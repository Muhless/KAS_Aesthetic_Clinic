Feature: Nurse management

    As an admin
    I want to manage the clinic's nurses
    So that the nurse list and their photos stay up to date

    Background:
        Given user already login

    @smoke
    Scenario: Nurse list is shown
        When admin opens the nurse page
        Then nurse list is shown

    Scenario: Add a new nurse
        When admin adds a nurse with valid data
        Then success message "Perawat berhasil ditambahkan." appear
        And the new nurse appears in the list

    Scenario: Add a new nurse with a photo
        When admin adds a nurse with a photo
        Then success message "Perawat berhasil ditambahkan." appear
        And the new nurse appears in the list
        And the new nurse photo is shown

    Scenario: Edit an existing nurse
        Given a nurse named "Nurse edit" exists
        When admin renames the nurse "Nurse edit" to "Nurse edit Updated"
        Then success message "Data perawat berhasil diperbarui." appear
        And nurse "Nurse edit Updated" appears in the list

    Scenario: Delete an existing nurse
        Given a nurse named "Nurse hapus" exists
        When admin deletes the nurse "Nurse hapus"
        Then success message "Perawat berhasil dihapus." appear
        And nurse "Nurse hapus" is no longer in the list
