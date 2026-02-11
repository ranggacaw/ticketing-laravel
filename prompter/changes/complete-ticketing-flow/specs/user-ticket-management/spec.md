## ADDED Requirements

### Requirement: Show Ticket for Scanning

Users MUST be able to display a high-contrast, scannable version of their ticket on mobile devices.

#### Scenario: Open ticket for scanning

Given I am viewing my ticket details
When I click "Show for Scanning"
Then a high-contrast view with the QR/barcode appears
And the screen brightness is maximized (if supported)
And the screen is kept awake

### Requirement: Ticket Preview Card

Users MUST be able to generate a visual ticket card for sharing or saving.

#### Scenario: Share ticket card

Given I am viewing a ticket
When I click "Preview Ticket"
Then a visually styled ticket card is generated
And I can download it as an image

### Requirement: Post-Event Testimonials

Users MUST be able to leave testimonials for events they have attended.

#### Scenario: Leave a review

Given I attended an event in the past
When I open the ticket details
Then I see a "Leave Testimonial" button
And I can submit a rating and comment
And the testimonial is linked to the event
