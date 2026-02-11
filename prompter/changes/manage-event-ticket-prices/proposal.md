# Change: Event Ticket Price Management

## Why

Event organizers need a flexible and reliable way to manage ticket pricing for their events. Currently, the system lacks a dedicated interface for managing complex pricing scenarios, leading to errors and inconsistencies.

## What Changes

- **CRUD Interface**: Implement a dedicated section in the Event Dashboard for managing `TicketType`s.
- **Backend Logic**: Create `TicketPriceController` to handle creating, updating, and deleting ticket tiers.
- **Validation**: Enforce strict validation rules (e.g., price > 0, quantity >= 0) on both specialized Form Requests and frontend.
- **UI Enhancements**: Add a "Ticket Prices" tab to the event management view with a responsive table and modal forms.

## Impact

- **Affected specs**: None (new capability).
- **New specs**:
    - `manage-prices` – Core requirements for managing ticket pricing tiers.
- **Affected code**:
    - `app/Http/Controllers/TicketPriceController.php` (New)
    - `app/Http/Requests/StoreTicketPriceRequest.php` (New)
    - `resources/views/events/show.blade.php` (Modified)
    - `resources/views/events/ticket-types/` (New components)
    - `routes/web.php` (Modified)
