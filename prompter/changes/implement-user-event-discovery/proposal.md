# Change: User Event Discovery & Purchase

## Why

Users currently lack a public interface to browse events and purchase tickets, despite the backend infrastructure being ready. This prevents the platform from selling tickets and fulfilling its primary business purpose.

## What Changes

- **Frontend**: Add new public pages for Event List (`/events`) and Event Details (`/events/{slug}`).
- **Backend Service**: Implement `CheckoutController` to handle ticket purchase logic, including inventory validation and secure token generation.
- **Models**: Add helper scopes and methods to `Event`, `TicketType`, and `Seat` to support frontend queries and availability checks.
- **Authentication**: Enforce login for purchase actions.

## Impact

- **Affected specs**: `event-discovery`, `ticket-purchase`.
- **Affected code**: `routes/web.php`, `app/Http/Controllers/EventController.php`, `app/Http/Controllers/CheckoutController.php`, `resources/views/events/*`.
