Feature: Patient management

    As an admin
    I want to manage patient data
    So that every visit can be registered to the right patient

    Background:
        Given user already login

    @smoke
    Scenario: Patient list is shown
        When admin opens the patient page
        Then patient list is shown

    Scenario: Add a new patient
        When admin adds a patient with valid data
        Then success message "Pasien berhasil ditambahkan." appear
        And the new patient appears in the list

    Scenario: Edit an existing patient
        Given a patient named "Pasien Edit" exists
        When admin renames the patient "Pasien Edit" to "Pasien Edit Updated"
        Then success message "Data pasien berhasil diperbarui." appear
        And patient "Pasien Edit Updated" appears in the list

    Scenario: Delete an existing patient
        Given a patient named "Pasien Hapus" exists
        When admin deletes the patient "Pasien Hapus"
        Then success message "Data pasien berhasil dihapus." appear
        And patient "Pasien Hapus" is no longer in the list
