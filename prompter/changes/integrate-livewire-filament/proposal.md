# Change: Integrate Livewire & Filament for Admin Panel

## Why

The current admin panel is built with hand-crafted Blade templates and standard Laravel controllers. Every CRUD screen (events, tickets, payments, users, venues, organizers, seats, ticket-types, history) is individually maintained across ~35 view files and 10 controllers. This creates high maintenance overhead, inconsistent UX patterns, and no real-time interactivity (all filtering, searching, and pagination triggers full-page reloads). Integrating **Livewire** provides dynamic, real-time UI without writing custom JavaScript, while **Filament v3** replaces the entire admin CRUD layer with a polished, consistent panel — complete with tables, forms, filters, actions, widgets, and notifications out-of-the-box.

## What Changes

### 1. Install Livewire 3

- Add `livewire/livewire` as a Composer dependency.
- Publish Livewire config; configure asset injection.
- Add `@livewireStyles` / `@livewireScripts` (or auto-inject) to the public-facing layout (`layouts/app.blade.php`, `user/layouts/app.blade.php`).
- Livewire will power any future real-time user-facing components (e.g., ticket scanner feedback, live checkout status updates).

### 2. Install Filament v3 Admin Panel

- Add `filament/filament` as a Composer dependency (this pulls in Livewire automatically).
- Run `php artisan filament:install --panels` to scaffold the `AdminPanelProvider`.
- Configure the panel ID as `admin`, path as `/panel` (to avoid collision with existing `/admin` routes during migration).
- Set the panel's auth guard, color scheme, and branding (logo, favicon, app name "Tiketcaw").
- Configure `canAccessPanel()` on the `User` model so only `admin` and `staff` roles can access Filament.

### 3. Create Filament Resources (replacing custom admin controllers/views)

- **EventResource** — replaces `Admin\EventController` + 5 Blade views. Table with sortable/searchable columns, create/edit forms with venue & organizer selects, show page, participants relation manager.
- **TicketResource** — replaces `Admin\TicketController` + 6 Blade views. Table with status badges, filters (scanned/unscanned, type, date range), export action, preview action.
- **PaymentResource** — replaces `Admin\PaymentController` + 2 Blade views. Table with proof image preview, approve/reject bulk actions, status filters.
- **UserResource** — replaces `Admin\UserController` + 4 Blade views. Table with role badge column and filter.
- **VenueResource** — replaces `Admin\VenueController` + Blade views. Includes seats relation manager.
- **OrganizerResource** — replaces `Admin\OrganizerController` + Blade views.
- **TicketTypeResource** — replaces `Admin\TicketTypeController` nested under events.
- **SeatResource** — replaces `Admin\SeatController` nested under venues.

### 4. Create Filament Dashboard Widgets

- **StatsOverviewWidget** — Quick stats cards (total tickets, validated, unvalidated, revenue) replacing the hand-coded dashboard stats.
- **RecentActivityWidget** — Latest activity log entries.
- **TicketSalesTrendWidget** — Chart widget showing ticket sales over time.

### 5. Filament Custom Pages

- **EventParticipantsPage** — Dedicated page for viewing event participants with filters (migrating `Admin\EventController@participants`).
- **ActivityHistoryPage** — Replaces `Admin\HistoryController` with filterable, exportable table.

### 6. Migrate Admin Routes

- Keep existing `/admin/*` Blade routes temporarily behind a feature flag for safe rollover.
- Filament panel served at `/panel` initially; once validated, swap to `/admin` and retire old routes.

### 7. Styling & Theme Consistency

- Configure Filament's color palette to match the existing indigo/purple gradient brand.
- Register the Outfit and Plus Jakarta Sans fonts in Filament's theme.
- Create a custom Filament theme CSS using Tailwind CSS v4 to align with the existing design tokens (`--color-primary`, `glass-card`, etc.).
- Ensure daisyUI components are NOT loaded inside Filament to avoid CSS conflicts.

### 8. Livewire Components for User-Facing Pages

- Create `LiveTicketScanner` Livewire component for real-time barcode scanning feedback (replacing the current full-page-reload scan/validate flow).
- Create `LiveCheckoutStatus` Livewire component to show payment status updates in real-time on the success page.

## Impact

- **New specs**: `livewire-integration`, `filament-admin-panel`, `filament-admin-resources`, `filament-admin-dashboard`
- **Affected specs**: `admin-dashboard-filters`, `admin-payment-approval`, `event-participants`, `theme-standardization`
- **New dependencies**: `livewire/livewire` (^3.0), `filament/filament` (^3.0)
- **Affected code**:
    - New: `app/Filament/` directory (Panel provider, Resources, Widgets, Pages)
    - New: `app/Livewire/` directory (user-facing Livewire components)
    - Modified: `composer.json` (new dependencies)
    - Modified: `app/Models/User.php` (add `FilamentUser` contract + `canAccessPanel()`)
    - Modified: `config/app.php` or `bootstrap/providers.php` (Filament panel provider registration)
    - Modified: `vite.config.js` (possible Filament theme build entry)
    - Modified: public layouts for `@livewireStyles`/`@livewireScripts` injection
    - Deprecated (eventually removed): `app/Http/Controllers/Admin/` (10 controllers), `resources/views/admin/` (~35 Blade views), admin routes in `routes/web.php`
- **Migration risk**: MODERATE — running old Blade admin + new Filament panel in parallel minimizes risk
