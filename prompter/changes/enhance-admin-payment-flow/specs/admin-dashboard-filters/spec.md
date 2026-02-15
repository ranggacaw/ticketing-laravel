## ADDED Requirements

### Requirement: Dashboard Ticket Filtering
The admin dashboard SHALL provide filter controls on the Recent Tickets table allowing admins to narrow results by status, ticket type, date range, and keyword search (guest name, email, or UUID).

#### Scenario: Filter by ticket status
- **WHEN** admin selects a status filter (e.g. "issued", "scanned")
- **THEN** the tickets table displays only tickets matching the selected status
- **AND** pagination reflects the filtered count

#### Scenario: Filter by ticket type
- **WHEN** admin selects a ticket type filter (e.g. "VIP", "General Admission")
- **THEN** the tickets table displays only tickets of the selected type

#### Scenario: Filter by date range
- **WHEN** admin enters a start date and/or end date
- **THEN** the tickets table displays only tickets created within the specified range

#### Scenario: Search by keyword
- **WHEN** admin enters a keyword in the search field
- **THEN** the tickets table displays tickets where guest name, email, or UUID contains the keyword (case-insensitive)

#### Scenario: Combined filters
- **WHEN** admin applies multiple filters simultaneously (e.g. status + type + keyword)
- **THEN** the tickets table displays only tickets matching ALL active filter criteria

#### Scenario: Clear filters
- **WHEN** admin clicks the "Clear Filters" action
- **THEN** all filter inputs are reset and the full unfiltered ticket list is displayed

#### Scenario: Filters persist across pagination
- **WHEN** admin navigates to the next page of results while filters are active
- **THEN** the same filter criteria remain applied
