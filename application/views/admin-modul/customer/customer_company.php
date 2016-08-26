    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <h3 class="animated fadeInLeft">Customer Company</h3>
                        <p class="animated fadeInDown">
                            <a href="<?= base_url('dashboard');?>">CSIS</a> <span class="fa-angle-right fa"></span> Customer Company
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
                                <!--<button type="button" onclick="add_customer_company()" class="btn  btn-sm btn-raised btn-primary" data-toggle="modal">
                                    <i class="fa fa-plus"> Add</i>
                                </button>-->
                                </div>
                                <button type="button" class="btn  btn-sm btn-raised btn-primary" data-toggle="modal" data-target="#login-modal">
                                  <i class="fa fa-file-excel-o"> Import</i>
                                </button>
                                <a href="<?php echo base_url('customer/customer_company_excel'); ?>">
                                    <button type="button" class="btn  btn-sm btn-raised btn-primary">
                                        <i class="fa fa-file-excel-o"> Export</i>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="responsive-table">
                            <table id="datatables-example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 10px;" align="center" >No.</th>
                                    <th>Company</th>
                                    <th style="width: 40px;">Code</th>
                                    <th style="width: 100px;">Contact Person</th>
                                    <th>Phone</th>
                                    <th>E-mail</th>
                                    <th style="width: 40px;">Status</th>
                                    <th style="width: 23%;"><center>Action</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $no = 1;
                                        foreach ($customer as $v):
                                ?>
                                <tr>
                                    <td align="center"><?= $no; ?></td>
                                    <td><?php echo $v->cust_company_name; ?></td>
                                    <td><?php echo $v->cust_code; ?></td>
                                    <td><?php echo $v->cust_name; ?></td>
                                    <td><?php echo $v->cust_company_phone; ?></td>
                                    <td><?php echo $v->cust_company_email; ?></td>
                                    <td><?php echo $v->status; ?></td>
                                    <td>
                                        <center>
                                            <a href="javascript:void(0)" onclick="add_pic('<?php echo $v->cust_company_id; ?>')" class="btn btn-xs btn-info"data-toggle="tooltip" data-placement="right" title="Add PIC"><span ><i class="fa fa-plus"></i></span></a>
                                            <a href="javascript:void(0)" onclick="detail_cust_company('<?php echo $v->cust_company_id; ?>')" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="right" title="Detail"><span ><i class="glyphicon glyphicon-list-alt"></i></span></a>
                                            <a href="javascript:void(0)" onclick="edit_cust_company('<?php echo $v->cust_company_id; ?>')" class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="right" title="Update"><i class="glyphicon glyphicon-pencil"></i></a> 
                                            <a href="javascript:void(0)" onclick="delete_cust('<?php echo $v->cust_company_id; ?>','<?php echo $v->cust_pic_contact; ?>')" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="right" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>
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

