Feature: Clinic finance

    As an admin
    I want to process patient payments and see the clinic's income
    So that every examination is billed and reported correctly

    Background:
        Given user already login

    Scenario: Finance page is empty when there is no data
        When admin opens the finance page
        Then finance income today is 0
        And finance income this month is 0
        And finance transaction count is 0
        And finance unpaid count is 0
        And payment table is empty
        And transaction history is empty
        And payment summary total is 0
        And payment summary count is 0
        And the print PDF button is shown

    Scenario: Unpaid payment appears in the payment table
        Given an unpaid payment for patient "Pasien Belum Bayar" exists
        When admin opens the finance page
        Then payment for "Pasien Belum Bayar" appears with status "Belum Bayar"
        And payment total for "Pasien Belum Bayar" is greater than 0
        And finance unpaid count is 1
        And finance transaction count is 0
        And finance income today is 0
        And transaction history is empty

    Scenario: Open payment detail
        Given an unpaid payment for patient "Pasien Detail" exists
        When admin opens the finance page
        And admin opens the payment detail for "Pasien Detail"
        Then payment detail is shown for "Pasien Detail"
        And payment detail total equals the payment total
        And payment detail status is "Belum Bayar"
        And the receipt button is not shown

    Scenario: Mark a payment as paid
        Given an unpaid payment for patient "Pasien Lunas" exists
        When admin opens the finance page
        And admin opens the payment detail for "Pasien Lunas"
        And admin fills the payment note "Dibayar tunai di kasir" and marks it as paid
        Then success message "Pembayaran berhasil diproses." appear
        And payment detail status is "Lunas"
        And payment detail method is "cash"
        And the receipt button is shown

    Scenario: Payment note is saved
        Given an unpaid payment for patient "Pasien Catatan" exists
        When admin opens the finance page
        And admin opens the payment detail for "Pasien Catatan"
        And admin fills the payment note "Dibayar tunai di kasir" and marks it as paid
        Then payment note is "Dibayar tunai di kasir"

    Scenario: Statistics and summary are updated after payment
        Given an unpaid payment for patient "Pasien Statistik" exists
        When admin opens the finance page
        And admin opens the payment detail for "Pasien Statistik"
        And admin fills the payment note "Dibayar tunai di kasir" and marks it as paid
        And admin opens the finance page
        Then finance income today equals the payment total
        And finance income this month equals the payment total
        And finance transaction count is 1
        And finance unpaid count is 0
        And payment summary total equals the payment total
        And payment summary count is 1
        And payment summary average equals the payment total

    Scenario: Transaction history shows paid payments
        Given an unpaid payment for patient "Pasien Riwayat" exists
        When admin opens the finance page
        And admin marks the payment for "Pasien Riwayat" as paid
        Then transaction history shows "Pasien Riwayat" with method "Cash" and the payment total

    Scenario: Multiple payments are counted correctly
        Given an unpaid payment for patient "Pasien Lunas Satu" exists
        And an unpaid payment for patient "Pasien Belum Satu" exists
        And an unpaid payment for patient "Pasien Belum Dua" exists
        When admin opens the finance page
        And admin marks the payment for "Pasien Lunas Satu" as paid
        Then payment table shows 3 payments
        And payment for "Pasien Belum Satu" appears with status "Belum Bayar"
        And payment for "Pasien Belum Dua" appears with status "Belum Bayar"
        And finance transaction count is 1
        And finance unpaid count is 2
        And finance income this month equals the total of "Pasien Lunas Satu"
