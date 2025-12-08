@extends('layouts.app')

@section('title', 'Daftar Treatment')

@section('content')
    <div class="p-6">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                x-data="{ show: true }" x-show="show" x-transition>
                <span class="block sm:inline">{{ session('success') }}</span>
                <button @click="show = false" class="absolute top-0 right-0 px-4 py-3">
                    <span class="text-2xl">&times;</span>
                </button>
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-primary-400">Treatment</h1>

            <div x-data="{ open: false }">
                <button @click="open = true"
                    class="cursor-pointer text-sm w-52 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-md shadow">
                    Tambah Treatment
                </button>
                <x-treatment.modal />
            </div>
        </div>

        <div class="px-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($treatments as $treatment)
                <x-treatment.card :treatment="$treatment" />
            @empty
                <div class="col-span-full text-center">
                    <p class="text-gray-500 text-lg">Belum ada treatment</p>
                </div>
            @endforelse
        </div>

        <script>
            function treatmentModal() {
                return {
                    open: false,
                    preview: null,
                    isEdit: false,
                    form: {
                        id: '',
                        nama: '',
                        deskripsi: '',
                        harga: '',
                        durasi: '',
                        status: 'tersedia',
                        foto: null
                    },

                    // Reset form
                    resetForm() {
                        this.form = {
                            id: '',
                            nama: '',
                            deskripsi: '',
                            harga: '',
                            durasi: '',
                            status: 'tersedia',
                            foto: null
                        };
                        this.preview = null;
                        this.isEdit = false;
                    },

                    // Buka modal untuk create
                    openCreateModal() {
                        this.resetForm();
                        this.open = true;
                    },

                    // Buka modal untuk edit
                    async openEditModal(id) {
                        this.open = true;
                        this.isEdit = true;

                        try {
                            const res = await fetch(`/treatment/${id}`);
                            if (!res.ok) throw new Error('Failed to fetch');

                            const json = await res.json();

                            this.form = {
                                id: json.data.id,
                                nama: json.data.nama || '',
                                deskripsi: json.data.deskripsi || '',
                                harga: json.data.harga || '',
                                durasi: json.data.durasi || '',
                                status: json.data.status || 'tersedia',
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
                            this.open = false;
                        }
                    },

                    // Handle file upload & preview
                    handleFileChange(event) {
                        const file = event.target.files[0];
                        if (file) {
                            // Validasi file
                            if (!file.type.startsWith('image/')) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'File Tidak Valid',
                                    text: 'Hanya file gambar yang diperbolehkan'
                                });
                                return;
                            }

                            if (file.size > 2048000) { // 2MB
                                Swal.fire({
                                    icon: 'error',
                                    title: 'File Terlalu Besar',
                                    text: 'Ukuran file maksimal 2MB'
                                });
                                return;
                            }

                            this.form.foto = file;

                            const reader = new FileReader();
                            reader.onload = (e) => {
                                this.preview = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    },

                    // Submit form (Create atau Update)
                    async submitForm() {
                        // Validasi dasar
                        if (!this.form.nama || !this.form.harga) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Peringatan',
                                text: 'Nama dan Harga wajib diisi!'
                            });
                            return;
                        }

                        const formData = new FormData();

                        if (this.isEdit) {
                            formData.append('_method', 'PUT');
                        }

                        formData.append('nama', this.form.nama);
                        formData.append('deskripsi', this.form.deskripsi || '');
                        formData.append('harga', this.form.harga);
                        formData.append('durasi', this.form.durasi || '');
                        formData.append('status', this.form.status);

                        if (this.form.foto) {
                            formData.append('foto', this.form.foto);
                        }

                        console.log('Mengirim data:', {
                            id: this.form.id,
                            nama: this.form.nama,
                            deskripsi: this.form.deskripsi,
                            harga: this.form.harga,
                            durasi: this.form.durasi,
                            status: this.form.status,
                            foto: this.form.foto ? this.form.foto.nama : null,
                            isEdit: this.isEdit
                        });

                        try {
                            const url = this.isEdit ? `/treatment/${this.form.id}` : '/treatment';

                            const response = await fetch(url, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[nama="csrf-token"]').content
                                },
                                body: formData
                            });

                            let data;
                            try {
                                data = await response.json();
                            } catch (e) {
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
                                this.resetForm();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: data.message ||
                                        `Treatment berhasil ${this.isEdit ? 'diperbarui' : 'ditambahkan'}`,
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });

                            } else {
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
                    },

                    // Close modal
                    closeModal() {
                        this.open = false;
                        setTimeout(() => this.resetForm(), 300);
                    }
                }
            }
        </script>
    </div>

@endsection
