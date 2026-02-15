# event-participants Specification

## Purpose
TBD - created by archiving change enhance-admin-payment-flow. Update Purpose after archive.
## Requirements
### Requirement: Event Participants Page
The system SHALL provide a dedicated admin page at `/admin/events/{event}/participants` listing all users who purchased tickets for the specified event.

#### Scenario: View participants list
- **WHEN** admin navigates to the event participants page
- **THEN** a table is displayed showing each participant's name, email, ticket type, ticket status, and purchase date
- **AND** results are paginated

#### Scenario: Filter participants by name or email
- **WHEN** admin enters a search keyword
- **THEN** only participants whose name or email contains the keyword are displayed

#### Scenario: Filter participants by ticket type
- **WHEN** admin selects a ticket type filter
- **THEN** only participants who hold tickets of the selected type are displayed

#### Scenario: Filter participants by ticket status
- **WHEN** admin selects a ticket status filter (e.g. "issued", "scanned", "pending")
- **THEN** only participants whose tickets match the selected status are displayed

#### Scenario: Navigate from event detail
- **WHEN** admin views an event's detail page
- **THEN** a "View Participants" link/button is visible that navigates to the participants page

#### Scenario: Empty event
- **WHEN** admin views participants for an event with no ticket purchases
- **THEN** a clear "No participants found" message is displayed

