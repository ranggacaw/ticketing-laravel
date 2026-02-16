# manage-prices Specification

## Purpose
TBD - created by archiving change manage-event-ticket-prices. Update Purpose after archive.
## Requirements
### Requirement: Manage Ticket Prices

The system SHALL allow event organizers to define and manage multiple ticket pricing tiers for events to support different categories (e.g., VIP, General Admission).

#### Scenario: Create a new ticket price tier

- **GIVEN** I am an authenticated event organizer
- **AND** I am on the management page for my event "Summer Festival"
- **WHEN** I choose to add a new ticket type
- **AND** I enter the name "VIP Pass", price "150.00", and quantity "100"
- **AND** I submit the form
- **THEN** the new ticket type "VIP Pass" should be saved
- **AND** I should see "VIP Pass" listed in the event's ticket types

#### Scenario: Validate invalid ticket price

- **GIVEN** I am an authenticated event organizer
- **AND** I am adding a new ticket type
- **WHEN** I enter a price of "-50.00"
- **AND** I submit the form
- **THEN** the system should reject the submission
- **AND** I should see a validation error stating the price must be positive

#### Scenario: Update an existing ticket price

- **GIVEN** I have an existing ticket type "Early Bird" with price "50.00"
- **WHEN** I edit the "Early Bird" ticket type
- **AND** I change the price to "60.00"
- **AND** I save the changes
- **THEN** the ticket type price should be updated to "60.00"

#### Scenario: Delete a ticket price

- **GIVEN** I have a ticket type "Obsolete Pass" that has 0 sales
- **WHEN** I choose to delete "Obsolete Pass"
- **AND** I confirm the deletion
- **THEN** the ticket type "Obsolete Pass" should be removed from the event

