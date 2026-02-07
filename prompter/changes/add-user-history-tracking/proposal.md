# Change: Add User History Tracking System

## Why

The Ticketing Laravel application lacks visibility into user actions – who did what, when, and to which resources. This creates significant gaps in security auditing, troubleshooting, and accountability. Administrators currently rely on direct database queries or server logs to investigate issues, which is time-consuming and unreliable.

## What Changes

- **New `ActivityLog` model and migration**: Create a database table to store user activities with timestamps, action types, resource references, and metadata (IP address, user agent, before/after states)
- **`ActivityLogger` service**: Centralized service for recording activities across the application
- **`LogsActivity` trait**: Automatic logging for model events (created, updated, deleted) on Ticket and User models
- **Authentication event logging**: Capture login, logout, and failed login attempts via Laravel event listeners
- **Admin History Dashboard** (`/admin/history`): Full-featured admin interface with filtering (user, action type, date range), search, pagination, and CSV export
- **User Self-History View** (`/my/history`): Limited view for staff/volunteers to see their own activity history
- **Activity Detail View**: Modal/page showing full context including metadata JSON
- **Navigation integration**: Add "User History" link to admin sidebar

## Impact

- **Affected specs**: None existing (new capability)
- **New specs**:
  - `activity-logging` – Core logging infrastructure
  - `admin-history-dashboard` – Admin UI for viewing all activities
  - `user-self-history` – Personal activity history for authenticated users
- **Affected code**:
  - `app/Models/` – New ActivityLog model, update Ticket and User models with LogsActivity trait
  - `app/Services/` – New ActivityLogger service
  - `app/Traits/` – New LogsActivity trait
  - `app/Http/Controllers/Admin/` – New HistoryController
  - `app/Http/Controllers/` – New MyHistoryController
  - `app/Listeners/` – New auth event listeners
  - `resources/views/admin/history/` – Admin history views
  - `resources/views/my/` – User self-history views
  - `routes/web.php` – New routes for history endpoints
  - `database/migrations/` – New activity_logs table migration
