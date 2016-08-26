    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <h3 class="animated fadeInLeft">Data All Customer</h3>
                        <p class="animated fadeInDown">
                            <a href="<?= base_url('dashboard');?>">CSIS</a> <span class="fa-angle-right fa"></span> Data All Customer
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
        
        <?= $this->session->flashdata('info'); ?>

        <div class="confirm-div">

        </div>

        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <button class="btn btn-primary btn-xs collapsed" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            <span data-toggle="tooltip" data-placement="right" title="Collapse for Action">Show</span>
                        </button>
                        <div style="height: 0px;" aria-expanded="false" class="collapse" id="collapseExample">
                            <div class="well">
                                <div class="col-md-9">
                                <button type="button" class="btn btn-sm btn-raised btn-primary" data-toggle="modal" data-target="#modal_form">
                                  <i class="fa fa-plus"> Add</i>
                                </button>
                                </div>
                                <button type="button" class="btn  btn-sm btn-raised btn-primary" data-toggle="modal" data-target="#login-modal">
                                  <i class="fa fa-file-excel-o"> Import</i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="responsive-table">
                            <table id="datatables-example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 10px;" align="center" >No.</th>
                                    <th>Customer Code</th>
                                    <!--<th>Company Id</th>
                                    <th>Personal Id</th>-->
                                    <th>Type</th>
                                    <th>Start Contract</th>
                                    <th>End Contract</th>
                                    <th>Maintenance Contract</th>
                                    <th style="width: 160px;" align="center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $no = 1;
                                        foreach ($customer as $v):
                                ?>
                                <tr>
                                    <td align="center"><?= $no; ?></td>
                                    <td><?php echo $v->cust_code; ?></td>
                                    <!--<td><?php echo $v->cust_company_detail_id; ?></td>
                                    <td><?php echo $v->cust_personal_detail_id; ?></td>-->
                                    <td><?php //$v->emp_position; 
                                            $pesan = pg_query("SELECT * FROM customer where cust_type_id='$v->cust_type_id' ");
                                            $j = pg_fetch_array($pesan);
                                                        
                                            $query_tahun = "SELECT * FROM customer_type";
                                            $tahun = pg_query($query_tahun);
                                            while ($row_tahun = pg_fetch_array($tahun)){
                                                if($row_tahun[0] == $j[2]) {
                                                echo $row_tahun[1];
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $v->cust_start_date_contract; ?></td>
                                    <td><?php echo $v->cust_end_date_contract; ?></td>
                                    <td><?php echo $v->cust_maintenance_contract; ?></td>
                                    <td>
                                        <a href="javascript:void(0)" onclick="detail_cust('<?php echo $v->cust_id; ?>','<?php echo $v->cust_type_id; ?>')" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="right" title="Detail Data"><span ><i class="glyphicon glyphicon-list-alt"></i></span> </a>
                                        <a href="javascript:void(0)" onclick="edit_cust('<?php echo $v->cust_id; ?>','<?php echo $v->cust_type_id; ?>')" class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="right" title="Update Data"><i class="glyphicon glyphicon-pencil"></i></a> 
                                        <a href="javascript:void(0)" onclick="delete_cust('<?php echo $v->cust_id; ?>')" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="right" title="Delete Data"><i class="glyphicon glyphicon-trash"></i></a>
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

<!-- Add Data Customer -->
    <!-- Modal -->
    <div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

  <!-- End Bootstrap modal -->

  <!-- Import Data GSM -->
    <!-- Modal -->
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="loginmodal-container">
            <h1>Import File Excel</h1><br>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#personal" data-toggle="tab">Personal</a></li> 
                <li><a href="#company" data-toggle="tab">Company</a></li>
            </ul>
            <br>
            <div class="tab-content">
                <div class="tab-pane active" id="personal">
                    <?php  echo form_open_multipart('customer/do_upload_personal') . "\n"; ?>
                        <input type="file" id="file_upload" name="userfile" /><br>
                        <input type="submit" name="login" class="login loginmodal-submit" value="Upload">
                    <?php echo form_close(); ?>
                </div>
                <div class="tab-pane" id="company">
                    <?php  echo form_open_multipart('customer/do_upload_company') . "\n"; ?>
                        <input type="file" id="file_upload" name="userfile" /><br>
                        <input type="submit" name="login" class="login loginmodal-submit" value="Upload">
                    <?php echo form_close(); ?>
                </div>
            </div>
            </div>
        </div>
    </div>
    <!-- End Import Data GSM -->

<!---########################################################### Modal Jquery Edit Customer Personal ################################################################## -->
<div class="modal fade" id="modal_edit" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Edit Customer Personal</h3>
            </div>
            <form method="post" action="<?php echo base_url('customer/ajax_update'); ?>" class="form-horizontal">
                <div class="modal-body form">
                    <input type="hidden" value="" name="id"/>
                    <input type="hidden" value="" name="type"/>
                    <input type="hidden" value="" name="detail_id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Customer Code</label>
                            <div class="col-md-9">
                                <input name="cust_code_edit" placeholder="Customer Code" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <?php
                            
                            //$sql="select * from customer_personal_detail where cust_personal_detail_id = $v->cust_personal_detail_id";
                            //$record=pg_fetch_array(pg_query($sql));
        
                        ?>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Customer Full Name</label>
                            <div class="col-md-9">
                                <input name="cust_full_name_edit" placeholder="Customer Full Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Customer Short Name</label>
                            <div class="col-md-9">
                                <input name="cust_short_name_edit" placeholder="Customer Short Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Gender</label>
                                <div class="col-md-9">
                                    <div class="radio" id="editGender">
                                        <label class="radio-inline">
                                            <input type="radio" name="cust_gender_edit" value="Laki-laki" /> Laki-laki
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="cust_gender_edit" value="Perempuan" /> Perempuan
                                        </label>
                                    </div>
                                </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Religion</label>
                            <div class="col-md-9">
                                <select class="form-control" name="cust_religion_id_edit" required>
                                    <?php
                                        //$pesan = pg_query("select * from customer where cust_personal_detail_id = '$v->cust_personal_detail_id' ");
                                        //$j = pg_fetch_array($pesan);

                                        $pesan = pg_query("SELECT * FROM customer_personal_detail where cust_personal_detail_id='$v->cust_personal_detail_id' ");
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
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Email Address</label>
                            <div class="col-md-9">
                                <input name="cust_personal_email_edit" placeholder="Email Address" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Phone</label>
                            <div class="col-md-9">
                                <input name="cust_personal_phone_edit" placeholder="Phone" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Mobile Phone</label>
                            <div class="col-md-9">
                                <input name="cust_personal_mobile_phone_edit" placeholder="Mobile Phone" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Address</label>
                            <div class="col-md-9">
                                <textarea name="cust_address_edit" id="address" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Start Date Contract</label>
                            <div class="col-md-9">
                                <input name="cust_start_date_contract_edit" placeholder="Start Date Contract" class="form-control datepicker" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">End Date Contract</label>
                            <div class="col-md-9">
                                <input name="cust_end_date_contract_edit" placeholder="End Date Contract" class="form-control datepicker" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Maintenance Contract</label>
                            <div class="col-md-9">
                                <input name="cust_maintenance_contract_edit" placeholder="Maintenance Contract" class="form-control" type="text">
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
<!---########################################################### End Modal Jquery Edit Customer Personal ################################################################## -->

<!---########################################################### Modal Jquery Detail Customer ################################################################## -->
<div class="modal fade" id="modal_detail" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Detail Customer Personal</h3>
            </div>
                <div class="modal-body form">
                    <div class="row">
                        <input type="hidden" value="" name="id"/>
                        <div class="col-md-4">
                          <span><b>Customer Code</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_code"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Customer Full Name</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_full_name"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Customer Short Name</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_short_name"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Gender</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_gender"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Religion</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_religion_id"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Email Address</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_personal_email"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Phone</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_personal_phone"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Mobile Phone</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_personal_mobile_phone"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Address</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_personal_address"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Start Date Contract</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_start_date_contract"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>End Date Contract</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_end_date_contract"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Maintenance Contract</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_maintenance_contract"></div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
        </div>
    </div>
</div>
<!---########################################################### End Modal Jquery Detail Customer ################################################################## -->

<!---########################################################### Modal Jquery Detail Customer ################################################################## -->
<div class="modal fade" id="modal_detail_company" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Detail Customer Company</h3>
            </div>
                <div class="modal-body form">
                    <div class="row">
                        <input type="hidden" value="" name="id"/>
                        <div class="col-md-4">
                          <span><b>Customer Code</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_code"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Company Name</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_company_name"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Company Business Type</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_business_type"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Address 1</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_company_address"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Address 2</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_company_address2"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Address 3</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_company_address3"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Zip Code</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_company_codepos"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>City</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_company_city"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Phone</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_company_phone"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Email</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_company_email"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Start Date Contract</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_start_date_contract"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>End Date Contract</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_end_date_contract"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Maintenance Contract</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_maintenance_contract"></div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
        </div>
    </div>
</div>
<!---########################################################### End Modal Jquery Detail Customer ################################################################## -->

<!---########################################################### Modal Jquery Edit Customer Company ################################################################## -->
<div class="modal fade" id="modal_edit_company" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Edit Customer Company</h3>
            </div>
            <form method="post" action="<?php echo base_url('customer/ajax_update_company'); ?>" class="form-horizontal">
                <div class="modal-body form">
                    <input type="hidden" value="" name="id"/>
                    <input type="hidden" value="" name="type"/>
                    <input type="hidden" value="" name="detail_company_id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Customer Code</label>
                            <div class="col-md-9">
                                <input name="cust_code_edit" placeholder="Customer Code" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <?php
                            
                            $sql="select * from customer_company_detail where cust_company_detail_id = $v->cust_company_detail_id";
                            $record=pg_fetch_array(pg_query($sql));
        
                        ?>
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Customer Company Name</label>
                            <div class="col-md-9">
                                <input name="cust_company_name_edit" placeholder="Customer Full Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Customer Business Type</label>
                            <div class="col-md-9">
                                <select class="form-control" name="cust_business_type_edit" style="width:31%">
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
                            <label class="control-label col-md-3">Address</label>
                            <div class="col-md-9">
                                <textarea name="cust_address_edit" id="address" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Address 2</label>
                            <div class="col-md-9">
                                <textarea name="cust_address2_edit" id="address2" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Address3</label>
                            <div class="col-md-9">
                                <textarea name="cust_address3_edit" id="address3" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Zip Code</label>
                            <div class="col-md-9">
                                <input name="cust_company_codepos_edit" placeholder="Zip Code" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">City</label>
                            <div class="col-md-9">
                                <input name="cust_company_city_edit" placeholder="City" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Company Phone</label>
                            <div class="col-md-9">
                                <input name="cust_company_phone_edit" placeholder="Company Phone" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Email</label>
                            <div class="col-md-9">
                                <input name="cust_company_email_edit" placeholder="Email" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Start Date Contract</label>
                            <div class="col-md-9">
                                <input name="cust_start_date_contract_edit" placeholder="Start Date Contract" class="form-control datepicker" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">End Date Contract</label>
                            <div class="col-md-9">
                                <input name="cust_end_date_contract_edit" placeholder="End Date Contract" class="form-control datepicker" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Maintenance Contract</label>
                            <div class="col-md-9">
                                <input name="cust_maintenance_contract_edit" placeholder="Maintenance Contract" class="form-control" type="text">
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
<!---########################################################### End Modal Jquery Edit Customer Company ################################################################## -->

    <!-- Add Data Customer Business Type -->
    <!-- Modal -->
    <div class="modal fade" id="businessModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Form Input Customer Business</h4>
                </div>
                
                <?= form_open('customer_business_type/process_insert1'); ?>
                <?= validation_errors(); ?>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="">Customer Business Type</label>
                            <input name="cust_business_name" placeholder="Business Name" class="form-control" type="text" required>
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
    <!-- End Add Data Business Type -->

<script type="text/javascript">
    /////////////////////////////////////////////// Start Modal Jquery Proses Delet Department ///////////////////////////////////////////////////////
    function delete_cust(id)
    {
        if(confirm('Are you sure delete this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('customer/ajax_delete')?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {                    
                    $(".confirm-div").html("<p class='alert alert-success'> Success Deleting Data !!</p>");
                    window.setTimeout(function(){location.reload()},1000)                    
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });
        }
    }
    /////////////////////////////////////////////// End Modal Jquery Proses Delet Department ///////////////////////////////////////////////////////

    /////////////////////////////////////////////// Modal Jquery Edit Customer Personal ///////////////////////////////////////////////////////
    function edit_cust(id,type)
    {
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('customer/ajax_edit/')?>/" + id + '/' + type,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                if(type==1)
                {
                    $('[name="id"]').val(data.cust_id);
                    $('[name="type"]').val(data.cust_type_id);
                    $('[name="detail_id"]').val(data.cust_personal_detail_id);

                    $('[name="cust_code_edit"]').val(data.cust_code);
                    $('[name="cust_full_name_edit"]').val(data.cust_full_name);
                    $('[name="cust_short_name_edit"]').val(data.cust_short_name);

                    if (data.cust_gender == 'Laki-laki')
                      $('#editGender').find(':radio[name=cust_gender_edit][value="Laki-laki"]').prop('checked', true);
                    else
                      $('#editGender').find(':radio[name=cust_gender_edit][value="Perempuan"]').prop('checked', true);

                    $('[name="cust_personal_email_edit"]').val(data.cust_personal_email);
                    $('[name="cust_personal_phone_edit"]').val(data.cust_personal_phone);
                    $('[name="cust_personal_mobile_phone_edit"]').val(data.cust_personal_mobile_phone);
                    $("textarea#address").val(data.cust_personal_address);
                    
                    $('[name="cust_start_date_contract_edit"]').val(data.cust_start_date_contract);
                    $('[name="cust_end_date_contract_edit"]').val(data.cust_end_date_contract);
                    $('[name="cust_maintenance_contract_edit"]').val(data.cust_maintenance_contract);
                    
                    $('#modal_edit').modal('show'); // show bootstrap modal when complete loaded
                }
                else if(type==2)
                {
                    $('[name="id"]').val(data.cust_id);
                    $('[name="type"]').val(data.cust_type_id);
                    $('[name="detail_company_id"]').val(data.cust_company_detail_id);

                    $('[name="cust_code_edit"]').val(data.cust_code);
                    $('[name="cust_company_name_edit"]').val(data.cust_company_name);
                    $('[name="cust_business_type_edit"]').val(data.cust_business_type);
                    $("textarea#address").val(data.cust_company_address);
                    $("textarea#address2").val(data.cust_company_address2);
                    $("textarea#address3").val(data.cust_company_address3);
                    $('[name="cust_company_codepos_edit"]').val(data.cust_company_codepos);
                    $('[name="cust_company_city_edit"]').val(data.cust_company_city);
                    $('[name="cust_company_phone_edit"]').val(data.cust_company_phone);
                    $('[name="cust_company_email_edit"]').val(data.cust_company_email);
                    
                    $('[name="cust_start_date_contract_edit"]').val(data.cust_start_date_contract);
                    $('[name="cust_end_date_contract_edit"]').val(data.cust_end_date_contract);
                    $('[name="cust_maintenance_contract_edit"]').val(data.cust_maintenance_contract);
                    
                    $('#modal_edit_company').modal('show'); // show bootstrap modal when complete loaded
                }
                  
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    /////////////////////////////////////////////// End Modal Jquery Edit Customer ///////////////////////////////////////////////////////

    /////////////////////////////////////////////// Modal Jquery Detail Customer ///////////////////////////////////////////////////////
    function detail_cust(id,type)
    {
        $('.help-block').empty(); 
            //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('customer/ajax_detail/')?>/" + id + '/' + type,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                if(type==1)
                {
                    $('[name="id"]').val(data.cust_id);
                    $('[name="type"]').val(data.cust_type_id);
                    $('[name="detail_id"]').val(data.cust_personal_detail_id);

                    $('.detail_cust_code').html(data.cust_code);
                    $('.detail_cust_full_name').html(data.cust_full_name);
                    $('.detail_cust_short_name').html(data.cust_short_name);
                    $('.detail_cust_gender').html(data.cust_gender);
                    $('.detail_cust_religion_id').html(data.cust_religion_id);
                    $('.detail_cust_personal_email').html(data.cust_personal_email);
                    $('.detail_cust_personal_phone').html(data.cust_personal_phone);
                    $('.detail_cust_personal_mobile_phone').html(data.cust_personal_mobile_phone);
                    $('.detail_cust_personal_address').html(data.cust_personal_address);

                    $('.detail_cust_start_date_contract').html(data.cust_start_date_contract);
                    $('.detail_cust_end_date_contract').html(data.cust_end_date_contract);
                    $('.detail_cust_maintenance_contract').html(data.cust_maintenance_contract);
                    
                    $('#modal_detail').modal('show'); // show bootstrap modal when complete loaded
                }
                else if(type==2)
                {
                    $('[name="id"]').val(data.cust_id);
                    $('[name="type"]').val(data.cust_type_id);
                    $('[name="detail_id"]').val(data.cust_personal_detail_id);

                    $('.detail_cust_code').html(data.cust_code);
                    $('.detail_cust_company_name').html(data.cust_company_name);
                    $('.detail_cust_business_type').html(data.is_business);
                    $('.detail_cust_company_address').html(data.cust_company_address);
                    $('.detail_cust_company_address2').html(data.cust_company_address2);
                    $('.detail_cust_company_address3').html(data.cust_company_address3);
                    $('.detail_cust_company_codepos').html(data.cust_company_codepos);
                    $('.detail_cust_company_city').html(data.cust_company_city);
                    $('.detail_cust_company_phone').html(data.cust_company_phone);
                    $('.detail_cust_company_email').html(data.cust_company_email);
                    
                    $('.detail_cust_start_date_contract').html(data.cust_start_date_contract);
                    $('.detail_cust_end_date_contract').html(data.cust_end_date_contract);
                    $('.detail_cust_maintenance_contract').html(data.cust_maintenance_contract);
                    
                    $('#modal_detail_company').modal('show'); // show bootstrap modal when complete loaded
                }        
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    /////////////////////////////////////////////// End Modal Jquery Detail Customer ///////////////////////////////////////////////////////
</script>