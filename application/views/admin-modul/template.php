<!-- Start Header -->
<?php $this->load->view('admin-modul/header'); ?>
<!-- End Header -->

<!-- Start Main Menu -->
    <body id="mimin" class="dashboard">
    <nav class="navbar navbar-default header navbar-fixed-top">
        
            <?php $this->load->view('admin-modul/nav'); ?>

    </nav>
<!-- End Main Menu -->

<!-- Start Menu Left -->
    <div id="left-menu">
        <?php $this->load->view('admin-modul/menu_left'); ?>    
    </div>
<!-- End Menu Left -->

<!-- Start Container -->
    <?php $this->load->view($content); ?>
<!-- /.container -->

<!-- start: right menu -->
    <div id="right-menu">
        <?php //$this->load->view('menu_right'); ?>
    </div>  
<!-- end: right menu -->

<!-- start: Mobile -->
    <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <?php $this->load->view('admin-modul/responsive'); ?>
        </div>       
    </div>
    <button id="mimin-mobile-menu-opener" class="animated rubberBand btn btn-circle btn-danger">
        <span class="fa fa-bars"></span>
    </button>
<!-- end: Mobile -->
    
<!-- Start Footer -->
<?php $this->load->view('admin-modul/footer'); ?>
<!-- End Footer -->