    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <h3 class="animated fadeInLeft">Data Employee</h3>
                        <p class="animated fadeInDown">
                            <a href="<?= base_url('dashboard');?>">CSIS</a> <span class="fa-angle-right fa"></span> <a href="<?= base_url('customer/cutomer_list');?>">Customer</a> <span class="fa-angle-right fa"></span> Data Customer
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
                                <!--<button type="button" class="btn btn-sm btn-raised btn-primary" data-toggle="modal" data-target="#modal_form">
                                  <i class="fa fa-plus"> Add</i>
                                </button>-->
                                <button type="button" onclick="add_employee()" class="btn  btn-sm btn-raised btn-primary" data-toggle="modal">
                                    <i class="fa fa-plus">Add</i>
                                </button>
                                </div>
                                <button type="button" class="btn  btn-sm btn-raised btn-primary" data-toggle="modal" data-target="#login-modal">
                                  <i class="fa fa-file-excel-o"> Import</i>
                                </button>
                                <a href="<?php echo base_url('customer/excelfiles'); ?>">
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
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Birtdate</th>
                                    <th>Position</th>
                                    <th>Department</th>
                                    <th style="width: 160px;" align="center"><center>Action</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $no = 1;
                                        foreach ($employee as $v):
                                ?>
                                <tr>
                                    <td align="center"><?= $no; ?></td>
                                    <td><?= $v->emp_code; ?></td>
                                    <td><?= $v->emp_name; ?></td>
                                    <td><?= $v->emp_birthdate; ?></td>
                                    <td><?= $v->pos_name; ?></td>
                                    <td><?= $v->dep_name; ?></td>
                                    <td>
                                        <a href="javascript:void(0)" onclick="edit_employee('<?php echo $v->emp_id; ?>')" class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="right" title="Update"><i class="glyphicon glyphicon-pencil"></i></a>
                                        <a href="javascript:void(0)" onclick="delete_employee('<?php echo $v->emp_id; ?>')" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="right" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>
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

    <!---########################################################### Modal Jquery Employee ################################################################## -->
    <div class="modal fade" id="modal_emp" role="dialog">
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
                                    <label class="control-label col-md-3">Code Employee</label>
                                    <div class="col-md-9">
                                        <input name="emp_code" placeholder="Employee Code" class="form-control" type="text">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Name Employee</label>
                                    <div class="col-md-9">
                                        <input name="emp_name" placeholder="Employee Name" class="form-control" type="text">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Birth Date</label>
                                    <div class="col-md-9">
                                        <input name="emp_birthdate" placeholder="Birth Date" class="form-control datepicker" type="text">
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Position</label>
                                    <div class="col-md-9">
                                        <select class="form-control" style="" name="emp_position">
                                            <?php
                                                echo '<option value="" selected="selected">--- Pilih Position ---</option>';
                                                        
                                                $tampil=pg_query("SELECT * FROM employees_position");
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
                                        <select class="form-control" style="" name="emp_department">
                                            <?php
                                                echo '<option value="" selected="selected">--- Pilih Department ---</option>';
                                                        
                                                $tampil=pg_query("SELECT * FROM employees_department");
                                                while($w=pg_fetch_array($tampil)){
                                                    echo "<option value=$w[dep_id]>$w[dep_name]</option>";
                                                }
                                            ?> 
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Keterangan</label>
                                    <div class="col-md-9">
                                        <textarea id="note" name="emp_note" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control" required></textarea>
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
    <!---########################################################### End Modal Jquery Edit Department ################################################################## -->

    <!-- Add Data Customer -->
    <!-- Modal -->
    <!--<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Form Input Employee</h4>
                </div>
                
                <?= form_open('employee/process_insert'); ?>
                <?= validation_errors(); ?>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="">Code</label>
                            <input name="emp_code" placeholder="Code" class="form-control" type="text" required>
                    </div>

                    <div class="form-group">
                        <label class="">Name</label>
                            <input name="emp_name" placeholder="Name" class="form-control" type="text" required>
                    </div>

                    <div class="form-group">
                        <label class="">Birthdate</label>
                            <input type="text" name="emp_birthdate" placeholder="Position" class="form-control" id="datepicker">
                    </div>

                    <div class="form-group"> 
                        <label class="">Position</label>
                            <select class="form-control" style="" name="emp_position">
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
                            <select class="form-control" style="" name="emp_department">
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
                        <label for="">Keterangan</label>
                            <textarea name="emp_note" placeholder="Address: Ex: Plaza 5 Pondok Indah Block D-9 Jalan Margaguna Raya, Jakarta Selatan 12140. Indonesia"class="form-control" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Foto</label>
                            <input name="userfile" placeholder="Department" class="form-control" type="file">
                    </div>        
                </div>

                <div class="modal-footer">
                    <button type="submit" name="save" class="btn btn-primary" >Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

                <?= form_close(); ?>

            </div>
        </div>
    </div>-->
    <!-- End Add Data Customer -->

  <!-- End Bootstrap modal -->

  <!-- Import Data GSM -->
    <!-- Modal -->
    <!--<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="loginmodal-container">
                <h1>Import File Excel</h1><br>

                <?php  echo form_open_multipart('customer/do_upload') . "\n"; ?>
                    <input type="file" id="file_upload" name="userfile" /><br>
                    <input type="submit" name="login" class="login loginmodal-submit" value="Upload">
                <?php echo form_close(); ?>
                
            </div>
        </div>
    </div>-->
    <!-- End Import Data GSM -->

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

    function add_employee()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_emp').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add Employee'); // Set Title to Bootstrap modal title
    }

    function save()
    {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        var url;

        if(save_method == 'add') {
            url = "<?php echo site_url('Employee/ajax_add')?>";
        } else {
            url = "<?php echo site_url('Employee/ajax_update')?>";
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
                    $('#modal_emp').modal('hide');
                    $(".confirm-div").html("<p class='alert alert-success'> Success Saving Data !!</p>");
                    window.setTimeout(function(){location.reload()},2000)                
                }
                else if (data.validate_status)
                {
                    $('#modal_emp').modal('hide');
                    $(".confirm-div").html("<p class='alert alert-success'> Error Saving Data, This Name Vendor is already inserted !!</p>");
                    window.setTimeout(function(){location.reload()},2000)    
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

    /////////////////////////////////////////////// Modal Jquery Edit Vendor ///////////////////////////////////////////////////////
    function edit_employee(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('.modal-title').text('Edit Employee'); // Set Title to Bootstrap modal title

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('Employee/ajax_edit/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data.emp_id);
                $('[name="emp_code"]').val(data.emp_code);
                $('[name="emp_name"]').val(data.emp_name);
                $('[name="emp_birthdate"]').val(data.emp_birthdate);
                $('[name="emp_position"]').val(data.pos_id);
                $('[name="emp_department"]').val(data.dep_id);
                //$('[name="emp_name"]').val(data.emp_name);
                $("textarea#note").val(data.emp_note);

                $('#modal_emp').modal('show'); // show bootstrap modal when complete loaded
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    /////////////////////////////////////////////// End Modal Jquery Edit Vendor ///////////////////////////////////////////////////////

    /////////////////////////////////////////////// Start Modal Jquery Proses Delete Employee ///////////////////////////////////////////////////////
    function delete_employee(id)
    {
        if(confirm('Are you sure delete this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('Employee/ajax_delete')?>/" + id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {                    
                    $(".confirm-div").html("<p class='alert alert-success'> Success Deleting Data !!</p>");
                    window.setTimeout(function(){location.reload()},3000)                    
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });
        }
    }
    /////////////////////////////////////////////// End Modal Jquery Proses Delete Employee ///////////////////////////////////////////////////////
</script>
