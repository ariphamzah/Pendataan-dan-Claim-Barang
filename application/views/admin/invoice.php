<html>
<head>
<title>Faktur Pembayaran</title>

<style>
    #tabel
    {
        font-size:15px;
        border-collapse:collapse;
    }
    #tabel  td
    {
        padding-left:5px;
        border: 1px solid black;
    }
    #p0 { text-indent: 2em; }
</style>



</head>
    
    <body style='font-size:12pt;'>
        <?php
            $customer         ='';
            $alamat           ='';
            $tanggal          ='';
            $id_transaksi     ='';
            $tanggal_masuk    ='';
            $tanggal_keluar   ='';
            $kode_barang      ='';
            $nama_barang      ='';
            $satuan           ='';
            $jumlah           ='';

            if(isset($report)){
                foreach($report as $r){
                    $customer         =$r->id_customer;
                    $alamat           =$r->lokasi;
                    $tanggal          =$r->tanggal_keluar;
                    $id_transaksi     =$r->id_transaksi;
                    $tanggal_masuk    =$r->tanggal_masuk;
                    $tanggal_keluar   =$r->tanggal_keluar;
                    $kode_barang      =$r->kode_barang;
                    $nama_barang      =$r->nama_barang;
                    $satuan           =$r->satuan;
                    $jumlah           =$r->jumlah;
                }
            }
        ?>

            <center>
                <table style='width:750px; font-size:12pt; font-family:Times New Roman; border-collapse: collapse;' border = '0'>
                    <td width='75%' align='left' style='padding-right:80px; vertical-align:top'>
                        <img src="<?php echo base_url()?>assets/upload/img/logo.png" alt="" width="100" height="100">
                    </td>
                    <td style='vertical-align:top' width='30%' align='left'>
                        <b><br><span style='font-size:12pt'>PT Obor Indonesia</span></b></br><br>
                        <span style='font-size:8pt;'>PASKAL HYPER SQUARE BLK A</span></br>
                        <span style='font-size:8pt;'>NO. 48-49</span></br>
                        <span style='font-size:8pt;'>JL. PASIR KALIKI NO. 25-27 BANDUNG</span></br>
                    </td>
                </table>
                <b><span style='font-size:18pt'>INVOICE</span></b></br><br>
                <span>&nbsp;</span>
                <table style='width:750px; font-size:8pt; font-family:calibri; border-collapse: collapse;' border = '0'>
                    <td width='70%' align='left' style='padding-right:80px; vertical-align:top'>
                    <?php foreach ($list_customer as $s) { 
                        $customer = $s->nama_customer;
                    }
                    ?>
                    Nama Customer &nbsp;&emsp; : <?= $customer ?><br>
                    Alamat &emsp;&emsp;&emsp;&emsp;&emsp; : <?= $alamat ?><br>
                    Tanggal &emsp;&emsp;&emsp;&emsp;&ensp;&ensp;: <?= $tanggal ?></br>
                    </td>
                </table>
                <br><br>
                <table cellspacing='0' style='width:750px; font-size:8pt; font-family:calibri;  border-collapse: collapse;' border='1'>
                
                    <tr align='center'>
                        <td width='4%'>No</td>
                        <td width='13%'>ID Transaksi</td>
                        <td width='10%'>Tanggal Masuk</td>
                        <td width='10%'>Tanggal Keluar</td>
                        <td width='10%'>Kode Barang</td>
                        <td width='13%'>Nama Barang</td>
                        <td width='7%'>Satuan</td>
                        <td width='7%'>Jumlah</td>
                    </tr>
                    
                    <tr>
                        <td align='center'>1</td>
                        <td> <?= $id_transaksi ?></td>
                        <td> <?= $tanggal_masuk ?></td>
                        <td> <?= $tanggal_keluar ?></td>
                        <td> <?= $kode_barang ?></td>
                        <td> <?= $nama_barang ?></td>
                        <td align="center"> <?= $satuan ?></td>
                        <td align="center   "> <?= $jumlah ?></td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <br><br>
                <table style='width:650; font-size:7pt;'>
                    <tr>
                        <td align='left'>Diterima Oleh,</br></br><br><br><u>(.....................)</u></td>
                        <td align='center' style='border:1px solid black; padding:5px; width:200px'>Pembayaran Melalui Transfer</td>
                        <td align='right' style='padding-right:10px '>TTD,&emsp;&ensp;&ensp;</br></br></br></br><u>(.....................)</u></td>
                    </tr>
                </table>
            </center>
        
    
    <script>
        window.print();    
    </script>
</body>
</html>