Feature: Doctor management

    As an admin
    I want to manage the clinic's doctors
    So that the doctor list stays up to date

    Background:
        Given user already login

    @smoke
    Scenario: Doctor list is shown
        When admin opens the doctor page
        Then doctor list is shown

    Scenario: Add a new doctor
        When admin adds a doctor with valid data
        Then success message "Dokter berhasil ditambahkan." appear
        And the new doctor appears in the list

    Scenario: Edit an existing doctor
        Given a doctor named "dr. Dokter Edit" exists
        When admin renames the doctor "dr. Dokter Edit" to "dr. Dokter Edit Updated"
        Then success message "Data dokter berhasil diperbarui." appear
        And doctor "dr. Dokter Edit Updated" appears in the list

    Scenario: Delete an existing doctor
        Given a doctor named "dr. Dokter Hapus" exists
        When admin deletes the doctor "dr. Dokter Hapus"
        Then success message "Dokter berhasil dihapus." appear
        And doctor "dr. Dokter Hapus" is no longer in the list
