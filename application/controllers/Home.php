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
		if ($this->session->has_userdata('login')) {
			$page['result'] = $this->Crud->get_user_management_data();
			$this->load->view('header');
			$this->load->view('user_management', $page);
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
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
				$data['status'] = $this->input->post('status');
				$password = $this->input->post('password');
				$data['password'] = password_hash($password, PASSWORD_DEFAULT);
				
				if ($this->input->post('sav-typ') == 'edit') {
					$data['id'] = $this->input->post('id');
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
		if ($this->session->has_userdata('login')) {
			$page['result'] = $this->Crud->get_mobile_management_data();
			$this->load->view('header');
			$this->load->view('mobile_management', $page);
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

	// Add or update the mobiles
	public function add_update_mobile() {
		if ($this->session->has_userdata('login')) {
			// Set validation rules
			$this->form_validation->set_rules('company_model', 'Company Model', 'required');
			$this->form_validation->set_rules('android_version', 'Android Version', 'required');
			$this->form_validation->set_rules('imei_number', 'IMEI Number', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">All fields are required!! Please try again.</div>');
				redirect(base_url() . 'home/mobile_management', 'refresh');
			} else {
				$data['company_model'] = $this->input->post('company_model');
				$data['android_version'] = $this->input->post('android_version');
				$data['imei_number'] = $this->input->post('imei_number');
				$data['status'] = $this->input->post('status');
				
				if ($this->input->post('sav-typ') == 'edit') {
					$data['id'] = $this->input->post('id');
					$result = $this->Crud->edit_mobile($data);
					if($result) {
						$this->session->set_flashdata('msg', '<div class="alert alert-success
						text-center">Mobile Updated Successfully.</div>');
						redirect(base_url() . 'home/mobile_management', 'refresh');
					} else {
						$this->session->set_flashdata('msg', '<div class="alert alert-danger
						text-center">Mobile updation failed. Please try again.</div>');
						redirect(base_url() . 'home/mobile_management', 'refresh');
					}
				} else {
					$result = $this->Crud->insert_mobile($data);
					if($result) {
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Mobile Added Successfully.</div>');
						redirect(base_url() . 'home/mobile_management', 'refresh');
						
					} else {
						$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Mobile Can\'t Add.</div>');
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
			$table = 'mobile_management';
			$result = $this->Crud->deleteCommonFunction($userId, $table);
			if($result) {
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Mobile Deleted Successfully.</div>');
				echo 1;
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Mobile Can\'t Delete.</div>');
				echo 0;
			}
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

	// Facebook Management
	public function facebook_management()
	{
		if ($this->session->has_userdata('login')) {
			$page['result'] = $this->Crud->get_facebook_management_data();
			$this->load->view('header');
			$this->load->view('facebook_management', $page);
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

	// Add or update the facebook accounts
	public function add_update_facebook() {
		if ($this->session->has_userdata('login')) {
			// Set validation rules
			$this->form_validation->set_rules('company_model', 'Company Model', 'required');
			$this->form_validation->set_rules('android_version', 'Android Version', 'required');
			$this->form_validation->set_rules('imei_number', 'IMEI Number', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">All fields are required!! Please try again.</div>');
				redirect(base_url() . 'home/facebook_management', 'refresh');
			} else {
				$data['company_model'] = $this->input->post('company_model');
				$data['android_version'] = $this->input->post('android_version');
				$data['imei_number'] = $this->input->post('imei_number');
				$data['status'] = $this->input->post('status');
				
				if ($this->input->post('sav-typ') == 'edit') {
					$data['id'] = $this->input->post('id');
					$result = $this->Crud->edit_facebook($data);
					if($result) {
						$this->session->set_flashdata('msg', '<div class="alert alert-success
						text-center">Facebook Account Updated Successfully.</div>');
						redirect(base_url() . 'home/facebook_management', 'refresh');
					} else {
						$this->session->set_flashdata('msg', '<div class="alert alert-danger
						text-center">Facebook Account updation failed. Please try again.</div>');
						redirect(base_url() . 'home/facebook_management', 'refresh');
					}
				} else {
					$result = $this->Crud->insert_facebook($data);
					if($result) {
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Facebook Account Added Successfully.</div>');
						redirect(base_url() . 'home/facebook_management', 'refresh');
						
					} else {
						$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Facebook Account Can\'t Add.</div>');
						redirect(base_url() . 'home/facebook_management', 'refresh');
					}
				}
			}
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

	// Delete the user 
	public function delete_facebook() {
		if ($this->session->has_userdata('login')) {
			$userId = $this->uri->segment(3);
			$table = 'facebook_management';
			$result = $this->Crud->deleteCommonFunction($userId, $table);
			if($result) {
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Facebook Account Deleted Successfully.</div>');
				echo 1;
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Facebook Account Can\'t Delete.</div>');
				echo 0;
			}
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

}