Feature: Doctor dashboard

    As a doctor
    I want to see today's patient queue
    So that I can call and examine the next patient

    Background:
        Given user already login as "dokter"

    Scenario: Doctor sees their own greeting
        When doctor opens the nakes page
        Then nakes page shows greeting for "John"

    Scenario: No patient today shows the empty state
        When doctor opens the nakes page
        Then no patient is waiting today

    Scenario: Today's visit appears in the patient table
        Given today's visit for patient "Pasien Nakes" with complaint "Demam" is waiting for the doctor
        When doctor opens the nakes page
        Then patient "Pasien Nakes" appears in the patient table
        And patient "Pasien Nakes" has complaint "Demam"
        And patient "Pasien Nakes" has status "Menunggu"
        And waiting patient count is 1

    Scenario: Calling a patient changes the visit status
        Given today's visit for patient "Pasien Panggil" with complaint "Kontrol" is waiting for the doctor
        When doctor opens the nakes page
        And doctor calls patient "Pasien Panggil"
        Then patient "Pasien Panggil" has status "Dipanggil"
        And waiting patient count is 0
        And called patient count is 1

    Scenario: Visit without a doctor is not shown
        Given today's visit for patient "Pasien Tanpa Dokter" is registered without a doctor
        When doctor opens the nakes page
        Then patient "Pasien Tanpa Dokter" does not appear in the patient table
        And no patient is waiting today
