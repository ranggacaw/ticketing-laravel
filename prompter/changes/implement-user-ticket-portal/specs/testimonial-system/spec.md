# Spec: Testimonial System

## Overview

Enable users to submit testimonials and ratings for events they have attended, providing social proof and feedback.

## ADDED Requirements

### Requirement: Submit Testimonial

Users SHALL be able to submit a testimonial for a past event ticket.

#### Scenario: Write Review Button Visibility

- **GIVEN** a user is viewing a "Past" ticket
- **AND** no testimonial has been submitted for this ticket
- **THEN** a "Write Review" button is displayed

#### Scenario: Submit Review Form

- **WHEN** user clicks "Write Review"
- **THEN** a form modal/page appears
- **AND** user can select a rating (1-5 stars)
- **AND** user can enter a text comment (optional/mandatory)
- **AND** user can submit the form

#### Scenario: Successful Submission

- **WHEN** user submits a valid review
- **THEN** the review is saved to the database
- **AND** user sees a success message
- **AND** the "Write Review" button is replaced with "Review Submitted"

### Requirement: View My Testimonials

Users SHALL be able to see their submitted testimonials.

#### Scenario: View Submitted Review

- **GIVEN** user has submitted a review for a ticket
- **WHEN** user views the ticket details
- **THEN** they see their rating and comment displayed instead of the form

#### Scenario: Prevent Duplicate Reviews

- **WHEN** user tries to submit a second review for the same ticket
- **THEN** an error message is displayed (or form is disabled)

## Technical Notes

- **Table**: `testimonials` (id, user_id, ticket_id, event_id, rating, comment, timestamps)
- **Model**: `Testimonial` belongsTo `User`, `Ticket`, `Event`.
- **Policy**: `TestimonialPolicy` ensures user can only review their own tickets.
