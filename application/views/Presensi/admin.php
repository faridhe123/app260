
 <!-- MDF -->

<div class="row flex-grow">
  <div class="col-12 grid-margin stretch-card">
    <div class="card card-rounded">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div>
                <h4 class="card-title card-title-dash">Rekap Presensi</h4>
              </div>
              <div>
                <div class="row">
                  <div class="form-group row col-md-8 align-items-center">
                      <label for="exampleInputUsername2" class="col-sm-2 col-form-label">Tanggal</label>
                      <div class="col-sm-5">
                        <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
                            <span class="input-group-addon input-group-prepend border-right">
                                <span class="icon-calendar input-group-text calendar-icon"></span>
                            </span>
                            <input id='i_tanggal' type="text" class="form-control" name='tanggal'>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div id="datepicker-popupA" class="input-group date datepicker navbar-date-picker">
                            <span class="input-group-addon input-group-prepend border-right">
                                <span class="icon-calendar input-group-text calendar-icon"></span>
                            </span>
                            <input id='i_tanggal' type="text" class="form-control" name='tanggal'>
                        </div>
                      </div>
                  </div>
                  <div class="col-md-3">
                    <button id='button-izin' class="btn btn-primary btn-md text-white mb-0 me-0" type="button">
                        <i class="mdi mdi-download"></i> <b>Unduh File</b>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="mt-3">
              <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                <div class="d-flex">
                  <img class="img-sm rounded-10" src="<?php echo base_url() ?>assets/template/images/faces/face1.jpg" alt="profile">
                  <div class="wrapper ms-3">
                    <p class="ms-1 mb-1 fw-bold">Brandon Washington</p>
                    <small class="text-muted mb-0">162543</small>
                  </div>
                </div>
                <div class="text-muted text-small">
                  1h ago
                </div>
              </div>
              <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                <div class="d-flex">
                  <img class="img-sm rounded-10" src="<?php echo base_url() ?>assets/template/images/faces/face2.jpg" alt="profile">
                  <div class="wrapper ms-3">
                    <p class="ms-1 mb-1 fw-bold">Wayne Murphy</p>
                    <small class="text-muted mb-0">162543</small>
                  </div>
                </div>
                <div class="text-muted text-small">
                  1h ago
                </div>
              </div>
              <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                <div class="d-flex">
                  <img class="img-sm rounded-10" src="<?php echo base_url() ?>assets/template/images/faces/face3.jpg" alt="profile">
                  <div class="wrapper ms-3">
                    <p class="ms-1 mb-1 fw-bold">Katherine Butler</p>
                    <small class="text-muted mb-0">162543</small>
                  </div>
                </div>
                <div class="text-muted text-small">
                  1h ago
                </div>
              </div>
              <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                <div class="d-flex">
                  <img class="img-sm rounded-10" src="<?php echo base_url() ?>assets/template/images/faces/face4.jpg" alt="profile">
                  <div class="wrapper ms-3">
                    <p class="ms-1 mb-1 fw-bold">Matthew Bailey</p>
                    <small class="text-muted mb-0">162543</small>
                  </div>
                </div>
                <div class="text-muted text-small">
                  1h ago
                </div>
              </div>
              <div class="wrapper d-flex align-items-center justify-content-between pt-2">
                <div class="d-flex">
                  <img class="img-sm rounded-10" src="<?php echo base_url() ?>assets/template/images/faces/face5.jpg" alt="profile">
                  <div class="wrapper ms-3">
                    <p class="ms-1 mb-1 fw-bold">Rafell John</p>
                    <small class="text-muted mb-0">Alaska, USA</small>
                  </div>
                </div>
                <div class="text-muted text-small">
                  1h ago
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  
  $( document ).ready(function(){
      
    $('#datepicker-popupA').datepicker({
        enableOnReadonly: true,
        todayHighlight: true,
    });
    $("#datepicker-popupA").datepicker("setDate", "0");
  });

 
</script>