<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller{

  public function __construct(){
		parent::__construct();
    $this->load->model('M_admin');
	}
  public function invoice()
  {
    $id_transaksi = $this->uri->segment(3);

    if($id_transaksi != ''){
      $where = array ('id_transaksi' => $id_transaksi);

      $data['report'] = $this->M_admin->get_data('tb_barang_keluar',$where);

      $this->load->view('admin/invoice',$data);
    }
    else{
      $this->load->view('admin/invoice');
    }    
  }
}