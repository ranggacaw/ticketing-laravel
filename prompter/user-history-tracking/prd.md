# Product Requirements Document (PRD)
## User History Tracking System

---

## Overview

| Attribute | Details |
|-----------|---------|
| **Feature Name** | User History Tracking System |
| **Document Version** | 1.0 |
| **Created Date** | February 8, 2026 |
| **Target Release** | Q1 2026 |
| **Product Owner** | [PO Name] |
| **Tech Lead** | [Tech Lead Name] |
| **Designer** | [Designer Name] |
| **QA Lead** | [QA Lead Name] |

---

## Quick Links

| Resource | Link |
|----------|------|
| Design Specs | [Figma Link] |
| Technical Specs | [Technical Documentation] |
| API Documentation | [API Docs] |
| JIRA Epic | [JIRA-XXXX] |
| Project Board | [Project Board Link] |

---

## Background

### Context
The Ticketing Laravel application currently manages tickets, users, and ticket validation workflows. As the system grows, there is a critical need to track and audit user activities within the platform. Currently, there is no mechanism to monitor:
- What actions users perform
- When these actions occur
- Which resources are affected by these actions

This creates gaps in accountability, security auditing, and operational visibility. Implementing a comprehensive User History Tracking System will address these needs.

### Current State
| Metric | Current Value |
|--------|---------------|
| User Activity Tracking | ❌ None |
| Audit Trail | ❌ None |
| Action Logging | ❌ None |
| Admin Visibility | Limited to direct DB queries |

### Problem Statement
**Problem:** Administrators and staff lack visibility into user actions within the ticketing system. There is no way to:
1. Track who performed specific actions (ticket creation, updates, deletions, scans)
2. Audit changes for security and compliance purposes
3. Debug issues by reviewing historical user actions
4. Monitor suspicious or unusual activity patterns

**Impact:**
- Security vulnerabilities due to lack of audit trails
- Difficulty in troubleshooting user-reported issues
- No accountability for destructive actions
- Compliance gaps for regulated environments
- Limited operational insights

### Current Workarounds
| Workaround | Limitations |
|------------|-------------|
| Manual database queries | Time-consuming, requires technical expertise |
| Server logs | Unstructured, lacks context, difficult to search |
| User interviews | Unreliable, time-consuming, not scalable |

---

## Objectives

### Business Objectives
1. **Enhance Security & Compliance** – Implement a complete audit trail for all user actions to meet security compliance requirements
2. **Improve Operational Visibility** – Enable administrators to monitor and analyze user behavior patterns
3. **Enable Accountability** – Create clear records of who did what and when
4. **Support Troubleshooting** – Provide historical context for debugging user-reported issues
5. **Reduce Support Time** – Decrease investigation time for incidents by 60%

### User Objectives
| User Type | Objective |
|-----------|-----------|
| **Admin** | View, filter, and analyze all user activities across the system |
| **Staff** | Review their own action history and access filtered activity logs |
| **Volunteer** | View their own scan/validation history |
| **System** | Automatically capture and persist all significant user actions |

---

## Success Metrics

| Metric | Current Baseline | Target | Measurement Method | Timeline |
|--------|-----------------|--------|-------------------|----------|
| **Primary: Action Capture Rate** | 0% | 100% of defined actions | Audit log completeness check | Launch Week |
| **Primary: Admin Investigation Time** | N/A | < 5 minutes per incident | Time tracking on support tickets | Month 1 |
| **Secondary: Search Response Time** | N/A | < 2 seconds for filtered queries | Performance monitoring | Launch Week |
| **Secondary: Storage Efficiency** | N/A | < 1KB per action record | Database size monitoring | Month 1 |
| **Secondary: UI Load Time** | N/A | < 1.5 seconds for history page | Lighthouse metrics | Launch Week |

---

## Scope

### MVP 1 Goals
Create a comprehensive user history tracking system that:
1. Automatically captures user actions across the application
2. Stores action data with timestamps, metadata, and context
3. Provides a filterable, searchable admin interface
4. Allows users to view their own action history
5. Supports data export for compliance purposes

### In-Scope Features

