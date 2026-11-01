Feature: Login
As 
    @smoke
    Scenario: Login with valid data
        Given user is on the login page
        When user login as admin
        Then user redirected to dashboard pages
