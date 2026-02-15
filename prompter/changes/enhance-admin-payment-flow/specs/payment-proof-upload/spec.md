## ADDED Requirements

### Requirement: Payment Proof Upload
The system SHALL require users to upload proof of payment (a screenshot or photo of the bank transfer receipt) during checkout. The proof file is stored server-side and linked to the payment record.

#### Scenario: Upload during checkout
- **WHEN** user completes ticket selection and bank selection
- **THEN** the checkout form requires a payment proof file upload before submission
- **AND** the form accepts JPG, PNG, and PDF files up to 2 MB

#### Scenario: File stored securely
- **WHEN** a proof file is uploaded
- **THEN** it is stored in `storage/app/public/payment-proofs/` with a unique filename
- **AND** the `payments.payment_proof_url` column records the relative storage path

#### Scenario: Invalid file rejected
- **WHEN** user uploads a file exceeding 2 MB or with a disallowed type
- **THEN** the form displays a validation error and the checkout is not processed

### Requirement: Pending Payment Status
Tickets created through checkout SHALL have `payment_status = 'pending'` until an admin approves the associated payment.

#### Scenario: Tickets created as pending
- **WHEN** a user successfully submits checkout with proof of payment
- **THEN** all tickets in the order are created with `payment_status = 'pending'`
- **AND** a `Payment` record is created with `status = 'pending'` linking the uploaded proof

#### Scenario: User sees pending status
- **WHEN** user views their tickets after checkout
- **THEN** each ticket displays a "Pending Verification" badge until the admin approves or rejects the payment
