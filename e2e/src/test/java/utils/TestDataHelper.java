package utils;

import java.io.File;
import java.io.IOException;
import java.nio.charset.StandardCharsets;
import java.nio.file.Files;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.HashMap;
import java.util.Map;

import org.mindrot.jbcrypt.BCrypt;

public class TestDataHelper {

   
    private static final String[] DATABASE = bacaDatabaseDariEnv();

    public static final String DOKTER_USERNAME = "dokter_test";
    public static final String DOKTER_PASSWORD = "password123";

    /**
     * ID hasil insert, dipakai test untuk membuka halaman tertentu.
     */
    public static class Data {

        public long dokterUserId, dokterId, pasienId, produkId, treatmentId;
        public long reservasiId, pelayananId, pemeriksaanId, pembayaranId;
    }

    private static Connection getConnection() throws SQLException {
        return DriverManager.getConnection(DATABASE[0], DATABASE[1], DATABASE[2]);
    }

    private static String[] bacaDatabaseDariEnv() {
        Map<String, String> env = new HashMap<>();
        File envFile = new File(cariProjectRoot(), ".env.testing");

        if (envFile.isFile()) {
            try {
                for (String line : Files.readAllLines(envFile.toPath(), StandardCharsets.UTF_8)) {
                    String trimmed = line.trim();
                    if (trimmed.isEmpty() || trimmed.startsWith("#") || !trimmed.contains("=")) {
                        continue;
                    }

                    int separator = trimmed.indexOf('=');
                    String key = trimmed.substring(0, separator).trim();
                    String value = trimmed.substring(separator + 1).trim();

                    if (value.length() >= 2
                            && ((value.startsWith("\"") && value.endsWith("\""))
                                    || (value.startsWith("'") && value.endsWith("'")))) {
                        value = value.substring(1, value.length() - 1);
                    }

                    env.putIfAbsent(key, value);
                }
            } catch (IOException e) {
                throw new IllegalStateException("Gagal membaca .env.testing", e);
            }
        }

        String host = System.getProperty("dbHost", env.getOrDefault("DB_HOST", "127.0.0.1"));
        String port = System.getProperty("dbPort", env.getOrDefault("DB_PORT", "3306"));
        String database = System.getProperty("dbName", env.getOrDefault("DB_DATABASE", "kas_test"));
        String user = System.getProperty("dbUser", env.getOrDefault("DB_USERNAME", "root"));
        String password = System.getProperty("dbPassword", env.getOrDefault("DB_PASSWORD", ""));

        return new String[] {"jdbc:mysql://" + host + ":" + port + "/" + database, user, password};
    }

    private static File cariProjectRoot() {
        File dir = new File(System.getProperty("user.dir")).getAbsoluteFile();

        while (dir != null && !new File(dir, "artisan").isFile()) {
            dir = dir.getParentFile();
        }

        return dir != null ? dir : new File(System.getProperty("user.dir"));
    }

    private static long insert(Connection conn, String sql, Object... params) throws SQLException {
        try (PreparedStatement ps = conn.prepareStatement(sql, Statement.RETURN_GENERATED_KEYS)) {
            for (int i = 0; i < params.length; i++) {
                ps.setObject(i + 1, params[i]);
            }
            ps.executeUpdate();
            try (ResultSet rs = ps.getGeneratedKeys()) {
                rs.next();
                return rs.getLong(1);
            }
        }
    }

    // Laravel hanya menerima prefix $2y$, sedangkan jBCrypt menghasilkan $2a$
    private static String laravelHash(String plain) {
        return BCrypt.hashpw(plain, BCrypt.gensalt(10)).replaceFirst("^\\$2a\\$", "\\$2y\\$");
    }

    /**
     * Kosongkan semua tabel data klinik. Tabel users (admin/perawat) tidak
     * disentuh.
     */
    public static void cleanAll() {
        String[] tables = {
            "pembayaran_items", "pembayarans", "pemeriksaan_produk", "pemeriksaans",
            "pelayanans", "reservasis", "treatments", "produks", "pasiens", "dokters"
        };
        try (Connection conn = getConnection(); Statement st = conn.createStatement()) {
            st.execute("SET FOREIGN_KEY_CHECKS = 0");
            for (String t : tables) {
                st.execute("TRUNCATE TABLE " + t);
            }
            st.execute("DELETE FROM users WHERE username = '" + DOKTER_USERNAME + "'");
            st.execute("SET FOREIGN_KEY_CHECKS = 1");
        } catch (SQLException e) {
            throw new RuntimeException("Gagal membersihkan data", e);
        }
    }

