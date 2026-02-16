# DESIGN: User Event Discovery & Purchase

## Architecture

This feature is built on top of the standard **Laravel MVC** pattern, utilizing **Blade** templates for server-side rendering and **Tailwind CSS/DaisyUI** for the UI.

### 1. Routing Structure

- `GET /events` -> `EventController@index`
    - Lists all `PUBLISHED` events.
    - Supports basic search/filtering.
- `GET /events/{slug}` -> `EventController@show`
    - detailed view of an event.
    - Shows Venue, Organizer, and Ticket Types.
- `GET /events/{slug}/checkout` -> `CheckoutController@show`
    - Form to select tickets/seats if not done on the detail page (or consolidate selection on detail page and POST directly).
    - _Decision_: To keep it simple, `show` page allows selecting Ticket Type and Quantity. "Buy Now" takes you to a summary/confirmation or directly processes if simple.
    - _Refined_:
        - `POST /events/{slug}/checkout` -> `CheckoutController@store` involves:
            - Validating availability.
            - Creating `Ticket` records.
            - Decrementing inventory.
            - Redirecting to Success.
- `GET /tickets/{uuid}/success` -> `TicketController@success` (or similar)
    - Shows the purchased ticket(s).

### 2. Frontend Components (Blade)

We will use reusable Blade components where possible, but primarily standard views:

- `resources/views/events/index.blade.php`: Grid of event cards.
- `resources/views/events/show.blade.php`: Hero section (Image), Details (Venue/Time), Ticket Selection form.
- `resources/views/checkout/success.blade.php`: Order confirmation.

### 3. Inventory Management Logic

To prevent over-selling:

- **Ticket Types**: `quantity_sold` must be checked against `quantity_total`.
- **Seats**: `tickets` table must not already have a valid ticket for the given `seat_id` and `event_id`.
- **Concurrency**: Use `DB::transaction()` with `lockForUpdate()` on the `TicketType` or `Seat` rows during the purchase transaction to ensure atomicity.

### 4. Security & Data Integrity

- **Ticket Generation**: Must generate a `secure_token` (using `Str::random` or similar crypto-secure method) upon creation.
- **User Link**: If user is logged in, link `user_id`. If guest, we might need to create a shadow user or allow null `user_id` (PRD says "Support for logged-in users", implies authentication might be required or preferred. PRD Open Questions says "Assume Force Registration for MVP").
    - _Decision_: Middleware `auth` will be applied to the Purchase action to force login.

## Data Models

Leverages existing:

- `Event` (scopes: `published()`)
- `TicketType` (methods: `isAvailable()`, `hasSeats()`)
- `Seat` (scopes: `availableFor($event)`)
- `Ticket` (factory method: `issueFor($user, $event, $type, $seat)`)

## Dependencies

- **Auth**: User must be logged in to buy.
- **DaisyUI**: For consistent styling with the admin panel.
