<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/deskapp/')?>/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/deskapp/')?>/src/plugins/datatables/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/deskapp/')?>/vendors/styles/style.css">
	
	<div class="main-container">
		
		<div class="pd-ltr-20">
			<div class="page-header">
				<div class="row">
					<div class="col-md-12 col-sm-12">
						<div class="title">
							<h4><?php echo $title. (isset($filter) ? " : "  . $hasil[0]['merk_type']." (".$hasil[0]['nopol'].")" : "");?></h4>
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
			
			<div class="card-box mb-30">
				
				<h2 class="h4 pd-20">Detil Pinjam</h2>
				<h2 class="h4 pd-20">
					<a href="<?php echo base_url('pinjam_kendaraan')?>"  class="btn btn-success" role="button">Lihat Kendaraan</a>
					<a href="<?php echo base_url('pinjam_kendaraan/calendar')?>" class="btn btn-warning" role="button">Lihat Kalender</a>
				</h2>
				
				<table class="table data-table nowrap">
					<thead>
						<tr>
							<th class="datatable-nosort" style='width:100px'></th>
							<th style='text-align: right;'>ID Akun</th>
							<th>Nama</th>
							<th>Unit</th>
							<th>Jabatan</th>
							<th>Akses</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						foreach($user as $row){
							?>
							
						<tr>
							<td class="table-plus">
								<img src="<?php echo base_url('assets/')?>/images/button_anonymous.jpg" width="70" height="70" alt="">
							</td>
							<td>
								<h5 class="font-16"><?php echo $row['username'];?></h5>
								id: <?php echo $row['id_akun'] ;?>
							</td>
							<td ><?php echo $row['nama']?></td>
							<td>
								<h5 class="font-16"><?php echo $row['nm_es3_short']?></h5>
								<?php echo $row['nama_unit_es4']?substr($row['nama_unit_es4'],0,23)."...":"" ?>
							</td>
							<td ><?php echo $row['jabatan']?></td>
							<?php if(($this->session->userdata('role')=='admin')){ ?>
								<td> 
									<?php if(!isset($row['akses'])){?>
									<form action="<?php echo base_url("akses/buka/"); ?>" method="POST" id='button_admin_reset'>
										<div class='form-group'>
											<input name='id_akun' value='<?php echo $row['id_akun']?>' type="text" hidden>
											<button type="submit" name='akses' class="btn btn-danger btn-sm">Ditutup</button>	<br/>
										</div>
									</form>
									<?php }else {?>
									<form action="<?php echo base_url("akses/tutup/"); ?>" method="POST" id='button_admin_reset'>
										<div class='form-group'>
											<input name='id_akun' value='<?php echo $row['id_akun']?>' type="text" hidden>
											<button type="submit" class="btn btn-success btn-sm">Dibuka</button>	<br/>
										</div>
									</form>
									<?php } ?>
								</td>
							<?php }?>
						</tr>
						<?php } ?>
					</tbody>
				</table>
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


		// datatable init
		$('document').ready(function(){
			$('.data-table').DataTable({
				scrollCollapse: true,
				autoWidth: true,
				//responsive: true,
				searching: false,
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