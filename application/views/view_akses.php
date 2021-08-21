<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>Desk260</title>

	<!-- Site favicon -->
	<!-- <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url('assets/deskapp/')?>vendors/images/apple-touch-icon.png"> -->
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/deskapp/')?>vendors/images/favicon-desk260.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<!-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"> -->
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/deskapp/')?>vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/deskapp/')?>vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/deskapp/')?>vendors/styles/style.css">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<!-- <script async <?php echo base_url('assets/deskapp/')?>src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script> -->
</head>
<body class="login-page">
	<div class="login-header box-shadow">
		<div class="container-fluid d-flex justify-content-between align-items-center">
			<div class="brand-logo">
				<a href="<?php echo base_url();?>">
					<img <?php echo base_url('assets/deskapp/')?>src="<?php echo base_url('assets/deskapp/')?>vendors/images/des-logo3.png" alt="">
				</a>
			</div>
			
		</div>
	</div>
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 col-lg-7">
				<?php if(isset($_GET['redirect_to'])){ 
					if( urldecode($_GET['redirect_to'])== '/desk260/tinjauan_tukin/' ){?>
					<img src="<?php echo base_url('assets/images/')?>cont.png" alt="">
					<?php }
						}else{?>
							<img src="<?php echo base_url('assets/images/')?>security.webp" alt="">
						<?php } ?>
				</div>
				<div class="col-md-6 col-lg-5">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-danger">Akses Terbatas</h2>
						</div>
						<p style='text-align:center'>Silahkan konfirmasi identitas pegawai ke administrator untuk dapat mengakses ke halaman ini. Klik <a href='<?php echo base_url('')?>'><b>disini</b></a> untuk kembali ke Beranda</p>
						<p style='text-align:center' class='text-primary'><?php echo urldecode($_GET['redirect_to']??null)?></p>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- js -->
	<script <?php echo base_url('assets/deskapp/')?>src="<?php echo base_url('assets/deskapp/')?>vendors/scripts/core.js"></script>
	<script <?php echo base_url('assets/deskapp/')?>src="<?php echo base_url('assets/deskapp/')?>vendors/scripts/script.min.js"></script>
	<script <?php echo base_url('assets/deskapp/')?>src="<?php echo base_url('assets/deskapp/')?>vendors/scripts/process.js"></script>
	<script <?php echo base_url('assets/deskapp/')?>src="<?php echo base_url('assets/deskapp/')?>vendors/scripts/layout-settings.js"></script>
</body>
</html>