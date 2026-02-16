## ADDED Requirements

### Requirement: Activity Log Data Model

The system SHALL maintain an `activity_logs` database table to store user activity records with the following schema:
- `id` (primary key)
- `user_id` (nullable foreign key to users table, SET NULL on delete)
- `action` (string, required) – the action type performed
- `resource_type` (string, nullable) – the model class name affected
- `resource_id` (integer, nullable) – the ID of the affected resource
- `description` (text, nullable) – human-readable description
- `metadata` (JSON, nullable) – additional context including before/after states
- `ip_address` (string, nullable) – client IP address (IPv4/IPv6)
- `user_agent` (text, nullable) – client browser/device information
- `created_at` (timestamp) – when the action occurred

The table SHALL have indexes on: `user_id`, `action`, `(resource_type, resource_id)`, and `created_at`.

#### Scenario: Activity log table exists with required columns
- **GIVEN** the database migrations have been executed
- **WHEN** the `activity_logs` table is inspected
- **THEN** all required columns exist with correct data types
- **AND** indexes are present for efficient querying

### Requirement: Activity Logger Service

The system SHALL provide an `ActivityLogger` service that creates activity log records with:
- The authenticated user's ID (or null for guest/system actions)
- The action type being performed
- Optional resource reference (type and ID)
- Optional metadata array
- Optional human-readable description
- The client's IP address (from request)
- The client's user agent (from request)

#### Scenario: Log creation with authenticated user
- **GIVEN** a user is authenticated
- **WHEN** `ActivityLogger::log('CREATE', $ticket, ['price' => 50000])` is called
- **THEN** an activity log record is created with the user's ID
- **AND** the record includes the resource type and ID
- **AND** the metadata contains the provided data
- **AND** the IP address and user agent are captured

#### Scenario: Log creation for guest/system action
- **GIVEN** no user is authenticated
- **WHEN** `ActivityLogger::log('LOGIN_FAILED', null, ['email' => 'test@test.com'])` is called
- **THEN** an activity log record is created with null user_id
- **AND** the metadata contains the provided data

### Requirement: Automatic Model Event Logging

The system SHALL provide a `LogsActivity` trait that, when applied to a model, automatically logs:
- `CREATE` action when a model is created (with full model data in metadata)
- `UPDATE` action when a model is updated (with before/after states in metadata)
- `DELETE` action when a model is deleted (with full model data in metadata)

#### Scenario: Ticket creation triggers activity log
- **GIVEN** the `Ticket` model uses the `LogsActivity` trait
- **WHEN** a new ticket is created
- **THEN** an activity log with action `CREATE` is recorded
- **AND** the resource_type is `App\Models\Ticket`
- **AND** the metadata contains the ticket's attribute values

#### Scenario: Ticket update triggers activity log with changes
- **GIVEN** the `Ticket` model uses the `LogsActivity` trait
- **WHEN** an existing ticket's price is updated from 50000 to 75000
- **THEN** an activity log with action `UPDATE` is recorded
- **AND** the metadata includes `before` with the original values
- **AND** the metadata includes `after` with the changed values

#### Scenario: User deletion triggers activity log
- **GIVEN** the `User` model uses the `LogsActivity` trait
- **WHEN** a user is deleted
- **THEN** an activity log with action `DELETE` is recorded
- **AND** the resource_type is `App\Models\User`
- **AND** the metadata contains the deleted user's attribute values

### Requirement: Authentication Event Logging

The system SHALL log authentication events:
- `LOGIN` when a user successfully authenticates
- `LOGOUT` when a user ends their session
- `LOGIN_FAILED` when an authentication attempt fails

#### Scenario: Successful login is logged
- **GIVEN** a user provides valid credentials
- **WHEN** they successfully authenticate
- **THEN** an activity log with action `LOGIN` is recorded
- **AND** the user_id matches the authenticated user
- **AND** the IP address and user agent are captured

#### Scenario: Logout is logged
- **GIVEN** a user is authenticated
- **WHEN** they log out
- **THEN** an activity log with action `LOGOUT` is recorded
- **AND** the user_id matches the logged-out user

#### Scenario: Failed login attempt is logged
- **GIVEN** a user provides invalid credentials
- **WHEN** authentication fails
- **THEN** an activity log with action `LOGIN_FAILED` is recorded
- **AND** the metadata includes the attempted email address
- **AND** the IP address is captured for security analysis

### Requirement: Ticket Scan Logging

The system SHALL log ticket validation (scan) actions with action type `SCAN`.

#### Scenario: Ticket scan is logged
- **GIVEN** a volunteer scans a ticket for validation
- **WHEN** the ticket is validated successfully
- **THEN** an activity log with action `SCAN` is recorded
- **AND** the resource references the scanned ticket
- **AND** the metadata includes the validation result

### Requirement: Supported Action Types

The system SHALL support the following action types:
- `CREATE` – resource was created
- `UPDATE` – resource was modified
- `DELETE` – resource was removed
- `SCAN` – ticket was scanned for validation
- `LOGIN` – user authenticated successfully
- `LOGOUT` – user session ended
- `LOGIN_FAILED` – failed authentication attempt
- `EXPORT` – data was exported

#### Scenario: Action type validation
- **GIVEN** the ActivityLogger service is used
- **WHEN** an activity is logged with any supported action type
- **THEN** the action type is stored correctly in the database