<!-- Add Data Customer -->
    <!-- Modal -->
    <div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Form Input Customer</h4>
                </div>
                    <!--<ul class="nav nav-tabs">
                      <li class="active"><a href="#profile" data-toggle="tab">Company</a></li>
                    </ul>-->
                    <!--<br>
                    <div class="tab-content">
                      <div class="tab-pane active" id="profile">-->
                        <?= form_open('customer/add_company'); ?>
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

                        <div class="form-group"> 
                            <label class="">Company Business Type</label>
                                <select class="form-control" style="" name="cust_business_type_id">
                                    <?php
                                        echo '<option value="" selected="selected">--- Pilih Business ---</option>';
                                    
                                        $tampil=pg_query("SELECT * FROM customer_business_type");
                                        while($w=pg_fetch_array($tampil)){
                                            echo "<option value=$w[cust_business_type_id]>$w[cust_business_type_name]</option>";
                                        }
                                    ?> 
                                </select>
                        </div>

                        <div class="form-group">
                            <label class="">Company Email Address</label>
                                <input name="cust_company_email" placeholder="Email" class="form-control" type="text">
                        </div>

                        <div class="form-group">
                            <label class="">Company Phone</label>
                            <input name="cust_company_phone" placeholder="Phone" class="form-control" type="text">
                        </div>

                        <div class="form-group">
                            <label class="">Company Address</label>
                            <textarea name="cust_company_address" id="cust_personal_address" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="">Start Date Contract</label>
                            <input name="cust_start_date_contract" placeholder="Start Date Contract" class="form-control datepicker" type="text">
                        </div>

                        <div class="form-group">
                            <label class="">End Date Contract</label>
                            <input name="cust_end_date_contract" placeholder="End Date Contract" class="form-control datepicker" type="text">
                        </div>

                        <hr>
                        <center><b>Contact Person</b></center>
                        <hr>

                        <div class="form-group">
                            <label class="">PIC Name</label>
                            <input name="cust_name" placeholder="Name" class="form-control" type="text">
                        </div>

                        <div class="form-group">
                            <label class="">Position</label>
                            <select class="form-control" style="" name="cust_position">
                                <?php
                                    echo '<option value="" selected="selected">--- Pilih Position ---</option>';
                                    
                                    $tampil=pg_query("SELECT * FROM position");
                                        while($w=pg_fetch_array($tampil)){
                                        echo "<option value=$w[pos_id]>$w[pos_name]</option>";
                                    }
                                ?> 
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="">Department</label>
                            <select class="form-control" style="" name="cust_department">
                                <?php
                                    echo '<option value="" selected="selected">--- Pilih Department ---</option>';
                                    
                                    $tampil=pg_query("SELECT * FROM department");
                                        while($w=pg_fetch_array($tampil)){
                                        echo "<option value=$w[dep_id]>$w[dep_name]</option>";
                                        }
                                ?> 
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="">Mobile Phone</label>
                            <input name="cust_mobile_phone" placeholder="Mobile Phone" class="form-control" type="text">
                        </div>

                        <div class="form-group">
                            <label class="">E-Mail</label>
                            <input name="cust_email" placeholder="E-Mail" class="form-control" type="text">
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
                            <label class="">Birth Date</label>
                            <input name="cust_birth_date" placeholder="Birth Date" class="form-control datepicker" type="text">
                        </div>

                        <div class="form-group">
                            <label class="">Address</label>
                            <textarea name="cust_address" id="cust_address" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control"></textarea>
                        </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" >Save</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>

                        <?= form_close(); ?>
                      <!--</div>
                    </div>-->
            </div>
        </div>
    </div>
    <!-- End Add Data Customer -->

  <!-- End Bootstrap modal -->

