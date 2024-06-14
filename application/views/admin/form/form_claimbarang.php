<?php
	$id_claim = 'CLM-'.date("Y").random_string('numeric', 8);
	$tanggal = '';
	$customer = '';
	$mekanik = '';
	$merk_mesin = '';
	$type_mesin = '';
	$nomor_mesin = '';
	$nama_part = '';
  $jumlah = '';
  $penyebab_kerusakan = '';
  $status = '';
  $keterangan = '';
	$flag = 0;
  $link = base_url('admin/proses_databarang_claim_insert');

	if(isset($masuk)){
		foreach($masuk as $d){
      $id_claim=$d->id_claim;
      $tanggal=$d->tanggal_claim;
      $customer=$d->id_customer;
      $mekanik=$d->mekanik;
      $merk_mesin=$d->merk_mesin;
      $type_mesin=$d->type_mesin;
      $nomor_mesin=$d->nomor_mesin;
      $nama_part=$d->nama_part;
      $jumlah=$d->jumlah;
      $penyebab_kerusakan=$d->penyebab_kerusakan;
      $status=$d->status;
      $keterangan=$d->keterangan;
      $flag=1;
      $link=base_url('admin/proses_databarang_claim_update');
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
        Form Data Claim Barang
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">Data Claim Barang</li>
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
                <h3 class="box-title"><i class="fa fa-archive" aria-hidden="true"></i><?= ($flag == 0 )?' Tambah':' Edit' ?> Data Claim Barang</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <div class="container">
                <form action="<?= $link ?>" role="form" method="post">

                  <?php if ($this->session->flashdata('msg_berhasil')) { ?>
                    <div class="alert alert-success alert-dismissible" style="width:91%">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Success!</strong><br> <?php echo $this->session->flashdata('msg_berhasil'); ?>
                    </div>
                  <?php } ?>

                  <?php if (validation_errors()) { ?>
                    <div class="alert alert-warning alert-dismissible">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Warning!</strong><br> <?php echo validation_errors(); ?>
                    </div>
                  <?php } ?>

                  <div class="box-body">
                    <div class="form-group">
                      <label for="id_claim" style="margin-right:121px;">ID Claim</label>
                      <input type="text" name="id_claim" style="width:60%;display:inline;" class="form-control responsive" readonly="readonly" value="<?= $id_claim ?>">
                    </div>
                    <div class="form-group">
                      <label for="tanggal" style="margin-right:124px;">Tanggal</label>
                      <input type="date" name="tanggal" style="width:60%;display:inline;" class="form-control responsive" autocomplete="off" value="<?= $tanggal ?>">
                    </div>
                    <div class="form-group">
                      <label for="customer" style="margin-right:74px;">Nama Customer</label>
                      <select class="form-control" name="customer" style="width:60%;display:inline;" class="form-control responsive">
                      <option value="" selected="">-- Pilih --</option>
                        <?php foreach ($list_customer as $s) { ?>
                          <option value="<?= $s->id_customer ?>" <?= $customer==$s->id_customer?'selected':''; ?>><?= $s->nama_customer ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="mekanik" style="margin-right:120px;">Mekanik</label>
                      <input type="text" name="mekanik" style="width:60%; display:inline;" class="form-control responsive" id="mekanik" placeholder="Mekanik" value="<?= $mekanik ?>">
                    </div>
                    <div class="form-group">
                      <label for="merk_mesin" style="margin-right:102px;">Merk Mesin</label>
                      <input type="text" name="merk_mesin" style="width:60%; display:inline;" class="form-control responsive" id="merk_mesin" placeholder="Merk Mesin" value="<?= $merk_mesin ?>">
                    </div>
                    <div class="form-group">
                      <label for="type_mesin" style="margin-right:104px;">Type Mesin</label>
                      <input type="text" name="type_mesin" style="width:60%; display:inline;" class="form-control responsive" id="type_mesin" placeholder="Type Mesin" value="<?= $type_mesin ?>">
                    </div>
                    <div class="form-group">
                      <label for="nomor_mesin" style="margin-right:92px;">Nomor Mesin</label>
                      <input type="text" name="nomor_mesin" style="width:60%; display:inline;" class="form-control responsive" id="nomor_mesin" placeholder="Nomor Mesin" value="<?= $nomor_mesin ?>">
                    </div>
                    <div class="form-group">
                      <label for="nama_part" style="margin-right:108px;">Nama Part</label>
                      <input type="text" name="nama_part" style="width:60%; display:inline;" class="form-control responsive" id="nama_part" placeholder="Nama Part" value="<?= $nama_part ?>">
                    </div>
                    <div class="form-group">
                      <label for="jumlah" style="margin-right:126px;">Jumlah</label>
                      <input type="number" name="jumlah" style="width:60%;display:inline;" class="form-control responsive" id="jumlah" placeholder="Jumlah" value="<?= $jumlah ?>">
                    </div>
                    <div class="form-group">
                      <label for="penyebab_kerusakan" style="margin-right:44px;">Penyebab Kerusakan</label>
                      <input type="text" name="penyebab_kerusakan" style="width:60%; display:inline;" class="form-control responsive" id="penyebab_kerusakan" placeholder="Penyebab Kerusakan" value="<?= $penyebab_kerusakan ?>">
                    </div>
                    <?php if($flag == 1){ ?>
                      <div class="form-group">
                      <label for="status" style="margin-right:129px;">Status</label>
                      <select class="form-control responsive" name="status" style="width:60%;display:inline;">
                        <option value="" selected="">-- Pilih --</option>
                        <option value="Di Ajukan" <?= $status=='Di Ajukan'?'selected':''; ?>>Di Ajukan</option>
                        <option value="Di Proses" <?= $status=='Di Proses'?'selected':''; ?>>Di Proses</option>
                        <option value="Selesai" <?= $status=='Selesai'?'selected':''; ?>>Selesai</option>
                        <option value="Di Tolak" <?= $status=='Di Tolak'?'selected':''; ?>>Di Tolak</option>
                      </select>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                      <label for="keterangan" style="margin-right:102px;">Keterangan</label>
                      <input type="text" name="keterangan" style="width:60%; display:inline;" class="form-control responsive" id="keterangan" placeholder="Keterangan" value="<?= $keterangan ?>">
                    </div>

                    <center>
                    <div class="form-group" style=" margin-top:50px; margin-bottom:50px;">
                      <button type="reset" class="btn btn-basic" name="btn_reset" style="width:95px; margin-right:20px; responsive"><i class="fa fa-eraser" aria-hidden="true"></i> Reset</button>
                      <button type="submit" style="width:95px; responsive" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i> Submit</button>
                    </div>
                    </center>
                    <!-- /.box-body -->
                    <div class="box-footer" style="width: 90%;">
                      <a type="button" class="btn btn-default" style="margin-right:5px; responsive" onclick="history.back(-1)" name="btn_kembali"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a>
                      <a type="button" class="btn btn-info" style="margin-right:29% display:inline; responsive" href="<?= base_url('admin/tabel_claimbarang') ?>" name="btn_listbarang"><i class="fa fa-table" aria-hidden="true"></i> Lihat List Claim</a>
                    </div>
                  <!-- </div> -->
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>