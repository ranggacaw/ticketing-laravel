## ADDED Requirements

### Requirement: Venue Management

Admins MUST be able to create, read, update, and delete Venues.

#### Scenario: Create a new venue

Given I am an admin on the venues page
When I click "Create Venue"
And fill in name, address, and capacity
Then the venue is saved and listed

### Requirement: Organizer Management

Admins MUST be able to create, read, update, and delete Organizers.

#### Scenario: Add a new organizer profile

Given I am an admin on the organizers page
When I enter the organizer details (name, email)
Then the organizer is created for future event assignment

### Requirement: Event Management

Admins MUST be able to create full Event records including dates, venue, and organizer.

#### Scenario: Create an event linked to venue and organizer

Given I am on the event creation page
When I select a venue and organizer
And set the event dates and description
Then the event is created in draft status

### Requirement: Ticket Type Management

Admins MUST be able to manage ticket types for specific events.

#### Scenario: Add ticket types to an event

Given I am editing an event
When I add a "VIP" ticket type with price and quantity
Then the ticket type is associated with that event

### Requirement: Seat Management

Admins MUST be able to define seat layouts for venues.

#### Scenario: Define seat layout

Given I am managing a venue
When I add seats with section, row, and number
Then these seats become available for event assignment
