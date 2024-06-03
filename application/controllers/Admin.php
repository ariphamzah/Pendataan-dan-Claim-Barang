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
    $data['token_generate'] = $this->token_generate();
    $this->session->set_userdata($data);
    $data['nav'] = 5;

    // Load View
    $this->load->view('component/header');
    $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
    $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
    $this->load->view('admin/profile',$data);
    $this->load->view('component/footer');
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
      $this->load->view('admin/profile');
    }
  }

  public function proses_gambar_upload()
  {
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
  }

  ####################################
           // End Profile
  ####################################



  ####################################
              // Users
  ####################################
  public function users()
  {
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
  }

  public function form_user()
  {
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
  }

  public function edit_user()
  {
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
  }

  public function update_user()
  {
    if($this->session->userdata('role') == 0){ 
      redirect (base_url('admin/tabel_barangmasuk'));
    }

    $id = $this->uri->segment(3);
    $where = array('id' => $id);
    $data['token_generate'] = $this->token_generate();
    $data['list_data'] = $this->M_admin->get_data('user',$where);
    $this->session->set_userdata($data);
    $this->load->view('admin/form/form_users',$data);
  }

  public function proses_delete_user()
  {
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
      'note'             => 'Delete User '.$username
    );
    
    $this->M_admin->insert('tb_report',$data_report);

    $this->session->set_flashdata('msg_berhasil','User Behasil Di Delete');
    redirect(base_url('admin/users'));

  }

  public function proses_reset_user()
  {
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
      'note'             => 'Reset Password User '.$reset
    );
    
    $this->M_admin->insert('tb_report',$data_report);

    $this->M_admin->update_password('user',$where,$data);

    $this->session->set_flashdata('msg_berhasil','Password Telah Direset');
    redirect(base_url('admin/users'));
  }

  public function proses_tambah_user()
  {
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
            'note'             => 'Add User '.$username
          );
          
          $this->M_admin->insert('tb_report',$data_report);
  
          $this->M_login->insert('user',$data);
  
          $this->session->set_flashdata('msg_terdaftar','User Berhasil Ditambahkan');
          redirect(base_url('admin/users'));
        }}
      }else {
        $this->load->view('admin/form/form_users',$data);
    }
  }

  public function proses_update_user()
  {
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
          'note'             => 'Update User '.$username
        );
        
        $this->M_admin->insert('tb_report',$data_report);

        $this->M_admin->update('user',$data,$where);
        $this->session->set_flashdata('msg_berhasil','Data User Berhasil Diupdate');
        redirect(base_url('admin/users'));
       }
    }else{
        $this->load->view('admin/form/form_users');
    }
  }


  ####################################
           // End Users
  ####################################



  ####################################
        // Report
  ####################################

  public function report($id)
  {
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

      $data['barmas'] = $this->M_admin->get_data_report('tb_barang_masuk',$month,$year,'tanggal');

      $data['flag'] = 1;

    }else{
      $data['flag'] = 0;
    }

    // Load View
    $this->load->view('component/header');
    $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
    $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
    $this->load->view('admin/tabel/report',$data);
    $this->load->view('component/footer');
  }

  ####################################
           // Report
  ####################################



  ####################################
        // DATA BARANG MASUK
  ####################################

  public function form_barangmasuk()
  {
    if($this->session->userdata('role') == 0){ 
      redirect (base_url('admin/tabel_barangmasuk'));
    }
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['nav'] = 0;
    
    // Load View
    $this->load->view('component/header');
    $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
    $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
    $this->load->view('admin/form/form_barangmasuk', $data);
    $this->load->view('component/footer');  
  }

  public function edit_barangmasuk($id_transaksi)
  {
    if($this->session->userdata('role') == 0){ 
      redirect (base_url('admin/tabel_barangmasuk'));
    }

    $where = array('id_transaksi' => $id_transaksi);
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['masuk'] = $this->M_admin->get_data('tb_barang_masuk',$where);
    $data['nav'] = 0;
    
    // Load View
    $this->load->view('component/header');
    $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
    $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
    $this->load->view('admin/form/form_barangmasuk', $data);
    $this->load->view('component/footer');  
  }

  public function tabel_barangmasuk()
  {
    $data['list_data'] = $this->M_admin->read_join('tb_barang_masuk');
    $data['nav'] = 1;

    // Load View
    $this->load->view('component/header');
    $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
    $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
    $this->load->view('admin/tabel/tabel_barangmasuk',$data);
    $this->load->view('component/footer');
  }

  public function tabel_claimbarang()
  {
    $data['list_data'] = $this->M_admin->select('tb_claim_barang');
    $data['nav'] = 8;

    // Load View
    $this->load->view('component/header');
    $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
    $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
    $this->load->view('admin/tabel/tabel_claimbarang',$data);
    $this->load->view('component/footer');
  }

  public function form_claimbarang()
  {
    if($this->session->userdata('role') == 0){ 
      redirect (base_url('admin/tabel_claimbarang'));
    }
    $data['list_claim'] = $this->M_admin->select('tb_claim_barang');
    $data['nav'] = 9;
    
    // Load View
    $this->load->view('component/header');
    $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
    $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
    $this->load->view('admin/form/form_claimbarang', $data);
    $this->load->view('component/footer');  
  }

  public function edit_claimbarang()
  {
    if($this->session->userdata('role') == 0){ 
      redirect (base_url('admin/tabel_claimbarang'));
    }

    $where = array('id_claim' => $id_claim);
    $data['list_claim'] = $this->M_admin->select('tb_claim_barang');
    $data['masuk'] = $this->M_admin->get_data('tb_barang_masuk',$where);
    $data['nav'] = 0;
    
    // Load View
    $this->load->view('component/header');
    $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
    $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
    $this->load->view('admin/form/form_barangmasuk', $data);
    $this->load->view('component/footer');  
  }

  public function delete_barang($id_transaksi)
  {
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
    redirect(base_url('admin/tabel_barangmasuk'));
  }



  public function proses_databarang_masuk_insert()
  {
    $this->form_validation->set_rules('lokasi','Lokasi','required');
    $this->form_validation->set_rules('kode_barang','Kode Barang','required');
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
            'id_satuan'       => $satuan,
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
      $data['list_satuan'] = $this->M_admin->select('tb_satuan');
      $this->load->view('admin/form/form_barangmasuk',$data);
    }
  }

  public function proses_databarang_masuk_update()
  {
    $this->form_validation->set_rules('lokasi','Lokasi','required');
    $this->form_validation->set_rules('kode_barang','Kode Barang','required');
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
            'id_satuan'    => $satuan,
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
      $this->load->view('admin/form/form_barangmasuk');
    }
  }
  ####################################
      // END DATA BARANG MASUK
  ####################################


  ####################################
              // SATUAN
  ####################################

  public function form_satuan()
  {
    if($this->session->userdata('role') == 0){ 
      redirect (base_url('admin/tabel_barangmasuk'));
    }

    $data['nav'] = 4;

    // Load View
    $this->load->view('component/header');
    $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
    $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
    $this->load->view('admin/form/form_satuan',$data);
    $this->load->view('component/footer');
  }

  public function edit_satuan()
  {
    if($this->session->userdata('role') == 0){ 
      redirect (base_url('admin/tabel_barangmasuk'));
    }

    $uri = $this->uri->segment(3);
    $where = array('id_satuan' => $uri);
    $data['data_satuan'] = $this->M_admin->get_data('tb_satuan',$where);
    $data['nav'] = 4;

    // Load View
    $this->load->view('component/header');
    $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
    $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
    $this->load->view('admin/form/form_satuan',$data);
    $this->load->view('component/footer');
  }

  public function tabel_satuan()
  {
    if($this->session->userdata('role') == 0){ 
      redirect (base_url('admin/tabel_barangmasuk'));
    }

    $data['list_data'] = $this->M_admin->select('tb_satuan');
    $data['nav'] = 3;

    // Load View
    $this->load->view('component/header');
    $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
    $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
    $this->load->view('admin/tabel/tabel_satuan',$data);
    $this->load->view('component/footer');
  }

  public function delete_satuan()
  {
    if($this->session->userdata('role') == 0){ 
      redirect (base_url('admin/tabel_barangmasuk'));
    }

    $uri = $this->uri->segment(3);
    $where = array('id_satuan' => $uri);

    $data_report = array(
      'id_report'        => 'RP-'.date("Y").random_string('numeric', 8),
      'user_report'      => $this->session->userdata('name'),
      'jenis_report'     => 'report_satuan',
      'note'             => 'Delete Satuan'
    );
    
    $this->M_admin->insert('tb_report',$data_report);

    $this->M_admin->delete('tb_satuan',$where);
    redirect(base_url('admin/tabel_satuan'));
  }

  public function proses_satuan_insert()
  {
    if($this->session->userdata('role') == 0){ 
      redirect (base_url('admin/tabel_barangmasuk'));
    }
    
    $this->form_validation->set_rules('kode_satuan','Kode Satuan','trim|required|max_length[100]');
    $this->form_validation->set_rules('nama_satuan','Nama Satuan','trim|required|max_length[100]');

    if($this->form_validation->run() ==  TRUE)
    {
      $kode_satuan = $this->input->post('kode_satuan' ,TRUE);
      $nama_satuan = $this->input->post('nama_satuan' ,TRUE);

      $data = array(
            'kode_satuan' => $kode_satuan,
            'nama_satuan' => $nama_satuan
      );

      $data_report = array(
        'id_report'        => 'RP-'.date("Y").random_string('numeric', 8),
        'user_report'      => $this->session->userdata('name'),
        'jenis_report'     => 'report_satuan',
        'note'             => 'Add Satuan'
      );
      
      $this->M_admin->insert('tb_report',$data_report);
      
      $this->M_admin->insert('tb_satuan',$data);

      $this->session->set_flashdata('msg_berhasil','Data satuan Berhasil Ditambahkan');
      redirect(base_url('admin/tabel_satuan'));
    }else {
      $this->load->view('admin/form/form_satuan');
    }
  }

  public function proses_satuan_update()
  {
    $this->form_validation->set_rules('kode_satuan','Kode Satuan','trim|required|max_length[100]');
    $this->form_validation->set_rules('nama_satuan','Nama Satuan','trim|required|max_length[100]');

    if($this->form_validation->run() ==  TRUE)
    {
      $id_satuan   = $this->input->post('id_satuan' ,TRUE);
      $kode_satuan = $this->input->post('kode_satuan' ,TRUE);
      $nama_satuan = $this->input->post('nama_satuan' ,TRUE);

      $where = array(
            'id_satuan' => $id_satuan
      );

      $data = array(
            'kode_satuan' => $kode_satuan,
            'nama_satuan' => $nama_satuan
      );

      $data_report = array(
        'id_report'        => 'RP-'.date("Y").random_string('numeric', 8),
        'user_report'      => $this->session->userdata('name'),
        'jenis_report'     => 'report_satuan',
        'note'             => 'Update Satuan'
      );
      
      $this->M_admin->insert('tb_report',$data_report);

      $this->M_admin->update('tb_satuan',$data,$where);

      $this->session->set_flashdata('msg_berhasil','Data satuan Berhasil Di Update');
      redirect(base_url('admin/tabel_satuan'));
    }else {
      $this->load->view('admin/form/form_satuan');
    }
  }

  ####################################
            // END SATUAN
  ####################################


  ####################################
     // DATA MASUK KE DATA KELUAR
  ####################################

  public function barang_keluar()
  {
    
    $uri = $this->uri->segment(3);
    $where = array( 'id_transaksi' => $uri);
    $data['list_data'] = $this->M_admin->get_data('tb_barang_masuk',$where);
    $data['list_satuan'] = $this->M_admin->select('tb_satuan');
    $data['nav'] = 2;

    // Load View
    $this->load->view('component/header');
    $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
    $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
    $this->load->view('admin/form/form_pindahbarang',$data);
    $this->load->view('component/footer');
  }

  public function proses_data_keluar()
  {
    $this->form_validation->set_rules('tanggal_keluar','Tanggal Keluar','trim|required');
    if($this->form_validation->run() === TRUE)
    {
      $id_transaksi   = $this->input->post('id_transaksi',TRUE);
      $costumer       = $this->input->post('customer',TRUE);
      $tanggal_masuk  = $this->input->post('tanggal',TRUE);
      $tanggal_keluar = $this->input->post('tanggal_keluar',TRUE);
      $lokasi         = $this->input->post('lokasi',TRUE);
      $merk           = $this->input->post('merk_barang',TRUE);
      $kode_barang    = $this->input->post('kode_barang',TRUE);
      $nama_barang    = $this->input->post('nama_barang',TRUE);
      $satuan         = $this->input->post('satuan',TRUE);
      $jumlah         = $this->input->post('jumlah',TRUE);

      $where = array( 'id_transaksi' => $id_transaksi);
      $data = array(
              'id_transaksi'    => $id_transaksi,
              'customer'        => $costumer,
              'tanggal_masuk'   => $tanggal_masuk,
              'tanggal_keluar'  => $tanggal_keluar,
              'lokasi'          => $lokasi,
              'merk'            => $merk,
              'kode_barang'     => $kode_barang,
              'nama_barang'     => $nama_barang,
              'id_satuan'          => $satuan,
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
      $this->load->view('form/form_pindahbarang/'.$id_transaksi);
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
    $data['list_data'] = $this->M_admin->read_join('tb_barang_keluar');
    $data['nav'] = 2;

    // Load View
    $this->load->view('component/header');
    $data['main_header'] = $this->load->view('component/main_header', $data, TRUE);
    $data['sidebar'] = $this->load->view('component/sidebar', NULL, TRUE);
    $this->load->view('admin/tabel/tabel_barangkeluar',$data);
    $this->load->view('component/footer');
  }

  ####################################
            // CLAIM BARANG
  ####################################

  

}
?>
