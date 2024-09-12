@extends('layouts.main')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Manajemen Pengguna</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambah
                        Pengguna</button>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="teknisi-tab" data-bs-toggle="tab" href="#teknisi" role="tab"
                                aria-controls="teknisi" aria-selected="true">Teknisi</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="user-tab" data-bs-toggle="tab" href="#user" role="tab"
                                aria-controls="user" aria-selected="false">User</a>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content" id="myTabContent">
                        <!-- Teknisi Tab -->
                        <div class="tab-pane fade show active" id="teknisi" role="tabpanel" aria-labelledby="teknisi-tab">
                            <div class="table-responsive">
                                <table class="table table-xl">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Role</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users->where('role.name', 'teknisi') as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->nik }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->role->name }}</td>
                                                <td class="text-nowrap">
                                                    <div class="dropdown dropup">
                                                        <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                            type="button" id="dropdownMenuButton-{{ $user->id }}"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-three-dots-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuButton-{{ $user->id }}">
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0)"
                                                                    onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->nik }}', '{{ $user->no_hp }}', '{{ $user->alamat }}', '{{ $user->email }}', '{{ $user->role->name }}')">Ubah</a>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('users.destroy', $user->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="dropdown-item">Hapus</button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- User Tab -->
                        <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">
                            <div class="table-responsive">
                                <table class="table table-xl">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>No. HP</th>
                                            <th>Alamat</th>
                                            <th>Role</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users->where('role.name', 'user') as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->no_hp }}</td>
                                                <td>{{ $user->alamat }}</td>
                                                <td>{{ $user->role->name }}</td>
                                                <td class="text-nowrap">
                                                    <div class="dropdown dropup">
                                                        <button class="btn btn-sm btn-secondary dropdown-toggle"
                                                            type="button" id="dropdownMenuButton-{{ $user->id }}"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-three-dots-vertical"></i>
                                                        </button>
                                                        <ul class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuButton-{{ $user->id }}">
                                                            <li>
                                                                <a class="dropdown-item" href="javascript:void(0)"
                                                                    onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->nik }}', '{{ $user->no_hp }}', '{{ $user->alamat }}', '{{ $user->email }}', '{{ $user->role->name }}')">Ubah</a>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('users.destroy', $user->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="dropdown-item">Hapus</button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
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
    </div>


    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="createForm" action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Tambah Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="role_id" class="form-label">Role</label>
                            <select class="form-select" id="role_id" name="role_id" required>
                                <option value="" disabled selected>Pilih Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="nikField" class="mb-3" style="display: none;">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div id="no_hpField" class="mb-3" style="display: none;">
                            <label for="no_hp" class="form-label">No HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp">
                        </div>
                        <div id="alamatField" class="mb-3" style="display: none;">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat">
                        </div>
                        <div class="mb-3 d-none">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3 d-none">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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
                <form id="editForm" action="#" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Ubah Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editRole_id" class="form-label">Role</label>
                            <select class="form-select" id="editRole_id" name="role_id" required>
                                <option value="" disabled>Pilih Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="editNikField" class="mb-3" style="display: none;">
                            <label for="editNik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="editNik" name="nik">
                        </div>
                        <div class="mb-3">
                            <label for="editName" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div id="editNo_hpField" class="mb-3" style="display: none;">
                            <label for="editNo_hp" class="form-label">No HP</label>
                            <input type="text" class="form-control" id="editNo_hp" name="no_hp">
                        </div>
                        <div id="editAlamatField" class="mb-3" style="display: none;">
                            <label for="editAlamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="editAlamat" name="alamat">
                        </div>
                        <div class="mb-3 d-none">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email">
                        </div>
                        <div class="mb-3 d-none">
                            <label for="editPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="editPassword" name="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@push('scripts')
    <script>
        document.getElementById('role_id').addEventListener('change', function() {
            const roleName = this.options[this.selectedIndex].text;
            const nikField = document.getElementById('nikField');
            const noHpField = document.getElementById('no_hpField');
            const alamatField = document.getElementById('alamatField');

            if (roleName === 'teknisi') {
                nikField.style.display = 'block';
                noHpField.style.display = 'none';
                alamatField.style.display = 'none';
            } else {
                nikField.style.display = 'none';
                noHpField.style.display = 'block';
                alamatField.style.display = 'block';
            }
        });

        function openEditModal(id, name, nik, no_hp, alamat, email, roleName) {
            document.getElementById('editForm').action = '/users/' + id;
            document.getElementById('editName').value = name;
            document.getElementById('editNik').value = nik;
            document.getElementById('editNo_hp').value = no_hp;
            document.getElementById('editAlamat').value = alamat;
            document.getElementById('editEmail').value = email;

            const editNikField = document.getElementById('editNikField');
            const editNoHpField = document.getElementById('editNo_hpField');
            const editAlamatField = document.getElementById('editAlamatField');
            const editRoleSelect = document.getElementById('editRole_id');

            // Set the role select value
            editRoleSelect.value = roleName;

            if (roleName === 'teknisi') {
                editNikField.style.display = 'block';
                editNoHpField.style.display = 'none';
                editAlamatField.style.display = 'none';
            } else {
                editNikField.style.display = 'none';
                editNoHpField.style.display = 'block';
                editAlamatField.style.display = 'block';
            }

            new bootstrap.Modal(document.getElementById('editModal')).show();
        }
    </script>
@endpush
