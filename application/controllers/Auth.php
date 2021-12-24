<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		// $this->load->model('logactivity');
	}

	public function index()
	{
		$this->load->view('auth/login');
	}

	public function login()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');

		if ($this->form_validation->run() == false) {
			$this->load->view('auth/login');
		} else {

			$this->_login();
		}
	}


	private function _login()
	{
		$email =  $this->input->post('email');
		$password = $this->input->post('password');

		$user = $this->db->get_where('user', ['email' => $email])->row_array();

		if ($user) {

			if ($user['is_active'] == 0) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Your email is not been actived! </div>');
				redirect('auth/login');
			} else {

				if (password_verify($password, $user['password'])) {

					$data = [
						'email' => $user['email']
					];

					$this->session->set_userdata($data);

						redirect('admin');
					
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Your password is wrong! </div>');
					redirect('auth/login');
				}
			}
		} else {


			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Your email is not register! </div>');
			redirect('auth/login');
		}
	}

	public function registration()
	{


		//validsari form regiter
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules(
			'password',
			'Password',
			'required|trim|min_length[6]',
			[
				'matches' => 'Password not match!',
				'min_length' => 'Password too short!'
			]
		);


		if ($this->form_validation->run() == false) {
			$this->load->view('auth/register');
		} else {

			$email = $this->input->post('email', true);
			$data = [

				'name' => htmlspecialchars($this->input->post('name', true)),
				'email' => htmlspecialchars($email),
				'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'is_active' => 1
			];

		

			$this->db->insert('user', $data);


			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Congratulations! your account has been be created </div>');
			redirect('auth');
		}
	}

	

	public function logout()
	{
		$user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
		$data_log = [
			'id_users' => $user['id'],
			'aksi' => 'Logout ' . ' ' . $user['nama_lengkap']
		];
		$this->db->set('waktu', 'NOW()', FALSE);
		// $this->logactivity->insert_activity($data_log, 'log_aktivitas');

		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            You have been logout account </div>');
		redirect('auth/login');
	}
	



}
