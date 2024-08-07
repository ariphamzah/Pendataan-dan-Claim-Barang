<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller{
  public function __construct(){
		parent::__construct();
    $this->load->model('M_admin');
    $this->load->model('M_login');
    $this->load->library('upload');
	}

  public function index(){
    if($this->session->userdata('status') == 'login'){
      $data['stokBarangMasuk'] = $this->M_admin->sum('tb_barang_masuk','jumlah');
      $data['stokBarangKeluar'] = $this->M_admin->sum('tb_barang_keluar','jumlah');
      $data['listClaim'] = $this->M_admin->sum('tb_claim_barang','jumlah');      
      $data['dataUser'] = $this->M_admin->numrows('user');
      
      $this->load->view('admin/index',$data);
    }else {
      $this->load->view('login/login');
    }
  }

  public function sigout(){
    $this->session->sess_destroy();
    redirect('login');
  }

  ####################################
              // Profile
  ####################################

  public function profile()
  {
    if($this->session->userdata('status') == 'login'){
      $data['token_generate'] = $this->token_generate();
      $this->session->set_userdata($data);
      $data['nav'] = 5;

      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/profile',$data);
      $this->load->view('component/footer');
      }else {
      $this->load->view('login/login');
    }  
  }

  public function token_generate()
  {
    return $tokens = md5(uniqid(rand(), true));
  }

  private function hash_password($password)
  {
    return password_hash($password,PASSWORD_DEFAULT);
  }

  public function proses_new_password()
  {
    if($this->session->userdata('status') == 'login'){
      $this->form_validation->set_rules('email','Email','required');
    $this->form_validation->set_rules('new_password','New Password','required');
    $this->form_validation->set_rules('confirm_new_password','Confirm New Password','required|matches[new_password]');

    if($this->form_validation->run() == TRUE)
    {
      if($this->session->userdata('token_generate') === $this->input->post('token'))
      {
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $new_password = $this->input->post('new_password');

        $data = array(
            'email'    => $email,
            'password' => $this->hash_password($new_password)
        );

        $where = array(
            'id' =>$this->session->userdata('id')
        );

        $data_report = array(
          'id_report'        => 'RP-'.date("Y").random_string('numeric', 8),
          'user_report'      => $this->session->userdata('name'),
          'jenis_report'     => 'report_user',
          'note'             => 'Change Profile User '.$this->session->userdata('name')
        );

        $this->M_admin->insert('tb_report',$data_report);

        $this->M_admin->update_password('user',$where,$data);

        $this->session->set_flashdata('msg_berhasil','Password Telah Diganti');
        redirect(base_url('admin/profile'));
      }
    }else {
      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/profile',$data);
      $this->load->view('component/footer');
    }
    }else {
      $this->load->view('login/login');
    } 
  }

  public function proses_gambar_upload()
  {
    if($this->session->userdata('status') == 'login'){
      $config =  array(
        'upload_path'     => "./assets/upload/user/img/",
        'allowed_types'   => "gif|jpg|png|jpeg",
        'max_size'        => "50000",  // ukuran file gambar
        'max_height'      => "9680",
        'max_width'       => "9024"
      );
      $this->load->library('upload',$config);
      $this->upload->initialize($config);

      if( ! $this->upload->do_upload('userpicture'))
      {
      $this->session->set_flashdata('msg_error_gambar', $this->upload->display_errors());
      $this->load->view('admin/profile',$data);
      }else{
      $upload_data = $this->upload->data();
      $nama_file = $upload_data['file_name'];
      $ukuran_file = $upload_data['file_size'];

      //resize img + thumb Img -- Optional
      $config['image_library']     = 'gd2';
      $config['source_image']      = $upload_data['full_path'];
      $config['create_thumb']      = FALSE;
      $config['maintain_ratio']    = TRUE;
      $config['width']             = 150;
      $config['height']            = 150;

      $this->load->library('image_lib', $config);
      $this->image_lib->initialize($config);

      if($this->session->userdata('photo') !== 'nopic.png'){
      unlink('./assets/upload/user/img/'.$this->session->userdata('photo'));
      }

      $where = array(
          'username' => $this->session->userdata('name')
      );

      $data_report = array(
      'id_report'        => 'RP-'.date("Y").random_string('numeric', 8),
      'user_report'      => $this->session->userdata('name'),
      'jenis_report'     => 'report_user',
      'note'             => 'Change Photo User '.$this->session->userdata('name')
      );

      $data = array(
      'photo' => $nama_file
      );

      $this->session->set_userdata('photo', $this->upload->data('file_name'));
      $this->M_admin->update('user',$data,$where);

      $this->M_admin->insert('tb_report',$data_report);

      $this->session->set_flashdata('msg_berhasil_gambar','Gambar Berhasil Di Upload');
      redirect(base_url('admin/profile'));
      }
    }else {
      $this->load->view('login/login');
    } 
  }

  ####################################
           // End Profile
  ####################################



  ####################################
              // Users
  ####################################
  public function users()
  {
    if($this->session->userdata('status') == 'login'){
      if($this->session->userdata('role') == 0){ 
        redirect (base_url('admin/tabel_barangmasuk'));
      }
  
      $data['list_users'] = $this->M_admin->read('user',$this->session->userdata('name'));
      $data['token_generate'] = $this->token_generate();
      $this->session->set_userdata($data);
      $data['nav'] = 6;
  
      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/users',$data);
      $this->load->view('component/footer');
    }else {
      $this->load->view('login/login');
    } 
  }

  public function form_user()
  {
    if($this->session->userdata('status') == 'login'){
      if($this->session->userdata('role') == 0){ 
        redirect (base_url('admin/tabel_barangmasuk'));
      }
  
      $data['token_generate'] = $this->token_generate();
      $this->session->set_userdata($data);
      $data['nav'] = 6;
  
      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/form/form_users',$data);
      $this->load->view('component/footer');
    }else {
      $this->load->view('login/login');
    } 
  }

  public function edit_user()
  {
    if($this->session->userdata('status') == 'login'){
      if($this->session->userdata('role') == 0){ 
        redirect (base_url('admin/tabel_barangmasuk'));
      }
      
      $id = $this->uri->segment(3);
      $where = array('id' => $id);
      $data['token_generate'] = $this->token_generate();
      $data['list_data'] = $this->M_admin->get_data('user',$where);
      $this->session->set_userdata($data);
      $data['nav'] = 6;
  
      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/form/form_users',$data);
      $this->load->view('component/footer');
    }else {
      $this->load->view('login/login');
    }
  }

  public function update_user()
  {
    if($this->session->userdata('status') == 'login'){
      if($this->session->userdata('role') == 0){ 
        redirect (base_url('admin/tabel_barangmasuk'));
      }
  
      $id = $this->uri->segment(3);
      $where = array('id' => $id);
      $data['token_generate'] = $this->token_generate();
      $data['list_data'] = $this->M_admin->get_data('user',$where);
      $this->session->set_userdata($data);
      $this->load->view('admin/form/form_users',$data);
    }else {
      $this->load->view('login/login');
    }
  }

  public function proses_delete_user()
  {
    if($this->session->userdata('status') == 'login'){
      if($this->session->userdata('role') == 0){ 
        redirect (base_url('admin/tabel_barangmasuk'));
      }
  
      $username = $this->uri->segment(3);
  
      $where = array('username' => $username);
  
      $this->M_admin->delete('user',$where);
      
      $data_report = array(
        'id_report'        => 'RP-'.date("Y").random_string('numeric', 8),
        'user_report'      => $this->session->userdata('name'),
        'jenis_report'     => 'report_user',
        'note'             => 'Delete User'. ' (' .$username. ')' 
      );
      
      $this->M_admin->insert('tb_report',$data_report);
  
      $this->session->set_flashdata('msg_berhasil','Data User Behasil Dihapus');
      redirect(base_url('admin/users'));
    }else {
      $this->load->view('login/login');
    }
  }

  public function proses_reset_user()
  {
    if($this->session->userdata('status') == 'login'){
      if($this->session->userdata('role') == 0){ 
        redirect (base_url('admin/tabel_barangmasuk'));
      }
  
      $reset = $this->uri->segment(3);
  
      $data = array(
        'password' => $this->hash_password($reset)
      );
  
      $where = array(
        'username' =>$reset
      );
  
      $data_report = array(
        'id_report'        => 'RP-'.date("Y").random_string('numeric', 8),
        'user_report'      => $this->session->userdata('name'),
        'jenis_report'     => 'report_user',
        'note'             => 'Reset Password User'. ' (' .$reset. ')' 
      );
      
      $this->M_admin->insert('tb_report',$data_report);
  
      $this->M_admin->update_password('user',$where,$data);
  
      $this->session->set_flashdata('msg_berhasil','Password Telah Direset');
      redirect(base_url('admin/users'));
    }else {
      $this->load->view('login/login');
    }
  }

  public function proses_tambah_user()
  {
    if($this->session->userdata('status') == 'login'){
      if($this->session->userdata('role') == 0){ 
        redirect (base_url('admin/tabel_barangmasuk'));
      }
  
      $this->form_validation->set_rules('username','Username','required');
      $this->form_validation->set_rules('email','Email','required|valid_email');
      $this->form_validation->set_rules('password','Password','required');
      $this->form_validation->set_rules('confirm_password','Confirm password','required|matches[password]');
  
      if($this->form_validation->run() == TRUE)
      {
        if($this->session->userdata('token_generate') === $this->input->post('token'))
        {
  
          $username     = $this->input->post('username',TRUE);
          $email        = $this->input->post('email',TRUE);
          $password     = $this->input->post('password',TRUE);
          $role         = $this->input->post('role',TRUE);
  
          if($this->M_login->cek_username('user',$username)){
            $this->session->set_flashdata('msg','Username Telah Digunakan');
            redirect(base_url('login/register'));
    
          }else{
            $data = array(
                  'username' => $username,
                  'email' 	 => $email,
                  'password' => $this->hash_password($password),
                  'role'     => $role
            );
  
            $data_report = array(
              'id_report'        => 'RP-'.date("Y").random_string('numeric', 8),
              'user_report'      => $this->session->userdata('name'),
              'jenis_report'     => 'report_user',
              'note'             => 'Add User'. ' (' .$username. ')' 
            );
            
            $this->M_admin->insert('tb_report',$data_report);
    
            $this->M_login->insert('user',$data);
    
            $this->session->set_flashdata('msg_terdaftar','User Berhasil Ditambahkan');
            redirect(base_url('admin/users'));
          }}
        }else {
          $data['token_generate'] = $this->token_generate();
          $this->session->set_userdata($data);
          $data['nav'] = 6;
  
          // Load View
          $this->load->view('component/header');
          $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
          $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
          $this->load->view('admin/form/form_users', $data);
          $this->load->view('component/footer');   
      }
    }else {
      $this->load->view('login/login');
    } 
  }

  public function proses_update_user()
  {
    if($this->session->userdata('status') == 'login'){
      if($this->session->userdata('role') == 0){ 
        redirect (base_url('admin/tabel_barangmasuk'));
      }
      
      $this->form_validation->set_rules('username','Username','required');
      $this->form_validation->set_rules('email','Email','required|valid_email');
  
      
      if($this->form_validation->run() == TRUE)
      {
        if($this->session->userdata('token_generate') === $this->input->post('token'))
        {
          $id           = $this->input->post('id',TRUE);        
          $username     = $this->input->post('username',TRUE);
          $email        = $this->input->post('email',TRUE);
          $role         = $this->input->post('role',TRUE);
  
          $where = array('id' => $id);
          $data = array(
                'username'     => $username,
                'email'        => $email,
                'role'         => $role,
          );
  
          $data_report = array(
            'id_report'        => 'RP-'.date("Y").random_string('numeric', 8),
            'user_report'      => $this->session->userdata('name'),
            'jenis_report'     => 'report_user',
            'note'             => 'Update User'. ' (' .$username. ')' 
          );
          
          $this->M_admin->insert('tb_report',$data_report);
  
          $this->M_admin->update('user',$data,$where);
          $this->session->set_flashdata('msg_berhasil','Data User Berhasil Diupdate');
          redirect(base_url('admin/users'));
         }
      }else{
          // Load View
          $this->load->view('component/header');
          $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
          $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
          $this->load->view('admin/form/form_users',$data);
          $this->load->view('component/footer');
      }
    }else {
      $this->load->view('login/login');
    }
  }


  ####################################
           // End Users
  ####################################


  ####################################
        // STOK OP NAME 
  ####################################

  public function stock_op_name()
  {
    if($this->session->userdata('status') == 'login'){
        $data['list_data'] = $this->M_admin->select_grouped_stock_op_name();
        $data['nav'] = 11;

        // Load View
        $this->load->view('component/header');
        $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
        $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
        $this->load->view('admin/tabel/tabel_stockopname', $data);
        $this->load->view('component/footer');
    } else {
        $this->load->view('login/login');
    }
  }

  ####################################
        // END - STOK OP NAME 
  ####################################


  ####################################
        // DATA BARANG MASUK
  ####################################

  public function form_barangmasuk()
  {
    if($this->session->userdata('status') == 'login'){
      if($this->session->userdata('role') == 0){ 
        redirect (base_url('admin/tabel_barangmasuk'));
      }
      $data['nav'] = 0;
      $id_barang= $this->M_admin->generate_kode_barang('OBOR-BM');
      $data['id_barang'] = $id_barang;
      
      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/form/form_barangmasuk', $data);
      $this->load->view('component/footer');  
    }else {
      $this->load->view('login/login');
    }
  }

  public function edit_barangmasuk($id_transaksi)
  {
    if($this->session->userdata('status') == 'login'){
      if($this->session->userdata('role') == 0){ 
        redirect (base_url('admin/tabel_barangmasuk'));
      }
  
      $where = array('id_transaksi' => $id_transaksi);
      $data['masuk'] = $this->M_admin->get_data('tb_barang_masuk',$where);
      $data['id_barang'] = $id_transaksi;
      $data['nav'] = 0;
      
      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/form/form_barangmasuk', $data);
      $this->load->view('component/footer');
    }else {
      $this->load->view('login/login');
    }   
  }

  public function tabel_barangmasuk()
  {
    if($this->session->userdata('status') == 'login'){
      $data['list_data'] = $this->M_admin->select('tb_barang_masuk');
      $data['nav'] = 1;

      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/tabel/tabel_barangmasuk',$data);
      $this->load->view('component/footer');
    }else {
      $this->load->view('login/login');
    } 
  }

  public function delete_barang($id_transaksi)
  {
    if($this->session->userdata('status') == 'login'){
      if($this->session->userdata('role') == 0){ 
        redirect (base_url('admin/tabel_barangmasuk'));
      }
  
      $where = array('id_transaksi' => $id_transaksi);
      $data_report = array(
        'id_report'        => 'RP-'.date("Y").random_string('numeric', 8),
        'user_report'      => $this->session->userdata('name'),
        'jenis_report'     => 'report_barang',
        'note'             => 'Delete Barang '.$id_transaksi
      );
  
      $this->M_admin->insert('tb_report',$data_report);
  
      $this->M_admin->delete('tb_barang_masuk',$where);
      $this->session->set_flashdata('msg_berhasil','Data Barang Berhasil Dihapus');
      redirect(base_url('admin/tabel_barangmasuk'));
    }else {
      $this->load->view('login/login');
    }
  }



  public function proses_databarang_masuk_insert()
  {

    if($this->session->userdata('status') == 'login'){
      $this->form_validation->set_rules('lokasi','Lokasi','required');
      $this->form_validation->set_rules('tanggal','Tanggal','required');
      $this->form_validation->set_rules('nama_barang','Nama Barang','required');
      $this->form_validation->set_rules('jumlah','Jumlah','required');

    if($this->form_validation->run() == TRUE)
    {
      $id_transaksi = $this->input->post('id_transaksi',TRUE);
      $tanggal      = $this->input->post('tanggal',TRUE);
      $lokasi       = $this->input->post('lokasi',TRUE);
      $merk         = $this->input->post('merk_barang',TRUE);
      $kode_barang  = $this->input->post('kode_barang',TRUE);
      $nama_barang  = $this->input->post('nama_barang',TRUE);
      $satuan       = $this->input->post('satuan',TRUE);
      $jumlah       = $this->input->post('jumlah',TRUE);

      $data = array(
            'id_transaksi' => $id_transaksi,
            'tanggal'      => $tanggal,
            'lokasi'       => $lokasi,
            'merk'         => $merk,
            'kode_barang'  => $kode_barang,
            'nama_barang'  => $nama_barang,
            'satuan'       => $satuan,
            'jumlah'       => $jumlah
      );

      $data_report = array(
        'id_report'        => 'RP-'.date("Y").random_string('numeric', 8),
        'user_report'      => $this->session->userdata('name'),
        'jenis_report'     => 'report_barang',
        'note'             => 'Add Barang '.$id_transaksi. ' (' .$nama_barang. ')' 
      );

      $this->M_admin->insert('tb_barang_masuk',$data);
      $this->M_admin->insert('tb_report',$data_report);

      $this->session->set_flashdata('msg_berhasil','Data Barang Berhasil Ditambahkan');
      redirect(base_url('admin/tabel_barangmasuk'));
    }else {
      $data['nav'] = 0;
      $id_barang= $this->M_admin->generate_kode_barang('OBOR-BM');
      $data['id_barang'] = $id_barang;

      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/form/form_barangmasuk', $data);
      $this->load->view('component/footer'); 
    }
    }else {
      $this->load->view('login/login');
    } 
  }

  public function proses_databarang_masuk_update()
  {
    if($this->session->userdata('status') == 'login'){
      $this->form_validation->set_rules('lokasi','Lokasi','required');
      $this->form_validation->set_rules('nama_barang','Nama Barang','required');
      $this->form_validation->set_rules('jumlah','Jumlah','required');

    if($this->form_validation->run() == TRUE)
    {
      $id_transaksi = $this->input->post('id_transaksi',TRUE);
      $tanggal      = $this->input->post('tanggal',TRUE);
      $lokasi       = $this->input->post('lokasi',TRUE);
      $merk         = $this->input->post('merk_barang',TRUE);
      $kode_barang  = $this->input->post('kode_barang',TRUE);
      $nama_barang  = $this->input->post('nama_barang',TRUE);
      $satuan       = $this->input->post('satuan',TRUE);
      $jumlah       = $this->input->post('jumlah',TRUE);

      $where = array('id_transaksi' => $id_transaksi);
      $data = array(
            'id_transaksi' => $id_transaksi,
            'tanggal'      => $tanggal,
            'lokasi'       => $lokasi,
            'merk'         => $merk,
            'kode_barang'  => $kode_barang,
            'nama_barang'  => $nama_barang,
            'satuan'       => $satuan,
            'jumlah'       => $jumlah
      );

      $data_report = array(
        'id_report'        => 'RP-'.date("Y").random_string('numeric', 8),
        'user_report'      => $this->session->userdata('name'),
        'jenis_report'     => 'report_barang',
        'note'             => 'Update Barang '.$id_transaksi. ' (' .$nama_barang. ')'
      );
      
      $this->M_admin->update('tb_barang_masuk',$data,$where);
      $this->M_admin->insert('tb_report',$data_report);

      $this->session->set_flashdata('msg_berhasil','Data Barang Berhasil Diupdate');
      redirect(base_url('admin/tabel_barangmasuk'));
    }else{
      $data['list_data'] = $this->M_admin->select('tb_barang_masuk');
      $data['nav'] = 1;
      
      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/tabel/tabel_barangmasuk', $data);
      $this->load->view('component/footer'); 
    }
    }else {
      $this->load->view('login/login');
    }
  }
  ####################################
      // END DATA BARANG MASUK
  ####################################
  

  ####################################
     // DATA MASUK KE DATA KELUAR
  ####################################

  public function barang_keluar()
  {
    if($this->session->userdata('status') == 'login'){
      $uri = $this->uri->segment(3);
      $where = array( 'id_transaksi' => $uri);
      $data['list_data'] = $this->M_admin->get_data('tb_barang_masuk',$where);

      // ID Transaksi
      $id_barang= $this->M_admin->generate_kode_barang_keluar('OBOR-BK');
      $data['id_barang'] = $id_barang;

      $data['list_customer'] = $this->M_admin->select('tb_customer');
      $data['nav'] = 2;

      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/form/form_pindahbarang',$data);
      $this->load->view('component/footer');
    }else {
      $this->load->view('login/login');
    }
  }

  public function proses_data_keluar()
  {
    if($this->session->userdata('status') == 'login'){
      $this->form_validation->set_rules('tanggal_keluar','Tanggal Keluar','trim|required');
      $this->form_validation->set_rules('customer','Nama Customer','required');
    if($this->form_validation->run() === TRUE)
    {
      // Generate ID Transaksi
      $id_transaksi   = $this->input->post('id_transaksi',TRUE);
      $customer       = $this->input->post('customer',TRUE);
      $tanggal_masuk  = $this->input->post('tanggal',TRUE);
      $tanggal_keluar = $this->input->post('tanggal_keluar',TRUE);
      $merk           = $this->input->post('merk_barang',TRUE);
      $kode_barang    = $this->input->post('kode_barang',TRUE);
      $nama_barang    = $this->input->post('nama_barang',TRUE);
      $satuan         = $this->input->post('satuan',TRUE);
      $jumlah         = $this->input->post('jumlah',TRUE);

      $where = array( 'id_transaksi' => $id_transaksi);
      $data = array(
              'id_transaksi'    => $id_transaksi,
              'id_customer'     => $customer,
              'tanggal_masuk'   => $tanggal_masuk,
              'tanggal_keluar'  => $tanggal_keluar,
              'merk'            => $merk,
              'kode_barang'     => $kode_barang,
              'nama_barang'     => $nama_barang,
              'satuan'          => $satuan,
              'jumlah'          => $jumlah
      );

      $data_report = array(
        'id_report'        => 'RP-'.date("Y").random_string('numeric', 8),
        'user_report'      => $this->session->userdata('name'),
        'jenis_report'     => 'report_barang',
        'note'             => 'Sale Barang '.$id_transaksi. ' (' .$nama_barang. ')'
      );
      
        $this->M_admin->insert('tb_report',$data_report);
        $this->M_admin->insert('tb_barang_keluar',$data);
        $this->session->set_flashdata('msg_berhasil_keluar','Data Berhasil Keluar');
        redirect(base_url('admin/tabel_barangmasuk'));
    }else {
      $data['list_data'] = $this->M_admin->select('tb_barang_masuk');
      $data['nav'] = 1;

      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/tabel/tabel_barangmasuk',$data);
      $this->load->view('component/footer');
    }
    }else {
      $this->load->view('login/login');
    } 
  }
  ####################################
    // END DATA MASUK KE DATA KELUAR
  ####################################


  ####################################
        // DATA BARANG KELUAR
  ####################################

  public function tabel_barangkeluar()
  {
    if($this->session->userdata('status') == 'login'){
      $data['list_data'] = $this->M_admin->read_join('tb_barang_keluar');
      $data['nav'] = 2;

      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/tabel/tabel_barangkeluar',$data);
      $this->load->view('component/footer');
    }else {
      $this->load->view('login/login');
    } 
  }

  
  ####################################
           // End Barang Keluar
  ####################################


  ####################################
            // CLAIM BARANG
  ####################################

  public function tabel_claimbarang()
  {
    if($this->session->userdata('status') == 'login'){
      $data['list_data'] = $this->M_admin->read_join('tb_claim_barang');
      $data['nav'] = 8;

      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/tabel/tabel_claimbarang',$data);
      $this->load->view('component/footer');
    }else {
      $this->load->view('login/login');
    } 
  }

  public function form_claimbarang()
  {
    if($this->session->userdata('status') == 'login'){
      $data['list_data'] = $this->M_admin->select('tb_claim_barang');
      $data['list_customer'] = $this->M_admin->select('tb_customer');
      $id_claim= $this->M_admin->generate_kode_claim('OBOR-CLM');
      $data['id_claim'] = $id_claim;
      $data['nav'] = 9;
      
      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/form/form_claimbarang', $data);
      $this->load->view('component/footer'); 
    }else {
      $this->load->view('login/login');
    }  
  }

  public function edit_claimbarang($id_claim)
  {
    if($this->session->userdata('status') == 'login'){
      if($this->session->userdata('role') == 0){ 
        redirect (base_url('admin/tabel_claimbarang'));
      }
  
      $where = array('id_claim' => $id_claim);
      $data['list_data'] = $this->M_admin->select('tb_claim_barang');
      $data['masuk'] = $this->M_admin->get_data('tb_claim_barang',$where);
      $data['list_customer'] = $this->M_admin->select('tb_customer');
      $data['id_claim'] = $id_claim;
      $data['nav'] = 9;
      
      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/form/form_claimbarang', $data);
      $this->load->view('component/footer');  
    }else {
      $this->load->view('login/login');
    }
  }

  public function proses_databarang_claim_insert()
  {
    if($this->session->userdata('status') == 'login'){
      $this->form_validation->set_rules('tanggal','Tanggal','required');
    $this->form_validation->set_rules('customer','Nama Customer','required');
    $this->form_validation->set_rules('mekanik','Mekanik','required');
    $this->form_validation->set_rules('merk_mesin','Merk Mesin','required');
    $this->form_validation->set_rules('nama_part','Nama Part','required');
    $this->form_validation->set_rules('nomor_mesin','Nomer Mesin','required');
    $this->form_validation->set_rules('jumlah','Jumlah','required');


    if($this->form_validation->run() == TRUE)
    {
      $id_claim                 = $this->input->post('id_claim',TRUE);
      $tanggal                  = $this->input->post('tanggal',TRUE);
      $nama_customer            = $this->input->post('customer',TRUE);
      $merk_mesin               = $this->input->post('merk_mesin',TRUE);
      $type_mesin               = $this->input->post('type_mesin',TRUE);
      $nomor_mesin              = $this->input->post('nomor_mesin',TRUE);
      $nama_part                = $this->input->post('nama_part',TRUE);
      $jumlah                   = $this->input->post('jumlah',TRUE);
      $penyebab_kerusakan       = $this->input->post('penyebab_kerusakan',TRUE);
      $status                   = $this->input->post('status',TRUE);
      $keterangan               = $this->input->post('keterangan',TRUE);

      if($this->session->userdata('role') == 0){ 
        $nama_mekanik                 = $this->session->userdata('name');
      }
      else {
        $nama_mekanik                 = $this->input->post('mekanik',TRUE);
      }

      $data = array(
            'id_claim'              => $id_claim,
            'tanggal_claim'         => $tanggal,
            'id_customer'           => $nama_customer,
            'mekanik'               => $nama_mekanik,
            'merk_mesin'            => $merk_mesin,
            'type_mesin'            => $type_mesin,
            'nomor_mesin'           => $nomor_mesin,
            'nama_part'             => $nama_part,
            'jumlah'                => $jumlah,
            'penyebab_kerusakan'    => $penyebab_kerusakan,
            'status'                => 'Di Ajukan',
            'keterangan'            => $keterangan

      );

      $data_report = array(
        'id_report'        => 'RP-'.date("Y").random_string('numeric', 8),
        'user_report'      => $this->session->userdata('name'),
        'jenis_report'     => 'report_claim',
        'note'             => 'Add Claim '.$id_claim. ' (' .$nama_mekanik. ')' 
      );

      $this->M_admin->insert('tb_claim_barang',$data);
      $this->M_admin->insert('tb_report',$data_report);

      $this->session->set_flashdata('msg_berhasil','Data Claim Berhasil Ditambahkan');
      redirect(base_url('admin/tabel_claimbarang'));
    }else{
      $data['nav'] = 9;
      $data['list_customer'] = $this->M_admin->select('tb_customer');
      $id_claim= $this->M_admin->generate_kode_claim('OBOR-CLM');
      $data['id_claim'] = $id_claim;
    
      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/form/form_claimbarang', $data);
      $this->load->view('component/footer');  
    }
    }else {
      $this->load->view('login/login');
    } 
    
  }

  public function proses_databarang_claim_update()
  {
    if($this->session->userdata('status') == 'login'){
      $this->form_validation->set_rules('tanggal','Tanggal','required');
      $this->form_validation->set_rules('customer','Nama Customer','required');
      $this->form_validation->set_rules('mekanik','Mekanik','required');
      $this->form_validation->set_rules('merk_mesin','Merk Mesin','required');
      $this->form_validation->set_rules('nama_part','Nama Part','required');
      $this->form_validation->set_rules('nomor_mesin','Nomer Mesin','required');
    
    if($this->form_validation->run() == TRUE)
    {
      $id_claim                 = $this->input->post('id_claim',TRUE);
      $tanggal                  = $this->input->post('tanggal',TRUE);
      $nama_customer            = $this->input->post('customer',TRUE);
      $mekanik                  = $this->input->post('mekanik',TRUE);
      $merk_mesin               = $this->input->post('merk_mesin',TRUE);
      $type_mesin               = $this->input->post('type_mesin',TRUE);
      $nomor_mesin              = $this->input->post('nomor_mesin',TRUE);
      $nama_part                = $this->input->post('nama_part',TRUE);      
      $jumlah                   = $this->input->post('jumlah',TRUE);
      $penyebab_kerusakan       = $this->input->post('penyebab_kerusakan',TRUE);
      $status                   = $this->input->post('status',TRUE);
      $keterangan               = $this->input->post('keterangan',TRUE);

      if ($status == "Selesai" || $status == "Di Tolak"){
    
        $where = array('id_claim' => $id_claim);

        $data_report = array(
          'id_report'        => 'RP-'.date("Y").random_string('numeric', 8),
          'user_report'      => $this->session->userdata('name'),
          'jenis_report'     => 'report_claim',
          'note'             => 'Status Barang '.$mekanik
        );

        $data = array(
          'id_claim'              => $id_claim,
          'tanggal_claim'         => $tanggal,
          'id_customer'           => $nama_customer,
          'mekanik'               => $mekanik,
          'merk_mesin'            => $merk_mesin,
          'type_mesin'            => $type_mesin,
          'nomor_mesin'           => $nomor_mesin,
          'nama_part'             => $nama_part,          
          'jumlah'                => $jumlah,
          'penyebab_kerusakan'    => $penyebab_kerusakan,
          'status'                => $status,
          'keterangan'            => $keterangan
        );
    
        $this->M_admin->insert('tb_report',$data_report);
        $this->M_admin->delete('tb_claim_barang',$where);
        $this->M_admin->insert('tb_report_claim',$data);


        redirect(base_url('admin/report_claim'));
      }

      else {
        $where = array('id_claim' => $id_claim);
        $data = array(
              'id_claim'              => $id_claim,
              'tanggal_claim'         => $tanggal,
              'id_customer'           => $nama_customer,
              'mekanik'               => $mekanik,
              'merk_mesin'            => $merk_mesin,
              'type_mesin'            => $type_mesin,
              'nomor_mesin'           => $nomor_mesin,
              'nama_part'             => $nama_part,              
              'jumlah'                => $jumlah,
              'penyebab_kerusakan'    => $penyebab_kerusakan,
              'status'                => $status,
              'keterangan'            => $keterangan
        );

        $data_report = array(
          'id_report'        => 'RP-'.date("Y").random_string('numeric', 8),
          'user_report'      => $this->session->userdata('name'),
          'jenis_report'     => 'report_claim',
          'note'             => 'Update Claim '.$id_claim. ' (' .$nama_mekanik. ')' 
        );
      
      $this->M_admin->update('tb_claim_barang',$data,$where);
      $this->M_admin->insert('tb_report',$data_report);

      $this->session->set_flashdata('msg_berhasil','Data Claim Berhasil Diupdate');
      redirect(base_url('admin/tabel_claimbarang'));
      }
    }else{
      $data['list_data'] = $this->M_admin->read_join('tb_claim_barang');
      $data['nav'] = 8;

      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/tabel/tabel_claimbarang',$data);
      $this->load->view('component/footer');
    }
    }else {
      $this->load->view('login/login');
    } 
  }


  ####################################
              // Customer
  ####################################

  public function form_customer()
  {
    if($this->session->userdata('status') == 'login'){
      if($this->session->userdata('role') == 0){ 
        redirect (base_url('admin/tabel_barangmasuk'));
      }
  
      $data['nav'] = 4;
  
      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/form/form_customer',$data);
      $this->load->view('component/footer');
    }else {
      $this->load->view('login/login');
    }
  }

  public function edit_customer()
  {
    if($this->session->userdata('status') == 'login'){
      if($this->session->userdata('role') == 0){ 
        redirect (base_url('admin/tabel_barangmasuk'));
      }
  
      $uri = $this->uri->segment(3);
      $where = array('id_customer' => $uri);
      $data['data_customer'] = $this->M_admin->get_data('tb_customer',$where);
      $data['nav'] = 4;
  
      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/form/form_customer',$data);
      $this->load->view('component/footer');  
    }else {
      $this->load->view('login/login');
    } 
  }

  public function tabel_customer()
  {
    if($this->session->userdata('status') == 'login'){
      if($this->session->userdata('role') == 0){ 
        redirect (base_url('admin/tabel_barangmasuk'));
      }
  
      $data['list_data'] = $this->M_admin->select('tb_customer');
      $data['nav'] = 3;
  
      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/tabel/tabel_customer',$data);
      $this->load->view('component/footer');
    }else {
      $this->load->view('login/login');
    } 
  }

  public function delete_customer()
  {
    if($this->session->userdata('status') == 'login'){
      if($this->session->userdata('role') == 0){ 
        redirect (base_url('admin/tabel_barangmasuk'));
      }
  
      $uri = $this->uri->segment(3);
      $where = array('id_customer' => $uri);
  
      $data_report = array(
        'id_report'        => 'RP-'.date("Y").random_string('numeric', 8),
        'user_report'      => $this->session->userdata('name'),
        'jenis_report'     => 'report_customer',
        'note'             => 'Delete customer'
      );
      
      $this->M_admin->insert('tb_report',$data_report);
  
      $this->M_admin->delete('tb_customer',$where);
      $this->session->set_flashdata('msg_berhasil','Data Customer Berhasil Dihapus');
      redirect(base_url('admin/tabel_customer'));
    }else {
      $this->load->view('login/login');
    } 
  }

  public function proses_customer_insert()
  {
    if($this->session->userdata('status') == 'login'){
      if($this->session->userdata('role') == 0){ 
        redirect (base_url('admin/tabel_barangmasuk'));
      }
      $this->form_validation->set_rules('nama_customer','Nama customer','trim|required|max_length[100]');
      $this->form_validation->set_rules('lokasi','Lokasi customer','trim|required|max_length[250]');
  
      if($this->form_validation->run() ==  TRUE)
      {
        $lokasi = $this->input->post('lokasi' ,TRUE);
        $nama_customer = $this->input->post('nama_customer' ,TRUE);
  
        $data = array(
              'lokasi'        => $lokasi,
              'nama_customer' => $nama_customer
        );
  
        $data_report = array(
          'id_report'        => 'RP-'.date("Y").random_string('numeric', 8),
          'user_report'      => $this->session->userdata('name'),
          'jenis_report'     => 'report_customer',
          'note'             => 'Add customer' .' (' .$nama_customer. ')'
        );
        
        $this->M_admin->insert('tb_report',$data_report);
        
        $this->M_admin->insert('tb_customer',$data);
  
        $this->session->set_flashdata('msg_berhasil','Data customer Berhasil Ditambahkan');
        redirect(base_url('admin/tabel_customer'));
      }else {
        $data['list_data'] = $this->M_admin->select('tb_customer');
        $data['nav'] = 4;
  
        // Load View
        $this->load->view('component/header');
        $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
        $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
        $this->load->view('admin/form/form_customer',$data);
        $this->load->view('component/footer');
      }
    }else {
      $this->load->view('login/login');
    } 
  }

  public function proses_customer_update()
  {
    if($this->session->userdata('status') == 'login'){
      $this->form_validation->set_rules('nama_customer','Nama customer','trim|required|max_length[100]');
    $this->form_validation->set_rules('lokasi','Lokasi customer','trim|required|max_length[250]');

    if($this->form_validation->run() ==  TRUE)
    {
      $id_customer   = $this->input->post('id_customer' ,TRUE);
      $lokasi = $this->input->post('lokasi' ,TRUE);
      $nama_customer = $this->input->post('nama_customer' ,TRUE);

      $where = array(
            'id_customer' => $id_customer
      );

      $data = array(
            'lokasi' => $lokasi,
            'nama_customer' => $nama_customer
      );

      $data_report = array(
        'id_report'        => 'RP-'.date("Y").random_string('numeric', 8),
        'user_report'      => $this->session->userdata('name'),
        'jenis_report'     => 'report_customer',
        'note'             => 'Update customer' .' (' .$nama_customer. ')'
      );
      
      $this->M_admin->insert('tb_report',$data_report);

      $this->M_admin->update('tb_customer',$data,$where);

      $this->session->set_flashdata('msg_berhasil','Data customer Berhasil Di Update');
      redirect(base_url('admin/tabel_customer'));
    }else {
      $data['list_data'] = $this->M_admin->select('tb_customer');
      $data['nav'] = 3;
  
      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/tabel/tabel_customer',$data);
      $this->load->view('component/footer');
    }
    }else {
      $this->load->view('login/login');
    } 
  }

  ####################################
            // END Costumer
  ####################################


  ####################################
        // Report
  ####################################

  public function report($id)
  {
    if($this->session->userdata('status') == 'login'){
      $data['nav'] = 7;
      $month = $this->input->post('month');
      $year = $this->input->post('year');
      
      $data['month'] = $month;
      $data['year'] = $year;

      // If user click submit
      if($id == 1){

        $data['barkel'] = $this->M_admin->get_data_report('tb_barang_keluar',$month,$year,'tanggal_keluar');

        $data['flag'] = 2;

      }else if($id == 2){

        $data['barmas'] = $this->M_admin->get_data_report_masuk('tb_barang_masuk',$month,$year,'tanggal');

        $data['flag'] = 1;

      }else if($id == 3){

          $data['clabar'] = $this->M_admin->get_data_report('tb_claim_barang',$month,$year,'tanggal');
    
          $data['flag'] = 3;

      }else{
        $data['flag'] = 0;
      }

      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/tabel/report',$data);
      $this->load->view('component/footer');
      
    }else {
      $this->load->view('login/login');
    }
  }

  public function report_claim()
  {
    if($this->session->userdata('status') == 'login'){
      $data['list_data'] = $this->M_admin->read_join('tb_report_claim');
      $data['nav'] = 10;

      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/tabel/tabel_reportclaim',$data);
      $this->load->view('component/footer');
    }else {
      $this->load->view('login/login');
    } 
  }

  public function report_kegiatan()
  {
    if($this->session->userdata('status') == 'login'){
      $data['list_data'] = $this->M_admin->select('tb_report');
      $data['nav'] = 10;

      // Load View
      $this->load->view('component/header');
      $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
      $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
      $this->load->view('admin/report_kegiatan',$data);
      $this->load->view('component/footer');
    }else {
      $this->load->view('login/login');
    } 
    
  }

  ####################################
           // End Report
  ####################################
}
?>
