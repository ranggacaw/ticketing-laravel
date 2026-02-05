## ADDED Requirements

### Requirement: Unique Barcode Generation
The system SHALL generate a unique barcode for every ticket record created.

#### Scenario: Barcode generation for new ticket
- **WHEN** a new ticket is saved in the database
- **THEN** the system SHALL generate a unique identifier and its corresponding QR/Code128 barcode

### Requirement: Scanner Compatibility
The generated barcodes MUST be compatible with standard QR and Code128 scanners, encoding the ticket's unique validation string.

#### Scenario: Scannability check
- **WHEN** a generated barcode is scanned
- **THEN** the output string SHALL match the ticket's unique validation record
