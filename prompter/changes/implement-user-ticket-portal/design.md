# Design: User Ticket Portal (MVP 1)

## Overview

This document captures the architectural decisions, component design, and technical approach for implementing the User Ticket Portal MVP 1.

## Architecture

### System Context

```
┌─────────────────────────────────────────────────────────────────┐
│                        TICKETING SYSTEM                          │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│   ┌─────────────────┐         ┌─────────────────────────────┐   │
│   │   Admin Portal  │         │      User Portal (NEW)      │   │
│   │  (Existing)     │         │                             │   │
│   │  /admin/*       │         │  /user/*                    │   │
│   │  ─────────────  │         │  ─────────────────────────  │   │
│   │  • Dashboard    │         │  • Dashboard                │   │
│   │  • Tickets CRUD │         │  • My Tickets (Read-only)   │   │
│   │  • Users CRUD   │         │  • Payment History          │   │
│   │  • History      │         │  • Profile                  │   │
│   └─────────────────┘         └─────────────────────────────┘   │
│           │                              │                       │
│           └──────────────┬───────────────┘                       │
│                          ▼                                       │
│   ┌─────────────────────────────────────────────────────────┐   │
│   │                   Shared Services                        │   │
│   │  • Authentication (Laravel Auth)                         │   │
│   │  • Activity Logging (LogsActivity trait)                 │   │
│   │  • Role Middleware                                       │   │
│   └─────────────────────────────────────────────────────────┘   │
│                          │                                       │
│                          ▼                                       │
│   ┌─────────────────────────────────────────────────────────┐   │
│   │                     Database                             │   │
│   │  users | tickets | payments | activity_logs              │   │
│   └─────────────────────────────────────────────────────────┘   │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
```

### Authentication Flow

```
┌─────────────────────────────────────────────────────────────────┐
│                    AUTHENTICATION FLOW                           │
└─────────────────────────────────────────────────────────────────┘

[Guest User]
     │
     ├── Click "Login" ──────────────────────────┐
     │                                           │
     ├── Click "Register" ──────────────────┐    │
     │                                      │    │
     ▼                                      ▼    ▼
┌──────────────┐                    ┌──────────────────┐
│ REGISTRATION │                    │     LOGIN        │
│              │                    │                  │
│ • name       │                    │ • email          │
│ • email      │                    │ • password       │
│ • password   │                    │ • remember_me    │
│ • confirm    │                    │                  │
│ • phone (opt)│                    └────────┬─────────┘
└──────┬───────┘                             │
       │                                     │
       ▼                                     │
[Create User with role='user']               │
       │                                     │
       ▼                                     ▼
[Email Verification?] ─── if OQ-01=Yes ─► [Verify Email]
       │ No                                  │
       ▼                                     ▼
       └─────────────────────────────► [Authenticated]
                                             │
                                             ▼
                                      [Role Check]
                                             │
                   ┌─────────────────────────┼─────────────────────┐
                   │                         │                     │
                   ▼                         ▼                     ▼
           [role = 'user']           [role = 'volunteer']   [role = 'admin/staff']
                   │                         │                     │
                   ▼                         ▼                     ▼
           [User Dashboard]          [Scan Page]           [Admin Dashboard]
```

## Database Design

### Entity Relationship Diagram