<div class="modal fade" id="modal_add_pic" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Add Contact Person</h3>
            </div>
            <form method="post" action="<?php echo base_url('customer/add_pic'); ?>" class="form-horizontal">
                <div class="modal-body form">
                    <input type="hidden" value="" name="id"/>
                    <input type="hidden" value="" name="type"/>
                    <input type="hidden" value="" name="cust_code"/>
                    <input type="hidden" value="" name="cust_company_name"/>
                    <input type="hidden" value="" name="cust_business_type_id"/>
                    <input type="hidden" value="" name="cust_company_phone"/>
                    <input type="hidden" value="" name="cust_company_email"/>
                    <input type="hidden" value="" name="cust_company_address"/>
                    <input type="hidden" value="" name="cust_start_date_contract"/>
                    <input type="hidden" value="" name="cust_end_date_contract"/>

                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Customer Code</label>
                            <div class="col-md-9">
                              <div class="cust_code"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Customer Company Name</label>
                            <div class="col-md-9">
                              <div class="cust_company_name"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Status</label>
                            <div class="col-md-9">
                              <div class="status"></div>
                            </div>
                        </div>

                        <hr style="margin-bottom: 10px;">
                          <h4>Contact Person</h4>
                        <hr style="margin-top: 10px;">

                        <div class="form-group">
                            <label class="control-label col-md-3">Customer Name</label>
                            <div class="col-md-9">
                                <input name="cust_name_add" placeholder="Customer Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Position</label>
                            <div class="col-md-9">
                                <select class="form-control" style="" name="cust_position_add">
                                    <?php
                                        echo '<option value="" selected="selected">--- Pilih Position ---</option>';
                                        
                                        $tampil=pg_query("SELECT * FROM position");
                                            while($w=pg_fetch_array($tampil)){
                                            echo "<option value=$w[pos_id]>$w[pos_name]</option>";
                                        }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Department</label>
                            <div class="col-md-9">
                                <select class="form-control" style="" name="cust_department_add">
                                    <?php
                                        echo '<option value="" selected="selected">--- Pilih Department ---</option>';
                                        
                                        $tampil=pg_query("SELECT * FROM department");
                                            while($w=pg_fetch_array($tampil)){
                                            echo "<option value=$w[dep_id]>$w[dep_name]</option>";
                                            }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Mobile Phone</label>
                            <div class="col-md-9">
                                <input name="cust_mobile_phone_add" placeholder="Mobile Phone" class="form-control" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">E-Mail</label>
                            <div class="col-md-9">
                                <input name="cust_email_add" placeholder="E-Mail" class="form-control" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Religion</label>
                            <div class="col-md-9">
                                <select class="form-control" style="" name="cust_religion_id_add">
                                    <?php
                                        echo '<option value="" selected="selected">--- Pilih Religion ---</option>';
                                        $tampil=pg_query("SELECT * FROM customer_religion");
                                            while($w=pg_fetch_array($tampil)){
                                            echo "<option value=$w[cust_religion_id]>$w[cust_religion_name]</option>";
                                        }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Birth Date</label>
                            <div class="col-md-9">
                                <input name="cust_birth_date_add" placeholder="Birth Date" class="form-control datepicker" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Address</label>
                            <div class="col-md-9">
                                <textarea name="cust_address_add" id="cust_address" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control"></textarea>
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

<!---########################################################### Modal Jquery Detail Customer ################################################################## -->
<div class="modal fade" id="modal_detail" role="dialog">
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
                          <span><b>Company Phone</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_company_phone"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Company Email</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_company_email"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Company Address</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_company_address"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Status</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_status"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Start Contract</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_start_date_contract"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>End Contract</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_end_date_contract"></div>
                        </div>

                        
                        <div class="col-md-12">
                          <hr style="margin-bottom: 10px;">
                          <h4>Contact Person</h4>
                          <hr style="margin-top: 10px;">
                        </div>
                        

                        <div class="col-md-4">
                          <span><b>Name PIC</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_name"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Position PIC</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_position"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Department PIC</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_department"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Mobile Phone PIC</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_mobile_phone"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>E-mail PIC</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_email"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Religion PIC</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_religion_id"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Birth Date PIC</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_birth_date"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Address PIC</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_address"></div>
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

