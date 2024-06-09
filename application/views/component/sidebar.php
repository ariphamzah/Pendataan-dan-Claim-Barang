<section class="sidebar">
  <!-- Sidebar user panel -->
  <div class="user-panel">
    <div class="pull-left image">
      <img src="<?php echo base_url('assets/upload/user/img/' . $this->session->userdata('photo')) ?>" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
      <p><?= $this->session->userdata('name') ?></p>
      <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
  </div>
  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu" data-widget="tree">
    <li class="header">MAIN NAVIGATION</li>
    <li>
      <a href="<?= base_url('admin') ?>">
        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        <span class="pull-right-container">
        </span>
      </a>
    </li>

    <?php if($this->session->userdata('role') == 1){ ?>

    <li class="treeview <?= ($nav != '0')?($nav != '9')?($nav != '4')?'':'active':'active':'active' ?>" href="<?= site_url('Welcome') ?>">
      <a href="#">
        <i class="fa fa-edit"></i> <span>Forms</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="<?= ($nav == '0')?'active':'' ?>"><a href="<?= base_url('admin/form_barangmasuk') ?>"><i class="fa fa-circle-o"></i> Barang Masuk</a></li>
        <li class="<?= ($nav == '4')?'active':'' ?>"><a href="<?= base_url('admin/form_customer') ?>"><i class="fa fa-circle-o"></i> Form Customer</a></li>
        <li class="<?= ($nav == '9')?'active':'' ?>"><a href="<?= base_url('admin/form_claimbarang') ?>"><i class="fa fa-circle-o"></i> Claim Barang</a></li>
      </ul>
    </li>

    <?php } ?>
    <li class="treeview <?= ($nav != '1')?($nav != '2')?($nav != '8')?($nav != '3')?'':'active':'active':'active':'active' ?>" href="<?= site_url('Welcome') ?>">
      <a href="#">
        <i class="fa fa-table"></i> <span>Tables</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li class="<?= ($nav == '1')?'active':'' ?>"><a href="<?= base_url('admin/tabel_barangmasuk') ?>"><i class="fa fa-circle-o"></i> Tabel Barang Masuk</a></li>
        <li class="<?= ($nav == '2')?'active':'' ?>"><a href="<?= base_url('admin/tabel_barangkeluar') ?>"><i class="fa fa-circle-o"></i> Tabel Barang Keluar</a></li>
        <li class="<?= ($nav == '8')?'active':'' ?>"><a href="<?= base_url('admin/tabel_claimbarang') ?>"><i class="fa fa-circle-o"></i> Tabel Claim Barang</a></li>

        <?php if($this->session->userdata('role') == 1){ ?>

        <li class="<?= ($nav == '3')?'active':'' ?>"><a href="<?= base_url('admin/tabel_customer') ?>"><i class="fa fa-circle-o"></i> Tabel Customer</a></li>

        <?php } ?>
      </ul>
      <li class="treeview <?= ($nav == '7')?'active':'' ?>">
        <a href="#">
          <i class="fa fa-edit"></i><span> Report</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="<?= ($nav == '7')?'active':'' ?>"><a href="<?php echo base_url('admin/report/0') ?>"><i class="fa fa-circle-o"></i> Report Barang</a></li>
        </ul>
      </li>
    </li>
    <li>
    <li class="header">LABELS</li>
    <li class="<?= ($nav == '5')?'active':'' ?>">
      <a href="<?php echo base_url('admin/profile') ?>">
        <i class="fa fa-cogs" aria-hidden="true"></i> <span>Profile</span></a>
    </li>

    <?php if($this->session->userdata('role') == 1){ ?>

    <li class="<?= ($nav == '6')?'active':'' ?>">
      <a href="<?php echo base_url('admin/users') ?>">
        <i class="fa fa-fw fa-users" aria-hidden="true"></i> <span>Users</span></a>
    </li>

    <?php } ?>
  </ul>
</section>