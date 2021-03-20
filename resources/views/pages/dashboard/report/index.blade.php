@extends('layouts.dashboard')

@section('title', 'Laporan')

@section('content')
	<style type="text/css">
		.blue_bg {
	        background-color: blue !important;
	    }
	</style>
    <div class="container"> 
        <!-- content-header -->
        <div class="content-header">
            <div class="header">
                <div class="title">
                    Laporan
                </div>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Laporan</li>
                </ol>
            </nav>   
        </div>

        <!-- content-header:end -->
        <!-- content -->
        <div class="content">
        	<div class="row ">
                <div class="col-12">
                    <div class="mt-2">
                        <!-- flush message error -->
                        <x-message />
                        <!-- flush message error:end -->
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group row my-2">

                                    <label class="col-2 col-form-label text-md-end">Pilih Bulan :</label>
                                    <div class="col-10">  
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-12">   
                                                <div class="input-group">
                                                    <input class="form-control" type="month" id="start" name="start" min="2021-03" value="2021-05">
                                                </div>
                                            </div>  
                                            <div class="col-lg-4 col-sm-12">   
                                                <div class="input-group">
                                                    <input class="form-control" type="month" id="stop" name="start" min="2021-03" value="2021-05">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">   
                                                <div class="input-group">
                                                    <a class="btn btn-secondary no-loader" target="_blank" id="exportExcel"> Export .xls </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">   
                    <div class="mt-2">
                        <!-- flush message error -->
                        <x-message />
                        <!-- flush message error:end -->
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group row my-2">
                                    <label class="col-2 col-form-label text-md-end">Pilih Tanggal :</label>
                                    <div class="col-10">
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                            <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#calendar') }}"/>
                                                        </svg>
                                                    </span>
                                                    <input class="form-control datepicker" data-date-format="dd-mm-yyyy" id="filter-date-start" placeholder="Tanggal" autocomplete="off" value="{{ \Carbon\Carbon::now()->firstOfMonth()->format('d-m-Y') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <svg class="bi icon" width="16" height="16" fill="currentColor">
                                                            <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#calendar-fill') }}"/>
                                                        </svg>
                                                    </span>
                                                    <input class="form-control datepicker" data-date-format="dd-mm-yyyy" id="filter-date-end" placeholder="Tanggal" autocomplete="off" value="{{ \Carbon\Carbon::now()->lastOfMonth()->format('d-m-Y') }}">
                                                </div>
                                            </div>  
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="input-group">
                                                    <a class="btn btn-secondary no-loader" target="_blank" id="submit"> Submit </a>
                                                </div>
                                            </div>     
                                        </div> 
                                    </div>
                                </div>  
                            	<div class="row">   
                            		<div class="col-lg-4">
                            		</div>
                            		<div class="col-lg-4 col-sm-12">
                                                <div class="form-group text-center">
												    <select class="form-control" id="fromPelabuhan">
												      <option value="0" selected>dari Pelabuhan Umum Gresik</option>
												      <option value="1">dari Pelabuhan Umum Bawean</option>
												    </select>
												  </div>
                                            </div>
                            	</div>
                        <div class="mt-2">
                        	<table  class="table table-bordered">
                        		<thead>   
                        			<tr class="text-center">
									    <th rowspan="3">No</th>       
									    <th rowspan="3">Hari</th>
									    <th rowspan="3">Tanggal</th>
									    <th colspan="4" class="text-light bg-primary">KM. EXPRESS BAHARI 8E</th>
									    <th colspan="4" class="text-light bg-warning">KM. NATUNA EXPRESS</th>
									    <th colspan="6"  class="text-light bg-success">KMP. GILI IYANG</th>
									</tr>    
									<tr class="text-center">
									    <th rowspan="2">Jam</th>
									    <th colspan="3">Jumlah Penumpang</th>
									    <th rowspan="2">Jam</th>  
									    <th colspan="3">Jumlah Penumpang</th>
									    <th rowspan="2">Jam</th>
									    <th colspan="5">Jumlah Penumpang</th> 
									</tr>   
									<tr class="text-center">   
										<th>Dewasa</th>
									    <th>Bayi</th>
									    <th>Anggota</th>   
									    <th>Dewasa</th>
									    <th>Bayi</th>
									    <th>Anggota</th>  
									    <th>Dewasa</th>
									    <th>Bayi</th>
									    <th>Anggota</th>   
									    <th>R2</th>   
									    <th>R4</th>   
									</tr>
                        		</thead>
                        		<tbody id="body-batik">
                        			<tr>
                        				<td>1</td>
                        				<td>1</td>
                        				<td>12</td>
                        				<td>12</td>
                        				<td>1</td>
                        				<td>1</td>
                        				<td>12</td>
                        				<td>12</td>
                        				<td>1</td>
                        				<td>1</td>
                        				<td>12</td>
                        				<td>12</td>
                        				<td>1</td>
                        				<td>1</td>
                        				<td>12</td>
                        				<td>12</td>
                        				<td>12</td>
                        			</tr>
                        		</tbody>
                        		<tfoot>
                        			<tr >
                        				<td colspan="4">Jumlah Per Kapal</td>
                        				<td class="total ship1 adult text-center">0</td>
                        				<td class="total ship1 baby text-center">0</td>
                        				<td class="total ship1 forces text-center">0</td>
                        				<td>-</td>
                        				<td class="total ship2 adult text-center">0</td>
                        				<td class="total ship2 baby text-center">0</td>
                        				<td class="total ship2 forces text-center">0</td>
                        				<td>-</td>
                        				<td class="total ship3 adult text-center">0</td>
                        				<td class="total ship3 baby text-center">0</td>
                        				<td class="total ship3 forces text-center">0</td>
                        				<td class="total ship3 r2 text-center">0</td>
                        				<td class="total ship3 r4 text-center">0</td>
                        			</tr>
                        			<!--tr >
                        				<td colspan="4">Load Factor Keberangkatan</td>
                        				<td colspan="3" class="lf ship1 text-center">0</td>
                        				<td colspan="4" class="lf ship2 text-center">0</td>
                        				<td colspan="6" class="lf ship3 text-center">0</td>
                        			</tr>
                        			<tr >
                        				<td colspan="4">Load Factor Jadwal</td>
                        				<td colspan="3" class="lfj ship1 text-center ">0</td>
                        				<td colspan="4" class="lfj ship2 text-center">0</td>
                        				<td colspan="6" class="lfj ship3 text-center">0</td>
                        			</tr-->
                        			<tr >
                        				<td colspan="4">Total</td>
                        				<td colspan="12" class="alltotal text-center">0</td>     
                        				<td class="allvehicle text-center">0</td>
                        			</tr>   
                        		</tfoot>
							</table>
                        	
                        </div>
                    </div></div>
                        <div class="mx-1 mt-4">
                            <table id="table-transactions" class="table table-hover table-stripped"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content:end -->
    </div>

    <!-- modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <span class="nama-kapal"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form">
                        <div class="form-group row my-1  d-none">
                            <label class="col-sm-4 text-md-end col-form-label">Nama Kapal</label>
                            <div class="col-md-7">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg class="bi icon" width="16" height="16" fill="currentColor">
                                            <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#person-fill') }}"/>
                                        </svg>
                                    </span>
                                    <input type="text" name="ship" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row my-1 ">
                            <label class="col-sm-4 text-md-end col-form-label">Tanggal</label>
                            <div class="col-md-7">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg class="bi icon" width="16" height="16" fill="currentColor">
                                            <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#calendar-fill') }}"/>
                                        </svg>
                                    </span>
                                    <input type="text" name="date" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row my-1 ">
                            <label class="col-sm-4 text-md-end col-form-label">Data Cuaca</label>
                            <div class="col-md-7">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg class="bi icon" width="16" height="16" fill="currentColor">
                                            <use xlink:href="{{ asset('img/icon/bootstrap-icons.svg#cloud-drizzle-fill') }}"/>
                                        </svg>
                                    </span>
                                    <div class="tw-bg-gray-200 tw-flex-1 tw-px-3 tw-py-1 tw-border-2 tw-border-gray-300 weather"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles-library')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">   
    <style>
        td.details-control {
            background: url('https://cdn.rawgit.com/DataTables/DataTables/6c7ada53ebc228ea9bc28b1b216e793b1825d188/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('https://cdn.rawgit.com/DataTables/DataTables/6c7ada53ebc228ea9bc28b1b216e793b1825d188/examples/resources/details_close.png') no-repeat center center;
        }
    </style>
@endpush

@push('scripts-library')
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/xlsx-populate.min.js') }}"></script>
@endpush

@push('scripts')
	
    <script>

    	

        // 
        var table
        // datatables
        const route = "{{ route('reports') }}";
        const initTable = () => {
            table = $('#table-transactions').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: route,
                    data: function (d) {
                        d.date_start = $('#filter-date-start').val(),
                        d.date_end = $('#filter-date-end').val()
                    }
                },
                responsive: true,
                autoWidth: false,
                order: [[1, 'asc']],
                columnDefs: [
                    { orderable: false, targets: [0] }
                ],
                columns: [
                    { title: '#', data: 'id', render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1 },
                    {
                        title: 'Tanggal',
                        data: 'date'
                    },
                    {
                        title: 'Kapal',
                        data: 'ship.name'
                    },
                    {
                        title: 'Status',
                        data: 'status'
                    },
                    {
                        title: 'Keterangan',
                        data: 'description'
                    },
                    {
                        title: 'Lokasi',
                        data: 'location'
                    },
                    {
                        title: 'Petugas',
                        data: 'petugas'
                    },
                    {
                        title: 'Total Penumpang',
                        data: 'pax'
                    },
                    {
                        title: '...',
                        data: null,
                        render: (data, type, row) => {
                            data.weather = JSON.parse(data.weather)
                            const weather = (data.weather != null) ? `'${data.weather.id}'` : `null`
                            console.log(data)
                            return `
                            <div>
                                <button class="btn btn-sm btn-outline-primary" type="button"
                                    onclick="showModal(
                                        '${data.id}', '${data.ship.name}', '${data.date}',
                                        ${weather}
                                    )">
                                    <i class="bi bi-search"></i>
                                    <div class="d-inline-block ml-4">Detail</div>
                                </button>
                            </div>
                            `
                        }
                    },
                ]
            });

            $('#filter-date-start').change(() => table.draw());
            $('#filter-date-end').change(() => table.draw());
        }

        // init modal
        var modal, modalEl = document.getElementById('modal')
        const initModal = () => {
            modal = new bootstrap.Modal(modalEl, {})
            // showModal(1, 'Kapal', '1-2-2021')
        }
        const showModal = (id, ship, date, weather = null, photo_embarkation = null) => {
            const title = modalEl.querySelector('.nama-kapal')
            const inputShip = modalEl.querySelector('input[name="ship"]')
            const inputDate = modalEl.querySelector('input[name="date"]')
            const inputWeather = modalEl.querySelector('div.weather')
            const routeWeather = `{{ route('weather.index') }}`
            title.innerHTML = `${ship} [${date}]`
            inputShip.value = `${ship}`
            inputDate.value = `${date}`
            if (weather == null) 
            {
                inputWeather.innerHTML = 'Tidak ada data cuaca di tanggal ini.'
            } else {
                inputWeather.innerHTML = `
                    <a href="${routeWeather}/${weather}?view" target="_blank">Lihat data cuaca</a>
                `
            }
            modal.toggle()
        }

        // datepicker
        const initDatepicker = () => {
            $('.datepicker').datepicker({
                orientation: 'bottom'
            })
        }

        // init
        document.addEventListener('DOMContentLoaded', function () {
            //initTable()
            initModal()    
            initDatepicker()
        })
    </script>  
    <script type="text/javascript">
    	function getTable( start, stop , arr) {

            $.ajax({url: "/apiweather", success: function(result){
                objWeather = result.reduce(function( old, row ){
                    var yr = row.date.split('-')[0];
                    var mt = row.date.split('-')[1];
                    var dt = row.date.split('-')[2];
                    old[ `${dt}-${mt}-${yr}` ] = row;
                    return old;
                }, {})
            }});

    		

    		$.ajax({url: "/apireport?start=" + start + "&stop=" +stop + "&flag=false", success: function(result){
    		var total = {
    			'allvehicle':0,
    			'alltotal':0,
    			'count_adult':{
    				1: 0,
	    			2: 0,
	    			3: 0
    			},
    			'count_baby':{
    				1: 0,
	    			2: 0,
	    			3: 0
    			},
    			'count_security_forces':{
    				1: 0,
	    			2: 0,
	    			3: 0
    			},'count_vehicle_wheel_2':{
    				1: 0,
	    			2: 0,
	    			3: 0
    			},'count_vehicle_wheel_4':{
    				1: 0,
	    			2: 0,
	    			3: 0
    			}
    		};
    		console.log(result)
		    var strTable = '';
	        result.forEach(function( obj , i){
	          var hari = obj.date.split('-')[0] * 1;  
	          var bulan = (obj.date.split('-')[1] * 1) - 1;
	          var bulanString = month[bulan]
	          var tahun = (obj.date.split('-')[2] * 1);
	          strTable += '<tr>';
	          strTable += `<td>${i + 1}</td>`;
	          strTable += `<td>${days[new Date(tahun, bulan, hari).getDay()]}</td>`
              if( obj.date in objWeather ) strTable += `<td class="bg-warning">${obj.date}</td>`;
	          else strTable += `<td>${obj.date}</td>`;
	            obj.routes[arr].ships.forEach( function( ship ) {  
	            	
	              if( ship.report ) {
	              	total['count_adult'][ship.id] += ship.report.count_adult;
	              	total['count_baby'][ship.id] += ship.report.count_baby;
	              	total['count_security_forces'][ship.id] += ship.report.count_security_forces;
	                strTable += `<td>${ship.report.time.substr(0,5)}</td>`
	                strTable += `<td>${ship.report.count_adult}</td>`
	                strTable += `<td>${ship.report.count_baby}</td>`
	                strTable += `<td>${ship.report.count_security_forces}</td>`
	                if( ship.id == 3 ) {
	                //	total['count_vehicle_wheel_2'][ship.id]+= ship.report.count_vehicle_wheel_2;
	                //	total['count_vehicle_wheel_4'][ship.id]+= ship.report.count_vehicle_wheel_4;
	                  strTable += `<td>${ship.report.count_vehicle_wheel_2}</td>`
	                  strTable += `<td>${ship.report.count_vehicle_wheel_4}</td>`
	                }
	              } else {
	              	if( ship.operation ) {
	              		var addC = (ship.operation.status == "Tidak Beroperasi" && ship.operation.description == "Perbaikan Mesin" && ship.operation.ship_id == ship.id) ? "bg-primary" : "";
                        if( addC == "" ) addC = (ship.operation.status == "Tidak Beroperasi" && ship.operation.description.trim() == "Cuaca Buruk") ? "bg-warning" : "";
	              		if( addC == "" ) addC = (ship.operation.status == "Tidak Beroperasi" && ship.operation.description.trim() == "Docking" && ship.operation.ship_id == ship.id) ? "bg-secondary" : "";
	              		strTable += `<td class="${addC}" title="${addC == "bg-primary" ? "Perbaikan Mesin" : ( addC == "bg-warning" ? "Cuaca Buruk" : (addC == "bg-secondary" ? "Docking" : ""))  }"></td>`
		              	strTable += `<td class="${addC}" title="${addC == "bg-primary" ? "Perbaikan Mesin" : ( addC == "bg-warning" ? "Cuaca Buruk" : (addC == "bg-secondary" ? "Docking" : ""))  }"></td>`   
		              	strTable += `<td class="${addC}" title="${addC == "bg-primary" ? "Perbaikan Mesin" : ( addC == "bg-warning" ? "Cuaca Buruk" : (addC == "bg-secondary" ? "Docking" : ""))  }"></td>`
		              	strTable += `<td class="${addC}" title="${addC == "bg-primary" ? "Perbaikan Mesin" : ( addC == "bg-warning" ? "Cuaca Buruk" : (addC == "bg-secondary" ? "Docking" : ""))  }"></td>`
		              	if( ship.id == 3 ) {
		                    strTable += `<td class="${addC}"></td>`      
		              		strTable += `<td class="${addC}"></td>`
		                }
	              	} else {
	              		strTable += `<td></td>`
		              	strTable += `<td></td>`
		              	strTable += `<td></td>`
		              	strTable += `<td></td>`
		              	if( ship.id == 3 ) {
		                    strTable += `<td></td>`
		              		strTable += `<td></td>`
		                }
	              	}
	              }
	            })
	        	strTable += '</tr>'
	          });
	        [1,2,3].map( function( id ){
	        	$(`.total.ship${id}.adult`).empty().text(total['count_adult'][id])
	        	$(`.total.ship${id}.baby`).empty().text(total['count_baby'][id])
	        	$(`.total.ship${id}.forces`).empty().text(total['count_security_forces'][id])
	        	total.alltotal += (total['count_adult'][id] + total['count_baby'][id] + total['count_security_forces'][id])
	        	if( id == 3 ) {
	        		$(`.total.ship${id}.r2`).empty().text(total['count_vehicle_wheel_2'][id])
	        		$(`.total.ship${id}.r4`).empty().text(total['count_vehicle_wheel_4'][id])
	        		total.allvehicle += (total['count_vehicle_wheel_2'][id] + total['count_vehicle_wheel_4'][id])
	        	}
	        })
	        
	        console.log(total)
	        $('#body-batik').empty().html(strTable); 
	        $('.alltotal').empty().text(total.alltotal)
	        $('.allvehicle').empty().text(total.allvehicle)

		  }}); 
    	}
    	  
	</script>
    <script type="text/javascript">
        var month = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
		  "Agustus", "September", "Oktober", "November", "Desember"
		];
		var days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
		var numdays = function(month, year) {
		  console.log(month, year)
		  return new Date(year, month, 0).getDate();
		};
		var monthShort = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
		var mapShipHour = [
		  '',
		  ['', 'D', 'H', 'L'],
		  ['', 'Q', 'U', 'Y']
		]
		var mapShipValue = [
		  '',
		  ['', ['E','F' ,'G'], ['I','J', 'K'], ['M','N', 'O', 'P']],
		  ['', ['R','S' ,'T'], ['V','W', 'X'], ['Z','AA', 'AB', 'AC']]
		]