<!---########################################################### Modal Jquery Edit Customer Personal ################################################################## -->
<div class="modal fade" id="modal_edit" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Form Edit Customer Company</h3>
            </div>
            <form method="post" action="<?php echo base_url('customer/ajax_update_company'); ?>" class="form-horizontal">
                <div class="modal-body form">
                    <input type="hidden" value="" name="id"/>
                    <input type="hidden" value="" name="pic"/>
                    <!--<input type="hidden" value="" name="type"/>
                    <input type="hidden" value="" name="detail_company_id"/>-->
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Customer Code</label>
                            <div class="col-md-9">
                                <input name="cust_code_edit" placeholder="Customer Code" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
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
                                <select class="form-control" name="cust_business_type_edit">
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
                            <label class="control-label col-md-3">Company Email Address</label>
                            <div class="col-md-9">
                                <input name="cust_company_email_edit" placeholder="Email" class="form-control" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Company Phone</label>
                            <div class="col-md-9">
                                <input name="cust_company_phone_edit" placeholder="Phone" class="form-control" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Company Address</label>
                            <div class="col-md-9">
                                <textarea name="cust_company_address_edit" id="cust_company_address" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Start Date Contract</label>
                            <div class="col-md-9">
                                <input name="cust_start_date_contract_edit" placeholder="Start Date Contract" class="form-control datepicker" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">End Date Contract</label>
                            <div class="col-md-9">
                                <input name="cust_end_date_contract_edit" placeholder="End Date Contract" class="form-control datepicker" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Status</label>
                            <div class="col-md-9">
                                <select class="form-control" name="status_edit">
                                    <option value="Active">Active</option>
                                    <option value="Non Active">Non Active</option>
                                </select>
                            </div>
                        </div>

                        <hr>
                        <center><b>Contact Person</b></center>
                        <hr>

                        <div class="form-group">
                            <label class="control-label col-md-3">PIC Name</label>
                            <div class="col-md-9">
                                <input name="cust_name_edit" placeholder="Name" class="form-control" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Position</label>
                            <div class="col-md-9">
                                <select class="form-control" style="" name="cust_position_edit">
                                    <?php
                                        echo '<option value="" selected="selected">--- Pilih Position ---</option>';
                                        
                                        $tampil=pg_query("SELECT * FROM position");
                                            while($w=pg_fetch_array($tampil)){
                                            echo "<option value=$w[pos_id]>$w[pos_name]</option>";
                                        }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Department</label>
                            <div class="col-md-9">
                                <select class="form-control" style="" name="cust_department_edit">
                                    <?php
                                        echo '<option value="" selected="selected">--- Pilih Department ---</option>';
                                        
                                        $tampil=pg_query("SELECT * FROM department");
                                            while($w=pg_fetch_array($tampil)){
                                            echo "<option value=$w[dep_id]>$w[dep_name]</option>";
                                            }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Mobile Phone</label>
                            <div class="col-md-9">
                                <input name="cust_mobile_phone_edit" placeholder="Mobile Phone" class="form-control" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">E-Mail</label>
                            <div class="col-md-9">
                                <input name="cust_email_edit" placeholder="E-Mail" class="form-control" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Religion</label>
                            <div class="col-md-9">
                                <select class="form-control" style="" name="cust_religion_id_edit">
                                    <?php
                                        echo '<option value="" selected="selected">--- Pilih Religion ---</option>';
                                        $tampil=pg_query("SELECT * FROM customer_religion");
                                            while($w=pg_fetch_array($tampil)){
                                            echo "<option value=$w[cust_religion_id]>$w[cust_religion_name]</option>";
                                        }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Birth Date</label>
                            <div class="col-md-9">
                                <input name="cust_birth_date_edit" placeholder="Birth Date" class="form-control datepicker" type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Address</label>
                            <div class="col-md-9">
                                <textarea name="cust_address_edit" id="cust_address" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control"></textarea>
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

  <!-- Import Data GSM -->
    <!-- Modal -->
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="loginmodal-container">
            <h1>Import File Excel</h1><br>
            <ul class="nav nav-tabs">
                <!--<li><a href="#personal" data-toggle="tab">Personal</a></li>--> 
                <li class="active"><a href="#company" data-toggle="tab">Company</a></li>
            </ul>
            <br>
            <div class="tab-content">
                <div class="tab-pane" id="personal">
                    <?php  echo form_open_multipart('customer/do_upload_personal') . "\n"; ?>
                        <input type="file" id="file_upload" name="userfile" /><br>
                        <input type="submit" name="login" class="login loginmodal-submit" value="Upload">
                    <?php echo form_close(); ?>
                </div>
                <div class="tab-pane active" id="company">
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

