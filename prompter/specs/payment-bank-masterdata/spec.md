# payment-bank-masterdata Specification

## Purpose
TBD - created by archiving change enhance-admin-payment-flow. Update Purpose after archive.
## Requirements
### Requirement: Bank Master Data
The system SHALL maintain a `banks` master table containing destination bank account information for manual transfer payments. The table is seeded with a predefined list of Indonesian banks.

#### Scenario: Seeded bank list
- **WHEN** the `BankSeeder` is executed
- **THEN** the `banks` table contains at least the following entries: BCA, Mandiri, BNI, BRI, BSI, CIMB Niaga
- **AND** each entry includes an account name, account number, and bank code

#### Scenario: Bank selection at checkout
- **WHEN** a user proceeds to checkout
- **THEN** the system presents the list of active banks (`is_active = true`) for the user to select as the transfer destination

#### Scenario: Inactive bank hidden
- **WHEN** a bank record has `is_active = false`
- **THEN** it does not appear in the user-facing bank selection list

### Requirement: Payment Bank Reference
Each payment record SHALL reference the bank selected by the user, along with the sender's account details.

#### Scenario: Payment stores bank details
- **WHEN** a payment is created during checkout
- **THEN** the payment record stores the selected `bank_id`, the sender's account name, and the sender's account number

#### Scenario: Payment bank displayed to admin
- **WHEN** admin views a payment record
- **THEN** the selected bank name, sender account name, and sender account number are visible

