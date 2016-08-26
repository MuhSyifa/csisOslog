    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <h3 class="animated fadeInLeft">Data All Customer Personal</h3>
                        <p class="animated fadeInDown">
                            <a href="<?= base_url('dashboard');?>">CSIS</a> <span class="fa-angle-right fa"></span> Data All Customer Personal
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
                                <!--<button type="button" onclick="add_customer_personal()" class="btn  btn-sm btn-raised btn-primary" data-toggle="modal">
                                    <i class="fa fa-plus"> Add</i>
                                </button>-->
                                <button type="button" class="btn btn-sm btn-raised btn-primary" data-toggle="modal" data-target="#modal_form">
                                  <i class="fa fa-plus"> Add</i>
                                </button>
                                </div>
                                <button type="button" class="btn  btn-sm btn-raised btn-primary" data-toggle="modal" data-target="#login-modal">
                                  <i class="fa fa-file-excel-o"> Import</i>
                                </button>
                                <a href="<?php echo base_url('customer/customer_personal_excel'); ?>">
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
                                    <th>Customer Code</th>
                                    <th>Customer Type</th>
                                    <th>Customer Name</th>
                                    <th>Start Contract</th>
                                    <th>End Contract</th>
                                    <th>Status</th>
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
                                    <td><?php echo $v->cust_type_name; ?></td>
                                    <td><?php echo $v->cust_name; ?></td>
                                    <td><?php echo $v->cust_start_date_contract; ?></td>
                                    <td><?php echo $v->cust_end_date_contract; ?></td>
                                    <td><?php echo $v->status; ?></td>
                                    <td>
                                        
                                        <a href="javascript:void(0)" onclick="detail_cust('<?php echo $v->cust_personal_id; ?>')" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="right" title="Detail Data"><span ><i class="glyphicon glyphicon-list-alt"></i></span></a>
                                        <a href="javascript:void(0)" onclick="edit_cust('<?php echo $v->cust_personal_id; ?>')" class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="right" title="Update Data"><i class="glyphicon glyphicon-pencil"></i></a>
                                        <!--<a href="<?= base_url();?>customer/update/<?= $v->cust_id ?>/<?= $v->cust_type_id ?>" class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="right" title="Update Data"><i class="glyphicon glyphicon-pencil"></i></a>-->
                                        <a href="javascript:void(0)" onclick="delete_cust('<?php echo $v->cust_personal_id; ?>')" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="right" title="Delete Data"><i class="glyphicon glyphicon-trash"></i></a>
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
                          <div class="detail_cust_name"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Customer Birth Date</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_cust_birth_date"></div>
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

  <!-- Import Data GSM -->
    <!-- Modal -->
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="loginmodal-container">
            <h1>Import File Excel</h1><br>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#personal" data-toggle="tab">Personal</a></li> 
                <!--<li><a href="#company" data-toggle="tab">Company</a></li>-->
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

    <div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Form Input Customer Personal</h4>
                </div>
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#profile" data-toggle="tab">Personal</a></li>
                    </ul>
                    <br>
                    <div class="tab-content">
                      <div class="tab-pane active" id="profile">
                        <?= form_open('customer/add_personal'); ?>
                        <?= validation_errors(); ?>

                        <div class="modal-body">
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">Customer Code</label>
                            <div class="col-md-9">
                                <input name="cust_code" placeholder="Code" class="form-control" type="text" required>
                                    <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Customer Name</label>
                            <div class="col-md-9">
                                <input name="cust_name" placeholder="Name" class="form-control" type="text" required>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Customer Birth Date</label>
                            <div class="col-md-9">
                                <input name="cust_birth_date" placeholder="Customer Birth Date" class="form-control datepicker" type="text" required>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Gender</label>
                            <div class="col-md-9">
                                <div class="radio" id="editGender">
                                    <label class="radio-inline">
                                        <input type="radio" name="cust_gender" value="Laki-laki"> Laki-laki
                                        <span class="help-block"></span>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="cust_gender" value="Perempuan"> Perempuan
                                        <span class="help-block"></span>
                                    </label>
                                </div>
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
                            <label class="control-label col-md-3">Email Address</label>
                            <div class="col-md-9">
                                <input name="cust_personal_email" placeholder="Email" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Phone</label>
                            <div class="col-md-9">
                                <input name="cust_personal_phone" placeholder="Phone" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Mobile Phone</label>
                            <div class="col-md-9">
                                <input name="cust_personal_mobile_phone" placeholder="Mobile Phone" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Address</label>
                            <div class="col-md-9">
                                <textarea name="cust_personal_address" id="cust_personal_address" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control"></textarea>
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

    <!---########################################################### Modal Jquery Customer Personal ################################################################## -->
    <div class="modal fade" id="modal_customer_personal" role="dialog">
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
                                    <input name="cust_code_edit" placeholder="Code" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Customer Name</label>
                                <div class="col-md-9">
                                    <input name="cust_name_edit" placeholder="Name" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Customer Birth Date</label>
                                <div class="col-md-9">
                                    <input name="cust_birth_date_edit" placeholder="Customer Birth Date" class="form-control datepicker" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Gender</label>
                                <div class="col-md-9">
                                    <label class="radio-inline">
                                        <input type="radio" name="cust_gender_edit" value="Laki-laki"> Laki-laki
                                        <span class="help-block"></span>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="cust_gender_edit" value="Perempuan"> Perempuan
                                        <span class="help-block"></span>
                                    </label>
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
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Email Address</label>
                                <div class="col-md-9">
                                    <input name="cust_personal_email_edit" placeholder="Email" class="form-control" type="text">
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
                                    <textarea name="cust_personal_address_edit" id="cust_personal_address_edit" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control"></textarea>
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
                                <label class="control-label col-md-3">Status</label>
                                <div class="col-md-9">
                                    <select id="optStatus" name="cust_status_edit" class="form-control">
                                      <option value="" selected="selected">--- Pilih Status ---</option>
                                      <option value="Active">Active</option>
                                      <option value="Non Active">Non Active</option>
                                    </select>
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

    function add_customer_personal()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_customer_personal').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add Customer Personal'); // Set Title to Bootstrap modal title
    }

    function save()
    {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        var url;

        if(save_method == 'add') 
        {
            url = "<?php echo site_url('customer/ajax_add')?>";
        }
        else if(save_method == 'update')
        {
            url = "<?php echo site_url('customer/ajax_update_personal')?>";
        }

        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                if(data.status) //if success close modal and reload ajax table
                {
                    $('#modal_customer_personal').modal('hide');
                    $(".confirm-div").html("<p class='alert alert-success'> Success Saving Data !!</p>");
                    window.setTimeout(function(){location.reload()},1000)                
                }
                else
                {
                    for (var i = 0; i < data.inputerror.length; i++) 
                    {
                        $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                }
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            }
        });
    }

    /////////////////////////////////////////////// Modal Jquery Edit Customer Personal ///////////////////////////////////////////////////////
    function edit_cust(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('.modal-title').text('Update Customer Personal'); // Set Title to Bootstrap modal title 

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('customer/ajax_edit_personal/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data.cust_personal_id);
                $('[name="cust_code_edit"]').val(data.cust_code);
                $('[name="cust_name_edit"]').val(data.cust_name);
                $('[name="cust_birth_date_edit"]').val(data.cust_birth_date);
                
                if (data.cust_gender == 'Laki-laki')
                {
                    $(':radio[name=cust_gender_edit][value="Laki-laki"]').prop('checked', true);
                }
                else
                {
                    $(':radio[name=cust_gender_edit][value="Perempuan"]').prop('checked', true);
                }

                $('[name="cust_religion_id_edit"]').val(data.cust_religion_id);
                $('[name="cust_personal_email_edit"]').val(data.cust_personal_email);
                $('[name="cust_personal_phone_edit"]').val(data.cust_personal_phone);
                $('[name="cust_personal_mobile_phone_edit"]').val(data.cust_personal_mobile_phone);
                $("textarea#cust_personal_address_edit").val(data.cust_personal_address);
                $('[name="cust_start_date_contract_edit"]').val(data.cust_start_date_contract);
                $('[name="cust_end_date_contract_edit"]').val(data.cust_end_date_contract);
                $('[name="cust_status_edit"]').val(data.status);

                //$( "#myselect option:selected" ).text();
                  
                $('#modal_customer_personal').modal('show'); // show bootstrap modal when complete loaded
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    /////////////////////////////////////////////// End Modal Jquery Edit Customer ///////////////////////////////////////////////////////

    /////////////////////////////////////////////// Modal Jquery Detail Customer ///////////////////////////////////////////////////////
    function detail_cust(id)
    {
        $('.help-block').empty(); 
            //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('customer/ajax_detail_personal/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data.cust_personal_id);

                $('.detail_cust_code').html(data.cust_code);
                $('.detail_cust_name').html(data.cust_name);
                $('.detail_cust_birth_date').html(data.cust_birth_date);
                $('.detail_cust_gender').html(data.cust_gender);
                    
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
                    
                $('.detail_cust_personal_email').html(data.cust_personal_email);
                $('.detail_cust_personal_phone').html(data.cust_personal_phone);
                $('.detail_cust_personal_mobile_phone').html(data.cust_personal_mobile_phone);
                $('.detail_cust_personal_address').html(data.cust_personal_address);

                $('.detail_cust_start_date_contract').html(data.cust_start_date_contract);
                $('.detail_cust_end_date_contract').html(data.cust_end_date_contract);
                $('.detail_cust_maintenance_contract').html(data.cust_maintenance_contract);
                    
                $('#modal_detail').modal('show'); // show bootstrap modal when complete loaded
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    /////////////////////////////////////////////// End Modal Jquery Detail Customer ///////////////////////////////////////////////////////

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
</script>