| ID | Feature | Priority | Description |
|----|---------|----------|-------------|
| ✅ | **Activity Logging Model** | P0 | Database model to store user activities |
| ✅ | **Automatic Event Capture** | P0 | Capture actions on Tickets, Users, and Authentication |
| ✅ | **Timestamp Recording** | P0 | Record precise timestamps for all actions |
| ✅ | **Action Categorization** | P0 | Categorize actions (CREATE, UPDATE, DELETE, VIEW, SCAN, LOGIN, LOGOUT) |
| ✅ | **Metadata Storage** | P0 | Store before/after states, IP addresses, user agents |
| ✅ | **Admin History Dashboard** | P0 | Full-featured admin interface to view all activities |
| ✅ | **Filtering & Search** | P0 | Filter by user, action type, date range, resource type |
| ✅ | **Pagination** | P0 | Paginated results for large datasets |
| ✅ | **User Self-History View** | P1 | Allow users to view their own action history |
| ✅ | **Date Range Filtering** | P1 | Filter activities by custom date ranges |
| ✅ | **Export to CSV** | P1 | Export filtered history to CSV for reporting |
| ✅ | **Real-time Updates** | P2 | Live updates on admin dashboard (optional) |

### Out-of-Scope Features

| Feature | Reason | Future Phase |
|---------|--------|--------------|
| ❌ Advanced Analytics Dashboard | Requires significant additional development | Phase 2 |
| ❌ Machine Learning Anomaly Detection | Complex implementation, separate initiative | Phase 3 |
| ❌ Third-party SIEM Integration | Requires external system coordination | Phase 2 |
| ❌ Video Recording of Sessions | Privacy concerns, storage limitations | Not Planned |
| ❌ Undo/Revert Actions | Requires complex state management | Phase 2 |

### Future Iterations Roadmap

| Phase | Features | Timeline |
|-------|----------|----------|
| **Phase 2** | Advanced Analytics, SIEM Integration, Bulk Export | Q2 2026 |
| **Phase 3** | Anomaly Detection, Alerting System | Q3 2026 |
| **Phase 4** | Compliance Reporting Templates | Q4 2026 |

---

## User Flow

### Main User Journey: Admin Viewing History

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                         USER HISTORY TRACKING FLOW                          │
└─────────────────────────────────────────────────────────────────────────────┘

[Admin Login] 
     │
     ▼
[Admin Dashboard]
     │
     ▼
[Click "User History" in Navigation]
     │
     ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│                        USER HISTORY INDEX PAGE                              │
│  ┌─────────────────────────────────────────────────────────────────────┐   │
│  │  FILTERS:                                                            │   │
│  │  [User Dropdown ▼] [Action Type ▼] [Date From] [Date To] [Search 🔍]│   │
│  └─────────────────────────────────────────────────────────────────────┘   │
│                                                                             │
│  ┌─────────────────────────────────────────────────────────────────────┐   │
│  │  ACTIVITY LOG TABLE:                                                 │   │
│  │  ─────────────────────────────────────────────────────────────────── │   │
│  │  │ Timestamp       │ User    │ Action  │ Resource │ Details    │👁️│  │   │
│  │  │ 2026-02-08 10:30│ John    │ CREATE  │ Ticket   │ #TKT-001   │👁️│  │   │
│  │  │ 2026-02-08 10:25│ Admin   │ UPDATE  │ User     │ Role change│👁️│  │   │
│  │  │ 2026-02-08 10:20│ Staff   │ SCAN    │ Ticket   │ #TKT-002   │👁️│  │   │
│  │  ─────────────────────────────────────────────────────────────────── │   │
│  │  [◀ Prev] Page 1 of 50 [Next ▶]                    [Export CSV 📥]   │   │
│  └─────────────────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────────────────┘
     │
     ▼ (Click View Details 👁️)
