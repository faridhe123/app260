<?php
date_default_timezone_set('Asia/Makassar');
// echo date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta/>
        <meta/>
        <meta/>
        <title>Geolocation</title>
    </head>
    <body>
        <div class="row">
            <div class="col-md-6">
                <div class='card card-rounded m-1'>
                    <div class="card-body">
                        <div class="d-sm-flex justify-content-between align-items-start">
                            <h4 class="card-title card-title-dash">PRESENSI PEGAWAI NON ASN</h4>
                        </div>
                        <hr/>
                        <form id='absen_masuk' method='POST' >            
                            <div class="row">
                                <!-- <label for="exampleInputUsername2" class="col-sm-3 col-form-label">LAT</label> -->
                                <input name='username' id='username' type="text"  placeholder="Latitude" value='<?php echo $this->session->userdata('username') ?>' hidden>
                                <div class="col-sm-6">
                                    <input name='lat' id='lat' type="text" class="form-control" id="exampleInputUsername2" placeholder="Latitude" hidden>
                                </div>
                                <!-- <label for="exampleInputUsername2" class="col-sm-3 col-form-label">LONG</label> -->
                                <div class="col-sm-6">
                                    <input name='long' id='long' type="text" class="form-control" id="exampleInputUsername2" placeholder="Longitude"  hidden>
                                </div>
                            </div>
                        </form>
                        <div class='my-3 row'>
                            <span class='col-12'><u>Data presensi anda hari ini</u></span><br/>
                            <strong class='col-4'>Nama</strong><br/>
                                <strong class='col-8'>: <?php echo $this->session->userdata('nama')?></strong><br/>
                            <strong class='col-4'>ID</strong><br/>
                                <strong class='col-8'>: <?php echo $this->session->userdata('username')?></strong><br/>
                            <strong class='col-4'>tanggal</strong><br/>
                            <strong class='col-8'>: <?php echo date('d-m-Y')?></strong><br/>
                        </div>
                        <hr/>
                        <div class='mt-3 row'>
                            <strong class='col-4'>Masuk</strong>
                            <?php if(isset($hasil['min'])){?>
                            <strong class='col-4'>: <?php echo date('H:i:s',strtotime($hasil['min']))?></strong><br/>
                            <strong class='col-3'> WITA</strong><br/>
                            <?php }else { ?>
                            <span class='col-8' style='color:darkgrey'>: Belum presensi</span>
                            <?php }?>
                        </div>
                        <div class='mb-3 row'>
                            <strong class='col-4'>Pulang</strong>
                            <?php if($hasil['max'] !== $hasil['min']){?>
                            <strong class='col-4'>: <?php echo date('H:i:s',strtotime($hasil['max']))?></strong><br/>
                            <strong class='col-3'> WITA</strong><br/>
                            <?php }else { ?>
                            <span class='col-8' style='color:darkgrey'>: Belum presensi</span>
                            <?php }?>
                        </div>
                        <button id='btn_absen' class="btn btn-primary me-2 mb-3"><i class='mdi mdi-clock-outline'></i>&nbsp;&nbsp; ABSEN</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class='card card-rounded m-1'>
                    <div class="card-body">
                        <h4 class="card-title"><i class='mdi mdi-information-outline'></i>&nbsp;&nbsp; Informasi</h4>
                        <blockquote class="blockquote">
                            <ul>
                                <li>Data pribadi akan tersimpan otomatis setelah diisi, dan dapat di update setiap hari</li>
                                <li>Pastikan mengklik 'Allow' saat dikonfirmasi browser untuk mengakses lokasi device</li>
                                <li>Apabila setelah klik 'Allow' koordinat masih belum muncul, disarankan untuk menggunakan browser lain atau device lain</li>
                                <li>Penilaian mandiri ini disusun berdasarkan protokol penanganan bencana COVID-19 Kementerian Keuangan</li>
                            </ul>
                        </blockquote>
                    </div>
                </div>
            </div>
            
        </div>
        
    </body>

    <script>
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

