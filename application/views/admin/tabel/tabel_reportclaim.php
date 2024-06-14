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
        Report Claim 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?=base_url('admin')?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Report</li>
        <li class="active"><a href="<?=base_url('admin/report_claim')?>">Report Claim</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-table" aria-hidden="true"></i> List Report Claim</h3>
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

              <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>ID Claim</th>
                  <th>Tanggal</th>
                  <th>Nama Costumer</th>
                  <th>Mekanik</th>
                  <th>Merk Mesin</th>
                  <th>Type Mesin</th>
                  <th>Nomor Mesin</th>
                  <th>Nama Part</th>
                  <th>Jumlah</th>
                  <th>Penyebab Kerusakan</th>
                  <th>Status</th>
                  <th>Keterangan</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <?php if(!empty($list_data)){ ?>
                  <?php $no = 1;?>
                  <?php foreach($list_data as $dd): ?>
                    <td><?=$no?></td>
                    <td><?=$dd->id_claim?></td>
                    <td><?=$dd->tanggal_claim?></td>
                    <td><?=$dd->nama_customer?></td>
                    <td><?=$dd->mekanik?></td>
                    <td><?=$dd->merk_mesin?></td>
                    <td><?=$dd->type_mesin?></td>
                    <td><?=$dd->nomor_mesin?></td>
                    <td><?=$dd->nama_part?></td>
                    <td><?=$dd->jumlah?></td>
                    <td><?=$dd->penyebab_kerusakan?></td>
                    <td><?=$dd->status?></td>
                    <td><?=$dd->keterangan?></td>
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
                    <th>ID Claim</th>
                    <th>Tanggal</th>
                    <th>Nama Costumer</th>
                    <th>Mekanik</th>
                    <th>Merk Mesin</th>
                    <th>Type Mesin</th>
                    <th>Nomor Mesin</th>
                    <th>Nama Part</th>
                    <th>Jumlah</th>
                    <th>Penyebab Kerusakan</th>
                    <th>Status</th>
                    <th>Keterangan</th>
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