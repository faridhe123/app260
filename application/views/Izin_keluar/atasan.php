

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
                        <h4 class="card-title card-title-dash"><?php echo $this->session->userdata('nama_unit_es4')?></h4>
                    <p class="card-subtitle card-subtitle-dash"></p>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Keperluan</th>
                                <th>Tindaklanjut</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($hasil as $row){?>
                                <tr>
                                    <td>
                                        <strong><?php echo $row['nama']; ?></strong><br/>
                                        <?php echo $row['jabatan']; ?>
                                    </td>
                                    <td><?php echo $fmt->format(new \DateTime($row['tanggal'])); ?></td>
                                    <td><?php echo date('H:i',strtotime('2021-01-01 '.$row['dari'])) . ' s.d. ' . date('H:i',strtotime('2021-01-01 '.$row['sampai'])); ?> WITA</td>
                                    <td><?php echo $row['keperluan'];?></td>
                                    <td>
                                        <?php if($row['status'] == 'Dikonfirmasi'){?><label class="badge badge-success">Dikonfirmasi</label><?php } 
                                         else {?>
                                         <button class='konfirmasi' data-toggle='modal' data-edit='<?php echo json_encode($row); ?>'><i class="mdi mdi-edit"></i>Konfirmasi</utton>
                                         <?php } ?>
                                        </td>
                                    <td><?php echo $row['catatan_atasan']??' - ';?></td>
                                </tr>
                            <?php }?>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->


    <div id="modal-konfirmasi" class="modal modal-top fade calendar-modal">
        <div class="modal-dialog modal-md modal-dialog">
            <div class="modal-content">
                <form id="add-event" action="<?php echo base_url("Izin_keluar/konfimasiIzin/"); ?>" method="POST">
                    <div class='modal-header'>
                        <h4 class="text-blue h4 mb-10">Konfirmasi Izin Keluar</h4>
                    </div>
                    <div class="modal-body">
                        <input id='id' type="text" class="form-control" name='id' hidden>
                        <div style='margin-left:100px'>
                            <div class="form-group">
                                <label ><strong>Nama : </strong></label>
                                <label id='k_nama'></label>
                            </div>
                            <div class="form-group">
                                <label ><strong>Tanggal : </strong></label>
                                <label id='k_tanggal'></label>
                            </div>
                            <div class="form-group">
                                <label ><strong>Pada pukul : </strong></label>
                                <label id='k_pukul'>Pada pukul : </label>
                            </div>
                            <div class="form-group">
                                <label ><strong>Untuk keperluan : </strong></label>
                                <label id='k_keperluan' ></label>
                            </div>
                            <div class="form-group">
                                <label class='text-info'><strong>Catatan : </strong></label>
                            </div>
                            <textarea class="form-control rm-4" rows="" name='catatan_atasan' style='height:40px;width:250px'></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id='submitButton' type="submit" class="btn btn-success" >Konfirmasi</button>
                        <!-- <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button> -->
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

        $(".konfirmasi").on('click',function(){
            $('#modal-konfirmasi').modal('show');

            $('#datepicker-popupE').datepicker({
                enableOnReadonly: true,
                todayHighlight: true,
            });
            $("#datepicker-popupE").datepicker("setDate", "0");

            $('#id').val($(this).data('edit').id);
            $('#k_nama').html($(this).data('edit').nama);
            $('#k_tanggal').html($(this).data('edit').tanggal);
            $('#k_pukul').html($(this).data('edit').dari + " s.d. " + $(this).data('edit').sampai + " WITA");
            $('#k_keperluan').html($(this).data('edit').keperluan);
            // alert($(this).data('edit').keperluan);
        });


    </script>