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
        Tabel Barang Keluar
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url('admin')?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Tables</li>
        <li class="active"><a href="<?=base_url('admin/tabel_barangkeluar')?>">Tabel Barang Keluar</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-table" aria-hidden="true"></i> Stok Barang Masuk</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <?php if($this->session->flashdata('msg_berhasil')){ ?>
                <div class="alert alert-success alert-dismissible" style="width:100%">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong><br> <?php echo $this->session->flashdata('msg_berhasil');?>
               </div>
              <?php } $id_transaksi = ""; ?>

              <?php if($this->session->userdata('role') == 1){ ?>
              <a href="<?=base_url('admin/tabel_barangmasuk')?>" style="margin-bottom:10px;" type="button" class="btn btn-primary" name="tambah_data"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data Keluar</a>
              <?php } ?>
              <a href="<?=base_url('report/invoice/'.$id_transaksi)?>" style="margin-bottom:10px;" type="button" class="btn btn-danger"><i class="fa fa-file-text" aria-hidden="true"></i> Invoice Manual</a>
              <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>ID Transaksi</th>
                  <th>Nama Customer</th>
                  <th>Tanggal Masuk</th>
                  <th>Tanggal Keluar</th>
                  <th>Lokasi</th>
                  <th>Merk barang</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Satuan</th>
                  <th>Jumlah</th>
                  <?php if($this->session->userdata('role') == 1){ ?>
                  <th>Invoice</th>
                  <?php } ?>
                  <!-- <th></th> -->
                </tr>
                </thead>
                <tbody>
                <tr>
                  <?php if(is_array($list_data)){ ?>
                  <?php $no = 1;?>
                  <?php foreach($list_data as $dd): ?>
                    <td><?=$no?></td>
                    <td><?=$dd->id_transaksi?></td>
                    <td><?=$dd->nama_customer?></td>
                    <td><?=$dd->tanggal_masuk?></td>
                    <td><?=$dd->tanggal_keluar?></td>
                    <td><?=$dd->lokasi?></td>
                    <td><?=$dd->merk?></td>
                    <td><?=$dd->kode_barang?></td>
                    <td><?=$dd->nama_barang?></td>
                    <td><?=$dd->satuan?></td>
                    <td><?=$dd->jumlah?></td>
                    <?php if($this->session->userdata('role') == 1){ ?>
                    <td><a type="button" class="btn btn-danger btn-report"  href="<?=base_url('report/invoice/'.$dd->id_transaksi)?>" name="btn_report" style="margin:auto;"><i class="fa fa-file-text" aria-hidden="true"></i></a></td>
                    <?php } ?>
                </tr>
              <?php $no++; ?>
              <?php endforeach;?>
              <?php }else { ?>
                    <td colspan="7" align="center"><strong>Data Kosong</strong></td>
              <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>No</th>
                  <th>ID Transaksi</th>
                  <th>Nama Customer</th>
                  <th>Tanggal Masuk</th>
                  <th>Tanggal Keluar</th>
                  <th>Lokasi</th>
                  <th>Merk barang</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Satuan</th>
                  <th>Jumlah</th>

                  <?php if($this->session->userdata('role') == 1){ ?>
                  <th>Invoice</th>
                  <?php } ?>
                </tr>
                </tfoot>
              </table>
              </div>
            </div>
          </div>
        <!-- </div> -->
      </div>
    </div>
  </section>
</div>