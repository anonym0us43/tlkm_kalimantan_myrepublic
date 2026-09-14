@extends("layouts")

@section("title", "Dashboard")

@section("breadcrumb")
	<li class="breadcrumb-item active">Daily Report</li>
@endsection

@section("styles")
	<link rel="stylesheet" href="{{ asset('assets/css/vendors/select2.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/vendors/flatpickr/flatpickr.min.css') }}">
	<style>
		.report-header-group {
			font-size: 11px;
			font-weight: 700;
			letter-spacing: 0.06em;
			text-transform: uppercase;
			vertical-align: middle !important;
		}

		.report-header-slot {
			font-size: 10px;
			font-weight: 600;
			letter-spacing: 0.04em;
			text-transform: uppercase;
			vertical-align: middle !important;
		}

		.report-header-sub {
			font-size: 10px;
			font-weight: 600;
			white-space: nowrap;
			vertical-align: middle !important;
		}

		#tblDailyReport th,
		#tblDailyReport td {
			padding: 6px 8px;
			vertical-align: middle;
			border-color: #dee2e6;
		}

		#tblDailyReport thead tr:first-child th {
			border-top: none;
		}

		.th-area {
			min-width: 150px;
			background: #f8f9fa;
		}

		.th-unassign-group {
			background: #fff2f2;
			color: var(--brand-red);
			border-left: 2px solid var(--brand-red) !important;
			border-right: 2px solid var(--brand-red) !important;
		}

		.th-unassign {
			background: #fff8f8;
			border-left: 2px solid var(--brand-red) !important;
		}

		.th-unassign-last {
			border-right: 2px solid var(--brand-red) !important;
		}

		.th-unassign-total {
			background: #ffe0e0;
			color: var(--brand-red);
			font-weight: 700;
			border-right: 2px solid var(--brand-red) !important;
		}

		.th-onprogress-group {
			background: #f0eaff;
			color: var(--brand-purple);
			border-left: 2px solid var(--brand-purple) !important;
			border-right: 2px solid var(--brand-purple) !important;
		}

		.th-onprogress {
			background: #f8f5ff;
			border-left: 2px solid var(--brand-purple) !important;
		}

		.th-onprogress-last {
			border-right: 2px solid var(--brand-purple) !important;
		}

		.th-onprogress-total {
			background: #e8deff;
			color: var(--brand-purple);
			font-weight: 700;
			border-right: 2px solid var(--brand-purple) !important;
		}

		.th-tail {
			background: #f1f3f4;
			font-size: 10px;
			font-weight: 700;
			letter-spacing: 0.03em;
			text-transform: uppercase;
		}

		.td-area {
			font-weight: 600;
			font-size: 12.5px;
			white-space: nowrap;
			text-align: center;
			vertical-align: middle !important;
		}

		.td-unassign {
			border-left: 2px solid var(--brand-red) !important;
		}

		.td-unassign-total {
			font-weight: 700;
			color: var(--brand-red);
			background: #fff8f8;
			border-right: 2px solid var(--brand-red) !important;
		}

		.td-onprogress {
			border-left: 2px solid var(--brand-purple) !important;
		}

		.td-onprogress-total {
			font-weight: 700;
			color: var(--brand-purple);
			background: #f8f5ff;
			border-right: 2px solid var(--brand-purple) !important;
		}

		.td-num {
			text-align: center;
			font-size: 12.5px;
		}

		.td-num.zero {
			color: #ccc;
		}

		tr.row-total {
			background: #f8f9fa;
			font-weight: 700;
		}

		tr.row-total .td-area {
			color: #1a1726;
		}

		.filter-label {
			font-size: 12px;
			font-weight: 600;
			color: #495057;
			margin-bottom: 5px;
			display: block;
		}

		.filter-control {
			height: 40px;
			border: 1px solid #dee2e6;
			border-radius: 6px;
			font-size: 13.5px;
			color: #495057;
			background: #fff;
			width: 100%;
		}

		.select2-container {
			width: 100% !important;
		}

		.select2-container .select2-selection--single {
			height: 40px !important;
			border: 1px solid #dee2e6 !important;
			border-radius: 6px !important;
			background: #fff;
		}

		.select2-container--default .select2-selection--single .select2-selection__rendered {
			line-height: 40px !important;
			font-size: 13.5px !important;
			color: #495057 !important;
			padding-left: 12px !important;
		}

		.select2-container--default .select2-selection--single .select2-selection__placeholder {
			color: #adb5bd !important;
		}

		.select2-container--default .select2-selection--single .select2-selection__arrow {
			height: 38px !important;
			top: 1px !important;
			right: 4px !important;
		}

		.select2-container--default .select2-selection--single .select2-selection__clear {
			height: 40px;
			line-height: 40px;
		}

		.filter-date-wrap {
			position: relative;
		}

		.filter-date-wrap input.form-control {
			height: 40px;
			border: 1px solid #dee2e6;
			border-radius: 6px;
			font-size: 13.5px;
			color: #495057;
			padding-right: 38px;
			cursor: pointer;
		}

		.filter-date-wrap .filter-date-icon {
			position: absolute;
			right: 12px;
			top: 50%;
			transform: translateY(-50%);
			pointer-events: none;
			display: flex;
			align-items: center;
		}

		.filter-date-wrap .filter-date-icon svg {
			width: 15px;
			height: 15px;
			stroke: #adb5bd;
		}

		#spinnerReport {
			display: none;
		}

		.table-empty-msg {
			font-size: 13px;
			color: #9490b0;
			padding: 40px 0;
		}
	</style>
