# Event Ticket Price Management Design

## Architecture

The solution follows the standard MVC pattern of Laravel. We will utilize the existing `Event` and `TicketType` models.

### Database Schema

We will use the existing `ticket_types` table which has the following structure:

- `id` (primary key)
- `event_id` (foreign key to events)
- `name` (string)
- `description` (text, nullable)
- `price` (decimal)
- `quantity` (integer, default 0)
- `sold` (integer, default 0)
- `sale_start_date` (datetime, nullable)
- `sale_end_date` (datetime, nullable)
- `timestamps`

### key Components

#### 1. Models

- **Event**: Has many `TicketTypes`.
- **TicketType**: Belongs to `Event`.

#### 2. Controllers

- **`TicketPriceController`**:
    - `index(Event $event)`: Returns the list of ticket prices for a specific event.
    - `store(Request $request, Event $event)`: Validates and creates a new ticket price.
    - `update(Request $request, Event $event, TicketType $ticketType)`: Validates and updates a ticket price.
    - `destroy(Event $event, TicketType $ticketType)`: Deletes a ticket price.

#### 3. Validation

We will use a Form Request `StoreTicketPriceRequest` and `UpdateTicketPriceRequest` ensuring:

- `name`: required, string, max 255.
- `price`: required, numeric, min:0.
- `quantity`: required, integer, min:0.
- `sale_start_date`: date, nullable.
- `sale_end_date`: date, after:sale_start_date, nullable.

#### 4. Frontend

- We will integrate the ticket price management into the **Event Show/Edit** page.
- A new section "Ticket Types" will display existing types in a table.
- A modal or inline form will facilitate adding/editing types without leaving the page (using Blade components and potentially Alpine.js for interactivity).

### Security

- **Authorization**: Ensure only the event organizer (or admin) can manage ticket prices for their event. We will use a Policy for `TicketType` or leverage existing `EventPolicy`.

### API (Internal)

While ensuring server-side rendering with Blade is the primary goal, we may expose internal API endpoints if we decide to use a more dynamic frontend framework component (like Vue/React) in the future, but for now, standard Resource Controllers returning views or redirects will suffice.
