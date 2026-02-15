# admin-payment-approval Specification

## Purpose
TBD - created by archiving change enhance-admin-payment-flow. Update Purpose after archive.
## Requirements
### Requirement: Admin Payment Review Interface
The system SHALL provide an admin interface at `/admin/payments` listing all payment records, with emphasis on pending payments awaiting approval.

#### Scenario: View pending payments
- **WHEN** admin navigates to the payments list
- **THEN** payments are displayed in a table showing invoice number, user name, amount, bank name, status, and submission date
- **AND** pending payments are shown first by default

#### Scenario: View payment detail
- **WHEN** admin clicks on a payment record
- **THEN** a detail page shows the full payment information including the uploaded proof image/document, sender bank details, and linked tickets

#### Scenario: View proof image
- **WHEN** admin opens a payment detail with an uploaded proof
- **THEN** the proof image is displayed inline (or a download link for PDF)
- **AND** the image can be clicked to view full-size

### Requirement: Approve Payment
An admin SHALL be able to approve a pending payment, confirming the transaction and activating the associated tickets.

#### Scenario: Approve pending payment
- **WHEN** admin clicks "Approve" on a pending payment
- **THEN** the payment status changes to `'confirmed'`
- **AND** `confirmed_at` is set to the current timestamp
- **AND** `confirmed_by` is set to the approving admin's user ID
- **AND** all linked tickets have their `payment_status` updated to `'confirmed'`

#### Scenario: Already confirmed payment
- **WHEN** admin attempts to approve a payment that is not in `'pending'` status
- **THEN** the system displays an error and no changes are made

### Requirement: Reject Payment
An admin SHALL be able to reject a pending payment with a stated reason, cancelling the associated tickets.

#### Scenario: Reject pending payment with reason
- **WHEN** admin clicks "Reject" on a pending payment and provides a rejection reason
- **THEN** the payment status changes to `'cancelled'`
- **AND** `rejection_reason` stores the admin's stated reason
- **AND** all linked tickets have their `payment_status` updated to `'cancelled'`
- **AND** ticket type inventory (`sold` count) is decremented to restore availability

#### Scenario: Reject without reason
- **WHEN** admin clicks "Reject" without providing a reason
- **THEN** the system requires a reason and does not process the rejection

#### Scenario: Already processed payment
- **WHEN** admin attempts to reject a payment that is not in `'pending'` status
- **THEN** the system displays an error and no changes are made

