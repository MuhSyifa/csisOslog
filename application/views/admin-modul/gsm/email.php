<!-- start: Content -->
    <div id="content">
        <div class="panel box-shadow-none content-header">
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <h3 class="animated fadeInLeft">Email Activation</h3>
                        <p class="animated fadeInDown">
                            <a href="<?= base_url('dashboard'); ?>">CSIS</a> <span class="fa-angle-right fa"></span> <a href="<?= base_url('gsm/gsm_list'); ?>">GSM</a> <span class="fa-angle-right fa"></span> Email Activation
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

    <div class="form-element">
            <div class="col-md-12 padding-0">
                <div class="col-md-12">
                    <div class="panel form-element-padding">
                        <div class="panel-heading">
                            <h4>Email </h4>
                        </div>
                        <div class="panel-body" style="padding-bottom:30px;">
                        <form method="POST" action="<?php echo base_url('gsm/email'); ?>">
                        <?php echo validation_errors(); ?>
                            <div class="form-group">
                            <label for="name"><b>Your Name:</b></label>
                                <input type="text" name="nama" class="txtinput border-none box-shadow-none form-control" placeholder="your name.." required class="form-control" id="name">
                            <label for="to"><b>To:</b></label>
                                <input type="email" name="email" class="txtinput border-none box-shadow-none form-control" placeholder="email address.." required class="form-control" id="to">
                            <label for="subject"><b>Subject:</b></label>
                                <input type="text" name="subjek" class="txtinput border-none box-shadow-none form-control" placeholder="subject.." required class="form-control" id="subject">
                            </div>
                            
                            <textarea name='pesan' id='emailText' required></textarea>
                            
                            <div class="form-group" style="float:right;">
                                <input type="submit" name="submit" class="btn btn-primary" value="Send"/>
                                <a href="<?php echo base_url('gsm/gsm_list'); ?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                </a>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<!-- end: content -->
