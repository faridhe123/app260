
  <link rel="stylesheet" href="<?php echo base_url('assets/AdminLTE/')?>plugins/toastr/toastr.min.css">
<div class="content-wrapper">
	<div class='row pt-5' >
		<div class="col-md-3"></div>
		<div class="col-md-8">
			<div class='row'>
				<div class='col-sm-12 col-lg-10'>	
					<div >
						<div class="card card-outline card-primary">
							<div class="card-header text-center">
							Form Registrasi
							</div>
							<div class="card-body">

								<form id='register' action='<?php echo base_url('register/submit')?>' method='POST' >
									<div class="box-body">
										<div class="row form-group">
											<label style='text-align:right' for="Nama" class="col-sm-3 control-label  ">Nama</label style='text-align:right'  >
											<div class="col-sm-6">
												<input class="form-control " name="Nama" autofocus="">
											</div>
										</div>
										<div class="row form-group" >
											<label style='text-align:right'  for="NIK" class="col-sm-3 control-label  ">NIK</label style='text-align:right'  >
											<div class="col-sm-4">
												<input class="form-control " name="NIK" >
											</div>
										</div>
										<div class="row form-group" >
											<label style='text-align:right'  for="Alamat" class="col-sm-3 control-label  ">Alamat</label style='text-align:right'  >
											<div class="col-sm-8">
												<input class="form-control " name="Alamat"  placeholder="" type="text" maxlength="512" >
												
											</div>
										</div>
										<div class="row form-group required" >
											<label style='text-align:right'   for="Email" class="col-sm-3 control-label required ">Email</label style='text-align:right'  >
											<div class="col-sm-5">
												<input class="form-control " name="Email" placeholder="" type="email" maxlength="128" required="">
												<div class="errorTxt"></div>
												<small class="form-text text-muted">
													Alamat email aktif yang dapat dihubungi
												</small>
											</div>
											
										</div>
										<div class="row form-group required" >
											<label style='text-align:right'   for="NoTelp" class="col-sm-3 control-label  required ">Telepon</label style='text-align:right'  >
											<div class="col-sm-4">
												<input class="form-control " name="NoTelp" placeholder="" type="text" maxlength="16" required="">
												<div class="errorTxt"></div>
												<small class="form-text text-muted">
													Nomor telepon aktif yang dapat dihubungi
												</small>
											</div>
										</div>
										<hr>
										<div class="row form-group required" >
											<label style='text-align:right'   for="Username" class="col-sm-3 control-label   required">Username</label style='text-align:right'  >
											<div class="col-sm-5">
												<input class="form-control " name="Username" placeholder="" type="text" maxlength="128" required="">
												<div class="errorTxt"></div>
											</div>
										</div>
										<div class="row form-group" >
											<label style='text-align:right'   for="Password" class="col-sm-3 control-label   required">Password</label style='text-align:right'  >
											<div class="col-sm-5 col-md-4">
												<input class="form-control " id='Password' name="Password" placeholder="" type="password" maxlength="128" required="">
												<div class="errorTxt"></div>
												<small class="form-text text-muted">Password minimal 6 karakter.</small>
											</div>
											<div class="col-sm-5 col-md-4">
												<input class="form-control " name="ConfirmPassword" placeholder="Konfirmasi Password" type="password" maxlength="128" required="" >
												<div class="errorTxt"></div>
												<!-- ngIf: Form.ConfirmPassword.$dirty && Pelapor.ConfirmPassword != Pelapor.Password -->
											</div>
										</div>
									<div class="box-footer center">
										
										<button type='submit' class="btn btn-block btn-primary btn-flat" title="Buat Akun" lbl="Buat Akun" ><i class="fa fa-save"></i> Buat Akun</button><br>
										<center><span class="info">Sudah memiliki akun? <a href="Account/Login">Login</a></span><center>
											</div>
									<!-- /.box-footer -->
								</form>
							</div>
							<!-- /.form-box -->
						</div><!-- /.card -->
					</div>
				</div>
			</div>
		</div>
  </div>
  <!-- jQuery -->
<script src="<?php echo base_url('assets/AdminLTE/')?>plugins/jquery/jquery.min.js"></script>

<!-- SweetAlert2 -->
<script src="<?php echo base_url('assets/AdminLTE/')?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?php echo base_url('assets/AdminLTE/')?>plugins/toastr/toastr.min.js"></script>


  <script>
$(function () {

  $('#register').validate({
	submitHandler: function (form) {
		// return false; 
	// 	Toast.fire({
    //     icon: 'success',
    //     title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
    //   })
		// toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.');
		// alert("submitted!");
		// 	Toasts('create', {
		// 	class: 'bg-danger',
		// 	title: 'Toast Title',
		// 	subtitle: 'Subtitle',
		// 	body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
		// })
		// alert( "Form successful submitted!" );
		// console.log(form.serialize());
		// $.ajax({
		// 	url   :"<?php echo base_url('register/')?>cek_id",
		// 	type  :"POST",
		// 	data  :form.serialize(),
		// 	cache :false,
		// 	success:function(result){
		// 	alert(result);
		// 	$("#add_name")[0].reset();
		// 	}
		// });
		// return false;
		//   var $form = $('#register');
		// 	$form.submit();
    },
	rules: {
		"Email": {
			required: true,
			email: true
		},
		"Telepon": {
			required: true,
			digits: true
		},
		"Username": {
			required: true,
		},
		"Password": {
			required: true,
			minlength: 6,
		},
		"ConfirmPassword": {
			required: true,
			equalTo: "#Password",
		},
	},
    errorElement: 'span',
    // errorLabelContainer: '.errorTxt',
    errorPlacement: function(error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>