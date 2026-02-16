## ADDED Requirements

### Requirement: Stats Overview Widget

The system SHALL display a statistics overview widget on the Filament dashboard showing key business metrics at a glance.

#### Scenario: Dashboard stats display

- **WHEN** an admin visits the Filament dashboard
- **THEN** stat cards display: Total Tickets (issued), Validated Tickets (with percentage), Unvalidated Tickets, Total Revenue (formatted as Rp)
- **AND** category breakdowns show counts for VVIP, VIP, Festival, and General Admission tickets

#### Scenario: Stats reflect real-time data

- **WHEN** a new ticket is purchased or validated
- **THEN** the dashboard stats update on next page load (or Livewire poll) to reflect current totals

### Requirement: Recent Activity Widget

The system SHALL display a recent activity feed widget on the Filament dashboard showing the latest user and system actions.

#### Scenario: Activity feed display

- **WHEN** an admin visits the Filament dashboard
- **THEN** the 10 most recent activity log entries are shown
- **AND** each entry displays: user avatar initial, user name, action type (bold), description, and relative timestamp

#### Scenario: Link to full history

- **WHEN** an admin clicks "View All" on the activity widget
- **THEN** they are navigated to the full Activity History page/Resource

### Requirement: Pending Payments Widget

The system SHALL display a pending payments counter widget on the Filament dashboard to alert admins of payments awaiting review.

#### Scenario: Pending count displayed

- **WHEN** there are payments with `status = 'pending'`
- **THEN** the widget shows the count of pending payments
- **AND** a link navigates to the Payments Resource filtered by pending status

#### Scenario: No pending payments

- **WHEN** all payments are confirmed or cancelled
- **THEN** the widget displays "0 Pending" or a success indicator
