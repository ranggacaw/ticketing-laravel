# Technical Documentation: Internal Barcode Generation System

## Overview
This document provides technical details on the barcode generation logic, symbology, and verification procedures for the internal ticketing system.

## Barcode Symbology
The system supports two primary barcode symbologies to ensure compatibility with various scanning hardware:

### 1. QR Code (Matrix 2D)
- **Library**: `simplesoftwareio/simple-qrcode`
- **Data Capacity**: High (up to 4296 alphanumeric characters).
- **Redundancy**: Level L (7%) error correction.
- **Usage**: Primary validation method for modern camera-based scanners and mobile validators.

### 2. Code 128 (Linear 1D)
- **Library**: `milon/barcode`
- **Subset**: Subset C (Numeric optimized) or Auto.
- **Usage**: Secondary validation method for legacy laser-based handheld scanners.

## Data Structure
The encoded data string follows a deterministic pattern derived from the ticket's UUID to ensure consistency and prevent collisions.

- **Pattern**: `TICKET-[4-digit-hash]-[4-digit-hash]`
- **Generation Logic**: 
  1. Take the ticket's unique UUID.
  2. Compute a `CRC32` checksum of the UUID.
  3. Format the checksum as an 8-digit numeric string.
  4. Segment the string into two groups for readability.

Example: `TICKET-8234-5678`

## Verification Procedure
To ensure 100% compatibility with external scanners:

1. **Size Verification**:
   - QR codes should be printed at a minimum of 2cm x 2cm.
   - Code 128 barcodes should be at least 3cm wide for laser scanners.
2. **Contrast Check**:
   - Barcodes must be printed in high-contrast (Black on White).
   - Quiet zones (margin around the barcode) must be respected (min 5px).
3. **Integration Test**:
   - The system encodes a hash that must match the `barcode_data` field in the database.
   - The validation endpoint `/validate` accepts both the raw UUID and the generated barcode string.

## Database Integration
| Field | Type | Description |
|---|---|---|
| `uuid` | UUID | Primary unique identifier. |
| `barcode_data` | String | The human-readable string encoded in the barcode. |
| `scanned_at` | Timestamp | Recorded when the ticket is successfully validated. |

## Troubleshooting
- **Scan Failure (QR)**: Check for printing blur or low resolution. Use `DomPDF` with high-quality SVG embedding.
- **Scan Failure (1D)**: Ensure the barcode is not truncated. Increase width in the `BarcodeService` or CSS.
- **Mismatch**: Verify that the `barcode_data` in the database matches the literal string output of the scanner.