function getReportByMonth( start, stop , flag){
return new Promise(function(resolve, reject) {
    var req = new XMLHttpRequest();
    var url = `/apireport?start=${start}&stop=${stop}&flag=${flag}`;
    req.open("GET", url, true);
    req.responseType = "json";
    req.onreadystatechange = function() {
      if (req.readyState === 4) {
        if (req.status === 200) {
          resolve(req.response);
        } else {
          reject("Received a " + req.status + " HTTP code.");
        }
      }
    };
    req.send();
  });
}

function downloadReport(start, stop, flag) {
return getReportByMonth(start, stop, flag).then( function( arrObj ){
  return generateBlob(arrObj, start, stop);
  })
}

function getWorkbook() {
  return new Promise(function(resolve, reject) {
    var req = new XMLHttpRequest();
    var url = "/excel/rekap.xlsx";
    req.open("GET", url, true);
    req.responseType = "arraybuffer";
    req.onreadystatechange = function() { 
      if (req.readyState === 4) {
        if (req.status === 200) {
          resolve(XlsxPopulate.fromDataAsync(req.response));
        } else {
          reject("Received a " + req.status + " HTTP code.");
        }
      }
    };
    req.send();
  });
}
 var colOffset = 10;
function generate(data, type) {
  return getWorkbook()
    .then(function(workbook) {
    var imonth = 0;
    var omonth = {};
    data.forEach(function( obj , i){
        var hari = obj.date.split('-')[0] * 1;
        var bulan = (obj.date.split('-')[1] * 1) - 1;
        var bulanString = month[bulan]
        var tahun = (obj.date.split('-')[2] * 1);
        if( !(bulan in omonth) ) {
          workbook.sheet(bulan).name(`${bulanString} ${tahun}`)
          workbook.sheet(bulan).cell("A2").value(`BAGIAN BULAN : ${bulanString.toUpperCase()} ${tahun}`)
          var iloop = numdays(bulan + 1, tahun)
        for (var x = 1; x <= iloop; x++) {
          workbook.sheet(bulan).cell("A" + (x + colOffset)).value(x);
          workbook.sheet(bulan).cell("B" + (x + colOffset)).value(days[new Date(tahun, bulan, x).getDay()]);
          workbook.sheet(bulan).cell("C" + (x + colOffset)).value(new Date(tahun, bulan, x)).style("numberFormat", "dd mmmm yyyy");
        }
        }
        omonth[ bulan ] = '';
        obj.routes.forEach( function(route){   
        	route.ships.forEach( function( ship ) {
        		if( ship.report ) {
                    if(mapShipHour[route.id][ship.id] + (hari+ colOffset))
        			 workbook.sheet(bulan).cell(mapShipHour[route.id][ship.id] + (hari+ colOffset)).value(ship.report.time.substr(0,5));
                    if(mapShipValue[route.id][ship.id][0] + (hari+ colOffset))
        			 workbook.sheet(bulan).cell(mapShipValue[route.id][ship.id][0] + (hari+ colOffset)).value(ship.report.count_adult);
                    if(mapShipValue[route.id][ship.id][1] + (hari+ colOffset))
        			 workbook.sheet(bulan).cell(mapShipValue[route.id][ship.id][1] + (hari+ colOffset)).value(ship.report.count_baby);
                    if( mapShipValue[route.id][ship.id][2] + (hari+ colOffset) )
        			workbook.sheet(bulan).cell(mapShipValue[route.id][ship.id][2] + (hari+ colOffset)).value(ship.report.count_security_forces);
        			if( ship.id == 3 && false) {
	        			workbook.sheet(bulan).cell(mapShipValue[route.id][ship.id][3] + (hari+ colOffset)).value(ship.report.count_vehicle_wheel_2);
	        			workbook.sheet(bulan).cell(mapShipValue[route.id][ship.id][4] + (hari+ colOffset)).value(ship.report.count_vehicle_wheel_4);
        			}    
        		} else {    
        			if( ship.operation ) {
	              		//var addC = (ship.operation.status == "Tidak Beroperasi" && ship.operation.description == "Perbaikan Mesin" && ship.operation.ship_id == ship.id) ? "0000FF" : "";
	              		//if( addC == "" ) addC = (ship.operation.status == "Tidak Beroperasi" && ship.operation.description.trim() == "Cuaca Buruk") ? "FF0000" : "";
                        /*
	              		console.log(mapShipHour[route.id][ship.id] + (hari+ colOffset))
	              		if( ship.operation.status == "Tidak Beroperasi" && ship.operation.description == "Perbaikan Mesin" && ship.operation.ship_id == ship.id ) {
	              			workbook.sheet(bulan).cell(mapShipHour[route.id][ship.id] + (hari+ colOffset)).style("fill", "538ed5");
	              			workbook.sheet(bulan).cell(mapShipValue[route.id][ship.id][0] + (hari+ colOffset)).style("fill", "538ed5");
	              			workbook.sheet(bulan).cell(mapShipValue[route.id][ship.id][1] + (hari+ colOffset)).style("fill", "538ed5");
	              			workbook.sheet(bulan).cell(mapShipValue[route.id][ship.id][2] + (hari+ colOffset)).style("fill", "538ed5");
	              			if( ship.id == 3 ) {
			        			workbook.sheet(bulan).cell(mapShipValue[route.id][ship.id][3] + (hari+ colOffset)).style("fill", "538ed5");
			        			//workbook.sheet(bulan).cell(mapShipValue[route.id][ship.id][4] + (hari+ colOffset)).value(0);
			                }
	              		} else if (ship.operation.status == "Tidak Beroperasi" && ship.operation.description == "Cuaca Buruk"){
	              			workbook.sheet(bulan).cell(mapShipHour[route.id][ship.id] + (hari+ colOffset)).style("fill", "ff0000");
	              			workbook.sheet(bulan).cell(mapShipValue[route.id][ship.id][0] + (hari+ colOffset)).style("fill", "ff0000");
	              			workbook.sheet(bulan).cell(mapShipValue[route.id][ship.id][1] + (hari+ colOffset)).style("fill", "ff0000");
	              			workbook.sheet(bulan).cell(mapShipValue[route.id][ship.id][2] + (hari+ colOffset)).style("fill", "ff0000");
	              			if( ship.id == 3 ) {
			        			workbook.sheet(bulan).cell(mapShipValue[route.id][ship.id][3] + (hari+ colOffset)).style("fill", "ff0000");
			        		}
	              		}*/
	              	}
        		}
        	})
        })         
    })
      for (var z = 11; z >= 0; z--) {
        if( !( z in omonth ) ) workbook.sheet(z).delete();
      }
      return workbook.outputAsync({ type: type });
    });
}

