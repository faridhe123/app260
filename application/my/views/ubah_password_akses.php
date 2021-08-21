<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>DESK260 - Ubah Password</title>

	<!-- Site favicon -->
	<!-- <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url('assets/deskapp/')?>vendors/images/apple-touch-icon.png"> -->
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/deskapp/')?>vendors/images/favicon-desk260.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/deskapp/')?>vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/deskapp/')?>vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/deskapp/')?>vendors/styles/style.css">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async <?php echo base_url('assets/deskapp/')?>src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script>
</head>
<body class="login-page">
	<div class="login-header box-shadow">
		<div class="container-fluid d-flex justify-content-between align-items-center">
			<div class="brand-logo">
				<a href="<?php echo base_url();?>">
					<img src="<?php echo base_url('assets/deskapp/')?>/vendors/images/des-logo3.png" alt="" class="light-logo">
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
							<h2 class="text-center text-danger">Ubah Password</h2>
						</div>
						<p style='text-align:center'>Silahkan ubah password anda untuk menghindari akses dari pihak lain.</p>
						<p style='text-align:center' class='text-primary'>Password ≥6 karakter dan tidak boleh sama dengan username</p>
						<form method="POST"	action="<?php echo base_url("akses/update_password/");?>">
							<?php if(isset($_GET['redirect_to'])){?>
							<input type="hidden" name="redirect_to" id="redirect_to" class="form-control" value='<?php echo $_GET['redirect_to'];?>' />
							<?php }?>
							<label for='pass_baru'>Ketik password baru</label>
							<div class="input-group custom">
								<input id='pass_baru' type="password" name='password' class="form-control form-control-lg" placeholder="**********" required>
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
								</div>
							</div>
							<label for='pass_konfirmasi'>Konfirmasi Password</label>
							<div class="input-group custom">
								<input id='pass_konfirmasi' type="password" name='password_c' class="form-control form-control-lg" placeholder="**********" required>
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="dw dw-padlock1"></i></span>
								</div>
							</div>
							<?php 
							$info = $this->session->flashdata('info');
							if(!empty($info)){ ?>
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<?php echo $info ?>
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<?php }?>
							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
										<!--
											use code for form submit
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
										-->
										<button type="submit" class="btn btn-primary btn-lg btn-block">Ubah</button>
									</div>
								</div>
							</div>
						</form>
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