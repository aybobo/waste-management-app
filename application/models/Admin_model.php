<?php

class Admin_model extends CI_Model {

	//------- login user

	public function islogin($userEmail, $password)
	{
		$this->db->where('email =', $userEmail);
		$this->db->where('password =', $password);
		$query = $this->db->get('users');
		return $query->row();
	}

	//----------------------------------

	public function getSingleUser($id)
	{
		$this->db->where('userid =', $id);
		$sql = $this->db->get('users');
		return $sql->row();
	}

	//---------------------------------

	public function setpassword($info)
	{
		$this->db->where('userid =', $info['id']);
		return $this->db->update('users', ['password' => $info['pwd'], 'num' => $info['key']]);
	}

	//-------------------------------

	public function checkEmail($email)
	{
		$this->db->where('email =', $email);
		$sql = $this->db->get('users');
		return $sql->row();
	}

	//---------------------------------

	public function updateToken($email, $token, $num)
	{
		$this->db->where('email =', $email);
		return $this->db->update('users', ['token' => $token, 'num' => $num]);
	}

	//-------------------------------

	public function verifyToken($data)
	{
		$this->db->where('token =', $data['token']);
		$sql = $this->db->get('users');
		return $sql->row();
	}

	//------------------------------------

	public function updatePassword($data)
	{
		$this->db->where('token =', $data['token']);
		return $this->db->update('users', ['password' => $data['pwd'],
										'token' => $data['token'],
										'num' => $data['num']]);
	}

	//-------------------------------------
}