┌─────────────────────────────────────────────────────────────────────────────┐
│                        ACTIVITY DETAIL MODAL/PAGE                           │
│  ┌─────────────────────────────────────────────────────────────────────┐   │
│  │  Activity Details                                           [✕ Close]│   │
│  │  ─────────────────────────────────────────────────────────────────── │   │
│  │  Timestamp:   2026-02-08 10:30:45 UTC                                │   │
│  │  User:        John Doe (john@example.com)                            │   │
│  │  Action:      CREATE                                                 │   │
│  │  Resource:    Ticket #TKT-001                                        │   │
│  │  IP Address:  192.168.1.100                                          │   │
│  │  User Agent:  Chrome/120.0 on Windows                                │   │
│  │  ─────────────────────────────────────────────────────────────────── │   │
│  │  METADATA:                                                           │   │
│  │  {                                                                   │   │
│  │    "seat_number": "A-15",                                            │   │
│  │    "price": 50000,                                                   │   │
│  │    "type": "VIP"                                                     │   │
│  │  }                                                                   │   │
│  └─────────────────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────────────────┘
```

### Alternative Flows

| Flow | Description |
|------|-------------|
| **Empty State** | When no activities match filters, show helpful empty state with suggestions |
| **Export Flow** | User clicks Export → System generates CSV → Download initiates |
| **User Self-View** | Regular users access limited view showing only their own activities |

### Error Handling & Edge Cases

| Scenario | System Response |
|----------|-----------------|
| Large date range selected | Show warning, paginate results, optimize query |
| No matching results | Display friendly "No activities found" message with filter suggestions |
| Export with 10k+ records | Process in background, notify when ready |
| Invalid date range | Display validation error, prevent form submission |
| Session timeout during view | Preserve filter state, redirect to login, return after auth |

---

## User Stories

| ID | User Story | Acceptance Criteria | Design | Notes | Platform | JIRA Ticket |
|----|------------|---------------------|--------|-------|----------|-------------|
| US-01 | As an **admin**, I want to view all user activities so that I can monitor system usage | **Given** I'm logged in as admin<br>**When** I navigate to "User History"<br>**Then** I see a paginated list of all activities<br>**And** each activity shows timestamp, user, action, and resource | [Figma] | Default sort: newest first | Web | [JIRA-XXX] |
| US-02 | As an **admin**, I want to filter activities by user so that I can investigate specific user behavior | **Given** I'm on the User History page<br>**When** I select a user from the dropdown<br>**Then** the list updates to show only that user's activities<br>**And** the filter persists across pagination | [Figma] | Include search-as-you-type | Web | [JIRA-XXX] |
| US-03 | As an **admin**, I want to filter activities by action type so that I can focus on specific operations | **Given** I'm on the User History page<br>**When** I select an action type (CREATE, UPDATE, DELETE, etc.)<br>**Then** only activities of that type are displayed | [Figma] | Multi-select enabled | Web | [JIRA-XXX] |
| US-04 | As an **admin**, I want to filter by date range so that I can review activities within specific periods | **Given** I'm on the User History page<br>**When** I set a "From" and "To" date<br>**Then** only activities within that range are shown<br>**And** date pickers prevent invalid ranges | [Figma] | Default: last 7 days | Web | [JIRA-XXX] |
| US-05 | As an **admin**, I want to view activity details so that I can see full context including metadata | **Given** I'm viewing the activity list<br>**When** I click the view icon on an activity<br>**Then** a detail view shows timestamp, user, action, resource, IP, user agent, and metadata JSON | [Figma] | Modal or dedicated page | Web | [JIRA-XXX] |
| US-06 | As an **admin**, I want to export activities to CSV so that I can create compliance reports | **Given** I have filtered activities<br>**When** I click "Export CSV"<br>**Then** a CSV file downloads with all filtered activities<br>**And** the file includes all displayed columns | [Figma] | Include all metadata | Web | [JIRA-XXX] |
| US-07 | As a **staff member**, I want to view my own activity history so that I can review my actions | **Given** I'm logged in as staff<br>**When** I navigate to "My Activity"<br>**Then** I see only my own activities<br>**And** I cannot view other users' activities | [Figma] | Subset of admin view | Web | [JIRA-XXX] |
| US-08 | As a **volunteer**, I want to see my scan history so that I can track my validations | **Given** I'm logged in as volunteer<br>**When** I access my profile or activity section<br>**Then** I see my scan/validation activities<br>**And** I see timestamps and ticket references | [Figma] | Read-only view | Web | [JIRA-XXX] |
| US-09 | As the **system**, I want to automatically log all ticket operations so that nothing is missed | **Given** any user performs a ticket action (create, update, delete, scan)<br>**When** the action completes successfully<br>**Then** an activity record is created with all relevant metadata | N/A | Use Model Events | Backend | [JIRA-XXX] |
| US-10 | As the **system**, I want to log authentication events so that security is auditable | **Given** a user logs in or logs out<br>**When** the auth action completes<br>**Then** an activity record is created with IP and user agent | N/A | Include failed attempts | Backend | [JIRA-XXX] |
| US-11 | As an **admin**, I want to search activities by keyword so that I can find specific records quickly | **Given** I'm on the User History page<br>**When** I type in the search box<br>**Then** activities matching the keyword in description or metadata are shown | [Figma] | Debounced search | Web | [JIRA-XXX] |
| US-12 | As the **system**, I want to log user management actions so that role changes are auditable | **Given** an admin creates, updates, or deletes a user<br>**When** the action completes<br>**Then** an activity record captures the before/after state | N/A | Include role changes | Backend | [JIRA-XXX] |

---

## Data Model

### Activity Log Table Schema

```sql
CREATE TABLE activity_logs (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         BIGINT UNSIGNED NULL,                    -- NULL for system/guest actions
    action          VARCHAR(50) NOT NULL,                    -- CREATE, UPDATE, DELETE, VIEW, SCAN, LOGIN, LOGOUT
    resource_type   VARCHAR(100) NULL,                       -- Model class name (Ticket, User, etc.)
    resource_id     BIGINT UNSIGNED NULL,                    -- ID of affected resource
    description     TEXT NULL,                               -- Human-readable description
    metadata        JSON NULL,                               -- Additional context (before/after state)
    ip_address      VARCHAR(45) NULL,                        -- IPv4 or IPv6
    user_agent      TEXT NULL,                               -- Browser/client info
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_user_id (user_id),
    INDEX idx_action (action),
    INDEX idx_resource (resource_type, resource_id),
    INDEX idx_created_at (created_at),
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
```

### Action Types Enum

| Action | Description |
|--------|-------------|
| `CREATE` | Resource was created |
| `UPDATE` | Resource was modified |
| `DELETE` | Resource was removed |
| `VIEW` | Resource was accessed/viewed |
| `SCAN` | Ticket was scanned for validation |
| `VALIDATE` | Ticket validation completed |
| `LOGIN` | User authenticated successfully |
| `LOGOUT` | User session ended |
| `LOGIN_FAILED` | Failed authentication attempt |
| `EXPORT` | Data was exported |

---

## Technical Implementation

### Backend Components

#### 1. Migration File
```php
// database/migrations/xxxx_xx_xx_create_activity_logs_table.php
Schema::create('activity_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
    $table->string('action', 50);
    $table->string('resource_type', 100)->nullable();
    $table->unsignedBigInteger('resource_id')->nullable();
    $table->text('description')->nullable();
    $table->json('metadata')->nullable();
    $table->string('ip_address', 45)->nullable();
    $table->text('user_agent')->nullable();
    $table->timestamps();
    
    $table->index(['resource_type', 'resource_id']);
    $table->index('action');
    $table->index('created_at');
});
```

#### 2. Model: ActivityLog
```php
// app/Models/ActivityLog.php
class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'action', 'resource_type', 'resource_id',
        'description', 'metadata', 'ip_address', 'user_agent'
    ];
    
    protected $casts = [
        'metadata' => 'array'
    ];
    
    public function user() { return $this->belongsTo(User::class); }
    
    public function resource() {
        return $this->morphTo('resource', 'resource_type', 'resource_id');
    }
}
```

#### 3. Service: ActivityLogger
```php
// app/Services/ActivityLogger.php
class ActivityLogger
{
    public static function log(string $action, ?Model $resource = null, array $metadata = [], ?string $description = null): ActivityLog
    {
        return ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'resource_type' => $resource ? get_class($resource) : null,
            'resource_id' => $resource?->id,
            'description' => $description,
            'metadata' => $metadata,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
```

#### 4. Trait: LogsActivity
```php
// app/Traits/LogsActivity.php
trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        static::created(fn($model) => ActivityLogger::log('CREATE', $model, $model->toArray()));
        static::updated(fn($model) => ActivityLogger::log('UPDATE', $model, [
            'before' => $model->getOriginal(),
            'after' => $model->getChanges()
        ]));
        static::deleted(fn($model) => ActivityLogger::log('DELETE', $model, $model->toArray()));
    }
}
```

### Frontend Components

| Component | Location | Description |
|-----------|----------|-------------|
| History Index | `resources/views/admin/history/index.blade.php` | Main listing page with filters |
| History Show | `resources/views/admin/history/show.blade.php` | Detail view for single activity |
| Filter Component | `resources/views/admin/history/_filters.blade.php` | Reusable filter partial |
| Export Button | Integrated in index | CSV download functionality |

---

## API Endpoints

| Method | Endpoint | Description | Access |
|--------|----------|-------------|--------|
| GET | `/admin/history` | List all activities (paginated, filterable) | Admin, Staff |
| GET | `/admin/history/{id}` | View single activity details | Admin, Staff |
| GET | `/admin/history/export` | Export filtered activities to CSV | Admin |
| GET | `/my/history` | View own activity history | All authenticated |

### Query Parameters for Listing

| Parameter | Type | Description |
|-----------|------|-------------|
| `user_id` | integer | Filter by specific user |
| `action` | string | Filter by action type |
| `resource_type` | string | Filter by resource type |
| `from_date` | date | Start of date range |
| `to_date` | date | End of date range |
| `search` | string | Keyword search in description/metadata |
| `per_page` | integer | Results per page (default: 25, max: 100) |

---

## Analytics & Tracking

| Event Name | Trigger | Parameters | Description |
|------------|---------|------------|-------------|
| `history_page_viewed` | Page Load | `{ filters_applied: boolean, user_role: string }` | Admin views history page |
| `history_filtered` | Filter Applied | `{ filter_type: string, value: string }` | User applies a filter |
| `history_detail_viewed` | Click Detail | `{ activity_id: number, action_type: string }` | User views activity detail |
| `history_exported` | Export Click | `{ record_count: number, filters: object }` | User exports to CSV |
| `history_searched` | Search Submit | `{ query: string, results_count: number }` | User performs keyword search |

### Sample Event JSON

```json
{
  "event": "history_filtered",
  "timestamp": "2026-02-08T10:30:45Z",
  "user_id": 1,
  "properties": {
    "filter_type": "action",
    "value": "CREATE",
    "page": "/admin/history",
    "total_results": 156
  }
}
```

---

## Open Questions

| ID | Question | Owner | Status | Resolution |
|----|----------|-------|--------|------------|
| OQ-01 | Should we track VIEW actions for all resources or only specific ones? | PO | Open | Consider performance impact |
| OQ-02 | What is the data retention policy for activity logs? | Legal/PO | Open | 1 year, 2 years, indefinite? |
| OQ-03 | Should failed login attempts be tracked with IP blocking? | Security | Open | Separate security feature? |
| OQ-04 | Do we need real-time notifications for specific actions? | PO | Open | Phase 2 consideration |
| OQ-05 | Should activity logs be soft-deleted or hard-deleted? | Tech Lead | Open | Recommend hard delete with archiving |

---

## Notes & Considerations

### Technical Considerations
- **Performance**: Activity logs can grow rapidly. Consider:
  - Partitioning table by date
  - Archiving old records to cold storage
  - Caching frequently accessed queries
  - Using database indexes strategically
- **Storage**: JSON metadata can consume significant space. Monitor and optimize.
- **Queue Processing**: Consider queuing log writes for high-traffic scenarios.

### Business Considerations
- **Privacy**: Activity logs contain user behavior data. Ensure compliance with privacy policies.
- **GDPR**: Users may request data deletion. Activity logs should support anonymization.
- **Access Control**: Strictly limit who can view activity logs.

### Migration Notes
- Initial deployment will have empty history. Consider this for UI empty states.
- No historical data migration planned—logs start from feature launch.

---

## Appendix

### References
| Document | Link |
|----------|------|
| Laravel Model Events | [Laravel Docs](https://laravel.com/docs/eloquent#events) |
| Laravel Activity Log Package | [spatie/laravel-activitylog](https://github.com/spatie/laravel-activitylog) |
| Audit Logging Best Practices | [OWASP](https://owasp.org/www-project-proactive-controls/) |

### Glossary
| Term | Definition |
|------|------------|
| **Activity Log** | A record of a single user action in the system |
| **Resource** | An entity affected by an action (Ticket, User, etc.) |
| **Metadata** | Additional JSON context stored with an activity (before/after states, etc.) |
| **Audit Trail** | The complete chronological history of activities |
| **Action Type** | Categorization of what was done (CREATE, UPDATE, DELETE, etc.) |

---

*Document generated on February 8, 2026*
