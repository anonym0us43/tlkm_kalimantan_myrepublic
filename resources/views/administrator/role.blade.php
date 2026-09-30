@extends("layouts")

@section("title", "Role")

@section("breadcrumb")
	<li class="breadcrumb-item">Administrator</li>
	<li class="breadcrumb-item active">Role</li>
@endsection

@section("styles")
	<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/vendors/jquery.dataTables.css") }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset("assets/css/vendors/dataTables.bootstrap5.css") }}" />
@endsection

@section("content")
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h5 class="mb-0">Data Role</h5>
					<button type="button" class="btn btn-primary btn-sm" id="btnAdd">
						<i class="fa-solid fa-plus pe-2"></i>Tambah Role
					</button>
				</div>
				<div class="card-body admin-datatable">
					<div class="table-responsive">
						<table class="table table-hover" id="tblRole" width="100%">
							<thead>
								<tr>
									<th width="50">No</th>
									<th>Nama Role</th>
									<th width="130">Dibuat</th>
									<th width="130">Diperbarui</th>
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

	<div class="modal fade" id="modalRole" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalRoleTitle">Tambah Role</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<form id="formRole" novalidate>
					@csrf
					<input type="hidden" id="roleId" value="" />
					<div class="modal-body">
						<div class="mb-3">
							<label for="role_name" class="form-label fw-semibold">
								Nama Role
								<span class="text-danger">*</span>
							</label>
							<input type="text" class="form-control" id="role_name" name="name" maxlength="100" autocomplete="off" required />
							<div class="invalid-feedback" id="errRoleName"></div>
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
	<script>
		const CSRF = $('meta[name="csrf-token"]').attr('content');

		DataTable.ext.errMode = 'none';

		const table = $('#tblRole').DataTable({
			ajax: {
				url: '{{ route("ajax.role.data") }}',
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
				{ data: 'name' },
				{ data: 'created' },
				{ data: 'updated' },
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
			$('#formRole')[0].reset();
			$('#roleId').val('');
			$('#role_name').removeClass('is-invalid');
			$('#errRoleName').text('');
		}

		$('#btnAdd').on('click', function () {
			clearForm();
			$('#modalRoleTitle').text('Tambah Role');
			$('#modalRole').modal('show');
		});

		$(document).on('click', '.btnEdit', function () {
			const id = $(this).data('id');
			clearForm();
			$('#modalRoleTitle').text('Edit Role');

			$.get('{{ url("admin/role") }}/' + id, function (data) {
				$('#roleId').val(data.id);
				$('#role_name').val(data.name);
				$('#modalRole').modal('show');
			});
		});

		$('#formRole').on('submit', function (e) {
			e.preventDefault();

			const id = $('#roleId').val();
			const url = id ? '{{ url("admin/role") }}/' + id : '{{ route("admin.role.store") }}';
			const method = id ? 'PUT' : 'POST';

			$('#role_name').removeClass('is-invalid');
			$('#errRoleName').text('');

			$.ajax({
				url: url,
				type: method,
				data: { _token: CSRF, name: $('#role_name').val().trim() },
				success: function (res) {
					$('#modalRole').modal('hide');
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
					if (xhr.status === 422 && xhr.responseJSON.errors?.name) {
						$('#role_name').addClass('is-invalid');
						$('#errRoleName').text(xhr.responseJSON.errors.name[0]);
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
				title: 'Hapus Role?',
				text: 'Data yang dihapus tidak dapat dikembalikan.',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Ya, hapus',
				cancelButtonText: 'Batal',
				confirmButtonColor: '#dc3545',
			}).then(function (result) {
				if (!result.isConfirmed) return;

				$.ajax({
					url: '{{ url("admin/role") }}/' + id,
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
