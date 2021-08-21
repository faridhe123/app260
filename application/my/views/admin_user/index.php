<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/deskapp/')?>/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/deskapp/')?>/src/plugins/datatables/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/deskapp/')?>/vendors/styles/style.css">
	<div class="main-container">
		<div class="pd-ltr-20">
			<div class="page-header">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="title">
							<h4><?php echo $title ?></h4>
						</div>
						<nav aria-label="breadcrumb" role="navigation">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo base_url('')?>">Home</a></li>
								<li class="breadcrumb-item active " aria-current="page" ><a href="<?php echo base_url('pinjam_kendaraan')?>">Kendaraan</a></li>
								<?php if(isset($filter)){?>
									<li class="breadcrumb-item" aria-current="page" ><?php echo $filter?></li>
								<?php }?>
							</ol>
						</nav>
					</div>
				</div>
			</div>
			<?php if(isset($_GET['stsSUCC'])){ ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>Input Berhasil!</strong> Mohon hubungi administrator untuk approval peminjaman kendaraan
						<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick='window.location.href =  window.location.href.split("?")[0];'>
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php }?>
				<?php if(isset($_GET['stsERR'])){ ?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>Input Gagal!</strong> Silakan hubungi administrator untuk informasi lebih lanjut.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick='window.location.href =  window.location.href.split("?")[0];'>
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
			<?php }?>
			<div class="card-box mb-30">
				<h2 class="h4 pd-20">
					<a href="<?php echo base_url('pinjam_kendaraan/kendaraan')?>" class="btn btn-info" role="button">Lihat Detil Peminjaman</a>
					<a href="<?php echo base_url('pinjam_kendaraan/calendar')?>" class="btn btn-warning" role="button">Lihat Kalender</a>
				</h2>
				<table class="data-table table nowrap">
					<thead>
						<tr>
							<th class="table-plus datatable-nosort"></th>
							<th>Nama</th>
							<th>Pemegang</th>
							<th>Peminjam terakhir</th>
							<th>Pinjam</th>
							<th class="datatable-nosort">Detil Kendaraan : </th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($hasil as $row){ ?>
						<tr <?php echo (!isset($row['fg_operasional']) ? "style='background:grey;'" : "") ; ?>>
							<td class="table-plus">
								<img src="<?php echo base_url('assets/')?>/images/mobil/<?php echo $row['id_kendaraan']?>.png" width="70" height="70" alt=""
								<?php echo (!isset($row['fg_operasional']) ? "style='filter:brightness(00%);'" : "") ; ?> >
							</td>
							<td>
								<h5 class="font-16"><a href='<?php echo base_url('pinjam_kendaraan/kendaraan/'.$row['id_kendaraan'])?>'><?php echo $row['merk_type']?></a></h5>
								<?php echo $row['nopol']?>
							</td>
							<td><?php echo $row['pemegang']?></td>
							<td><b><?php echo $row['atas_nama']?></b>
								
									<?php if(isset($row['tgl_mulai_pinjam']) and isset($row['tgl_selesai_pinjam']) ){
										echo "<span style='color:grey'>Selesai ".date("d M Y", strtotime($row['tgl_selesai_pinjam']))."</span>";
									}elseif(isset($row['tgl_mulai_pinjam']) and !isset($row['tgl_selesai_pinjam']) ){
										echo "<span style='color:red'>Sedang dipinjam <span>".$row['tgl_mulai_pinjam'];
									}else{
										echo "<span style='color:grey'>Tidak ada</span>";
									}?>
								
							</td>
							<td>
								<?php if((isset($row['tgl_mulai_pinjam']) and isset($row['tgl_selesai_pinjam']) ) or (!isset($row['tgl_mulai_pinjam']) and isset($row['fg_operasional'])) ){?>
								<button type="submit" name='status_admin' class="btn btn-success" data-toggle="modal" data-target="#modalPinjam<?php echo $row['id_kendaraan']?>">PINJAM</button></td>
								<?php }?>
							<td>
								<div class="dropdown">
								<div class="blog-detail card-box overflow-hidden mb-30">
									<!-- <div class="blog-img">
										<img src="<?php echo base_url('assets/')?>/images/mobil/<?php echo $row['id_kendaraan']?>.png" alt="">
									</div> -->
									<div class="blog-caption">
										<!-- <h5 class="mb-10">Detil Kendaraan</h5> -->
										<ul>
										<li>ID : <?php echo $row['id_kendaraan']?></li>
										<li>Nopol Lama : <?php echo $row['nopol_lama']?></li>
										<li>No STNK : <?php echo $row['no_stnk']?></li>
										<li>No BPKP : <?php echo $row['no_bpkp']?></li>
										<li>No Rangka : <?php echo $row['no_rangka']?></li>
										<li>No Mesin : <?php echo $row['no_mesin']?></li>
										<li>Tahun : <?php echo $row['thn']?></li>
										<li>Roda : <?php echo $row['roda']?></li>
										</ul>
									</div>
								</div>
									<!-- <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
										<i class="dw dw-more"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
										<a class="dropdown-item" href="#"><i class="dw dw-eye"></i> View</a>
										<a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
										<a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Delete</a>
									</div> -->
								</div>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<?php foreach($hasil as $row){ ?>
			<div id="modalPinjam<?php echo $row['id_kendaraan']?>" class="modal modal-top fade calendar-modal">
				<div class="modal-dialog modal-lg modal-dialog-centered">
					<div class="modal-content">
						<form id="add-event" action="<?php echo base_url("pinjam_kendaraan/input_PinjamKendaraan/"); ?>" method="POST">
							<input type="text" class="form-control" name="id_pinjam" value="<?php echo $last_id; ?>" hidden>
							<input type="text" class="form-control" name="id_kendaraan" value="<?php echo $row['id_kendaraan']; ?>" hidden>
							<input type="text" class="form-control" name="ip_peminjam" value="<?php echo $_SERVER['REMOTE_ADDR'];?>" hidden>
							<input type="text" class="form-control" name="id_akun" value="<?php echo $this->session->userdata('id_akun');?>" hidden>
							<div class="modal-body">
								<h4 class="text-blue h4 mb-10">Pinjam <?php echo $row['merk_type']." (".$row['nopol'].")" ;?></h4>
								<div class="form-row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="small mb-1" for="tgl_mulai_pinjam">Tgl Mulai pinjam</label>
											<input data-language='id' id='tgl_mulai_pinjam' class="form-control date-picker" type="text" name='tgl_mulai_pinjam' data-date-format="yyyy-mm-dd" value="<?php echo date("Y-m-d") ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="small mb-1" for="tgl_mulai_pinjam">Tgl Selesai Pinjam</label>
											<input data-language='id' id='tgl_selesai_pinjam' class="form-control date-picker" type="text" name='tgl_selesai_pinjam' data-date-format="yyyy-mm-dd" value="<?php echo date("Y-m-d") ?>">
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Tujuan</label>
											<input type="text" class="form-control" name="tujuan" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Atas Nama</label>
											<input type="text" class="form-control" name="atas_nama" required>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Nomor ND</label>
											<input type="text" class="form-control" name="nomor_nd">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Penanggungjawab</label>
											<input type="text" class="form-control" name="pj" required>
										</div>
									</div>
								</div>
								
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-primary" >Save</button>
								<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<?php } ?>

			<div class="footer-wrap pd-20 mb-20 card-box">
				DeskApp - Bootstrap 4 Admin Template By <a href="https://github.com/dropways" target="_blank">Ankit Hingarajiya</a>
			</div>
		</div>
	</div>

	<!--js APLIKASI-->
	<script src="<?php echo base_url('assets/deskapp/')?>/src/plugins/apexcharts/apexcharts.min.js"></script>
	<script src="<?php echo base_url('assets/deskapp/')?>/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url('assets/deskapp/')?>/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?php echo base_url('assets/deskapp/')?>/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
	<script src="<?php echo base_url('assets/deskapp/')?>/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
	<script >
		var options = {
			series: [80],
			grid: {
				padding: {
					top: 0,
					right: 0,
					bottom: 0,
					left: 0
				},
			},
			chart: {
				height: 100,
				width: 70,
				type: 'radialBar',
			},	
			plotOptions: {
				radialBar: {
					hollow: {
						size: '50%',
					},
					dataLabels: {
						name: {
							show: false,
							color: '#fff'
						},
						value: {
							show: true,
							color: '#333',
							offsetY: 5,
							fontSize: '15px'
						}
					}
				}
			},
			colors: ['#ecf0f4'],
			fill: {
				type: 'gradient',
				gradient: {
					shade: 'dark',
					type: 'diagonal1',
					shadeIntensity: 0.8,
					gradientToColors: ['#1b00ff'],
					inverseColors: false,
					opacityFrom: [1, 0.2],
					opacityTo: 1,
					stops: [0, 100],
				}
			},
			states: {
				normal: {
					filter: {
						type: 'none',
						value: 0,
					}
				},
				hover: {
					filter: {
						type: 'none',
						value: 0,
					}
				},
				active: {
					filter: {
						type: 'none',
						value: 0,
					}
				},
			}
		};

		var options2 = {
			series: [70],
			grid: {
				padding: {
					top: 0,
					right: 0,
					bottom: 0,
					left: 0
				},
			},
			chart: {
				height: 100,
				width: 70,
				type: 'radialBar',
			},	
			plotOptions: {
				radialBar: {
					hollow: {
						size: '50%',
					},
					dataLabels: {
						name: {
							show: false,
							color: '#fff'
						},
						value: {
							show: true,
							color: '#333',
							offsetY: 5,
							fontSize: '15px'
						}
					}
				}
			},
			colors: ['#ecf0f4'],
			fill: {
				type: 'gradient',
				gradient: {
					shade: 'dark',
					type: 'diagonal1',
					shadeIntensity: 1,
					gradientToColors: ['#009688'],
					inverseColors: false,
					opacityFrom: [1, 0.2],
					opacityTo: 1,
					stops: [0, 100],
				}
			},
			states: {
				normal: {
					filter: {
						type: 'none',
						value: 0,
					}
				},
				hover: {
					filter: {
						type: 'none',
						value: 0,
					}
				},
				active: {
					filter: {
						type: 'none',
						value: 0,
					}
				},
			}
		};

		var options3 = {
			series: [75],
			grid: {
				padding: {
					top: 0,
					right: 0,
					bottom: 0,
					left: 0
				},
			},
			chart: {
				height: 100,
				width: 70,
				type: 'radialBar',
			},	
			plotOptions: {
				radialBar: {
					hollow: {
						size: '50%',
					},
					dataLabels: {
						name: {
							show: false,
							color: '#fff'
						},
						value: {
							show: true,
							color: '#333',
							offsetY: 5,
							fontSize: '15px'
						}
					}
				}
			},
			colors: ['#ecf0f4'],
			fill: {
				type: 'gradient',
				gradient: {
					shade: 'dark',
					type: 'diagonal1',
					shadeIntensity: 0.8,
					gradientToColors: ['#f56767'],
					inverseColors: false,
					opacityFrom: [1, 0.2],
					opacityTo: 1,
					stops: [0, 100],
				}
			},
			states: {
				normal: {
					filter: {
						type: 'none',
						value: 0,
					}
				},
				hover: {
					filter: {
						type: 'none',
						value: 0,
					}
				},
				active: {
					filter: {
						type: 'none',
						value: 0,
					}
				},
			}
		};

		var options4 = {
			series: [85],
			grid: {
				padding: {
					top: 0,
					right: 0,
					bottom: 0,
					left: 0
				},
			},
			chart: {
				height: 100,
				width: 70,
				type: 'radialBar',
			},	
			plotOptions: {
				radialBar: {
					hollow: {
						size: '50%',
					},
					dataLabels: {
						name: {
							show: false,
							color: '#fff'
						},
						value: {
							show: true,
							color: '#333',
							offsetY: 5,
							fontSize: '15px'
						}
					}
				}
			},
			colors: ['#ecf0f4'],
			fill: {
				type: 'gradient',
				gradient: {
					shade: 'dark',
					type: 'diagonal1',
					shadeIntensity: 0.8,
					gradientToColors: ['#2979ff'],
					inverseColors: false,
					opacityFrom: [1, 0.5],
					opacityTo: 1,
					stops: [0, 100],
				}
			},
			states: {
				normal: {
					filter: {
						type: 'none',
						value: 0,
					}
				},
				hover: {
					filter: {
						type: 'none',
						value: 0,
					}
				},
				active: {
					filter: {
						type: 'none',
						value: 0,
					}
				},
			}
		};

		var options5 = {
			chart: {
				height: 350,
				type: 'bar',
				parentHeightOffset: 0,
				fontFamily: 'Poppins, sans-serif',
				toolbar: {
					show: false,
				},
			},
			colors: ['#1b00ff', '#f56767'],
			grid: {
				borderColor: '#c7d2dd',
				strokeDashArray: 5,
			},
			plotOptions: {
				bar: {
					horizontal: false,
					columnWidth: '25%',
					endingShape: 'rounded'
				},
			},
			dataLabels: {
				enabled: false
			},
			stroke: {
				show: true,
				width: 2,
				colors: ['transparent']
			},
			series: [{
				name: 'In Progress',
				data: [40, 28, 47, 22, 34, 25]
			}, {
				name: 'Complete',
				data: [30, 20, 37, 10, 28, 11]
			}],
			xaxis: {
				categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
				labels: {
					style: {
						colors: ['#353535'],
						fontSize: '16px',
					},
				},
				axisBorder: {
					color: '#8fa6bc',
				}
			},
			yaxis: {
				title: {
					text: ''
				},
				labels: {
					style: {
						colors: '#353535',
						fontSize: '16px',
					},
				},
				axisBorder: {
					color: '#f00',
				}
			},
			legend: {
				horizontalAlign: 'right',
				position: 'top',
				fontSize: '16px',
				offsetY: 0,
				labels: {
					colors: '#353535',
				},
				markers: {
					width: 10,
					height: 10,
					radius: 15,
				},
				itemMargin: {
					vertical: 0
				},
			},
			fill: {
				opacity: 1

			},
			tooltip: {
				style: {
					fontSize: '15px',
					fontFamily: 'Poppins, sans-serif',
				},
				y: {
					formatter: function (val) {
						return val
					}
				}
			}
		}

		var options6 = {
			series: [73],
			chart: {
			height: 350,
			type: 'radialBar',
			offsetY: 0
			},
			colors: ['#0B132B', '#222222'],
			plotOptions: {
			radialBar: {
				startAngle: -135,
				endAngle: 135,
				dataLabels: {
				name: {
					fontSize: '16px',
					color: undefined,
					offsetY: 120
				},
				value: {
					offsetY: 76,
					fontSize: '22px',
					color: undefined,
					formatter: function (val) {
					return val + "%";
					}
				}
				}
			}
			},
			fill: {
			type: 'gradient',
			gradient: {
				shade: 'dark',
				shadeIntensity: 0.15,
				inverseColors: false,
				opacityFrom: 1,
				opacityTo: 1,
				stops: [0, 50, 65, 91]
			},
			},
			stroke: {
			dashArray: 4
			},
			labels: ['Achieve Goals'],
		};

		var chart = new ApexCharts(document.querySelector("#chart"), options);
		chart.render();

		var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
		chart2.render();

		var chart3 = new ApexCharts(document.querySelector("#chart3"), options3);
		chart3.render();

		var chart4 = new ApexCharts(document.querySelector("#chart4"), options4);
		chart4.render();

		var chart5 = new ApexCharts(document.querySelector("#chart5"), options5);
		chart5.render();

		var chart6 = new ApexCharts(document.querySelector("#chart6"), options6);
		chart6.render();


		// datatable init
		$('document').ready(function(){
			$('.data-table').DataTable({
				scrollCollapse: true,
				autoWidth: true,
				responsive: true,
				searching: true,
				bLengthChange: false,
				bPaginate: false,
				bInfo: false,
				columnDefs: [{
					targets: "datatable-nosort",
					orderable: false,
				}],
				"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"language": {
					"info": "_START_-_END_ of _TOTAL_ entries",
					searchPlaceholder: "Search",
					paginate: {
						next: '<i class="ion-chevron-right"></i>',
						previous: '<i class="ion-chevron-left"></i>'  
					}
				},
			});
		});
	</script>