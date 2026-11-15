Feature: Product management

    As an admin
    I want to manage the clinic's products
    So that treatment products and their stock are always accurate

    Background:
        Given user already login

    @smoke
    Scenario: Product list is shown
        When admin opens the product page
        Then product list is shown

    Scenario: Add a new product
        When admin adds a new product
        Then success message "Produk berhasil ditambahkan." appear
        And product "Produk Baru" appears in the list

    Scenario: Adding a product without required fields shows validation errors
        When admin opens the add product form and submits it empty
        Then validation error message appear

    Scenario: Edit an existing product
        When admin renames the product "Produk E2E" to "Produk Edit"
        Then success message "Produk berhasil diperbarui." appear
        And product "Produk Edit" appears in the list

    Scenario: Delete an existing product
        When admin deletes the product "Produk E2E"
        Then success message "Produk berhasil dihapus." appear
        And product "Produk E2E" is no longer in the list

    Scenario: Filter products by name
        When admin filters products by name "Produk E2E"
        Then only product "Produk E2E" is shown

    Scenario: Filter products with no result shows the empty state
        When admin filters products by name "Produk Tidak Ada"
        Then product empty state is shown

    Scenario: Filter products with low stock
        When admin adds a low stock product "Produk Stok Menipis"
        And admin filters products with low stock
        Then product "Produk Stok Menipis" appears in the list
