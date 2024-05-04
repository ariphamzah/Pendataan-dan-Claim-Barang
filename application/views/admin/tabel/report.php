<?php
  $months = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
  $years = date('Y');
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
        Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url('admin')?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li>Report</li> -->
        <li class="active"><a href="<?=base_url('admin/report')?>">Report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">

            <!-- <?php if($this->session->flashdata('msg_berhasil')){ ?>
              <div class="alert alert-success alert-dismissible" style="width:100%">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Success!</strong><br> <?php echo $this->session->flashdata('msg_berhasil');?>
              </div>
            <?php } ?>

            <?php if($this->session->flashdata('msg_berhasil_keluar')){ ?>
              <div class="alert alert-success alert-dismissible" style="width:100%">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>Success!</strong><br> <?php echo $this->session->flashdata('msg_berhasil_keluar');?>
              </div>
            <?php } ?> -->

            <a href="" style="margin-bottom:10px;" name=""></a>
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#barmas" data-toggle="tab">Report Barang Masuk</a></li>
                <li><a href="#barkel" data-toggle="tab">Report Barang Keluar</a></li>
              </ul>
              <div class="tab-content">

                <!-- Report Barang Keluar -->
                
                <div class="tab-pane" id="barkel">
                  <form class="form-horizontal" action="<?= site_url('Admin/report/1') ?>" method="post">
                    <?php if($this->session->flashdata('msg_berhasil')){ ?>
                      <div class="alert alert-success alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Success</strong><br> <?php echo $this->session->flashdata('msg_berhasil');?>
                      </div>
                    <?php } ?>

                    <?php if(validation_errors()){ ?>
                      <div class="alert alert-warning alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Warning!</strong><br> <?php echo validation_errors(); ?>
                      </div>
                    <?php } ?>
                    
                    <div class="col-sm-2">
                      <select class="form-control" name="month" id="month" required>
                        <option value="">Month</option>
                        <?php for($m=0;$m<12;$m++){ ?>
                        <option value="<?= $m + 1 ?>" <?= ($flag == 2)?($months[$m] == $months[$month - 1])?'selected':'':''; ?>><?= $months[$m] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-sm-2">
                      <select class="form-control" name="year" id="year" required>
                        <option value="">Year</option>
                        <?php for($y=0;$y<3;$y++){ ?>
                        <option value="<?= $years - $y ?>" <?= ($flag == 2)?($years - $y == $year)?'selected':'':''; ?>><?= $years - $y ?></option>
                        <?php } ?>
                      </select>

                    </div>

                    <div class="col-sm-2">
                      <input type="submit" value="Submit" class="btn btn-success" name="submit">
                    </div>

                    <h3>Report Periode, <?= ($flag == 2)?$months[$month - 1]:'' ?> - <?= ($flag == 2)?$year:'' ?></h3>

                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>No</th>
                        <th>ID Transaksi</th>
                        <th>Nama Curtomer</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Keluar</th>
                        <th>Lokasi</th>
                        <th>Merk barang</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Jumlah</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr>
                        <?php if($flag == 2){if(is_array($barkel)){ ?>
                        <?php $no = 1;?>
                        <?php foreach($barkel as $dd): ?>
                          <td><?=$no?></td>
                          <td><?=$dd->id_transaksi?></td>
                          <td><?=$dd->customer?></td>
                          <td><?=$dd->tanggal_masuk?></td>
                          <td><?=$dd->tanggal_keluar?></td>
                          <td><?=$dd->lokasi?></td>
                          <td><?=$dd->merk?></td>
                          <td><?=$dd->kode_barang?></td>
                          <td><?=$dd->nama_barang?></td>
                          <td><?=$dd->nama_satuan?></td>
                          <td><?=$dd->jumlah?></td>
                      </tr>
                    <?php $no++; ?>
                    <?php endforeach;?>
                    <?php }else { ?>
                          <td colspan="7" align="center"><strong>Data Kosong</strong></td>
                    <?php }}else{ ?>
                          <td colspan="7" align="center"><strong>Data Kosong</strong></td>
                    <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>No</th>
                          <th>ID Transaksi</th>
                          <th>Nama Curtomer</th>
                          <th>Tanggal Masuk</th>
                          <th>Tanggal Keluar</th>
                          <th>Lokasi</th>
                          <th>Merk barang</th>
                          <th>Kode Barang</th>
                          <th>Nama Barang</th>
                          <th>Satuan</th>
                          <th>Jumlah</th>
                        </tr>
                      </tfoot>
                    </table>

                  </form>
                </div>

                <!-- Report Barang Masuk -->
                <div class="tab-pane active" id="barmas">
                  <form class="form-horizontal" action="<?= site_url('Admin/report/2') ?>" method="post">
                    <?php if($this->session->flashdata('msg_berhasil')){ ?>
                      <div class="alert alert-success alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Success</strong><br> <?php echo $this->session->flashdata('msg_berhasil');?>
                      </div>
                    <?php } ?>

                    <?php if(validation_errors()){ ?>
                      <div class="alert alert-warning alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Warning!</strong><br> <?php echo validation_errors(); ?>
                      </div>
                    <?php } ?>
                    
                    <div class="col-sm-2">
                      <select class="form-control" name="month" id="month" required>
                        <option value="">Month</option>
                        <?php for($m=0;$m<12;$m++){ ?>
                        <option value="<?= $m + 1 ?>" <?= ($flag == 1)?($months[$m] == $months[$month - 1])?'selected':'':''; ?>><?= $months[$m] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-sm-2">
                      <select class="form-control" name="year" id="year" required>
                        <option value="">Year</option>
                        <?php for($y=0;$y<3;$y++){ ?>
                        <option value="<?= $years - $y ?>" <?= ($flag == 1)?($years - $y == $year)?'selected':'':''; ?>><?= $years - $y ?></option>
                        <?php } ?>
                      </select>

                    </div>

                    <div class="col-sm-2">
                      <input type="submit" value="Submit" class="btn btn-success" name="submit-masuk">
                    </div>

                    <h3>Report Periode, <?= ($flag == 1)?$months[$month - 1]:'' ?> - <?= ($flag == 1)?$year:'' ?></h3>

                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>No</th>
                        <th>ID_Transaksi</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Merk Barang</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Jumlah</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr>
                        <?php if($flag == 1){if(is_array($barmas)){ ?>
                        <?php $no = 1;?>
                        <?php foreach($barmas as $dd): ?>
                          <td><?=$no?></td>
                          <td><?=$dd->id_transaksi?></td>
                          <td><?=$dd->tanggal?></td>
                          <td><?=$dd->lokasi?></td>
                          <td><?=$dd->merk?></td>
                          <td><?=$dd->kode_barang?></td>
                          <td><?=$dd->nama_barang?></td>
                          <td><?=$dd->nama_satuan?></td>
                          <td><?=$dd->jumlah?></td>
                      </tr>
                    <?php $no++; ?>
                    <?php endforeach;?>
                    <?php }else { ?>
                          <td colspan="7" align="center"><strong>Data Kosong</strong></td>
                    <?php }}else{ ?>
                          <td colspan="7" align="center"><strong>Data Kosong</strong></td>
                    <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>No</th>
                          <th>ID_Transaksi</th>
                          <th>Tanggal</th>
                          <th>Lokasi</th>
                          <th>Merk Barang</th>
                          <th>Kode Barang</th>
                          <th>Nama Barang</th>
                          <th>Satuan</th>
                          <th>Jumlah</th>
                        </tr>
                      </tfoot>
                    </table>

                  </form>
                </div>
              </div>
            </div>
              
          <!-- </div> -->
        </div>
      </div>
    </div>
  </section>
</div>