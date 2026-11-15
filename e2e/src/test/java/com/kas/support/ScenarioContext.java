package com.kas.support;

import com.kas.pages.Notifiable;

/**
 * State yang dipakai bersama oleh step definition dalam satu skenario.
 *
 * Cucumber membuat instance step definition baru per skenario, sehingga
 * langkah generik (mis. assertion notifikasi) tidak bisa mengandalkan field
 * milik satu kelas step saja.
 */
public final class ScenarioContext {

    private static Notifiable notifiable;

    private ScenarioContext() {
    }

    public static void reset() {
        notifiable = null;
    }

    /** Simpan halaman terakhir yang punya notifikasi sukses/error. */
    public static void setNotifiable(Notifiable page) {
        notifiable = page;
    }

    public static Notifiable notifiable() {
        if (notifiable == null) {
            throw new IllegalStateException(
                    "Tidak ada halaman dengan notifikasi yang dibuka pada skenario ini");
        }
        return notifiable;
    }
}
