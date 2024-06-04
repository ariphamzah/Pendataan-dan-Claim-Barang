<?php
	$id = '';
	$username = '';
	$email = '';
	$role = '';
  $flag = 0;
  $link = base_url('admin/proses_tambah_user');

	if(isset($list_data)){
		foreach($list_data as $d){
      $id=$d->id;
      $username=$d->username;
      $email=$d->email;
      $role=$d->role;
      $flag = 1;
      $link=base_url('admin/proses_update_user');
    }
	}
?>

<div class="wrapper">

  <header class="main-header">
    <?= $main_header ?>
  </header>

  <aside class="main-sidebar">
    <?= $sidebar ?>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tambah User
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">Satuan Barang</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <div class="container">
            <!-- general form elements -->
          <div class="box box-primary" style="width:94%;">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-fw fa-user" aria-hidden="true"></i><?= ($flag == 0 )?' Tambah':' Edit' ?> Users Data</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="container">
              <form action="<?= $link ?>" role="form" method="post">

                <?php if($this->session->flashdata('msg_berhasil')){ ?>
                  <div class="alert alert-success alert-dismissible" style="width:91%">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong><br> <?php echo $this->session->flashdata('msg_berhasil');?>
                  </div>
                <?php } ?>

                <?php if(validation_errors()){ ?>
                  <div class="alert alert-warning alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Warning!</strong><br> <?php echo validation_errors(); ?>
                  </div>
                <?php } ?>

                <div class="box-body">
                  <div class="form-group">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <label for="username" style="margin-right:96px;">Username</label>
                  <input type="text" name="username" style="width:60%;display:inline;" class="form-control responsive" id="username" value="<?= $username ?>" <?php if($username != ''){ ?> readonly="readonly" <?php } ?> placeholder="Username">
                  </div>
                  <div class="form-group">
                    <label for="email" style="margin-right:124px;">Email</label>
                    <input type="text" name="email" style="width:60%;display:inline;" class="form-control responsive" id="email" value="<?= $email ?>" placeholder="Email">
                </div>
                  <div class="form-group">
                    <label for="password" style="margin-right:100px;">Password</label>
                    <input type="password" name="password" style="width:60%;display:inline;" class="form-control responsive" id="password" placeholder="Password">
                </div>
                  <div class="form-group">
                    <label for="confirm_password" style="margin-right:47px;">Confirm Password</label>
                    <input type="password" name="confirm_password" style="width:60%;display:inline;" class="form-control responsive" id="confirm_password" placeholder="Confirm Password">
                </div>
                <div class="form-group">
                  <label for="role" style="margin-right:132px;">Role</label>
                  <select class="form-control responsive" name="role" style="width:60%;display:inline;">
                    <option>-- Pilih Role --</option>
                    <option value="0" <?= ($role == 0)?'selected':'' ?>>User Biasa</option>
                    <option value="1" <?= ($role == 1)?'selected':'' ?>>User Admin</option>
                  </select>
                </div>
                <!-- /.box-body -->
                <?php if(isset($token_generate)){ ?>
                  <input type="hidden" name="token"  class="form-control responsive" value="<?= $token_generate?>">
                <?php }else {
                  redirect(base_url('admin/form_user'));
                }?>

                <center>
                <div class="form-group" style=" margin-top:50px; margin-bottom:50px;">
                  <button type="submit" style="width:95px; responsive" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i> Submit</button>
                </div>
                </center>

                <div class="box-footer" style="width:90%;">
                  <a type="button" class="btn btn-default" style="margin-right:5px; responsive" onclick="history.back(-1)" name="btn_kembali"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a>
                  <a type="button" class="btn btn-info" style="margin-right:29% display:inline; responsive" href="<?=base_url('admin/users')?>" name="btn_listusers"><i class="fa fa-table" aria-hidden="true"></i> Lihat Users</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>