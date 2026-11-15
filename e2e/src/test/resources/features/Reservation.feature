Feature: Reservation

    As an admin
    I want to register a reservation for a patient
    So that the patient gets a schedule with the chosen doctor

    Scenario: Create new reservation
        Given user already login
        And User already in reservation pages
        When User create reservation for patient "Michael" with doctor "John" tomorrow
        Then successfully create reservation message appear
        And reservation appear in the table
