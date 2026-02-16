# filament-admin-panel Specification

## Purpose

Filament v3 admin panel configuration for Tiketcaw.
## Requirements
### Requirement: Filament Panel Installation

The system SHALL include Filament v3 as a Composer dependency and provide an `AdminPanelProvider` that configures a dedicated admin panel accessible at a configurable URL path.

#### Scenario: Panel accessible at configured path

- **WHEN** an admin or staff user navigates to the Filament panel path (e.g., `/panel`)
- **THEN** the Filament login page or dashboard is displayed
- **AND** the panel branding shows "Tiketcaw" with the project's indigo/purple color scheme

#### Scenario: Non-admin denied access

- **WHEN** a user with role `user` or `volunteer` attempts to access the Filament panel
- **THEN** access is denied and the user is redirected to the appropriate portal

### Requirement: Filament Authentication Guard

The system SHALL reuse the default `web` authentication guard for Filament, with access restricted to users whose `role` column is `admin` or `staff`.

#### Scenario: Admin login via Filament

- **WHEN** a user with `role = 'admin'` logs in through the Filament login page
- **THEN** they are authenticated and redirected to the Filament dashboard

#### Scenario: Staff login via Filament

- **WHEN** a user with `role = 'staff'` logs in through the Filament login page
- **THEN** they are authenticated and redirected to the Filament dashboard
- **AND** resources restricted to admin-only are not visible to staff

### Requirement: Filament Theme Consistency

The system SHALL configure a custom Filament theme that matches the application's existing visual identity, including brand colors, fonts, and styling conventions.

#### Scenario: Brand colors applied

- **WHEN** the Filament panel is loaded
- **THEN** the primary color is indigo (#6366f1), danger color is red (#e61f27)
- **AND** the Outfit and Plus Jakarta Sans fonts are used for headings and body text

#### Scenario: No CSS conflicts with main app

- **WHEN** the Filament panel is loaded
- **THEN** daisyUI classes from the main application CSS are NOT applied within the panel
- **AND** no visual glitches or broken layouts appear

### Requirement: Filament Navigation Structure

The system SHALL organize the Filament sidebar navigation to mirror the current admin panel structure, with logical groupings for operations, master data, and system management.

#### Scenario: Admin sees full navigation

- **WHEN** an admin user views the Filament sidebar
- **THEN** navigation groups include: Dashboard, Operations (Tickets, Payments, History), Master Data (Events, Venues, Organizers), and System (Users)

#### Scenario: Staff sees limited navigation

- **WHEN** a staff user views the Filament sidebar
- **THEN** system management items (Users, Master Data) are hidden
- **AND** operational items (Dashboard, Tickets, History) remain visible

