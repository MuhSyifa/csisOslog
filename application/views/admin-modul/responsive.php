<div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
  <ul class="nav nav-list" style="margin-bottom: 25%;">
    <li class="active ripple">
      <a href="<?php echo base_url('dashboard'); ?>"><span class="fa-home fa"></span>Dashboard</a>
    </li>

    <li class="ripple"><a href="<?php echo base_url('vendor/vendor_list'); ?>">
      <span class="glyphicon glyphicon-list-alt"></span> Vendor</a>
    </li>
    
    <li class="ripple">
      <a class="tree-toggle nav-header">
        <span class="fa fa-pencil-square"></span>GSM
        <span class="fa-angle-right fa right-arrow text-right"></span>
      </a>
      <ul class="nav nav-list tree">
        <li><a href="<?php echo base_url('gsm/gsm_list'); ?>">GSM Received</a></li>
        <li><a href="<?php echo base_url('gsm/gsm_active_list'); ?>">GSM Activated</a></li>
        <li><a href="<?php echo base_url('gsm/gsm_disable_list'); ?>">GSM Disabled</a></li>
      </ul>
    </li>

    <li class="ripple">
      <a class="tree-toggle nav-header">
        <span class="fa fa-pencil-square"></span>GPS
        <span class="fa-angle-right fa right-arrow text-right"></span>
      </a>
      <ul class="nav nav-list tree">
        <li><a href="<?php echo base_url('gps/gps_list'); ?>">GPS Received</a></li>
        <li><a href="<?php echo base_url('gpsDetail/gps_detail_lists'); ?>">GPS Detail</a></li>
        <li><a href="<?php echo base_url('gpstype/gps_type_list'); ?>">GPS Type</a></li>
        <!--<li><a href="<?php echo base_url('gpsType/gps_list'); ?>">GPS Condition</a></li>-->
      </ul>
    </li>

    <li class="ripple"><a href="<?php echo base_url('vehicle/vehicle_list'); ?>">
      <span class="fa fa-truck"></span>Vehicle</a>
    </li>

    <li class="ripple"><a class="tree-toggle nav-header">
      <span class="fa fa-wrench"></span> Orders  <span class="fa-angle-right fa right-arrow text-right"></span> </a>
      <ul class="nav nav-list tree">
        <li><a href="<?= base_url('order/order_list'); ?>">Install</a></li>
        <li><a href="<?= base_url('order/uninstall_list'); ?>">Uninstall</a></li>
      </ul>
    </li>

    <li class="ripple"><a class="tree-toggle nav-header">
      <span class="fa fa-cogs"></span> Maintenance  <span class="fa-angle-right fa right-arrow text-right"></span> </a>
      <ul class="nav nav-list tree">
        <li><a href="<?= base_url('reinstall/reinstall_list'); ?>">Reinstallation</a></li>
      </ul>
    </li>

    <li class="ripple"><a class="tree-toggle nav-header">
      <span class="fa fa-users"></span> Customer  <span class="fa-angle-right fa right-arrow text-right"></span> </a>
      <ul class="nav nav-list tree">
        <li><a href="<?php echo base_url('customer/customer_personal_list'); ?>">Customer Personal</a></li>
        <li><a href="<?php echo base_url('customer/customer_company_list'); ?>">Customer Compnay</a></li>
        <li><a href="<?php echo base_url('customer_business_type/customer_business_type_list'); ?>">Business Type</a></li>
        <!--<li><a href="<?php echo base_url('customer_type/customer_type_list'); ?>">Customer Type</a></li>
        <li><a href="<?php echo base_url('customer_religion/customer_religion_list'); ?>">Customer Religion</a></li>-->
      </ul>
    </li>

    <li class="ripple"><a class="tree-toggle nav-header">
      </span><span class="icons icon-people"></span> Employee  <span class="fa-angle-right fa right-arrow text-right"></span> </a>
      <ul class="nav nav-list tree">
        <li><a href="<?php echo base_url('employee/employee_list'); ?>">Employee</a></li>
        <li><a href="<?php echo base_url('department/department_list'); ?>">Department</a></li>
        <li><a href="<?php echo base_url('position/position_list'); ?>">Position</a></li>
      </ul>
    </li>

    <li class="ripple"><a href="<?php echo base_url('users/user_list'); ?>">
      <span class="fa fa-user"></span>Users</a>
    </li>

  </ul>
</div>