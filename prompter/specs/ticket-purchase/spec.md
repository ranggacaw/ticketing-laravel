# ticket-purchase Specification

## Purpose
TBD - created by archiving change implement-user-event-discovery. Update Purpose after archive.
## Requirements
### Requirement: Ticket Type Selection

Users MUST be able to select a quantity of tickets for available ticket types.

#### Scenario: Selecting tickets

- **Given** an event with "VIP" ($100) and "General" ($50) tickets
- **When** the user views the event page
- **Then** they can select a quantity (0, 1, 2...) for each type
- **And** "Sold Out" types are visually disabled.

### Requirement: Inventory Validation

The system MUST prevent selling more tickets than available (`quantity_total`).

#### Scenario: Enforcing limits

- **Given** "VIP" tickets have 5 total and 4 sold
- **When** a user tries to buy 2 "VIP" tickets
- **Then** the system prevents the purchase
- **And** shows an error message "Only 1 ticket remaining".

### Requirement: Seat Selection (Seated Events)

For events with assigned seating, users MUST select a specific seat.

#### Scenario: Selecting a seat

- **Given** a ticket type is linked to a seating section
- **When** the user selects that ticket type
- **Then** they are presented with a list of available `Seats` for that section
- **And** they cannot select a seat that is already assigned to a valid `Ticket` for this event.

### Requirement: Purchase Transaction

The system MUST process the purchase securely.

#### Scenario: Successful purchase

- **Given** the user has selected valid tickets/seats
- **When** they confirm the purchase (mock payment)
- **Then** the system creates `Ticket` records for each selection
- **And** the `TicketType` `quantity_sold` is incremented
- **And** the tickets are linked to the current `User`
- **And** the user is redirected to a success/confirmation page.

### Requirement: Authentication Enforcement

Only logged-in users MUST be able to purchase tickets.

#### Scenario: Guest tries to buy

- **Given** a guest user
- **When** they attempt to click "Buy" or "Checkout"
- **Then** they are redirected to the Login/Register page
- **And** redirected back to the event after login.