function generateBlob(obj, start, stop) {
  return generate(obj)
    .then(function(blob) {
      var url = window.URL.createObjectURL(blob);
      var a = document.createElement("a");    
      document.body.appendChild(a);
      a.href = url;
      a.download = "Report_" + start + "_" + stop + ".xlsx";
      a.click();
      window.URL.revokeObjectURL(url);
      document.body.removeChild(a);
    })
    .catch(function(err) {
      alert(err.message || err);
      throw err;
    });
}
window.addEventListener('DOMContentLoaded', (event) => {
   $('#exportExcel').on('click', function(){
		var startdate = $('#start').val();
		var stopdate = $('#stop').val();
		var flag = 'true';
		console.log(startdate, stopdate)
		downloadReport(startdate, stopdate, flag);
	});
   var start = $('#filter-date-start').val();
   var stop = $('#filter-date-end').val();
   getTable(start, stop, 0);
   $('#submit').on('click', function(){
		var start = $('#filter-date-start').val();
   		var stop = $('#filter-date-end').val();
   		var arr = $('#fromPelabuhan').val();
		getTable(start, stop , arr * 1);
	});
   $('#fromPelabuhan').on('change', function(){
   	   var start = $('#filter-date-start').val();
   		var stop = $('#filter-date-end').val();
   		var arr = $('#fromPelabuhan').val();
		getTable(start, stop , arr * 1);
   });
   $('#body-batik').delegate( 'tr td:nth-child(3)' ,'click', function(){
    var onDate = $(this).text();
   	showModal(objWeather[onDate]['shipid'], '', onDate, objWeather[onDate]['wid']);   
   })
});
  
    </script>     
@endpush