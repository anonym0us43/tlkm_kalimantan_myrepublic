@extends("layouts")

@section("title", "Employee")

@section("breadcrumb")
	<li class="breadcrumb-item">Administrator</li>
	<li class="breadcrumb-item active">Employee</li>
@endsection

@section("styles")
	<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/vendors/jquery.dataTables.css") }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/vendors/dataTables.bootstrap5.css") }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/vendors/select2.css") }}" />
@endsection

@section("content")
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h5 class="mb-0">Data Employee</h5>
					<button type="button" class="btn btn-primary btn-sm" id="btnAdd">
						<i data-feather="plus" class="me-1" style="width: 14px; height: 14px"></i>
						Tambah Employee
					</button>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover" id="tblEmployee" width="100%">
							<thead>
								<tr>
									<th width="50">No</th>
									<th>NIK</th>
									<th>Nama</th>
									<th>Area</th>
									<th>Role</th>
									<th width="100">Status</th>
									<th width="120">Tgl Dibuat</th>
									<th width="120">Aksi</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalEmployee" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalEmployeeTitle">Tambah Employee</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<form id="formEmployee" novalidate>
					@csrf
					<input type="hidden" id="employeeId" value="" />
					<div class="modal-body">
						<div class="row g-3">
							<div class="col-md-6">
								<label for="nik" class="form-label fw-semibold">
									NIK
									<span class="text-danger">*</span>
								</label>
								<input type="text" class="form-control" id="nik" name="nik" maxlength="12" autocomplete="off" required />
								<div class="invalid-feedback" id="errNik"></div>
							</div>
							<div class="col-md-6">
								<label for="nama" class="form-label fw-semibold">
									Nama
									<span class="text-danger">*</span>
								</label>
								<input type="text" class="form-control" id="nama" name="nama" maxlength="255" autocomplete="off" required />
								<div class="invalid-feedback" id="errNama"></div>
							</div>
							<div class="col-md-6">
								<label for="area_id" class="form-label fw-semibold">
									Area
									<span class="text-danger">*</span>
								</label>
								<select class="form-select" id="area_id" name="area_id" required>
									<option value="">Pilih Area</option>
									@foreach ($areas as $area)
										<option value="{{ $area->id }}">{{ $area->name }}</option>
									@endforeach
								</select>
								<div class="invalid-feedback" id="errAreaId"></div>
							</div>
							<div class="col-md-6">
								<label for="role_id" class="form-label fw-semibold">
									Role
									<span class="text-danger">*</span>
								</label>
								<select class="form-select" id="role_id" name="role_id" required>
									<option value="">Pilih Role</option>
									@foreach ($roles as $role)
										<option value="{{ $role->id }}">{{ $role->name }}</option>
									@endforeach
								</select>
								<div class="invalid-feedback" id="errRoleId"></div>
							</div>
							<div class="col-md-6">
								<label for="password" class="form-label fw-semibold">
									Password
									<span class="text-danger" id="pwdRequired">*</span>
									<small class="text-muted fw-normal" id="pwdHint" style="display: none">(kosongkan jika tidak diubah)</small>
								</label>
								<input type="password" class="form-control" id="password" name="password" autocomplete="new-password" />
								<div class="invalid-feedback" id="errPassword"></div>
							</div>
							<div class="col-md-6">
								<label for="status" class="form-label fw-semibold">
									Status
									<span class="text-danger">*</span>
								</label>
								<select class="form-select" id="status" name="status" required>
									<option value="1">Aktif</option>
									<option value="0">Non-Aktif</option>
								</select>
								<div class="invalid-feedback" id="errStatus"></div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary btn-sm">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@section("scripts")
	<script src="{{ asset("assets/js/datatable/datatables/dataTables.js") }}"></script>
	<script src="{{ asset("assets/js/datatable/datatables/dataTables.bootstrap5.js") }}"></script>
	<script src="{{ asset("assets/js/select2/select2.full.min.js") }}"></script>
	<script>
		const CSRF = $('meta[name="csrf-token"]').attr('content');

		DataTable.ext.errMode = 'none';

		$('#area_id').select2({
			dropdownParent: $('#modalEmployee'),
			placeholder: 'Pilih Area',
			allowClear: true,
			width: '100%',
		});

		$('#role_id').select2({
			dropdownParent: $('#modalEmployee'),
			placeholder: 'Pilih Role',
			allowClear: true,
			width: '100%',
		});

		const table = $('#tblEmployee').DataTable({
			ajax: {
				url: '{{ route("ajax.employee.data") }}',
				type: 'GET',
				dataSrc: 'data',
				error: function () {
					Swal.fire({
						toast: true,
						position: 'top-end',
						icon: 'error',
						title: 'Gagal memuat data.',
						showConfirmButton: false,
						timer: 3000,
						timerProgressBar: true,
					});
				},
			},
			columns: [
				{ data: 'no', orderable: false, searchable: false },
				{ data: 'nik' },
				{ data: 'nama' },
				{ data: 'area_name' },
				{ data: 'role_name' },
				{ data: 'status', orderable: false, searchable: false },
				{ data: 'created' },
				{
					data: 'id',
					orderable: false,
					searchable: false,
					render: function (id) {
						return `
                            <button class="btn btn-warning btn-xs me-1 btnEdit" data-id="${id}" title="Edit" style="padding:4px 8px;">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn btn-danger btn-xs btnDelete" data-id="${id}" title="Hapus" style="padding:4px 8px;">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>`;
					},
				},
			],
			language: {
				url: false,
				search: 'Cari:',
				lengthMenu: 'Tampilkan _MENU_ data',
				info: 'Menampilkan _START_-_END_ dari _TOTAL_ data',
				paginate: { previous: 'Prev', next: 'Next' },
				emptyTable: 'Tidak ada data tersedia',
				zeroRecords: 'Data tidak ditemukan',
			},
		});

		function clearForm() {
			$('#formEmployee')[0].reset();
			$('#employeeId').val('');
			$('#area_id').val('').trigger('change');
			$('#role_id').val('').trigger('change');
			$('#formEmployee .is-invalid').removeClass('is-invalid');
			$('#formEmployee [id^="err"]').text('');
			$('#pwdRequired').show();
			$('#pwdHint').hide();
		}

		function applyValidationErrors(errors) {
			const map = {
				area_id: 'errAreaId',
				role_id: 'errRoleId',
				nik: 'errNik',
				nama: 'errNama',
				password: 'errPassword',
				status: 'errStatus',
			};

			$.each(errors, function (field, msgs) {
				if (map[field]) {
					$('#' + field).addClass('is-invalid');
					$('#' + map[field]).text(msgs[0]);
				}
			});
		}

		$('#btnAdd').on('click', function () {
			clearForm();
			$('#modalEmployeeTitle').text('Tambah Employee');
			$('#modalEmployee').modal('show');
		});

		$(document).on('click', '.btnEdit', function () {
			const id = $(this).data('id');
			clearForm();
			$('#modalEmployeeTitle').text('Edit Employee');
			$('#pwdRequired').hide();
			$('#pwdHint').show();

			$.get('{{ url("admin/employee") }}/' + id, function (data) {
				$('#employeeId').val(data.id);
				$('#nik').val(data.nik);
				$('#nama').val(data.nama);
				$('#area_id').val(data.area_id).trigger('change');
				$('#role_id').val(data.role_id).trigger('change');
				$('#status').val(data.status);
				$('#modalEmployee').modal('show');
			});
		});

		$('#formEmployee').on('submit', function (e) {
			e.preventDefault();

			const id = $('#employeeId').val();
			const url = id ? '{{ url("admin/employee") }}/' + id : '{{ route("admin.employee.store") }}';
			const method = id ? 'PUT' : 'POST';

			$('#formEmployee .is-invalid').removeClass('is-invalid');
			$('#formEmployee [id^="err"]').text('');

			$.ajax({
				url: url,
				type: method,
				data: {
					_token: CSRF,
					area_id: $('#area_id').val(),
					role_id: $('#role_id').val(),
					nik: $('#nik').val().trim(),
					nama: $('#nama').val().trim(),
					status: $('#status').val(),
					password: $('#password').val(),
				},
				success: function (res) {
					$('#modalEmployee').modal('hide');
					table.ajax.reload(null, false);
					Swal.fire({
						toast: true,
						position: 'top-end',
						icon: 'success',
						title: res.message,
						showConfirmButton: false,
						timer: 3000,
						timerProgressBar: true,
					});
				},
				error: function (xhr) {
					if (xhr.status === 422 && xhr.responseJSON.errors) {
						applyValidationErrors(xhr.responseJSON.errors);
					} else {
						Swal.fire({
							toast: true,
							position: 'top-end',
							icon: 'error',
							title: xhr.responseJSON?.message || 'Terjadi kesalahan.',
							showConfirmButton: false,
							timer: 3000,
							timerProgressBar: true,
						});
					}
				},
			});
		});

		$(document).on('click', '.btnDelete', function () {
			const id = $(this).data('id');

			Swal.fire({
				title: 'Hapus Employee?',
				text: 'Data yang dihapus tidak dapat dikembalikan.',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Ya, hapus',
				cancelButtonText: 'Batal',
				confirmButtonColor: '#dc3545',
			}).then(function (result) {
				if (!result.isConfirmed) return;

				$.ajax({
					url: '{{ url("admin/employee") }}/' + id,
					type: 'DELETE',
					data: { _token: CSRF },
					success: function (res) {
						table.ajax.reload(null, false);
						Swal.fire({
							toast: true,
							position: 'top-end',
							icon: 'success',
							title: res.message,
							showConfirmButton: false,
							timer: 3000,
							timerProgressBar: true,
						});
					},
					error: function (xhr) {
						Swal.fire({
							toast: true,
							position: 'top-end',
							icon: 'error',
							title: xhr.responseJSON?.message || 'Gagal menghapus.',
							showConfirmButton: false,
							timer: 3000,
							timerProgressBar: true,
						});
					},
				});
			});
		});
	</script>
@endsection
