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
                <div class='card card-rounded mx-2'>
                    <div class="card-body">
                        <div class="d-sm-flex justify-content-between align-items-start">
                            <h4 class="card-title card-title-dash">PRESENSI PEGAWAI NON ASN</h4>
                        </div>
                        <form id='absen_masuk' method='POST' >            
                            <div class="row">
                                <!-- <label for="exampleInputUsername2" class="col-sm-3 col-form-label">LAT</label> -->
                                <div class="col-sm-6">
                                    <input name='lat' id='lat' type="text" class="form-control" id="exampleInputUsername2" placeholder="Latitude">
                                </div>
                                <!-- <label for="exampleInputUsername2" class="col-sm-3 col-form-label">LONG</label> -->
                                <div class="col-sm-6">
                                    <input name='long' id='long' type="text" class="form-control" id="exampleInputUsername2" placeholder="Longitude">
                                </div>
                            </div>
                        </form>
                        <div class='my-3 row'>
                            <strong class='col-12'>Data Presensi Anda Hari ini</strong><br/>
                            <strong class='col-12'>NIP 817933289 / 13571598</strong><br/>
                            <strong class='col-12'>pada tanggal 22-08-2021</strong><br/>
                        </div>
                        <div class='my-3 row'>
                            <strong class='col-4'>Waktu Masuk</strong>
                            <strong class='col-8'>: 00:00:00 WITA</strong><br/>
                        </div>
                        <div class='my-3 row'>
                            <strong class='col-4'>Waktu Pulang</strong>
                            <strong class='col-8'>: 00:00:00 WITA</strong><br/>
                        </div>
                        <button id='btn_absen' class="btn btn-primary me-2 mb-3"><i class='mdi mdi-clock-outline'></i>&nbsp;&nbsp; ABSEN</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class='card card-rounded mx-2'>
                    <div class="card-body">
                        <h4 class="card-title"><i class='mdi mdi-information-outline'></i>&nbsp;&nbsp; Informasi</h4>
                        <blockquote class="blockquote">
                            <ul>
                                <li>Form wajib diisi sekali sehari</li>
                                <li>Pegawai tidak dapat mengisi kegiatan logbook apabila belum menyelesaikan form assessment ini</li>
                                <li>Isian akan disimpan digunakan sebagai alat bantu DJP dalam memonitoring kondisi kesehatan pegawai</li>
                                <li>Data pribadi akan tersimpan otomatis setelah diisi, dan dapat di update setiap hari</li>
                                <li>Pegawai dapat melakukan penilaian mandiri lebih dari satu kali setiap harinya</li>
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

                    // coba AJAX
                    $.ajax({
                        type: "POST",
                        url: "<?php  echo base_url('Test_ajax/test'); ?>",
                        data: form,

                        success: function(data){
                            alert(data); //Unterminated String literal fixed
                        }
                    });
       
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

