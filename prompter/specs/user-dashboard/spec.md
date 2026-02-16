# user-dashboard Specification

## Purpose
TBD - created by archiving change implement-user-ticket-portal. Update Purpose after archive.
## Requirements
### Requirement: Dashboard Overview

The user dashboard SHALL display summary cards for tickets and engagement.

#### Scenario: View dashboard summary cards

- **WHEN** a logged-in user accesses `/user/dashboard`
- **THEN** they see summary cards for:
    - **Upcoming Events**: Count of future tickets.
    - **Past Events**: Count of attended events.
    - **Loyalty Points**: Current points balance.
- **AND** clicking each card navigates to the respective section.

#### Scenario: Dashboard with no data

- **WHEN** a new user with no tickets accesses the dashboard
- **THEN** summary cards show "0"
- **AND** a "Browse Events" or similar CTA is displayed.

### Requirement: Loyalty Points Widget

The dashboard SHALL display the user's loyalty points balance.

#### Scenario: View Loyalty Points

- **WHEN** a user views the dashboard
- **THEN** their current loyalty points balance is displayed prominently.
- **AND** (Optional) A link to "Learn More" or "Redeem" if applicable in future MVP.

### Requirement: Recent Tickets Widget

The dashboard SHALL display the user's most recent/upcoming tickets.

#### Scenario: View upcoming tickets

- **WHEN** a user with upcoming tickets views the dashboard
- **THEN** up to 3 upcoming tickets are shown
- **AND** each ticket card shows: Event Name, Date, Seat, Status.
- **AND** clicking a ticket goes to Ticket Details.

