# Complete Ticketing Application Flow

## Why

While the core master data schema and basic event browsing/checkout exist, the application lacks a cohesive end-to-end flow. Admins currently manage critical data (like ticket types and seats) via database tools, and users miss key engagement features like activity history, ticket previews, and testimonials. This change implements the **full application flow** defined in the [Version 2.0 PRD](prompter/ticketing-app-flow/prd.md) to make the platform production-ready.

## What Changes

### Admin Side

- **Master Data Management**: Full CRUD UI for Venues, Organizers, Events, Ticket Types, and Seats.
- **Enhanced Dashboard**: Improve "My Activity" tracking and ticket scanning interface.
- **User Management**: Detailed user profiles with history tabs.

### User Side

- **My Activity**: Consolidated timeline of purchases, check-ins, and testimonials.
- **Ticket Management**: Enhanced ticket details, full-screen scanning mode, and visual ticket previews.
- **Engagement**: Testimonial submission for past events.

## Impact

- **New Specs**: `admin-master-data`, `admin-activity`, `user-activity`, `user-ticket-management`.
- **Modified Specs**: `user-event-discovery` (minor enhancements), `core-schema` (usage).
- **Codebase**:
    - New Controllers: `Admin\VenueController`, `Admin\OrganizerController`, `Admin\TicketTypeController`, `Admin\SeatController`, `User\ActivityController`, `User\TestimonialController`.
    - New Views: `admin.venues.*`, `admin.organizers.*`, `user.activity.index`, `user.tickets.show-scan`, `user.tickets.preview`.
    - Updates: `EventController` (admin CRUD), `TicketController` (user view).
