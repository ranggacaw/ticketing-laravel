# user-self-history Specification

## Purpose
TBD - created by archiving change add-user-history-tracking. Update Purpose after archive.
## Requirements
### Requirement: User Self-History Page

The system SHALL provide a personal activity history page at `/my/history` accessible by all authenticated users (admin, staff, volunteer).

The page SHALL display only the authenticated user's own activities with:
- Timestamp (formatted for readability)
- Action type with visual styling
- Resource type and identifier (if applicable)
- Brief description

#### Scenario: Staff views their own history
- **GIVEN** a user with `staff` role is authenticated
- **WHEN** they navigate to `/my/history`
- **THEN** they see a list of only their own activities
- **AND** they cannot see activities from other users

#### Scenario: Volunteer views their scan history
- **GIVEN** a user with `volunteer` role is authenticated
- **WHEN** they navigate to `/my/history`
- **THEN** they see their scan/validation activities
- **AND** timestamps and ticket references are displayed

#### Scenario: Admin views their own history
- **GIVEN** a user with `admin` role is authenticated
- **WHEN** they navigate to `/my/history`
- **THEN** they see only activities they personally performed
- **AND** this is separate from the full admin history view

### Requirement: Self-History Filtering

The user self-history page SHALL provide limited filtering:
- Filter by action type (dropdown)
- Filter by date range (from date, to date)

The page SHALL NOT provide:
- User selection filter (always shows current user's activities)
- Free-text search (simplified view)
- CSV export (admin-only feature)

#### Scenario: Filter own activities by action type
- **GIVEN** a user is viewing their own history
- **WHEN** they select "SCAN" action type filter
- **THEN** only their SCAN activities are displayed

#### Scenario: Filter own activities by date range
- **GIVEN** a user is viewing their own history
- **WHEN** they set a date range filter
- **THEN** only their activities within that range are displayed

### Requirement: Self-History Pagination

The user self-history page SHALL paginate results with:
- Default of 25 items per page
- Page navigation controls

#### Scenario: Navigate own history pages
- **GIVEN** a user has more than 25 activities
- **WHEN** they are on page 1
- **THEN** they see the first 25 activities
- **AND** they can navigate to subsequent pages

### Requirement: Self-History Navigation

The user navigation (profile dropdown or sidebar) SHALL include a "My Activity" link for all authenticated users.

#### Scenario: My Activity link in user menu
- **GIVEN** any authenticated user is logged in
- **WHEN** they view their profile dropdown or user menu
- **THEN** they see a "My Activity" navigation link
- **AND** clicking it navigates to `/my/history`

### Requirement: Self-History Empty State

The self-history page SHALL display a helpful message when the user has no activities recorded.

#### Scenario: New user with no activities
- **GIVEN** a newly registered user has no activities
- **WHEN** they navigate to `/my/history`
- **THEN** a friendly message is displayed: "No activity recorded yet"
- **AND** the page does not show an error

### Requirement: Self-History Read-Only View

The user self-history SHALL be read-only:
- No edit or delete actions on activity records
- No export functionality
- View-only access to own records

#### Scenario: User cannot modify activity records
- **GIVEN** a user is viewing their own history
- **THEN** no edit or delete buttons are present
- **AND** activity records are immutable from the user's perspective

