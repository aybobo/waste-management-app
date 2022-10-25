<?php

class Config_model extends CI_Model {

	//------- update user password

	public function getSectors()
	{
		$this->db->where('status =', 'Active');
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('sector');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//----------------------------------

	public function getallstreet()
	{
		$this->db->where('status =', 'Active');
		$this->db->order_by('streetname', 'ASC');
		$query = $this->db->get('street');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//---------------------------------

	public function getallhouses()
	{
		$this->db->where('status =', 'Active');
		$this->db->order_by('status', 'ASC');
		$query = $this->db->get('house');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//---------------------------------

	public function getcustomers() {
		$this->db->where('status =', 'Active');
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//-------------------------------------

	public function getcommercialcustomers()
	{
		$this->db->where('status =', 'Active');
		$this->db->where('customertype =', 'Commercial');
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//----------------------------------

	public function getmonthpayment($month, $year)
	{
		$this->db->where('month =', $month);
		$this->db->where('year =', $year);
		$query = $this->db->get('commission');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//----------------------------------
}