<!---########################################################### Modal Jquery Customer Customer ################################################################## -->
    <div class="modal fade" id="modal_customer_company" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title"></h3>
                </div>
                    <div class="modal-body form">
                        <form id="form" action="#" class="form-horizontal">
                        <input type="hidden" value="" name="id"/>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Customer Code</label>
                                <div class="col-md-9">
                                    <input name="cust_code" placeholder="Code" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Company Name</label>
                                <div class="col-md-9">
                                    <input name="cust_company_name" placeholder="Name" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Business Type</label>
                                <div class="col-md-9">
                                    <select class="form-control" style="" name="cust_business_type_id">
                                        <?php
                                            echo '<option value="" selected="selected">--- Pilih Business ---</option>';
                                            $tampil=pg_query("SELECT * FROM customer_business_type");
                                            while($w=pg_fetch_array($tampil)){
                                            echo "<option value=$w[cust_business_type_id]>$w[cust_business_type_name]</option>";
                                            }
                                        ?> 
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Company Email Address</label>
                                <div class="col-md-9">
                                    <input name="cust_company_email" placeholder="Email" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Company Phone</label>
                                <div class="col-md-9">
                                    <input name="cust_company_phone" placeholder="Phone" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Company Address</label>
                                <div class="col-md-9">
                                    <textarea name="cust_company_address" id="cust_personal_address" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control"></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Start Date Contract</label>
                                <div class="col-md-9">
                                    <input name="cust_start_date_contract" placeholder="Start Date Contract" class="form-control datepicker" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">End Date Contract</label>
                                <div class="col-md-9">
                                    <input name="cust_end_date_contract" placeholder="End Date Contract" class="form-control datepicker" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <p><b>Contact Person</b></p>
                            <hr>

                            <div class="form-group">
                                <label class="control-label col-md-3">PIC Name</label>
                                <div class="col-md-9">
                                    <input name="cust_company_name" placeholder="Name" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Position</label>
                                <div class="col-md-9">
                                    <select class="form-control" style="" name="cust_position">
                                        <?php
                                            echo '<option value="" selected="selected">--- Pilih Position ---</option>';
                                            $tampil=pg_query("SELECT * FROM position");
                                            while($w=pg_fetch_array($tampil)){
                                            echo "<option value=$w[pos_id]>$w[pos_name]</option>";
                                            }
                                        ?> 
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Department</label>
                                <div class="col-md-9">
                                    <select class="form-control" style="" name="cust_department">
                                        <?php
                                            echo '<option value="" selected="selected">--- Pilih Department ---</option>';
                                            $tampil=pg_query("SELECT * FROM department");
                                            while($w=pg_fetch_array($tampil)){
                                            echo "<option value=$w[dep_id]>$w[dep_name]</option>";
                                            }
                                        ?> 
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Mobile Phone</label>
                                <div class="col-md-9">
                                    <input name="cust_mobile_phone" placeholder="Mobile Phone" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">E-Mail</label>
                                <div class="col-md-9">
                                    <input name="cust_email" placeholder="E-Mail" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Religion</label>
                                <div class="col-md-9">
                                    <select class="form-control" style="" name="cust_religion_id">
                                        <?php
                                            echo '<option value="" selected="selected">--- Pilih Religion ---</option>';
                                            $tampil=pg_query("SELECT * FROM customer_religion");
                                            while($w=pg_fetch_array($tampil)){
                                            echo "<option value=$w[cust_religion_id]>$w[cust_religion_name]</option>";
                                            }
                                        ?> 
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Birth Date</label>
                                <div class="col-md-9">
                                    <input name="cust_birth_date" placeholder="Birth Date" class="form-control datepicker" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Address</label>
                                <div class="col-md-9">
                                    <textarea name="cust_address" id="cust_address" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control"></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                                                        
                        </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
            </div>
        </div>
    </div>
    <!---########################################################### End Modal Jquery Customer Personal ################################################################## -->

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

    function add_customer_company()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_customer_company').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add Customer Company'); // Set Title to Bootstrap modal title
    }

    function add_pic(id)
    {
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('customer/ajax_add_pic/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data.cust_company_id);
                $('[name="type"]').val(data.cust_type_id);
                $('[name="cust_code"]').val(data.cust_code);
                $('[name="cust_company_name"]').val(data.cust_company_name);
                $('[name="cust_business_type_id"]').val(data.cust_business_type);
                $('[name="cust_company_phone"]').val(data.cust_company_phone);
                $('[name="cust_company_email"]').val(data.cust_company_email);
                $('[name="cust_company_address"]').val(data.cust_company_address);
                $('[name="cust_start_date_contract"]').val(data.cust_start_date_contract);
                $('[name="cust_end_date_contract"]').val(data.cust_end_date_contract);

                $('.cust_code').html(data.cust_code);
                $('.cust_company_name').html(data.cust_company_name);
                $('.status').html(data.status);

                $('#modal_add_pic').modal('show'); // show bootstrap modal when complete loaded
                  
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    /////////////////////////////////////////////// Modal Jquery Edit Customer Personal ///////////////////////////////////////////////////////
    function edit_cust_company(id)
    {
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('customer/ajax_edit_company/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data.cust_company_id);
                $('[name="pic"]').val(data.cust_pic_contact);
                
                $('[name="cust_code_edit"]').val(data.cust_code);
                $('[name="cust_company_name_edit"]').val(data.cust_company_name);
                $('[name="cust_business_type_edit"]').val(data.cust_business_type);
                $('[name="cust_company_phone_edit"]').val(data.cust_company_phone);
                $('[name="cust_company_email_edit"]').val(data.cust_company_email);
                $("textarea#cust_company_address").val(data.cust_company_address);
                $('[name="cust_start_date_contract_edit"]').val(data.cust_start_date_contract);
                $('[name="cust_end_date_contract_edit"]').val(data.cust_end_date_contract);
                $('[name="status_edit"]').val(data.status);
                // Person
                $('[name="cust_name_edit"]').val(data.cust_name);
                $('[name="cust_position_edit"]').val(data.cust_position);
                $('[name="cust_department_edit"]').val(data.cust_department);
                $('[name="cust_mobile_phone_edit"]').val(data.cust_mobile_phone);
                $('[name="cust_email_edit"]').val(data.cust_email);
                $('[name="cust_religion_id_edit"]').val(data.cust_religion_id);
                $('[name="cust_birth_date_edit"]').val(data.cust_birth_date);
                $("textarea#cust_address").val(data.cust_address);
                    
                $('#modal_edit').modal('show'); // show bootstrap modal when complete loaded
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    /////////////////////////////////////////////// End Modal Jquery Edit Customer ///////////////////////////////////////////////////////

    /////////////////////////////////////////////// Modal Jquery Detail Customer ///////////////////////////////////////////////////////
    function detail_cust_company(id)
    {
        $('.help-block').empty(); 
            //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('customer/ajax_detail_company/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data.cust_company_id);
                
                $('.detail_cust_code').html(data.cust_code);
                $('.detail_cust_company_name').html(data.cust_company_name);
                $('.detail_cust_company_phone').html(data.cust_company_phone);
                $('.detail_cust_company_email').html(data.cust_company_email);
                $('.detail_cust_company_address').html(data.cust_company_address);
                $('.detail_status').html(data.status);
                $('.detail_cust_start_date_contract').html(data.cust_start_date_contract);
                $('.detail_cust_end_date_contract').html(data.cust_end_date_contract);
                
                // Contact Person
                $('.detail_cust_name').html(data.cust_name);
                $('.detail_cust_position').html(data.cust_position);
                $('.detail_cust_department').html(data.cust_department);
                $('[name="cust_department_edit"]').val(data.cust_department);
                $('.detail_cust_mobile_phone').html(data.cust_mobile_phone);
                $('.detail_cust_email').html(data.cust_email);
                //$('.detail_cust_religion_id').html(data.cust_religion_id);
                if (data.cust_religion_id==1) 
                {
                    $('.detail_cust_religion_id').html("Islam");
                }
                else if(data.cust_religion_id==2)
                {
                    $('.detail_cust_religion_id').html("Kristen");
                }
                else if(data.cust_religion_id==3)
                {
                    $('.detail_cust_religion_id').html("Budha");
                }
                else if(data.cust_religion_id==4)
                {
                    $('.detail_cust_religion_id').html("Hindu");
                }
                else
                {
                    $('.detail_cust_religion_id').html("Lainnya");
                }

                $('.detail_cust_birth_date').html(data.cust_birth_date);
                $('.detail_cust_address').html(data.cust_address);
                    
                $('#modal_detail').modal('show'); // show bootstrap modal when complete loaded
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    /////////////////////////////////////////////// End Modal Jquery Detail Customer ///////////////////////////////////////////////////////

    function delete_cust(id,pic)
    {
        if(confirm('Are you sure delete this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('customer/ajax_delete_company')?>/" + id + '/' + pic,
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
</script>