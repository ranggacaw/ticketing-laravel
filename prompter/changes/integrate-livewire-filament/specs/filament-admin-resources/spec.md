## ADDED Requirements

### Requirement: Event Management Resource

The system SHALL provide a Filament Resource for Events with full CRUD capabilities, replacing the existing Blade-based event management interface.

#### Scenario: List events with pagination

- **WHEN** an admin navigates to the Events resource
- **THEN** a table displays all events with columns: Name, Venue, Organizer, Start Time, Status, Ticket Count
- **AND** results are paginated and sortable by any column

#### Scenario: Create event via form

- **WHEN** an admin clicks "New Event" and fills the form (name, description, start/end time, venue, organizer, status, location)
- **THEN** a new Event record is created with an auto-generated slug
- **AND** the admin is redirected to the events list with a success notification

#### Scenario: Edit event

- **WHEN** an admin edits an existing event
- **THEN** the form is pre-populated with current values
- **AND** saving updates the record and slug (if name changed)

#### Scenario: Manage ticket types inline

- **WHEN** an admin views an event detail
- **THEN** a Ticket Types relation manager is visible
- **AND** ticket types can be created, edited, and deleted without leaving the event page

### Requirement: Ticket Management Resource

The system SHALL provide a Filament Resource for Tickets with advanced filtering, search, and export capabilities.

#### Scenario: List tickets with filters

- **WHEN** an admin navigates to the Tickets resource
- **THEN** a table displays tickets with columns: UUID (truncated), Guest Name, Email, Seat, Type (badge), Status (badge), Price, Created At
- **AND** filters are available for: scan status, ticket type, date range, and keyword search

#### Scenario: Export tickets

- **WHEN** an admin clicks the Export action on the tickets table
- **THEN** a PDF or CSV export is generated containing the filtered ticket data

#### Scenario: View ticket detail

- **WHEN** an admin clicks on a ticket row
- **THEN** a detail page shows full ticket information including barcode, QR code, and scan history

### Requirement: Payment Management Resource

The system SHALL provide a Filament Resource for Payments with proof viewing, approval, and rejection capabilities.

#### Scenario: List payments with status filter

- **WHEN** an admin navigates to the Payments resource
- **THEN** a table displays payments with columns: User, Amount, Status (badge), Bank, Proof Image (thumbnail), Created At
- **AND** a status filter allows filtering by pending, confirmed, or cancelled

#### Scenario: Approve payment via action

- **WHEN** an admin clicks the Approve action on a pending payment
- **THEN** the payment status changes to `confirmed`, `confirmed_at` and `confirmed_by` are set
- **AND** all linked tickets are updated to `payment_status = 'confirmed'`
- **AND** a success notification is displayed

#### Scenario: Reject payment via action

- **WHEN** an admin clicks the Reject action on a pending payment
- **THEN** a modal prompts for a rejection reason
- **AND** the payment status changes to `cancelled` with the reason stored
- **AND** linked tickets are updated to `payment_status = 'cancelled'`

### Requirement: User Management Resource

The system SHALL provide a Filament Resource for Users with role management and filtering.

#### Scenario: List users with role filter

- **WHEN** an admin navigates to the Users resource
- **THEN** a table displays users with columns: Name, Email, Role (badge), Phone, Created At
- **AND** a role filter allows filtering by admin, staff, volunteer, and user roles

#### Scenario: Create user via form

- **WHEN** an admin creates a new user
- **THEN** the form requires: name, email, password (hashed), role select
- **AND** optional fields include: phone and avatar upload

### Requirement: Venue Management Resource

The system SHALL provide a Filament Resource for Venues with nested seat management via a RelationManager.

#### Scenario: List venues

- **WHEN** an admin navigates to the Venues resource
- **THEN** a table displays venues with columns: Name, City, Country, Capacity

#### Scenario: Manage seats inline

- **WHEN** an admin views a venue detail
- **THEN** a Seats relation manager is visible
- **AND** seats can be created, edited, and deleted without leaving the venue page

### Requirement: Organizer Management Resource

The system SHALL provide a Filament Resource for Organizers with full CRUD.

#### Scenario: List organizers

- **WHEN** an admin navigates to the Organizers resource
- **THEN** a table displays organizers with columns: Name, Email, Phone

#### Scenario: Create organizer

- **WHEN** an admin creates a new organizer via the form
- **THEN** the record is saved and the admin is notified of success

### Requirement: Event Participants View

The system SHALL provide a way to view all ticket holders (participants) for a specific event within the Filament panel.

#### Scenario: View event participants

- **WHEN** an admin navigates to an event's detail page and accesses the Participants tab or relation
- **THEN** a table displays all ticket holders: Name, Email, Ticket Type, Seat, Scan Status
- **AND** the list supports search by name or email and filter by ticket type and status

#### Scenario: Empty event participants

- **WHEN** an event has no purchased tickets
- **THEN** the participants view shows an empty state: "No participants yet"

### Requirement: Activity History View

The system SHALL provide a read-only Filament Resource or custom page for viewing activity logs with filtering and search.

#### Scenario: View activity history

- **WHEN** an admin navigates to the Activity History page
- **THEN** a table displays logs with columns: User, Action, Description, Timestamp
- **AND** results are sortable and searchable by user name or action type
