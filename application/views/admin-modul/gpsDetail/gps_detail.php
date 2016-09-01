
            <!-- start: Content -->
            <div id="content">
               <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                      <div class="col-md-6">
                        <h3 class="animated fadeInLeft">Details GPS</h3>
                        <p class="animated fadeInDown">
                            <a href="<?= base_url();?>">CSIS</a> <span class="fa-angle-right fa"></span>
                            <a href="<?= base_url('gps/gps_list');?>">GPS</a> <span class="fa-angle-right fa"></span>
                              Details GPS
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
                    <!-- <button class="btn btn-primary btn-xs" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                      <span data-toggle="tooltip" data-placement="right" title="Collapse for Action">Show</span>
                    </button> -->
                    <div class="collapse" id="collapseExample">
                        <div class="well">
                            <div class="col-md-9">
                              <a href="#" class="btn btn-sm btn-raised btn-primary" data-toggle="modal" data-target="#myModal">
                                <i class="glyphicon glyphicon-plus"></i> Add 
                              </a>
                            </div>
                            
                            <button type="button" class="btn  btn-sm btn-raised btn-primary" data-toggle="modal" data-target="#login-modal">
                              <i class="fa fa-file-excel-o"> Import</i>
                            </button>

                            <a href="<?php //echo base_url('gpstype/excel_type'); ?>" class="btn btn-raised btn-sm btn-primary"> 
                              <i class="fa fa-file-excel-o"> Export</i>
                            </a> 
                        </div>
                    </div>
                    </div>
                    <div class="panel-body">
                    <p><h3>Stock Received GPS</h3></p>
                      <div class="responsive-table">
                        <table id="datatables-example" class="table table-bordered table-striped" width="100%" cellspacing="0">
                            <thead>
                              <tr>
                                <td style="width: 10px;" align="center">No.</td>
                                <td>Type</td>
                                <td>Condition </td>
                                <td>Status</td>
                                <td>Quantity</td>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $no=1;
                                foreach ($gpsDetails as $v):
                              ?>
                              <tr>
                                <td align="center"><?= $no; ?> </td>
                                <td><?= $v->gps_type_name; ?> </td>
                                <td><?php echo $v->gps_cond_name; echo "& "; echo $v->gps_stat_name;?> </td>
                                <td><i class="label label-info"><?= $v->status ?></i></td>
                                <td><?= $v->gps_qty; ?></td>
                              </tr>
                              <?php
                                $no++;
                                endforeach;
                              ?>
                            </tbody>
                        </table>
                      </div>
                      <br /><br />

                      <p><h3>Stock Installed GPS</h3></p>
                      <div class="responsive-table">
                        <table class="table table-bordered table-striped datatables" width="100%" cellspacing="0">
                            <thead>
                              <tr>
                                <td style="width: 10px;" align="center">No.</td>
                                <td>Type</td>
                                <td>Condition </td>
                                <td>Status</td>
                                <td>Quantity</td>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $no=1;
                                foreach ($gpsDetailInstalls as $v):
                              ?>
                              <tr>
                                <td align="center"><?= $no; ?> </td>
                                <td><?= $v->gps_type_name; ?> </td>
                                <td><?php echo $v->gps_cond_name; echo "& "; echo $v->gps_stat_name;?> </td>
                                <td><i class="label label-success"><?= $v->status ?></i></td>
                                <td><?= $v->gps_qty; ?></td>
                              </tr>
                              <?php
                                $no++;
                                endforeach;
                              ?>
                            </tbody>
                        </table>
                      </div>
                      <br /><br />

                      
                      <p><h3>Stock Uninstalled GPS</h3></p>
                      <div class="responsive-table">
                        <table class="table table-bordered table-striped datatables" width="100%" cellspacing="0">
                            <thead>
                              <tr>
                                <td style="width: 10px;" align="center">No.</td>
                                <td>Type</td>
                                <td>Condition </td>
                                <td>Status</td>
                                <td>Quantity</td>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $no=1;
                                foreach ($gpsDetailUninstalls as $v):
                              ?>
                              <tr>
                                <td align="center"><?= $no; ?> </td>
                                <td><?= $v->gps_type_name; ?> </td>
                                <td><?php echo $v->gps_cond_name; echo "& "; echo $v->gps_stat_name;?> </td>
                                <td><i class="label label-warning"><?= $v->status ?></i></td>
                                <td><?= $v->gps_qty; ?></td>
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
          <!-- end: content -->
  
