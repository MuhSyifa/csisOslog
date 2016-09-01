<!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <h3 class="animated fadeInLeft">Form PO Installation</h3>
                        <p class="animated fadeInDown">
                            <a href="<?php echo base_url('dashboard'); ?>">CSIS</a> <span class="fa-angle-right fa"></span>
                            <a href="<?php echo base_url('order/order_list'); ?>">Installation</a> <span class="fa-angle-right fa"></span> Form PO Installation
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
                        <div class="panel-heading">
                          <h4> </h4>
                        </div>
                        <div class="panel-body" style="padding-bottom:30px;">
                        <!-- <form action="<?php echo base_url();?>gsm_type/edit" role="form" method="post" accept-charset="utf-8"> -->
                          
                        <?php echo form_open('order/process_order_install'); ?>
                        <?php echo validation_errors(); ?>

                            <div class="form-group">
                                <label class=""><b>Number BAST/SPK</b><font color="red"><b>*</b></font></label>
                                    <div class="radio">
                                        <label class="radio-inline">
                                          <input type="radio" name="order_type_number" value="BAST" <?php echo ($data->order_type_number=='BAST')?'checked':'' ?>> BAST
                                        <font color="red"><b>*</b></font></label>
                                        <label class="radio-inline">
                                          <input type="radio" name="order_type_number" value="SPK" <?php echo ($data->order_type_number=='SPK')?'checked':'' ?>> SPK
                                        <font color="red"><b>*</b></font></label>
                                    </div>
                                    <input type="text" name="order_number" value="<?php echo $data->order_number;?>" placeholder="Type here for number of BAST or SPK" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label class=""><b>Customer</b><font color="red"><b>*</b></font></label>
                                <select class="form-control" name="cust_id" required>
                                    <?php
                                          $a = pg_query("SELECT * FROM orders where order_id='$data->odet_id' ");
                                          $b = pg_fetch_array($a);
                                                    
                                          $c = "SELECT * FROM customer ";
                                          $d = pg_query($c);
                                          while ($row_d = pg_fetch_array($d)){
                                            if($row_d[cust_id] == $b[cust_id]) {
                                            echo "<option value=$row_d[cust_id] selected>$row_d[cust_code]</option>";
                                            }else {
                                                echo "<option value=$row_d[cust_id]>$row_d[cust_code]</option>";
                                                }
                                            }
                                    ?>
                              </select>
                            </div>
                            
                            <div class="form-group">
                                <label class=""><b>PIC Technicion</b><font color="red"><b>*</b></font></label>
                                <select class="form-control" name="emp_id" required>
                                    <?php
                                          $a = pg_query("SELECT * FROM orders where order_id='$data->odet_id' ");
                                          $b = pg_fetch_array($a);
                                                    
                                          $c = "SELECT * FROM employees WHERE emp_department = '1'";
                                          $d = pg_query($c);
                                          while ($row_d = pg_fetch_array($d)){
                                            if($row_d[emp_id] == $b[emp_id]) {
                                            echo "<option value=$row_d[emp_id] selected>$row_d[emp_name]</option>";
                                            }else {
                                                echo "<option value=$row_d[emp_id]>$row_d[emp_name]</option>";
                                                }
                                            }
                                    ?>
                              </select>
                            </div>

                            <div class="form-group">
                                <label class=""><b>Date Installation</b><font color="red"><b>*</b></font></label>
                                    <input type="text" name="order_date" value="" placeholder="17, August 1945"  class="form-control datepicker" id="datepicker" required>
                            </div>

                            <div class="form-group">
                                <label class=""><b>Location</b><font color="red"><b>*</b></font></label>
                                    <input type="text" name="order_location" value="" placeholder="Location installation"  class="form-control" required>
                            </div>

                            <div class="form-group">
                            <label class=""><b>Vehicle Name</b></label>
                                <input type="text" name="order_veh_name" placeholder="Vehicle Name"  class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label class=""><b>Vehicle Number Police</b></label>
                                    <input type="text" name="order_veh_num_police" placeholder="Vehicle Number Police"  class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label class=""><b>Vehicle Number Lambung</b></label>
                                    <input type="text" name="order_veh_num_flank" placeholder="Vehicle Number"  class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for=""><b>Vehicle Remarks</b></label>
                                    <textarea name="order_veh_remarks" placeholder="Remarks"class="form-control" required></textarea>
                            </div>
                                
                            <div class="form-group">
                                <label for=""><b>GPS Imei</b></label>
                                    <select class="form-control" name="gps_id">
                                        <?php
                                          echo '<option value="" selected="selected" disabled="" required>--- Choose GPS ---</option>';
                                            $showgps=pg_query("SELECT * FROM gps Where status = 'Received' and gps_cond_id = '1' Order By gps_imei_number Desc");
                                            while ($sg=pg_fetch_array($showgps)) {
                                              echo "<option value=$sg[gps_id]>$sg[gps_imei_number]</option>";
                                            }
                                        ?>
                                    </select>
                            </div>

                            <div class="form-group">
                                <label for=""><b>Gsm</b></label>
                                    <select class="form-control" name="gsm_id">
                                        <?php
                                            echo '<option value="" selected="selected" disabled="" required>--- Choose Number ---</option>';
                                                $showgsm=pg_query("SELECT * FROM gsm WHERE status = 'Activated' and gsm_cond_id = '2' ");
                                                while ($sgsm=pg_fetch_array($showgsm)) {
                                                    echo "<option value=$sgsm[gsm_id]>$sgsm[gsm_number]</option>";
                                                }
                                        ?>
                                    </select>
                            </div>

                            <!--<input type="hidden" name="ins_id" value="<?= $data->odet_id; ?>" class="form-control" id="" placeholder="">-->
                </div>
                    <div class="modal-footer">
                        <button type="submit" name="save" class="btn btn-primary">Save</button>
                        <a href="<?= base_url('order/order_list');?>" class="btn btn-default" type="button">Cancel</a>
                    </div>
                <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- end: content -->