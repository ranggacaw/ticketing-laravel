## Context

The ticketing application currently operates in "MVP simulator" mode where checkout immediately confirms payment. This change introduces a manual bank-transfer payment workflow with admin oversight, plus several admin-facing quality-of-life features (dashboard filters, event participants list, barcode uniqueness). The changes span the checkout flow, admin panel, database schema, and file storage.

### Stakeholders
- **Admin / Staff**: Need filtering, participant visibility, and payment approval tools.
- **User (Attendee)**: Needs to select a bank, upload proof, and wait for confirmation.

## Goals / Non-Goals

### Goals
- Provide admin-side filtering on the dashboard tickets table.
- Let admins see which users purchased tickets for each event.
- Guarantee 1 barcode = 1 ticket at the database level.
- Introduce bank-transfer payment flow: bank selection → proof upload → admin approval.
- Keep the implementation minimal and consistent with existing patterns (DaisyUI v5, Blade, Alpine.js).

### Non-Goals
- Payment gateway integration (Stripe, Midtrans) — deferred to roadmap.
- Real-time push notifications when payment is approved/rejected.
- Automatic payment verification (OCR on proof images).
- Refactoring the checkout into a multi-step wizard — keep changes to the existing single-page flow.

## Decisions

### 1. Bank Masterdata — Static Seeder
**Decision**: Store banks in a `banks` DB table populated by a Laravel seeder.
**Alternatives considered**:
- External API (Flip, Xendit) — adds runtime dependency and network latency; overkill for a static list.
- Config file / enum — harder to extend, no admin UI path.
**Rationale**: A seeded table is queryable, extendable by admin later, and follows the existing master-data CRUD pattern.

### 2. Payment Flow — In-Checkout Upload
**Decision**: Users upload proof of payment during checkout. Tickets are created with `payment_status = 'pending'`.
**Alternatives considered**:
- Post-checkout upload — worse UX, user might forget, harder to link proof to tickets.
**Rationale**: Single flow reduces drop-off and ensures every order has a proof attached from the start.

### 3. Barcode Uniqueness — UUID-Based + Unique Constraint
**Decision**: Use the ticket's UUID directly as `barcode_data` (already unique) and add a unique index on `tickets.barcode_data`.
**Alternatives considered**:
- Keep the CRC32-based `formatBarcodeData` — can collide on different UUIDs (birthday-problem territory at scale).
- Random string — no determinism.
**Rationale**: UUID is already guaranteed unique per ticket. Keeping it as barcode data simplifies the system and satisfies "1 barcode = 1 ticket". The `BarcodeService::formatBarcodeData` will be updated to produce a deterministic short code derived from UUID + ticket ID to avoid CRC32 collisions.

### 4. File Storage — Local Disk (public)
**Decision**: Store proof images in `storage/app/public/payment-proofs/`.
**Rationale**: Consistent with existing storage patterns. `storage:link` is already documented as a setup step. Can switch to S3 later via filesystem config.

### 5. Dashboard Filtering — Server-Side with Query Params
**Decision**: Filter with GET query parameters; re-render Blade view with filtered data.
**Alternatives considered**:
- Alpine.js client-side filtering — limited to current page, doesn't scale with pagination.
- Livewire — adds a new dependency not in the stack.
**Rationale**: GET params are simple, bookmarkable, and work with existing pagination.

## Data Model Changes

### New Table: `banks`
| Column | Type | Notes |
|--------|------|-------|
| id | bigint PK | |
| name | string(100) | e.g. "Bank Central Asia (BCA)" |
| code | string(20) unique | e.g. "BCA" |
| logo_url | string(500) nullable | optional bank logo |
| account_name | string(255) | destination account holder |
| account_number | string(50) | destination account number |
| is_active | boolean default true | soft toggle |
| timestamps | | |

### Altered Table: `payments`
| Column | Change | Notes |
|--------|--------|-------|
| bank_id | ADD FK nullable | references `banks.id` |
| sender_account_name | ADD string nullable | payer's name on transfer |
| sender_account_number | ADD string nullable | payer's account number |
| rejection_reason | ADD text nullable | reason if admin rejects |

### Altered Table: `tickets`
| Column | Change | Notes |
|--------|--------|-------|
| barcode_data | ADD unique index | enforce 1:1 barcode-ticket |

## Risks / Trade-offs

- **Risk**: Changing `payment_status` default from `'confirmed'` to `'pending'` affects any existing e2e tests.
  → **Mitigation**: Update test fixtures; guard with feature flag if needed.
- **Risk**: Existing tickets have non-unique `barcode_data` from CRC32.
  → **Mitigation**: Migration backfills unique values before adding the unique index.
- **Risk**: Large proof uploads could slow checkout.
  → **Mitigation**: Enforce 2 MB max, validate mime types server-side.

## Migration Plan

1. Run new migrations (banks, alter payments, alter tickets) — additive, no destructive changes.
2. Run `BankSeeder` to populate initial bank data.
3. Backfill `barcode_data` on any tickets where it's null or colliding.
4. Add unique index on `tickets.barcode_data`.
5. Update `CheckoutController` to create pending payments with proof upload.
6. Deploy admin payment views and routes.

Rollback: Migrations are reversible. Dropping `banks` table and removing added columns restores previous state. The unique index can be dropped independently.

## Open Questions

None — all ambiguous points resolved during proposal review.
