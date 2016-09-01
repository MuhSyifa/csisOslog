
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <h3 class="animated fadeInLeft">Data Reinstallation</h3>
                        <p class="animated fadeInDown">
                            <a href="<?= base_url('dashboard');?>">CSIS</a> <span class="fa-angle-right fa"></span>
                            Data Reinstallation
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
    <?php echo $this->session->flashdata('info'); ?>
    <div class="col-md-12 top-20 padding-0">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                
                <button class="btn btn-primary btn-xs" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                      <span data-toggle="tooltip" data-placement="right" title="Collapse for Action">Show</span>
                    </button>
                    <div class="collapse" id="collapseExample">
                        <div class="well">
                            <!-- Button trigger modal -->
                            <!--<button type="button" class="btn  btn-sm btn-raised btn-primary" data-toggle="modal" data-target="#myModal">
                              <i class="fa fa-plus"> Add </i>
                            </button>-->
                            <button type="button" onclick="add()" class="btn  btn-sm btn-raised btn-primary" data-toggle="modal">
                                <i class="fa fa-plus"> Add</i>
                            </button>
                            <!--<button type="button" class="btn  btn-sm btn-raised btn-primary" data-toggle="modal" data-target="#stepModal">
                              <i class="fa fa-plus"> Launch </i>
                            </button>-->
                            
                        </div>
                    </div>
                </div>
                    <div class="panel-body">
                    <div class="responsive-table">
                        <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th style="width: 10px;" align="center" >No.</th>
                            <th>No. BAST/SPK</th>
                            <th>Vehicle</th>
                            <th>GPS IMEI</th>
                            <th>GSM Number</th>
                            <th>Technicion</th>
                            <th>Date Install</th>
                            <th>Customer</th>
                            <th><center>Action</center></th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                            $no = 1;
                            foreach ($reinstall as $v):
                        ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $v->order_number; ?></td>
                                <td><?= $v->veh_number_police;?></td>
                                <td><?= $v->gps_imei_number;?></td>
                                <td><?= $v->gsm_number;?></td>
                                <td><?= $v->emp_name;?></td>
                                <td><?= $v->order_date; ?></td>
                                <td><?= $v->cust_code;?></td>
                                <td>
                                    <center>
                                        <a href="javascript:void(0)" onclick="add_reinstall('<?php echo $v->odet_id; ?>','<?php echo $v->veh_install_type_business; ?>')" class="btn btn-xs btn-info"data-toggle="tooltip" data-placement="right" title="Add"><span ><i class="fa fa-plus"></i></span> </a>
                                        
                                        <a href="javascript:void(0)" onclick="detail_order('<?php echo $v->odet_id; ?>')" class="btn btn-xs btn-default"data-toggle="tooltip" data-placement="right" title="Detail"><span ><i class="glyphicon glyphicon-list-alt"></i></span> </a>

                                        <a href="javascript:void(0)" onclick="uninstall_reinstall('<?php echo $v->odet_id; ?>')" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="left" title="Uninstall"><span ><i class="fa fa-gear"></i></span> </a>
                                    </center>
                                </td>
                            </tr>
                        <?php
                            $no++; 
                            endforeach;
                        ?>
                        </tbody>
                        </table>
                    </div>
                    </div>
            </div>
        </div>  
    </div>
    </div>

    <!---########################################################### Modal Jquery Add Order ################################################################## -->
    <div class="modal fade" id="modal_add" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#po" data-toggle="tab">PO Reinstallation</a></li> 
                    <li><a href="#trial" data-toggle="tab">Trial Reinstallation</a></li>
                </ul>
                
                <div class="tab-content">
                <div class="tab-pane active" id="po">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title"></h3>
                    </div>

                    <form id="form" method="post" action="<?php echo base_url('reinstall/process_order_install'); ?>" class="form-horizontal">
                    <div class="modal-body">
                        
                        <div class="form-body">
                            
                            <div class="form-group">
                                <label class="control-label col-md-3">Number Type <b>*</b></label>
                                    <div class="col-md-9">
                                        <div class="radio">
                                            <label class="radio-inline">
                                                <input type="radio" checked="" name="order_type_number" id="bs1" value="BAST" required> BAST
                                                <span class="help-block"></span>
                                            </label>
                                            
                                            <label class="radio-inline">
                                                  <input type="radio" name="order_type_number" id="ba2" value="SPK" required> SPK
                                                <span class="help-block"></span>
                                            </label>
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Number BAST/SPK <b>*</b></label>
                                <div class="col-md-9">
                                    <input type="text" name="order_number" placeholder="Type here for number of BAST or SPK" class="form-control" required>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Customer <b>*</b></label>
                                <div class="col-md-9">
                                    <select class="form-control" name="cust_id" required>
                                        <?php
                                          echo '<option value="" selected="selected" disabled="" required>--- Choose Customers ---</option>';
                                            $showcust=pg_query("SELECT * FROM customer Order By cust_code asc");
                                            while ($cust=pg_fetch_array($showcust)) {
                                              echo "<option value=$cust[cust_id]>$cust[cust_code]</option>";
                                            }
                                        ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        
                            
                            <div class="form-group">
                                <label class="control-label col-md-3">PIC Technicion <b>*</b></label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="emp_id" required>
                                            <?php
                                                echo '<option value="" selected="selected" disabled="" required>--- Choose Technicion ---</option>';
                                                $showemp=pg_query("SELECT * FROM employee WHERE pos_id = '1' Order By emp_name asc");
                                                while ($emp=pg_fetch_array($showemp)) {
                                                echo "<option value=$emp[emp_id]>$emp[emp_name]</option>";
                                                }
                                            ?>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Date Installation <b>*</b></label>
                                    <div class="col-md-9">
                                        <input type="text" name="order_date" placeholder="17, August 1945"  class="form-control datepicker" required>
                                        <span class="help-block"></span>
                                    </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Location <b>*</b></label>
                                    <div class="col-md-9">
                                        <input type="text" name="order_location" placeholder="Location installation"  class="form-control" required>
                                        <span class="help-block"></span>
                                    </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Vehicle <b>*</b></label>
                                <div class="col-md-9">
                                    <select class="form-control" name="veh_id">
                                        <?php
                                          echo '<option value="" selected="selected" disabled="" required>--- Choose Vehicle ---</option>';
                                            $showgps=pg_query("SELECT * FROM vehicles Where veh_status = 'Uninstalled' order by veh_number_police asc");
                                            while ($sg=pg_fetch_array($showgps)) {
                                              echo "<option value=$sg[veh_id]>$sg[veh_number_police]".' ('."$sg[veh_status]".') '."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">GPS Imei <b>*</b></label>
                                <div class="col-md-9">
                                    <select class="form-control" name="gps_id">
                                        <?php
                                          echo '<option value="" selected="selected" disabled="" required>--- Choose GPS ---</option>';
                                            $showgps=pg_query("SELECT * FROM gps Where status = 'Received' or status = 'Uninstalled' and gps_cond_id = '1' Order By gps_imei_number asc"); 
                                            while ($sg=pg_fetch_array($showgps)) {
                                              echo "<option value=$sg[gps_id]>$sg[gps_imei_number]".' ('."$sg[status]".') '."</option>";
                                            }
                                        ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Gsm <b>*</b></label>
                                <div class="col-md-9">
                                    <select class="form-control" name="gsm_id">
                                        <?php
                                            echo '<option value="" selected="selected" disabled="" required>--- Choose GSM ---</option>';
                                                $showgsm=pg_query("SELECT * FROM gsm WHERE status = 'Activated' or status = 'Uninstalled' and gsm_cond_id = '2' order by gsm_number asc");
                                                while ($sgsm=pg_fetch_array($showgsm)) {
                                                    echo "<option value=$sgsm[gsm_id]>$sgsm[gsm_number]".' ('."$sgsm[status]".') '."</option>";
                                                }
                                        ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" id="btnSave" name="save" class="btn btn-primary" >Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>

                    </form>
                
                </div>
                
                <div class="tab-pane" id="trial">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title-trial"></h3>
                    </div>

                    <form id="form" method="post" action="<?php echo base_url('order/process_order_install_trial'); ?>" class="form-horizontal">
                    <div class="modal-body">
                        
                        <div class="form-body">
                            
                            <div class="form-group">
                                <label class="control-label col-md-3">Number Type <b>*</b></label>
                                    <div class="col-md-9">
                                        <div class="radio">
                                            <label class="radio-inline">
                                                <input type="radio" checked="" name="order_type_number" id="bs1" value="BAST" required> BAST
                                                <span class="help-block"></span>
                                            </label>
                                            
                                            <label class="radio-inline">
                                                  <input type="radio" name="order_type_number" id="ba2" value="SPK" required> SPK
                                                <span class="help-block"></span>
                                            </label>
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Number BAST/SPK <b>*</b></label>
                                <div class="col-md-9">
                                    <input type="text" name="order_number" placeholder="Type here for number of BAST or SPK" class="form-control" required>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Customer <b>*</b></label>
                                <div class="col-md-9">
                                    <select class="form-control" name="cust_id" required>
                                        <?php
                                          echo '<option value="" selected="selected" disabled="" required>--- Choose Customers ---</option>';
                                            $showcust=pg_query("SELECT * FROM customer Order By cust_code asc");
                                            while ($cust=pg_fetch_array($showcust)) {
                                              echo "<option value=$cust[cust_id]>$cust[cust_code]</option>";
                                            }
                                        ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        
                            
                            <div class="form-group">
                                <label class="control-label col-md-3">PIC Technicion <b>*</b></label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="emp_id" required>
                                            <?php
                                                echo '<option value="" selected="selected" disabled="" required>--- Choose Technicion ---</option>';
                                                $showemp=pg_query("SELECT * FROM employee WHERE pos_id = '1' Order By emp_name asc");
                                                while ($emp=pg_fetch_array($showemp)) {
                                                echo "<option value=$emp[emp_id]>$emp[emp_name]</option>";
                                                }
                                            ?>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Date Installation <b>*</b></label>
                                    <div class="col-md-9">
                                        <input type="text" name="order_date" placeholder="17, August 1945"  class="form-control datepicker" required>
                                        <span class="help-block"></span>
                                    </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Location <b>*</b></label>
                                    <div class="col-md-9">
                                        <input type="text" name="order_location" placeholder="Location installation"  class="form-control" required>
                                        <span class="help-block"></span>
                                    </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Vehicle Expiry Date <b>*</b></label>
                                <div class="col-md-9">
                                    <input type="text" name="order_veh_expiry_date" placeholder="17, August 1945"  class="form-control datepicker" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Vehicle<b>*</b></label>
                                <div class="col-md-9">
                                    <select class="form-control" name="veh_id">
                                        <?php
                                          echo '<option value="" selected="selected" disabled="" required>--- Choose Vehicle ---</option>';
                                            $showgps=pg_query("SELECT * FROM vehicles Where veh_status = 'Uninstalled' order by veh_number_police asc");
                                            while ($sg=pg_fetch_array($showgps)) {
                                              echo "<option value=$sg[veh_id]>$sg[veh_number_police]</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">GPS Imei <b>*</b></label>
                                <div class="col-md-9">
                                <select class="form-control" name="gps_id">
                                    <?php
                                      echo '<option value="" selected="selected" disabled="" required>--- Choose GPS ---</option>';
                                        $showgps=pg_query("SELECT * FROM gps Where status = 'Received' and gps_cond_id = '1' Order By gps_imei_number asc");
                                        while ($sg=pg_fetch_array($showgps)) {
                                          echo "<option value=$sg[gps_id]>$sg[gps_imei_number]".' ('."$sg[status]".') '."</option>";
                                        }
                                    ?>
                                </select>
                                <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Gsm <b>*</b></label>
                                <div class="col-md-9">
                                    <select class="form-control" name="gsm_id">
                                        <?php
                                            echo '<option value="" selected="selected" disabled="" required>--- Choose GSM ---</option>';
                                                $showgsm=pg_query("SELECT * FROM gsm WHERE status = 'Activated' and gsm_cond_id = '2' order by gsm_number asc ");
                                                while ($sgsm=pg_fetch_array($showgsm)) {
                                                    echo "<option value=$sgsm[gsm_id]>$sgsm[gsm_number]".' ('."$sgsm[status]".') '."</option>";
                                                }
                                        ?>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" id="btnSave" name="save" class="btn btn-primary" >Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>

                    </form>
                </div>

                </div>

            </div>
        </div>
    </div>
    <!---########################################################### End Modal Jquery Add Order ################################################################## -->

    <!-- Add Data -->
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#po" data-toggle="tab">PO Reinstallation</a></li> 
                  <li><a href="#trial" data-toggle="tab">Trial Reinstallation</a></li>
                </ul>
                
                <div class="tab-content">
                <div class="tab-pane active" id="po">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Form PO Reinstallation</h4>
                </div>

                <div class="modal-body">
                <?php echo form_open('reinstall/process_order_install'); ?>
                        <?php echo validation_errors(); ?>

                            <div class="form-group">
                            <label class=""><b>Number BAST/SPK</b></label>
                                <div class="radio">
                                    <label class="radio-inline">
                                        <input type="radio" checked="" name="order_type_number" id="bs1" value="BAST"> BAST
                                    </label>
                                    <label class="radio-inline">
                                          <input type="radio" name="order_type_number" id="ba2" value="SPK"> SPK
                                    </label>
                                </div>
                                <input type="text" name="order_number" placeholder="Type here for number of BAST or SPK" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-10">
                                <label class=""><b>Customer</b></label>
                                    <select class="form-control" name="cust_id" required>
                                    <?php
                                      echo '<option value="" selected="selected" disabled="" required>--- Choose Customers ---</option>';
                                        $showcust=pg_query("SELECT * FROM customer Order By cust_code Desc");
                                        while ($cust=pg_fetch_array($showcust)) {
                                          echo "<option value=$cust[cust_id]>$cust[cust_code]</option>";
                                        }
                                    ?>
                                    </select>
                                </div>
                                <div class="col-md-2" style="margin-top: 25px;">
                                    <button type="button" class="btn  btn-sm btn-raised btn-primary" data-toggle="modal" data-target="#customerModal">
                                        <i class="fa fa-plus"> Add</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                            
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-10">
                                <label class=""><b>PIC Technicion</b></label>
                                    <select class="form-control" name="emp_id" required>
                                        <?php
                                            echo '<option value="" selected="selected" disabled="" required>--- Choose Technicion ---</option>';
                                            $showemp=pg_query("SELECT * FROM employees WHERE emp_position = '4' Order By emp_name Desc");
                                            while ($emp=pg_fetch_array($showemp)) {
                                            echo "<option value=$emp[emp_id]>$emp[emp_name]</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2" style="margin-top: 25px;">
                                    <button type="button" class="btn  btn-sm btn-raised btn-primary" data-toggle="modal" data-target="#employeeModal">
                                        <i class="fa fa-plus"> Add</i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=""><b>Date Installation</b></label>
                                <input type="text" name="order_date" placeholder="17, August 1945"  class="form-control datepicker" required>
                        </div>

                        <div class="form-group">
                            <label class=""><b>Location</b></label>
                                <input type="text" name="order_location" placeholder="Location installation"  class="form-control" required>
                        </div>

                        <!--<div class="form-group">
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
                            <label class=""><b>Vehicle Install Type</b></label>
                                <input type="text" name="vehicle_install_type" placeholder="Vehicle Number" value="PO Installation"  class="form-control" required disabled>
                        </div>

                        <div class="form-group">
                            <label for=""><b>Vehicle Remarks</b></label>
                                <textarea name="order_veh_remarks" placeholder="Remarks"class="form-control" required></textarea>
                        </div>-->

                        <div class="form-group">
                            <label for=""><b>Vehicle</b></label>
                                <select class="form-control" name="veh_id">
                                    <?php
                                      echo '<option value="" selected="selected" disabled="" required>--- Choose Vehicle ---</option>';
                                        $showgps=pg_query("SELECT * FROM vehicles Where veh_status = 'Uninstalled' ");
                                        while ($sg=pg_fetch_array($showgps)) {
                                          echo "<option value=$sg[veh_id]>$sg[veh_number_police]</option>";
                                        }
                                    ?>
                                </select>
                        </div>
                            
                        <div class="form-group">
                            <label for=""><b>GPS Imei</b></label>
                                <select class="form-control" name="gps_id">
                                    <?php
                                      echo '<option value="" selected="selected" disabled="" required>--- Choose GPS ---</option>';
                                        $showgps=pg_query("SELECT * FROM gps Where status = 'Received' or status = 'Uninstalled' and gps_cond_id = '1' ");
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
                                            $showgsm=pg_query("SELECT * FROM gsm Where status = 'Activated' or status = 'Uninstalled' and gsm_cond_id = '2'");
                                            while ($sgsm=pg_fetch_array($showgsm)) {
                                                echo "<option value=$sgsm[gsm_id]>$sgsm[gsm_number]</option>";
                                            }
                                    ?>
                                </select>
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" name="save" class="btn btn-primary" >Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                <?php echo form_close(); ?>
                
                </div>

                <div class="tab-pane" id="trial">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Form Trial Reinstallation</h4>
                </div>

                <div class="modal-body">
                <?php echo form_open('reinstall/process_order_install_trial'); ?>
                        <?php echo validation_errors(); ?>

                        <div class="form-group">
                            <label class=""><b>Number BAST/SPK</b></label>
                                <div class="radio">
                                    <label class="radio-inline">
                                        <input type="radio" checked="" name="order_type_number" id="bs1" value="BAST"> BAST
                                    </label>
                                    <label class="radio-inline">
                                          <input type="radio" name="order_type_number" id="ba2" value="SPK"> SPK
                                    </label>
                                </div>
                                <input type="text" name="order_number" placeholder="Type here for number of BAST or SPK" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-10">
                                <label class=""><b>Customer</b></label>
                                    <select class="form-control" name="cust_id" required>
                                    <?php
                                      echo '<option value="" selected="selected" disabled="" required>--- Choose Customers ---</option>';
                                        $showcust=pg_query("SELECT * FROM customer Order By cust_code Desc");
                                        while ($cust=pg_fetch_array($showcust)) {
                                          echo "<option value=$cust[cust_id]>$cust[cust_code]</option>";
                                        }
                                    ?>
                                    </select>
                                </div>
                                <div class="col-md-2" style="margin-top: 25px;">
                                    <button type="button" class="btn  btn-sm btn-raised btn-primary" data-toggle="modal" data-target="#customerModal">
                                        <i class="fa fa-plus"> Add</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                            
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-10">
                                <label class=""><b>PIC Technicion</b></label>
                                    <select class="form-control" name="emp_id" required>
                                        <?php
                                            echo '<option value="" selected="selected" disabled="" required>--- Choose Technicion ---</option>';
                                            $showemp=pg_query("SELECT * FROM employees WHERE emp_position = '4' Order By emp_name Desc");
                                            while ($emp=pg_fetch_array($showemp)) {
                                            echo "<option value=$emp[emp_id]>$emp[emp_name]</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2" style="margin-top: 25px;">
                                    <button type="button" class="btn  btn-sm btn-raised btn-primary" data-toggle="modal" data-target="#employeeModal">
                                        <i class="fa fa-plus"> Add</i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=""><b>Date Installation</b></label>
                                <input type="text" name="order_date" placeholder="17, August 1945"  class="form-control datepicker" required>
                        </div>

                        <div class="form-group">
                            <label class=""><b>Location</b></label>
                                <input type="text" name="order_location" placeholder="Location installation"  class="form-control" required>
                        </div>

                        <!--<div class="form-group">
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
                        </div>-->

                        <!--<div class="form-group">
                            <label class=""><b>Vehicle Install Type</b></label>
                                <input type="text" name="vehicle_install_type" placeholder="Vehicle Number" value="Trial Installation"  class="form-control" required disabled>
                        </div>-->

                        <div class="form-group">
                            <label class=""><b>Vehicle Expiry Date</b></label>
                                <input type="text" name="order_veh_expiry_date" placeholder="17, August 1945"  class="form-control datepicker" required>
                        </div>

                        <div class="form-group">
                            <label for=""><b>Vehicle</b></label>
                                <select class="form-control" name="veh_id">
                                    <?php
                                      echo '<option value="" selected="selected" disabled="" required>--- Choose Vehicle ---</option>';
                                        $showgps=pg_query("SELECT * FROM vehicles Where veh_status = 'Uninstalled' ");
                                        while ($sg=pg_fetch_array($showgps)) {
                                          echo "<option value=$sg[veh_id]>$sg[veh_number_police]</option>";
                                        }
                                    ?>
                                </select>
                        </div>

                        <!--<div class="form-group">
                            <label for=""><b>Vehicle Remarks</b></label>
                                <textarea name="order_veh_remarks" placeholder="Remarks"class="form-control" required></textarea>
                        </div>-->
                            
                        <div class="form-group">
                            <label for=""><b>GPS Imei</b></label>
                                <select class="form-control" name="gps_id">
                                    <?php
                                      echo '<option value="" selected="selected" disabled="" required>--- Choose GPS ---</option>';
                                        $showgps=pg_query("SELECT * FROM gps Where status = 'Received' or status = 'Uninstalled' and gps_cond_id = '1' Order By gps_imei_number Desc");
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
                                            $showgsm=pg_query("SELECT * FROM gsm WHERE status = 'Activated' or status = 'Uninstalled' and gsm_cond_id = '2' ");
                                            while ($sgsm=pg_fetch_array($showgsm)) {
                                                echo "<option value=$sgsm[gsm_id]>$sgsm[gsm_number]</option>";
                                            }
                                    ?>
                                </select>
                        </div>
                </div>
                
                <div class="modal-footer">
                    <button type="submit" name="save" class="btn btn-primary" >Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                <?php echo form_close(); ?>

                </div>
                </div>
   
            </div>
        </div>
    </div>
    <!-- End Add Data -->

    <!-- Add Data Customer -->
    <!-- Modal -->
    <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Form Input Customer</h4>
                </div>
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#home" data-toggle="tab">Personal</a></li> 
                      <li><a href="#profile" data-toggle="tab">Company</a></li>
                    </ul>
                    <br>
                    <div class="tab-content">
                      <div class="tab-pane active" id="home">
                      
                      <?= form_open('customer/process_insert_personal'); ?>
                      <?= validation_errors(); ?>
                      
                      <div class="modal-body">  
                        <div class="form-group">
                            <label class="">Customer Code</label>
                                <input name="cust_code" placeholder="Code" class="form-control" type="text" required>
                        </div>

                        <div class="form-group">
                            <label class="">Customer Full Name</label>
                                <input name="cust_full_name" placeholder="Full Name" class="form-control" type="text" required>
                        </div>

                        <div class="form-group">
                            <label class="">Customer Short Name</label>
                                <input name="cust_short_name" placeholder="Short Name" class="form-control" type="text" required>
                        </div>

                        <div class="form-group">
                            <label class=""><b>Gender</b></label>
                                <div class="radio">
                                    <label class="radio-inline">
                                        <input type="radio" checked="" name="cust_gender" id="bs1" value="Laki-laki"> Laki-laki
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="cust_gender" id="ba2" value="Perempuan"> Perempuan
                                    </label>
                                </div>
                        </div>

                        <div class="form-group"> 
                            <label class="">Religion</label>
                                <select class="form-control" style="" name="cust_religion_id">
                                    <?php
                                        echo '<option value="" selected="selected">--- Pilih Religion ---</option>';
                                                        
                                        $tampil=pg_query("SELECT * FROM customer_religion");
                                        while($w=pg_fetch_array($tampil)){
                                        echo "<option value=$w[cust_religion_id]>$w[cust_religion_name]</option>";
                                                        }
                                    ?> 
                                </select>
                        </div>

                        <div class="form-group">
                            <label class="">Email Address</label>
                                <input name="cust_personal_email" placeholder="Email Address" class="form-control" type="text" required>
                        </div>

                        <div class="form-group">
                            <label class="">Phone</label>
                                <input name="cust_personal_phone" placeholder="Phone" class="form-control" type="text" required>
                        </div>

                        <div class="form-group">
                            <label class="">Mobile Phone</label>
                                <input name="cust_personal_mobile_phone" placeholder="Mobile Phone" class="form-control" type="text" required>
                        </div>

                        <div class="form-group">
                            <label for="">Address</label>
                                <textarea name="cust_personal_address" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control" required></textarea>
                        </div>

                        <div class="form-group">
                        <label class="">Start Date Contract</label>
                            <input name="cust_start_date_contract" placeholder="Start Contract" class="form-control datepicker" type="text">
                        </div>

                        <div class="form-group">
                            <label class="">End Date Contract</label>
                                <input name="cust_end_date_contract" placeholder="End Contract" class="form-control datepicker" type="text">
                        </div>

                        <div class="form-group">
                            <label class="">Maintenance Contract</label>
                                <input name="cust_maintenance_contract" placeholder="Maintenan Contract" class="form-control" type="text">
                        </div>
                      </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" >Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>

                      <?= form_close(); ?>
                      </div>

                      <div class="tab-pane" id="profile">
                        <?= form_open('customer/process_insert_company'); ?>
                        <?= validation_errors(); ?>

                        <div class="modal-body">
                        <div class="form-group">
                            <label class="">Customer Code</label>
                                <input name="cust_code" placeholder="Code" class="form-control" type="text" required>
                        </div>

                        <div class="form-group">
                            <label class="">Company Name</label>
                                <input name="cust_company_name" placeholder="Company Name" class="form-control" type="text" required>
                        </div>

                        <!--<div class="form-group">
                            <label class="">Company Business Type</label>
                                <input name="cust_business_type" placeholder="Business Company Type" class="form-control" type="text" required>
                        </div>-->

                        <div class="form-group">
                        <div class="row">
                            <div class="col-md-10"> 
                            <label class="">Company Business Type</label>
                                <select class="form-control" style="" name="cust_business_type">
                                    <?php
                                        echo '<option value="" selected="selected">--- Pilih Company Business Type ---</option>';
                                                        
                                        $tampil=pg_query("SELECT * FROM customer_business_type");
                                        while($w=pg_fetch_array($tampil)){
                                        echo "<option value=$w[cust_business_type_id]>$w[cust_business_type_name]</option>";
                                                        }
                                    ?> 
                                </select>
                            </div>
                            <div class="col-md-2" style="margin-top: 25px;">
                                <button type="button" class="btn  btn-sm btn-raised btn-primary" data-toggle="modal" data-target="#businessModal">
                                    <i class="fa fa-plus"> Add</i>
                                </button>
                            </div>
                        </div>
                        </div>

                        <div class="form-group">
                            <label for="">Address 1</label>
                                <textarea name="cust_company_address" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="">Address 2</label>
                                <textarea name="cust_company_address2" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="">Address 3</label>
                                <textarea name="cust_company_address3" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control" required></textarea>
                        </div>

                        <div class="form-group">
                            <label class="">Zip Code</label>
                                <input name="cust_company_codepos" placeholder="Code Pos" class="form-control" type="text" required>
                        </div>

                        <div class="form-group">
                            <label class="">City</label>
                                <input name="cust_company_city" placeholder="City" class="form-control" type="text" required>
                        </div>

                        <div class="form-group">
                            <label class="">Phone</label>
                                <input name="cust_company_phone" placeholder="Company Phone" class="form-control" type="text" required>
                        </div>

                        <div class="form-group">
                            <label class="">Email</label>
                                <input name="cust_company_email" placeholder="Company Email" class="form-control" type="text" required>
                        </div>

                        <div class="form-group">
                        <label class="">Start Date Contract</label>
                            <input name="cust_start_date_contract" placeholder="Start Contract" class="form-control datepicker" type="text">
                        </div>

                        <div class="form-group">
                            <label class="">End Date Contract</label>
                                <input name="cust_end_date_contract" placeholder="End Contract" class="form-control datepicker" type="text">
                        </div>

                        <div class="form-group">
                            <label class="">Maintenance Contract</label>
                                <input name="cust_maintenance_contract" placeholder="Maintenan Contract" class="form-control" type="text">
                        </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" >Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>

                        <?= form_close(); ?>
                      </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- End Add Data Customer -->

    <!---########################################################### Modal Jquery Add Reinstall In One BAST Type 1 ################################################################## -->
    <div class="modal fade" id="modal_reinstall_po" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Form PO Reinstallation</h3>
                </div>
                <form method="post" action="<?php echo base_url('order/ajax_po_install'); ?>" class="form-horizontal">
                    <div class="modal-body form">
                        <input type="hidden" value="" name="id"/>
                        <input type="hidden" value="" name="type"/>

                        <div class="form-body">
                            
                            <div class="form-group">
                                <label class="control-label col-md-3">Type Number</label>
                                    <div class="col-md-9">
                                        <div class="radio" id="editTypeNumber">
                                            <label class="radio-inline">
                                                <input type="radio" name="order_type_number_edit" value="BAST" /> BAST
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="order_type_number_edit" value="SPK" /> SPK
                                            </label>
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Number BAST/SPK</label>
                                <div class="col-md-9">
                                    <input name="order_number_edit" placeholder="Customer Code" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Customer</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="cust_id_edit" required>
                                        <?php
                                          echo '<option value="" selected="selected" disabled="" required>--- Choose Customers ---</option>';
                                            $showcust=pg_query("SELECT * FROM customer Order By cust_code asc");
                                            while ($cust=pg_fetch_array($showcust)) {
                                              echo "<option value=$cust[cust_id]>$cust[cust_code]</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">PIC Technicion</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="emp_id_edit" required>
                                        <?php
                                            echo '<option value="" selected="selected" disabled="" required>--- Choose Technicion ---</option>';
                                            $showemp=pg_query("SELECT * FROM employee WHERE pos_id = '1' Order By emp_name asc");
                                                while ($emp=pg_fetch_array($showemp)) {
                                                echo "<option value=$emp[emp_id]>$emp[emp_name]</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Date Reinstallation</label>
                                <div class="col-md-9">
                                    <input name="order_date_edit" placeholder="17, August 1945" class="form-control datepicker" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Location</label>
                                <div class="col-md-9">
                                    <input name="order_location_edit" placeholder="Location" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Vehicle</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="veh_id">
                                        <?php
                                            echo '<option value="" selected="selected" disabled="" required>--- Choose Vehicle ---</option>';
                                                $showgps=pg_query("SELECT * FROM vehicles Where veh_status = 'Uninstalled' order by veh_number_police asc");
                                                while ($sg=pg_fetch_array($showgps)) {
                                                  echo "<option value=$sg[veh_id]>$sg[veh_number_police]</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">GPS Imei</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="gps_id_edit">
                                        <?php
                                            echo '<option value="" selected="selected" disabled="" required>--- Choose GPS ---</option>';
                                                $showgps=pg_query("SELECT * FROM gps Where status = 'Received' or status = 'Uninstalled' and gps_cond_id = '1' Order By gps_imei_number asc");
                                                while ($sg=pg_fetch_array($showgps)) {
                                                  echo "<option value=$sg[gps_id]>$sg[gps_imei_number]".' ('."$sg[status]".') '."</option>";
                                            }
                                        ?>
                                     </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Gsm</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="gsm_id_edit">
                                        <?php
                                            echo '<option value="" selected="selected" disabled="" required>--- Choose Number ---</option>';
                            
                                            $showgsm=pg_query("SELECT * FROM gsm WHERE status = 'Activated' or status = 'Uninstalled' and gsm_cond_id = '2' order by gsm_number asc");
                                            while ($sgsm=pg_fetch_array($showgsm)) {
                                                echo "<option value=$sgsm[gsm_id]>$sgsm[gsm_number]".' ('."$sgsm[status]".') '."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    <!---########################################################### End Modal Jquery Add Reinstall In One BAST  Type 1 ################################################################## -->

    <!---########################################################### Modal Jquery Add Reinstall In One BAST Type 2 ################################################################## -->
    <div class="modal fade" id="modal_reinstall_trial" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Form Trial Reinstallation</h3>
                </div>
                <form method="post" action="<?php echo base_url('order/ajax_trial_install'); ?>" class="form-horizontal">
                    <div class="modal-body form">
                        <input type="hidden" value="" name="id"/>
                        <input type="hidden" value="" name="type"/>

                        <div class="form-body">
                            
                            <div class="form-group">
                                <label class="control-label col-md-3">Type Number</label>
                                    <div class="col-md-9">
                                        <div class="radio" id="editTypeNumber1">
                                            <label class="radio-inline">
                                                <input type="radio" name="order_type_number_edit1" value="BAST" /> BAST
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="order_type_number_edit1" value="SPK" /> SPK
                                            </label>
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Number BAST/SPK</label>
                                <div class="col-md-9">
                                    <input name="order_number_edit1" placeholder="Customer Code" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Customer</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="cust_id_edit" required>
                                        <?php
                                          echo '<option value="" selected="selected" disabled="" required>--- Choose Customers ---</option>';
                                            $showcust=pg_query("SELECT * FROM customer Order By cust_code asc");
                                            while ($cust=pg_fetch_array($showcust)) {
                                              echo "<option value=$cust[cust_id]>$cust[cust_code]</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">PIC Technicion</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="emp_id_edit" required>
                                        <?php
                                            echo '<option value="" selected="selected" disabled="" required>--- Choose Technicion ---</option>';
                                            $showemp=pg_query("SELECT * FROM employee WHERE pos_id = '1' Order By emp_name asc");
                                                while ($emp=pg_fetch_array($showemp)) {
                                                echo "<option value=$emp[emp_id]>$emp[emp_name]</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Date Reinstallation</label>
                                <div class="col-md-9">
                                    <input name="order_date_edit" placeholder="17, August 1945" class="form-control datepicker" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Location</label>
                                <div class="col-md-9">
                                    <input name="order_location_edit" placeholder="Location" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Vehicle</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="veh_id">
                                        <?php
                                            echo '<option value="" selected="selected" disabled="" required>--- Choose Vehicle ---</option>';
                                                $showgps=pg_query("SELECT * FROM vehicles Where veh_status = 'Uninstalled' order by veh_number_police ");
                                                while ($sg=pg_fetch_array($showgps)) {
                                                  echo "<option value=$sg[veh_id]>$sg[veh_number_police]</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Vehicle Expiry Date</label>
                                <div class="col-md-9">
                                    <input type="text" name="order_veh_expiry_date" placeholder="17, August 1945"  class="form-control datepicker">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">GPS Imei</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="gps_id_edit">
                                        <?php
                                            echo '<option value="" selected="selected" disabled="" required>--- Choose GPS ---</option>';
                                                $showgps=pg_query("SELECT * FROM gps Where status = 'Received' or status = 'Uninstalled' and gps_cond_id = '1' Order By gps_imei_number asc");
                                                while ($sg=pg_fetch_array($showgps)) {
                                                  echo "<option value=$sg[gps_id]>$sg[gps_imei_number]".' ('."$sg[status]".') '."</option>";
                                            }
                                        ?>
                                     </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Gsm</label>
                                <div class="col-md-9">
                                    <select class="form-control" name="gsm_id_edit">
                                        <?php
                                            echo '<option value="" selected="selected" disabled="" required>--- Choose Number ---</option>';
                            
                                            $showgsm=pg_query("SELECT * FROM gsm WHERE status = 'Activated' or status = 'Uninstalled' and gsm_cond_id = '2' order by gsm_number asc");
                                            while ($sgsm=pg_fetch_array($showgsm)) {
                                                echo "<option value=$sgsm[gsm_id]>$sgsm[gsm_number]".' ('."$sgsm[status]".') '."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    <!---########################################################### End Modal Jquery Add Reinstall In One BAST Type 2 ################################################################## -->

    <!---########################################################### Modal Jquery Detail Reinstall ################################################################## -->
    <div class="modal fade" id="modal_detail" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Detail Reinstall</h3>
                </div>
                    <div class="modal-body form">
                        <div class="row">
                            <input type="hidden" value="" name="id"/>
                            <div class="col-md-4">
                              <span><b>Type Number</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_order_type"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>Number BAST/SPK</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_order_number"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>Customer</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_cust_code"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>PIC Technicion</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_emp_name"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>Order Location</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_order_location"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>Vehicle Name</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_veh_name"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>Vehicle Type Order</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_veh_install_type_business"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>GPS IMEI Number</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_gps_imei_number"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>GSM Number</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_gsm_number"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>Installated Date</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_order_date"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>Expiry Date</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_veh_expiry_date"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
            </div>
        </div>
    </div>
    <!---########################################################### End Modal Jquery Detail Reinstall ################################################################## -->

    <!---########################################################### Modal Jquery Uninstall ################################################################## -->
    <div class="modal fade" id="modal_uninstall" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Form Uninstallation</h3>
                </div>
                <form method="post" action="<?php echo base_url('order/process_order_uninstall'); ?>" class="form-horizontal">
                    <div class="modal-body form">
                        <input type="hidden" value="" name="id"/>
                        <input type="hidden" value="" name="gsm_id"/>
                        <input type="hidden" value="" name="gps_id"/>
                        <input type="hidden" value="" name="veh_id"/>

                        <div class="form-body">
                            
                            <div class="row">
                                <div class="col-md-3">
                                  <span>Vehicle Name</span>
                                </div>
                                <div class="col-md-9">
                                  <div class="uninstall_veh_name"></div>
                                </div>

                                <div class="col-md-3">
                                  <span>GPS IMEI Number</span>
                                </div>
                                <div class="col-md-9">
                                  <div class="uninstall_gps_imei_number"></div>
                                </div>

                                <div class="col-md-3">
                                  <span>GSM Number</span>
                                </div>
                                <div class="col-md-9">
                                  <div class="uninstall_gsm_number"></div>
                                </div>
                            </div><br>

                            <div class="form-group">
                                <div class="col-md-3">
                                    <label for="">Status Gps <b>*</b></label>
                                </div>
                                
                                <div class="col-md-9" style="margin-bottom: 14px;">
                                    <select class="form-control" name="gps_cond_id" required>
                                        <?php
                                            echo '<option value="" selected="selected">--- Choose GPS Type ---</option>';
                                            
                                            $showgpstype=pg_query("SELECT * FROM gps_conditions ORDER BY gps_cond_name ASC");
                                            while ($sgt=pg_fetch_array($showgpstype)) {
                                                echo "<option value=$sgt[gps_cond_id]>$sgt[gps_cond_name]</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-3">
                                    <label for="">Status Gsm <b>*</b></label>
                                </div>
                            
                                <div class="col-md-9" style="margin-bottom: 14px;">
                                    <select class="form-control" name="gsm_cond_id" required>
                                        <?php
                                            echo '<option value="" selected="selected">--- Pilih Condition ---</option>';
                                            
                                            $tampil=pg_query("SELECT * FROM gsm_conditions");
                                            while($w=pg_fetch_array($tampil)){
                                                echo "<option value=$w[gsm_cond_id]>$w[gsm_cond_name]</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3">Uninstallation Date <b>*</b></label>
                                <div class="col-md-9">
                                    <input name="uninstall_date" placeholder="17, August 1945" class="form-control datepicker" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3">Uninstallation By <b>*</b></label>
                                <div class="col-md-9">
                                    <input name="uninstall_by" placeholder="Uninstallation By" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
    <!---########################################################### End Modal Jquery Uninstall ################################################################## -->

<script type="text/javascript">
    $(document).ready(function() {
        $("input").change(function(){
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("textarea").change(function(){
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
        $("select").change(function(){
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
    });
    
    function add()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_add').modal('show'); // show bootstrap modal
        $('.modal-title').text('Purchase Order Reinstallation'); // Set Title to Bootstrap modal title
        $('.modal-title-trial').text('Trial Reinstallation')
    }

    /////////////////////////////////////////////// Modal Jquery Add Reinstall In One BAST ///////////////////////////////////////////////////////
    function add_reinstall(id,type)
    {
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('reinstall/ajax_add/')?>/" + id + '/' + type,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                if(type==1)
                {
                    $('[name="id"]').val(data.odet_id);
                    $('[name="type"]').val(data.veh_install_type_business);

                    if (data.order_type_number == 'BAST')
                    {
                      $('#editTypeNumber').find(':radio[name=order_type_number_edit][value="BAST"]').prop('checked', true);
                    }
                    else
                    {
                      $('#editTypeNumber').find(':radio[name=order_type_number_edit][value="SPK"]').prop('checked', true);
                    }

                    $('[name="order_number_edit"]').val(data.order_number);
                    
                    $('#modal_reinstall_po').modal('show'); // show bootstrap modal when complete loaded
                }
                else if(type==2)
                {
                    $('[name="id"]').val(data.odet_id);
                    $('[name="type"]').val(data.veh_install_type_business);

                    if (data.order_type_number == 'BAST')
                    {
                      $('#editTypeNumber1').find(':radio[name=order_type_number_edit1][value="BAST"]').prop('checked', true);
                    }
                    else
                    {
                      $('#editTypeNumber1').find(':radio[name=order_type_number_edit1][value="SPK"]').prop('checked', true);
                    }

                    $('[name="order_number_edit1"]').val(data.order_number);
                    
                    $('#modal_reinstall_trial').modal('show'); // show bootstrap modal when complete loaded
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    /////////////////////////////////////////////// End Modal Jquery Add Reinstall In One BAST ///////////////////////////////////////////////////////

    /////////////////////////////////////////////// Modal Jquery Detail Reinstall ///////////////////////////////////////////////////////
    function detail_order(id)
    {
        $('.help-block').empty(); 

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('reinstall/ajax_detail/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data.odet_id);
                //$('[name="type"]').val(data.veh_install_type_business);

                $('.detail_order_type').html(data.order_type_number);
                $('.detail_order_number').html(data.order_number);
                $('.detail_cust_code').html(data.cust_code);
                $('.detail_emp_name').html(data.emp_name);
                $('.detail_order_location').html(data.order_location);
                $('.detail_veh_name').html(data.veh_name);

                if (data.veh_install_type_business == '1')
                {
                    $('.detail_veh_install_type_business').html('Purchase Order');
                }
                else
                {
                    $('.detail_veh_install_type_business').html('Trial Order');
                }
                    
                $('.detail_veh_expiry_date').html(data.veh_expiry_date);
                $('.detail_gps_imei_number').html(data.gps_imei_number);
                $('.detail_gsm_number').html(data.gsm_number);
                $('.detail_order_date').html(data.order_date);
                    
                $('#modal_detail').modal('show'); // show bootstrap modal when complete loaded
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    /////////////////////////////////////////////// End Modal Jquery Detail Reinstall ///////////////////////////////////////////////////////

    /////////////////////////////////////////////// Modal Jquery Uninstall ///////////////////////////////////////////////////////
    function uninstall_reinstall(id)
    {
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('reinstall/ajax_uninstall/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data.odet_id);
                $('[name="gsm_id"]').val(data.gsm_id);
                $('[name="gsm_cond_id"]').val(data.gsm_cond_id);
                $('[name="gps_id"]').val(data.gps_id);
                $('[name="gps_cond_id"]').val(data.gps_cond_id);
                $('[name="veh_id"]').val(data.veh_id);

                $('.uninstall_veh_name').html(data.veh_name);
                $('.uninstall_gps_imei_number').html(data.gps_imei_number);
                $('.uninstall_gsm_number').html(data.gsm_number);
                  
                $('#modal_uninstall').modal('show'); // show bootstrap modal when complete loaded
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
      }
    /////////////////////////////////////////////// End Modal Jquery Uninstall In Reinstall ///////////////////////////////////////////////////////
</script>
