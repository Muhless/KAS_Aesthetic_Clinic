@extends('layouts.app')

@section('title', 'Halaman Perawat')

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 relative"
            x-data="{ show: true }" x-show="show" x-transition>
            <span class="block sm:inline">{{ session('success') }}</span>
            <button @click="show = false" class="absolute top-0 right-0 px-4 py-3">
                <span class="text-2xl">&times;</span>
            </button>
        </div>
    @endif

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="p-6" x-data="PerawatModal()">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-primary-400">Perawat</h1>
            <button @click="open = true"
                class="cursor-pointer text-sm w-52 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md shadow">
                Tambah Perawat
            </button>
        </div>

        <div class="grid grid-cols-4 gap-4">
            @foreach ($perawats as $perawat)
                <x-perawat.card :perawat="$perawat" />
            @endforeach
        </div>

        <x-perawat.modal />

        <!-- Alpine.js Script -->
        <script>
            function PerawatModal() {
                return {
                    open: false,
                    preview: null,
                    isEdit: false, // Track mode edit atau tambah
                    form: {
                        id: '',
                        nama: '',
                        no_telepon: '',
                        email: '',
                        tanggal_lahir: '',
                        foto: null
                    },

                    // Buka modal untuk tambah perawat baru
                    createPerawat() {
                        this.isEdit = false;
                        this.resetForm();
                        this.open = true;
                    },

                    // Buka modal untuk edit perawat
                    async editPerawat(id) {
                        this.isEdit = true;
                        this.open = true;

                        try {
                            const res = await fetch(`/perawat/${id}`);
                            const json = await res.json();

                            let tanggalLahir = '';
                            if (json.data.tanggal_lahir) {
                                tanggalLahir = json.data.tanggal_lahir.substring(0, 10);
                            }

                            this.form = {
                                id: json.data.id,
                                nama: json.data.nama,
                                no_telepon: json.data.no_telepon,
                                email: json.data.email,
                                tanggal_lahir: tanggalLahir,
                                foto: null
                            };

                            this.preview = json.data.foto_url || null;

                        } catch (error) {
                            console.error('Error fetching perawat:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal mengambil data perawat'
                            });
                        }
                    },

                    // Handle file upload & preview
                    handleFileChange(event) {
                        const file = event.target.files[0];
                        if (file) {
                            this.form.foto = file;

                            // Preview gambar
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                this.preview = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    },

                    // Reset form
                    resetForm() {
                        this.form = {
                            id: '',
                            nama: '',
                            no_telepon: '',
                            email: '',
                            tanggal_lahir: '',
                            foto: null
                        };
                        this.preview = null;
                    },

                    // Submit form (tambah atau edit)
                    async submitForm() {
                        const formData = new FormData();

                        formData.append('_method', 'PATCH');

                        if (this.form.nama) formData.append('nama', this.form.nama);
                        if (this.form.no_telepon) formData.append('no_telepon', this.form.no_telepon);
                        if (this.form.email) formData.append('email', this.form.email);
                        if (this.form.tanggal_lahir) formData.append('tanggal_lahir', this.form.tanggal_lahir);
                        if (this.form.foto) formData.append('foto', this.form.foto);

                        console.log('Mengirim data:', {
                            id: this.form.id,
                            nama: this.form.nama,
                            no_telepon: this.form.no_telepon,
                            email: this.form.email,
                            tanggal_lahir: this.form.tanggal_lahir,
                            foto: this.form.foto ? this.form.foto.name : null
                        });

                        try {
                            const response = await fetch(`/perawat/${this.form.id}`, {
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
