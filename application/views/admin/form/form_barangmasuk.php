<?php
	$id_transaksi = 'WG-'.date("Y").random_string('numeric', 8);
	$tanggal = '';
	$lokasi = '';
	$merk = '';
	$kode_barang = '';
	$nama_barang = '';
	$satuan = '';
	$jumlah = '';
	$flag = 0;
  $link = base_url('admin/proses_databarang_masuk_insert');

	if(isset($masuk)){
		foreach($masuk as $d){
      $id_transaksi=$d->id_transaksi;
      $tanggal=$d->tanggal;
      $lokasi=$d->lokasi;
      $merk=$d->merk;
      $kode_barang=$d->kode_barang;
      $nama_barang=$d->nama_barang;
      $satuan=$d->id_satuan;
      $jumlah=$d->jumlah;
      $flag=1;
      $link=base_url('admin/proses_databarang_masuk_update');
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
        Form Data Barang Masuk
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">Data Barang Masuk</li>
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
                <h3 class="box-title"><i class="fa fa-archive" aria-hidden="true"></i><?= ($flag == 0 )?' Tambah':' Edit' ?> Data Barang Masuk</h3>
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
                      <label for="id_transaksi" style="margin-right:97px;">ID Transaksi</label>
                      <input type="text" name="id_transaksi" style="width:60%;display:inline;" class="form-control responsive" readonly="readonly" value="<?= $id_transaksi ?>">
                    </div>
                    <div class="form-group">
                      <label for="tanggal" style="margin-right:124px;">Tanggal</label>
                      <input type="date" name="tanggal" style="width:60%;display:inline;" class="form-control responsive" autocomplete="off" value="<?= $tanggal ?>">
                    </div>
                    <div class="form-group">
                      <label for="nama_barang" style="margin-right:132px;">Lokasi</label>
                      <select class="form-control responsive" name="lokasi" style="width:60%;display:inline;">
                        <option value="">-- Pilih --</option>
                        <option value="Aceh" <?= $lokasi=='Aceh'?'selected':''; ?>>Aceh</option>
                        <option value="Bali" <?= $lokasi=='Bali'?'selected':''; ?>>Bali</option>
                        <option value="Bengkulu" <?= $lokasi=='Bengkulu'?'selected':''; ?>>Bengkulu</option>
                        <option value="Jakarta" <?= $lokasi=='Jakarta'?'selected':''; ?>>Jakarta Raya</option>
                        <option value="Jambi" <?= $lokasi=='Jambi'?'selected':''; ?>>Jambi</option>
                        <option value="Jawa Tengah" <?= $lokasi=='Jawa Tengah'?'selected':''; ?>>Jawa Tengah</option>
                        <option value="Jawa Timur"  <?= $lokasi=='Jawa Timur'?'selected':''; ?>>Jawa Timur</option>
                        <option value="Jawa Barat" <?= $lokasi=='Jawa Barat'?'selected':''; ?>>Jawa Barat</option>
                        <option value="Papua" <?= $lokasi=='Papua'?'selected':''; ?>>Papua</option>
                        <option value="Yogyakarta" <?= $lokasi=='Yogyakarta'?'selected':''; ?>>Yogyakarta</option>
                        <option value="Kalimantan Barat" <?= $lokasi=='Kalimantan Barat'?'selected':''; ?>>Kalimantan Barat</option>
                        <option value="Kalimantan Selatan" <?= $lokasi=='Kalimantan Selatan'?'selected':''; ?>>Kalimantan Selatan</option>
                        <option value="Kalimantan Tengah" <?= $lokasi=='Kalimantan Tengah'?'selected':''; ?>>Kalimantan Tengah</option>
                        <option value="Kalimantan Timur" <?= $lokasi=='Kalimantan Timur'?'selected':''; ?>>Kalimantan Timur</option>
                        <option value="Lampung" <?= $lokasi=='Lampung'?'selected':''; ?>>Lampung</option>
                        <option value="NTB" <?= $lokasi=='NTB'?'selected':''; ?>>Nusa Tenggara Barat</option>
                        <option value="NTT" <?= $lokasi=='NTT'?'selected':''; ?>>Nusa Tenggara Timur</option>
                        <option value="Riau" <?= $lokasi=='Riau'?'selected':''; ?>>Riau</option>
                        <option value="Sulawesi Selatan" <?= $lokasi=='Sulawesi Selatan'?'selected':''; ?>>Sulawesi Selatan</option>
                        <option value="Sulawesi Utara" <?= $lokasi=='Sulawesi Utara'?'selected':''; ?>>Sulawesi Utara</option>
                        <option value="Sulawesi Tengah" <?= $lokasi=='Sulawesi Tengah'?'selected':''; ?>>Sulawesi Tengah</option>
                        <option value="Sulawesi Tenggara" <?= $lokasi=='Sulawesi Tenggara'?'selected':''; ?>>Sulawesi Tenggara</option>
                        <option value="Sumatera Barat" <?= $lokasi=='Sumatera Barat'?'selected':''; ?>>Sumatera Barat</option>
                        <option value="Sumatera Utara" <?= $lokasi=='Sumatera Utara'?'selected':''; ?>>Sumatera Utara</option>
                        <option value="Maluku" <?= $lokasi=='Maluku'?'selected':''; ?>>Maluku</option>
                        <option value="Maluku Utara" <?= $lokasi=='Maluku Utara'?'selected':''; ?>>Maluku Utara</option>
                        <option value="Banten" <?= $lokasi=='Banten'?'selected':''; ?>>Banten</option>
                        <option value="Gorontalo" <?= $lokasi=='Gorontalo'?'selected':''; ?>>Gorontalo</option>
                        <option value="Bangka" <?= $lokasi=='Bangka'?'selected':''; ?>>Bangka Belitung</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="id_transaksi" style="margin-right:94px;">Merk Barang</label>
                      <input type="text" name="merk_barang" style="width:60%;display:inline;" class="form-control responsive" id="merk_barang" placeholder="Merk Barang" value="<?= $merk ?>">
                    </div>
                    <div class="form-group">
                      <label for="kode_barang" style="margin-right:33px;">Kode Barang / Barcode</label>
                      <input type="text" name="kode_barang" style="width:60%;display:inline;" class="form-control responsive" id="kode_barang" placeholder="Kode Barang" value="<?= $kode_barang ?>">
                    </div>
                    <div class="form-group">
                      <label for="nama_Barang" style="margin-right:89px;">Nama Barang</label>
                      <input type="text" name="nama_barang" style="width:60%;display:inline;" class="form-control responsive" id="nama_Barang" placeholder="Nama Barang" value="<?= $nama_barang ?>">
                    </div>
                    <div class="form-group">
                      <label for="satuan" style="margin-right:129px;">Satuan</label>
                      <select class="form-control responsive" name="satuan" style="width:60%;display:inline;">
                        <option value="" selected="">-- Pilih --</option>
                        <?php foreach ($list_satuan as $s) { ?>
                          <option value="<?= $s->kode_satuan ?>" <?= $satuan==$s->kode_satuan?'selected':''; ?>><?= $s->nama_satuan ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="jumlah" style="margin-right:126px;">Jumlah</label>
                      <input type="number" name="jumlah" style="width:60%;display:inline;" class="form-control responsive" id="jumlah" value="<?= $jumlah ?>">
                    </div>
                    <center>
                    <div class="form-group" style=" margin-top:50px; margin-bottom:50px;">
                      <button type="reset" class="btn btn-basic" name="btn_reset" style="width:95px; margin-right:20px; responsive"><i class="fa fa-eraser" aria-hidden="true"></i> Reset</button>
                      <button type="submit" style="width:95px; responsive" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i> Submit</button>
                    </div>
                    </center>
                    <!-- /.box-body -->
                    <div class="box-footer" style="width: 90%;">
                      <a type="button" class="btn btn-default" style="margin-right:1px; responsive" onclick="history.back(-1)" name="btn_kembali"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a>
                      <a type="button" class="btn btn-info" style="margin-right:29% display:inline; responsive" href="<?= base_url('admin/tabel_claimbarang') ?>" name="btn_listbarang"><i class="fa fa-table" aria-hidden="true"></i> Lihat List Barang</a>
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