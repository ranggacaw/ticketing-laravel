# Spec: Payment History

## Overview

Allow users to view their payment history, including detailed breakdowns of each transaction.

---

## ADDED Requirements

### Requirement: Payment History List

Users SHALL be able to view a list of all their payments.

#### Scenario: View payment history

- **WHEN** a user navigates to `/user/payments`
- **THEN** they see all payments associated with their account
- **AND** payments sorted by date (newest first)
- **AND** each shows: invoice number, date, amount, status badge

#### Scenario: Filter payments by status

- **WHEN** user selects status filter (Confirmed, Pending, Cancelled)
- **THEN** only payments with matching status are shown

#### Scenario: Empty payment history

- **WHEN** a user has no payments
- **THEN** empty state illustration shown
- **AND** message: "No payment history found"

---

### Requirement: Payment Detail View

Users SHALL be able to view comprehensive payment information.

#### Scenario: View payment details

- **WHEN** user clicks on a payment from the list
- **THEN** they see: invoice number, date, amount, status, associated tickets

#### Scenario: View associated tickets

- **WHEN** payment is linked to tickets
- **THEN** each ticket is listed with: event name, seat, type, price
- **AND** clicking ticket navigates to ticket detail

---

### Requirement: Payment Status Badges

Payment status SHALL be displayed with visual indicators.

#### Scenario: Pending payment badge

- **WHEN** payment has `status='pending'`
- **THEN** yellow "Pending" badge with clock icon is shown

#### Scenario: Confirmed payment badge

- **WHEN** payment has `status='confirmed'`
- **THEN** green "Confirmed" badge with checkmark is shown

#### Scenario: Cancelled payment badge

- **WHEN** payment has `status='cancelled'`
- **THEN** red "Cancelled" badge with X icon is shown

---

### Requirement: Payment Authorization

Users SHALL only be able to view payments associated with their account.

#### Scenario: View own payment

- **WHEN** user accesses a payment associated with their account
- **THEN** payment details are displayed

#### Scenario: Access other user payment

- **WHEN** user accesses a payment not associated with their account
- **THEN** 403 Forbidden error is returned

---

## Technical Notes

- Routes: `GET /user/payments`, `GET /user/payments/{payment}`
- Controller: `User\PaymentController`
- Policy: `PaymentPolicy@view` checks `$payment->user_id === $user->id`
