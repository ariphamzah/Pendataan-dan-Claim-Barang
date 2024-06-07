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
        Tabel Claim Barang 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url('admin')?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Tables</li>
        <li class="active"><a href="<?=base_url('admin/tabel_barangmasuk')?>">Tabel Claim Barang</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-table" aria-hidden="true"></i> Stok Claim Barang</h3>
            </div>
            
            <div class="box-body">

              <?php if($this->session->flashdata('msg_berhasil')){ ?>
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
              <?php } ?>

              <?php if($this->session->userdata('role') == 1){ ?>
              <a href="<?=base_url('admin/form_claimbarang')?>" style="margin-bottom:10px;" type="button" class="btn btn-primary" name="tambah_data"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data Claim</a>
              <?php } else { ?>
                <a href=""></a>
              <?php } ?>

              <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>id claim</th>
                  <th>tanggal</th>
                  <th>nama costumer</th>
                  <th>mekanik</th>
                  <th>merk mesin</th>
                  <th>type mesin</th>
                  <th>nomor mesin</th>
                  <th>nama part</th>
                  <th>penyebab kerusakan</th>
                  <th>status</th>
                  <th>keterangan</th>

                  <?php if($this->session->userdata('role') == 1){ ?>
                  <th>Update</th>
                  <?php } ?>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <?php if(!empty($list_data)){ ?>
                  <?php $no = 1;?>
                  <?php foreach($list_data as $dd): ?>
                    <td><?=$no?></td>
                    <td><?=$dd->id_claim?></td>
                    <td><?=$dd->tanggal?></td>
                    <td><?=$dd->nama_customer?></td>
                    <td><?=$dd->mekanik?></td>
                    <td><?=$dd->merk_mesin?></td>
                    <td><?=$dd->type_mesin?></td>
                    <td><?=$dd->nomor_mesin?></td>
                    <td><?=$dd->nama_part?></td>
                    <td><?=$dd->penyebab_kerusakan?></td>
                    <td><?=$dd->status?></td>
                    <td><?=$dd->keterangan?></td>

                    <?php if($this->session->userdata('role') == 1){ ?>
                    <td><a type="button" class="btn btn-info"  href="<?=base_url('admin/edit_claimbarang/'.$dd->id_claim)?>" name="btn_update" style="margin:auto;"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
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
                    <th>id claim</th>
                    <th>tanggal</th>
                    <th>nama costumer</th>
                    <th>mekanik</th>
                    <th>merk mesin</th>
                    <th>type mesin</th>
                    <th>nomor mesin</th>
                    <th>nama part</th>
                    <th>penyebab kerusakan</th>
                    <th>status</th>
                    <th>keterangan</th>

                    <?php if($this->session->userdata('role') == 1){ ?>
                    <th>Update</th>
                    <?php } ?>
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