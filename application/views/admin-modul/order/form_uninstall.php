<!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                  <div class="col-md-6">
                    <h3 class="animated fadeInLeft">Form Uninstallation</h3>
                        <p class="animated fadeInDown">
                            <a href="<?php echo base_url('dashboard'); ?>">CSIS</a> <span class="fa-angle-right fa"></span>
                            <a href="<?php echo base_url('order/order_list'); ?>">Installation</a> <span class="fa-angle-right fa"></span> Form Uninstallation
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
                        
                        <?php echo form_open('order/process_order_uninstall'); ?>
                        <?php echo validation_errors(); ?>

                            <div class="form-group">
                              <div class="col-md-2">
                                <dt>Vehicle</dt>
                              </div>
                              <div class="col-md-10">   
                                  <dd>:
                                    <?php
                                          $vehicles = pg_query("SELECT vehicles.veh_name
                                                            FROM order_details JOIN vehicles ON vehicles.veh_id=order_details.veh_id
                                                            WHERE odet_id ='$data->odet_id'");
                                          while ($row=pg_fetch_array($vehicles)) {
                                            echo "$row[0]";
                                          }
                                        ?>
                                  </dd>
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="col-md-2">
                                <dt>GPS Imei</dt>
                              </div>
                              <div class="col-md-10">   
                                  <dd>:
                                    <?php
                                      $imei = pg_query("SELECT gps.gps_imei_number
                                                        FROM order_details JOIN gps ON gps.gps_id=order_details.gps_id
                                                        WHERE odet_id ='$data->odet_id'");
                                      while ($row=pg_fetch_array($imei)) {
                                        echo "$row[0]";
                                      }
                                    ?>
                                  </dd>
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="col-md-2">
                                <dt>Gsm Number</dt>
                              </div>
                              <div class="col-md-10">   
                                  <dd>:
                                    <?php
                                      $number = pg_query("SELECT gsm.gsm_number
                                                        FROM order_details JOIN gsm ON gsm.gsm_id=order_details.gsm_id
                                                        WHERE odet_id ='$data->odet_id'");
                                      while ($row=pg_fetch_array($number)) {
                                        echo "$row[0]";
                                      }
                                    ?>
                                  </dd>
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="col-md-2">
                                <label for=""><b>Status Gps</b><font color="red"><b>*</b></font></label>
                              </div>
                              <div class="col-md-10" style="margin-bottom: 14px;">
                                <select class="form-control" name="gps_cond_id" required>
                                  <?php

                                      $tampil="SELECT gps.gps_cond_id
                                                        FROM order_details JOIN gps ON gps.gps_id=order_details.gps_id
                                                        WHERE odet_id ='$data->odet_id' ";
                                      $w=pg_fetch_array(pg_query($tampil));

                                  ?>
                                  
                                  <?php 
                                      
                                      if($w['gps_cond_id'] == 1)
                                      {
                                          echo "<option value='1' selected>Serviceable</option>";
                                      }
                                      else
                                      {
                                          echo "<option value='2' selected>Unserviceable</option>";
                                      }
                                            //echo $w['gsm_cond_id']; 
                                  ?>
                                    <option value="1">Serviceable</option>
                                    <option value="2">Unserviceable</option>

                                  </select>
                                </div>
                              </div>

                            <div class="form-group">
                              <div class="col-md-2">
                                <label for=""><b>Status Gsm</b><font color="red"><b>*</b></font></label>
                              </div>
                              <div class="col-md-10" style="margin-bottom: 14px;">
                                <select class="form-control" name="gsm_cond_id" required>
                                  <?php

                                      $tampil="SELECT gsm.gsm_cond_id
                                                        FROM order_details JOIN gsm ON gsm.gsm_id=order_details.gsm_id
                                                        WHERE odet_id ='$data->odet_id' ";
                                      $w=pg_fetch_array(pg_query($tampil));

                                  ?>
                                  
                                  <?php 
                                      
                                      if($w['gsm_cond_id'] == 2)
                                      {
                                          echo "<option value='2' selected>Active</option>";
                                      }
                                      else
                                      {
                                          echo "<option value='3' selected>Not Active</option>";
                                      }
                                            //echo $w['gsm_cond_id']; 
                                  ?>
                                  <option value="2">Active</option>
                                  <option value="3">Not Active</option>

                                </select>
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="col-md-2">
                                <label class=""><b>Date Uninstallation</b><font color="red"><b>*</b></font></label>
                              </div>
                              <div class="col-md-10" style="margin-bottom: 14px;">
                                    <input type="text" name="uninstall_date" value="" placeholder="17, August 1945"  class="form-control datepicker" required>
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="col-md-2">
                                <label><b>Uninstalled By</b><font color="red"><b>*</b></font></label>
                              </div>
                              <div class="col-md-10">
                                <input type="text" name="uninstall_by" class="form-control" value="<?php echo $_SESSION['name']; ?>">
                              </div>
                            </div>

                            <input type="hidden" name="odet_id" value="<?= $data->odet_id; ?>" class="form-control" id="" placeholder="">

                            <input type="hidden" name="gsm_id" value="<?= $data->gsm_id; ?>" class="form-control" id="" placeholder="">

                            <input type="hidden" name="gps_id" value="<?= $data->gps_id; ?>" class="form-control" id="" placeholder="">

                            <input type="hidden" name="veh_id" value="<?= $data->veh_id; ?>" class="form-control" id="" placeholder="">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit" class="btn btn-primary" >Uninstall</button>
                        <a href="<?= base_url('order/order_list');?>" class="btn btn-default" type="button">Cancel</a>
                    </div>
                <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- end: content -->