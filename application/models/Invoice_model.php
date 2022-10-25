<?php

class Invoice_model extends CI_Model {

	public function getSectors()
	{
		$this->db->order_by('status', 'ASC');
		$query = $this->db->get('sector');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//------------------------------------

	public function getagents()
	{
		$this->db->order_by('status', 'ASC');
		$query = $this->db->get('agent');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//------------------------------------

	public function fetchactivestreet($sectorid)
	{
		$this->db->where('sectorid =', $sectorid);
		$this->db->where('status =', 'Active');
		$this->db->order_by('streetname', 'ASC');
		$query = $this->db->get('street');
		$output = '<option value="">Select Street</option>';
		foreach ($query->result() as $row) {
			$output .= '<option value="'.$row->streetid.'">'.$row->streetname.'</option>';
		}
		return $output;
	}

	//--------------------------------------------

	public function getallactivehouses($streetid)
	{
		$this->db->where('streetid =', $streetid);
		$this->db->where('status =', 'Active');
		$query = $this->db->get('house');
		$output = '<option value="">Select House Number</option>';
		foreach ($query->result() as $row) {
			$output .= '<option value="'.$row->houseid.'">'.$row->houseno.'</option>';
		}
		return $output;
	}

	//----------------------------------------------

	public function customerbysector($data)
	{
		$this->db->where('sectorid =', $data['sector']);
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('customer');
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//-----------------------------------------

	public function customerbysectornstreet($data)
	{
		$this->db->where('sectorid =', $data['sector']);
		$this->db->where('streetid =', $data['street']);
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('customer');
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//--------------------------------------------

	public function customerbysectorstreetnhouse($data)
	{
		$this->db->where('sectorid =', $data['sector']);
		$this->db->where('streetid =', $data['street']);
		$this->db->where('houseid =', $data['houseno']);
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('customer');
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//--------------------------------------------

	public function customerbyagent($data)
	{
		$this->db->where('agentid =', $data['agent']);
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('customer');
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}
}