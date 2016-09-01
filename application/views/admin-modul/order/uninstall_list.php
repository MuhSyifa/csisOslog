    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <h3 class="animated fadeInLeft">Data Uninstall</h3>
                        <p class="animated fadeInDown">
                            <a href="<?= base_url('dashboard');?>">CSIS</a> <span class="fa-angle-right fa"></span> Data Uninstall
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
                                <a href="<?php echo base_url('order/excel_order_uninstall'); ?>" class="btn btn-raised btn-primary btn-sm">
                                    <i class="fa fa-file-excel-o"></i> Export
                                </a>
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
                            foreach ($uninstall as $v):
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
                                        <a href="javascript:void(0)" onclick="detail_uninstall('<?php echo $v->odet_id; ?>')" class="btn btn-xs btn-default"data-toggle="tooltip" data-placement="right" title="Detail"><span ><i class="glyphicon glyphicon-list-alt"></i></span> </a>
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
    <div class="modal fade" id="modal_detail_unin" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Detail Uninstallation</h3>
                </div>
                    <div class="modal-body form">
                        <div class="row">
                            <input type="hidden" value="" name="id"/>
                            <div class="col-md-4">
                              <span><b>Type Number</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_unin_order_type"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>Number BAST/SPK</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_unin_order_number"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>Customer</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_unin_cust_code"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>Date Uninstallation</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_unin_odet_work_date"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>PIC Uninstallation</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_unin_odet_work_by"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>Vehicle Name</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_unin_veh_name"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>GPS IMEI Number</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_unin_gps_imei_number"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>GSM Number</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_unin_gsm_number"></div>
                            </div>

                            <div class="col-md-4">
                              <span><b>Status</b></span>
                            </div>
                            <div class="col-md-8">
                              <div class="detail_unin_odet_status"></div>
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
    /////////////////////////////////////////////// Modal Jquery Detail Uninstall ///////////////////////////////////////////////////////
    function detail_uninstall(id)
    {
        $('.help-block').empty(); 

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('order/ajax_uninstall_detail/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="id"]').val(data.odet_id);
                //$('[name="type"]').val(data.veh_install_type_business);

                $('.detail_unin_order_type').html(data.order_type_number);
                $('.detail_unin_order_number').html(data.order_number);
                $('.detail_unin_cust_code').html(data.cust_code);
                    
                //$('.detail_unin_order_location').html(data.order_location);
                $('.detail_unin_veh_name').html(data.veh_name);
                $('.detail_unin_odet_work_date').html(data.odet_work_date);
                $('.detail_unin_odet_work_by').html(data.odet_work_by);
                //$('.detail_unin_veh_expiry_date').html(data.veh_expiry_date);
                $('.detail_unin_gps_imei_number').html(data.gps_imei_number);
                $('.detail_unin_gsm_number').html(data.gsm_number);
                $('.detail_unin_odet_status').html(data.odet_status);                
                    
                $('#modal_detail_unin').modal('show'); // show bootstrap modal when complete loaded
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }
    /////////////////////////////////////////////// End Modal Jquery Detail Uninstall ///////////////////////////////////////////////////////
</script>