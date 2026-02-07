# Design: User History Tracking System

## Context

The ticketing application currently has no audit trail mechanism. This design covers:
- Automatic capture of significant user actions
- Storage of contextual metadata (IP, user agent, before/after states)
- Queryable history for admins and self-service for users

### Stakeholders
- **Admins**: Need full visibility and export capability
- **Staff**: Need to review their own actions
- **Volunteers**: Limited visibility to their scan activities
- **Security/Compliance**: Require audit trails for accountability

## Goals / Non-Goals

### Goals
- Automatically log all CRUD operations on Tickets and Users
- Capture authentication events (login, logout, failed attempts)
- Provide filterable, searchable admin interface
- Enable users to view their own activity history
- Support CSV export for compliance reporting
- Minimal performance overhead on normal operations

### Non-Goals
- Real-time notifications or alerting (Phase 2)
- Machine learning anomaly detection (Phase 3)
- Third-party SIEM integration (Phase 2)
- Undo/revert functionality

## Decisions

### 1. Use Native Laravel Model Events + Custom Service

**Decision**: Implement a `LogsActivity` trait using Laravel's model events (created, updated, deleted) combined with a centralized `ActivityLogger` service.

**Alternatives considered**:
- **spatie/laravel-activitylog package**: Well-maintained but adds external dependency. Decided against to keep the solution minimal and fully controllable.
- **Database triggers**: Would miss application context (user, IP, request data).
- **Middleware-only approach**: Too coarse-grained, wouldn't capture model-level changes.

**Rationale**: Native events provide fine-grained control, the trait keeps models clean, and a service enables consistent logging from controllers and event listeners.

### 2. JSON Metadata Column for Flexibility

**Decision**: Store additional context in a JSON `metadata` column rather than separate columns.

**Rationale**: 
- Flexible schema for different action types (before/after states for updates, full record for creates/deletes)
- Avoids schema migrations when adding new metadata fields
- MySQL/PostgreSQL have efficient JSON querying capabilities

### 3. Role-Based Access Control

**Decision**: 
- Admins: Access to `/admin/history` (all activities), export capability
- Staff: Access to `/admin/history` (read-only view, same as admin)
- Volunteers: Access to `/my/history` only (their own activities)

**Rationale**: Matches existing role hierarchy in the application (admin > staff > volunteer).

### 4. Synchronous Logging (MVP)

**Decision**: Log activities synchronously within the request lifecycle.

**Alternatives considered**:
- **Queue-based logging**: Better performance under load but adds complexity and potential data loss during failures.

**Rationale**: For MVP, simplicity outweighs performance. Queue-based approach can be added in Phase 2 if metrics show bottlenecks.

### 5. Soft Delete Strategy

**Decision**: Activity logs will NOT be soft-deleted. They are immutable audit records.

**Rationale**: Audit integrity requires immutability. Data retention/archival will be handled separately.

## Technical Design

### Database Schema

```sql
CREATE TABLE activity_logs (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         BIGINT UNSIGNED NULL,
    action          VARCHAR(50) NOT NULL,
    resource_type   VARCHAR(100) NULL,
    resource_id     BIGINT UNSIGNED NULL,
    description     TEXT NULL,
    metadata        JSON NULL,
    ip_address      VARCHAR(45) NULL,
    user_agent      TEXT NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_user_id (user_id),
    INDEX idx_action (action),
    INDEX idx_resource (resource_type, resource_id),
    INDEX idx_created_at (created_at),
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
```

### Action Types Enum

| Action | Trigger |
|--------|---------|
| `CREATE` | Model created event |
| `UPDATE` | Model updated event |
| `DELETE` | Model deleted event |
| `SCAN` | Ticket validation action |
| `LOGIN` | Successful authentication |
| `LOGOUT` | User logout |
| `LOGIN_FAILED` | Failed authentication attempt |
| `EXPORT` | Data export action |

### Component Structure

```
app/
├── Models/
│   └── ActivityLog.php          # Eloquent model
├── Services/
│   └── ActivityLogger.php       # Central logging service
├── Traits/
│   └── LogsActivity.php         # Model trait for auto-logging
├── Listeners/
│   ├── LogSuccessfulLogin.php   # Auth event listener
│   ├── LogSuccessfulLogout.php
│   └── LogFailedLogin.php
└── Http/Controllers/
    ├── Admin/
    │   └── HistoryController.php  # Admin history management
    └── MyHistoryController.php    # User self-history
```

### View Structure

```
resources/views/
├── admin/
│   └── history/
│       ├── index.blade.php      # Main listing with filters
│       ├── show.blade.php       # Detail view
│       └── _filters.blade.php   # Reusable filter partial
└── my/
    └── history/
        └── index.blade.php      # User's own history
```

## Risks / Trade-offs

| Risk | Mitigation |
|------|------------|
| **Storage growth**: Activity logs can grow rapidly | Add database indexes for efficient queries; plan for archival strategy in Phase 2 |
| **Performance impact**: Logging on every request | Synchronous logging is minimal overhead; monitor and migrate to queues if needed |
| **Privacy considerations**: Logs contain user behavior data | Implement role-based access; consider GDPR anonymization in future |
| **Circular logging**: Logging could trigger more logs | Exclude ActivityLog model from LogsActivity trait |

## Migration Plan

1. Create `activity_logs` table migration
2. Create ActivityLog model and ActivityLogger service
3. Add LogsActivity trait to Ticket and User models
4. Register auth event listeners
5. Create admin and user history controllers/views
6. Add navigation links
7. Deploy and begin capturing activities (no historical data migration)

## Open Questions

1. **Data retention period**: How long should activity logs be retained? (Suggested: 1-2 years)
2. **VIEW action tracking**: Should we track every time a ticket/user is viewed? (Performance impact vs. audit completeness)
3. **Failed login IP blocking**: Should repeated failed logins trigger IP blocking? (Separate security feature)
