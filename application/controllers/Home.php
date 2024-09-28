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

	/** ------------------------------User Management---------------------------- */
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
				$password = $this->input->post('password');
				$data['password'] = password_hash($password, PASSWORD_DEFAULT);
				if($this->input->post('status') === '1' || $this->input->post('status') === '0') {
					$data['status'] = $this->input->post('status');
				}
				
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

	/** ------------------------------Mobile Management---------------------------- */
	// User Management
	public function mobile_management()
	{
		if ($this->session->has_userdata('login')) {
			$page['result'] = $this->Crud->get_mobile_management_data();
			$page['totalFacebookAccount'] = $this->Crud->getTotalAccounts('fb_account_management');
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
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">All fields are required!! Please try again.</div>');
				redirect(base_url() . 'home/mobile_management', 'refresh');
			} else {
				$data['company_model'] = $this->input->post('company_model');
				$data['android_version'] = $this->input->post('android_version');
				$data['imei_number'] = $this->input->post('imei_number');
				if($this->input->post('status') === '1' || $this->input->post('status') === '0') {
					$data['status'] = $this->input->post('status');
				}
				
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
		
	// Fetch social media accounts
	public function fetch_social_media_accounts()
	{
		if ($this->session->has_userdata('login')) {
			if ($this->input->post('social_app')) {
				$socialApp = $this->input->post('social_app');
				$tableName = '';
				if($socialApp == 'facebook1' || $socialApp == 'facebook2') {
					$tableName = 'fb_account_management';
				} elseif($socialApp == 'instagram1' || $socialApp == 'instagram2') {
					$tableName = 'instagram_management';
				} elseif($socialApp == 'twitter1' || $socialApp == 'twitter2') {
					$tableName = 'twitter_management';
				} elseif($socialApp == 'youtube1' || $socialApp == 'youtube2') {
					$tableName = 'youtube_management';
				} elseif($socialApp == 'tiktok1' || $socialApp == 'tiktok2') {
					$tableName = 'tiktok_management';
				} elseif($socialApp == 'whatsapp1' || $socialApp == 'whatsapp2') {
					$tableName = 'whatsapp_management';
				}

				echo $this->Crud->fetch_social_media_accounts($tableName);
			}
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

	// Save mobile social media accounts in mobile
	public function save_mobile_accounts() {
		if ($this->session->has_userdata('login')) {
			$platforms = $this->input->post('platform');
			$app_series = $this->input->post('app_series');
			$accounts = $this->input->post('accounts'); 
			$mobileId = $this->input->post('mobile_id');
			$tableName = '';

			$data = [];
			
			foreach ($platforms as $key => $platform) {
				$data[] = [
					'mobile_id' => $mobileId,
					'platform' => $platform,
					'app_series' => $app_series[$key],
					'account' => $accounts[$key],
				];

				if ($platform == 'facebook') {
					$tableName = 'fb_account_management';
					$this->Crud->update_facebook_availability($accounts[$key], $tableName);
				} elseif($platform == 'instagram') {
					$tableName = 'instagram_management';
					$this->Crud->update_instagram_availability($accounts[$key], $tableName);
				}
			}

			$result = $this->Crud->save_mobile_accounts($mobileId, $data);
			if($result) {
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Social Media Account Added Successfully.</div>');
				redirect(base_url() . 'home/mobile_management', 'refresh');
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Facebook Accounts Can\'t Added.</div>');
				redirect(base_url() . 'home/mobile_management', 'refresh');
			}
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

	// Get saved social media accounts from mobile
	public function get_saved_social_media_accounts() {
		if ($this->session->has_userdata('login')) {
			$mobileId = $this->input->post('mobile_id');
			$savedAccounts = $this->Crud->get_saved_social_media_accounts($mobileId);
			echo json_encode(['saved_accounts' => $savedAccounts]);
		} else {
			redirect(base_url(). 'home/login', 'refresh');
		}
	}

	// Delete  the social media accounts from mobile 
	public function delete_social_media_account() {
		$accountId = $this->input->post('id');
		$platform = $this->input->post('platform');

		if ($accountId && $platform) {
			$deleted = $this->Crud->delete_social_media_account($accountId, $platform);
			if ($deleted) {
				echo $deleted;
			} else {
				echo false;
			}
		} else {
			echo false;
		}
	}

	/** ------------------------------Facebook Management---------------------------- */
	// Facebook Account Management
	public function fb_account_management()
	{
		if ($this->session->has_userdata('login')) {
			$page['result'] = $this->Crud->get_fb_account_management_data();
			$this->load->view('header');
			$this->load->view('fb_account_management', $page);
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

	// Add or update the facebook accounts
	public function add_update_fb_account() {
		if ($this->session->has_userdata('login')) {
			// Set validation rules
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('profile_link', 'Profile Link', 'required');
			$this->form_validation->set_rules('account_id', 'Facebook Id', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('mobile', 'Mobile', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('gender', 'Gender', 'required');
			$this->form_validation->set_rules('religion', 'Religion', 'required');
			$this->form_validation->set_rules('cast', 'cast', 'required');
			$this->form_validation->set_rules('dob', 'DOB', 'required');
			$this->form_validation->set_rules('age', 'Age', 'required');
			$this->form_validation->set_rules('location', 'Location', 'required');
			$this->form_validation->set_rules('city', 'city', 'required');
			$this->form_validation->set_rules('state', 'State', 'required');
			$this->form_validation->set_rules('friends', 'Friends', 'required');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">All fields are required!! Please try again.</div>');
				redirect(base_url() . 'home/fb_account_management', 'refresh');
			} else {
				$data['name'] = $this->input->post('name');
				$data['profile_link'] = $this->input->post('profile_link');
				$data['account_id'] = $this->input->post('account_id');
				$data['password'] = $this->input->post('password');
				$data['mobile'] = $this->input->post('mobile');
				$data['email'] = $this->input->post('email');
				$data['gender'] = $this->input->post('gender');
				$data['religion'] = $this->input->post('religion');
				$data['cast'] = $this->input->post('cast');
				$data['dob'] = $this->input->post('dob');
				$data['age'] = $this->input->post('age');
				$data['location'] = $this->input->post('location');
				$data['city'] = $this->input->post('city');
				$data['state'] = $this->input->post('state');
				$data['friends'] = $this->input->post('friends');
				if($this->input->post('status') === '1' || $this->input->post('status') === '0') {
					$data['status'] = $this->input->post('status');
				}
				
				if ($this->input->post('sav-typ') == 'edit') {
					$data['id'] = $this->input->post('id');
					$result = $this->Crud->edit_fb_account($data);
					if($result) {
						$this->session->set_flashdata('msg', '<div class="alert alert-success
						text-center">Facebook Account Updated Successfully.</div>');
						redirect(base_url() . 'home/fb_account_management', 'refresh');
					} else {
						$this->session->set_flashdata('msg', '<div class="alert alert-danger
						text-center">Facebook Account updation failed. Please try again.</div>');
						redirect(base_url() . 'home/fb_account_management', 'refresh');
					}
				} else {
					$result = $this->Crud->insert_fb_account($data);
					if($result) {
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Facebook Account Added Successfully.</div>');
						redirect(base_url() . 'home/fb_account_management', 'refresh');
						
					} else {
						$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Facebook Account Can\'t Add.</div>');
						redirect(base_url() . 'home/fb_account_management', 'refresh');
					}
				}
			}
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

	// Delete the facebook account 
	public function delete_fb_account() {
		if ($this->session->has_userdata('login')) {
			$userId = $this->uri->segment(3);
			$table = 'fb_account_management';
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

	/** ------------------------------Facebook Group Management---------------------------- */
	// Facebook Group Management
	public function fb_group_management() {
		if ($this->session->has_userdata('login')) {
			$page['result'] = $this->Crud->get_facebook_group_data();
			$this->load->view('header');
			$this->load->view('fb_group_management', $page);
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

	// Add or update the facebook group details
	public function add_update_facebook_group() {
		if ($this->session->has_userdata('login')) {
			// Set validation rules
			$this->form_validation->set_rules('profile_id', 'Profile ID', 'required');
			$this->form_validation->set_rules('profile_name', 'Profile Name', 'required');
			$this->form_validation->set_rules('group_name', 'Group Name', 'required');
			$this->form_validation->set_rules('group_link', 'Group Link', 'required');
			$this->form_validation->set_rules('group_category', 'Group Category', 'required');
			$this->form_validation->set_rules('group_location', 'Group Location', 'required');
			$this->form_validation->set_rules('group_members', 'Group Member', 'required');
			$this->form_validation->set_rules('group_permissions', 'Group Permission', 'required');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">All fields are required!! Please try again.</div>');
				redirect(base_url() . 'home/fb_group_management', 'refresh');
			} else {
				$data['profile_id'] = $this->input->post('profile_id');
				$data['profile_name'] = $this->input->post('profile_name');
				$data['group_name'] = $this->input->post('group_name');
				$data['group_link'] = $this->input->post('group_link');
				$data['group_category'] = $this->input->post('group_category');
				$data['group_location'] = $this->input->post('group_location');
				$data['group_members'] = $this->input->post('group_members');
				$data['group_permissions'] = $this->input->post('group_permissions');
				if($this->input->post('status') === '1' || $this->input->post('status') === '0') {
					$data['status'] = $this->input->post('status');
				}
				
				if ($this->input->post('sav-typ') == 'edit') {
					$data['id'] = $this->input->post('id');
					$result = $this->Crud->edit_facebook_group($data);
					if($result) {
						$this->session->set_flashdata('msg', '<div class="alert alert-success
						text-center">Facebook Group Updated Successfully.</div>');
						redirect(base_url() . 'home/fb_group_management', 'refresh');
					} else {
						$this->session->set_flashdata('msg', '<div class="alert alert-danger
						text-center">Facebook Group updation failed. Please try again.</div>');
						redirect(base_url() . 'home/fb_group_management', 'refresh');
					}
				} else {
					$result = $this->Crud->insert_facebook_group($data);
					if($result) {
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Facebook Group Added Successfully.</div>');
						redirect(base_url() . 'home/fb_group_management', 'refresh');
						
					} else {
						$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Facebook Group Can\'t Add.</div>');
						redirect(base_url() . 'home/fb_group_management', 'refresh');
					}
				}
			}
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

	// Delete facebook group 
	public function delete_facebook_group() {
		if ($this->session->has_userdata('login')) {
			$userId = $this->uri->segment(3);
			$table = 'fb_group_management';
			$result = $this->Crud->deleteCommonFunction($userId, $table);
			if($result) {
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Facebook Group Deleted Successfully.</div>');
				echo 1;
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Facebook Group Can\'t Delete.</div>');
				echo 0;
			}
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}
	
	// Fetch all social media accounts
	public function fetch_all_facebook_account_details() {
		$search = $this->input->get('search');
        $allAccounts = $this->Crud->fetch_all_facebook_account_details($search);
        $response = array();
        foreach ($allAccounts as $account) {
            $response[] = array(
                'account_id' => $account->account_id,
                'name' => $account->name,
            );
        }

        echo json_encode($response);
    }
	
	// Facebook Page Management
	public function fb_page_management()
	{
		if ($this->session->has_userdata('login')) {
			$page['result'] = $this->Crud->get_facebook_page_data();
			$this->load->view('header');
			$this->load->view('fb_page_management', $page);
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

	// Add or update the facebook page details
	public function add_update_facebook_page() {
		if ($this->session->has_userdata('login')) {
			// Set validation rules
			$this->form_validation->set_rules('profile_id', 'Profile ID', 'required');
			$this->form_validation->set_rules('profile_name', 'Profile Name', 'required');
			$this->form_validation->set_rules('page_name', 'Page Name', 'required');
			$this->form_validation->set_rules('page_link', 'Page Link', 'required');
			$this->form_validation->set_rules('page_category', 'Page Category', 'required');
			$this->form_validation->set_rules('page_location', 'Page Location', 'required');
			$this->form_validation->set_rules('page_followers', 'Page Member', 'required');
			$this->form_validation->set_rules('page_permissions', 'Page Permission', 'required');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">All fields are required!! Please try again.</div>');
				redirect(base_url() . 'home/fb_page_management', 'refresh');
			} else {
				$data['profile_id'] = $this->input->post('profile_id');
				$data['profile_name'] = $this->input->post('profile_name');
				$data['page_name'] = $this->input->post('page_name');
				$data['page_link'] = $this->input->post('page_link');
				$data['page_category'] = $this->input->post('page_category');
				$data['page_location'] = $this->input->post('page_location');
				$data['page_followers'] = $this->input->post('page_followers');
				$data['page_permissions'] = $this->input->post('page_permissions');
				if($this->input->post('status') === '1' || $this->input->post('status') === '0') {
					$data['status'] = $this->input->post('status');
				}

				if ($this->input->post('sav-typ') == 'edit') {
					$data['id'] = $this->input->post('id');
					$result = $this->Crud->edit_facebook_group($data);
					if($result) {
						$this->session->set_flashdata('msg', '<div class="alert alert-success
						text-center">Facebook Page Updated Successfully.</div>');
						redirect(base_url() . 'home/fb_page_management', 'refresh');
					} else {
						$this->session->set_flashdata('msg', '<div class="alert alert-danger
						text-center">Facebook Page updation failed. Please try again.</div>');
						redirect(base_url() . 'home/fb_page_management', 'refresh');
					}
				} else {
					$result = $this->Crud->insert_facebook_page($data);
					if($result) {
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Facebook Page Added Successfully.</div>');
						redirect(base_url() . 'home/fb_page_management', 'refresh');
						
					} else {
						$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Facebook Page Can\'t Add.</div>');
						redirect(base_url() . 'home/fb_page_management', 'refresh');
					}
				}
			}
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

	// Delete facebook page 
	public function delete_facebook_page() {
		if ($this->session->has_userdata('login')) {
			$userId = $this->uri->segment(3);
			$table = 'fb_page_management';
			$result = $this->Crud->deleteCommonFunction($userId, $table);
			if($result) {
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Facebook Page Deleted Successfully.</div>');
				echo 1;
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Facebook Page Can\'t Delete.</div>');
				echo 0;
			}
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

	
	// Facebook Profile Management
	public function fb_profile_management()
	{
		if ($this->session->has_userdata('login')) {
			$page['result'] = $this->Crud->get_facebook_page_data();
			$this->load->view('header');
			$this->load->view('fb_profile_management', $page);
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

	// Add or update the facebook page details
	public function add_update_facebook_profile() {
		if ($this->session->has_userdata('login')) {
			// Set validation rules
			$this->form_validation->set_rules('profile_id', 'Profile ID', 'required');
			$this->form_validation->set_rules('profile_name', 'Profile Name', 'required');
			$this->form_validation->set_rules('page_name', 'Page Name', 'required');
			$this->form_validation->set_rules('page_link', 'Page Link', 'required');
			$this->form_validation->set_rules('page_category', 'Page Category', 'required');
			$this->form_validation->set_rules('page_location', 'Page Location', 'required');
			$this->form_validation->set_rules('page_followers', 'Page Member', 'required');
			$this->form_validation->set_rules('page_permissions', 'Page Permission', 'required');
			if ($this->form_validation->run() == FALSE) {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">All fields are required!! Please try again.</div>');
				redirect(base_url() . 'home/fb_page_management', 'refresh');
			} else {
				$data['profile_id'] = $this->input->post('profile_id');
				$data['profile_name'] = $this->input->post('profile_name');
				$data['page_name'] = $this->input->post('page_name');
				$data['page_link'] = $this->input->post('page_link');
				$data['page_category'] = $this->input->post('page_category');
				$data['page_location'] = $this->input->post('page_location');
				$data['page_followers'] = $this->input->post('page_followers');
				$data['page_permissions'] = $this->input->post('page_permissions');
				if($this->input->post('status') === '1' || $this->input->post('status') === '0') {
					$data['status'] = $this->input->post('status');
				}

				if ($this->input->post('sav-typ') == 'edit') {
					$data['id'] = $this->input->post('id');
					$result = $this->Crud->edit_facebook_group($data);
					if($result) {
						$this->session->set_flashdata('msg', '<div class="alert alert-success
						text-center">Facebook Page Updated Successfully.</div>');
						redirect(base_url() . 'home/fb_page_management', 'refresh');
					} else {
						$this->session->set_flashdata('msg', '<div class="alert alert-danger
						text-center">Facebook Page updation failed. Please try again.</div>');
						redirect(base_url() . 'home/fb_page_management', 'refresh');
					}
				} else {
					$result = $this->Crud->insert_facebook_page($data);
					if($result) {
						$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Facebook Page Added Successfully.</div>');
						redirect(base_url() . 'home/fb_page_management', 'refresh');
						
					} else {
						$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Facebook Page Can\'t Add.</div>');
						redirect(base_url() . 'home/fb_page_management', 'refresh');
					}
				}
			}
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

	// Delete facebook page 
	public function delete_facebook_profile() {
		if ($this->session->has_userdata('login')) {
			$userId = $this->uri->segment(3);
			$table = 'fb_page_management';
			$result = $this->Crud->deleteCommonFunction($userId, $table);
			if($result) {
				$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Facebook Page Deleted Successfully.</div>');
				echo 1;
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Facebook Page Can\'t Delete.</div>');
				echo 0;
			}
		} else {
			redirect(base_url() . 'home/login', 'refresh');
		}
	}

}