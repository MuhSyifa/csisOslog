<div class="col-md-12 nav-wrapper">
  <div class="navbar-header" style="width:100%;">
    <div class="opener-left-menu is-open">
      <span class="top"></span>
        <span class="middle"></span>
        <span class="bottom"></span>
    </div>
    <a href="<?php echo base_url('dashboard');?>" class="navbar-brand"> 
      CSIS
    </a>

    <ul class="nav navbar-nav navbar-right user-nav">
      <li class="user-name"><span><b>Welcome</b>, <?php echo $_SESSION['name'];?></span></li>
      <li class="dropdown avatar-dropdown">
        <img src="<?php echo base_url('assets/img/avatar.jpg'); ?>" class="img-circle avatar" alt="user name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"/>
        <ul class="dropdown-menu user-dropdown">
          <li style="margin-bottom: 12px;"><a href="<?php echo base_url('dashboard/changepwd');?>"><span class="fa fa-user"></span> Change Password</a></li>
          <li class="more">
            <ul>
              <li>
                <div class="row">
                  <div class="col-md-4"></div>
                  <div class="col-md-4"></div>
                  <div class="col-md-12"><a href="<?php echo base_url('dashboard/logout');?>"><span class="fa fa-power-off "></span> Logout</a></div>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      <li ><a class=""><span class="fa fa"></span></a></li>
    </ul>
  </div>
</div>