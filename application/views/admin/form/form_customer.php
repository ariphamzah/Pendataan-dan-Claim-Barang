<?php
	$id_customer = '';
	$nama_customer = '';
	$lokasi = '';
  $flag = 0;
  $link = base_url('admin/proses_customer_insert');

	if(isset($data_customer)){
		foreach($data_customer as $d){
      $id_customer=$d->id_customer;
      $nama_customer=$d->nama_customer;
      $lokasi=$d->lokasi;
      $flag = 1;
      $link=base_url('admin/proses_customer_update');
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

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Input List Customer
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">List Customer</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="container">
            <div class="box box-primary" style="width:94%;">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-archive" aria-hidden="true"></i><?= ($flag == 0 )?' Tambah':' Edit' ?> List Customer</h3>
              </div>
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
                      <label for="nama_customer" style="margin-right:120px;">Nama Customer</label>
                      <input type="text" name="nama_customer" style="width:60%;display:inline;" class="form-control responsive" id="nama_customer" value="<?= $nama_customer ?>" placeholder="Nama Customer">
                    </div>
                    <div class="form-group">
                      <input type="hidden" name="id_customer" value="<?= $id_customer ?>">
                      <label for="lokasi" style="margin-right:118px;">Lokasi Customer</label>
                      <input type="text" name="lokasi" style="width:60%;display:inline;" class="form-control responsive" id="lokasi" value="<?= $lokasi ?>" placeholder="Lokasi Customer">
                    </div>
                    <center>
                    <div class="form-group" style=" margin-top:50px; margin-bottom:50px;">
                      <button type="reset" class="btn btn-basic" name="btn_reset" style="width:95px; margin-right:20px; responsive"><i class="fa fa-eraser" aria-hidden="true"></i> Reset</button>
                      <button type="submit" style="width:95px; responsive" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i> Submit</button>
                    </div>
                    </center>
                    <!-- /.box-body -->
                    <div class="box-footer" style="width:90%;">
                      <a type="button" class="btn btn-default" style="margin-right:5px; responsive" onclick="history.back(-1)" name="btn_kembali"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a>
                      <a type="button" class="btn btn-info" style="margin-right:29% display:inline; responsive" href="<?=base_url('admin/tabel_customer')?>" name="btn_listcustomer"><i class="fa fa-table" aria-hidden="true"></i> Lihat customer</a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>