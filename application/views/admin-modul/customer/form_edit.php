<!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                  <div class="col-md-6">
                    <h3 class="animated fadeInLeft">Form Edit Customer Personal</h3>
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
                         
                        <?php echo form_open('customer/process_update_personal'); ?>
                        <?php echo validation_errors(); ?>

                          <div class="form-group">
                            <label class="">Customer Code</label>
                            <input name="cust_code"  value="<?= $data->cust_code; ?>" placeholder="Code" class="form-control" type="text" required>
                          </div>

                          <?php
                            
                            $sql="select * from customer_personal_detail where cust_personal_detail_id = $data->cust_personal_detail_id";
                            $record=pg_fetch_array(pg_query($sql));
        
                          ?>
                          
                          <div class="form-group">
                            <label class="">Customer Full Name</label>
                                <input name="cust_full_name" value="<?php echo $record['cust_full_name']; ?>" placeholder="Full Name" class="form-control" type="text" required>
                          </div>

                          <div class="form-group">
                              <label class="">Customer Short Name</label>
                                  <input name="cust_short_name" value="<?php echo $record['cust_short_name']; ?>" placeholder="Short Name" class="form-control" type="text" required>
                          </div>

                          <div class="form-group">
                              <label class=""><b>Gender</b></label>
                                  <div class="radio">
                                      <label class="radio-inline">
                                          <input type="radio" name="cust_gender" value="Laki-laki" <?php if($record['cust_gender']=="Laki-laki"){ echo "checked";}?>/> Laki-laki
                                      </label>
                                      <label class="radio-inline">
                                          <input type="radio" name="cust_gender" value="Perempuan" <?php if($record['cust_gender']=="Perempuan"){ echo "checked";}?>/> Perempuan
                                      </label>

                                      
                                  </div>
                          </div>

                          <div class="form-group"> 
                              <label class="">Religion</label>
                                <select class="form-control" name="cust_religion_id" required>
                                  <?php
                                            $pesan = pg_query("select * from customer_personal_detail where cust_personal_detail_id = $data->cust_type_id ");
                                            $j = pg_fetch_array($pesan);
                                                      
                                            $query_tahun = "SELECT * FROM customer_religion";
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
                              <label class="">Email Address</label>
                                  <input name="cust_personal_email" value="<?php echo $record['cust_personal_email']; ?>" placeholder="Email Address" class="form-control" type="text" required>
                          </div>

                          <div class="form-group">
                              <label class="">Phone</label>
                                  <input name="cust_personal_phone" value="<?php echo $record['cust_personal_phone']; ?>" placeholder="Phone" class="form-control" type="text" required>
                          </div>

                          <div class="form-group">
                              <label class="">Mobile Phone</label>
                                  <input name="cust_personal_mobile_phone" value="<?php echo $record['cust_personal_mobile_phone']; ?>" placeholder="Mobile Phone" class="form-control" type="text" required>
                          </div>

                          <div class="form-group">
                              <label for="">Address</label>
                                  <textarea name="cust_personal_address" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control" required><?php echo $record['cust_personal_address']; ?></textarea>
                          </div>

                          <div class="form-group">
                          <label class="">Start Date Contract</label>
                              <input name="cust_start_date_contract" value="<?php echo $data->cust_start_date_contract; ?>" placeholder="Start Contract" class="form-control datepicker" type="text">
                          </div>

                          <div class="form-group">
                              <label class="">End Date Contract</label>
                                  <input name="cust_end_date_contract" value="<?php echo $data->cust_end_date_contract; ?>" placeholder="End Contract" class="form-control datepicker" type="text">
                          </div>

                          <div class="form-group">
                              <label class="">Maintenance Contract</label>
                                  <input name="cust_maintenance_contract" value="<?php echo $data->cust_maintenance_contract; ?>" placeholder="Maintenan Contract" class="form-control" type="text">
                          </div>

                          <div class="form-controll">
                            <input type="hidden" name="cust_id" value="<?= $data->cust_id; ?>" class="form-control" id="" placeholder="">
                          </div>

                          <div class="form-controll">
                            <input type="hidden" name="cust_personal_detail_id" value="<?= $data->cust_personal_detail_id; ?>" class="form-control" id="" placeholder="">
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