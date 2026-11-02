Feature: Login

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


