

  <!-- MDF -->
  
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/time-picker-bootstrap/')?>timepicker.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/time-picker-bootstrap/')?>bootstrap.min.css">
<?php
date_default_timezone_set('Asia/Makassar');
// echo date('Y-m-d H:i:s');
$fmt = new \IntlDateFormatter('id_ID', NULL, NULL);
$fmt->setPattern('cccc, d MMMM yyyy'); 
// See: http://userguide.icu-project.org/formatparse/datetime for pattern syntax
// Output: 6 gennaio 2016 12:10
?>

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h4 class="card-title card-title-dash">Daftar Izin Keluar Kantor</h4>
                    <p class="card-subtitle card-subtitle-dash"></p>
                    </div>
                    <div>
                        <button id='button-izin' class="btn btn-primary btn-md text-white mb-0 me-0" type="button">
                            <i class="mdi mdi-plus"></i> <b>Buat Izin</b>
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Keperluan</th>
                                <th>status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($hasil as $row){?>
                                <tr>
                                    <td><?php echo $fmt->format(new \DateTime($row['tanggal'])); ?></td>
                                    <td><?php echo date('H:i',strtotime('2021-01-01 '.$row['dari'])) . ' s.d. ' . date('H:i',strtotime('2021-01-01 '.$row['sampai'])); ?></td>
                                    <td><?php echo $row['keperluan'];?></td>
                                    <td>
                                        <?php if($row['status']){?><label class="badge badge-success">Disetujui</label><?php } ?>
                                        <?php if(){?><label class="badge badge-success">Disetujui</label><?php } ?>
                                    </td>
                                </tr>
                            <?php }?>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->

    <div id="modal-add" class="modal modal-top fade calendar-modal">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <form id="add-event" action="<?php echo base_url("Izin_keluar/submitIzin/"); ?>" method="POST">
                    <div class='modal-header'>
                        <h4 class="text-blue h4 mb-10">Izin Keluar Kantor</h4>

                    </div>
                    <div class="modal-body">
                        <input type="text" class="form-control" id="jarak" name='jarak' hidden readonly>
                        <input type="text" class="form-control" id="long" name='long' hidden readonly>
                        <input type="text" class="form-control" id="lat" name='lat' hidden readonly>
                        <div class="form-group">
                            <label for="tanggal-keluar">Tanggal : </label>
                            <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
                                <span class="input-group-addon input-group-prepend border-right">
                                    <span class="icon-calendar input-group-text calendar-icon"></span>
                                </span>
                                <input id='i_tanggal' type="text" class="form-control" name='tanggal'>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row ml-2">
                                <div class="col-md-6">
                                        <label>Dari</label>
                                        <input  id='i_dari' class="form-control simpleExample row" type="text" name='dari' value='09:00'>
                                </div>
                                <div class="col-md-6">
                                        <label>Sampai</label>
                                        <input id='i_sampai' class="form-control simpleExample row" type="text" name='sampai' value='12:00'>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea1">Keperluan : </label>
                            <textarea class="form-control" id="exampleTextarea1" rows="" name='keperluan' style='height:100px'></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id='submitButton' type="submit" class="btn btn-primary" >Submit</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
      
      $( document ).ready(function(){
        $(".simpleExample").timepicker({
          hourHeaderText: "Jam",
          minHeaderText: "Menit",
          okButtonText: "<b>Pilih</b>",
          cancelButtonText: "Tutup",
          selectSize: 5
        });
	  });

      function calcCrow(coord1, coord2)
        {
            // var R = 6.371; // km
            var R = 6371000;
            var dLat = toRad(coord2.lat-coord1.lat);
            var dLon = toRad(coord2.lng-coord1.lng);
            var lat1 = toRad(coord1.lat);
            var lat2 = toRad(coord2.lat);

            var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
            var d = R * c;
            return d;
        }

        // Converts numeric degrees to radians
        function toRad(Value)
        {
            return Value * Math.PI / 180;
        }
      
        // Membuka Modal Jika Klik Button Buat Izin
        document.getElementById("button-izin").addEventListener('click', evt=>{
            jQuery('#modal-add').modal('show');

            //CEK NYALA ATAU TIDAK GPS
            if('geolocation' in navigator){
                // apakah ada GPS?
                navigator.geolocation.getCurrentPosition(position=>{
                    let latitude = position.coords.latitude;
                    let longitude = position.coords.longitude;

                    // Ubah nilai di form
                    $('#lat').val(latitude);
                    $('#long').val(longitude);
                    
                    //jarak
                    coordKantor = {"lat": -5.1327699,"lng": 119.4395278};
                    coordPegawai = {"lat": latitude,"lng": longitude};
                    $('#jarak').val(calcCrow(coordKantor, coordPegawai));

                },error=>{                      // jika error
                    console.log(error.code)
                })
            }else{
                console.log("Not Supported");   //jika tidak support
            }

            jQuery('#i_tanggal').val(moment().format('MM/DD/YYYY'));
            jQuery('#i_dari').val(moment().format('HH:mm'));
            jQuery('#i_sampai').val(moment().add(1, 'hours').format('HH:mm'));
        });

    </script>