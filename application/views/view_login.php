<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>App260 | Login</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/template/vendors/feather/feather.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/template/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/template/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/template/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/template/vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/template/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/template/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?php echo base_url() ?>/assets/template/images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img style='width:130px' src="<?php echo base_url() ?>/assets/template/images/logo.png" alt="logo">
				<!-- <span style='font-size:30px' >App<b>260</b></span> -->
              </div>
              <h4>Selamat datang di App260</h4>
              <h6 class="fw-light">Silahkan Login untuk melanjutkan</h6>
			  	<form id='login' class="form-horizontal pt-3k" method='POST' action='<?php echo base_url('login/getlogin')?>'>                
					<?php if(isset($_GET['redirect_to'])){?>
					<input type="hidden" name="redirect_to" id="redirect_to" class="form-control" value='<?php echo $_GET['redirect_to'];?>' />
					<?php }?>
					<div class="form-group">
						<input  name="Username" type="text" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username" required>
					</div>
					<div class="form-group">
						<input name="Password" type="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" required>
					</div>
					<div class="mt-3">
						<button title="Login" lbl="Login" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
					</div>
					<?php $sukses = $this->session->flashdata('sukses');
					if(isset($sukses)){ ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<?php echo $sukses ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<?php }?>
					<?php 
					$info = $this->session->flashdata('info');
					if(!empty($info)){ ?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>Username / password salah!</strong><br/>Hubungi administrator jika lupa password.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<?php } ?>
				</form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="<?php echo base_url() ?>/assets/template/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="<?php echo base_url() ?>/assets/template/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="<?php echo base_url() ?>/assets/template/js/off-canvas.js"></script>
  <script src="<?php echo base_url() ?>/assets/template/js/hoverable-collapse.js"></script>
  <script src="<?php echo base_url() ?>/assets/template/js/template.js"></script>
  <script src="<?php echo base_url() ?>/assets/template/js/settings.js"></script>
  <script src="<?php echo base_url() ?>/assets/template/js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>
