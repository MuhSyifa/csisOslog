<!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                  <div class="col-md-6">
                    <h3 class="animated fadeInLeft">Form Edit Customer Business Type</h3>
                      <p class="animated fadeInDown">
                        <a href="<?php echo base_url('dashboard'); ?>">CSIS</a> <span class="fa-angle-right fa"></span> <a href="<?php echo base_url('customer_business_type/customer_business_type_list'); ?>">Customer Business Type</a> <span class="fa-angle-right fa"></span> Form Edit Customer Religion
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
        <div class="form-element">
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel form-element-padding">
                        <div class="panel-body" style="padding-bottom:30px;">
                          
                        <?php echo form_open('customer_business_type/process_update'); ?>
                        <?php echo validation_errors(); ?>

                          <div class="form-group">
                            <label for="">Customer Type Name</label>
                            <input name="cust_business_name" value="<?= $data->cust_business_type_name; ?>" placeholder="Name" class="form-control" type="text" required>
                          </div>

                          <div class="form-controll">
                            <input type="hidden" name="cust_business_type_id" value="<?= $data->cust_business_type_id; ?>" class="form-control" id="" placeholder="">
                          </div>

                          <div class="form-group" style="float:right;">
                                <input type="submit" name="submit" class="btn btn-primary" value="Update"/>
                                <a href="<?php echo base_url('customer_business_type/customer_business_type_list'); ?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                </a>
                          </div>
                        <?php echo form_close(); ?>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- end: content -->