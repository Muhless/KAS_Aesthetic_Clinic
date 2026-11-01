Feature: Reservation

    Scenario: Create new reservation
        Given User already in reservation pages
        When User create reservation for patient "Michael" with doctor "John" tomorrow
        Then successfully create reservation message appear
        And reservation appear in the table




