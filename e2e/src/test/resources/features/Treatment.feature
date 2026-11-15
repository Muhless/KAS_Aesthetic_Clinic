Feature: Treatment management

    As an admin
    I want to manage the clinic's treatments
    So that the treatment catalogue matches the services offered

    Background:
        Given user already login

    @smoke
    Scenario: Treatment list is shown
        When admin opens the treatment page
        Then treatment list is shown

    Scenario: Add a new treatment
        When admin adds a new treatment
        Then success message "Treatment berhasil ditambahkan." appear
        And treatment "New Treatment" appears in the list

    Scenario: Edit an existing treatment
        Given a treatment named "Treatment Edit" exists
        When admin renames the treatment "Treatment Edit" to "Treatment Edit Updated"
        Then success message "Treatment berhasil diubah." appear
        And treatment "Treatment Edit Updated" appears in the list

    Scenario: Delete an existing treatment
        Given a treatment named "Treatment Hapus" exists
        When admin deletes the treatment "Treatment Hapus"
        Then success message "Treatment berhasil dihapus." appear
        And treatment "Treatment Hapus" is no longer in the list
