<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
	{
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('addmole');

    }

    public function index()
    {
        $data['title'] = "Dashboard";
        $this->load->view('templates/header', $data);
        $this->load->view('admin/index');
        $this->load->view('templates/footer');
    }


    public function add_mole()
    {
        $data['title'] = "Tambah Mole";
		$data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


        $this->form_validation->set_rules('nama', "Nama", 'required|trim');
        $this->form_validation->set_rules('jumlah', "Jumlah", 'required|trim');
        $this->form_validation->set_rules('harga', "Harga", 'required|trim');
        $this->form_validation->set_rules('file', 'Image', 'file_type[image/jpeg|image/gif|image/png|image/jpg|image/heic');

        if ($this->form_validation->run() == false) {
            
        $this->load->view('templates/header', $data);
        $this->load->view('admin/add_mole', $data);
        $this->load->view('templates/footer', $data);

        }else {

           
			$config['upload_path']          = 'uploads/';
			$config['allowed_types']        = 'gif|jpg|png|jpeg|heic';
			$config['max_size']             = 5000;

            
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

            if (!$this->upload->do_upload('file')) {
				$error = array('error' => $this->upload->display_errors());
				$this->load->view('admin/template/header', $error);
				$this->load->view('admin/add', $error);
				$this->load->view('admin/template/footer', $error);
			}else {

             $data_image = $this->upload->data();


              $image = $data_image['file_name'];

              $data = [
                  'nama_produk' => $this->input->post('nama', true),
                  'jumlah_produk' => $this->input->post('jumlah', true),
                  'harga_produk' => $this->input->post('harga', true),
                  'image' => $image
              ];

              $this->addmole->insert($data, 'produk');


              $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
              Tambah Data Produk Berhasil </div>');
             redirect('admin/add_mole');

            }


        }

    }
}