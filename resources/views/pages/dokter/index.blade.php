@extends('layouts.app')

@section('title', 'Halaman Dokter - KAS Aesthetic Clinic')

@section('content')
    <div class="p-6" x-data="dokterModal()">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-primary-400">Dokter</h1>

            {{-- <button @click="open = true"
                class="cursor-pointer text-sm w-52 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg shadow">
                Tambah Dokter
            </button> --}}
        </div>

        <div class="grid grid-cols-4 gap-4">
            @foreach ($dokters as $dokter)
                <x-dokter.card :dokter="$dokter" />
            @endforeach
        </div>

        <!-- Modal Component -->
        <x-dokter.modal />

        <!-- Alpine.js Script -->
        <script>
            function dokterModal() {
                return {
                    open: false,
                    preview: null,
                    form: {
                        id: '',
                        nama: '',
                        no_telepon: '',
                        email: '',
                        spesialis: '',
                        tanggal_lahir: '',
                        foto: null
                    },

                    // Buka modal untuk edit
                    async editDokter(id) {
                        this.open = true;

                        try {
                            const res = await fetch(`/dokter/${id}`);
                            if (!res.ok) throw new Error('Failed to fetch');

                            const json = await res.json();

                            this.form = {
                                id: json.data.id,
                                nama: json.data.nama || '',
                                no_telepon: json.data.no_telepon || '',
                                email: json.data.email || '',
                                spesialis: json.data.spesialis || '',
                                tanggal_lahir: json.data.tanggal_lahir ? json.data.tanggal_lahir.substring(0, 10) : '',
                                foto: null
                            };

                            this.preview = json.data.foto ? `/storage/${json.data.foto}` : null;

                        } catch (error) {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal mengambil data: ' + error.message
                            });
                        }
                    },

                    // Handle file upload & preview
                    handleFileChange(event) {
                        const file = event.target.files[0];
                        if (file) {
                            this.form.foto = file;

                            const reader = new FileReader();
                            reader.onload = (e) => {
                                this.preview = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    },

                    // Submit form
                    async submitForm() {
                        const formData = new FormData();

                        formData.append('_method', 'PATCH');

                        if (this.form.nama) formData.append('nama', this.form.nama);
                        if (this.form.no_telepon) formData.append('no_telepon', this.form.no_telepon);
                        if (this.form.email) formData.append('email', this.form.email);
                        if (this.form.spesialis) formData.append('spesialis', this.form.spesialis);
                        if (this.form.tanggal_lahir) formData.append('tanggal_lahir', this.form.tanggal_lahir);
                        if (this.form.foto) formData.append('foto', this.form.foto);

                        console.log('Mengirim data:', {
                            id: this.form.id,
                            nama: this.form.nama,
                            no_telepon: this.form.no_telepon,
                            email: this.form.email,
                            spesialis: this.form.spesialis,
                            tanggal_lahir: this.form.tanggal_lahir,
                            foto: this.form.foto ? this.form.foto.name : null
                        });

                        try {
                            const response = await fetch(`/dokter/${this.form.id}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: formData
                            });

                            let data;
                            try {
                                data = await response.json();
                            } catch (e) {
                                // Jika response bukan JSON
                                const text = await response.text();
                                console.error('Response bukan JSON:', text);

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error Server',
                                    html: `<pre style="text-align: left; max-height: 400px; overflow: auto;">${text}</pre>`,
                                    width: '800px'
                                });
                                return;
                            }

                            console.log('Response dari server:', data);
                            console.log('Status code:', response.status);

                            if (response.ok) {
                                this.open = false;

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: data.message || 'Data berhasil diperbarui',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });

                            } else {
                                // Tampilkan error detail
                                console.error('Error response:', data);

                                let errorHtml = '<div style="text-align: left;">';

                                // Validasi errors
                                if (data.errors) {
                                    errorHtml += '<strong>Error Validasi:</strong><ul style="margin: 10px 0;">';
                                    for (let field in data.errors) {
                                        errorHtml += `<li><strong>${field}:</strong> ${data.errors[field].join(', ')}</li>`;
                                    }
                                    errorHtml += '</ul>';
                                }

                                // Message error
                                if (data.message) {
                                    errorHtml += `<p><strong>Pesan:</strong> ${data.message}</p>`;
                                }

                                // Error exception detail
                                if (data.error) {
                                    errorHtml += `<p style="color: red;"><strong>Detail Error:</strong> ${data.error}</p>`;
                                }

                                // Debug info
                                errorHtml += `<hr><small><strong>Status:</strong> ${response.status}</small>`;
                                errorHtml += '</div>';

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal Menyimpan Data',
                                    html: errorHtml,
                                    width: '600px',
                                    confirmButtonText: 'OK'
                                });
                            }
                        } catch (error) {
                            console.error('Fetch error:', error);

                            Swal.fire({
                                icon: 'error',
                                title: 'Error Koneksi',
                                html: `
                            <div style="text-align: left;">
                                <p><strong>Terjadi kesalahan saat menghubungi server:</strong></p>
                                <p style="color: red;">${error.message}</p>
                                <hr>
                                <small>Cek console browser (F12) untuk detail lengkap</small>
                            </div>
                        `,
                                width: '600px'
                            });
                        }
                    }
                }
            }
        </script>
    </div>
@endsection
