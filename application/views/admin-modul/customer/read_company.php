
<!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">Read Install GPS Company</h3>
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
                          <dd><?php echo $datas->cust_code; ?></dd>

                          <?php
                            
                            $sql="select * from customer_company_detail where cust_company_detail_id = $datas->cust_company_detail_id";
                            $record=pg_fetch_array(pg_query($sql));
        
                          ?>

                          <dt>Name Company</dt>
                          <dd><?php echo $record['cust_company_name']; ?></dd>
                          <dt>Business Type</dt>
                          <dd><?php echo $record['cust_business_type']; ?></dd>
                          <dt>Address Company 1</dt>
                          <dd><?php echo $record['cust_company_address']; ?></dd>
                          <dt>Address Company 2</dt>
                          <dd><?php echo $record['cust_company_address2']; ?></dd>
                          <dt>Address Company 3</dt>
                          <dd><?php echo $record['cust_company_address3']; ?></dd>
                          <dt>Zip Code</dt>
                          <dd><?php echo $record['cust_company_codepos']; ?></dd>
                          <dt>City</dt>
                          <dd><?php echo $record['cust_company_city']; ?></dd>
                          <dt>Phone Customer</dt>
                          <dd><?php echo $record['cust_company_phone']; ?></dd>
                          <dt>Email Customer</dt>
                          <dd><?php echo $record['cust_company_email']; ?></dd>
                          <dt>Start Contract Customer</dt>
                          <dd><?php echo $datas->cust_start_date_contract; ?></dd>
                          <dt>End Contract Customer</dt>
                          <dd><?php echo $datas->cust_end_date_contract; ?></dd>
                          <dt>Maintenance Contract Customer</dt>
                          <dd><?php echo $datas->cust_maintenance_contract; ?></dd>
                          <dt>Timestamp Insert</dt>
                          <dd><?php echo $datas->cust_insert; ?></dd>
                          <dt>Timestamp Update</dt>
                          <dd><?php echo $datas->cust_update; ?></dd>
                          <dt>Timestamp By</dt>
                          <dd><?php echo $datas->cust_user; ?></dd>
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
