# Design Decisions: Complete Ticketing Flow

## 1. Master Data Management UI

### Context

Admins need to manage complex hierarchical data (Event -> TicketType, Venue -> Seat).

### Decisions

- **Nested Resource Routing**:
    - Ticket Types will be nested under Events (`admin/events/{event}/ticket-types`).
    - Seats will be nested under Venues (`admin/venues/{venue}/seats`).
- **Bulk Operations for Seats**:
    - Since creating seats one-by-one is tedious, the Seat Create UI will support bulk generation (e.g., "Row A, Numbers 1-20").
- **Live Previews**:
    - Ticket Type creation will show a small preview of how it looks on the public page.

## 2. User Activity Timeline

### Context

Users want a single view of all their interactions.

### Decisions

- **Polymorphic Activity Feed**:
    - Use the existing `ActivityLog` model but enrich it with specialized formatters for different event types (purchase, check-in, review).
    - Frontend will use a unified timeline component that renders different "cards" based on activity type.

## 3. Ticket Scanning Display

### Context

Scanning at events can be slow if screens are dim or codes are small.

### Decisions

- **Dedicated "Scan Mode"**:
    - A specific route `/user/tickets/{uuid}/scan` designed for mobile screens.
    - Forces high contrast (white background, black code) regardless of theme.
    - Uses JavaScript to request screen wake lock (if supported).
    - Encodes a `secure_token` (TOTP or static secret) in the QR code to prevent simple screenshot replay attacks (future-proofing).

## 4. Ticket Previews & Testimonials

### Context

Users want to share tickets on social media and leave reviews after events.

### Decisions

- **HTML-to-Image Generation**:
    - The "Preview Ticket" feature will use a DOM-to-Image library (client-side) to generate a shareable image from a styled HTML node, avoiding heavy server-side image generation.
- **Testimonial Linking**:
    - Testimonials are strictly linked to a valid, attended ticket (checked-in status preferred, or at least past event date) to ensure authenticity.
