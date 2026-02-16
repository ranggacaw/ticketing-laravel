# Tasks: Add User History Tracking System

## Definition of Done
- [x] All activity log database infrastructure is in place and migrated
- [x] Activity logging service captures CRUD operations on Tickets and Users
- [x] Authentication events (login, logout, failed login) are logged
- [x] Admin history dashboard displays all activities with filtering, search, and pagination
- [x] CSV export functionality works for filtered results
- [x] Users can view their own activity history at `/my/history`
- [x] Activity detail view shows full metadata including IP and user agent
- [x] Navigation links are added to admin sidebar
- [x] All new views follow the existing "glass" UI aesthetic

---

## 1. Database & Model Infrastructure

- [x] 1.1 Create migration for `activity_logs` table with indexes
  - Columns: id, user_id, action, resource_type, resource_id, description, metadata (JSON), ip_address, user_agent, created_at
  - Indexes: user_id, action, (resource_type, resource_id), created_at
  - Foreign key: user_id → users.id (SET NULL on delete)

- [x] 1.2 Create `ActivityLog` model (`app/Models/ActivityLog.php`)
  - Define fillable fields
  - Cast metadata to array
  - Define `user()` belongsTo relationship
  - Define `resource()` morphTo relationship

## 2. Activity Logging Service & Trait

- [x] 2.1 Create `ActivityLogger` service (`app/Services/ActivityLogger.php`)
  - Static `log()` method accepting action, optional resource, metadata, description
  - Capture auth user, IP address, user agent from request
  - Create ActivityLog record

- [x] 2.2 Create `LogsActivity` trait (`app/Traits/LogsActivity.php`)
  - Boot method registering created, updated, deleted observers
  - Call ActivityLogger for each event with appropriate metadata
  - For updates: capture before/after state

- [x] 2.3 Apply `LogsActivity` trait to `Ticket` model
- [x] 2.4 Apply `LogsActivity` trait to `User` model

## 3. Authentication Event Logging

- [x] 3.1 Create `LogSuccessfulLogin` listener for `Illuminate\Auth\Events\Login`
- [x] 3.2 Create `LogSuccessfulLogout` listener for `Illuminate\Auth\Events\Logout`
- [x] 3.3 Create `LogFailedLogin` listener for `Illuminate\Auth\Events\Failed`
- [x] 3.4 Register listeners in `EventServiceProvider`

## 4. Admin History Dashboard

- [x] 4.1 Create `HistoryController` (`app/Http/Controllers/Admin/HistoryController.php`)
  - `index()`: List all activities with filtering, search, and pagination
  - `show()`: Display single activity detail
  - `export()`: Generate CSV for filtered results

- [x] 4.2 Add admin history routes in `routes/web.php`
  - `GET /admin/history` → index
  - `GET /admin/history/{id}` → show
  - `GET /admin/history/export` → export (CSV download)

- [x] 4.3 Create `index.blade.php` view (`resources/views/admin/history/index.blade.php`)
  - Filter sidebar: user dropdown, action type dropdown, date range pickers, search box
  - Activity table: timestamp, user, action, resource, description, view button
  - Pagination at bottom
  - Export CSV button
  - Glass card aesthetic matching existing admin views

- [x] 4.4 Create `_filters.blade.php` partial (`resources/views/admin/history/_filters.blade.php`)
  - User select with search
  - Action type multi-select
  - Date from/to pickers
  - Clear filters button

- [x] 4.5 Create `show.blade.php` view (`resources/views/admin/history/show.blade.php`)
  - Full activity details: timestamp, user info, action, resource link
  - IP address and user agent
  - Metadata JSON display (formatted)
  - Back button

- [x] 4.6 Add "User History" link to admin navigation/sidebar

## 5. User Self-History View

- [x] 5.1 Create `MyHistoryController` (`app/Http/Controllers/MyHistoryController.php`)
  - `index()`: List current user's activities with filtering and pagination
  - Filter by action type and date range only (no user selection)

- [x] 5.2 Add user history route in `routes/web.php`
  - `GET /my/history` → index (accessible by all authenticated users)

- [x] 5.3 Create `index.blade.php` view (`resources/views/my/history/index.blade.php`)
  - Simplified filter: action type, date range
  - Activity table: timestamp, action, resource, description
  - Pagination
  - Read-only view (no export)
  - Glass card aesthetic

- [x] 5.4 Add "My Activity" link to user menu/profile dropdown

## 6. Scan Action Integration

- [x] 6.1 Update `TicketController::validateTicket()` to log SCAN action
  - Include ticket reference and validation result in metadata

## 7. Testing & Validation

- [x] 7.1 Manual testing: Create, update, delete tickets and verify logs appear
- [x] 7.2 Manual testing: Login, logout and verify auth events logged
- [x] 7.3 Manual testing: Filter and search functionality in admin dashboard
- [x] 7.4 Manual testing: CSV export with filters applied
- [x] 7.5 Manual testing: User self-history shows only own activities
- [x] 7.6 Verify empty state displays correctly when no activities match filters