```
┌───────────────────────────────────────────────────────────────────────┐
│                    ENTITY RELATIONSHIPS                                │
└───────────────────────────────────────────────────────────────────────┘

    ┌─────────────┐          ┌─────────────────┐          ┌─────────────┐
    │   users     │          │    tickets      │          │  payments   │
    ├─────────────┤          ├─────────────────┤          ├─────────────┤
    │ id (PK)     │◄────────┐│ id (PK)         │┌────────►│ id (PK)     │
    │ name        │         ││ uuid            ││         │ user_id (FK)│
    │ email       │         ││ user_id (FK)────┤│         │ invoice_num │
    │ password    │         ││ user_name       ││         │ amount      │
    │ role        │         ││ user_email      ││         │ status      │
    │ phone       │←─NEW    ││ seat_number     ││         │ proof_url   │
    │ notif_prefs │←─NEW    ││ price           ││         │ confirmed_at│
    │ created_at  │         ││ type            ││         │ confirmed_by│
    │ updated_at  │         ││ barcode_data    ││         │ notes       │
    └─────────────┘         ││ payment_status←─┤│─NEW     │ created_at  │
         │                  ││ scanned_at      ││         │ updated_at  │
         │                  │└─────────────────┘│         └─────────────┘
         │                  │         ▲         │                │
         │                  │         │         │                │
         │                  │    ┌────┴────┐    │                │
         │                  │    │ payment_│    │                │
         │                  │    │ tickets │    │                │
         │                  │    ├─────────┤    │                │
         │                  └────│ticket_id│    │                │
         │                       │(FK)     │    │                │
         │                       │payment_ │────┘                │
         │                       │id (FK)  │                     │
         │                       └─────────┘                     │
         │                                                       │
         └───────────────────────────────────────────────────────┘
                              HAS MANY
```

### Schema Details

#### New: `payments` Table

```php
Schema::create('payments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('invoice_number', 50)->unique();
    $table->decimal('amount', 12, 2);
    $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
    $table->string('payment_proof_url', 500)->nullable();
    $table->timestamp('confirmed_at')->nullable();
    $table->foreignId('confirmed_by')->nullable()->constrained('users');
    $table->text('notes')->nullable();
    $table->timestamps();

    $table->index(['user_id', 'status']);
});
```

#### New: `payment_tickets` Table

```php
Schema::create('payment_tickets', function (Blueprint $table) {
    $table->id();
    $table->foreignId('payment_id')->constrained()->onDelete('cascade');
    $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
    $table->timestamps();

    $table->unique(['payment_id', 'ticket_id']);
});
```

#### Modified: `users` Table

```php
Schema::table('users', function (Blueprint $table) {
    $table->string('phone', 20)->nullable()->after('email');
    $table->json('notification_preferences')
        ->default('{"email":true,"payment":true,"events":true}')
        ->after('phone');
});
```

#### Modified: `tickets` Table

```php
Schema::table('tickets', function (Blueprint $table) {
    $table->foreignId('user_id')->nullable()->after('id')->constrained();
    $table->enum('payment_status', ['pending', 'confirmed'])->default('pending')->after('type');

    $table->index('user_id');
});
```

## Component Design

### Controllers

```
app/Http/Controllers/
├── AuthController.php              (MODIFY - add registration)
├── User/
│   ├── DashboardController.php     (NEW)
│   ├── TicketController.php        (NEW)
│   ├── PaymentController.php       (NEW)
│   └── ProfileController.php       (NEW)
```

### Controller Responsibilities

| Controller                 | Routes                                | Responsibilities                         |
| -------------------------- | ------------------------------------- | ---------------------------------------- |
| `AuthController`           | `login`, `register`, `password/*`     | Auth forms, registration, password reset |
| `User\DashboardController` | `user/dashboard`                      | Dashboard summary, widgets, activity     |
| `User\TicketController`    | `user/tickets`, `user/tickets/{id}`   | Ticket listing, details, download        |
| `User\PaymentController`   | `user/payments`, `user/payments/{id}` | Payment history, details                 |
| `User\ProfileController`   | `user/profile`                        | View/update profile, change password     |

### Views Structure

