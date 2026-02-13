# theme-standardization Specification

## Purpose
TBD - created by archiving change standardize-light-mode. Update Purpose after archive.
## Requirements
### Requirement: Single Visual Theme

The application MUST only support the "Light" visual theme across all interfaces (Admin, User Portal, Public).

#### Scenario: Admin Dashboard Load

- **Given** I am an admin user
- **When** I load the dashboard
- **Then** the interface appears in light mode
- **And** there are no toggle buttons to switch to dark mode
- **And** my system preference for "Dark Mode" is ignored

#### Scenario: User Portal Load

- **Given** I am a ticket holder accessing the portal
- **When** I log in
- **Then** the dashboard appears in light mode (consistent with public pages)
- **And** the background is light (e.g., `bg-base-200`) instead of dark (`bg-slate-900`)

### Requirement: Codebase Cleanliness

All dark-mode specific logic and unused styles MUST be removed to prevent technical debt.

#### Scenario: Source Inspection

- **Given** I inspect `app.css`
- **Then** I should not see `dark:` variant overrides
- **And** the DaisyUI config should only list `light` theme

