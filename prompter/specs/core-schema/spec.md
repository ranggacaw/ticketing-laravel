# core-schema Specification

## Purpose
TBD - created by archiving change implement-master-data-schema. Update Purpose after archive.
## Requirements
### Requirement: Events Data Structure

The system MUST store event details with support for venues, organizers, and status tracking.

#### Scenario: Verify Events Table

- **WHEN** the database schema is updated
- **THEN** the events table has columns for id, name, slug, description, start_date, end_date, venue_id, status, organizer_id
- **AND** status supports DRAFT, PUBLISHED, CANCELLED, COMPLETED

### Requirement: Ticket Types Data Structure

The system MUST allow multiple ticket types per event with pricing and inventory controls.

#### Scenario: Verify Ticket Types Table

- **WHEN** the database schema is updated
- **THEN** the ticket_types table has columns for id, event_id, name, price, currency, quantity_total, quantity_sold, sale_start, sale_end, max_per_order
- **AND** price must be non-negative

### Requirement: Seats Data Structure

The system MUST support seat definitions for seated events.

#### Scenario: Verify Seats Table

- **WHEN** the database schema is updated
- **THEN** the seats table has columns for id, venue_id, section, row, number, is_accessible

### Requirement: Issued Tickets Data Structure

The system MUST track individual issued tickets with unique security tokens and status.

#### Scenario: Verify Tickets Table

- **WHEN** the database schema is updated
- **THEN** the tickets table has columns for id, ticket_number, secure_token, event_id, ticket_type_id, user_id, order_id, seat_id, status
- **AND** status supports ACTIVE, SCANNED, REFUNDED, VOID

### Requirement: Data Integrity

Foreign keys MUST verify valid relationships between entities.

#### Scenario: Enforce Foreign Keys

- **WHEN** trying to insert a ticket referencing a non-existent event
- **THEN** the database rejects the create operation with a constraint violation

