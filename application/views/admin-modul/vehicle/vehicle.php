    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <h3 class="animated fadeInLeft">Data Vehicle</h3>
                        <p class="animated fadeInDown">
                            <a href="<?= base_url('dashboard');?>">CSIS</a> <span class="fa-angle-right fa"></span> Data vehicle
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

        <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        <button class="btn btn-primary btn-xs collapsed" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                          <span data-toggle="tooltip" data-placement="right" title="Collapse for Action">Show</span>
                        </button>
                        <div style="height: 0px;" aria-expanded="false" class="collapse" id="collapseExample">
                            <div class="well">
                                <a href="<?php echo base_url('vehicle/vehicle_excel'); ?>">
                                    <button type="button" class="btn  btn-sm btn-raised btn-primary">
                                        <i class="fa fa-file-excel-o"> Export Vehicle Install</i>
                                    </button>
                                </a>
                                <a href="<?php echo base_url('vehicle/vehicle_uninstall_excel'); ?>">
                                    <button type="button" class="btn  btn-sm btn-raised btn-primary">
                                        <i class="fa fa-file-excel-o"> Export Vehicle Uninstall</i>
                                    </button>
                                </a>                       
                            </div>
                        </div>
                    </div>
                        <div class="panel-body">
                            <p>Data Vehicle Install GPS</p>
                            <div class="responsive-table">
                                <table id="datatables-example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width: 10px;" align="center" >No.</th>
                                        <th>Name</th>
                                        <th>Police</th>
                                        <th>Flank</th>
                                        <th>Status</th>
                                        <th>Install</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no = 1;
                                            foreach ($vehicle as $v):
                                    ?>
                                    <tr>
                                        <td align="center"><?= $no; ?></td>
                                        <td><?= $v->veh_name; ?></td>
                                        <td><?= $v->veh_number_police; ?></td>
                                        <td><?= $v->veh_number_flank; ?></td>
                                        <td><i class="label label-success"><?= $v->veh_status;  ?> GPS</i></td>
                                        <td><?= $v->veh_install_date; ?></td>
                                        <td>
                                            <a href="javascript:void(0)" onclick="detail_vehicle('<?php echo $v->veh_id; ?>')" class="btn btn-xs btn-default"data-toggle="tooltip" data-placement="right" title="Read Data"><span ><i class="glyphicon glyphicon-list-alt"></i></span> </a>
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
                        <div class="panel-body">
                            <p>Data Vehicle Uninstall GPS</p>
                            <div class="responsive-table">
                                <table class="table table-striped table-bordered datatables" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width: 10px;" align="center" >No.</th>
                                        <th>Name</th>
                                        <th>Police</th>
                                        <th>Flank</th>
                                        <th>Status</th>
                                        <!--<th>Install</th>-->
                                        <th>Uninstall</th>
                                        <!--<th>Created</th>
                                        <th>Modified</th>
                                        <th>User By</th>-->
                                        <th style="width: 160px;" align="center"><center>Action</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no = 1;
                                            foreach ($vehicleUn as $v):
                                    ?>
                                    <tr>
                                        <td align="center"><?= $no; ?></td>
                                        <td><?= $v->veh_name; ?></td>
                                        <td><?= $v->veh_number_police; ?></td>
                                        <td><?= $v->veh_number_flank; ?></td>
                                        <td><i class="label label-warning"><?= $v->veh_status;  ?> GPS</i></td>
                                        <!--<td><?= $v->veh_install_date; ?></td>-->
                                        <td><?= $v->veh_uninstall_date; ?></td>
                                        <!--<td><?= $v->veh_insert; ?></td>
                                        <td><?= $v->veh_update; ?></td>
                                        <td><?= $v->veh_user; ?></td>-->
                                        <td>
                                            <center>
                                            <a href="<?php echo base_url(); ?>vehicle/detail/<?php echo $v->veh_id; ?>" class="btn btn-xs btn-default"data-toggle="tooltip" data-placement="right" title="Detail Vehicle"><span ><i class="glyphicon glyphicon-list-alt"></i></span> </a>
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

<!---########################################################### Modal Jquery Detail Order ################################################################## -->
<div class="modal fade" id="modal_detail" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Detail Vehicle</h3>
            </div>
                <div class="modal-body form">
                    <div class="row">
                        <input type="hidden" value="" name="id"/>
                        <div class="col-md-4">
                          <span><b>Vehicle Name</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_veh_name"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Vehicle Number Police</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_veh_number_police"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Vehicle Number Flank</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_veh_number_flank"></div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Vehicle Status</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_veh_status"></div>
                        </div>

                        <div class="install">
                            <div class="col-md-4">
                              <span><b>Date Install</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_veh_install_date"></div>
                            </div>
                        </div>

                        <div class="uninstall">
                            <div class="col-md-4">
                              <span><b>Date Uninstall</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_veh_uninstall_date"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Vehicle Type Order</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_veh_install_type_business"></div>
                        </div>

                        <div class="expiry">
                            <div class="col-md-4">
                              <span><b>Expiry Date</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_veh_expiry_date"></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                          <span><b>Vehicle Remarks</b></span>
                        </div>
                        <div class="col-md-8">
                          <div class="detail_veh_remarks"></div>
                        </div>

                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
        </div>
    </div>
</div>
<!---########################################################### End Modal Jquery Detail Order ################################################################## -->

    <script type="text/javascript">
    
    /////////////////////////////////////////////// Modal Jquery Detail Vehicle ///////////////////////////////////////////////////////
    function detail_vehicle(id)
    {
        $('.help-block').empty(); 

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('vehicle/ajax_detail/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                if(data.veh_status == 'Installed')
                {
                    $('[name="id"]').val(data.veh_id);
                    
                    $('.detail_veh_name').html(data.veh_name);
                    $('.detail_veh_number_police').html(data.veh_number_police);
                    $('.detail_veh_number_flank').html(data.veh_number_flank);
                    $('.detail_veh_install_date').html(data.veh_install_date);
                    $('.detail_veh_remarks').html(data.veh_remarks);
                    $('.uninstall').hide();
                    $('.detail_veh_status').html(data.veh_status);

                    if (data.veh_install_type_business == '1')
                    {
                      $('.detail_veh_install_type_business').html('Purchase Order');
                      $('.expiry').hide();
                    }
                    else
                    {
                      $('.detail_veh_install_type_business').html('Trial Order');
                      $('.expiry').show();
                      $('.detail_veh_expiry_date').html(data.veh_expiry_date);
                    }
                }
                else
                {
                    $('[name="id"]').val(data.veh_id);
                    
                    $('.detail_veh_name').html(data.veh_name);
                    $('.detail_veh_number_police').html(data.veh_number_police);
                    $('.detail_veh_number_flank').html(data.veh_number_flank);
                    $('.install').hide();
                    $('.detail_veh_uninstall_date').html(data.veh_uninstall_date);
                    $('.detail_veh_remarks').html(data.veh_remarks);
                    $('.detail_veh_status').html(data.veh_status);

                    if (data.veh_install_type_business == '1')
                    {
                      $('.detail_veh_install_type_business').html('Purchase Order');
                      $('.expiry').hide();
                    }
                    else
                    {
                      $('.detail_veh_install_type_business').html('Trial Order');
                      $('.expiry').show();
                      $('.detail_veh_expiry_date').html(data.veh_expiry_date);
                    }
                }
                    
                $('#modal_detail').modal('show'); // show bootstrap modal when complete loaded
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    /////////////////////////////////////////////// End Modal Jquery Detail Vehicle ///////////////////////////////////////////////////////
    </script>
