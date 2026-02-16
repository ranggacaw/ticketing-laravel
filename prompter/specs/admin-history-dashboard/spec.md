# admin-history-dashboard Specification

## Purpose
TBD - created by archiving change add-user-history-tracking. Update Purpose after archive.
## Requirements
### Requirement: Admin History Index Page

The system SHALL provide an admin history dashboard at `/admin/history` accessible by users with `admin` or `staff` roles that displays a paginated list of all user activities.

Each activity record SHALL display:
- Timestamp (formatted for readability)
- User name and email (or "System" for null user_id)
- Action type with visual styling
- Resource type and identifier (if applicable)
- Brief description
- View details button

#### Scenario: Admin views activity list
- **GIVEN** a user with `admin` role is authenticated
- **WHEN** they navigate to `/admin/history`
- **THEN** they see a paginated list of all activities
- **AND** the most recent activities appear first
- **AND** each row shows timestamp, user, action, resource, and description

#### Scenario: Staff views activity list
- **GIVEN** a user with `staff` role is authenticated
- **WHEN** they navigate to `/admin/history`
- **THEN** they see the same activity list as admins
- **AND** they can filter and search activities

#### Scenario: Volunteer cannot access admin history
- **GIVEN** a user with `volunteer` role is authenticated
- **WHEN** they attempt to access `/admin/history`
- **THEN** they receive a 403 Forbidden response

### Requirement: Activity Filtering

The admin history dashboard SHALL provide filtering capabilities:
- Filter by user (dropdown with search)
- Filter by action type (multi-select: CREATE, UPDATE, DELETE, SCAN, LOGIN, LOGOUT, LOGIN_FAILED, EXPORT)
- Filter by date range (from date, to date)
- Free-text search across description and metadata

Filters SHALL:
- Apply immediately on change
- Persist across pagination
- Be clearable with a "Clear Filters" button
- Show the number of matching results

#### Scenario: Filter by specific user
- **GIVEN** an admin is on the history page
- **WHEN** they select a user from the user filter dropdown
- **THEN** only activities performed by that user are displayed
- **AND** the filter persists when navigating between pages

#### Scenario: Filter by action type
- **GIVEN** an admin is on the history page
- **WHEN** they select "CREATE" and "UPDATE" action types
- **THEN** only CREATE and UPDATE activities are displayed

#### Scenario: Filter by date range
- **GIVEN** an admin is on the history page
- **WHEN** they set a "From" date of 2026-02-01 and "To" date of 2026-02-07
- **THEN** only activities within that date range are displayed
- **AND** the date pickers prevent selecting invalid ranges (from > to)

#### Scenario: Free-text search
- **GIVEN** an admin is on the history page
- **WHEN** they type "TKT-001" in the search box
- **THEN** activities matching the keyword in description or metadata are displayed
- **AND** search is debounced to avoid excessive queries

#### Scenario: Clear all filters
- **GIVEN** an admin has applied multiple filters
- **WHEN** they click "Clear Filters"
- **THEN** all filters are reset to default values
- **AND** the full activity list is displayed

### Requirement: Activity Detail View

The system SHALL provide a detail view for each activity accessible at `/admin/history/{id}` or via a modal.

The detail view SHALL display:
- Full timestamp
- User information (name, email)
- Action type
- Resource type and ID with link to resource (if applicable)
- IP address
- User agent
- Full metadata as formatted JSON

#### Scenario: View activity details
- **GIVEN** an admin is viewing the activity list
- **WHEN** they click the view button on an activity
- **THEN** a detail view opens showing all activity information
- **AND** the metadata JSON is formatted for readability

#### Scenario: Resource link navigation
- **GIVEN** an admin is viewing an activity detail for a Ticket action
- **WHEN** the resource (Ticket) still exists
- **THEN** a link to the ticket detail page is displayed
- **AND** clicking the link navigates to the ticket

### Requirement: Activity Pagination

The admin history dashboard SHALL paginate results with:
- Default of 25 items per page
- Maximum of 100 items per page
- Page navigation controls

#### Scenario: Navigate between pages
- **GIVEN** there are 100 activities in the system
- **WHEN** the admin is on page 1
- **THEN** they see the first 25 activities
- **AND** they can navigate to subsequent pages

### Requirement: CSV Export

The system SHALL allow admins to export filtered activity logs to CSV format.

The export SHALL:
- Include all columns: timestamp, user, action, resource_type, resource_id, description, ip_address, user_agent, metadata
- Apply current filters to the export
- Download immediately for small datasets
- Limit export to reasonable size (max 10,000 records)

#### Scenario: Export filtered activities to CSV
- **GIVEN** an admin has filtered activities by action type "CREATE"
- **WHEN** they click "Export CSV"
- **THEN** a CSV file downloads containing only CREATE activities
- **AND** the file includes all activity columns
- **AND** the filename includes the export date

#### Scenario: Export with large dataset warning
- **GIVEN** there are more than 10,000 matching activities
- **WHEN** the admin clicks "Export CSV"
- **THEN** a warning is displayed about the large dataset
- **AND** the export is limited to the first 10,000 records

### Requirement: Admin Navigation Integration

The admin sidebar/navigation SHALL include a "User History" link for admin and staff users.

#### Scenario: History link in navigation
- **GIVEN** an admin or staff user is logged in
- **WHEN** they view the admin sidebar
- **THEN** they see a "User History" navigation link
- **AND** clicking it navigates to `/admin/history`

### Requirement: Empty State Handling

The history dashboard SHALL display a helpful empty state when:
- No activities exist in the system
- No activities match the current filters

#### Scenario: No activities match filters
- **GIVEN** an admin has applied filters
- **WHEN** no activities match the criteria
- **THEN** a friendly empty state message is displayed
- **AND** suggestions to modify filters are shown

