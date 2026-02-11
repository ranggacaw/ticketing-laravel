# Tasks: Manage Event Ticket Prices

## Definition of Done

- [x] Ticket Pricing interface is available in Event Dashboard
- [x] Admins can create, read, update, and delete ticket types
- [x] Validation prevents invalid data (negative prices, etc.)
- [x] Feature tests pass

---

## 1. Backend Implementation

- [x] 1.1 Create `TicketPriceController`
    - Implement `index`, `store`, `update`, `destroy` methods
    - Ensure logic is scoped to `Event` model

- [x] 1.2 Implement Validation Requests
    - Create `StoreTicketPriceRequest` (rules: name required, price > 0, quantity >= 0)
    - Create `UpdateTicketPriceRequest`

- [x] 1.3 Define Routes
    - Add resource routes `events.ticket-types` in `web.php`

- [x] 1.4 Implement Authorization
    - Create/Update `TicketTypePolicy` or ensure `EventPolicy` covers ticket management

## 2. Frontend Implementation

- [x] 2.1 Create Ticket Types Table Component
    - `resources/views/events/ticket-types/index.blade.php`
    - Display Name, Price, Quantity, Sold, Actions

- [x] 2.2 Create Add/Edit Form Component
    - `resources/views/events/ticket-types/form.blade.php`
    - Input fields for Category Name, Price, Quota, Description
    - Handle validation errors

- [x] 2.3 Integrate with Event Dashboard
    - Add "Ticket Prices" tab/section in `resources/views/events/show.blade.php` (or edit)

## 3. Testing

- [x] 3.1 Write Feature Tests
    - `tests/Feature/TicketPriceManagementTest.php`
    - Test happy path (CRUUD)
    - Test validation failures
    - Test authorization (unauthorized access)
