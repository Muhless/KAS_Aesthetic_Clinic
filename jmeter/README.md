# JMeter - KAS Aesthetic Clinic

Performance test untuk alur utama aplikasi. Plan bersifat **read-only**: hanya
login, membuka halaman, dan logout, sehingga aman dijalankan terhadap database
development tanpa membuat/mengubah data.

## Isi

| File | Keterangan |
|---|---|
| `kas-clinic.jmx` | Test plan JMeter 5.6.3 |
| `run.sh` | Menjalankan plan non-GUI + membuat HTML report |
| `results/` | Output JTL dan HTML report (tidak di-commit) |

## Skenario

| Thread Group | Beban default | Yang diuji |
|---|---|---|
| `01 - Admin session` | 5 thread, ramp-up 5 s, 2 iterasi | login admin (CSRF + redirect), buka `/`, `/pasien`, `/dokter`, `/perawat`, `/produk`, `/treatment`, `/reservasi`, `/keuangan`, lalu logout |
| `02 - Doctor dashboard` | 3 thread, ramp-up 3 s, 2 iterasi | login dokter, redirect ke `/nakes`, buka dashboard dokter |
| `03 - Invalid login` | 1 thread, 1 iterasi | login dengan password salah harus menampilkan `Username atau password salah.` |

Setiap request punya assertion:

- response code `200`
- halaman terautentikasi tidak memuat judul halaman login
- login gagal menampilkan pesan error yang benar

CSRF token diambil otomatis dari halaman login (`_token`) dan dari meta tag
`csrf-token` untuk logout, jadi plan tetap valid meski token berubah.

## Prasyarat

1. Aplikasi berjalan, misalnya `php artisan serve --port=8001`.
2. Database sudah di-seed (akun `admin`, `dokter`, `perawat`).
3. JMeter 5.6.x terpasang dan ada di `PATH`.

## Menjalankan

```bash
# Default: http://localhost:8001
./jmeter/run.sh

# Override host/port dan beban
./jmeter/run.sh -Jhost=127.0.0.1 -Jport=8001 -Jthreads=10 -Jloops=3

# Uji cepat (1 thread, tanpa think time)
./jmeter/run.sh -Jthreads=1 -Jloops=1 -JdoctorThreads=1 -JdoctorLoops=1 -JthinkTime=0
```

Hasil:

- `jmeter/results/result.jtl` — data mentah per request
- `jmeter/results/html/index.html` — report HTML (throughput, latency, error rate)

## Properti yang bisa dioverride (`-J...`)

| Properti | Default | Keterangan |
|---|---|---|
| `protocol` | `http` | Skema URL |
| `host` | `localhost` | Host aplikasi |
| `port` | `8001` | Port aplikasi |
| `adminUsername` / `adminPassword` | `admin` / `password123` | Akun admin |
| `doctorUsername` / `doctorPassword` | `dokter` / `password123` | Akun dokter |
| `threads` / `rampUp` / `loops` | `5` / `5` / `2` | Beban thread group admin |
| `doctorThreads` / `doctorRampUp` / `doctorLoops` | `3` / `3` / `2` | Beban thread group dokter |
| `thinkTime` | `300` | Jeda antar request (ms) |

## Catatan

- `php artisan serve` memakai PHP built-in server yang default-nya satu worker.
  Hasil throughput lebih mencerminkan batas server dev, bukan kapasitas produksi.
  Untuk pengukuran yang representatif, arahkan plan ke Nginx/Apache + PHP-FPM:
  `./jmeter/run.sh -Jport=80`.
- Login memakai `bcrypt`, sehingga endpoint login memang lebih lambat daripada
  halaman biasa. Itu wajar dan terlihat terpisah di report per label.
- Plan tidak menguji upload file atau operasi tulis (CRUD) agar data development
  tidak tercemar. Untuk uji tulis, gunakan database testing terpisah.
