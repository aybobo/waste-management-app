<?php

class Reports_model extends CI_Model {

	public function getSectors()
	{
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('sector');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//-----------------------------------

	public function fetchstreet($sectorid)
	{
		$this->db->where('sectorid =', $sectorid);
		//$this->db->where('status =', 'Active');
		$this->db->order_by('streetname', 'ASC');
		$query = $this->db->get('street');
		$output = '<option value="">Select Street</option>';
		foreach ($query->result() as $row) {
			$output .= '<option value="'.$row->streetid.'">'.$row->streetname.'</option>';
		}
		return $output;
	}

	//--------------------------------------

	public function getallhouses($streetid)
	{
		$this->db->where('streetid =', $streetid);
		//$this->db->where('status =', 'Active');
		$query = $this->db->get('house');
		$output = '<option value="">Select House Number</option>';
		foreach ($query->result() as $row) {
			$output .= '<option value="'.$row->houseid.'">'.$row->houseno.'</option>';
		}
		return $output;
	}
	
	//--------------------------------------

	public function allpayments($data)
	{
		$this->db->where('year =', $data['year']);
		$this->db->order_by('customerid', 'ASC');
		$query = $this->db->get('paymentsbymonth');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//---------------------------------------

	public function allcustomers()
	{
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//-----------------------------------------

	public function customersbysector($data)
	{
		$this->db->where('sectorid =', $data['sector']);
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//-----------------------------------------------

	public function customersbystreet($data)
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

	//-----------------------------------------------

	public function customersbyhouse($data)
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

	//----------------------------------------------

	public function paymentsbydate($data)
	{
		$this->db->where('paymentdate >=', $data['startdate']);
		$this->db->where('paymentdate <=', $data['enddate']);
		$this->db->order_by('paymentdate', 'DESC');
		$query = $this->db->get('payments');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//-----------------------------------------------

	public function alldebtors()
	{
		$this->db->where('debt >', 0);
		$this->db->where('status =', 'Active');
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//--------------------------------------

	public function debtorsinsector($data)
	{
		$this->db->where('sectorid =', $data['sector']);
		$this->db->where('status =', 'Active');
		$this->db->where('debt >', 0);
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//--------------------------------------------

	public function debtorsinstreet($data)
	{
		$this->db->where('status =', 'Active');
		$this->db->where('sectorid =', $data['sector']);
		$this->db->where('streetid =', $data['street']);
		$this->db->where('debt >', 0);
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//---------------------------------------

	public function debtorsinhouse($data)
	{
		$this->db->where('status =', 'Active');
		$this->db->where('sectorid =', $data['sector']);
		$this->db->where('streetid =', $data['street']);
		$this->db->where('houseid =', $data['houseno']);
		$this->db->where('debt >', 0);
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//-----------------------------------------

	public function getpayments()
	{
		$this->db->order_by('paymentid', 'DESC');
		$query = $this->db->get('payments');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//----------------------------------------

	public function allcommissions($data)
	{
		$this->db->where('year =', $data['year']);
		$this->db->order_by('agentid', 'ASC');
		$query = $this->db->get('agentscommissionbymonth');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//---------------------------------------

	public function allagents()
	{
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('agent');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//------------------------------------------------

	public function agentsbyid($data)
	{
		$this->db->where('agentid =', $data['agent']);
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('agent');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//---------------------------------------

	public function commissionsbydate($data)
	{
		$this->db->where('entrancedate >=', $data['startdate']);
		$this->db->where('entrancedate <=', $data['enddate']);
		$this->db->order_by('entrancedate', 'DESC');
		$query = $this->db->get('commission');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//------------------------------------------

	public function getagents()
	{
		$this->db->where('fname !=', 'Open');
		//$this->db->where('fname !=', 'Lagos');
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('agent');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//---------------------------------------

	public function getagentcustomers($data)
	{
		$this->db->where('agentid =', $data['agent']);
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//-------------------------------------

	public function creditReport($data)
	{
		$this->db->where('date >=', $data['startdate']);
		$this->db->where('date <=', $data['enddate']);
		//$this->db->where('transactionType', 'CR');
		$this->db->order_by('date', 'DESC');
		$query = $this->db->get('cashbook');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//------------------------------------------

	public function debitReport($data)
	{
		$this->db->where('date >=', $data['startdate']);
		$this->db->where('date <=', $data['enddate']);
		$this->db->where('transactionType', 'DR');
		$this->db->order_by('date', 'DESC');
		$query = $this->db->get('cashbook');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//---------------------------------------------

	public function getCommercialDebtors()
	{
		$this->db->where('customertype =', 'Commercial');
		$this->db->where('debt >', 0);
		$this->db->where('status =', 'Active');
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//--------------------------------------

	public function getCommercialDebtorsInSector($sector)
	{
		$this->db->where('sectorname =', $sector);
		$this->db->where('customertype =', 'Commercial');
		$this->db->where('debt >', 0);
		$this->db->where('status =', 'Active');
		$this->db->order_by('sectorid', 'ASC');
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//---------------------------------------

	public function getResidentialDebtorsInSector($sector)
	{
		$this->db->where('sectorname =', $sector);
		$this->db->where('customertype =', 'Residential');
		$this->db->where('debt >', 0);
		$this->db->where('status =', 'Active');
		$this->db->order_by('sectorid', 'ASC');
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//-------------------------------------

	public function getStreetsInSector($sector)
	{
		$this->db->where('sectorname =', $sector);
		$query = $this->db->get('street');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//---------------------------------------

	public function getCommercialDebtorsInStreet($sector, $street)
	{
		$this->db->where('sectorname =', $sector);
		$this->db->where('streetname =', $street);
		$this->db->where('customertype =', 'Commercial');
		$this->db->where('debt >', 0);
		$this->db->where('status =', 'Active');
		$query = $this->db->get('customer');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//----------------------------------------

	public function getResidentialDebtorsInStreet($sector, $street)
	{
		$this->db->where('sectorname =', $sector);
		$this->db->where('streetname =', $street);
		$this->db->where('customertype =', 'Residential');
		$this->db->where('debt >', 0);
		$this->db->where('status =', 'Active');
		$query = $this->db->get('customer');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//-------------------------------------------

	public function getHousesInStreet($sector, $street)
	{
		$this->db->where('sectorname =', $sector);
		$this->db->where('streetname =', $street);
		$this->db->where('status =', 'Active');
		$query = $this->db->get('house');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//---------------------------------------

	public function getCommercialDebtorsInHouse($house, $street, $sector)
	{
		$this->db->where('customertype =', 'Commercial');
		$this->db->where('sectorname =', $sector);
		$this->db->where('streetname =', $street);
		$this->db->where('houseno =', $house);
		$this->db->where('debt >', 0);
		$this->db->where('status =', 'Active');
		$query = $this->db->get('customer');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//--------------------------------------

	public function getResidentialDebtorsInHouse($house, $street, $sector)
	{
		$this->db->where('customertype =', 'Residential');
		$this->db->where('sectorname =', $sector);
		$this->db->where('streetname =', $street);
		$this->db->where('houseno =', $house);
		$this->db->where('debt >', 0);
		$this->db->where('status =', 'Active');
		$query = $this->db->get('customer');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//======================================

	public function getResidentialDebtors()
	{
		$this->db->where('customertype =', 'Residential');
		$this->db->where('debt >', 0);
		$this->db->where('status =', 'Active');
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//-------------------------------------

	public function getcommercialcustomers()
	{
		$this->db->where('customertype =', 'Commercial');
		$this->db->where('status =', 'Active');
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//-------------------------------------

	public function getcommercialtypes()
	{
		$this->db->where('status =', 'Active');
		$this->db->order_by('typeId', 'ASC');
		$query = $this->db->get('commercialtype');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//----------------------------------

}