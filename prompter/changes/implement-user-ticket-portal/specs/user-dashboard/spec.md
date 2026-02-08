# Spec: User Dashboard

## Overview

Central hub for ticket holders to see an overview of their tickets, payments, and recent activity.

---

## ADDED Requirements

### Requirement: Dashboard Overview

The user dashboard SHALL display summary cards with ticket and payment counts.

#### Scenario: View dashboard summary cards

- **WHEN** a logged-in user accesses `/user/dashboard`
- **THEN** they see summary cards for: Active Tickets, Pending Payments, Past Events
- **AND** clicking each card navigates to the respective filtered list

#### Scenario: Dashboard with no data

- **WHEN** a new user with no tickets accesses the dashboard
- **THEN** summary cards show "0" for all counts
- **AND** empty state message displayed: "You don't have any tickets yet"

---

### Requirement: Recent Tickets Widget

The dashboard SHALL display the user's most recent tickets.

#### Scenario: View recent tickets

- **WHEN** a user with tickets views the dashboard
- **THEN** up to 5 most recent tickets are shown
- **AND** each ticket shows: event name, date, seat number, status badge

#### Scenario: View all tickets link

- **WHEN** user has more than 5 tickets
- **THEN** "View All" link is displayed
- **AND** clicking navigates to `/user/tickets`

---

### Requirement: Recent Payments Widget

The dashboard SHALL display the user's most recent payments.

#### Scenario: View recent payments

- **WHEN** a user with payments views the dashboard
- **THEN** up to 3 most recent payments are shown
- **AND** each payment shows: invoice number, date, amount, status badge

---

### Requirement: Dashboard Caching

Dashboard data SHALL be cached for performance.

#### Scenario: Dashboard data cached

- **WHEN** a user accesses the dashboard
- **THEN** summary counts are cached for 5 minutes
- **AND** subsequent requests use cached data

---

## Technical Notes

- Dashboard route: `GET /user/dashboard`
- Controller: `User\DashboardController@index`
- Cache key: `user:{user_id}:dashboard:stats`
