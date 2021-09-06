<?php
date_default_timezone_set('Asia/Makassar');
// echo date('Y-m-d H:i:s');
$tgl1 = new \IntlDateFormatter('id_ID', NULL, NULL);
$tgl1->setPattern('cccc, d MMMM yyyy'); 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta/>
        <meta/>
        <meta/>
        <title>Presensi</title>
    </head>
    <body>
        <div class="row">
            <div class="col-md-12">
                <div class='card card-rounded m-1'>
                    <div class="card-body" style="overflow-y: scroll; height:400px;">
                        <div class="d-sm-flex justify-content-between align-items-start">
                            <h4 class="card-title card-title-dash">Notifikasi Penggunaan UID</h4>
                        </div>
                        <hr/>
                        <?php foreach($notifikasi as $notif){?>
                        <blockquote class="blockquote" style='background:#ffcec8'>
                            <ul>
                                <li><?php echo $notif['indikasi'] . " pada hari ".$tgl1->format(new \DateTime($notif['date_record'])) . 
                                    " pukul ". date("H:i", strtotime($notif['date_record']))?></li>
                            </ul>
                        </blockquote>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class='card card-rounded m-1'>
                    <div class="card-body">
                        <h4 class="card-title"><i class='mdi mdi-information-outline'></i>&nbsp;&nbsp; List Unique ID Perangkat</h4>
                        <div class="table-responsive pt-3" style="overflow-y: scroll; height:400px;">
                            <table class="table table-dark" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>UID</th>
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Freq.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1;foreach($hasil as $rows){?>
                                <tr>
                                    <td><?php echo $no++;?></td>
                                    <td><?php echo $rows['uid']?></td>
                                    <td><?php echo $rows['username']?></td>
                                    <td><?php echo $rows['user_pemilik']?></td>
                                    <td><?php echo $rows['frekuensi']; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
    </body>

    <script>

        var navigator_info = window.navigator;
        var screen_info = window.screen;
        var uid = navigator_info.mimeTypes.length;

        console.log(navigator_info.userAgent)

        uid += navigator_info.userAgent.replace(/\D+/g,'');
        uid += navigator_info.plugins.length;
        uid += screen_info.height || '';
        uid += screen_info.width || '';
        uid += screen_info.pixelDepth || '';
        // console.log(uid);

        $( document ).ready(function(){
            $('#uid' ).val(uid);
            // detilnya
            $('#user_agent' ).val(navigator_info.userAgent.replace(/\D+/g,''));
            $('#plugins_length' ).val(navigator_info.plugins.length);
            $('#screen_height' ).val(screen_info.height || '');
            $('#screen_width' ).val(screen_info.width || '');
            $('#pixel_depth' ).val(screen_info.pixelDepth || '');
        });

        const getLocation = document.getElementById("btn_absen");

        //This function takes in latitude and longitude of two locations
        // and returns the distance between them as the crow flies (in meters)
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

        getLocation.addEventListener('click', evt=>{
            if('geolocation' in navigator){
                // apakah ada GPS?
                navigator.geolocation.getCurrentPosition(position=>{
                    let latitude = position.coords.latitude;
                    let longitude = position.coords.longitude;

                    // Ubah nilai di form
                    $('#lat').val(latitude);
                    $('#long').val(longitude);
                    $('#uid').val(uid);
                     // detilnya
                    $('#user_agent' ).val(navigator_info.userAgent.replace(/\D+/g,''));
                    $('#plugins_length' ).val(navigator_info.plugins.length);
                    $('#screen_height' ).val(screen_info.height || '');
                    $('#screen_width' ).val(screen_info.width || '');
                    $('#pixel_depth' ).val(screen_info.pixelDepth || '');

                    form = $('#absen_masuk').serialize();

                    coordKantor = {"lat": -5.1327699,"lng": 119.4395278};
                    coordPegawai = {"lat": latitude,"lng": longitude};
                    
                    
                    if(calcCrow(coordKantor, coordPegawai) > 200 && false) { // jarak jauh dari kantor
                        status = "Harap melakukan absen dalam wilayah kantor";
                        alert( "Jarak anda "+calcCrow(coordKantor, coordPegawai).toFixed(2)+ " m kantor. "+status);
                    }
                    else { // masuk area kantor
                        // coba AJAX
                        $.ajax({
                            type: "POST",
                            url: "<?php  echo base_url('Presensi/submit'); ?>",
                            data: form,

                            success: function(data){
                                // alert(data); //Unterminated String literal fixed
                                location.href = "<?php echo base_url('Presensi/sukses'); ?>"
                            }
                        });
                    }

                    //alert( "Jarak anda "+calcCrow(Kantor, Pegawai).toFixed(2)+ " m kantor. "+status);

                    
       
                    console.log(form)  
                },error=>{                      // jika error
                    console.log(error.code)
                })
            }else{
                console.log("Not Supported");   //jika tidak support
            }
        });

    </script>
</html>