```
resources/views/
├── auth/
│   ├── login.blade.php             (MODIFY - add link to register)
│   ├── register.blade.php          (NEW)
│   ├── forgot-password.blade.php   (NEW)
│   └── reset-password.blade.php    (NEW)
├── user/
│   ├── layouts/
│   │   └── app.blade.php           (NEW - user portal layout)
│   ├── dashboard.blade.php         (NEW)
│   ├── tickets/
│   │   ├── index.blade.php         (NEW)
│   │   └── show.blade.php          (NEW)
│   ├── payments/
│   │   ├── index.blade.php         (NEW)
│   │   └── show.blade.php          (NEW)
│   └── profile/
│       └── edit.blade.php          (NEW)
```

### Middleware Configuration

```php
// routes/web.php additions

// Public auth routes
Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// User portal routes
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('dashboard', [User\DashboardController::class, 'index'])->name('dashboard');
    Route::get('tickets', [User\TicketController::class, 'index'])->name('tickets.index');
    Route::get('tickets/{ticket}', [User\TicketController::class, 'show'])->name('tickets.show');
    Route::get('payments', [User\PaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/{payment}', [User\PaymentController::class, 'show'])->name('payments.show');
    Route::get('profile', [User\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [User\ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [User\ProfileController::class, 'updatePassword'])->name('profile.password');
});
```

## UI/UX Design

### Design System

Following the PRD specifications for a cohesive visual language.

#### Color Tokens

```css
:root {
    /* Primary - Indigo */
    --color-primary-400: #818cf8;
    --color-primary-500: #6366f1;
    --color-primary-600: #4f46e5;

    /* Secondary - Emerald */
    --color-secondary-400: #34d399;
    --color-secondary-500: #10b981;

    /* Accent - Amber */
    --color-accent-400: #fbbf24;
    --color-accent-500: #f59e0b;

    /* Status */
    --color-success: #22c55e;
    --color-warning: #f59e0b;
    --color-error: #ef4444;

    /* Surface - Light */
    --color-bg-light: #ffffff;
    --color-surface-light: #f8fafc;
    --color-text-primary-light: #1e293b;
    --color-text-secondary-light: #64748b;

    /* Surface - Dark */
    --color-bg-dark: #0f172a;
    --color-surface-dark: #1e293b;
    --color-text-primary-dark: #f1f5f9;
    --color-text-secondary-dark: #94a3b8;
}
```

#### Component Patterns

| Component              | Description                                          |
| ---------------------- | ---------------------------------------------------- |
| **Glass Card**         | Semi-transparent with backdrop-blur (existing admin) |
| **Status Badge**       | Pill-shaped with color-coded status                  |
| **Action Button**      | Primary/secondary variants with hover states         |
| **Form Input**         | Consistent sizing, focus states, validation styling  |
| **Skeleton Loader**    | Pulsing placeholder during data loading              |
| **Toast Notification** | Non-intrusive feedback at bottom-right               |

### Page Layouts

#### User Dashboard

```
┌─────────────────────────────────────────────────────────────────┐
│  [Logo]                                    [Profile] [Logout]    │
├─────────────────────────────────────────────────────────────────┤
│ ┌───────────┐                                                    │
│ │ Sidebar   │  ┌─────────────────────────────────────────────┐  │
│ │           │  │ Welcome, {Name}!                    👋       │  │
│ │ Dashboard │  └─────────────────────────────────────────────┘  │
│ │ My Tickets│                                                    │
│ │ Payments  │  ┌───────────┐ ┌───────────┐ ┌───────────┐        │
│ │ Profile   │  │ Active    │ │ Pending   │ │ Past      │        │
│ │           │  │ Tickets   │ │ Payments  │ │ Events    │        │
│ └───────────┘  │    5      │ │    2      │ │   12      │        │
│                └───────────┘ └───────────┘ └───────────┘        │
│                                                                   │
│                ┌─────────────────────────────────────────────┐   │
│                │ Recent Tickets                              │   │
│                │ ┌─────────────────────────────────────────┐ │   │
│                │ │ 🎫 Concert XYZ - Feb 15 - Seat A-12     │ │   │
│                │ └─────────────────────────────────────────┘ │   │
│                │ ┌─────────────────────────────────────────┐ │   │
│                │ │ 🎫 Theater ABC - Mar 02 - Seat B-05     │ │   │
│                │ └─────────────────────────────────────────┘ │   │
│                └─────────────────────────────────────────────┘   │
│                                                                   │
│                ┌─────────────────────────────────────────────┐   │
│                │ Recent Payments                             │   │
│                │ ...                                         │   │
│                └─────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────┘
```

