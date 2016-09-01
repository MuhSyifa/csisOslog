
<!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Detail Uninstall GPS</h3>
                        <p class="animated fadeInDown">
                            <a href="<?= base_url('');?>">CSIS</a> <span class="fa-angle-right fa"> </span>
                            <a href="<?php echo base_url('gps/gps_list'); ?>">GPS</a> <span class="fa-angle-right fa"></span> Detail Uninstall
                        </p>
                </div>
            </div>
        </div>
        <div class="form-element">
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel form-element-padding">
                        <div class="panel-heading">
                          <h4>Detail Uninstall</h4>
                        </div>
                        <div class="panel-body" style="padding-bottom:30px;">
                        <div class="container">
                        <dl class="dl-horizontal">
                          <dt>Purchase Order Date</dt>
                          <dd><?php echo $data->gps_purchase_order; ?></dd>
                          <dt>IMEI Number</dt>
                          <dd><?php echo $data->gps_imei_number; ?></dd>
                          <dt>Serial Number</dt>
                          <dd><?php echo $data->gps_sn; ?></dd>
                          <dt>Vendor</dt>
                          <dd><?php
                                  $vendor = pg_query("SELECT vendor.vendor_name
                                                      FROM gps JOIN vendor ON gps.vendor_id=vendor.vendor_id 
                                                               JOIN gps_type ON gps.gps_type_id=gps_type.gps_type_id 
                                                      WHERE gps_id ='$data->gps_id'");
                                  while ($row=pg_fetch_array($vendor)) {
                                    echo "$row[0]";
                                  }
                                ?>
                          </dd>
                          <dt>Type</dt>
                          <dd>
                            <?php
                                  $type = pg_query("SELECT gps_type.gps_type_name
                                                    FROM gps JOIN gps_type ON gps.gps_type_id=gps_type.gps_type_id
                                                    WHERE gps_id ='$data->gps_id'");
                                  while ($row=pg_fetch_array($type)) {
                                    echo "$row[0]";
                                  }
                                ?>
                          </dd>
                          <dt>Condition</dt>
                          <dd>
                            <?php
                                  $type = pg_query("SELECT gps_conditions.gps_cond_name
                                                    FROM gps JOIN gps_conditions ON gps.gps_cond_id=gps_conditions.gps_cond_id
                                                    WHERE gps_id ='$data->gps_id'");
                                  while ($row=pg_fetch_array($type)) {
                                    echo "$row[0]";
                                  }
                                ?>
                          </dd>
                          <dt>Gps Status</dt>
                          <dd>
                            <?php
                                  $type = pg_query("SELECT gps_statuses.gps_stat_name
                                                    FROM gps JOIN gps_statuses ON gps.gps_stat_id=gps_statuses.gps_stat_id
                                                    WHERE gps_id ='$data->gps_id'");
                                  while ($row=pg_fetch_array($type)) {
                                    echo "$row[0]";
                                  }
                                ?>
                          </dd>
                          <dt>Uninstall By</dt>
                          <dd><?php echo $data->gps_uninstall_by; ?></dd>
                          <dt>Uninstall Date</dt>
                          <dd><?php echo $data->gps_uninstall_date; ?></dd>
                          <dt>Status</dt>
                          <dd><?php echo $data->status; ?></dd>
                          <dt>Note</dt>
                          <dd><?php echo $data->gps_information; ?></dd>
                          <dt>Timestamp Insert</dt>
                          <dd><?php echo $data->gps_insert; ?></dd>
                          <dt>Timestamp Update</dt>
                          <dd><?php echo $data->gps_update; ?></dd>
                          <dt>Timestamp User</dt>
                          <dd><?php echo $data->gps_user; ?></dd>
                        </dl>
                      </div>
                      <div class="modal-footer">
                            <a href="<?= base_url('uninstall/uninstall_gps_list');?>" type="button" class="btn btn-default" >Back</a>
                      </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<!-- end: content -->