    /**
     * Kondisi: pasien sudah reservasi dan masuk antrian (status 'menunggu').
     * Dokter belum membuat pemeriksaan. Cocok untuk test alur dokter memeriksa.
     */
    public static Data seedAntrianMenunggu() {
        Data d = new Data();
        try (Connection conn = getConnection()) {
            d.dokterUserId = insert(conn,
                    "INSERT INTO users (username, password, role, created_at, updated_at) VALUES (?, ?, 'dokter', NOW(), NOW())",
                    DOKTER_USERNAME, laravelHash(DOKTER_PASSWORD));

            d.dokterId = insert(conn,
                    "INSERT INTO dokters (user_id, nama, no_telepon, email, spesialis, biaya_konsultasi, created_at, updated_at) "
                    + "VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())",
                    d.dokterUserId, "dr. Ayu Lestari", "081200000001", "ayu@kas.test", "Dermatologi", 100000);

            d.pasienId = insert(conn,
                    "INSERT INTO pasiens (nama, jenis_kelamin, nomor_telepon, tanggal_lahir, created_at, updated_at) "
                    + "VALUES (?, ?, ?, ?, NOW(), NOW())",
                    "Siti Aminah", "P", "081234567890", "1995-04-12");

            d.produkId = insert(conn,
                    "INSERT INTO produks (nama, kategori, deskripsi, harga, stok, status, created_at, updated_at) "
                    + "VALUES (?, ?, ?, ?, ?, 'tersedia', NOW(), NOW())",
                    "Serum Vitamin C", "Skincare", "Serum pencerah wajah", 150000, 50);

            d.treatmentId = insert(conn,
                    "INSERT INTO treatments (nama, deskripsi, harga, durasi, status, created_at, updated_at) "
                    + "VALUES (?, ?, ?, ?, 'tersedia', NOW(), NOW())",
                    "Facial Brightening", "Perawatan wajah mencerahkan", 300000, 60);

            d.reservasiId = insert(conn,
                    "INSERT INTO reservasis (user_id, pasien_id, dokter_id, tanggal, status, created_at, updated_at) "
                    + "VALUES (?, ?, ?, CURDATE(), 'diproses', NOW(), NOW())",
                    d.dokterUserId, d.pasienId, d.dokterId);

            d.pelayananId = insert(conn,
                    "INSERT INTO pelayanans (pasien_id, dokter_id, reservasi_id, tanggal, nomor_antrian, status, keluhan, created_at, updated_at) "
                    + "VALUES (?, ?, ?, CURDATE(), 1, 'menunggu', ?, NOW(), NOW())",
                    d.pasienId, d.dokterId, d.reservasiId, "Kulit kusam dan berjerawat");

            return d;
        } catch (SQLException e) {
            throw new RuntimeException("Gagal menyiapkan data antrian", e);
        }
    }

    /**
     * Kondisi: dokter sudah memeriksa, ada treatment + produk, dan tagihan
     * belum dibayar. Cocok untuk test halaman keuangan / pembayaran.
     */
    public static Data seedPemeriksaanDenganTagihan() {
        Data d = seedAntrianMenunggu();
        try (Connection conn = getConnection()) {
            try (PreparedStatement ps = conn.prepareStatement(
                    "UPDATE pelayanans SET status = 'selesai' WHERE id = ?")) {
                ps.setLong(1, d.pelayananId);
                ps.executeUpdate();
            }

            d.pemeriksaanId = insert(conn,
                    "INSERT INTO pemeriksaans (pelayanan_id, treatment_id, diagnosa, tindakan, catatan, created_at, updated_at) "
                    + "VALUES (?, ?, ?, ?, ?, NOW(), NOW())",
                    d.pelayananId, d.treatmentId, "Hiperpigmentasi ringan", "Facial brightening", "Kontrol 2 minggu lagi");

            insert(conn,
                    "INSERT INTO pemeriksaan_produk (pemeriksaan_id, produk_id, qty, created_at, updated_at) "
                    + "VALUES (?, ?, 1, NOW(), NOW())",
                    d.pemeriksaanId, d.produkId);

            d.pembayaranId = insert(conn,
                    "INSERT INTO pembayarans (pelayanan_id, total_harga, status, created_at, updated_at) "
                    + "VALUES (?, ?, 'belum_bayar', NOW(), NOW())",
                    d.pelayananId, 450000);

            insert(conn,
                    "INSERT INTO pembayaran_items (pembayaran_id, jenis, treatment_id, produk_id, qty, harga_satuan, subtotal, created_at, updated_at) "
                    + "VALUES (?, 'treatment', ?, NULL, 1, 300000, 300000, NOW(), NOW())",
                    d.pembayaranId, d.treatmentId);

            insert(conn,
                    "INSERT INTO pembayaran_items (pembayaran_id, jenis, treatment_id, produk_id, qty, harga_satuan, subtotal, created_at, updated_at) "
                    + "VALUES (?, 'produk', NULL, ?, 1, 150000, 150000, NOW(), NOW())",
                    d.pembayaranId, d.produkId);

            return d;
        } catch (SQLException e) {
            throw new RuntimeException("Gagal menyiapkan data pemeriksaan dan tagihan", e);
        }
    }
}