@endsection

@section("content")

	<div class="row mb-3">
		<div class="col-12">
			<div class="card">
				<div class="card-body py-3">
					<div class="row g-3 align-items-end">
						<div class="col-xl-3 col-md-6 col-12">
							<label class="filter-label" for="filterArea">Area</label>
							<select id="filterArea" class="form-select filter-select2" style="width:100%">
								<option value="">Semua Area</option>
								@foreach ($areas as $area)
									<option value="{{ e($area) }}">{{ e($area) }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-xl-3 col-md-6 col-12">
							<label class="filter-label" for="filterWoType">Tipe Work Order</label>
							<select id="filterWoType" class="form-select filter-select2" style="width:100%">
								<option value="">Semua Tipe</option>
								@foreach ($woTypes as $type)
									<option value="{{ e($type) }}">{{ e($type) }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-xl-3 col-md-6 col-12">
							<label class="filter-label" for="filterStartDate">Tanggal Awal</label>
							<div class="filter-date-wrap">
								<input
									type="text"
									id="filterStartDate"
									class="form-control"
									placeholder="Pilih tanggal awal"
									readonly
								/>
								<span class="filter-date-icon">
									<i data-feather="calendar"></i>
								</span>
							</div>
						</div>
						<div class="col-xl-3 col-md-6 col-12">
							<label class="filter-label" for="filterEndDate">Tanggal Akhir</label>
							<div class="filter-date-wrap">
								<input
									type="text"
									id="filterEndDate"
									class="form-control"
									placeholder="Pilih tanggal akhir"
									readonly
								/>
								<span class="filter-date-icon">
									<i data-feather="calendar"></i>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h5 class="mb-0">Daily Report</h5>
				</div>
				<div class="card-body p-0">
					<div class="text-center py-3" id="spinnerReport">
						<div class="spinner-border spinner-border-sm text-primary" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>
						<span class="ms-2 text-muted" style="font-size:13px">Memuat data...</span>
					</div>
					<div class="table-responsive" id="wrapTable">
						<table class="table table-bordered table-sm mb-0" id="tblDailyReport">
							<thead>
								<tr>
									<th class="th-area report-header-group text-center" rowspan="3">AREA</th>
									<th class="th-unassign-group report-header-group text-center" colspan="8">UN-ASSIGN</th>
									<th class="th-onprogress-group report-header-group text-center" colspan="8">ON-PROGRESS</th>
									<th class="th-tail report-header-group text-center align-middle" rowspan="3">VERIFICATION<br>AGENT</th>
									<th class="th-tail report-header-group text-center align-middle" rowspan="3">PENDING</th>
									<th class="th-tail report-header-group text-center align-middle" rowspan="3">CANCEL</th>
									<th class="th-tail report-header-group text-center align-middle" rowspan="3">COMPLETE</th>
								</tr>
								<tr>
									<th class="th-unassign report-header-slot text-center" colspan="7">SLOT TIME</th>
									<th class="th-unassign-total report-header-slot text-center" rowspan="2">TOTAL</th>
									<th class="th-onprogress report-header-slot text-center" colspan="7">SLOT TIME</th>
									<th class="th-onprogress-total report-header-slot text-center" rowspan="2">TOTAL</th>
								</tr>
								<tr>
									<th class="th-unassign report-header-sub text-center">09-11</th>
									<th class="th-unassign report-header-sub text-center">11-13</th>
									<th class="th-unassign report-header-sub text-center">13-15</th>
									<th class="th-unassign report-header-sub text-center">15-17</th>
									<th class="th-unassign report-header-sub text-center">17-19</th>
									<th class="th-unassign report-header-sub text-center">19-21</th>
									<th class="th-unassign th-unassign-last report-header-sub text-center">21-23</th>
									<th class="th-onprogress report-header-sub text-center">09-11</th>
									<th class="th-onprogress report-header-sub text-center">11-13</th>
									<th class="th-onprogress report-header-sub text-center">13-15</th>
									<th class="th-onprogress report-header-sub text-center">15-17</th>
									<th class="th-onprogress report-header-sub text-center">17-19</th>
									<th class="th-onprogress report-header-sub text-center">19-21</th>
									<th class="th-onprogress th-onprogress-last report-header-sub text-center">21-23</th>
								</tr>
							</thead>
							<tbody id="tbodyReport">
								<tr>
									<td colspan="21" class="table-empty-msg text-center">
										Pilih filter tanggal untuk memuat data.
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@section("scripts")
	<script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
	<script src="{{ asset('assets/js/flat-pickr/flatpickr.js') }}"></script>
	<script>
		const DAILY_REPORT_URL = '{{ route("ajax.daily.report") }}';

		function numCell(val, extraClass)
		{
			const display = val > 0 ? val : '';
			const zeroClass = val === 0 ? ' zero' : '';
			return `<td class="td-num${zeroClass}${extraClass ? ' ' + extraClass : ''}">${display}</td>`;
		}

		function buildRow(row, isTotal)
		{
			const rowClass = isTotal ? ' class="row-total"' : '';
			const areaLabel = isTotal ? 'NASIONAL' : row.area;

			return `<tr${rowClass}>
				<td class="td-area">${areaLabel}</td>
				${numCell(row.unassign_09to11, 'td-unassign')}
				${numCell(row.unassign_11to13, 'td-unassign')}
				${numCell(row.unassign_13to15, 'td-unassign')}
				${numCell(row.unassign_15to17, 'td-unassign')}
				${numCell(row.unassign_17to19, 'td-unassign')}
				${numCell(row.unassign_19to21, 'td-unassign')}
				${numCell(row.unassign_21to23, 'td-unassign')}
				<td class="td-num td-unassign-total">${row.unassign_total > 0 ? row.unassign_total : (isTotal ? 0 : '')}</td>
				${numCell(row.onprogress_09to11, 'td-onprogress')}
				${numCell(row.onprogress_11to13, 'td-onprogress')}
				${numCell(row.onprogress_13to15, 'td-onprogress')}
				${numCell(row.onprogress_15to17, 'td-onprogress')}
				${numCell(row.onprogress_17to19, 'td-onprogress')}
				${numCell(row.onprogress_19to21, 'td-onprogress')}
				${numCell(row.onprogress_21to23, 'td-onprogress')}
				<td class="td-num td-onprogress-total">${row.onprogress_total > 0 ? row.onprogress_total : (isTotal ? 0 : '')}</td>
				${numCell(row.verification_agent, '')}
				${numCell(row.wo_pending, '')}
				${numCell(row.wo_cancel, '')}
				${numCell(row.wo_complete, '')}
			</tr>`;
		}

		function sumField(data, field)
		{
			return data.reduce((acc, row) => acc + (row[field] || 0), 0);
		}

		function renderTable(data)
		{
			const tbody = document.getElementById('tbodyReport');

			if (!data.length)
			{
				tbody.innerHTML = `<tr><td colspan="21" class="table-empty-msg text-center">Tidak ada data untuk filter yang dipilih.</td></tr>`;
				return;
			}

			const numericFields = [
				'unassign_09to11', 'unassign_11to13', 'unassign_13to15', 'unassign_15to17',
				'unassign_17to19', 'unassign_19to21', 'unassign_21to23', 'unassign_total',
				'onprogress_09to11', 'onprogress_11to13', 'onprogress_13to15', 'onprogress_15to17',
				'onprogress_17to19', 'onprogress_19to21', 'onprogress_21to23', 'onprogress_total',
				'verification_agent', 'wo_pending', 'wo_cancel', 'wo_complete',
			];

			const grandTotal = { area: 'TOTAL' };
			numericFields.forEach(f => grandTotal[f] = sumField(data, f));

			const rows = data.map(row => buildRow(row, false)).join('');
			const totalRow = buildRow(grandTotal, true);

			tbody.innerHTML = rows + totalRow;
		}

		function loadReport()
		{
			const startDate = document.getElementById('filterStartDate').value;
			const endDate   = document.getElementById('filterEndDate').value;
			const area      = $('#filterArea').val();
			const woType    = $('#filterWoType').val();

			if (!startDate || !endDate)
			{
				return;
			}

			document.getElementById('spinnerReport').style.display  = 'block';
			document.getElementById('wrapTable').style.display       = 'none';

			const params = new URLSearchParams({ start_date: startDate, end_date: endDate });
			if (area)    params.set('area', area);
			if (woType)  params.set('wo_type', woType);

			$.ajax({
				url: DAILY_REPORT_URL + '?' + params.toString(),
				type: 'GET',
				success: function (res)
				{
					renderTable(res.data || []);
				},
				error: function (xhr)
				{
					document.getElementById('tbodyReport').innerHTML =
						`<tr><td colspan="21" class="table-empty-msg text-center text-danger">
							Gagal memuat data. ${xhr.responseJSON?.message || ''}
						</td></tr>`;
				},
				complete: function ()
				{
					document.getElementById('spinnerReport').style.display = 'none';
					document.getElementById('wrapTable').style.display      = 'block';
					feather.replace();
				},
			});
		}

		$('.filter-select2').select2({
			width: '100%',
			allowClear: true,
			placeholder: function ()
			{
				return $(this).data('placeholder') || 'Pilih...';
			},
		});

		$('#filterArea').data('placeholder', 'Semua Area');
		$('#filterWoType').data('placeholder', 'Semua Tipe');

		feather.replace();

		$('.filter-select2').on('change', function ()
		{
			loadReport();
		});

		const today = '{{ date("Y-m-d") }}';

		flatpickr('#filterStartDate', {
			dateFormat: 'Y-m-d',
			defaultDate: today,
			locale: { firstDayOfWeek: 1 },
			onChange: function ()
			{
				loadReport();
			},
		});

		flatpickr('#filterEndDate', {
			dateFormat: 'Y-m-d',
			defaultDate: today,
			locale: { firstDayOfWeek: 1 },
			onChange: function ()
			{
				loadReport();
			},
		});

		loadReport();
	</script>
@endsection
