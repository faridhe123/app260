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
                        <button class="btn btn-primary btn-md text-white mb-0 me-0" type="button"><i class="mdi mdi-account-plus"></i>Add new member</button>
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
                        <tr>
                            <td><?php echo $fmt->format(new \DateTime()); ?></td>
                            <td><?php echo date('H:i') . ' s.d. ' . date('H:i'); ?></td>
                            <td>Periksa Dokter</td>
                            <td><label class="badge badge-success">Disetujui</label></td>
                        </tr>
                        <tr>
                            <td><?php echo $fmt->format(new \DateTime()); ?></td>
                            <td><?php echo date('H:i') . ' s.d. ' . date('H:i'); ?></td>
                            <td>Periksa Dokter</td>
                            <td><label class="badge badge-success">Disetujui</label></td>
                        </tr>
                        <tr>
                            <td><?php echo $fmt->format(new \DateTime()); ?></td>
                            <td><?php echo date('H:i') . ' s.d. ' . date('H:i'); ?></td>
                            <td>Periksa Dokter</td>
                            <td><label class="badge badge-success">Disetujui</label></td>
                        </tr>
                        <tr>
                            <td><?php echo $fmt->format(new \DateTime()); ?></td>
                            <td><?php echo date('H:i') . ' s.d. ' . date('H:i'); ?></td>
                            <td>Periksa Dokter</td>
                            <td><label class="badge badge-success">Disetujui</label></td>
                        </tr>
                        <tr>
                            <td><?php echo $fmt->format(new \DateTime()); ?></td>
                            <td><?php echo date('H:i') . ' s.d. ' . date('H:i'); ?></td>
                            <td>Periksa Dokter</td>
                            <td><label class="badge badge-success">Disetujui</label></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
      

    </script>