## ADDED Requirements

### Requirement: Unique Barcode Per Ticket
The system SHALL guarantee that every ticket has a globally unique `barcode_data` value, enforced by a database unique constraint. Each ticket purchased — even within the same transaction — MUST receive its own distinct barcode.

#### Scenario: Multiple tickets in one purchase
- **WHEN** a user buys 3 tickets in a single checkout transaction
- **THEN** 3 separate ticket records are created, each with a unique `barcode_data` value
- **AND** no two tickets in the system share the same `barcode_data`

#### Scenario: Database constraint prevents duplicates
- **WHEN** a ticket is created with a `barcode_data` value that already exists
- **THEN** the database rejects the insert with a unique constraint violation

#### Scenario: Barcode data format
- **WHEN** a ticket is created
- **THEN** its `barcode_data` is derived deterministically from the ticket's UUID
- **AND** the resulting code is short enough for readable 1D barcode rendering (Code128)

#### Scenario: Existing ticket backfill
- **WHEN** migration runs on a database with pre-existing tickets
- **THEN** any ticket with a null or duplicate `barcode_data` is backfilled with a unique value before the unique index is applied
