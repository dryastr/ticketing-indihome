@extends('layouts.main')

@section('title', 'Daftar Detail Kendala')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">Daftar Detail Kendala</h4>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Detail
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
                                        <th>Jenis Kendala</th>
                                        <th>Detail Kendala</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detailKendalas as $detailKendala)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $detailKendala->jenisKendala->nama_kendala }}</td>
                                            <td>{{ $detailKendala->detail_kendala }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-secondary"
                                                    onclick="openEditModal('{{ $detailKendala->id }}', '{{ $detailKendala->jenis_kendala_id }}', '{{ $detailKendala->detail_kendala }}')">Ubah</button>
                                                <form action="{{ route('detail_kendalas.destroy', $detailKendala->id) }}"
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
                    <h5 class="modal-title" id="createModalLabel">Tambah Detail Kendala</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('detail_kendalas.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="jenis_kendala_id" class="form-label">Jenis Kendala</label>
                            <select class="form-select @error('jenis_kendala_id') is-invalid @enderror"
                                id="jenis_kendala_id" name="jenis_kendala_id" required>
                                <option value="">Pilih Jenis Kendala</option>
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
                            <label for="detail_kendala" class="form-label">Detail Kendala</label>
                            <textarea class="form-control @error('detail_kendala') is-invalid @enderror" id="detail_kendala" name="detail_kendala"
                                required></textarea>
                            @error('detail_kendala')
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
                    <h5 class="modal-title" id="editModalLabel">Ubah Detail Kendala</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editJenisKendalaId" class="form-label">Jenis Kendala</label>
                            <select class="form-select @error('jenis_kendala_id') is-invalid @enderror"
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
                            <label for="editDetailKendala" class="form-label">Detail Kendala</label>
                            <textarea class="form-control @error('detail_kendala') is-invalid @enderror" id="editDetailKendala"
                                name="detail_kendala" required></textarea>
                            @error('detail_kendala')
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
        function openEditModal(id, jenisKendalaId, detailKendala) {
            document.getElementById('editForm').action = '/detail_kendalas/' + id;
            document.getElementById('editJenisKendalaId').value = jenisKendalaId;
            document.getElementById('editDetailKendala').value = detailKendala;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }
    </script>
@endpush
