@extends("layouts")

@section("title", "KPI MS Maintenance")

@section("breadcrumb")
	<li class="breadcrumb-item active">KPI MS Maintenance</li>
@endsection

@section("styles")
	<link rel="stylesheet" href="{{ asset("assets/css/vendors/flatpickr/flatpickr.min.css") }}" />
	<link rel="stylesheet" href="{{ asset("assets/css/vendors/flatpickr/monthSelect.css") }}" />
	<link rel="stylesheet" href="{{ asset("assets/css/vendors/jquery.dataTables.css") }}" />
	<link rel="stylesheet" href="{{ asset("assets/css/vendors/dataTables.bootstrap5.css") }}" />
	<link rel="stylesheet" href="{{ asset("assets/css/vendors/buttons.bootstrap5.css") }}" />
	<style>
		:root {
			--kpi-warning: #ffb829;
			--kpi-success: #65c15c;
			--kpi-danger: #dc3545;
			--kpi-success-text: color-mix(in srgb, var(--kpi-success) 65%, #000);
		}

		.kpi-month-wrap {
			position: relative;
			width: 170px;
		}

		.kpi-month-wrap .kpi-month-input {
			height: 40px;
			padding-right: 38px;
			font-size: 13.5px;
			color: #495057;
			border: 1px solid #dee2e6;
			border-radius: 6px;
			cursor: pointer;
		}

		.kpi-month-icon {
			position: absolute;
			top: 50%;
			right: 12px;
			display: flex;
			align-items: center;
			transform: translateY(-50%);
			pointer-events: none;
		}

		.kpi-month-icon svg {
			width: 15px;
			height: 15px;
			stroke: #adb5bd;
		}

		.flatpickr-monthSelect-month.selected {
			color: #fff;
			background: var(--brand-primary);
			border-color: var(--brand-primary);
		}

		#chartKpiDaily {
			min-height: 340px;
		}

		.kpi-tooltip {
			min-width: 190px;
			padding: 10px 12px;
			font-size: 12px;
			color: #333;
			background: #fff;
			border: 1px solid #e6e9f2;
			border-radius: 8px;
			box-shadow: 0 8px 24px rgba(16, 38, 168, 0.12);
		}

		.kpi-tooltip-title {
			margin-bottom: 6px;
			font-weight: 700;
			color: var(--brand-primary);
		}

		.kpi-tooltip-row {
			display: flex;
			align-items: center;
			gap: 8px;
			padding: 2px 0;
		}

		.kpi-tooltip-dot {
			width: 8px;
			height: 8px;
			border-radius: 50%;
			flex-shrink: 0;
		}

		.kpi-tooltip-label {
			flex: 1;
		}

		.kpi-tooltip-value {
			font-weight: 700;
		}

		.kpi-tooltip-value.achieved {
			color: var(--kpi-success-text);
		}

		.kpi-tooltip-value.below {
			color: var(--kpi-danger);
		}

		.kpi-tooltip-target {
			font-size: 11px;
			color: #6c757d;
		}

		#spinnerKpi {
			display: none;
		}

		.table.kpi-table {
			width: max-content;
			min-width: 100%;
		}

		.table.kpi-table th,
		.table.kpi-table td {
			padding: 6px 8px;
			vertical-align: middle;
			text-align: center;
			white-space: nowrap;
			border-color: #dee2e6;
		}

		.table.kpi-table thead tr:first-child th {
			border-top: none;
		}

		.table.kpi-table thead th {
			font-weight: 700 !important;
		}

		.table.kpi-table .report-header-group {
			font-size: 11px;
			letter-spacing: 0.06em;
			text-transform: uppercase;
		}

		.table.kpi-table .report-header-sub {
			min-width: 68px;
			font-size: 10px;
			font-weight: 600;
			letter-spacing: 0.03em;
			text-transform: uppercase;
		}

		.table.kpi-table .th-area {
			position: sticky;
			left: 0;
			z-index: 3;
			min-width: 150px;
			background: #f0f1fd;
			color: #1026a8;
		}

		.table.kpi-table .th-day {
			background: #d8dbf8;
			color: #1026a8;
		}

		.table.kpi-table .th-otr,
		.table.kpi-table .th-vr,
		.table.kpi-table .th-sla,
		.table.kpi-table .th-sr {
			color: #333;
			background: color-mix(in srgb, var(--metric-color) 12%, #fff);
		}

		.table.kpi-table .th-otr {
			--metric-color: var(--brand-primary);
		}

		.table.kpi-table .th-vr {
			--metric-color: var(--brand-magenta);
		}

		.table.kpi-table .th-sla {
			--metric-color: var(--kpi-warning);
		}

		.table.kpi-table .th-sr {
			--metric-color: var(--kpi-success);
		}

		.table.kpi-table .td-area {
			position: sticky;
			left: 0;
			z-index: 2;
			font-size: 12.5px;
			background: #fff;
		}

		.table.kpi-table .td-num {
			font-size: 12.5px;
		}

		.table.kpi-table .kpi-count {
			color: #495057;
		}

		.table.kpi-table .kpi-count-divider {
			margin: 0 3px;
			color: #ced4da;
		}

		.table.kpi-table .kpi-rate {
			margin-left: 6px;
			font-weight: 600;
		}

		.table.kpi-table .kpi-rate.below {
			color: var(--kpi-danger);
		}

		.table.kpi-table .kpi-rate.achieved {
			color: var(--kpi-success-text);
		}

		.table.kpi-table .td-dash {
			color: #ccc;
		}

		.table.kpi-table tr.row-total td {
			background: #f8f9fa;
			font-weight: 700;
		}

		.table.kpi-table .td-clickable {
			cursor: pointer;
		}

		.table.kpi-table .td-clickable:hover {
			background-color: rgba(16, 38, 168, 0.08);
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

		.detail-result.achieved {
			font-weight: 600;
			color: var(--kpi-success-text);
		}

		.detail-result.below {
			font-weight: 600;
			color: var(--kpi-danger);
		}

		.table-empty-msg {
			font-size: 13px;
			color: #9490b0;
			padding: 40px 0;
		}
	</style>
@endsection

@section("content")
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
					<h5 class="mb-0 text-uppercase" id="kpiTitle">Performance</h5>
					<div class="kpi-month-wrap">
						<input type="text" id="filterMonth" class="form-control kpi-month-input" />
						<span class="kpi-month-icon">
							<i data-feather="calendar"></i>
						</span>
					</div>
				</div>
				<div class="card-body pb-2">
					<div id="chartKpiDaily"></div>
				</div>
				<div class="card-body p-0">
					<div class="text-center py-3" id="spinnerKpi">
						<div class="spinner-border spinner-border-sm text-primary" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>
						<span class="ms-2 text-muted" style="font-size: 13px">Memuat data...</span>
					</div>
					<div class="table-responsive" id="wrapKpiTable">
						<table class="table table-bordered table-sm mb-0 kpi-table" id="tblKpi">
							<thead id="theadKpi"></thead>
							<tbody id="tbodyKpi">
								<tr>
									<td class="table-empty-msg">Pilih bulan untuk memuat data.</td>
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
						<table class="table table-hover table-bordered table-sm w-100" id="tblDetail"></table>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section("scripts")
	<script src="{{ asset("assets/js/flat-pickr/flatpickr.js") }}"></script>
	<script src="{{ asset("assets/js/flat-pickr/monthSelect.js") }}"></script>
	<script src="{{ asset("assets/js/datatable/datatables/dataTables.js") }}"></script>
	<script src="{{ asset("assets/js/datatable/datatables/dataTables.bootstrap5.js") }}"></script>
	<script src="{{ asset("assets/js/datatable/datatable-extension/jszip.min.js") }}"></script>
	<script src="{{ asset("assets/js/datatable/datatable-extension/dataTables.buttons.js") }}"></script>
	<script src="{{ asset("assets/js/datatable/datatable-extension/buttons.bootstrap5.js") }}"></script>
	<script src="{{ asset("assets/js/datatable/datatable-extension/buttons.html5.min.js") }}"></script>
	<script src="{{ asset("assets/js/chart/apex-chart/apex-chart.js") }}"></script>
	<script>
		const KPI_DAILY_URL = '{{ route("ajax.kpi.daily") }}';
		const KPI_DETAIL_URL = '{{ route("ajax.kpi.daily.detail") }}';
		const KPI_METRICS = [
			{
				key: 'otr',
				label: '% OTR',
				short: 'OTR',
				resultLabel: 'On Time',
				target: 95,
				colorToken: '--brand-primary',
				headerClass: 'th-otr',
			},
			{
				key: 'vr',
				label: '% VR',
				short: 'VR',
				resultLabel: 'Dikunjungi',
				target: 95,
				colorToken: '--brand-magenta',
				headerClass: 'th-vr',
			},
			{
				key: 'sla',
				label: '% SLA',
				short: 'SLA',
				resultLabel: 'Selesai ≤ 24 Jam',
				target: 95,
				colorToken: '--kpi-warning',
				headerClass: 'th-sla',
			},
			{
				key: 'sr',
				label: '% SR',
				short: 'SR',
				resultLabel: 'Selesai',
				target: 93,
				colorToken: '--kpi-success',
				headerClass: 'th-sr',
			},
		];

		let kpiChart = null;

		function escapeHtml(text) {
			return String(text ?? '').replace(/[&<>"']/g, function (character) {
				return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[character];
			});
		}

		function formatPercent(value) {
			return value.toFixed(2).replace('.', ',') + '%';
		}

		function readBrandColor(token) {
			return getComputedStyle(document.documentElement).getPropertyValue(token).trim();
		}

		function indexByDay(dailyRates) {
			const ratesByDay = {};

			dailyRates.forEach(function (dailyRate) {
				ratesByDay[dailyRate.day] = dailyRate;
			});

			return ratesByDay;
		}

		function buildHeaderHtml(daysInMonth) {
			let dayCells = '';
			let metricCells = '';

			for (let day = 1; day <= daysInMonth; day++) {
				dayCells += `<th class="th-day report-header-group" colspan="4">${String(day).padStart(2, '0')}</th>`;
				metricCells += KPI_METRICS.map(function (metric) {
					return `<th class="${metric.headerClass} report-header-sub">${metric.label}</th>`;
				}).join('');
			}

			return `<tr><th class="th-area report-header-group" rowspan="2">AREA</th>${dayCells}</tr><tr>${metricCells}</tr>`;
		}

		function clickableAttributes(metric, day, area) {
			return `data-metric="${metric.key}" data-day="${day}" data-area="${escapeHtml(area)}"`;
		}

		function buildMetricCell(dailyRate, metric, day, area) {
			const value = dailyRate ? dailyRate[metric.key] : null;

			if (value === null || value === undefined) {
				return '<td class="td-num td-dash">-</td>';
			}

			const counts = dailyRate.counts[metric.key];
			const targetClass = value >= metric.target ? 'achieved' : 'below';

			return (
				`<td class="td-num td-clickable" ${clickableAttributes(metric, day, area)}>` +
				`<span class="kpi-count">${counts.yes}</span>` +
				'<span class="kpi-count-divider">|</span>' +
				`<span class="kpi-count">${counts.no}</span>` +
				`<span class="kpi-rate ${targetClass}">${formatPercent(value)}</span>` +
				'</td>'
			);
		}

		function buildRow(label, dailyRates, daysInMonth, isNational) {
			const ratesByDay = indexByDay(dailyRates);
			const clickArea = isNational ? '' : label;
			let cells = '';

			for (let day = 1; day <= daysInMonth; day++) {
				KPI_METRICS.forEach(function (metric) {
					cells += buildMetricCell(ratesByDay[day], metric, day, clickArea);
				});
			}

			return `<tr${isNational ? ' class="row-total"' : ''}><td class="td-area">${escapeHtml(label)}</td>${cells}</tr>`;
		}

		function renderTable(data) {
			const areaRows = data.areas
				.map(function (areaRow) {
					return buildRow(areaRow.area, areaRow.days, data.days_in_month, false);
				})
				.join('');

			document.getElementById('theadKpi').innerHTML = buildHeaderHtml(data.days_in_month);
			document.getElementById('tbodyKpi').innerHTML =
				areaRows + buildRow('NASIONAL', data.national, data.days_in_month, true);
		}

		function withOpacity(hexColor, opacity) {
			const red = parseInt(hexColor.slice(1, 3), 16);
			const green = parseInt(hexColor.slice(3, 5), 16);
			const blue = parseInt(hexColor.slice(5, 7), 16);

			return `rgba(${red}, ${green}, ${blue}, ${opacity})`;
		}

		function formatLongDate(month, day) {
			return new Date(`${month}-${String(day).padStart(2, '0')}T00:00:00`).toLocaleDateString('id-ID', {
				day: 'numeric',
				month: 'long',
				year: 'numeric',
			});
		}

		function buildTooltip(month, day, dailyRate) {
			const rows = KPI_METRICS.map(function (metric) {
				const value = dailyRate ? dailyRate[metric.key] : null;
				const stateClass = value === null || value === undefined ? '' : value >= metric.target ? 'achieved' : 'below';
				const valueText = stateClass ? formatPercent(value) : '-';

				return `<div class="kpi-tooltip-row">
					<span class="kpi-tooltip-dot" style="background: ${readBrandColor(metric.colorToken)}"></span>
					<span class="kpi-tooltip-label">${metric.label}</span>
					<span class="kpi-tooltip-value ${stateClass}">${valueText}</span>
					<span class="kpi-tooltip-target">/ ${metric.target}%</span>
				</div>`;
			}).join('');

			return `<div class="kpi-tooltip"><div class="kpi-tooltip-title">${formatLongDate(month, day)}</div>${rows}</div>`;
		}

		function renderChart(data, month) {
			const ratesByDay = indexByDay(data.national);
			const dayLabels = Array.from({ length: data.days_in_month }, function (_, index) {
				return String(index + 1).padStart(2, '0');
			});
			const metricColors = KPI_METRICS.map(function (metric) {
				return readBrandColor(metric.colorToken);
			});
			const targetColors = metricColors.map(function (color) {
				return withOpacity(color, 0.6);
			});

			const metricSeries = KPI_METRICS.map(function (metric) {
				return {
					name: metric.label,
					type: 'line',
					data: dayLabels.map(function (_, index) {
						const dailyRate = ratesByDay[index + 1];
						return dailyRate ? dailyRate[metric.key] : null;
					}),
				};
			});
			const targetSeries = KPI_METRICS.map(function (metric) {
				return {
					name: 'Target ' + metric.label,
					type: 'line',
					data: dayLabels.map(function () {
						return metric.target;
					}),
				};
			});

			const options = {
				chart: {
					type: 'line',
					height: 340,
					toolbar: { show: false },
					fontFamily: 'inherit',
					zoom: { enabled: false },
					animations: {
						enabled: !window.matchMedia('(prefers-reduced-motion: reduce)').matches,
						easing: 'easeinout',
						speed: 700,
					},
				},
				series: metricSeries.concat(targetSeries),
				colors: metricColors.concat(targetColors),
				stroke: { curve: 'smooth', width: [3, 3, 3, 3, 2, 2, 2, 2], dashArray: [0, 0, 0, 0, 10, 6, 3, 8] },
				markers: {
					size: [4, 4, 4, 4, 0, 0, 0, 0],
					colors: ['#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff', '#fff'],
					strokeColors: metricColors.concat(targetColors),
					strokeWidth: 2,
					hover: { sizeOffset: 2 },
				},
				dataLabels: { enabled: false },
				grid: {
					borderColor: '#eef0f4',
					xaxis: { lines: { show: false } },
					padding: { left: 6, right: 14 },
				},
				xaxis: {
					categories: dayLabels,
					axisBorder: { show: false },
					axisTicks: { show: false },
					labels: { style: { colors: '#6c757d', fontSize: '11px' } },
					crosshairs: { stroke: { color: '#ced4da', width: 1, dashArray: 0 } },
					tooltip: { enabled: false },
				},
				yaxis: {
					min: 0,
					max: 100,
					tickAmount: 5,
					labels: {
						style: { colors: '#6c757d', fontSize: '11px' },
						formatter: function (value) {
							return value + '%';
						},
					},
				},
				legend: {
					position: 'top',
					horizontalAlign: 'left',
					fontSize: '12px',
					fontWeight: 600,
					customLegendItems: KPI_METRICS.map(function (metric) {
						return metric.label;
					}),
					markers: { width: 10, height: 10, radius: 10 },
					itemMargin: { horizontal: 12 },
					labels: { colors: '#495057' },
					onItemClick: { toggleDataSeries: false },
					onItemHover: { highlightDataSeries: false },
				},
				tooltip: {
					shared: true,
					intersect: false,
					custom: function ({ dataPointIndex }) {
						return buildTooltip(month, dataPointIndex + 1, ratesByDay[dataPointIndex + 1]);
					},
				},
			};

			if (kpiChart) {
				kpiChart.destroy();
			}

			kpiChart = new ApexCharts(document.getElementById('chartKpiDaily'), options);
			kpiChart.render();
		}

		function updateTitle(month) {
			const monthName = new Date(month + '-01T00:00:00').toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
			document.getElementById('kpiTitle').textContent = 'Performance — ' + monthName;
		}

		function setTableVisible(isVisible) {
			document.getElementById('wrapKpiTable').style.display = isVisible ? 'block' : 'none';
		}

		function showTableError(message) {
			document.getElementById('theadKpi').innerHTML = '';
			document.getElementById('tbodyKpi').innerHTML =
				`<tr><td class="table-empty-msg text-danger">Gagal memuat data. ${escapeHtml(message)}</td></tr>`;
		}

		function loadKpiDaily() {
			const month = document.getElementById('filterMonth').value;

			if (!month) {
				return;
			}

			updateTitle(month);
			document.getElementById('spinnerKpi').style.display = 'block';
			setTableVisible(false);

			$.ajax({
				url: KPI_DAILY_URL,
				type: 'GET',
				data: { month: month },
				success: function (response) {
					renderChart(response.data, month);
					renderTable(response.data);
				},
				error: function (xhr) {
					showTableError(xhr.responseJSON?.message);
				},
				complete: function () {
					document.getElementById('spinnerKpi').style.display = 'none';
					setTableVisible(true);
				},
			});
		}

		let detailTable = null;

		const DETAIL_FORMULA_COLUMNS = {
			otr: [{ title: 'Batas On Time', data: 'otr_deadline' }],
			vr: [
				{ title: 'WO Agent', data: 'wo_agent' },
				{ title: 'Alasan Agent', data: 'wo_reason_agent' },
				{ title: 'Status Installer', data: 'wo_installer' },
			],
			sla: [
				{ title: 'WO Agent', data: 'wo_agent' },
				{ title: 'Alasan Agent', data: 'wo_reason_agent' },
				{ title: 'Updated At', data: 'updated_at' },
				{ title: 'Batas SLA', data: 'sla_deadline' },
			],
			sr: [
				{ title: 'WO Agent', data: 'wo_agent' },
				{ title: 'Alasan Agent', data: 'wo_reason_agent' },
			],
		};

		function detailColumns(metric) {
			const resultColumn = {
				title: metric.resultLabel,
				data: 'is_achieved',
				render: function (isAchieved, type) {
					const text = isAchieved ? 'Ya' : 'Tidak';

					return type === 'display'
						? `<span class="detail-result ${isAchieved ? 'achieved' : 'below'}">${text}</span>`
						: text;
				},
			};

			return [
				{
					title: 'No',
					data: null,
					render: function (value, type, row, meta) {
						return meta.row + 1;
					},
					width: '40px',
					orderable: false,
				},
				{ title: 'Tanggal', data: 'date_wo' },
				{ title: 'WO Number', data: 'wo_number' },
				{ title: 'Status WO', data: 'work_order_status' },
				{ title: 'Tipe WO', data: 'wo_type' },
				{ title: 'Subscription ID', data: 'subscription_id' },
				{ title: 'Customer ID', data: 'customer_id' },
				{ title: 'Nama Customer', data: 'customer_name' },
				{ title: 'No. HP', data: 'mobile_number' },
				{ title: 'Alamat', data: 'customer_address', className: 'text-wrap', width: '260px' },
				{ title: 'Cluster', data: 'cluster_name' },
				{ title: 'Plan', data: 'plan' },
				{ title: 'Slot Time', data: 'slot_time' },
				{ title: 'Arrival Time', data: 'arrival_time' },
				{ title: 'Installer', data: 'installer' },
				...DETAIL_FORMULA_COLUMNS[metric.key],
				resultColumn,
			];
		}

		function renderDetailTable(rows, metric) {
			if (detailTable) {
				detailTable.destroy();
				$('#tblDetail').empty();
			}

			$('#spinnerDetail').hide();
			$('#wrapDetail').removeAttr('hidden');
			$('#btnExcelDetail').removeAttr('hidden');
			feather.replace();

			detailTable = $('#tblDetail').DataTable({
				data: rows,
				autoWidth: false,
				scrollX: true,
				dom: "<'d-flex justify-content-between align-items-center mb-2'lf>tr<'d-flex justify-content-between align-items-center mt-2'ip>",
				buttons: [{ extend: 'excel', title: $('#modalDetailTitle').text() }],
				columnDefs: [{ targets: '_all', render: DataTable.render.text() }],
				columns: detailColumns(metric),
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

			setTimeout(function () {
				detailTable?.columns.adjust();
			}, 350);
		}

		$('#tblKpi').on('click', '.td-clickable', function () {
			const metricKey = $(this).data('metric');
			const metric = KPI_METRICS.find(function (item) {
				return item.key === metricKey;
			});
			const month = document.getElementById('filterMonth').value;
			const day = String($(this).data('day')).padStart(2, '0');
			const area = $(this).data('area');

			$('#modalDetailTitle').text(`${metric.label} — ${formatLongDate(month, day)} — ${area || 'NASIONAL'}`);
			$('#spinnerDetail').show();
			$('#wrapDetail').attr('hidden', true);
			$('#modalDetail').modal('show');

			$.ajax({
				url: KPI_DETAIL_URL,
				type: 'GET',
				data: { date: `${month}-${day}`, area: area, metric: metric.key, mode: 'percent' },
				success: function (response) {
					renderDetailTable(response.data || [], metric);
				},
				error: function () {
					$('#spinnerDetail').hide();
					$('#wrapDetail').removeAttr('hidden');
					$('#tblDetail').html('<tbody><tr><td class="text-center text-danger py-3">Gagal memuat data.</td></tr></tbody>');
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

			$('#tblDetail').empty();
			$('#btnExcelDetail').attr('hidden', true);
		});

		const monthPicker = flatpickr('#filterMonth', {
			defaultDate: new Date(),
			altInput: true,
			altFormat: 'F Y',
			dateFormat: 'Y-m',
			locale: {
				months: {
					shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
					longhand: [
						'Januari',
						'Februari',
						'Maret',
						'April',
						'Mei',
						'Juni',
						'Juli',
						'Agustus',
						'September',
						'Oktober',
						'November',
						'Desember',
					],
				},
			},
			plugins: [new monthSelectPlugin({ shorthand: true, dateFormat: 'Y-m', altFormat: 'F Y' })],
			onChange: loadKpiDaily,
		});

		monthPicker.altInput.setAttribute('aria-label', 'Bulan');
		loadKpiDaily();
	</script>
@endsection
