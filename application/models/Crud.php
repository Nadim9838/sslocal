<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Crud extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

    // Check if the user exists in the database
    public function userLoginAuth($email, $password) {
        $this->db->where('email', $email);
        $query = $this->db->get('login');

        // Check if user exists
        if ($query->num_rows() > 0) {
            $user = $query->row_array();
            // If user exists and password matches (using password_verify)
            if ($user && password_verify($password, $user['password'])) {
                return $user;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Get user management data
	public function get_user_management_data()
	{
		$query = $this->db->select('*')->from('login')->get();
		return $query->result_array();
	}

    // Add new user
	public function insert_user($data)
	{
		$this->db->insert('login', $data);
		return $this->db->affected_rows();
	}

    // Update user
	public function edit_user($data)
	{
		$this->db->where('id', $data["id"]);
		$this->db->update('login', $data);
		return $this->db->affected_rows();
	}

    // Delete user
	public function delete_user($userId)
	{
		$this->db->where('id', $userId);
		$this->db->delete('login');

		$this->db->where('user_id', $userId);
    	$query = $this->db->get('user_permissions');

		// If userId exists, delete the user from user_permissions table
		if ($query->num_rows() > 0) {
			$this->db->where('user_id', $userId);
			$this->db->delete('user_permissions');
		}

        return true;
	}
    
	// Get user permissions 
	public function get_user_permissions($userId) {
        $this->db->where('user_id', $userId);
        return $this->db->get('user_permissions')->result();
    }

	// Get user permissions of a particular user id
	public function get_user_login_permissions($userId) {
		$this->db->where('user_id', $userId);
		return $this->db->get('user_permissions')->result_array();
	}

	// Update user permissions of a particular user
    public function update_user_permissions($userId, $permissions) {
        // Remove old permissions
        $this->db->where('user_id', $userId);
   		$this->db->delete('user_permissions');

        // Insert new permissions
        foreach ($permissions as $menu => $perm) {
			$data = array(
				'user_id' => $userId,
				'permission' => $menu,
				'add' => isset($perm['add']) ? 1 : 0,
				'view' => isset($perm['view']) ? 1 : 0,
				'edit' => isset($perm['edit']) ? 1 : 0,
				'delete' => isset($perm['delete']) ? 1 : 0
			);
			$this->db->insert('user_permissions', $data);
		}

        return true;
    }

	// Get mobile management data
	public function get_mobile_management_data()
	{
		$query = $this->db->select('*')->from('mobile_management')->get();
		return $query->result_array();
	}

    // Add new mobile
	public function insert_mobile($data)
	{
		$this->db->insert('mobile_management', $data);
		return $this->db->affected_rows();
	}

    // Update mobile
	public function edit_mobile($data)
	{
		$this->db->where('id', $data["id"]);
		$this->db->update('mobile_management', $data);
		return $this->db->affected_rows();
	}

    // Delete data common function
	public function deleteCommonFunction($userId, $tableName)
	{
		$this->db->where('id', $userId);
		$this->db->delete($tableName);
        return true;
	}

	// Get facebook management data
	public function get_fb_account_management_data()
	{
		$query = $this->db->select('*')->from('fb_account_management')->get();
		return $query->result_array();
	}

    // Add new facebook
	public function insert_fb_account($data)
	{
		$this->db->insert('fb_account_management', $data);
		return $this->db->affected_rows();
	}

    // Update facebook
	public function edit_fb_account($data)
	{
		$this->db->where('id', $data["id"]);
		$this->db->update('fb_account_management', $data);
		return $this->db->affected_rows();
	}

	// Get total acounts added
	public function getTotalAccounts($tableName) {
		$total = $this->db->count_all($tableName);
		return $total;
	}

	// Fetch social media accounts
	public function fetch_social_media_accounts($table) {
		$this->db->where('availability', 1);
		$query = $this->db->get($table);
		$output = '<option value="">Select Account</option>';
		foreach ($query->result() as $row) {
			$output .= '<option value="' . $row->account_id . '">' . $row->account_id . '</option>';
		}
		return $output;
	}
	
	// Save social media social accounts 
	public function save_mobile_accounts($mobileId, $data) {

		$this->db->where('mobile_id', $mobileId);
		$this->db->delete('social_media_accounts');
		$this->db->insert_batch('social_media_accounts', $data);
		return true;
	}

	// Get all saved social media accounts
	public function get_saved_social_media_accounts($mobileId) {
		if (!empty($mobileId)) {
            $this->db->select('platform, app_series, account');
            $this->db->from('social_media_accounts');
            $this->db->where('mobile_id', $mobileId);
            $query = $this->db->get();

            // If records are found, return them
            if ($query->num_rows() > 0) {
                return $query->result_array();
            } else {
                return [];
            }
        } else {
            return [];
        }
	}

	public function delete_social_media_account($accountId, $platform) {
		$this->db->where('account', $accountId);
		$this->db->where('platform', $platform);
		$this->db->delete('social_media_accounts');

		if($platform == 'facebook') {
			$this->db->where('account_id', $accountId);
			$this->db->update('fb_account_management', ['availability' => 1]);
		}

        return true;
	}
	// Update the availability flag 0
	public function update_facebook_availability($account, $table) {
		$this->db->where('account_id', $account);
		$this->db->update($table, ['availability' => 0]);
	
		return true;
	}
	
	// Get facebook group data
	public function get_facebook_group_data()
	{
		$query = $this->db->select('*')->from('fb_group_management')->get();
		return $query->result_array();
	}

    // Add new facebook
	public function insert_facebook_group($data)
	{
		$this->db->insert('fb_group_management', $data);
		return $this->db->affected_rows();
	}

    // Update facebook
	public function edit_facebook_group($data)
	{
		$this->db->where('id', $data["id"]);
		$this->db->update('fb_group_management', $data);
		return $this->db->affected_rows();
	}

	// Fetch all social media accounts
	public function fetch_all_facebook_account_details($search) {
		$query = $this->db->select('name, account_id')
                          ->from('fb_account_management');

		if (!empty($search)) {
            $this->db->like('account_id', $search);
            $this->db->or_like('name', $search);
        }

        $query = $this->db->get();
        return $query->result();
	}

	// Get facebook page data
	public function get_facebook_page_data()
	{
		$query = $this->db->select('*')->from('fb_page_management')->get();
		return $query->result_array();
	}

    // Add new facebook page
	public function insert_facebook_page($data)
	{
		$this->db->insert('fb_page_management', $data);
		return $this->db->affected_rows();
	}

    // Update facebook page
	public function edit_facebook_page($data)
	{
		$this->db->where('id', $data["id"]);
		$this->db->update('fb_page_management', $data);
		return $this->db->affected_rows();
	}


	// Get facebook profile data
	public function get_facebook_profile_data()
	{
		$query = $this->db->select('*')->from('fb_page_management')->get();
		return $query->result_array();
	}

	// Add new facebook page
	public function insert_facebook_profile($data)
	{
		$this->db->insert('fb_page_management', $data);
		return $this->db->affected_rows();
	}

	// Update facebook page
	public function edit_facebook_profile($data)
	{
		$this->db->where('id', $data["id"]);
		$this->db->update('fb_page_management', $data);
		return $this->db->affected_rows();
	}

}