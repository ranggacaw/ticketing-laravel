## ADDED Requirements

### Requirement: User Activity Timeline

Users MUST see a consolidated timeline of all their interactions with the platform.

#### Scenario: View all past interactions

Given I am logged in as a user
When I visit the "My Activity" page
Then I see a chronological list of my purchases, event check-ins, and reviews
And each item distinguishes its type clearly (e.g., icons)
