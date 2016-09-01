
<!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Detail Uninstall GSM</h3>
                        <p class="animated fadeInDown">
                            <a href="<?= base_url('');?>">CSIS</a> <span class="fa-angle-right fa"> </span>
                            <a href="<?php echo base_url('gsm/gsm_list'); ?>">GSM</a> <span class="fa-angle-right fa"></span> Detail Uninstall
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
                          <dt>GSM Number</dt>
                          <dd><?php echo $data->gsm_number; ?></dd>
                          <dt>GSM IMSI Number</dt>
                          <dd><?php echo $data->gsm_imsi_number; ?></dd>
                          <dt>GSM ICCID Number</dt>
                          <dd><?php echo $data->gsm_iccid_number; ?></dd>
                          <dt>Vendor</dt>
                          <dd><?php
                                  $vendor = pg_query("SELECT vendor.vendor_name
                                                      FROM gsm JOIN vendor ON gsm.vendor_id=vendor.vendor_id 
                                                      WHERE gsm_id ='$data->gsm_id'");
                                  while ($row=pg_fetch_array($vendor)) {
                                    echo "$row[0]";
                                  }
                                ?>
                          </dd>
                          <dt>Uninstall By</dt>
                          <dd><?php echo $data->gsm_uninstall_by; ?></dd>
                          <dt>Uninstall Date</dt>
                          <dd><?php echo $data->gsm_uninstall_date; ?></dd>
                          <dt>Timestamp Insert</dt>
                          <dd><?php echo $data->gsm_insert; ?></dd>
                          <dt>Timestamp Update</dt>
                          <dd><?php echo $data->gsm_update; ?></dd>
                          <dt>Timestamp User</dt>
                          <dd><?php echo $data->gsm_user; ?></dd>
                          <dt>Status</dt>
                          <dd><?php echo $data->status; ?></dd>
                        </dl>
                      </div>
                      <div class="modal-footer">
                            <a href="<?= base_url('uninstall/uninstall_gsm_list');?>" type="button" class="btn btn-default" >Back</a>
                      </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<!-- end: content -->
