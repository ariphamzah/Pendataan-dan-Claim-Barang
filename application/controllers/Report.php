<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller{

  public function __construct(){
		parent::__construct();
    $this->load->model('M_admin');
	}
  public function invoice()
  {
    if($this->session->userdata('status') == 'login'){
      $id_transaksi = $this->uri->segment(3);

    if($id_transaksi != ''){
      $where = array ('id_transaksi' => $id_transaksi);

      $data['list_data'] = $this->M_admin->select('tb_barang_keluar');
      $data['report'] = $this->M_admin->get_data('tb_barang_keluar',$where);
      $data['list_customer'] = $this->M_admin->select('tb_customer');

      $this->load->view('admin/invoice',$data);
    }
    else{
      $this->load->view('admin/invoice');
    }
    }else {
      $this->load->view('login/login');
    }    
  }
}     