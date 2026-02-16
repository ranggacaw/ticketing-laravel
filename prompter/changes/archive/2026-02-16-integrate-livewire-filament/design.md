## Context

The application is a Laravel 12 ticketing system currently using:

- **Backend**: Standard Laravel controllers + Blade views for both user-facing and admin pages
- **Frontend**: Tailwind CSS v4 + daisyUI v5 (beta) + Alpine.js
- **Auth**: Custom role-based auth (`admin`, `staff`, `volunteer`, `user`) via a `role` column on users
- **Admin panel**: 10 controllers, ~35 Blade views, custom sidebar layout (`layouts/admin.blade.php`)

This is a cross-cutting change that introduces two new major dependencies (Livewire 3, Filament v3), replaces the entire admin layer, and adds real-time capabilities to user-facing pages.

## Goals / Non-Goals

### Goals

- Replace hand-crafted admin CRUD with Filament Resources for consistency and maintainability
- Provide real-time, reactive UI on user-facing pages via Livewire components
- Maintain brand consistency (indigo/purple gradient, Outfit font, glass-card aesthetic) in the Filament panel
- Enable a parallel-run period where both old Blade admin and new Filament panel coexist
- Preserve all existing admin functionality (dashboard stats, filtering, payment approval, export, etc.)

### Non-Goals

- Replacing user-facing pages with Filament (user portal stays Blade + Alpine)
- Migrating the volunteer scanner to Filament (keep the dedicated scan page as-is)
- Building a Filament plugin or reusable package
- Multi-tenancy or team management

## Decisions

### D1: Filament Panel Path — `/panel` initially, migrate to `/admin` later

- **What**: Filament admin panel mounts at `/panel` during transition; existing `/admin` Blade routes remain active.
- **Why**: Avoids route collision. Allows side-by-side validation before retiring old views.
- **Alternatives considered**:
    - Mount at `/admin` immediately and remove old routes → Higher risk; if Filament is misconfigured, admins lose access.
    - Mount at `/admin` with subdomain isolation → Overkill for this project size.

### D2: Filament Authentication — Reuse existing Laravel auth, no separate guard

- **What**: Filament uses the default `web` guard. Access control via `canAccessPanel()` on the `User` model, checking `role` in `['admin', 'staff']`.
- **Why**: The app already has a working auth system. Creating a separate guard would fragment sessions and require users to log in twice.
- **Alternatives considered**:
    - Separate `admin` guard → Unnecessary complexity; would lose existing session.
    - Filament Shield plugin for permissions → Over-engineered for 2 admin roles; can add later if needed.

### D3: Livewire Asset Injection — Auto-inject (default behavior)

- **What**: Livewire 3 auto-injects its scripts/styles. No manual `@livewireStyles`/`@livewireScripts` needed for Filament. For user-facing layouts, rely on auto-injection or add directives to the base layout.
- **Why**: Simpler, less error-prone. Filament handles its own Livewire injection internally.

### D4: CSS Isolation — Filament uses its own Tailwind build, NOT the app's daisyUI config

- **What**: Filament has its own CSS pipeline. The main `app.css` (with daisyUI) is NOT loaded inside Filament.
- **Why**: daisyUI v5 and Filament both customize Tailwind heavily. Loading both would cause class name collisions and visual glitches.
- **Custom theme**: Create `resources/css/filament/admin/theme.css` with Filament's recommended Tailwind v4 setup. Register brand colors (`primary: indigo`, `danger: red`, etc.) and fonts (`Outfit`, `Plus Jakarta Sans`) so the Filament panel feels cohesive with the rest of the app.

### D5: Resource Architecture — One Resource per model, nested relations via RelationManagers

- **What**: Each admin model gets its own Filament Resource. Nested entities (seats under venues, ticket-types under events) use Filament's RelationManager pattern instead of separate pages.
- **Why**: Matches Filament conventions, reduces navigation depth, keeps related data contextual.

### D6: Migration Strategy — Phased rollout

- **Phase 1**: Install Livewire + Filament, configure panel, create Resources for all current admin CRUD operations. Both old and new panels accessible.
- **Phase 2**: Validate all functionality in Filament panel, build Livewire user-facing components.
- **Phase 3**: Redirect `/admin` to Filament panel, archive old Blade views and controllers.

## Risks / Trade-offs

| Risk                                              | Impact                               | Mitigation                                                 |
| ------------------------------------------------- | ------------------------------------ | ---------------------------------------------------------- |
| Filament v3 may not fully support Tailwind CSS v4 | Medium — custom theme may break      | Pin Filament to a version with v4 support; test thoroughly |
| daisyUI + Filament CSS collision if both loaded   | High — visual glitches               | Isolate CSS: Filament pages never load `app.css`           |
| Route collisions during parallel run (`/admin`)   | Low — panel at `/panel` initially    | Only swap after full validation                            |
| Increased composer dependency tree                | Low — standard for Laravel ecosystem | All packages are well-maintained, first-party              |
| Learning curve for team                           | Medium                               | Filament is well-documented; existing patterns map 1:1     |

## Migration Plan

1. **Install dependencies** → `composer require filament/filament:"^3.0"` (includes Livewire 3)
2. **Run installer** → `php artisan filament:install --panels`
3. **Configure panel** → `AdminPanelProvider.php` (path, colors, fonts, auth)
4. **Create User contract** → Implement `FilamentUser` on `User` model
5. **Generate Resources** → One per model, configure forms/tables/actions
6. **Create Widgets** → Dashboard stats, activity feed, charts
7. **Build Livewire components** → Scanner, checkout status
8. **Test parallel** → Verify both old and new panel work
9. **Cutover** → Move Filament to `/admin`, deprecate old routes
10. **Cleanup** → Remove old admin controllers, views, routes

### Rollback

- Remove Filament panel provider from config
- Revert `User` model changes
- `composer remove filament/filament`
- Old admin routes/views remain functional until explicitly deleted

## Open Questions

1. Should the Filament panel path be `/panel` or something else like `/manage`?
2. Do we need Filament's notification system to replace Laravel's session flash messages for the user-facing app, or keep those separate?
3. Should we keep the old admin layout as a fallback for the volunteer scanner page, or integrate the scanner into Filament as a custom page?
