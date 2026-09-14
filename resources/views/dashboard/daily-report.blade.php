@extends("layouts")

@section("title", "Daily Report")

@section("breadcrumb")
	<li class="breadcrumb-item active">Daily Report</li>
@endsection

@section("styles")
	<link rel="stylesheet" href="{{ asset("assets/css/vendors/select2.css") }}" />
	<link rel="stylesheet" href="{{ asset("assets/css/vendors/flatpickr/flatpickr.min.css") }}" />
	<link rel="stylesheet" href="{{ asset("assets/css/vendors/jquery.dataTables.css") }}" />
	<link rel="stylesheet" href="{{ asset("assets/css/vendors/dataTables.bootstrap5.css") }}" />
	<link rel="stylesheet" href="{{ asset("assets/css/vendors/buttons.bootstrap5.css") }}" />
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
			background: #f4f5f7 !important;
			color: #3d3a4e !important;
		}

		.th-unassign-group {
			background: #fde8ec !important;
			color: #b00c26 !important;
		}

		.th-unassign {
			background: #fff4f6 !important;
			color: #c8102e !important;
		}

		.th-unassign-last {
		}

		.th-unassign-total {
			background: #fcd5db !important;
			color: #b00c26 !important;
			font-weight: 700;
		}

		.th-onprogress-group {
			background: #ede3fb !important;
			color: #4a0b8a !important;
		}

		.th-onprogress {
			background: #f6f0ff !important;
			color: #5b0ea6 !important;
		}

		.th-onprogress-last {
		}

		.th-onprogress-total {
			background: #dfd0f9 !important;
			color: #4a0b8a !important;
			font-weight: 700;
		}

		#tblDailyReport thead th {
			font-weight: 700 !important;
		}

		.th-verification {
			background: #e2edff !important;
			color: #1a4fc4 !important;
			font-size: 10px;
			letter-spacing: 0.03em;
			text-transform: uppercase;
		}

		.th-pending {
			background: #fef3e2 !important;
			color: #92400e !important;
			font-size: 10px;
			letter-spacing: 0.03em;
			text-transform: uppercase;
		}

		.th-cancel {
			background: #fce7e7 !important;
			color: #991b1b !important;
			font-size: 10px;
			letter-spacing: 0.03em;
			text-transform: uppercase;
		}

		.th-complete {
			background: #e6f7ee !important;
			color: #166534 !important;
			font-size: 10px;
			letter-spacing: 0.03em;
			text-transform: uppercase;
		}

		.td-area {
			font-size: 12.5px;
			white-space: nowrap;
			text-align: center;
			vertical-align: middle !important;
		}

		.td-unassign {
			background: #fff4f6;
		}

		.td-unassign-total {
			color: var(--brand-red);
			background: #fcd5db;
		}

		.td-onprogress {
			background: #f6f0ff;
		}

		.td-onprogress-total {
			color: var(--brand-purple);
			background: #dfd0f9;
		}

		.s2-checkbox-item {
			display: flex;
			align-items: center;
			gap: 8px;
			padding: 1px 0;
		}

		.s2-checkbox-item .s2-box {
			width: 15px;
			height: 15px;
			border: 1.5px solid #ced4da;
			border-radius: 3px;
			display: flex;
			align-items: center;
			justify-content: center;
			flex-shrink: 0;
			transition:
				background 0.15s,
				border-color 0.15s;
		}

		.select2-results__option--selected .s2-box,
		.select2-results__option[aria-selected='true'] .s2-box {
			background: var(--brand-purple);
			border-color: var(--brand-purple);
		}

		.select2-results__option--selected .s2-box::after,
		.select2-results__option[aria-selected='true'] .s2-box::after {
			content: '✓';
			display: block;
			color: #fff;
			font-size: 11px;
			font-weight: 700;
			line-height: 1;
		}

		.select2-results__option--selected {
			background-color: rgba(91, 14, 166, 0.06) !important;
			color: inherit !important;
		}

		.select2-container--default .select2-results__option--highlighted[aria-selected] {
			background-color: rgba(91, 14, 166, 0.1) !important;
			color: #1e1b2e !important;
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
			display: flex;
			align-items: center;
			gap: 5px;
		}

		.filter-label-icon {
			width: 13px;
			height: 13px;
			stroke: #5b0ea6;
			flex-shrink: 0;
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

		.select2-container .select2-selection--multiple {
			position: relative !important;
			height: 40px !important;
			border: 1px solid #dee2e6 !important;
			border-radius: 6px !important;
			background: #fff;
			padding: 0 28px 0 8px !important;
			cursor: pointer;
			overflow: hidden;
		}

		.select2-container--default .select2-selection--multiple .select2-selection__rendered {
			display: flex !important;
			align-items: center;
			flex-wrap: nowrap;
			padding: 0 !important;
			height: 38px;
			overflow: hidden;
		}

		.select2-container--default .select2-selection--multiple .select2-selection__placeholder {
			color: #adb5bd !important;
			font-size: 13.5px !important;
			line-height: 38px !important;
			margin: 0 !important;
		}

		.select2-container--default .select2-selection--multiple .select2-selection__choice {
			display: none !important;
		}

		.wo-type-summary {
			font-size: 13.5px !important;
			color: #495057 !important;
			line-height: 38px !important;
			white-space: nowrap !important;
			overflow: hidden !important;
			text-overflow: ellipsis !important;
			max-width: 100% !important;
			list-style: none !important;
			padding: 0 !important;
			margin: 0 !important;
			flex-shrink: 1 !important;
		}

		.select2-container--default .select2-selection--multiple .select2-search--inline {
			display: none !important;
		}

		.select2-container--default .select2-selection--multiple .select2-selection__clear {
			position: absolute !important;
			right: 8px !important;
			top: 50% !important;
			transform: translateY(-50%) !important;
			color: #adb5bd !important;
			font-size: 18px !important;
			line-height: 1 !important;
			margin: 0 !important;
			z-index: 1;
		}

		.select2-container--default .select2-selection--multiple .select2-selection__clear:hover {
			color: #6c757d !important;
		}

		#s2-filterWoType-container,
		.select2-container--default .select2-selection--multiple .select2-selection__rendered .select2-search--inline input {
			display: none !important;
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

		#tblDetail td,
		#tblDetail th {
			white-space: nowrap;
			vertical-align: middle;
			font-size: 12.5px;
		}

		#modalDetail .modal-title {
			flex: 1;
			min-width: 0;
			overflow: hidden;
			white-space: nowrap;
			text-overflow: ellipsis;
		}

		#modalDetail .modal-header .d-flex {
			flex-shrink: 0;
		}

		#modalDetail .dataTables_filter input {
			min-width: 160px;
		}

		.td-clickable {
			cursor: pointer;
		}

		.td-clickable:hover {
			background-color: rgba(91, 14, 166, 0.06) !important;
		}

		.td-dash {
			color: #ccc;
		}
	</style>
