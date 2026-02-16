## 1. Foundation — Install & Configure Dependencies

- [x] 1.1 Run `composer require filament/filament:"^3.0"` (includes `livewire/livewire` v3 as a dependency)
- [x] 1.2 Run `php artisan filament:install --panels` to scaffold `AdminPanelProvider`
- [x] 1.3 Configure `AdminPanelProvider`: set panel ID to `admin`, path to `panel`, primary color to indigo, brandName to "Tiketcaw", register fonts (Outfit, Plus Jakarta Sans)
- [x] 1.4 Implement `FilamentUser` contract on `App\Models\User` — add `canAccessPanel()` returning `true` only for `admin` and `staff` roles
- [x] 1.5 Create an admin user via seeder/tinker to verify Filament login works at `/panel`
- [x] 1.6 Verify Livewire asset injection works on existing user-facing layouts (no page breaks)

## 2. Filament Theme — Visual Consistency

- [x] 2.1 Create custom Filament theme: `resources/css/filament/admin/theme.css` (Tailwind v4, register brand colors: primary=#6366f1 indigo, danger=#e61f27)
- [x] 2.2 Register Outfit and Plus Jakarta Sans fonts via Filament's font configuration
- [x] 2.3 Add Filament theme build entry to `vite.config.js` (or use Filament's built-in asset compilation)
- [x] 2.4 Verify Filament panel loads without daisyUI class conflicts (no `app.css` loaded in panel)
- [x] 2.5 Test sidebar, header, and form styling match brand expectations

## 3. Filament Resources — Core CRUD

- [x] 3.1 Create `EventResource` with form (name, slug, description, start_time, end_time, venue select, organizer select, status select, location), table (all columns, sortable, searchable, status badge), and filter (by status, by venue)
- [x] 3.2 Create `TicketResource` with table (UUID, guest name, email, seat, type badge, status badge, price, scanned_at), filters (scanned/unscanned, type, date range, search), and export action
- [x] 3.3 Create `PaymentResource` with table (user, amount, status badge, bank, proof image preview, created_at), filters (by status: pending/confirmed/cancelled), approve/reject header and bulk actions
- [x] 3.4 Create `UserResource` with form (name, email, password, role select, phone, avatar upload), table (name, email, role badge, created_at), filter by role
- [x] 3.5 Create `VenueResource` with form (name, address, city, country, capacity), table columns, and `SeatsRelationManager` for nested seat management
- [x] 3.6 Create `OrganizerResource` with form (name, email, phone, description), table columns
- [x] 3.7 Create `TicketTypeResource` as a RelationManager on `EventResource` (name, price, quota, description)
- [x] 3.8 Create `BankResource` with simple form (name, code, logo, is_active toggle), table with active/inactive filter

## 4. Filament Dashboard — Widgets

- [x] 4.1 Create `StatsOverviewWidget` with stat cards: Total Tickets, Validated, Unvalidated, Revenue, and per-category counts (VVIP, VIP, Festival, GA)
- [x] 4.2 Create `RecentActivityWidget` showing latest 10 activity log entries (user, action, description, timestamp)
- [x] 4.3 Create `PendingPaymentsWidget` showing count of pending payments with link to PaymentResource
- [x] 4.4 Register all widgets on the Filament dashboard page

## 5. Filament Custom Pages & Actions

- [x] 5.1 Create custom `EventParticipants` page (or RelationManager on EventResource) showing all ticket holders for a given event with search and filters
- [x] 5.2 Add `ViewAction` and `ExportAction` on TicketResource for per-ticket preview and PDF export
- [x] 5.3 Add `ApproveAction` and `RejectAction` on PaymentResource (approve: confirm payment + update linked tickets; reject: cancel + prompt for reason + restore inventory)
- [x] 5.4 Create `ActivityLogResource` (read-only) or custom page replacing `Admin\HistoryController` with filters and export

## 6. Livewire Components — User-Facing Real-Time Features

- [x] 6.1 Create `LiveTicketScanner` Livewire component at `app/Livewire/LiveTicketScanner.php` — real-time barcode validation without full-page reload
- [x] 6.2 Create `LivePaymentStatus` Livewire component — polls or listens for payment approval updates on the checkout success page
- [x] 6.3 Add `@livewireStyles` and `@livewireScripts` to the user-facing layout (`resources/views/user/layouts/app.blade.php`) if not auto-injected
- [x] 6.4 Update `scan.blade.php` to embed the `LiveTicketScanner` component
- [x] 6.5 Update `checkout/success.blade.php` to embed the `LivePaymentStatus` component

## 7. Testing & Validation

- [x] 7.1 Verify all Filament Resources CRUD works: create, edit, view, delete for each model
- [x] 7.2 Test Filament filters, search, and pagination on each Resource
- [x] 7.3 Test payment approve/reject flow in Filament and confirm ticket statuses update correctly
- [x] 7.4 Test Filament dashboard widgets display correct data
- [x] 7.5 Test Livewire scanner component processes barcodes correctly
- [x] 7.6 Test LivePaymentStatus reflects status changes
- [x] 7.7 Test that existing user-facing pages (events, dashboard, tickets, checkout) are unaffected
- [x] 7.8 Test responsive behavior of Filament panel on mobile
- [x] 7.9 Run `php artisan test` — all existing tests pass

## 8. Route Migration & Cleanup (Phase 3 — after validation)

- [x] 8.1 Change Filament panel path from `/panel` to `/admin`
- [x] 8.2 Remove or comment out old `/admin/*` routes from `routes/web.php`
- [x] 8.3 Remove deprecated admin controllers from `app/Http/Controllers/Admin/`
- [x] 8.4 Remove deprecated admin Blade views from `resources/views/admin/`
- [x] 8.5 Remove `resources/views/layouts/admin.blade.php` layout
- [x] 8.6 Update any hardcoded `/admin` links in the user-facing app to use Filament's URL helpers
- [x] 8.7 Final smoke test: all functionality accessible, no broken links
