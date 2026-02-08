# Spec: Ticket Details View

## Overview

Allow users to view comprehensive information about their tickets, including barcode display and download functionality.

---

## ADDED Requirements

### Requirement: My Tickets List

Users SHALL be able to view a paginated, filterable list of their tickets.

#### Scenario: View all tickets

- **WHEN** a user navigates to `/user/tickets`
- **THEN** they see a list of all tickets associated with their account
- **AND** tickets are sorted by event date (nearest first)
- **AND** each card shows: event name, date, seat, type, status

#### Scenario: Filter tickets by status

- **WHEN** a user clicks filter tabs (Upcoming, Past, Pending)
- **THEN** only tickets matching that filter are shown

#### Scenario: Ticket pagination

- **WHEN** a user has more than 12 tickets
- **THEN** tickets are paginated with 12 per page
- **AND** pagination controls shown at bottom

#### Scenario: Empty tickets list

- **WHEN** a user has no tickets
- **THEN** empty state illustration shown
- **AND** message: "You don't have any tickets yet"

---

### Requirement: Ticket Detail Page

Users SHALL be able to view comprehensive ticket information including scannable barcode.

#### Scenario: View ticket details

- **WHEN** a user clicks on a ticket from the list
- **THEN** they see: event name, date, venue, seat, type, price, status, barcode/QR

#### Scenario: Barcode display

- **WHEN** ticket detail page loads
- **THEN** barcode/QR code is displayed prominently and scannable
- **AND** copy button allows copying barcode data

#### Scenario: Scanned ticket indicator

- **WHEN** viewing a ticket that has been scanned
- **THEN** "Checked In" badge is displayed with scan timestamp

---

### Requirement: Ticket Download

Users SHALL be able to download their ticket.

#### Scenario: Download ticket

- **WHEN** user clicks "Download" button on ticket detail
- **THEN** PDF or image file is generated and downloaded

---

### Requirement: Ticket Authorization

Users SHALL only be able to view tickets associated with their account.

#### Scenario: View own ticket

- **WHEN** user accesses a ticket associated with their account
- **THEN** ticket details are displayed

#### Scenario: Access other user ticket

- **WHEN** user accesses a ticket not associated with their account
- **THEN** 403 Forbidden error is returned

#### Scenario: Access non-existent ticket

- **WHEN** user accesses a ticket ID that doesn't exist
- **THEN** 404 Not Found error is returned

---

## Technical Notes

- Routes: `GET /user/tickets`, `GET /user/tickets/{ticket}`
- Controller: `User\TicketController`
- Policy: `TicketPolicy@view` checks `$ticket->user_id === $user->id`
