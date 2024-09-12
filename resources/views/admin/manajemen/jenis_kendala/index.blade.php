@extends('layouts.main')

@section('title', 'Daftar Jenis Kendala')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">Daftar Jenis Kendala</h4>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Jenis
                            Kendala</button>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-xl">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kendala</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jenisKendalas as $jenisKendala)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $jenisKendala->nama_kendala }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-secondary"
                                                    onclick="openEditModal('{{ $jenisKendala->id }}', '{{ $jenisKendala->nama_kendala }}')">Ubah</button>
                                                <form action="{{ route('jenis_kendalas.destroy', $jenisKendala->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Tambah Jenis Kendala</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('jenis_kendalas.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_kendala" class="form-label">Nama Kendala</label>
                            <input type="text" class="form-control @error('nama_kendala') is-invalid @enderror"
                                id="nama_kendala" name="nama_kendala" required>
                            @error('nama_kendala')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Ubah Jenis Kendala</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editNamaKendala" class="form-label">Nama Kendala</label>
                            <input type="text" class="form-control @error('nama_kendala') is-invalid @enderror"
                                id="editNamaKendala" name="nama_kendala" required>
                            @error('nama_kendala')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        function openEditModal(id, namaKendala) {
            document.getElementById('editForm').action = '/jenis_kendalas/' + id;
            document.getElementById('editNamaKendala').value = namaKendala;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }
    </script>
@endpush
