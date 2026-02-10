# Implement Master Data Schema

## Why

The current ticketing system lacks a robust master data schema, relying on flat tables and strings for ticket types and seats. This prevents inventory management, proper validation, and scalability. Implementing a structured schema as defined in the PRD is critical for the MVP.

## What Changes

- **Database Schema**:
    - Add `ticket_types`, `seats`, `venues` (implied), `organizers` (implied) tables.
    - Update `events` table with `slug`, `venue_id`, `status`.
    - Update `tickets` table with `secure_token`, `ticket_type_id`, `status`, foreign keys.
- **Models**: Create/Update Eloquent models for all entities.
- **Factories/Seeders**: Update factories for testing.

## Impact

- **Specs**: Adding `core-schema` capability.
- **Code**: `Event`, `Ticket` models will be refactored. New models `TicketType`, `Seat`.
- **Breaking Changes**: Existing code relying on flat `tickets` table structure (e.g. `price` column directly on tickets, though it might remain as snapshot) will need updates.
