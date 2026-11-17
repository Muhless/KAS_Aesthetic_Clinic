#!/usr/bin/env bash
#
# Menjalankan performance test KAS Aesthetic Clinic dengan JMeter non-GUI.
# Semua argumen diteruskan ke JMeter, misalnya:
#
#   ./run.sh -Jthreads=10 -Jloops=3 -JdoctorThreads=5 -JthinkTime=500
#
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
RESULTS_DIR="${SCRIPT_DIR}/results"
JTL="${RESULTS_DIR}/result.jtl"
HTML="${RESULTS_DIR}/html"

mkdir -p "${RESULTS_DIR}"
rm -f "${JTL}"
rm -rf "${HTML}"

jmeter -n \
    -t "${SCRIPT_DIR}/kas-clinic.jmx" \
    -l "${JTL}" \
    -e -o "${HTML}" \
    "$@"

# JMeter's console summariser mengabaikan sample di dalam Transaction Controller
# (summariser.ignore_transaction_controller_sample_result=true), sehingga angka
# di console hanya menghitung request di luar transaksi. Ringkasan lengkap
# dihitung ulang dari JTL di sini.
if command -v python3 >/dev/null 2>&1; then
    python3 - "${JTL}" <<'PY'
import csv
import statistics
import sys

rows = list(csv.DictReader(open(sys.argv[1])))
if rows:
    elapsed = [int(row["elapsed"]) for row in rows]
    ordered = sorted(elapsed)
    failures = sum(1 for row in rows if row["success"] != "true")
    p90 = ordered[min(len(ordered) - 1, int(len(ordered) * 0.90))]

    print()
    print(f"Ringkasan : {len(rows)} sample, {failures} gagal "
          f"({failures / len(rows) * 100:.2f}%)")
    print(f"Latency   : avg {statistics.mean(elapsed):.0f} ms, "
          f"p90 {p90} ms, max {max(elapsed)} ms")
PY
fi

echo ""
echo "JTL    : ${JTL}"
echo "Report : ${HTML}/index.html"
