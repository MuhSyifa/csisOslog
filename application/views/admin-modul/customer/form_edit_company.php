<!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                  <div class="col-md-6">
                    <h3 class="animated fadeInLeft">Form Edit Customer Company</h3>
                      <p class="animated fadeInDown">
                        <a href="<?php echo base_url('dashboard'); ?>">CSIS</a> <span class="fa-angle-right fa"></span> <a href="<?php echo base_url('customer/customer_list'); ?>">Customer</a> <span class="fa-angle-right fa"></span> Form Edit Customer
                      </p>
                  </div>
                  <div class="col-md-6">
                    <ul style="float:right;">
                      <li class="time">
                        <h1 class="animated fadeInLeft" align="center" style="font-size: 25px;">21:00</h1>
                        <p class="animated fadeInRight">Sat,October 1st 2029</p>
                      </li>
                    </ul>
                  </div>
                </div>
            </div>
        </div>
        <div class="form-element">
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel form-element-padding">
                        <div class="panel-body" style="padding-bottom:30px;">
                        
                        <?php echo form_open('customer/process_update_company'); ?>
                        <?php echo validation_errors(); ?>

                          <div class="form-group">
                            <label class="">Customer Code</label>
                            <input name="cust_code"  value="<?= $datas->cust_code; ?>" placeholder="Code" class="form-control" type="text" required>
                          </div>

                          <?php
                            
                            $sql="select * from customer_company_detail where cust_company_detail_id = $datas->cust_company_detail_id";
                            $record=pg_fetch_array(pg_query($sql));
        
                          ?>

                          <div class="form-group">
                            <label class="">Customer Company Name</label>
                                <input name="cust_company_name" value="<?php echo $record['cust_company_name']; ?>" placeholder="Full Name" class="form-control" type="text" required>
                          </div>

                          <div class="form-group">
                              <label class="">Customer Business Type</label>
                                  <input name="cust_business_type" value="<?php echo $record['cust_business_type']; ?>" placeholder="Short Name" class="form-control" type="text" required>
                          </div>

                          <div class="form-group"><label class="col-sm-2 control-label text-right">Customer Business Type</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="cust_business_type" style="width:31%">
                                        <?php
                                            $pesan = pg_query("SELECT * FROM customer_company_detail WHERE cust_business_type = $record->cust_business_type ");
                                            $j     = pg_fetch_array($pesan);
                                            
                                            $query_tahun = "SELECT * FROM customer_business_type ";
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
                          </div>

                          <div class="form-group">
                              <label for="">Address 1</label>
                                  <textarea name="cust_company_address" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control" required><?php echo $record['cust_company_address']; ?></textarea>
                          </div>

                          <div class="form-group">
                              <label for="">Address 2</label>
                                  <textarea name="cust_company_address2" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control" required><?php echo $record['cust_company_address2']; ?></textarea>
                          </div>

                          <div class="form-group">
                              <label for="">Address 3</label>
                                  <textarea name="cust_company_address3" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control" required><?php echo $record['cust_company_address3']; ?></textarea>
                          </div>

                          <div class="form-group">
                              <label class="">Zip Code</label>
                                  <input name="cust_company_codepos" value="<?php echo $record['cust_company_codepos']; ?>" placeholder="Zip Code" class="form-control" type="text" required>
                          </div>

                          <div class="form-group">
                              <label class="">City</label>
                                  <input name="cust_company_city" value="<?php echo $record['cust_company_city']; ?>" placeholder="City" class="form-control" type="text" required>
                          </div>

                          <div class="form-group">
                              <label class="">Company Phone</label>
                                  <input name="cust_company_phone" value="<?php echo $record['cust_company_phone']; ?>" placeholder="Mobile Phone" class="form-control" type="text" required>
                          </div>

                          <div class="form-group">
                              <label class="">Company Email</label>
                                  <input name="cust_company_email" value="<?php echo $record['cust_company_email']; ?>" placeholder="Mobile Phone" class="form-control" type="text" required>
                          </div>

                          <div class="form-group">
                          <label class="">Start Date Contract</label>
                              <input name="cust_start_date_contract" value="<?php echo $datas->cust_start_date_contract; ?>" placeholder="Start Contract" class="form-control datepicker" type="text">
                          </div>

                          <div class="form-group">
                              <label class="">End Date Contract</label>
                                  <input name="cust_end_date_contract" value="<?php echo $datas->cust_end_date_contract; ?>" placeholder="End Contract" class="form-control datepicker" type="text">
                          </div>

                          <div class="form-group">
                              <label class="">Maintenance Contract</label>
                                  <input name="cust_maintenance_contract" value="<?php echo $datas->cust_maintenance_contract; ?>" placeholder="Maintenan Contract" class="form-control" type="text">
                          </div>

                          <div class="form-controll">
                            <input type="hidden" name="cust_id" value="<?= $datas->cust_id; ?>" class="form-control" id="" placeholder="">
                          </div>

                          <div class="form-controll">
                            <input type="hidden" name="cust_company_detail_id" value="<?= $datas->cust_company_detail_id; ?>" class="form-control" id="" placeholder="">
                          </div>

                          <div class="form-group" style="float:right;">
                                <input type="submit" name="submit" class="btn btn-primary" value="Update"/>
                                <a href="<?php echo base_url('customer/customer_list'); ?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                </a>
                          </div>
                        <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- end: content -->