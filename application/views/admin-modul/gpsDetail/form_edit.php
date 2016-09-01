<!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Form Edit Gps Condition</h3>
                        <p class="animated fadeInDown">
                          	<a href="<?php echo base_url('gpsType/gps_type_list'); ?>">Gps Condition</a> <span class="fa-angle-right fa"></span> Edit Gps Condition
                        </p>
                </div>
            </div>
        </div>
        <div class="form-element">
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel form-element-padding">
                        <div class="panel-heading">
                         	<h4>Edit GPS </h4>
                        </div>
                        <div class="panel-body" style="padding-bottom:30px;">
                    <form role="form" action="<?php echo base_url('gpsDetail/process_update'); ?>" method="POST">
                    <?php echo validation_errors(); ?>

                        <div class="form-group">
                            <label for="">Type</label>
                                <select class="form-control" name="gps_type_id" required="">
                                    <?php
                                          $pesan = pg_query("SELECT * FROM gps_details where gps_det_id='$data->gps_det_id' ");
                                          $j = pg_fetch_array($pesan);
                                                    
                                          $query_tahun = "SELECT gps_type_id, gps_type_name FROM gps_type ";
                                          $tahun = pg_query($query_tahun);
                                          while ($row_tahun = pg_fetch_array($tahun)){
                                            if($row_tahun[0] == $j[4]) {
                                            echo "<option value=$row_tahun[0] selected>$row_tahun[1]</option>";
                                            }else {
                                            echo "<option value=$row_tahun[0]>$row_tahun[1]</option>";
                                            }
                                            }
                                        ?>
                                </select>
                        </div>

                        <div class="form-group">
                            <label for="gps_id">IMEI Number</label>
                                <select class="form-control" name="gps_id" required>
                                    <?php
                                          $pesan = pg_query("SELECT * FROM gps_details where gps_det_id='$data->gps_det_id' ");
                                          $j = pg_fetch_array($pesan);
                                                    
                                          $query_tahun = "SELECT gps_id, gps_imei_number FROM gps Where status='Received' ";
                                          $tahun = pg_query($query_tahun);
                                          while ($row_tahun = pg_fetch_array($tahun)){
                                            if($row_tahun[0] == $j[4]) {
                                            echo "<option value=$row_tahun[0] selected>$row_tahun[1]</option>";
                                            }else {
                                            echo "<option value=$row_tahun[0]>$row_tahun[1]</option>";
                                            }
                                            }
                                        ?>
                                </select>
                        </div>

                        <div class="form-group">
                            <label for="">Condition</label>
                                <select class="form-control" name="gps_cond_id" required>
                                    <?php
                                          $pesan = pg_query("SELECT * FROM gps_details where gps_det_id='$data->gps_det_id' ");
                                          $j = pg_fetch_array($pesan);
                                                    
                                          $query_tahun = "SELECT gps_cond_id, gps_cond_name FROM gps_conditions ";
                                          $tahun = pg_query($query_tahun);
                                          while ($row_tahun = pg_fetch_array($tahun)){
                                            if($row_tahun[0] == $j[4]) {
                                            echo "<option value=$row_tahun[0] selected>$row_tahun[1]</option>";
                                            }else {
                                            echo "<option value=$row_tahun[0]>$row_tahun[1]</option>";
                                            }
                                            }
                                        ?>
                                </select>
                        </div>

                        <div class="form-group">
                          <label for="">Status</label>
                                <select class="form-control" name="gps_stat_id" required>
                                <?php
                                          $pesan = pg_query("SELECT * FROM gps_details where gps_det_id='$data->gps_det_id' ");
                                          $j = pg_fetch_array($pesan);
                                                    
                                          $query_tahun = "SELECT gps_stat_id, gps_stat_name FROM gps_statuses ";
                                          $tahun = pg_query($query_tahun);
                                          while ($row_tahun = pg_fetch_array($tahun)){
                                            if($row_tahun[0] == $j[4]) {
                                            echo "<option value=$row_tahun[0] selected>$row_tahun[1]</option>";
                                            }else {
                                            echo "<option value=$row_tahun[0]>$row_tahun[1]</option>";
                                            }
                                            }
                                        ?>
                                </select>
                        </div>

                          <div class="form-group">
                            <label>Quantity</label>
                              <input type="number" name="gps_det_qty" value="<?php echo $data->gps_det_qty;?>" class="form-control" placeholder="" required>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary" >Save</button>
                          </div>
                    </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- end: content -->