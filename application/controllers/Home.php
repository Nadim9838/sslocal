<?php defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');

class Home extends CI_Controller {

    // Call constructer function
    public function __construct() {
        parent::__construct();
        $this->load->model('Crud');
    }

    // First time this function call
    public function index()
	{
		redirect(base_url() . 'home/login');
	}

    // Login page
    public function login()
	{
		$this->load->view('outer_header');
		$this->load->view('login');
	}

    // User login authentication
    public function userLoginAuth()	{
		// Set validation rules
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Failed!! Please try again.</div>');
            $this->load->view('outer_header');
            $this->load->view('login');
			// $password = password_hash('nadim123', PASSWORD_DEFAULT);
			// log_message('error', $password);
        } else {
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			
			// Authenticate the user
            $userData = $this->Crud->userLoginAuth($email, $password);
			if($userData) {
				$this->session->set_userdata('login', $userData);
				// Set user permissions on session
				$permissions = $this->Crud->get_user_login_permissions($userData['id']);
				$this->session->set_userdata('permissions', $permissions);
				redirect(base_url() . 'home/dashboard', 'refresh');
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid email or password. Please try again.</div>');
				$this->load->view('outer_header');
				$this->load->view('login');
			}
		}
	}

	// Logout the user
	public function logout()
	{
		$this->session->unset_userdata('permissions');
		$this->session->unset_userdata('login');
		$this->session->sess_destroy();
		redirect(base_url() . 'home/login', 'refresh');
	}

	// Dashboard page
	public function dashboard()
	{
		if ($this->session->has_userdata('login')) {
			$this->load->view('header');
			$this->load->view('dashboard');
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

	// User Management
	public function user_management()
	{
		$page['result'] = $this->Crud->get_user_management_data();
		$this->load->view('header');
		$this->load->view('user_management', $page);
	}

	// Add or update the users
	public function add_update_user() {
		if ($this->session->has_userdata('login')) {
			// Set validation rules
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('mobile', 'Mobile', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">All fields are required!! Please try again.</div>');
				redirect(base_url() . 'home/user_management', 'refresh');
			} else {
				$data['name'] = $this->input->post('name');
				$data['email'] = $this->input->post('email');
				$data['mobile'] = $this->input->post('mobile');
				$password = $this->input->post('password');
				$data['password'] = password_hash($password, PASSWORD_DEFAULT);
				
				if ($this->input->post('sav-typ') == 'edit') {
					$data['id'] = $this->input->post('id');
					$message = "User Updated Successfully!";
					$result = $this->Crud->edit_user($data);
					if($result) {
						$this->session->set_flashdata('msg', '<div class="alert alert-success
						text-center">User Updated Successfully.</div>');
						redirect(base_url() . 'home/user_management', 'refresh');
					} else {
						$this->session->set_flashdata('msg', '<div class="alert alert-danger
						text-center">User updation failed. Please try again.</div>');
						redirect(base_url() . 'home/user_management', 'refresh');
					}
				} else {
					$result = $this->Crud->insert_user($data);
					if($result) {
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">User Added Successfully.</div>');
						redirect(base_url() . 'home/user_management', 'refresh');
						
					} else {
						$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">User Can\'t Add.</div>');
						redirect(base_url() . 'home/user_management', 'refresh');
					}
				}
			}
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

	// Delete the user 
	public function delete_user() {
		if ($this->session->has_userdata('login')) {
			$userId = $this->uri->segment(3);
			$result = $this->Crud->delete_user($userId);
			if($result) {
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">User Deleted Successfully.</div>');
				echo 1;
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">User Can\'t Delete.</div>');
				echo 0;
			}
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

	// Get user permissions
    public function get_user_permissions() {
		if ($this->session->has_userdata('login')) {
			$userId = $this->uri->segment(3);
			$data['permissions'] = $this->Crud->get_user_permissions($userId);
			echo json_encode($data['permissions']);
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
    }

	// Set user permissions
	public function set_user_permissions() {
		if ($this->session->has_userdata('login')) {
			$user_id = $this->input->post('user_id');
			$permissions = $this->input->post('permissions');

			if ($this->Crud->update_user_permissions($user_id, $permissions)) {
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Permissions  Updated Successfully.</div>');
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Failed to update permissions.</div>');
			}
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
    }

	// User Management
	public function mobile_management()
	{
		$page['result'] = $this->Crud->get_mobile_management_data();
		$this->load->view('header');
		$this->load->view('mobile_management', $page);
	}

	// Add or update the mobiles
	public function add_update_mobile() {
		if ($this->session->has_mobiledata('login')) {
			// Set validation rules
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('mobile', 'Mobile', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">All fields are required!! Please try again.</div>');
				redirect(base_url() . 'home/mobile_management', 'refresh');
			} else {
				$data['name'] = $this->input->post('name');
				$data['email'] = $this->input->post('email');
				$data['mobile'] = $this->input->post('mobile');
				$data['status'] = $this->input->post('status');
				$password = $this->input->post('password');
				$data['password'] = password_hash($password, PASSWORD_DEFAULT);
				
				if ($this->input->post('sav-typ') == 'edit') {
					$data['id'] = $this->input->post('id');
					$message = "User Updated Successfully!";
					$result = $this->Crud->edit_mobile($data);
					if($result) {
						$this->session->set_flashdata('msg', '<div class="alert alert-success
						text-center">User Updated Successfully.</div>');
						redirect(base_url() . 'home/mobile_management', 'refresh');
					} else {
						$this->session->set_flashdata('msg', '<div class="alert alert-danger
						text-center">User updation failed. Please try again.</div>');
						redirect(base_url() . 'home/mobile_management', 'refresh');
					}
				} else {
					$result = $this->Crud->insert_mobile($data);
					if($result) {
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">User Added Successfully.</div>');
						redirect(base_url() . 'home/mobile_management', 'refresh');
						
					} else {
						$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">User Can\'t Add.</div>');
						redirect(base_url() . 'home/mobile_management', 'refresh');
					}
				}
			}
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

	// Delete the user 
	public function delete_mobile() {
		if ($this->session->has_userdata('login')) {
			$userId = $this->uri->segment(3);
			$result = $this->Crud->delete_mobile($userId);
			if($result) {
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">User Deleted Successfully.</div>');
				echo 1;
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">User Can\'t Delete.</div>');
				echo 0;
			}
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

}