Feature: Patient examination

    As a doctor
    I want to record the result of a patient examination
    So that the diagnosis, treatment, and products are saved for billing

    Background:
        Given user already login as "dokter"

    Scenario: Calling a patient reveals the Periksa action
        Given today's visit for patient "Pasien Periksa" with complaint "Kontrol rutin" is waiting for the doctor
        When doctor opens the nakes page
        Then patient "Pasien Periksa" has status "Menunggu"
        And patient "Pasien Periksa" has no "Periksa" action
        When doctor calls patient "Pasien Periksa"
        Then patient "Pasien Periksa" has status "Dipanggil"
        And patient "Pasien Periksa" has a "Periksa" action
        When doctor opens the examination form for patient "Pasien Periksa"
        Then examination form is shown for patient "Pasien Periksa"

    Scenario: Saving an examination with treatment and product
        Given today's visit for patient "Pasien Simpan" with complaint "Kulit kusam" is waiting for the doctor
        When doctor opens the nakes page
        And doctor calls patient "Pasien Simpan"
        And doctor opens the examination form for patient "Pasien Simpan"
        Then examination form is shown for patient "Pasien Simpan"
        And product "Produk E2E" is available in the examination form
        When doctor fills the examination with treatment "Treatment E2E", diagnosa "Hiperpigmentasi ringan", tindakan "Facial brightening", catatan "Kontrol 2 minggu lagi", and product "Produk E2E"
        And doctor saves the examination
        Then success message "Pemeriksaan berhasil disimpan." appear
        And patient "Pasien Simpan" has status "Selesai"
        And patient "Pasien Simpan" has a "Hasil" action
        When doctor opens the examination result for patient "Pasien Simpan"
        Then examination form is shown for patient "Pasien Simpan"
        And saved treatment is "Treatment E2E"
        And saved diagnosa is "Hiperpigmentasi ringan"
        And saved tindakan is "Facial brightening"
        And saved catatan is "Kontrol 2 minggu lagi"
        And saved product "Produk E2E" is checked

    Scenario: Examination data created through the API is ready to be examined
        Given a complete examination for patient "Pasien Api" is created through the API
        When doctor opens the examination edit url
        Then examination form is shown for patient "Pasien Api"
        And saved treatment is "Treatment E2E"
        And saved product "Produk E2E" is checked
        When doctor opens the nakes page
        Then patient "Pasien Api" has status "Dipanggil"
        And patient "Pasien Api" has a "Periksa" action
