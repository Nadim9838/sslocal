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
	public function get_facebook_management_data()
	{
		$query = $this->db->select('*')->from('facebook_management')->get();
		return $query->result_array();
	}

    // Add new facebook
	public function insert_facebook($data)
	{
		$this->db->insert('facebook_management', $data);
		return $this->db->affected_rows();
	}

    // Update facebook
	public function edit_facebook($data)
	{
		$this->db->where('id', $data["id"]);
		$this->db->update('facebook_management', $data);
		return $this->db->affected_rows();
	}

	// Get total acounts added
	public function getTotalAccounts($tableName) {
		$total = $this->db->count_all($tableName);
		return $total;
	}

	// Fetch social media accounts
	public function fetch_social_accounts($table) {
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

	// Update the availability flag 0
	public function update_facebook_availability($account, $table) {
		$this->db->where('account_id', $account);
		$this->db->update($table, ['availability' => 0]);
	
		return true;
	}
}