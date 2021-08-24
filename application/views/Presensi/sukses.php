<?php
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
            <div class="col-md-6 col-sm-12 grid-margin stretch-card">
                <div class="card bg-primary card-rounded">
                    <div class="card-body pb-0">
                        <h4 class="card-title card-title-dash text-white mb-4">Berhasil</h4>
                        <hr style='border-top:3px solid white'/>
                        <div class="row">
                            <div class="col-sm-12 mb-4">
                                <h3 class="text-white upgrade-info mb-0">
                                Presensi anda telah <span class="fw-bold">berhasil</span> disimpan! Anda akan diarahkan ke halaman presensi atau klik 
                                <a href="<?php echo base_url('Presensi/')?>"> di sini</a>
                                </h3><br/>
                                <!-- <a href="<?php echo base_url('Presensi/')?>" class="btn btn-info upgrade-btn"><b>Di sini</b></a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <script>
         setTimeout(function(){
            window.location.href = '<?php echo base_url('Presensi/')?>';
         }, 5000);
      </script>
</html>

