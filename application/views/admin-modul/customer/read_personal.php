
<!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Read Install GPS Personal</h3>
                        <p class="animated fadeInDown">
                            <a href="<?= base_url('');?>">CSIS</a> <span class="fa-angle-right fa"> </span>
                            <a href="<?php echo base_url('install/installation'); ?>">Install</a> <span class="fa-angle-right fa"></span> Read Install
                        </p>
                </div>
            </div>
        </div>
        <div class="form-element">
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel form-element-padding">
                        <div class="panel-heading">
                          <h4>Read Install</h4>
                        </div>
                        <div class="panel-body" style="padding-bottom:30px;">
                        <div class="container">
                        <dl class="dl-horizontal">
                          <dt>Code Customer</dt>
                          <dd><?php echo $data->cust_code; ?></dd>

                          <?php
                            
                            $sql="select * from customer_personal_detail where cust_personal_detail_id = $data->cust_personal_detail_id";
                            $record=pg_fetch_array(pg_query($sql));
        
                          ?>

                          <dt>Full name Customer</dt>
                          <dd><?php echo $record['cust_full_name']; ?></dd>
                          <dt>Short name Customer</dt>
                          <dd><?php echo $record['cust_short_name']; ?></dd>
                          <dt>Gender Customer</dt>
                          <dd><?php echo $record['cust_gender']; ?></dd>
                          <dt>Email Customer</dt>
                          <dd><?php echo $record['cust_personal_email']; ?></dd>
                          <dt>Phone Customer</dt>
                          <dd><?php echo $record['cust_personal_phone']; ?></dd>
                          <dt>Mobile Phone Customer</dt>
                          <dd><?php echo $record['cust_personal_mobile_phone']; ?></dd>
                          <dt>Address Customer</dt>
                          <dd><?php echo $record['cust_personal_address']; ?></dd>
                          <dt>Start Contract Customer</dt>
                          <dd><?php echo $data->cust_start_date_contract; ?></dd>
                          <dt>End Contract Customer</dt>
                          <dd><?php echo $data->cust_end_date_contract; ?></dd>
                          <dt>Maintenance Contract Customer</dt>
                          <dd><?php echo $data->cust_maintenance_contract; ?></dd>
                          <dt>Religion Customer</dt>
                          <dd>
                              <?php
                                $pesan = pg_query("select * from customer_personal_detail where cust_personal_detail_id = $data->cust_type_id ");
                                $j = pg_fetch_array($pesan);
                                                      
                                $query_tahun = "SELECT * FROM customer_religion";
                                $tahun = pg_query($query_tahun);
                                while ($row_tahun = pg_fetch_array($tahun)){
                                  if($row_tahun[0] == $j[4]) {
                                    echo "$row_tahun[1]";
                                  }
                                }
                              ?>
                          </dd>
                          <dt>Timestamp Insert</dt>
                          <dd><?php echo $data->cust_insert; ?></dd>
                          <dt>Timestamp Update</dt>
                          <dd><?php echo $data->cust_update; ?></dd>
                          <dt>Timestamp By</dt>
                          <dd><?php echo $data->cust_user; ?></dd>
                        </dl>
                      </div>
                      <div class="modal-footer">
                            <a href="<?= base_url('customer/customer_list');?>" type="button" class="btn btn-default" >Back</a>
                      </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<!-- end: content -->
