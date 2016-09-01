
<!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                  <div class="col-md-6">
                    <h3 class="animated fadeInLeft">Detail Uninstall</h3>
                        <p class="animated fadeInDown">
                            <a href="<?= base_url('dashboard');?>">CSIS</a> <span class="fa-angle-right fa"> </span>
                            <a href="<?php echo base_url('order/uninstall_list'); ?>">Uninstall</a> <span class="fa-angle-right fa"></span> Detail Uninstall
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
                          <h4>Read Uninstall</h4>
                        </div>
                        <div class="panel-body" style="padding-bottom:30px;">
                        <div class="container">
                        <dl class="dl-horizontal">
                          <dt>Type BAST/SPK</dt>
                          <dd>
                            <?php
                                  $typeNumber = pg_query("SELECT orders.*  FROM order_details JOIN orders ON order_details.order_id=orders.order_id  WHERE odet_id ='$data->odet_id'");
                                  while ($row=pg_fetch_array($typeNumber)) {
                                    echo "$row[order_type_number]";
                                  }
                                ?>
                          </dd>
                          <dt>Number BAST/SPK</dt>
                          <dd>
                            <?php
                                  $typeNumber = pg_query("SELECT orders.*  FROM order_details JOIN orders ON order_details.order_id=orders.order_id  WHERE odet_id ='$data->odet_id'");
                                  while ($row=pg_fetch_array($typeNumber)) {
                                    echo "$row[order_number]";
                                  }
                                ?>
                          </dd>
                          <dt>Customer Code</dt>
                          <dd>
                              <?php
                                  $customer = pg_query("SELECT orders.*, customer.*  FROM order_details JOIN orders ON order_details.order_id=orders.order_id JOIN customer ON orders.cust_id=customer.cust_id WHERE odet_id ='$data->odet_id'");
                                  while ($row=pg_fetch_array($customer)) {
                                    echo "$row[cust_code]";
                                  }
                                ?>
                          </dd>
                          <dt>Technicion</dt>
                          <dd><?php
                                  $employees = pg_query("SELECT orders.*, employees.emp_name FROM order_details JOIN orders ON order_details.order_id=orders.order_id JOIN employees ON orders.emp_id=employees.emp_id WHERE odet_id ='$data->odet_id'");
                                  while ($row=pg_fetch_array($employees)) {
                                    echo "$row[emp_name]";
                                  }
                                ?>
                          </dd>
                          <dt>Location Installation</dt>
                          <dd><?php
                                  $orders = pg_query("SELECT orders.order_location
                                                    FROM order_details JOIN orders ON orders.order_id=order_details.order_id
                                                    WHERE odet_id ='$data->odet_id'");
                                  while ($row=pg_fetch_array($orders)) {
                                    echo "$row[0]";
                                  }
                                ?>
                          </dd>
                          <dt>Vehicle</dt>
                          <dd>
                            <?php
                                  $vehicles = pg_query("SELECT vehicles.veh_name
                                                    FROM order_details JOIN vehicles ON vehicles.veh_id=order_details.veh_id
                                                    WHERE odet_id ='$data->odet_id'");
                                  while ($row=pg_fetch_array($vehicles)) {
                                    echo "$row[0]";
                                  }
                                ?>
                          </dd>
                          <dt>GPS IMEI Number</dt>
                          <dd>
                            <?php
                                  $imei = pg_query("SELECT gps.gps_imei_number
                                                    FROM order_details JOIN gps ON gps.gps_id=order_details.gps_id
                                                    WHERE odet_id ='$data->odet_id'");
                                  while ($row=pg_fetch_array($imei)) {
                                    echo "$row[0]";
                                  }
                                ?>
                          </dd>
                          <dt>GSM Number</dt>
                          <dd>
                            <?php
                                  $number = pg_query("SELECT gsm.gsm_number
                                                    FROM order_details JOIN gsm ON gsm.gsm_id=order_details.gsm_id
                                                    WHERE odet_id ='$data->odet_id'");
                                  while ($row=pg_fetch_array($number)) {
                                    echo "$row[0]";
                                  }
                                ?>
                          </dd>
                          <dt>Date Installation</dt>
                          <dd><?php echo $data->odet_work_date; ?></dd>
                          <!--<dt>Date Uninstall</dt>
                          <dd><?php echo $data->odet_uninstall_date; ?></dd>-->
                          <dt>Status Installation</dt>
                          <dd><?php echo $data->odet_status;?></dd>
                          <dt>Timestamp Insert</dt>
                          <dd><?php echo $data->odet_insert; ?></dd>
                          <dt>Timestamp Update</dt>
                          <dd><?php echo $data->odet_update; ?></dd>
                          <dt>Timestamp User</dt>
                          <dd><?php echo $data->odet_user; ?></dd>
                        </dl>
                      </div>
                      <div class="modal-footer">
                            <a href="<?= base_url('order/uninstall_list');?>" type="button" class="btn btn-default" >Back</a>
                      </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<!-- end: content -->
