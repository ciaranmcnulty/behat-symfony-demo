@javascript
Feature: Scheduling a training course

  As a trainer
  In order to be able to cancel courses or schedule new ones
  I should be able to specify a maximum and minimum class size

  Rules:
    - Course is proposed with size limits
    - When enough enrolments happen, course is considered viable
    - When maximum class size is reached, further enrolments are not allowed

  Background:
    Given "BDD for Beginners" was proposed with a class size of 2 to 3 people

  Scenario: Course does not get enough enrolments to be viable
    When only Alice enrols on this course
    Then this course will not be viable

  Scenario: Course gets enough enrolments to be viable
    Given Alice has already enrolled on this course
    When Bob enrols on this course
    Then this course will be viable

  Scenario: Enrolments are stopped when class size is reached
    Given Alice, Bob and Charlie have already enrolled on this course
    When Derek tries to enrol on this course
    Then he should not be able to enrol

