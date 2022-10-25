<?php

class Users_model extends CI_Model {

	/*---check if user exists-----*/

	public function checkuser($data)
	{
		$this->db->where('email =', $data['email']);
		$query = $this->db->get('users');
		return $query->row();
	}

	/*--------add new user---------*/

	public function addUser($data)
	{
		$this->db->insert('users', ['fname' => $data['fname'],
									'oname' => $data['oname'],
									'lname' => $data['lname'],
									'email' => $data['email'],
									'signature' => $data['filename'],
									'status' => 'Active',
									'role' => $data['role'],
									'createdby' => $data['createdby'],
									'datecreated' => $data['createdate']]);

		$insert_id = $this->db->insert_id();
   		return  $insert_id;
	}

	/* --------fetch all sectors---------  */

	public function getUsers() {
		$this->db->order_by('lname', 'ASC');
		$query = $this->db->get('users');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	/*-------- get single user ---------*/

	public function getSingleUser($id)
	{
		$this->db->where('userid =', $id);
		$query = $this->db->get('users');
		return $query->row();
	}

	//-------- update user --------

	public function updateuser($data)
	{
		$this->db->where('userid =', $data['id']);
		return $this->db->update('users',
									['fname' => $data['fname'],
									'oname' => $data['oname'],
									'lname' => $data['lname'],
									'signature' => $data['filename'],
									'role' => $data['role'],
									'email' => $data['email'],
									'status' => $data['status'],
									'modifiedby' => $data['modifiedby'],
									'datemodified' => $data['modifydate']]);
	}

	//--------------------------------------

}