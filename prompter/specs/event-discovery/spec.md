# event-discovery Specification

## Purpose
TBD - created by archiving change implement-user-event-discovery. Update Purpose after archive.
## Requirements
### Requirement: Browse Published Events

The system MUST display a public catalog of events that are marked as `PUBLISHED`.

#### Scenario: User visits the events page

- **Given** there are `PUBLISHED` events in the database
- **And** there are `DRAFT` events in the database
- **When** the user visits `/events`
- **Then** they see a list of the `PUBLISHED` events only
- **And** each event card shows the Event Name, Start Date, Venue Name, and "Starting At" price (lowest ticket type price).

#### Scenario: Empty state

- **Given** there are no `PUBLISHED` events
- **When** the user visits `/events`
- **Then** they see a friendly "No upcoming events" message.

### Requirement: View Event Details

The system MUST provide a detailed view for each event, accessible via a unique URL slug.

#### Scenario: User views event details

- **Given** a published event "Summer Fest" with slug `summer-fest`
- **When** the user visits `/events/summer-fest`
- **Then** they see the full Event Description
- **And** they see the Venue Name and Address
- **And** they see the Organizer Name
- **And** they see a list of available Ticket Types with prices.

### Requirement: SEO Friendly URLs

Routes MUST use the event `slug` instead of `id`.

#### Scenario: Assessing URL structure

- **Given** an event
- **When** the link is generated
- **Then** it follows the format `/events/{slug}`.

