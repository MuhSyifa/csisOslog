            <!-- start: Content -->
            <div id="content">
               <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                      <div class="col-md-6">
                        <h3 class="animated fadeInLeft"><font color="#007299"><b>Customer Support </b></font>Information System</h3>
                        <p class="animated fadeInDown"></span><h4><b>PT. Integrasia Utama</b></h4></p>
                        <p class="animated fadeInDown"><span class="fa  fa-map-marker"> Plaza Pondok Indah 5 D-09 Jalan Margaguna Raya Pondok Indah</p>
                        <p class="animated fadeInDown">Jakarta Selatan 12140, Indonesia</p>
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
                  <div class="col-md-6">
                    <div class="panel">
                           <div class="panel-heading-white panel-heading">
                              <h4>Pie Chart Received GPS</h4>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                 <div id="chartgpspie" ></div>                            
                                </div>
                            </div>
                      </div>
                  </div>

                  <div class="col-md-6">
                    <div class="panel">
                      <div class="panel-heading-white panel-heading">
                        <h4>Table Stock Received GPS</h4>
                      </div>
                      
                      <div class="panel-body">
                        <div class="responsive-table">
                          <table id="datatables-example" class="table table-bordred table-striped" width="100%" cellspacing="0">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Type </th>
                                <th>Condition </th>
                                <th>Status </th>
                                <th>Stock </th>
                              </tr>
                            </thead>
                            
                            <tbody>
                              <?php 
                                  $no = 1;
                                  foreach ($gpsStock as $v):
                              ?>
                              <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $v->gps_type_name; ?> </td>
                                <td><?php echo $v->gps_cond_name; ?></td>
                                <td><?php echo $v->gps_stat_name; ?></td>
                                <td><?php echo $v->gps_qty; ?> </td>
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

              <div class="col-md-12 top-20 padding-0">
                <div class="col-md-12">
                  <div class="col-md-6">
                    <div class="panel">
                       <div class="panel-heading-white panel-heading">
                        <h4>Pie Chart Installed GPS</h4>
                      </div>
                      <div class="panel-body">
                        <div class="col-md-12">
                          <div id="chartgpspieinstalled"></div>                            
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6 ">
                    <div class="panel">
                       <div class="panel-heading-white panel-heading">
                        <h4>Table Stock Installed GPS</h4>
                        </div>

                        <div class="panel-body">
                          <div class="responsive-table">
                            <table class="table table-bordred table-striped datatables" width="100%" cellspacing="0">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Type </th>
                                  <th>Condition </th>
                                  <th>Status </th>
                                  <th>Stock </th>
                                </tr>
                              </thead>

                              <tbody>
                              <?php 
                                $no = 1;
                                foreach ($gpsInstalled as $v):
                              ?>
                                <tr>
                                  <td><?php echo $no; ?></td>
                                  <td><?php echo $v->gps_type_name; ?> </td>
                                  <td><?php echo $v->gps_cond_name; ?></td>
                                  <td><?php echo $v->gps_stat_name; ?></td>
                                  <td><?php echo $v->gps_qty; ?> </td>
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