@endsection

@section("content")
	<div class="row mb-3">
		<div class="col-12">
			<div class="card">
				<div class="card-body py-2 px-3">
					<div class="row row-cols-xl-4 row-cols-md-2 row-cols-1 g-2">
						<div class="col">
							<label class="filter-label" for="filterArea">
								<i data-feather="map-pin" class="filter-label-icon"></i>
								Area
							</label>
							<select id="filterArea" class="form-select filter-select2" style="width: 100%">
								<option value="">Semua Area</option>
								@foreach ($areas as $area)
									<option value="{{ e($area) }}">{{ e($area) }}</option>
								@endforeach
							</select>
						</div>
						<div class="col">
							<label class="filter-label" for="filterWoType">
								<i data-feather="layers" class="filter-label-icon"></i>
								Tipe Work Order
							</label>
							<select id="filterWoType" class="form-select" style="width: 100%" multiple>
								@foreach ($woTypes as $type)
									<option value="{{ e($type) }}">{{ e($type) }}</option>
								@endforeach
							</select>
						</div>
						<div class="col">
							<label class="filter-label" for="filterStartDate">
								<i data-feather="calendar" class="filter-label-icon"></i>
								Tanggal Awal
							</label>
							<div class="filter-date-wrap">
								<input type="text" id="filterStartDate" class="form-control" placeholder="Pilih tanggal awal" readonly />
								<span class="filter-date-icon">
									<i data-feather="calendar"></i>
								</span>
							</div>
						</div>
						<div class="col">
							<label class="filter-label" for="filterEndDate">
								<i data-feather="calendar" class="filter-label-icon"></i>
								Tanggal Akhir
							</label>
							<div class="filter-date-wrap">
								<input type="text" id="filterEndDate" class="form-control" placeholder="Pilih tanggal akhir" readonly />
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

	<div class="row mb-3">
		<div class="col-xl-3 col-sm-6 col-12">
			<div class="card small-widget mb-0">
				<div class="card-body primary">
					<span class="f-light">On Time Rate</span>
					<div class="d-flex align-items-end gap-1">
						<h4 id="kpiOtr">—</h4>
						<span class="font-primary f-12 f-w-500">Target 95%</span>
					</div>
					<p class="f-light mb-0" style="font-size: 11px" id="kpiOtrFormula">— / — WO</p>
					<div class="bg-gradient">
						<svg class="stroke-icon svg-fill">
							<use href="{{ asset("assets/svg/icon-sprite.svg#clock") }}"></use>
						</svg>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-sm-6 col-12">
			<div class="card small-widget mb-0">
				<div class="card-body secondary">
					<span class="f-light">Visit Rate</span>
					<div class="d-flex align-items-end gap-1">
						<h4 id="kpiVr">—</h4>
						<span class="font-secondary f-12 f-w-500">Target 95%</span>
					</div>
					<p class="f-light mb-0" style="font-size: 11px" id="kpiVrFormula">— / — WO</p>
					<div class="bg-gradient">
						<svg class="stroke-icon svg-fill">
							<use href="{{ asset("assets/svg/icon-sprite.svg#user-visitor") }}"></use>
						</svg>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-sm-6 col-12">
			<div class="card small-widget mb-0">
				<div class="card-body warning">
					<span class="f-light">SLA 24 Jam</span>
					<div class="d-flex align-items-end gap-1">
						<h4 id="kpiSla">—</h4>
						<span class="font-warning f-12 f-w-500">Target 95%</span>
					</div>
					<p class="f-light mb-0" style="font-size: 11px" id="kpiSlaFormula">— / — WO</p>
					<div class="bg-gradient">
						<svg class="stroke-icon svg-fill">
							<use href="{{ asset("assets/svg/icon-sprite.svg#analytics-rate") }}"></use>
						</svg>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-3 col-sm-6 col-12">
			<div class="card small-widget mb-0">
				<div class="card-body success">
					<span class="f-light">Success Rate</span>
					<div class="d-flex align-items-end gap-1">
						<h4 id="kpiSr">—</h4>
						<span class="font-success f-12 f-w-500">Target 93%</span>
					</div>
					<p class="f-light mb-0" style="font-size: 11px" id="kpiSrFormula">— / — WO</p>
					<div class="bg-gradient">
						<svg class="stroke-icon svg-fill">
							<use href="{{ asset("assets/svg/icon-sprite.svg#ord-success") }}"></use>
						</svg>
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
						<span class="ms-2 text-muted" style="font-size: 13px">Memuat data...</span>
					</div>
					<div class="table-responsive" id="wrapTable">
						<table class="table table-bordered table-sm mb-0" id="tblDailyReport">
							<thead>
								<tr>
									<th class="th-area report-header-group text-center" rowspan="3">AREA</th>
									<th class="th-unassign-group report-header-group text-center" colspan="8">UN-ASSIGN</th>
									<th class="th-onprogress-group report-header-group text-center" colspan="8">ON-PROGRESS</th>
									<th class="th-verification report-header-group text-center align-middle" rowspan="3">
										VERIFICATION
										<br />
										AGENT
									</th>
									<th class="th-pending report-header-group text-center align-middle" rowspan="3">PENDING</th>
									<th class="th-cancel report-header-group text-center align-middle" rowspan="3">CANCEL</th>
									<th class="th-complete report-header-group text-center align-middle" rowspan="3">COMPLETE</th>
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
									<td colspan="21" class="table-empty-msg text-center">Pilih filter tanggal untuk memuat data.</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header py-2 px-3">
					<h6 class="modal-title mb-0" id="modalDetailTitle">Detail</h6>
					<div class="d-flex align-items-center gap-2">
						<button type="button" class="btn btn-sm btn-success" id="btnExcelDetail" hidden>
							<i data-feather="download" style="width: 13px; height: 13px; margin-right: 4px; vertical-align: middle"></i>
							Excel
						</button>
						<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
					</div>
				</div>
				<div class="modal-body p-3">
					<div id="spinnerDetail" class="text-center py-4">
						<div class="spinner-border spinner-border-sm text-primary" role="status"></div>
						<span class="ms-2 text-muted" style="font-size: 13px">Memuat data...</span>
					</div>
					<div id="wrapDetail" hidden>
						<table class="table table-hover table-bordered table-sm w-100" id="tblDetail">
							<thead>
								<tr>
									<th width="40">No</th>
									<th>Tipe WO</th>
									<th>Plan</th>
									<th>ID Customer</th>
									<th>WO Number</th>
									<th>Tanggal</th>
									<th>Slot Time</th>
									<th>Installer</th>
									<th>WO Agent</th>
									<th>Alasan Agent</th>
									<th>Status Installer</th>
									<th>Alasan Installer</th>
									<th>Remarks</th>
									<th>Updated At</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section("scripts")
	<script src="{{ asset("assets/js/select2/select2.full.min.js") }}"></script>
	<script src="{{ asset("assets/js/flat-pickr/flatpickr.js") }}"></script>
	<script src="{{ asset("assets/js/datatable/datatables/dataTables.js") }}"></script>
	<script src="{{ asset("assets/js/datatable/datatables/dataTables.bootstrap5.js") }}"></script>
	<script src="{{ asset("assets/js/datatable/datatable-extension/jszip.min.js") }}"></script>
	<script src="{{ asset("assets/js/datatable/datatable-extension/dataTables.buttons.js") }}"></script>
	<script src="{{ asset("assets/js/datatable/datatable-extension/buttons.bootstrap5.js") }}"></script>
	<script src="{{ asset("assets/js/datatable/datatable-extension/buttons.html5.min.js") }}"></script>
	<script>
		const DAILY_REPORT_URL = '{{ route("ajax.daily.report") }}';
		const KPI_URL = '{{ route("ajax.daily.report.kpi") }}';

		function esc(s) {
			return String(s ?? '').replace(/[&<>"']/g, function (c) {
				return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
			});
		}

		function numCell(val, extraClass, col, area) {
			const cls = 'td-num' + (extraClass ? ' ' + extraClass : '');

			if (val > 0) {
				return `<td class="${cls} td-clickable" data-col="${col}" data-area="${esc(area)}">${val}</td>`;
			}

			return `<td class="${cls} td-dash">-</td>`;
		}

		function buildRow(row, isTotal) {
			const rowClass = isTotal ? ' class="row-total"' : '';
			const areaLabel = isTotal ? 'NASIONAL' : row.area;
			const clickArea = isTotal ? '' : (row.area ?? '');

			return `<tr${rowClass}>
				<td class="td-area">${areaLabel}</td>
				${numCell(row.unassign_09to11, 'td-unassign', 'unassign_09to11', clickArea)}
				${numCell(row.unassign_11to13, 'td-unassign', 'unassign_11to13', clickArea)}
				${numCell(row.unassign_13to15, 'td-unassign', 'unassign_13to15', clickArea)}
				${numCell(row.unassign_15to17, 'td-unassign', 'unassign_15to17', clickArea)}
				${numCell(row.unassign_17to19, 'td-unassign', 'unassign_17to19', clickArea)}
				${numCell(row.unassign_19to21, 'td-unassign', 'unassign_19to21', clickArea)}
				${numCell(row.unassign_21to23, 'td-unassign', 'unassign_21to23', clickArea)}
				${numCell(row.unassign_total, 'td-unassign-total', 'unassign_total', clickArea)}
				${numCell(row.onprogress_09to11, 'td-onprogress', 'onprogress_09to11', clickArea)}
				${numCell(row.onprogress_11to13, 'td-onprogress', 'onprogress_11to13', clickArea)}
				${numCell(row.onprogress_13to15, 'td-onprogress', 'onprogress_13to15', clickArea)}
				${numCell(row.onprogress_15to17, 'td-onprogress', 'onprogress_15to17', clickArea)}
				${numCell(row.onprogress_17to19, 'td-onprogress', 'onprogress_17to19', clickArea)}
				${numCell(row.onprogress_19to21, 'td-onprogress', 'onprogress_19to21', clickArea)}
				${numCell(row.onprogress_21to23, 'td-onprogress', 'onprogress_21to23', clickArea)}
				${numCell(row.onprogress_total, 'td-onprogress-total', 'onprogress_total', clickArea)}
				${numCell(row.verification_agent, '', 'verification_agent', clickArea)}
				${numCell(row.wo_pending, '', 'wo_pending', clickArea)}
				${numCell(row.wo_cancel, '', 'wo_cancel', clickArea)}
				${numCell(row.wo_complete, '', 'wo_complete', clickArea)}
			</tr>`;
		}

		function sumField(data, field) {
			return data.reduce((acc, row) => acc + (row[field] || 0), 0);
		}

		function renderTable(data) {
			const tbody = document.getElementById('tbodyReport');

			if (!data.length) {
				tbody.innerHTML = `<tr><td colspan="21" class="table-empty-msg text-center">Tidak ada data untuk filter yang dipilih.</td></tr>`;
				return;
			}

			const numericFields = [
				'unassign_09to11',
				'unassign_11to13',
				'unassign_13to15',
				'unassign_15to17',
				'unassign_17to19',
				'unassign_19to21',
				'unassign_21to23',
				'unassign_total',
				'onprogress_09to11',
				'onprogress_11to13',
				'onprogress_13to15',
				'onprogress_15to17',
				'onprogress_17to19',
				'onprogress_19to21',
				'onprogress_21to23',
				'onprogress_total',
				'verification_agent',
				'wo_pending',
				'wo_cancel',
				'wo_complete',
			];

			const grandTotal = { area: 'TOTAL' };
			numericFields.forEach((f) => (grandTotal[f] = sumField(data, f)));

			const rows = data.map((row) => buildRow(row, false)).join('');
			const totalRow = buildRow(grandTotal, true);

			tbody.innerHTML = rows + totalRow;
		}

		function setKpiCard(valId, formulaId, value, formula) {
			document.getElementById(valId).textContent = value.toFixed(2).replace('.', ',') + '%';
			document.getElementById(formulaId).textContent = formula;
		}

		function resetKpiCards() {
			['kpiOtr', 'kpiVr', 'kpiSla', 'kpiSr'].forEach(function (id) {
				document.getElementById(id).textContent = '—';
			});
			['kpiOtrFormula', 'kpiVrFormula', 'kpiSlaFormula', 'kpiSrFormula'].forEach(function (id) {
				document.getElementById(id).textContent = '— / — WO';
			});
		}

		function loadKpi(params) {
			$.ajax({
				url: KPI_URL + '?' + params.toString(),
				type: 'GET',
				success: function (res) {
					const d = res.data;
					setKpiCard('kpiOtr', 'kpiOtrFormula', d.on_time_rate, d.on_time_formula);
					setKpiCard('kpiVr', 'kpiVrFormula', d.visit_rate, d.visit_formula);
					setKpiCard('kpiSla', 'kpiSlaFormula', d.sla24_rate, d.sla24_formula);
					setKpiCard('kpiSr', 'kpiSrFormula', d.success_rate, d.success_formula);
				},
			});
		}

		function loadReport() {
			const startDate = document.getElementById('filterStartDate').value;
			const endDate = document.getElementById('filterEndDate').value;
			const area = $('#filterArea').val();
			const woTypes = $('#filterWoType').val() || [];

			if (!startDate || !endDate) {
				resetKpiCards();
				return;
			}

			document.getElementById('spinnerReport').style.display = 'block';
			document.getElementById('wrapTable').style.display = 'none';

			const params = new URLSearchParams({ start_date: startDate, end_date: endDate });
			if (area) params.set('area', area);
			woTypes.forEach(function (t) {
				params.append('wo_type[]', t);
			});

			loadKpi(params);

			$.ajax({
				url: DAILY_REPORT_URL + '?' + params.toString(),
				type: 'GET',
				success: function (res) {
					renderTable(res.data || []);
				},
				error: function (xhr) {
					document.getElementById('tbodyReport').innerHTML =
						`<tr><td colspan="21" class="table-empty-msg text-center text-danger">
							Gagal memuat data. ${xhr.responseJSON?.message || ''}
						</td></tr>`;
				},
				complete: function () {
					document.getElementById('spinnerReport').style.display = 'none';
					document.getElementById('wrapTable').style.display = 'block';
					feather.replace();
				},
			});
		}

		$('#filterArea').select2({
			width: '100%',
			allowClear: true,
			placeholder: 'Semua Area',
		});

		$('#filterWoType').select2({
			width: '100%',
			allowClear: true,
			placeholder: 'Semua Tipe',
			closeOnSelect: false,
			templateResult: function (data) {
				if (!data.id) return $('<span>' + data.text + '</span>');
				return $('<span class="s2-checkbox-item"><span class="s2-box"></span><span>' + data.text + '</span></span>');
			},
		});

		function refreshWoTypeDisplay() {
			const texts = $('#filterWoType option:selected')
				.map(function () {
					return $(this).text();
				})
				.get();
			const $rendered = $('#filterWoType').next('.select2-container').find('.select2-selection__rendered');
			$rendered.find('.wo-type-summary').remove();
			if (texts.length) {
				$rendered.prepend('<li class="wo-type-summary">' + texts.join(', ') + '</li>');
			}
		}

		$('#filterWoType').on('select2:select select2:unselect select2:clear', function () {
			refreshWoTypeDisplay();
		});

		feather.replace();

		$('#filterArea, #filterWoType').on('change', function () {
			loadReport();
		});

		const today = '{{ date("Y-m-d") }}';

		flatpickr('#filterStartDate', {
			dateFormat: 'Y-m-d',
			defaultDate: today,
			locale: { firstDayOfWeek: 1 },
			onChange: function () {
				loadReport();
			},
		});

		flatpickr('#filterEndDate', {
			dateFormat: 'Y-m-d',
			defaultDate: today,
			locale: { firstDayOfWeek: 1 },
			onChange: function () {
				loadReport();
			},
		});

		loadReport();

		const DETAIL_URL = '{{ route("ajax.daily.report.detail") }}';

		const COL_LABELS = {
			unassign_09to11: 'Un-Assign 09-11',
			unassign_11to13: 'Un-Assign 11-13',
			unassign_13to15: 'Un-Assign 13-15',
			unassign_15to17: 'Un-Assign 15-17',
			unassign_17to19: 'Un-Assign 17-19',
			unassign_19to21: 'Un-Assign 19-21',
			unassign_21to23: 'Un-Assign 21-23',
			unassign_total: 'Un-Assign Total',
			onprogress_09to11: 'On-Progress 09-11',
			onprogress_11to13: 'On-Progress 11-13',
			onprogress_13to15: 'On-Progress 13-15',
			onprogress_15to17: 'On-Progress 15-17',
			onprogress_17to19: 'On-Progress 17-19',
			onprogress_19to21: 'On-Progress 19-21',
			onprogress_21to23: 'On-Progress 21-23',
			onprogress_total: 'On-Progress Total',
			verification_agent: 'Verification Agent',
			wo_pending: 'Pending',
			wo_cancel: 'Cancel',
			wo_complete: 'Complete',
		};

		let detailTable = null;

		$('#tblDailyReport').on('click', '.td-clickable', function () {
			const col = $(this).data('col');
			const area = $(this).data('area');
			const startDate = document.getElementById('filterStartDate').value;
			const endDate = document.getElementById('filterEndDate').value;
			const woTypes = $('#filterWoType').val() || [];

			$('#modalDetailTitle').text((COL_LABELS[col] || col) + ' — ' + (area || 'NASIONAL'));

			$('#spinnerDetail').show();
			$('#wrapDetail').attr('hidden', true);

			$('#modalDetail').modal('show');

			const params = new URLSearchParams({ start_date: startDate, end_date: endDate, column: col });
			if (area) params.set('area', area);
			woTypes.forEach(function (t) {
				params.append('wo_type[]', t);
			});

			$.ajax({
				url: DETAIL_URL + '?' + params.toString(),
				type: 'GET',
				success: function (res) {
					if (detailTable) {
						detailTable.destroy();
						$('#tblDetail tbody').empty();
					}

					$('#spinnerDetail').hide();
					$('#wrapDetail').removeAttr('hidden');
					$('#btnExcelDetail').removeAttr('hidden');
					feather.replace();

					detailTable = $('#tblDetail').DataTable({
						data: res.data || [],
						autoWidth: false,
						scrollX: true,
						dom: "<'d-flex justify-content-between align-items-center mb-2'lf>tr<'d-flex justify-content-between align-items-center mt-2'ip>",
						buttons: [
							{
								extend: 'excel',
								title: $('#modalDetailTitle').text(),
							},
						],
						columns: [
							{ title: 'No', data: null, render: (d, t, r, m) => m.row + 1, width: '40px', orderable: false },
							{ title: 'Tipe WO', data: 'wo_type' },
							{ title: 'Plan', data: 'plan' },
							{ title: 'ID Customer', data: 'id_customer' },
							{ title: 'WO Number', data: 'wo_number' },
							{ title: 'Tanggal', data: 'date_wo' },
							{ title: 'Slot Time', data: 'slot_time' },
							{ title: 'Installer', data: 'installer' },
							{ title: 'WO Agent', data: 'wo_agent' },
							{ title: 'Alasan Agent', data: 'wo_reason_agent' },
							{ title: 'Status Installer', data: 'wo_installer' },
							{ title: 'Alasan Installer', data: 'wo_reason_installer' },
							{ title: 'Remarks', data: 'wo_remarks' },
							{ title: 'Updated At', data: 'updated_at' },
						],
						pageLength: 25,
						language: {
							emptyTable: 'Tidak ada data',
							search: 'Cari:',
							lengthMenu: 'Tampilkan _MENU_ data',
							info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
							infoEmpty: 'Tidak ada data',
							infoFiltered: '(disaring dari _MAX_ total data)',
							zeroRecords: 'Data tidak ditemukan',
							paginate: { first: '&laquo;', last: '&raquo;', next: '&rsaquo;', previous: '&lsaquo;' },
						},
					});
				},
				error: function () {
					$('#spinnerDetail').hide();
					$('#wrapDetail').removeAttr('hidden');
					$('#tblDetail tbody').html(
						'<tr><td colspan="14" class="text-center text-danger py-3">Gagal memuat data.</td></tr>',
					);
				},
			});
		});

		$('#btnExcelDetail').on('click', function () {
			if (detailTable) {
				detailTable.button(0).trigger();
			}
		});

		$('#modalDetail').on('hidden.bs.modal', function () {
			if (detailTable) {
				detailTable.destroy();
				detailTable = null;
			}
			$('#tblDetail tbody').empty();
			$('#btnExcelDetail').attr('hidden', true);
		});
	</script>
@endsection
