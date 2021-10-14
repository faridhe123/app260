<?php
date_default_timezone_set('Asia/Makassar');
// echo date('Y-m-d H:i:s');
$fmt = new \IntlDateFormatter('id_ID', NULL, NULL);
$fmt->setPattern('cccc, d MMMM yyyy'); 

$tgl1 = new \IntlDateFormatter('id_ID', NULL, NULL);
$tgl1->setPattern('d-MMM-yyyy'); 

$tgl2 = new \IntlDateFormatter('id_ID', NULL, NULL);
$tgl2->setPattern('MMMM'); 
// See: http://userguide.icu-project.org/formatparse/datetime for pattern syntax
// Output: 6 gennaio 2016 12:10
?>
 <!-- MDF -->
 <div class="card card-rounded mb-2">
  <div class="card-body">
    <div class="row">
      <div>
        <form method='POST' >
        <div class="row">
            <div class="form-group row col-md-7 align-items-center">
                <label for="exampleInputUsername2" class="col-sm-2 col-form-label">TGL</label>
                <div class="col-sm-5">
                  <div id="datepicker-popupA" class="input-group date datepicker navbar-date-picker">
                      <span class="input-group-addon input-group-prepend border-right">
                          <span class="icon-calendar input-group-text calendar-icon"></span>
                      </span>
                      <input id='i_tanggal' type="text" class="form-control" name='dari' value='<?php echo $dari?>'>
                  </div>
                </div>
                <div class="col-sm-5">
                  <div id="datepicker-popupB" class="input-group date datepicker navbar-date-picker">
                      <span class="input-group-addon input-group-prepend border-right">
                          <span class="icon-calendar input-group-text calendar-icon"></span>
                      </span>
                      <input id='i_tanggal' type="text" class="form-control" name='sampai' value='<?php echo $sampai?>'>
                  </div>
                </div>
            </div>
            <div class="col-md-5 row">
              <div class="col-md-6">
                <button formaction="<?php echo site_url()?>presensi/admin" id='button-izin' class="btn btn-success btn-md text-white mb-0 me-0" type="submit">
                    <i class="mdi mdi-filter"></i> <b>Filter</b>
                </button>
              </div>
              <div class="col-md-6">
                <div class="btn-group">
                  <button formaction="<?php echo site_url()?>presensi/getExcelRekap" id='button-izin'  type="submit" class="btn btn-primary">Download Excel</button>
                  <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuSplitButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuSplitButton1">
                    <h6 class="dropdown-header">Pilh Bulan ...</h6>
                    <?php for($b=1;$b<=12;$b++){?>
                    <a class="dropdown-item" href="<?php echo site_url('presensi/getExcelRekap/'.$b)?>"><?php echo $tgl2->format(new \DateTime("2021-$b-01"))?></a>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <!-- <div class="col-md-6">
                <button formaction="<?php echo site_url()?>presensi/getExcelRekap" id='button-izin' class="btn btn-primary btn-md text-white mb-0 me-0" type="submit">
                    <i class="mdi mdi-download"></i> <b>Download</b>
                </button>
              </div> -->
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="row flex-grow">
  <div class="col-12 grid-margin stretch-card">
    <div class="card card-rounded">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div>
                <h4 class="card-title card-title-dash">Rekap Presensi 
                    <?php  echo ($dari == date('Y-m-d') && $sampai == date('Y-m-d')) ? ' HARI INI' 
                      : '<span class="text-danger">'.$tgl1->format(new \DateTime($dari)).' - '.$tgl1->format(new \DateTime($sampai)).'</span>'; ?></h4>
                <a class="btn btn-primary" href="<?php echo site_url('presensi/uid')?>">CEK UID</a>
            </div>
            </div>
            <div class="mt-3">
              <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Masuk</th>
                                <th>Pulang</th>
                                <th>UID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($hasil as $row){?>
                                <tr>
                                    <td><?php echo $fmt->format(new \DateTime($row['date_record'])); ?></td>
                                    <td>
                                      <div class="d-flex">
                                        <img class="img-sm rounded-10" src="<?php echo base_url() ?>assets/template/images/faces/face1.jpg" alt="profile">
                                        <div class="wrapper ms-3">
                                          <p class="ms-1 mb-1 fw-bold"><?php echo $row['nama']?></p>
                                          <small class="text-muted mb-0"><?php echo $row['username']?></small>
                                        </div>
                                      </div>
                                    </td>
                                    <td><?php echo date("H:i:s",strtotime($row['masuk'])) ?></td>
                                    <td><?php echo $row['pulang'] ? date("H:i:s",strtotime($row['pulang'])) : "<span class='text-danger'>Belum Absen</span>" ?></td>
                                    <td><?php $list = explode('/',$row['list_uid']);?>
                                      <div class="text-muted text-small" title='<?php foreach($list as $li) echo '- '.$li.'&#10'; ?>'>
                                        <?php echo $row['jumlah_uid']?>
                                      </div>
                                    </td>
                                </tr>
                            <?php }?>
                            </tbody>
                    </table>
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
        format: 'yyyy-mm-dd',
        enableOnReadonly: true,
        todayHighlight: true,
    });
    $('#datepicker-popupB').datepicker({
        format: 'yyyy-mm-dd',
        enableOnReadonly: true,
        todayHighlight: true,
    });
  });

 
</script>