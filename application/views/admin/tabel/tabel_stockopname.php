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
        Tabel Stock Op Name
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url('admin')?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Tables</li>
        <li class="active"><a href="<?=base_url('admin/stock_op_name')?>">Tabel Stock Op Name</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-table" aria-hidden="true"></i> Stok Op Name</h3>
            </div>
            
            <div class="box-body">

              <div class="table-responsive">
              <table id="example1" class="table table-bordered">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Barang</th>
                  <th>Merk Barang</th>
                  <th>Satuan</th>
                  <th>Jumlah</th>
                </tr>
                </thead>
                <?php if(!empty($list_data)){ ?>
                <?php $no = 1;?>
                <?php foreach($list_data as $dd): ?>
                <?php $warna = $dd->jumlah < 5 ? 'bg-red' : ''; ?>
                <tbody class="<?php echo $warna; ?>">
                <tr>
                    <td><?=$no?></td>
                    <td><?=$dd->nama_barang?></td>
                    <td><?=$dd->merk?></td>
                    <td><?=$dd->satuan?></td>
                    <td><?=$dd->jumlah?></td>
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
                    <th>Nama Barang</th>
                    <th>Merk Barang</th>
                    <th>Satuan</th>
                    <th>Jumlah</th>
                  </tr>
                </tfoot>
              </table>
              </div>
            <!-- </div> -->
          </div>
        </div>
      </div>
    </div>
  </section>
</div>