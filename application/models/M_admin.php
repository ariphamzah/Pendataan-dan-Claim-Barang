<?php

class M_admin extends CI_Model
{

  public function insert($tabel,$data)
  {
    $this->db->insert($tabel,$data);
  }

  public function generate_kode_barang($char_bm)
  {
    $char = $char_bm;
    $query = $this->db->select('MAX(id_transaksi) as max_kode')
                      ->from('tb_barang_masuk')
                      ->where('id_transaksi LIKE', $char.'%')
                      ->order_by('id_transaksi', 'DESC')
                      ->limit(1)
                      ->get();
    $data = $query->row();
    
    if ($data) {
        $kodeBarang = $data->max_kode;
        $no = substr($kodeBarang, 11);
        $no = (int) $no;
        $no += 1;
    } else {
        $no = 1;
    }
    
    $newKodeBarang = $char.date("Y").$no;
    return $newKodeBarang;
  }

  public function generate_kode_barang_keluar($char_bm)
  {
    $char = $char_bm;
    $query = $this->db->select('MAX(id_transaksi) as max_kode')
                      ->from('tb_barang_keluar')
                      ->where('id_transaksi LIKE', $char.'%')
                      ->order_by('id_transaksi', 'DESC')
                      ->limit(1)
                      ->get();
    $data = $query->row();
    
    if ($data) {
        $kodeBarang = $data->max_kode;
        $no = substr($kodeBarang, 11);
        $no = (int) $no;
        $no += 1;
    } else {
        $no = 1;
    }
    
    $newKodeBarang = $char .date("Y"). $no;
    return $newKodeBarang;
  }

  public function generate_kode_claim($char_bm)
  {
    $char = $char_bm;
    $query = $this->db->select('MAX(id_claim) as max_kode')
                      ->from('tb_claim_barang')
                      ->where('id_claim LIKE', $char.'%')
                      ->order_by('id_claim', 'DESC')
                      ->limit(1)
                      ->get();
    $data = $query->row();
    
    if ($data) {
        $kodeBarang = $data->max_kode;
        $no = substr($kodeBarang, 12);
        $no = (int) $no;
        $no += 1;
    } else {
        $no = 1;
    }
    
    $newKodeBarang = $char .date("Y"). $no;
    return $newKodeBarang;
  }

  public function select_grouped_stock_op_name()
  {
    $this->db->select('nama_barang, MAX(merk) AS merk, MAX(kode_barang) AS kode_barang, MAX(satuan) AS satuan, SUM(jumlah) AS jumlah');
    $this->db->from('tb_barang_masuk');
    $this->db->group_by('nama_barang');
    $this->db->order_by('nama_barang');
    return $this->db->get()->result();
  }

  public function select($tabel)
  {
    $query = $this->db->get($tabel);
    return $query->result();
  }

  public function cek_jumlah($tabel,$id_transaksi,$id_claim)
  {
    return  $this->db->select('*')
               ->from($tabel)
               ->where('id_transaksi',$id_transaksi,'id_claim',$id_claim)
               ->get();
  }

  public function get_data_array($tabel,$id_transaksi,$id_claim)
  {
    $query = $this->db->select()
                      ->from($tabel)
                      ->where($id_transaksi,$id_claim)
                      ->get();
    return $query->result_array();
  }

  public function get_data($tabel,$id_transaksi)
  {
    $query = $this->db->select()
                      ->from($tabel)
                      ->where($id_transaksi)
                      ->get();
    return $query->result();
  }

  public function get_data_report($tabel,$month,$year,$tang)
  {
    $query = $this->db->select('*')
                      ->from($tabel)
                      ->join('tb_customer', $tabel.'.id_customer = tb_customer.id_customer')
                      ->where("MONTH(".$tang.")='".$month."' AND YEAR(".$tang.")='".$year."'")
                      ->get();
    return $query->result();
  }

  public function get_data_report_masuk($tabel,$month,$year,$tang)
  {
    $query = $this->db->select('*')
                      ->from($tabel)
                      ->where("MONTH(".$tang.")='".$month."' AND YEAR(".$tang.")='".$year."'")
                      ->get();
    return $query->result();
  }

  public function update($tabel,$data,$where)
  {
    $this->db->where($where);
    $this->db->update($tabel,$data);
  }

  public function delete($tabel,$where)
  {
    $this->db->where($where);
    $this->db->delete($tabel);
  }

  public function mengurangi($tabel,$id_transaksi,$jumlah)
  {
    $this->db->set("jumlah","jumlah - $jumlah");
    $this->db->where('id_transaksi',$id_transaksi);
    $this->db->update($tabel);
  }

  public function update_password($tabel,$where,$data)
  {
    $this->db->where($where);
    $this->db->update($tabel,$data);
  }

  public function get_data_gambar($tabel,$username)
  {
    $query = $this->db->select()
                      ->from($tabel)
                      ->where('username_user',$username)
                      ->get();
    return $query->result();
  }

  public function sum($tabel,$field)
  {
    $query = $this->db->select_sum($field)
                      ->from($tabel)
                      ->get();
    return $query->result();
  }

  public function numrows($tabel)
  {
    $query = $this->db->select()
                      ->from($tabel)
                      ->get();
    return $query->num_rows();
  }

  public function read($tabel,$username)
  {
    $query = $this->db->select()
                      ->from($tabel)
                      ->where_not_in('username',$username)
                      ->get();

    return $query->result();
  }
  
  public function read_join($table)
	{
    $query = $this->db->select('*')
                      ->from($table)
                      ->join('tb_customer', $table.'.id_customer = tb_customer.id_customer')
                      ->get();

    return $query->result();
	}


}



 ?>
