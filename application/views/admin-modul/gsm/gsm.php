<!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <h3 class="animated fadeInLeft">Data GSM Card Received</h3>
                        <p class="animated fadeInDown">
                           <a href="<?php echo base_url('dashboard'); ?>">CSIS</a> <span class="fa-angle-right fa"></span> <a href="">GSM</a> <span class="fa-angle-right fa"></span> Data GSM Card Received
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
                                    <button type="button" onclick="add_gsm()" class="btn  btn-sm btn-raised btn-primary" data-toggle="modal">
                                        <i class="fa fa-plus"> Add</i>
                                    </button>
                                </div>
                                <button type="button" class="btn  btn-sm btn-raised btn-primary" data-toggle="modal" data-target="#login-modal">
                                  <i class="fa fa-file-excel-o"> Import</i>
                                </button>
                                <a href="<?php echo base_url('gsm/excelfiles'); ?>">
                                    <button type="button" class="btn  btn-sm btn-raised btn-primary">
                                      <i class="fa fa-file-excel-o"> Export</i>
                                    </button>
                                </a>   
                            </div>
                        </div>
                    </div>

                        <div class="panel-body">
                        <div class="responsive-table">
                         <form method="post" action="<?php echo base_url('gsm/activeAll'); ?>">
                            <table id="datatables-example" class="table table-bordred table-striped" width="100%" cellspacing="0">
                            <thead>
                              <tr>
                                <th><center><input type="checkbox" id="checkAll" /></center></th>
                                <th>No</th>
                                <th>GSM Number</th>
                                <th>IMSI Number</th>
                                <th>ICCID Number</th>
                                <th>Vendor</th>
                                <th>Status</th>
                                <th>Aksi</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $no = 1;
                                    foreach ($data as $v):
                            ?>
                              <tr>
                                <td><center><input type="checkbox" name="check_id[]" value="<?php echo $v->gsm_id ?>" class="checkthis" /></center></td>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $v->gsm_number; ?></td>
                                <td><?php echo $v->gsm_imsi_number; ?></td>
                                <td><?php echo $v->gsm_iccid_number; ?></td>
                                <td><input type="hidden" name="is_vendor[]" value="<?php echo $v->is_vendor;?>" /><?php echo $v->is_vendor;?></td>
                                <td><i class="label label-info"><?php echo $v->status; ?></i></td>
                                <td>
                                    <a href="javascript:void(0)" onclick="detail_gsm('<?php echo $v->gsm_id ?>')" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="right" title="Detail Data"><i class="glyphicon glyphicon-list-alt"></i></a>
                                    <a href="javascript:void(0)" onclick="active_gsm('<?php echo $v->gsm_id ?>')" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="right" title="Activate Data"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:void(0)" onclick="edit_gsm('<?php echo $v->gsm_id ?>')" class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="right" title="Update"><i class="glyphicon glyphicon-pencil"></i></a>
                                    <a href="javascript:void(0)" onclick="delete_gsm('<?php echo $v->gsm_id; ?>')" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="right" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>
                                </td>
                              </tr>
                            <?php 
                                $no++; 
                                endforeach;
                            ?>
                            </tbody>
                            </table>
                                <input id="activateBtn" type="submit" name="activate" value="Activate" class="btn btn-sm btn-raised btn-success">                                             
                                <input id="sendBtn" type="submit" name="send" value="Send" class="btn btn-sm btn-raised btn-success">    
                            </form>
            
                        </div>
                        </div>
                </div>
            </div>  
        </div>
    </div>

    <!---########################################################### Modal Jquery Add GSM ################################################################## -->
    <div class="modal fade" id="modal_add" role="dialog">
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
                                <label class="control-label col-md-3">Number Card GSM <b>*</b></label>
                                <div class="col-md-9">
                                    <input name="gsm_number" placeholder="GSM Number" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Number IMSI GSM <b>*</b></label>
                                <div class="col-md-9">
                                    <input name="gsm_imsi_number" placeholder="Number IMSI GSM" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Number ICCID GSM <b>*</b></label>
                                <div class="col-md-9">
                                    <input name="gsm_iccid_number" placeholder="Number ICCID GSM" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Vendor <b>*</b></label>
                                <div class="col-md-9">
                                    <select class="form-control" style="" name="vendor_id">
                                        <?php
                                            echo '<option value="" selected="selected">--- Pilih Vendor ---</option>';
                                            $tampil=pg_query("SELECT * FROM vendor where vendor_type='GSM'");
                                            while($w=pg_fetch_array($tampil)){
                                            echo "<option value=$w[vendor_id]>$w[vendor_name]</option>";
                                            }
                                        ?> 
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Condition <b>*</b></label>
                                <div class="col-md-9">
                                    <select class="form-control" style="" name="gsm_cond_id">
                                        <?php
                                            echo '<option value="" selected="selected">--- Pilih Condition ---</option>';
                                            $tampil=pg_query("SELECT * FROM gsm_conditions");
                                            while($w=pg_fetch_array($tampil)){
                                            echo "<option value=$w[gsm_cond_id]>$w[gsm_cond_name]</option>";
                                            }
                                        ?> 
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">GSM Received Date <b>*</b></label>
                                <div class="col-md-9">
                                    <input name="gsm_received_date" placeholder="GSM Received Date" class="form-control datepicker" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">GSM Received By <b>*</b></label>
                                <div class="col-md-9">
                                    <input name="gsm_received_by" placeholder="GSM Received By" class="form-control" type="text">
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
    <!---########################################################### End Modal Jquery Add GSM ################################################################## -->

    <!-- Import Data GSM -->
    <!-- Modal -->
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="loginmodal-container">
                <h1>Import File Excel</h1><br>

                <?php  echo form_open_multipart('gsm/do_upload') . "\n"; ?>
                    <input type="file" id="file_upload" name="userfile" /><br>
                    <input type="submit" name="login" class="login loginmodal-submit" value="Upload">
                <?php echo form_close(); ?>
                
            </div>
        </div>
    </div>
    <!-- End Import Data GSM -->

    <!---########################################################### Modal Jquery Active GSM ################################################################## -->
    <div class="modal fade" id="modal_active" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title"></h3>
                </div>
                    <form id="form" method="post" action="<?php echo base_url('gsm/ajax_active_proses'); ?>" class="form-horizontal">
                    <div class="modal-body">
                        
                        <input type="hidden" value="" name="id"/>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">GSM Activated Date <b>*</b></label>
                                <div class="col-md-9">
                                    <input name="gsm_activated_date" placeholder="GSM Activated Date" class="form-control datepicker" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">GSM Activated By <b>*</b></label>
                                <div class="col-md-9">
                                    <input name="gsm_activated_by" placeholder="GSM Activated By" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>

                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Active</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                    </form>
            </div>
        </div>
    </div>
    <!---########################################################### End Modal Jquery Active GSM ################################################################## -->

    <!---########################################################### Modal Jquery Detail GSM ################################################################## -->
    <div class="modal fade" id="modal_detail" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Detail GSM Received</h3>
                </div>
                    <div class="modal-body form">
                        <div class="row">
                            <input type="hidden" value="" name="id"/>
                            <div class="col-md-4">
                              <span><b>GSM Number</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>GSM IMSI Number</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_imsi"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>GSM ICCID Number</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_iccid"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>Vendor</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_vendor"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>Condition</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_cond"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>GSM Received By</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_by"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>GSM Received Date</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_date"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>Status</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_status"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
            </div>
        </div>
    </div>
    <!---########################################################### End Modal Jquery Detail GSM ################################################################## -->

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

    function add_gsm()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_add').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add GSM'); // Set Title to Bootstrap modal title
    }

    function save()
    {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        var url;

        if(save_method == 'add') 
        {
            url = "<?php echo site_url('gsm/ajax_add')?>";
        } 
        else if(save_method == 'update') 
        {
            url = "<?php echo site_url('gsm/ajax_update')?>";
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
                    $('#modal_add').modal('hide');
                    $(".confirm-div").html("<p class='alert alert-success'> Success Saving Data !!</p>");
                    window.setTimeout(function(){location.reload()},1000)                
                }
                else if (data.validate_status)
                {
                    $('#modal_add').modal('hide');
                    $(".confirm-div").html("<p class='alert alert-success'> Error Saving Data, This Number GSM is already inserted !!</p>");
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

    /////////////////////////////////////////////// Modal Jquery Edit GSM ///////////////////////////////////////////////////////
    function edit_gsm(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('.modal-title').text('Edit GSM Received'); // Set Title to Bootstrap modal title

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('gsm/ajax_edit/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data.gsm_id);
                $('[name="gsm_number"]').val(data.gsm_number);
                $('[name="gsm_imsi_number"]').val(data.gsm_imsi_number);
                $('[name="gsm_iccid_number"]').val(data.gsm_iccid_number);
                $('[name="vendor_id"]').val(data.vendor_id);
                $('[name="gsm_cond_id"]').val(data.gsm_cond_id);
                $('[name="gsm_received_date"]').val(data.gsm_received_date);
                $('[name="gsm_received_by"]').val(data.gsm_received_by);
                  
                $('#modal_add').modal('show'); // show bootstrap modal when complete loaded
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    /////////////////////////////////////////////// End Modal Jquery Edit GSM ///////////////////////////////////////////////////////

    /////////////////////////////////////////////// Modal Jquery Active GSM //////////////////////////////////////////////////////////
    function active_gsm(id)
    {
        save_method = 'active';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('.modal-title').text('Activated GSM Card'); // Set Title to Bootstrap modal title 

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('gsm/ajax_active/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data.gsm_id);
                $('[name="gsm_activated_date"]').val(data.gsm_activated_date);
                $('[name="gsm_activated_by"]').val(data.gsm_activated_by);
                  
                $('#modal_active').modal('show'); // show bootstrap modal when complete loaded
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    /////////////////////////////////////////////// End Modal Jquery Active GSM ///////////////////////////////////////////////////////

    /////////////////////////////////////////////// Modal Jquery Detail GSM ///////////////////////////////////////////////////////
    function detail_gsm(id)
    {
        $('.help-block').empty(); 

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('gsm/ajax_detail/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data.gsm_id);
                $('.detail').html(data.gsm_number);
                $('.detail_imsi').html(data.gsm_imsi_number);
                $('.detail_iccid').html(data.gsm_iccid_number);
                $('.detail_vendor').html(data.vendor_name);
                //$('.detail_cond').html(data.gsm_cond_id);

                if (data.gsm_cond_id == '2')
                    $('.detail_cond').html('Active');
                else
                    $('.detail_cond').html('Not Active');

                $('.detail_by').html(data.gsm_received_by);
                $('.detail_date').html(data.gsm_received_date);
                $('.detail_status').html(data.status);
                    
                $('#modal_detail').modal('show'); // show bootstrap modal when complete loaded
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    /////////////////////////////////////////////// End Modal Jquery Detail GSM ///////////////////////////////////////////////////////

    /////////////////////////////////////////////// Start Modal Jquery Proses Delete GSM ///////////////////////////////////////////////////////
    function delete_gsm(id)
    {
        if(confirm('Are you sure delete this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('gsm/ajax_delete')?>/" + id,
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
    /////////////////////////////////////////////// End Modal Jquery Proses Delete GSM ///////////////////////////////////////////////////////
</script>
