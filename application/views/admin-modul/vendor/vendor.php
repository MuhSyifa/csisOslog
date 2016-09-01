
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <h3 class="animated fadeInLeft">Data All Vendor</h3>
                        <p class="animated fadeInDown">
                            <a href="<?php echo base_url('dashboard'); ?>">CSIS</a> <span class="fa-angle-right fa"></span> Data All Vendor
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
                                    <button type="button" onclick="add_vendor()" class="btn  btn-sm btn-raised btn-primary" data-toggle="modal">
                                        <i class="fa fa-plus"> Add</i>
                                    </button>
                                </div>
                                <button type="button" class="btn  btn-sm btn-raised btn-primary" data-toggle="modal" data-target="#login-modal">
                                  <i class="fa fa-file-excel-o"> Import</i>
                                </button>
                                <a href="<?php echo base_url('vendor/excel_vendor'); ?>">
                                    <button type="button" class="btn  btn-sm btn-raised btn-primary">
                                      <i class="fa fa-file-excel-o"> Export</i>
                                    </button>
                                </a>
                                
                            </div>
                        </div>
                    </div>
                        <div class="panel-body">
                        <div class="responsive-table">
                            <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Nama Vendor</th>
                                <th>Type Vendor</th>
                                <th>Timestamp Insert</th>
                                <th>Last Timestamp Update</th>
                                <th>Aksi</th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $no = 1;
                                    foreach ($data as $v):
                                ?>
                              <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $v->vendor_name; ?></td>
                                <td><?php echo $v->vendor_type; ?></td>
                                <td><?php echo $v->vendor_insert; ?></td>
                                <td><?php echo $v->vendor_update; ?></td>
                                <td>
                                    <a href="javascript:void(0)" onclick="edit_vendor('<?php echo $v->vendor_id; ?>')" class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="right" title="Update"><i class="glyphicon glyphicon-pencil"></i></a> 
                                    <a href="javascript:void(0)" onclick="delete_vendor('<?php echo $v->vendor_id; ?>')" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="right" title="Delete"><i class="glyphicon glyphicon-trash"></i></a>
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

    <!---########################################################### Modal Jquery Edit Vendor ################################################################## -->
    <div class="modal fade" id="modal_edit_vendor" role="dialog">
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
                                <label class="control-label col-md-3">Nama Vendor <b>*</b></label>
                                <div class="col-md-9">
                                    <input name="vendor_name" placeholder="Vendor Name" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Type Vendor <b>*</b></label>
                                <div class="col-md-9">
                                    <select name="vendor_type" class="form-control">
                                        <option value="">--Select Type Vendor--</option>
                                        <option value="GSM">GSM</option>
                                        <option value="GPS">GPS</option>
                                    </select>
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
    <!---########################################################### End Modal Jquery Edit Vendor ################################################################## -->
    
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="loginmodal-container">
                <h1>Import File Excel</h1><br>

                <?php  echo form_open_multipart('vendor/do_upload') . "\n"; ?>
                    <input type="file" id="file_upload" name="userfile" /><br>
                    <input type="submit" name="login" class="login loginmodal-submit" value="Upload">
                <?php echo form_close(); ?>
                
            </div>
        </div>
    </div>

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

        function add_vendor()
        {
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_edit_vendor').modal('show'); // show bootstrap modal
            $('.modal-title').text('Add Vendor'); // Set Title to Bootstrap modal title
        }

        function save()
        {
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable 
            var url;

            if(save_method == 'add') {
                url = "<?php echo site_url('vendor/ajax_add')?>";
            } else {
                url = "<?php echo site_url('vendor/ajax_update')?>";
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
                        $('#modal_edit_vendor').modal('hide');
                        $(".confirm-div").html("<p class='alert alert-success'> Success Saving Data !!</p>");
                        window.setTimeout(function(){location.reload()},2000)                
                    }
                    else if (data.validate_status)
                    {
                        $('#modal_edit_vendor').modal('hide');
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
        function edit_vendor(id)
        {
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('.modal-title').text('Edit Vendor'); // Set Title to Bootstrap modal title

            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('vendor/ajax_edit/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('[name="id"]').val(data.vendor_id);
                    $('[name="vendor_name"]').val(data.vendor_name);
                    $('[name="vendor_type"]').val(data.vendor_type);

                    $('#modal_edit_vendor').modal('show'); // show bootstrap modal when complete loaded
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });
        }
        /////////////////////////////////////////////// End Modal Jquery Edit Vendor ///////////////////////////////////////////////////////

        /////////////////////////////////////////////// Start Modal Jquery Proses Delete Vendor ///////////////////////////////////////////////////////
        function delete_vendor(id)
        {
            if(confirm('Are you sure delete this data?'))
            {
                // ajax delete data to database
                $.ajax({
                    url : "<?php echo site_url('vendor/ajax_delete')?>/" + id,
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
        /////////////////////////////////////////////// End Modal Jquery Proses Delete Vendor ///////////////////////////////////////////////////////
    </script>
