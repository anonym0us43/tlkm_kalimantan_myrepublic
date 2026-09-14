@extends("layouts")

@section("title", "Area")

@section("breadcrumb")
	<li class="breadcrumb-item">Administrator</li>
	<li class="breadcrumb-item active">Area</li>
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
					<h5 class="mb-0">Data Area</h5>
					<button type="button" class="btn btn-primary btn-sm" id="btnAdd">
						<i data-feather="plus" class="me-1" style="width: 14px; height: 14px"></i>
						Tambah Area
					</button>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-hover" id="tblArea" width="100%">
							<thead>
								<tr>
									<th width="50">No</th>
									<th width="80">Kode</th>
									<th width="70">Inisial</th>
									<th>Nama Area</th>
									<th width="120">Diperbarui</th>
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

	<div class="modal fade" id="modalArea" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalAreaTitle">Tambah Area</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
				</div>
				<form id="formArea" novalidate>
					@csrf
					<input type="hidden" id="areaId" value="" />
					<div class="modal-body">
						<div class="row g-3">
							<div class="col-12">
								<label for="area_name" class="form-label fw-semibold">
									Nama Area
									<span class="text-danger">*</span>
								</label>
								<input
									type="text"
									class="form-control"
									id="area_name"
									name="name"
									maxlength="100"
									autocomplete="off"
									required
								/>
								<div class="invalid-feedback" id="errAreaName"></div>
							</div>
							<div class="col-md-6">
								<label for="area_code" class="form-label fw-semibold">Kode</label>
								<input type="number" class="form-control" id="area_code" name="code" autocomplete="off" />
								<div class="invalid-feedback" id="errAreaCode"></div>
							</div>
							<div class="col-md-6">
								<label for="area_initial" class="form-label fw-semibold">Inisial</label>
								<input type="text" class="form-control" id="area_initial" name="initial" maxlength="3" autocomplete="off" />
								<div class="invalid-feedback" id="errAreaInitial"></div>
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
	<script>
		const CSRF = $('meta[name="csrf-token"]').attr('content');

		DataTable.ext.errMode = 'none';

		const table = $('#tblArea').DataTable({
			ajax: {
				url: '{{ route("ajax.area.data") }}',
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
				{ data: 'code' },
				{ data: 'initial' },
				{ data: 'name' },
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
			$('#formArea')[0].reset();
			$('#areaId').val('');
			$('#area_name, #area_code, #area_initial').removeClass('is-invalid');
			$('#errAreaName, #errAreaCode, #errAreaInitial').text('');
		}

		$('#btnAdd').on('click', function () {
			clearForm();
			$('#modalAreaTitle').text('Tambah Area');
			$('#modalArea').modal('show');
		});

		$(document).on('click', '.btnEdit', function () {
			const id = $(this).data('id');
			clearForm();
			$('#modalAreaTitle').text('Edit Area');

			$.get('{{ url("admin/area") }}/' + id, function (data) {
				$('#areaId').val(data.id);
				$('#area_name').val(data.name);
				$('#area_code').val(data.code);
				$('#area_initial').val(data.initial);
				$('#modalArea').modal('show');
			});
		});

		$('#formArea').on('submit', function (e) {
			e.preventDefault();

			const id = $('#areaId').val();
			const url = id ? '{{ url("admin/area") }}/' + id : '{{ route("admin.area.store") }}';
			const method = id ? 'PUT' : 'POST';

			$('#area_name, #area_code, #area_initial').removeClass('is-invalid');
			$('#errAreaName, #errAreaCode, #errAreaInitial').text('');

			$.ajax({
				url: url,
				type: method,
				data: {
					_token: CSRF,
					name: $('#area_name').val().trim(),
					code: $('#area_code').val(),
					initial: $('#area_initial').val().trim(),
				},
				success: function (res) {
					$('#modalArea').modal('hide');
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
						const e = xhr.responseJSON.errors;
						if (e.name) {
							$('#area_name').addClass('is-invalid');
							$('#errAreaName').text(e.name[0]);
						}
						if (e.code) {
							$('#area_code').addClass('is-invalid');
							$('#errAreaCode').text(e.code[0]);
						}
						if (e.initial) {
							$('#area_initial').addClass('is-invalid');
							$('#errAreaInitial').text(e.initial[0]);
						}
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
				title: 'Hapus Area?',
				text: 'Data yang dihapus tidak dapat dikembalikan.',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Ya, hapus',
				cancelButtonText: 'Batal',
				confirmButtonColor: '#dc3545',
			}).then(function (result) {
				if (!result.isConfirmed) return;

				$.ajax({
					url: '{{ url("admin/area") }}/' + id,
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
