
<div class="content-wrapper">
		
			<center>
				<div class='col-sm-12 col-lg-6 pt-5'>	
					<div >
						<div class="card card-outline card-primary">
							<div class="card-header text-center">
							LOGIN
							</div>
							<div class="card-body">
								<form id='login' class="form-horizontal" method='POST' action='<?php echo base_url('login/getlogin')?>'>
									<?php if(isset($_GET['redirect_to'])){?>
									<input type="hidden" name="redirect_to" id="redirect_to" class="form-control" value='<?php echo $_GET['redirect_to'];?>' />
									<?php }?>
									<div class="box-body">
										<div class="form-group required">
											
											<div class="col-sm-12">
												<input class="form-control input-lg" name="Username" placeholder="Username" type="text" autofocus="" required="">
											</div>
										</div>
										<div class="form-group required" >
											
											<div class="col-sm-12">
												<input class="form-control" name="Password" placeholder="Password" type="password" required="">
											</div>
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
									</div><!-- /.box-body -->

									<div class="box-footer center">
										<button class="btn btn-block btn-primary btn-lg btn-flat" title="Login" lbl="Login" ><i class="fa fa-sign-in"></i> Login</button><br>
										<span class="info pull-left"><a style="cursor:pointer" href="#/recover">Lupa password?</a></span>
										<span class="info pull-right">Belum memiliki akun? <a href="#/register">Buat Akun</a></span>
									</div>
								</form>
							
							</div>
						</div><!-- /.card -->
					</div>
				</div>
			</center>
		
  </div>
  <!-- jQuery -->
<script src="<?php echo base_url('assets/AdminLTE/')?>plugins/jquery/jquery.min.js"></script>
  <script>
$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
		toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.');
		// alert("submitted!");
		// 	Toasts('create', {
		// 	class: 'bg-danger',
		// 	title: 'Toast Title',
		// 	subtitle: 'Subtitle',
		// 	body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
		// });
    //   alert( "Form successful submitted!" );
	//   var $form = $('#login');
    // 	$form.submit();
    }
  });
  $('#login').validate({
    
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