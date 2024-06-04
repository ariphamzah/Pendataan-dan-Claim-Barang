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
        Tambah Barang Keluar
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?=base_url('admin/tabel_barangmasuk')?>">Tables</a></li>
        <li class="active">Tambah Barang Keluar</li>
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
                <h3 class="box-title"><i class="fa fa-archive" aria-hidden="true"></i> Tambah Barang Keluar</h3>
              </div>
              <div class="container">
                <form action="<?=base_url('admin/proses_data_keluar')?>" role="form" method="post">
                  <?php if(validation_errors()){ ?>
                    <div class="alert alert-warning alert-dismissible">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Warning!</strong><br> <?php echo validation_errors(); ?>
                    </div>
                  <?php } ?>

                  <div class="box-body">
                    <div class="form-group">
                      <?php foreach($list_data as $d){ ?>
                      <label for="id_transaksi" style="margin-right:97px;">ID Transaksi</label>
                      <input type="text" name="id_transaksi" style="width:60%;display:inline;" class="form-control responsive" readonly="readonly" value="<?=$d->id_transaksi?>">
                    </div>
                    <div class="form-group">
                      <label for="tanggal" style="margin-right:74px;">Nama Customer</label>
                      <input type="text" name="customer" style="width:60%;display:inline;" class="form-control responsive">
                    </div>
                    <div class="form-group">
                      <label for="tanggal" style="margin-right:81px;">Tanggal Masuk</label>
                      <input type="text" name="tanggal" style="width:60%;display:inline;" class="form-control responsive" readonly="readonly" value="<?=$d->tanggal?>">
                    </div>
                    <div class="form-group">
                      <label for="tanggal_keluar" style="margin-right:80px;">Tanggal Keluar</label>
                      <input type="date" name="tanggal_keluar" style="width:60%;display:inline;" class="form-control responsive" required="" placeholder="Klik Disini">
                    </div>
                    <div class="form-group">
                      <label for="lokasi" style="margin-right:132px;">Lokasi</label>
                      <input type="text" name="lokasi" style="width:60%;display:inline;" class="form-control responsive" >
                    </div>
                    <div class="form-group">
                      <label for="merk_barang" style="margin-right:94px;">Merk Barang</label>
                      <input type="text" name="merk_barang" readonly="readonly" style="width:60%;display:inline;" class="form-control responsive" id="merk_barang" value="<?=$d->merk?>">
                    </div>
                    <div class="form-group">
                      <label for="kode_barang" style="margin-right:33px;">Kode Barang / Barcode</label>
                      <input type="text" name="kode_barang" readonly="readonly" style="width:60%;display:inline;" class="form-control responsive" id="kode_barang" value="<?=$d->kode_barang?>">
                    </div>
                    <div class="form-group">
                      <label for="nama_Barang" style="margin-right:89px;">Nama Barang</label>
                      <input type="text" name="nama_barang" readonly="readonly" style="width:60%;display:inline;" class="form-control responsive" id="nama_Barang" value="<?=$d->nama_barang?>">
                    </div>
                    <div class="form-group">
                      <label for="satuan" style="margin-right:129px;">Satuan</label>
                      <select class="form-control responsive" name="satuan" style="width:60%;display:inline;" readonly="readonly">
                        <?php foreach($list_satuan as $s){?>
                          <?php if($d->satuan == $s->nama_satuan){?>
                        <option value="<?=$d->satuan?>" readonly="readonly" selected=""><?=$d->satuan?></option>
                        <?php }else{?>
                        <option value="<?=$s->kode_satuan?>" readonly="readonly"><?=$s->nama_satuan?></option>
                          <?php } ?>
                          <?php } ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="jumlah" style="margin-right:126px;">Jumlah</label>
                      <input type="number" name="jumlah" style="width:60%;display:inline;" class="form-control responsive" id="jumlah" max="<?=$d->jumlah?>" value="<?=$d->jumlah?>">
                    </div>
                    <?php } ?>

                    <div class="box-footer" style="width:90%;">
                      <a type="button" class="btn btn-default" style="margin-right:5px; responsive" onclick="history.back(-1)" name="btn_kembali"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a>
                      <button type="submit" style="width:95px; responsive" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i> Submit</button>&nbsp;&nbsp;&nbsp;
                    </div>
                  </div>
                </form>
              <!-- </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>