#### Mobile Layout (< 640px)

```
┌───────────────────────────┐
│ [☰]  Ticketing   [👤]     │
├───────────────────────────┤
│ Welcome, {Name}! 👋       │
│                           │
│ ┌─────────┐ ┌─────────┐  │
│ │ Active  │ │ Pending │  │
│ │    5    │ │    2    │  │
│ └─────────┘ └─────────┘  │
│                           │
│ ┌─────────────────────┐  │
│ │ Recent Tickets      │  │
│ │ ─────────────────── │  │
│ │ 🎫 Concert XYZ      │  │
│ │    Feb 15 - A-12    │  │
│ └─────────────────────┘  │
│                           │
├───────────────────────────┤
│ [🏠] [🎫] [💳] [👤]      │
│ Home  Tickets Pay Profile │
└───────────────────────────┘
```

## Data Migration Strategy

### Linking Existing Tickets to Users

1. **Match by Email**: Find all tickets where `user_email` matches a registered user
2. **Auto-create Users**: Optionally create user accounts for unregistered ticket holders
3. **Preserve Data**: Keep `user_email` and `user_name` as fallback for orphan tickets

```php
// Migration approach
public function up(): void
{
    // Step 1: Add columns
    Schema::table('tickets', function (Blueprint $table) {
        $table->foreignId('user_id')->nullable()->after('id')->constrained();
        $table->enum('payment_status', ['pending', 'confirmed'])->default('confirmed');
    });

    // Step 2: Link existing tickets to users by email
    DB::statement("
        UPDATE tickets t
        INNER JOIN users u ON t.user_email = u.email
        SET t.user_id = u.id
    ");
}
```

## Security Considerations

| Concern               | Mitigation                                            |
| --------------------- | ----------------------------------------------------- |
| **Brute Force**       | Rate limiting: 5 login attempts/minute, 3 reset/hour  |
| **Session Hijacking** | Secure cookies, HTTPS only, session regeneration      |
| **Data Access**       | Policy/Gate checks: users can only see their own data |
| **XSS Prevention**    | Blade's automatic escaping, CSP headers               |
| **CSRF**              | Laravel's built-in CSRF protection                    |

## Performance Considerations

| Concern                | Solution                                           |
| ---------------------- | -------------------------------------------------- |
| **Dashboard Load**     | Cache user stats for 5 minutes                     |
| **Ticket List**        | Pagination (12 per page), eager load relationships |
| **Barcode Display**    | Generate on-demand, cache rendered SVG/PNG         |
| **Mobile Performance** | Lazy loading images, minimal JS, skeleton loaders  |

## Testing Strategy

| Layer           | Approach                                                |
| --------------- | ------------------------------------------------------- |
| **Unit**        | Model relationships, payment calculations, status logic |
| **Feature**     | Auth flows, ticket access, payment filtering            |
| **Integration** | Email verification (if enabled), data migration script  |
| **Browser**     | Responsive layouts, barcode display, form validation    |

## Trade-offs & Decisions

| Decision                         | Rationale                                    |
| -------------------------------- | -------------------------------------------- |
| Blade + Alpine.js over SPA       | Simpler, matches existing admin, faster TTM  |
| Server-side auth over API tokens | Users access via browser only (MVP)          |
| Glass card UI matching admin     | Consistent brand, reuse existing CSS         |
| `user_id` nullable on tickets    | Backward compatibility with existing tickets |
| Separate `payments` table        | Flexibility for future payment gateway       |
