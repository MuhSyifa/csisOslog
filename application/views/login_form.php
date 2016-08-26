<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Customer Service Information System Integrasia Utama">
    <meta name="author" content="Integrasia Utama">
    <meta name="keyword" content="CSIS Integrasia Utama">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CSIS (Customer Service Information System) Integrasia Utama</title>

    <!-- start: Css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
    
    <!-- plugins -->  
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/plugins/font-awesome.min.css'); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/plugins/simple-line-icons.css'); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/plugins/animate.min.css'); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/plugins/fullcalendar.min.css'); ?>"/>
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo base_url('assets/img/logocsis.png');?>">
  </head>

  <body id="mimin" class="dashboard form-signin-wrapper">
    <div class="container">
      <form action="<?php echo base_url();?>index.php/login/do_login" method="post" class="form-signin">
        <div class="panel periodic-login">
          <span class="atomic-number"></span>
          <div class="panel-body text-center">
            <img src="<?php echo base_url('assets/img/integrasia-utama.png');?>" style="width: 250px; margin-top: 25%;" alt="">
            <font style="font-family: Serifs; font-size: 40px">CSIS</font><br>
            
            <i class="icons icon-arrow-down"></i><br><br>
            <p class="atomic-mass" style="font-size: 12px;">Customer Service Information System</p>
            <!--<h1 class="atomic-symbol"></h1>-->
              <div class="form-group form-animate-text" style="margin-top: 25%;">
                <input type="text" class="form-text" name="uname" required> <?php echo form_error('username');?>
                <span class="bar"></span>
                <label>Username</label>
              </div>
              <div class="form-group form-animate-text" style="margin-top:40px !important;">
                <input type="password" class="form-text" name="pass" id="passwordfield" required> <?php echo form_error('password');?>
                  <span class="bar"></span>
                  <label>Password</label>
              </div>
              <label class="pull-left">
                <i class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="right" title="Hold The Icon To Show Password!"> Show</i>
              </label>
              <br><br>
              <button style="height: 30px !important; width: 252px !important; " class="btn-flip btn-default btn-3d col-md-19" type="submit"  name="login" >
                <div class="flip">
                  <div class="side">
                    Login
                  </div>
                  <div class="side back">
                    <font color="black">You Will be Loged In!</font>
                  </div>
                </div>
              </button>
          </div>
        </div>
      </form>
    </div>
  <!-- end: Content -->

  <!-- start: Javascript -->
  <script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
  <script src="<?php echo base_url('assets/js/jquery.ui.min.js');?>"></script>
  <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
  <script src="<?php echo base_url('assets/js/plugins/moment.min.js');?>"></script>
  <script src="<?php echo base_url('assets/js/plugins/icheck.min.js');?>"></script>
  <script src="<?php echo base_url('assets/js/main.js');?>"></script>

  <!-- custom -->
  <script type="text/javascript">
    $(document).ready(function(){
      $('input').iCheck({
        checkboxClass: 'icheckbox_flat-aero',
        radioClass: 'iradio_flat-aero'
      });
    });
  </script>

  <!-- Show Password -->
  <script type="text/javascript">
  
    $("#passwordfield").on("keyup",function(){
      if($(this).val())
        $(".glyphicon-eye-open").show();
      else
        $(".glyphicon-eye-open").hide();
    });
    
    $(".glyphicon-eye-open").mousedown(function(){
      $("#passwordfield").attr('type','text');
    }).mouseup(function(){
      $("#passwordfield").attr('type','password');
    }).mouseout(function(){
      $("#passwordfield").attr('type','password');
    });
  
  </script>
     <!-- end: Javascript -->

  </body>
</html>