## ADDED Requirements

### Requirement: Ticket Data Entry
The dashboard SHALL provide fields for Entering Seat Number, Ticket Type, Price, and User Details (Name/Email).

#### Scenario: Admin enters ticket data
- **WHEN** the admin submits the ticket creation form
- **THEN** the system SHALL validate that all required fields are present and the seat is not already assigned

### Requirement: Duplicate Seat Prevention
The system MUST prevent the assignment of the same seat number for the same event/type.

#### Scenario: Duplicate seat entry
- **WHEN** an admin enters a seat number that already exists for the event
- **THEN** the system SHALL display an error message and prevent the save operation
