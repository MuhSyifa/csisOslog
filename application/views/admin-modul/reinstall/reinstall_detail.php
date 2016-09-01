
<!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                  <div class="col-md-6">
                    <h3 class="animated fadeInLeft">Detail Reinstallation</h3>
                        <p class="animated fadeInDown">
                            <a href="<?= base_url('dashboard');?>">CSIS</a> <span class="fa-angle-right fa"> </span>
                            <a href="<?php echo base_url('reinstall/reinstall_list'); ?>">Reinstall</a> <span class="fa-angle-right fa"></span> Detail Reinstallation
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
                          <h4>Detail Installation</h4>
                        </div>
                        <div class="panel-body">
                        <div class="container">
                        <dl class="dl-horizontal">
                          <dt>Type BAST/SPK</dt>
                          <dd><?php echo $data->order_type_number; ?></dd>
                          <dt>Number BAST/SPK</dt>
                          <dd><?php echo $data->order_number; ?></dd>
                          <dt>Customer</dt>
                          <dd>
                              <?php
                                  /*$customer = pg_query("SELECT customer.*
                                                        FROM orders JOIN customer ON customer.cust_id=installs.cust_id 
                                                        WHERE ins_id ='$data->ins_id'");
                                  while ($row=pg_fetch_array($customer)) {
                                    echo "$row[cust_code]";
                                  }*/
                                  echo $data->cust_code;
                                ?>
                          </dd>
                          <dt>Technicion</dt>
                          <dd><?php
                                  /*$employees = pg_query("SELECT employees.*
                                                      FROM installs JOIN employees ON employees.emp_id=installs.emp_id 
                                                      WHERE ins_id ='$data->ins_id'");
                                  while ($row=pg_fetch_array($employees)) {
                                    echo "$row[emp_name]";
                                  }*/
                                  echo $data->emp_name;
                                ?>
                          </dd>
                          <dt>Location Installation</dt>
                          <dd><?php echo $data->order_location; ?></dd>
                          <dt>Vehicle</dt>
                          <dd>
                            <?php
                                  /*$vehicles = pg_query("SELECT vehicles.veh_name
                                                    FROM installs JOIN vehicles ON vehicles.veh_id=installs.veh_id
                                                    WHERE ins_id ='$data->ins_id'");
                                  while ($row=pg_fetch_array($vehicles)) {
                                    echo "$row[0]";
                                  }*/
                                  echo $data->veh_name;
                                ?>
                          </dd>
                          <dt>Vehicle Install Type</dt>
                          <dd>
                            <?php
                                  /*$vehicles = pg_query("SELECT vehicles.veh_install_type_business   
                                                    FROM installs JOIN vehicles ON vehicles.veh_id=installs.veh_id
                                                    WHERE ins_id ='$data->ins_id'");
                                  while ($row=pg_fetch_array($vehicles)) {
                                    echo "$row[0]";
                                  }*/

                                  //echo $data->veh_install_type_business;
                                  if($data->veh_install_type_business == 1)
                                  {
                                    echo "PO Installation";
                                  }
                                  else
                                  {
                                    echo "Trial Installation";
                                  }
                                ?>
                          </dd>
                          <dt>Vehicle Expiry Date</dt>
                          <dd>
                            <?php
                                  /*$vehicles = pg_query("SELECT vehicles.veh_install_type_business   
                                                    FROM installs JOIN vehicles ON vehicles.veh_id=installs.veh_id
                                                    WHERE ins_id ='$data->ins_id'");
                                  while ($row=pg_fetch_array($vehicles)) {
                                    echo "$row[0]";
                                  }*/

                                  echo $data->veh_expiry_date;
                                ?>
                          </dd>
                          <dt>GPS IMEI Number</dt>
                          <dd>
                            <?php
                                  /*$imei = pg_query("SELECT gps.gps_imei_number
                                                    FROM installs JOIN gps ON gps.gps_id=installs.gps_id
                                                    WHERE ins_id ='$data->ins_id'");
                                  while ($row=pg_fetch_array($imei)) {
                                    echo "$row[0]";
                                  }*/
                                  echo $data->gps_imei_number;
                                ?>
                          </dd>
                          <dt>GSM Number</dt>
                          <dd>
                            <?php
                                  /*$number = pg_query("SELECT gsm.gsm_number
                                                    FROM installs JOIN gsm ON gsm.gsm_id=installs.gsm_id
                                                    WHERE ins_id ='$data->ins_id'");
                                  while ($row=pg_fetch_array($number)) {
                                    echo "$row[0]";
                                  }*/
                                  echo $data->gsm_number;
                                ?>
                          </dd>
                          <dt>Date Installation</dt>
                          <dd><?php echo $data->order_date; ?></dd>
                          <dt>Timestamp Insert</dt>
                          <dd><?php echo $data->odet_insert; ?></dd>
                          <dt>Timestamp Update</dt>
                          <dd><?php echo $data->odet_update; ?></dd>
                          <dt>Timestamp User</dt>
                          <dd><?php echo $data->odet_user; ?></dd>
                        </dl>
                      </div>
                      <div class="modal-footer">
                            <a href="<?= base_url('reinstall/reinstall_list'); ?>" type="button" class="btn btn-default">Back</a>
                      </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<!-- end: content -->
