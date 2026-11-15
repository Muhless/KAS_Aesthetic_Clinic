Feature: Login

    As a clinic staff member
    I want to authenticate with my account
    So that I can access the clinic dashboard

    @smoke
    Scenario: Login with valid data
        Given user is on the login page
        When user login as admin
        Then user redirected to dashboard pages

    Scenario: Login with invalid data
        Given user is on the login page
        When user login as "admin" with password "admin123"
        Then error message "Username atau password salah." appear
        And user still in the login page

    Scenario: Login with unregistered username
        Given user is on the login page
        When user login as "user-tidak-ada" with password "password123"
        Then an error message appear
        And user still in the login page

    Scenario: Login with empty form
        Given user is on the login page
        When user submits the login form with empty credentials
        Then browser blocks the empty login form
        And user still in the login page

    Scenario Outline: Every role can login and is redirected to its home page
        Given user is on the login page
        When user login as the "<role>" account
        Then user is redirected to the "<route>" page

        Examples:
            | role    | route  |
            | admin   | /      |
            | dokter  | /nakes |
            | perawat | /      |
