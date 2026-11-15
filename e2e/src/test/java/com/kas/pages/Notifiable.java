package com.kas.pages;

import java.util.List;

/**
 * Halaman yang menampilkan notifikasi sukses/error setelah submit form.
 *
 * Dipakai oleh step definition generik, supaya assertion notifikasi bisa
 * ditulis sekali dan dipakai lintas fitur CRUD.
 */
public interface Notifiable {

    boolean hasSuccessMessage();

    String getSuccessMessage();

    boolean hasErrorMessage();

    List<String> getErrorMessages();
}
