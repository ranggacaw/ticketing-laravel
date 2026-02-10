# TASKS: Implement Master Data Schema

## 1. Database Schema Migration

- [x] Create `venues` migration (basic structure for FKs)
- [x] Create `organizers` migration (basic structure for FKs or use Users table with role)
- [x] Update/Recreate `events` table with new fields (`slug`, `venue_id`, `status`, `organizer_id`)
- [x] Create `ticket_types` table
- [x] Create `seats` table
- [x] Update `tickets` table schema (add `secure_token`, `ticket_type_id`, `status`, `seat_id`, etc.)

## 2. Models & Relationships

- [x] Create/Update `Venue` model with `hasMany` relationships
- [x] Create/Update `Organizer` model with `hasMany` relationships
- [x] Update `Event` model (fillable, relationships, status enum casting)
- [x] Create `TicketType` model (relationships, accessors)
- [x] Create `Seat` model (relationships)
- [x] Update `Ticket` model (relationships, status enum casting, secure token generation)

## 3. Factories & Seeders

- [x] Update `EventFactory` to include relations
- [x] Create `TicketTypeFactory`
- [x] Update `TicketFactory` to use new structure
- [x] Create seeders for a sample event with ticket types and seats

## 4. Validation (Tests)

- [x] Test: Event creation with related entities works correctly
- [x] Test: Ticket Type inventory management prevents negative values
- [x] Test: Ticket issuance enforces unique tokens and valid relationships
