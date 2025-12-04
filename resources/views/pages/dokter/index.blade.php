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

                    async editDokter(id) {
                        this.open = true;

                        try {
                            const res = await fetch(`/api/dokter/${id}`);
                            const json = await res.json();

                            const tanggalLahir = json.data.tanggal_lahir ?
                                json.data.tanggal_lahir.split(' ')[0] :
                                '';

                            this.form = {
                                id: json.data.id,
                                nama: json.data.nama,
                                no_telepon: json.data.no_telepon,
                                email: json.data.email,
                                spesialis: json.data.spesialis || '',
                                tanggal_lahir: tanggalLahir,
                                foto: null
                            };

                            this.preview = json.data.foto_url || null;

                        } catch (error) {
                            console.error('Error fetching dokter:', error);
                            alert('Gagal mengambil data dokter');
                        }
                    },

                    async submitForm() {
                        const formData = new FormData();

                        formData.append('_method', 'PATCH');

                        if (this.form.nama) formData.append('nama', this.form.nama);
                        if (this.form.no_telepon) formData.append('no_telepon', this.form.no_telepon);
                        if (this.form.email) formData.append('email', this.form.email);
                        if (this.form.spesialis) formData.append('spesialis', this.form.spesialis);
                        if (this.form.tanggal_lahir) formData.append('tanggal_lahir', this.form.tanggal_lahir);
                        if (this.form.foto) formData.append('foto', this.form.foto);

                        try {
                            const response = await fetch(`/dokter/${this.form.id}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: formData
                            });

                            const data = await response.json();

                            if (response.ok) {
                                this.open = false;

                                // Tampilkan popup success
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: data.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
                                });

                            } else {
                                if (data.errors) {
                                    let errorMsg = '';
                                    for (let field in data.errors) {
                                        errorMsg += data.errors[field].join(', ') + '\n';
                                    }

                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Validasi Gagal',
                                        text: errorMsg
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: data.message || 'Terjadi kesalahan'
                                    });
                                }
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat menyimpan data'
                            });
                        }
                    }
                }
            }
        </script>
    </div>
@endsection
