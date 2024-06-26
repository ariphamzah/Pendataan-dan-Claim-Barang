<a href="<?php echo base_url('admin') ?>" class="logo">
  <span class="logo-mini"><b>SON</b></span>
  <span class="logo-lg"><b>Stock Op Name</b></span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </a>

  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- User Account: style can be found in dropdown.less -->
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <img src="<?php echo base_url('assets/upload/user/img/' . $this->session->userdata('photo')) ?>" class="user-image" alt="User Image">
          <span class="hidden-xs"><?= $this->session->userdata('name') ?></span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
            <img src="<?php echo base_url('assets/upload/user/img/' . $this->session->userdata('photo')) ?>" class="img-circle" alt="User Image">
            <p>
              <?= $this->session->userdata('name') ?>
              <small>Last Login: <?= $this->session->userdata('last_login') ?></small>
            </p>
          </li>
          <!-- Menu Body -->

          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
              <a href="<?= base_url('admin/profile') ?>" class="btn btn-default btn-flat"><i class="fa fa-cogs" aria-hidden="true"></i> Profile</a>
            </div>
            <div class="pull-right">
              <a href="<?= base_url('admin/sigout') ?>" class="btn btn-default btn-flat"><i class="fa fa-sign-out" aria-hidden="true"></i> Sign out</a>
            </div>
          </li>
        </ul>
      </li>
      <!-- Control Sidebar Toggle Button -->
    </ul>
  </div>
</nav>