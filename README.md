# KAS Aesthetic Clinic

Aplikasi manajemen klinik berbasis Laravel + Vite (Tailwind). Repo ini berisi
tiga lapis pengujian: **Pest** (unit/feature), **BDD Selenium** (Cucumber &
TestNG), dan **JMeter** (performance smoke).

Test Plan : <https://docs.google.com/document/d/1DUStQ_iYFjfxXdte6uxS0pxT_9S1uLsmIonhgMKc3Kg/edit?usp=sharing>
Test Case (Testiny): <https://app.testiny.io/p/1/testcases/tcf/4/tc/7>

## Prasyarat

- PHP 8.2+ dengan ekstensi `pdo_mysql`, `pdo_sqlite`, `mbstring`, `dom`, `gd`, `zip`
- Composer, Node.js 22+, MySQL/MariaDB
- Java 17 + Maven (untuk e2e), Chrome (untuk Selenium)
- JMeter 5.6.x (untuk performance test)

## Setup lokal

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run build        # atau `npm run dev` saat development
php artisan migrate --seed
php artisan serve    # http://127.0.0.1:8000
```

Akun hasil seeder: `admin`, `dokter`, `perawat` — password `password123`.

## Test Laravel (Pest)

```bash
php artisan test --compact
```

`phpunit.xml` memakai SQLite in-memory, jadi test tidak menyentuh database
development. Butuh ekstensi `pdo_sqlite`/`sqlite3`.

## Test BDD (Selenium)

Skenario Gherkin ada di `e2e/src/test/resources/features`, step definition di
`e2e/src/test/java/com/kas/steps`.

E2E **wajib** berjalan terhadap environment `testing`, karena setiap skenario
menjalankan `php artisan e2e:reset` yang mereset database `kas_test` (tidak akan
jalan jika `APP_ENV` bukan `testing`).

```bash
# 1. Siapkan environment testing
cp .env.testing.example .env.testing
# isi DB_PASSWORD sesuai MySQL lokal
php artisan key:generate --env=testing
php artisan migrate --env=testing --force

# 2. Jalankan aplikasi untuk e2e (port terpisah dari server dev)
#    Samakan APP_URL di .env.testing dengan port yang dipakai.
php artisan serve --env=testing --port=8002

# 3. Jalankan suite
cd e2e
mvn test -DbaseUrl=http://127.0.0.1:8002 -Dheadless=true           # Cucumber (49 skenario)
mvn test -Ptestng -DskipTests -DbaseUrl=http://127.0.0.1:8002 -Dheadless=true  # TestNG
```

Gunakan `-Dheadless=false` untuk melihat browser berjalan, atau
`-DresetDb=false` untuk mempertahankan isi database antar skenario.

Report:

- `e2e/target/surefire-reports` — hasil Cucumber
- `e2e/target/testng-output` — hasil TestNG
- `e2e/target/failure-artifacts` — screenshot/HTML saat test gagal

## Performance test (JMeter)

```bash
./jmeter/run.sh                                  # beban default
./jmeter/run.sh -Jthreads=1 -Jloops=1 -JthinkTime=0   # smoke cepat
```

Hasil di `jmeter/results/result.jtl` dan report HTML
`jmeter/results/html/index.html`. Detail skenario dan properti ada di
`jmeter/README.md`.

## CI (GitHub Actions)

| Workflow      | Trigger                   | Isi                                                                                           |
| ------------- | ------------------------- | --------------------------------------------------------------------------------------------- |
| `CI`          | PR, push `main`           | `composer validate`, Pint (non-blocking), build asset, Pest                                   |
| `E2E`         | PR, push `main`, manual   | MySQL 8.0 + server `testing`, Cucumber 49 skenario; TestNG via manual run (`run_testng=true`) |
| `Performance` | manual, nightly 01:00 WIB | JMeter smoke + artifact HTML report                                                           |

File environment tidak di-commit:

- `.env` — environment lokal
- `.env.testing` — environment uji; template di `.env.testing.example`

Di CI, `.env.testing` dibuat dari template lalu `APP_KEY` digenerate dan
kredensial MySQL diisi otomatis, jadi tidak ada secret yang perlu disimpan di
repo.
