# Spec: Ticket Management

## Overview

Manage the user's ticket inventory, allow viewing details, and accessing tickets for usage (scanning).

## ADDED Requirements

### Requirement: My Tickets List

Users SHALL be able to view a paginated, filterable list of their tickets.

#### Scenario: View all tickets

- **WHEN** a user navigates to `/user/tickets`
- **THEN** they see a list of all tickets associated with their account
- **AND** tickets are sorted by event date (nearest first)
- **AND** tabs for "Upcoming" and "Past" are available.

#### Scenario: Filter tickets by status

- **WHEN** a user clicks "Past" tab
- **THEN** only past event tickets are shown.

### Requirement: Ticket Detail View

Users SHALL be able to view comprehensive ticket information including scannable barcode.

#### Scenario: View ticket details

- **WHEN** a user clicks on a ticket from the list
- **THEN** they see: Event Name, Date, Venue, Seat, Status, Barcode/QR.
- **AND** (If past) A "Write Review" button is shown (linking to Testimonials).

#### Scenario: Ticket Authorization

- **WHEN** user tries to view a ticket ID not owned by them
- **THEN** a 403 Forbidden error is returned.

## Technical Notes

- Route: `GET /user/tickets`, `GET /user/tickets/{id}`.
- Controller: `User\TicketController`.
- Policy: `TicketPolicy@view`.
