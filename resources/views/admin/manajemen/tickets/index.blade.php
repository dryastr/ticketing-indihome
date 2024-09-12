@extends('layouts.main')

@section('title', 'Daftar Tiket')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">Daftar Tiket</h4>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">Tambah
                            Tiket</button>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-xl">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Jenis Kendala</th>
                                        <th>STO</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tickets as $ticket)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ticket->user->nik }}</td>
                                            <td>{{ $ticket->pelanggan->name }}</td>
                                            <td>{{ $ticket->jenisKendala->nama_kendala }}</td>
                                            <td>{{ $ticket->STO }}</td>
                                            <td>{{ $ticket->status ? 'Active' : 'Inactive' }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-secondary"
                                                    onclick="openEditModal('{{ $ticket->id }}', '{{ $ticket->nik_id }}', '{{ $ticket->pelanggan_id }}', '{{ $ticket->jenis_kendala_id }}', '{{ $ticket->STO }}', '{{ $ticket->status }}')">Ubah</button>
                                                <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST"
                                                    style="display:inline;">
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
                    <h5 class="modal-title" id="createModalLabel">Tambah Tiket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tickets.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nik_id" class="form-label">NIK</label>
                            <select class="form-control @error('nik_id') is-invalid @enderror" id="nik_id" name="nik_id"
                                required>
                                <option value="">Pilih NIK</option>
                                @foreach ($teknisis as $user)
                                    <option value="{{ $user->id }}">{{ $user->nik }} - {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nik_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="pelanggan_id" class="form-label">Pelanggan</label>
                            <select class="form-control @error('pelanggan_id') is-invalid @enderror" id="pelanggan_id"
                                name="pelanggan_id" required>
                                <!-- Assuming you have a $pelanggan list passed to the view -->
                                @foreach ($users as $pelanggan)
                                    <option value="{{ $pelanggan->id }}">{{ $pelanggan->name }}</option>
                                @endforeach
                            </select>
                            @error('pelanggan_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kendala_id" class="form-label">Jenis Kendala</label>
                            <select class="form-control @error('jenis_kendala_id') is-invalid @enderror"
                                id="jenis_kendala_id" name="jenis_kendala_id" required>
                                <!-- Assuming you have a $jenisKendalas list passed to the view -->
                                @foreach ($jenisKendalas as $jenisKendala)
                                    <option value="{{ $jenisKendala->id }}">{{ $jenisKendala->nama_kendala }}</option>
                                @endforeach
                            </select>
                            @error('jenis_kendala_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="STO" class="form-label">STO</label>
                            <input type="text" class="form-control @error('STO') is-invalid @enderror" id="STO"
                                name="STO" required>
                            @error('STO')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status"
                                required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            @error('status')
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
                    <h5 class="modal-title" id="editModalLabel">Edit Tiket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editNikId" class="form-label">NIK</label>
                            <select class="form-control @error('nik_id') is-invalid @enderror" id="editNikId"
                                name="nik_id" required>
                                <option value="">Pilih NIK</option>
                                @foreach ($teknisis as $user)
                                    <option value="{{ $user->id }}">{{ $user->nik }} - {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nik_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="editPelangganId" class="form-label">Pelanggan</label>
                            <select class="form-control @error('pelanggan_id') is-invalid @enderror" id="editPelangganId"
                                name="pelanggan_id" required>
                                @foreach ($users as $pelanggan)
                                    <option value="{{ $pelanggan->id }}">{{ $pelanggan->name }}</option>
                                @endforeach
                            </select>
                            @error('pelanggan_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="editJenisKendalaId" class="form-label">Jenis Kendala</label>
                            <select class="form-control @error('jenis_kendala_id') is-invalid @enderror"
                                id="editJenisKendalaId" name="jenis_kendala_id" required>
                                @foreach ($jenisKendalas as $jenisKendala)
                                    <option value="{{ $jenisKendala->id }}">{{ $jenisKendala->nama_kendala }}</option>
                                @endforeach
                            </select>
                            @error('jenis_kendala_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="editSTO" class="form-label">STO</label>
                            <input type="text" class="form-control @error('STO') is-invalid @enderror" id="editSTO"
                                name="STO" required>
                            @error('STO')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="editStatus" class="form-label">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="editStatus"
                                name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            @error('status')
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

@endsection

@push('scripts')
    <script>
        function openEditModal(id, nikId, pelangganId, jenisKendalaId, sto, status) {
            document.getElementById('editForm').action = '/tickets/' + id;
            document.getElementById('editNikId').value = nikId;
            document.getElementById('editPelangganId').value = pelangganId;
            document.getElementById('editJenisKendalaId').value = jenisKendalaId;
            document.getElementById('editSTO').value = sto;
            document.getElementById('editStatus').value = status;

            var myModal = new bootstrap.Modal(document.getElementById('editModal'), {});
            myModal.show();
        }
    </script>
@endpush
