<?php

class Customersetup_model extends CI_Model {

	/*------ fetch all sectors */

	public function getSectors()
	{
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('sector');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//-------check if sector exists-------------

	public function checksector($data)
	{
		$this->db->where('sectorname =', $data['sector']);
		$query = $this->db->get('sector');
		return $query->row();
	}

	//----------add sector-------------

	public function addsector($data)
	{
		return $this->db->insert('sector', ['sectorname' => $data['sector'],
								'status' => 'Active',
								//'agentid' => $data['agent'],
								'areaid' => $data['area'],
								'areaname' => $data['areaname'],
								//'agentname' => $data['agentname'],
								'createdby' => $data['createdby'],
								'datecreated' => $data['createdate']]);
	}

	//----------fetch single sector----------------

	public function getsinglesector($sectorid)
	{
		$this->db->where('sectorid =', $sectorid);
		$query = $this->db->get('sector');
		return $query->row();
	}

	//------------update sector --------------------

	public function updatesector($data)
	{
		$this->db->where('sectorid =', $data['id']);
		$this->db->update('sector',
									['sectorname' => $data['sector'],
									//'agentid' => $data['agent'],
									//'agentname' => $data['agentname'],
									'areaid' => $data['area'],
									'areaname' => $data['areaname'],
									'status' => $data['status'],
									'modifiedby' => $data['modifiedby'],
									'datemodified' => $data['modifydate']]);

		//update street table
		$this->db->where('sectorid =', $data['id']);
		$this->db->update('street', ['status' => $data['status'],
									'sectorname' => $data['sector']]);

		//update house table
		$this->db->where('sectorid =', $data['id']);
		$this->db->update('house', ['status' => $data['status'],
									'sectorname' => $data['sector']]);

		//update agent table
		/*$this->db->where('agentid =', $data['agent']);
		$this->db->update('agent', ['sectorname' => $data['sector'],
									'sectorid' => $data['id']]);*/

		//update customer table
		$this->db->where('sectorid =', $data['id']);
		return $this->db->update('customer', ['status' => $data['status'],
											//'agentid' => $data['agent'],
											'areaname' => $data['areaname'],
											'areaid' => $data['area'],
											'sectorname' => $data['sector']]);
	}

	//---------get active sectors ------------------

	public function getactivecommercialtypes()
	{
		$this->db->where('status =', 'Active');
		$this->db->order_by('typeName', 'ASC');
		$query = $this->db->get('commercialtype');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//---------------------------------------

	public function getactiveareas()
	{
		$this->db->where('status =', 'Active');
		$this->db->order_by('areaname', 'ASC');
		$query = $this->db->get('area');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//-------------------------------------------

	public function getotheractivesectors($sectorid)
	{
		$this->db->where('sectorid !=', $sectorid);
		$this->db->where('status =', 'Active');
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('sector');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//----------------------------------------------

	public function getotheractivestreets($streetid)
	{
		$this->db->where('streetid !=', $streetid);
		$this->db->where('status =', 'Active');
		$this->db->order_by('streetname', 'ASC');
		$query = $this->db->get('street');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//--------- get all street ---------------

	public function getallstreet()
	{
		$this->db->order_by('streetname', 'ASC');
		$query = $this->db->get('street');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//---------- get single street -------------

	public function getsinglestreet($streetid)
	{
		$this->db->where('streetid =', $streetid);
		$query = $this->db->get('street');
		return $query->row();
	}

	//-------- check if matching street name is in sector ----------------

	public function checkstreet($data)
	{
		$this->db->where('sectorid =', $data['sector']);
		$this->db->where('streetname =', $data['street']);
		$query = $this->db->get('street');
		return $query->row();
	}

	//---------------------------------------

	public function checkstreetcode($temp)
	{
		$this->db->where('streetcode =', $temp);
		$query = $this->db->get('street');
		return $query->row();
	}

	//-------- add new street -------------

	public function addstreet($data)
	{
		return $this->db->insert('street', ['sectorid' => $data['sector'],
											'sectorname' => $data['sectorname'],
											'streetname' => $data['street'],
											'streetcode' => $data['streetcode'],
											'status' => 'Active',
											'createdby' => $data['createdby'],
											'datecreated' => $data['createdate']]);
	}

	//---------- update street ---------------

	public function updatestreet($data)
	{
		$this->db->where('streetid =', $data['id']);
		$this->db->update('street',
									['sectorid' => $data['sector'],
									'streetname' => $data['street'],
									'sectorname' => $data['sectorname'],
									'streetcode' => $data['streetcode'],
									'status' => $data['status'],
									'modifiedby' => $data['modifiedby'],
									'datemodified' => $data['modifydate']]);

		//update house table
		$this->db->where('streetid =', $data['id']);
		$this->db->update('house', ['status' => $data['status'],
									'streetname' => $data['street']]);

		//update customer table
		$this->db->where('streetid =', $data['id']);
		return $this->db->update('customer', ['status' => $data['status'],
											'streetname' => $data['street']]);

	}

	//--------------------------------------

	public function getactivestreets()
	{
		$this->db->where('status =', 'Active');
		$this->db->order_by('streetname', 'ASC');
		$query = $this->db->get('street');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//-------------------------------------

	public function getactivesectors()
	{
		$this->db->where('status =', 'Active');
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('sector');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//-------------------------------------

	public function getallhouses()
	{
		$this->db->order_by('status', 'ASC');
		$query = $this->db->get('house');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//---------active streets for js-------------

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

	//-------------------------------------

	public function fetchactivesector($areaid)
	{
		$this->db->where('areaid =', $areaid);
		$this->db->where('status =', 'Active');
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('sector');
		$output = '<option value="">Select Sector</option>';
		foreach ($query->result() as $row) {
			$output .= '<option value="'.$row->sectorid.'">'.$row->sectorname.'</option>';
		}
		return $output;
	}

	//-----------------------------------------

	public function checkhouse($data)
	{
		$this->db->where('sectorid =', $data['sector']);
		$this->db->where('streetid =', $data['street']);
		$this->db->where('houseno =', $data['houseno']);
		$query = $this->db->get('house');
		return $query->row();
	}

	//-------------------------------------------

	public function addhouse($data)
	{
		return $this->db->insert('house', ['sectorid' => $data['sector'],
											'sectorname' => $data['sectorname'],
											'streetid' => $data['street'],
											'streetname' => $data['streetname'],
											'status' => 'Active',
											'houseno' => $data['houseno'],
											'createdby' => $data['createdby'],
											'datecreated' => $data['createdate']]);
	}

	//----------------------------------------

	public function getsinglehouse($houseid)
	{
		$this->db->where('houseid =', $houseid);
		$query = $this->db->get('house');
		return $query->row();
	}

	//---------------------------------------

	public function updatehouse($data)
	{
		$this->db->where('houseid =', $data['id']);
		$this->db->update('house',
									['sectorid' => $data['sector'],
									'streetid' => $data['street'],
									'streetname' => $data['streetname'],
									'sectorname' => $data['sectorname'],
									'houseno' => $data['houseno'],
									'status' => $data['status'],
									'modifiedby' => $data['modifiedby'],
									'datemodified' => $data['modifydate']]);

		$this->db->where('houseid =', $data['id']);
		return $this->db->update('customer', ['status' => $data['status'],
											'houseno' => $data['houseno']]);

	}

	//--------------------------------

	public function gethousecategories() {
		$this->db->order_by('housetype', 'ASC');
		$query = $this->db->get('housecategory');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//-----------------------------------

	public function getotherhousecategories($housecatid) {
		$this->db->where('catid !=', $housecatid);
		$this->db->order_by('housetype', 'ASC');
		$query = $this->db->get('housecategory');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//-----------------------------------

	public function getothercomercialtype($typeId) {
		$this->db->where('typeId !=', $typeId);
		//$this->db->where('typeId !=', 1);
		$this->db->where('status =', 'Active');
		$this->db->order_by('typeName', 'ASC');
		$query = $this->db->get('commercialtype');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//--------------------------------

	public function getotheractiveareas($areaid) {
		$this->db->where('areaid !=', $areaid);
		$this->db->order_by('areaname', 'ASC');
		$query = $this->db->get('area');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//------------------------------------

	public function checkhousetype($data)
	{
		$this->db->where('housetypecode =', $data['code']);
		$query = $this->db->get('housecategory');
		return $query->row();
	}

	//------------------------------------------

	public function addhousetype($data)
	{
		return $this->db->insert('housecategory', ['housetype' => $data['housetype'],
								'monthlycharge' => $data['mntcharge'],
								'housetypecode' => $data['code'],
								'createdby' => $data['createdby'],
								'datecreated' => $data['createdate']]);
	}

	//------------------------------------------

	public function getsinglecategory($catid)
	{
		$this->db->where('catid =', $catid);
		$query = $this->db->get('housecategory');
		return $query->row();
	}

	//---------------------------------------

	public function updatecategory($data)
	{
		$this->db->where('catid =', $data['id']);
		$this->db->update('housecategory',
									['housetype' => $data['housetype'],
									'monthlycharge' => $data['mntcharge'],
									'housetypecode' => $data['code'],
									'modifiedby' => $data['modifiedby'],
									'datemodified' => $data['modifydate']]);

		$this->db->where('housecatid =', $data['id']);
		return $this->update('customer', ['housecat' => $data['housetype']]);
	}

	//---------------------------------------

	public function getcustomers() {
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//---------------------------------

	public function getallactivehouses($streetid) {
		$this->db->where('streetid =', $streetid);
		$this->db->where('status =', 'Active');
		$query = $this->db->get('house');
		$output = '<option value="">Select House Number</option>';
		foreach ($query->result() as $row) {
			$output .= '<option value="'.$row->houseid.'">'.$row->houseno.'</option>';
		}
		return $output;
	}

	//---------------------------------------

	public function getagents()
	{
		$this->db->where('status !=', 'Acti');
		$this->db->order_by('status', 'ASC');
		$query = $this->db->get('agent');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//----------------------------------------

	public function checkagent($data)
	{
		$this->db->where('fname =', $data['fname']);
		$this->db->where('lname =', $data['lname']);
		$this->db->where('telno =', $data['telno']);
		$query = $this->db->get('agent');
		return $query->row();
	}

	//----------------------------------------

	public function addagent($data)
	{
		return $this->db->insert('agent', [//'sectorname' => $data['sectorname'],
											//'sectorid' => $data['sector'],
											'fname' => $data['fname'],
											'oname' => $data['oname'],
											'lname' => $data['lname'],
											'telno' => $data['telno'],
											'status' => 'Active',
											'createdby' => $data['createdby'],
											'datecreated' => $data['createdate']]);
	}

	//-----------------------------------------

	public function getsingleagent($agentid)
	{
		$this->db->where('agentid =', $agentid);
		$query = $this->db->get('agent');
		return $query->row();
	}

	//-----------------------------------------

	public function updateagent($data)
	{
		$this->db->where('agentid =', $data['id']);
		$this->db->update('agent',
									['fname' => $data['fname'],
									'oname' => $data['oname'],
									'lname' => $data['lname'],
									'telno' => $data['telno'],
									/*'sectorid' => $data['sector'],
									'sectorname' => $data['sectorname'],*/
									'status' => $data['status'],
									'modifiedby' => $data['modifiedby'],
									'datemodified' => $data['modifydate']]);

		$this->db->where('agentid =', $data['id']);
		return $this->db->update('sector', ['agentname' => $data['agentname']]);
	}

	//-----------------------------------------------

	public function getactiveagents()
	{
		$this->db->where('status =', 'Active');
		$this->db->order_by('lname', 'ASC');
		$query = $this->db->get('agent');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//-------------------------------------------

	public function getotheractiveagents($agentid)
	{
		$this->db->where('agentid !=', $agentid);
		$this->db->where('status =', 'Active');
		$this->db->order_by('lname', 'ASC');
		$query = $this->db->get('agent');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//-----------------------------------------------

	public function checkcustomer($data)
	{
		$this->db->where('sectorid =', $data['sector']);
		$this->db->where('streetid =', $data['street']);
		$this->db->where('houseno =', $data['house']);
		$this->db->where('name =', $data['lname']);
		$this->db->where('telno =', $data['telno']);
		$query = $this->db->get('customer');
		return $query->row();
	}

	//--------------------------------------------

	public function addcustomer($data)
	{
		$this->db->trans_begin();
		$this->db->insert('customer', ['houseid' => $data['houseno'],
											'houseno' => $data['house'],
											'customercode' => $data['customercode'],
											'streetid' => $data['street'],
											'streetname' => $data['streetname'],
											'sectorid' => $data['sector'],
											'sectorname' => $data['sectorname'],
											'housecatid' => $data['housetype'],
											'housecat' => $data['housecat'],
											'counter' => $data['counter'],
											'status' => 'Active',
											'num' => $data['i'],
											'agentid' => $data['agentid'],
											'agentname' => $data['agentname'],
											'areaname' => $data['areaname'],
											'areaid' => $data['areaid'],
											'monthlycharge' => $data['mntcharge'],
											'commercialtype' => $data['commtype'],
											'commercialTypeName' => $data['commtypename'],
											'name' => $data['lname'],
											'telno' => $data['telno'],
											'debt' => $data['debt'],
											'wallet' => $data['wallet'],
											'customertype' => $data['customertype'],
											'createdby' => $data['createdby'],
											'customerentrydate' => $data['entrydate'],
											'datecreated' => $data['createdate']]);

		$insert_id = $this->db->insert_id();
		/*$this->db->insert('paymentsbymonth', ['customerid' => $insert_id,
													'customername' => $data['customername'],
													'year' => $data['year'],
													'amtcollected' => $data['amtcollect'],
													'amtexpected' => $data['supposedamt'],
													//'arears' => $data['excessamt'],
													'lastenteredby' => $data['createdby'],
													'lastentrydate' => $data['createdate']]);*/

		$this->db->insert('ledger', ['customerid' => $insert_id,
											'customername' => $data['customername'],
											'amtcollected' => $data['amtcollect'],
											'amtexpected' => $data['supposedamt'],
											'debt' => $data['debt'],
											'wallet' => $data['wallet'],
											'monthlycharge' => $data['mntcharge'],
											'year' => $data['year']]);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		}
		else {
			$this->db->trans_commit();
            return  TRUE;
		}
	}

	//-------------------------------------------

	public function getsinglecustomer($customerid)
	{
		$this->db->where('customerid =', $customerid);
		$query = $this->db->get('customer');
		return $query->row();

		/*$this->db->select('*');
		$this->db->from('customer AS A');
		$this->db->join('commercialtype AS B', 'A.commercialtype = B.typeId', 'INNER');
		$this->db->where('customerid =', $customerid);
		$query = $this->db->get();
		return $query->row();*/

		/*$this->db->select('*');
		$this->db->from('customer AS A');
		$this->db->join('area AS B', 'A.areaid = B.areaid', 'INNER');
		$this->db->join('sector AS C', 'C.sectorid = A.sectorid', 'INNER');
		$this->db->join('street AS D', 'A.streetid = D.streetid', 'INNER');
		$this->db->join('house AS E', 'A.houseid = E.houseid', 'INNER');
		$this->db->join('house AS E', 'A.houseid = E.houseid', 'INNER');
		$this->db->where('userId =', $userId);
		$query = $this->db->get();
		return $query->row();*/
	}

	//-----------------------------------

	public function getcommercialtypename($data)
	{
		$this->db->where('typeId =', $data['commtype']);
		$query = $this->db->get('commercialtype');
		return $query->row()->typeName;
	}

	//--------------------------------------

	public function gethousetypeno($data)
	{
		$this->db->where('sectorid =', $data['sector']);
		$this->db->where('streetid =', $data['street']);
		$this->db->where('houseno =', $data['house']);
		$this->db->where('housecat =', $data['housecat']);
		$query = $this->db->get('customer');
		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//--------------------------------------

	public function updatecustomer($data)
	{
		$this->db->trans_begin();
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['houseid' => $data['houseno'],
										'houseno' => $data['house'],
										'streetid' => $data['street'],
										'streetname' => $data['streetname'],
										'customercode' => $data['customercode'],
										'counter' => $data['counter'],
										'sectorid' => $data['sector'],
										'sectorname' => $data['sectorname'],
										'housecatid' => $data['housetype'],
										'housecat' => $data['housecat'],
										'status' => $data['status'],
										'agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'areaname' => $data['areaname'],
										'areaid' => $data['area'],
										'debt' => $data['debt'],
										'wallet' => $data['wallet'],
										'name' => $data['lname'],
										'telno' => $data['telno'],
										'monthlycharge' => $data['mntcharge'],
										'customerentrydate' => $data['entrydate'],
										'customertype' => $data['customertype'],
										'commercialtype' => $data['commtype'],
										'commercialTypeName' => $data['commtypename'],
										'modifiedby' => $data['modfiedby'],
										'datemodified' => $data['modifydate']]);

		$this->db->where('customerid =', $data['id']);
		$this->db->update('ledger', ['monthlycharge' => $data['mntcharge']]);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		}
		else {
			$this->db->trans_commit();
            return  TRUE;
		}
	}

	//----------------------------------------

	public function getcustomercode($houseid)
	{
		$this->db->where('houseid', $houseid);
		$this->db->where('status', 'Active');
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get('customer');
		$output = '<option value="">Select customer code</option>';
		foreach ($query->result() as $row) {
			$output .= '<option value="' . $row->customerid. '@' . $row->monthlycharge . '">'.$row->customercode. '</option>';
		}
		return $output;
	}

	//---------------------------------------

	public function getcustomername($codeid)
	{
		$this->db->where('customercode', $codeid);
		$query = $this->db->get('customer');
		$output = '';
		foreach ($query->result() as $row) {
			$output = $row->name;
		}
		return $output;
	}

	//-------------------------------------

	public function fetchactivecustomer($customerid)
	{
		$this->db->where('customerid', $customerid);
		$query = $this->db->get('customer');
		$output = $query->row->name;
		
		return $output;
	}

	//-------------------------------------

	public function getledgerdetails($customerid)
	{
		$this->db->where('customerid =', $customerid);
		$this->db->where('year =', $data['year']);
		$query = $this->db->get('ledger');
		return $query->row();
	}

	//----------------------------------------

	public function checkpaymentinyear($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('paymentyear =', $data['year']);
		$query = $this->db->get('payments');
		return $query->row();
	}

	//-----------------------------------------

	public function checkpaymentjan($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('jan =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}

	//--------------------------------------------

	public function checkagentcomminyear($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$query = $this->db->get('commission');
		return $query->row();
	}

	//--------------------------------------------

	public function checkagentjancomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('jan =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}

	//------------------------------------------------

	//customer yet to pay for the month but has paid at least ones in the year, agent has comm
	//comm in year but not in month

	public function savejanpayment($data)
	{
		$this->db->trans_begin();

		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['jan' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['janagentcomm'],
													'lawmacomm' => $data['janlawmacomm'],
													'jan' => $data['agentcomm'],
													'totalmonthcollection' => $data['jancollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
            return $insert_id;
		}	
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function savejanpayment1($data)
	{
		$this->db->trans_begin();

		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['jan' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['janagentcomm'],
													'lawmacomm' => $data['janlawmacomm'],
													'jan' => $data['partjan'],
													'totalmonthcollection' => $data['jancollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}		
	}

	//-------------no commission in year, customer paid in year not month

	public function savejanpayment2($data)
	{
		$this->db->trans_begin();
		
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['jan' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		//$this->db->where('agentid =', $data['agentid']);
		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'jan' => $data['agentcomm'],
													'year' => $data['year'],
													'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}	
	}

	//------------customer pay, agent has comm in year but not in month

	public function savejanpayment3($data)
	{
		$this->db->trans_begin();

		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['jan' => $data['janamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['janagentcomm'],
															'lawmacomm' => $data['janlawmacomm'],
															'jan' => $data['agentcomm'],
															'totalmonthcollection' => $data['jancollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function savejanpayment4($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['jan' => $data['janamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['janagentcomm'],
													'lawmacomm' => $data['janlawmacomm'],
													'jan' => $data['partjan'],
													'totalmonthcollection' => $data['jancollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------customer paid in month,no agent comm in year

	public function savejanpayment5($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['jan' => $data['janamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'jan' => $data['agentcomm'],
													'year' => $data['year'],
													'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'narration' => $data['desc'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}	
	}

	//-------------februaryyyyyy----------------

	/*public function checkpaymentfeb($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('feb =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}*/

	//----------------------------------------

	/*public function checkagentfebcomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->where('feb =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}*/

	//------------feb-----------------

	public function savefebpayment($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['feb' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['febagentcomm'],
													'lawmacomm' => $data['feblawmacomm'],
													'feb' => $data['agentcomm'],
													'totalmonthcollection' => $data['febcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function savefebpayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['feb' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['febagentcomm'],
													'lawmacomm' => $data['feblawmacomm'],
													'feb' => $data['partfeb'],
													'totalmonthcollection' => $data['febcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}	
	}

	//-------------no commission in year, customer paid in year not month

	public function savefebpayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['feb' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		//$this->db->where('agentid =', $data['agentid']);
		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'feb' => $data['agentcomm'],
													'year' => $data['year'],
													'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'narration' => $data['desc'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//------------customer pay, agent has comm in year but not in month

	public function savefebpayment3($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['feb' => $data['febamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['febagentcomm'],
													'lawmacomm' => $data['feblawmacomm'],
													'feb' => $data['agentcomm'],
													'totalmonthcollection' => $data['febcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'narration' => $data['desc'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function savefebpayment4($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['feb' => $data['febamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['febagentcomm'],
													'lawmacomm' => $data['feblawmacomm'],
													'feb' => $data['partfeb'],
													'totalmonthcollection' => $data['febcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'narration' => $data['desc'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}		
	}

	//----------customer paid in month,no agent comm in year

	public function savefebpayment5($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['feb' => $data['febamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'feb' => $data['agentcomm'],
													'year' => $data['year'],
													'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'narration' => $data['desc'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//-----------------march -------------------

	/*public function checkpaymentmar($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('mar =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}*/

	//----------------------------------------

	/*public function checkagentmarcomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->where('mar =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}*/

	//------------mar-----------------

	public function savemarpayment($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['mar' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['maragentcomm'],
													'lawmacomm' => $data['marlawmacomm'],
													'mar' => $data['agentcomm'],
													'totalmonthcollection' => $data['marcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function savemarpayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['mar' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['maragentcomm'],
													'lawmacomm' => $data['marlawmacomm'],
													'mar' => $data['partmar'],
													'totalmonthcollection' => $data['marcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//-------------no commission in year, customer paid in year not month

	public function savemarpayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['mar' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		//$this->db->where('agentid =', $data['agentid']);
		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'mar' => $data['agentcomm'],
													'year' => $data['year'],
													'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'narration' => $data['desc'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//------------customer pay, agent has comm in year but not in month

	public function savemarpayment3($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['mar' => $data['maramt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['maragentcomm'],
													'lawmacomm' => $data['marlawmacomm'],
													'mar' => $data['agentcomm'],
													'totalmonthcollection' => $data['marcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'narration' => $data['desc'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function savemarpayment4($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['mar' => $data['maramt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['maragentcomm'],
													'lawmacomm' => $data['marlawmacomm'],
													'mar' => $data['partmar'],
													'totalmonthcollection' => $data['marcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'narration' => $data['desc'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------customer paid in month,no agent comm in year

	public function savemarpayment5($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['mar' => $data['maramt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'mar' => $data['agentcomm'],
													'year' => $data['year'],
													'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------------- april--------------------

	/*public function checkpaymentapril($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('april =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}*/

	//----------------------------------------

	/*public function checkagentaprilcomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->where('april =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}*/

	//------------april-----------------

	public function saveaprilpayment($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['april' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['aprilagentcomm'],
													'lawmacomm' => $data['aprillawmacomm'],
													'april' => $data['agentcomm'],
													'totalmonthcollection' => $data['aprilcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'narration' => $data['desc'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return 0;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function saveaprilpayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['april' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['aprilagentcomm'],
													'lawmacomm' => $data['aprillawmacomm'],
													'april' => $data['partapril'],
													'totalmonthcollection' => $data['aprilcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'narration' => $data['desc'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//-------------no commission in year, customer paid in year not month

	public function saveaprilpayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['april' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		//$this->db->where('agentid =', $data['agentid']);
		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'april' => $data['agentcomm'],
													'year' => $data['year'],
													'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'narration' => $data['desc'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//------------customer pay, agent has comm in year but not in month

	public function saveaprilpayment3($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['april' => $data['aprilamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['aprilagentcomm'],
													'lawmacomm' => $data['aprillawmacomm'],
													'april' => $data['agentcomm'],
													'totalmonthcollection' => $data['aprilcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'narration' => $data['desc'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function saveaprilpayment4($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['april' => $data['aprilamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['aprilagentcomm'],
													'lawmacomm' => $data['aprillawmacomm'],
													'april' => $data['partapril'],
													'totalmonthcollection' => $data['aprilcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'narration' => $data['desc'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------customer paid in month,no agent comm in year

	public function saveaprilpayment5($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['april' => $data['aprilamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'april' => $data['agentcomm'],
													'year' => $data['year'],
													'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'narration' => $data['desc'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------------may0000----------

	/*public function checkpaymentmay($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('may =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}*/

	//----------------------------------------

	/*public function checkagentmaycomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->where('may =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}*/

	//------------may-----------------

	public function savemaypayment($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['may' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['mayagentcomm'],
													'lawmacomm' => $data['maylawmacomm'],
													'may' => $data['agentcomm'],
													'totalmonthcollection' => $data['maycollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'narration' => $data['desc'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function savemaypayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['may' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['mayagentcomm'],
													'lawmacomm' => $data['maylawmacomm'],
													'may' => $data['partmay'],
													'totalmonthcollection' => $data['maycollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'narration' => $data['desc'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//-------------no commission in year, customer paid in year not month

	public function savemaypayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['may' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		//$this->db->where('agentid =', $data['agentid']);
		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'may' => $data['agentcomm'],
													'year' => $data['year'],
													'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'narration' => $data['desc'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//------------customer pay, agent has comm in year but not in month

	public function savemaypayment3($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['may' => $data['mayamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['mayagentcomm'],
													'lawmacomm' => $data['maylawmacomm'],
													'may' => $data['agentcomm'],
													'totalmonthcollection' => $data['maycollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'narration' => $data['desc'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function savemaypayment4($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['may' => $data['mayamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['mayagentcomm'],
													'lawmacomm' => $data['maylawmacomm'],
													'may' => $data['partmay'],
													'totalmonthcollection' => $data['maycollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------customer paid in month,no agent comm in year

	public function savemaypayment5($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['may' => $data['mayamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
															'lawmacomm' => $data['lawmacomm'],
															'agentid' => $data['agentid'],
															'agentname' => $data['agentname'],
															'may' => $data['agentcomm'],
															'year' => $data['year'],
															'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------------june ------------------------

	/*public function checkpaymentjune($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('june =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}*/

	//----------------------------------------

	/*public function checkagentjunecomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->where('june =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}*/

	//------------june-----------------

	public function savejunepayment($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['june' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['juneagentcomm'],
													'lawmacomm' => $data['junelawmacomm'],
													'june' => $data['agentcomm'],
													'totalmonthcollection' => $data['junecollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function savejunepayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['june' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['juneagentcomm'],
														'lawmacomm' => $data['junelawmacomm'],
															'june' => $data['partjune'],
															'totalmonthcollection' => $data['junecollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//-------------no commission in year, customer paid in year not month

	public function savejunepayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['june' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		//$this->db->where('agentid =', $data['agentid']);
		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
															'lawmacomm' => $data['lawmacomm'],
															'agentid' => $data['agentid'],
															'agentname' => $data['agentname'],
															'june' => $data['agentcomm'],
															'year' => $data['year'],
															'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//------------customer pay, agent has comm in year but not in month

	public function savejunepayment3($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['june' => $data['juneamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['juneagentcomm'],
														'lawmacomm' => $data['junelawmacomm'],
															'june' => $data['agentcomm'],
															'totalmonthcollection' => $data['junecollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function savejunepayment4($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['june' => $data['juneamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['juneagentcomm'],
														'lawmacomm' => $data['junelawmacomm'],
															'june' => $data['partjune'],
															'totalmonthcollection' => $data['junecollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------customer paid in month,no agent comm in year

	public function savejunepayment5($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['june' => $data['juneamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
														'lawmacomm' => $data['lawmacomm'],
														'agentid' => $data['agentid'],
														'agentname' => $data['agentname'],
														'june' => $data['agentcomm'],
														'year' => $data['year'],
														'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------july------------------------

	/*public function checkpaymentjuly($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('july =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}*/

	//----------------------------------------

	/*public function checkagentjulycomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->where('july =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}*/

	//------------july-----------------

	public function savejulypayment($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['july' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['julyagentcomm'],
														'lawmacomm' => $data['julylawmacomm'],
															'july' => $data['agentcomm'],
															'totalmonthcollection' => $data['julycollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function savejulypayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['july' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['julyagentcomm'],
														'lawmacomm' => $data['julylawmacomm'],
															'july' => $data['partjuly'],
															'totalmonthcollection' => $data['julycollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//-------------no commission in year, customer paid in year not month

	public function savejulypayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['july' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		//$this->db->where('agentid =', $data['agentid']);
		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'july' => $data['agentcomm'],
													'year' => $data['year'],
													'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//------------customer pay, agent has comm in year but not in month

	public function savejulypayment3($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['july' => $data['julyamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['julyagentcomm'],
														'lawmacomm' => $data['julylawmacomm'],
															'july' => $data['agentcomm'],
															'totalmonthcollection' => $data['julycollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function savejulypayment4($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['july' => $data['julyamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['julyagentcomm'],
														'lawmacomm' => $data['julylawmacomm'],
															'july' => $data['partjuly'],
															'totalmonthcollection' => $data['julycollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------customer paid in month,no agent comm in year

	public function savejulypayment5($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['july' => $data['julyamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'july' => $data['agentcomm'],
													'year' => $data['year'],
													'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//-------------august----------------------

	/*public function checkpaymentaug($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('aug =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}*/

	//----------------------------------------

	/*public function checkagentaugcomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->where('aug =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}*/

	//------------aug-----------------

	public function saveaugpayment($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['aug' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['augagentcomm'],
															'lawmacomm' => $data['auglawmacomm'],
															'aug' => $data['agentcomm'],
															'totalmonthcollection' => $data['augcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function saveaugpayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['aug' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['augagentcomm'],
															'lawmacomm' => $data['auglawmacomm'],
															'aug' => $data['partaug'],
															'totalmonthcollection' => $data['augcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//-------------no commission in year, customer paid in year not month

	public function saveaugpayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['aug' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		//$this->db->where('agentid =', $data['agentid']);
		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'aug' => $data['agentcomm'],
													'year' => $data['year'],
													'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//------------customer pay, agent has comm in year but not in month

	public function saveaugpayment3($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['aug' => $data['augamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['augagentcomm'],
															'lawmacomm' => $data['auglawmacomm'],
															'aug' => $data['agentcomm'],
															'totalmonthcollection' => $data['augcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function saveaugpayment4($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['aug' => $data['augamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['augagentcomm'],
															'lawmacomm' => $data['auglawmacomm'],
															'aug' => $data['partaug'],
															'totalmonthcollection' => $data['augcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------customer paid in month,no agent comm in year

	public function saveaugpayment5($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['aug' => $data['augamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
															'lawmacomm' => $data['lawmacomm'],
															'agentid' => $data['agentid'],
															'agentname' => $data['agentname'],
															'aug' => $data['agentcomm'],
															'year' => $data['year'],
															'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//------------september----------------

	/*public function checkpaymentsept($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('sept =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}*/

	//----------------------------------------

	/*public function checkagentseptcomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->where('sept =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}*/

	//------------sept-----------------

	public function saveseptpayment($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['sept' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['septagentcomm'],
														'lawmacomm' => $data['septlawmacomm'],
															'sept' => $data['agentcomm'],
															'totalmonthcollection' => $data['septcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function saveseptpayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['sept' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['septagentcomm'],
														'lawmacomm' => $data['septlawmacomm'],
															'sept' => $data['partsept'],
															'totalmonthcollection' => $data['septcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//-------------no commission in year, customer paid in year not month

	public function saveseptpayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['sept' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		//$this->db->where('agentid =', $data['agentid']);
		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
															'lawmacomm' => $data['lawmacomm'],
															'agentid' => $data['agentid'],
															'agentname' => $data['agentname'],
															'sept' => $data['agentcomm'],
															'year' => $data['year'],
															'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//------------customer pay, agent has comm in year but not in month

	public function saveseptpayment3($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['sept' => $data['septamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['septagentcomm'],
														'lawmacomm' => $data['septlawmacomm'],
															'sept' => $data['agentcomm'],
															'totalmonthcollection' => $data['septcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function saveseptpayment4($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['sept' => $data['septamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['septagentcomm'],
														'lawmacomm' => $data['septlawmacomm'],
															'sept' => $data['partsept'],
															'totalmonthcollection' => $data['septcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------customer paid in month,no agent comm in year

	public function saveseptpayment5($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['sept' => $data['septamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
															'lawmacomm' => $data['lawmacomm'],
															'agentid' => $data['agentid'],
															'agentname' => $data['agentname'],
															'sept' => $data['agentcomm'],
															'year' => $data['year'],
															'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//-----------october-----------------

	/*public function checkpaymentoct($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('oct =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}*/

	//----------------------------------------

	/*public function checkagentoctcomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->where('oct =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}*/

	//------------oct-----------------

	public function saveoctpayment($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['oct' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['octagentcomm'],
															'lawmacomm' => $data['octlawmacomm'],
															'oct' => $data['agentcomm'],
															'totalmonthcollection' => $data['octcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function saveoctpayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['oct' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['octagentcomm'],
															'lawmacomm' => $data['octlawmacomm'],
															'oct' => $data['partoct'],
															'totalmonthcollection' => $data['octcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//-------------no commission in year, customer paid in year not month

	public function saveoctpayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['oct' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		//$this->db->where('agentid =', $data['agentid']);
		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
															'lawmacomm' => $data['lawmacomm'],
															'agentid' => $data['agentid'],
															'agentname' => $data['agentname'],
															'oct' => $data['agentcomm'],
															'year' => $data['year'],
															'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//------------customer pay, agent has comm in year but not in month

	public function saveoctpayment3($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['oct' => $data['octamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['octagentcomm'],
															'lawmacomm' => $data['octlawmacomm'],
															'oct' => $data['agentcomm'],
															'totalmonthcollection' => $data['octcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function saveoctpayment4($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['oct' => $data['octamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['octagentcomm'],
															'lawmacomm' => $data['octlawmacomm'],
															'oct' => $data['partoct'],
															'totalmonthcollection' => $data['octcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------customer paid in month,no agent comm in year

	public function saveoctpayment5($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['oct' => $data['octamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
															'lawmacomm' => $data['lawmacomm'],
															'agentid' => $data['agentid'],
															'agentname' => $data['agentname'],
															'oct' => $data['agentcomm'],
															'year' => $data['year'],
															'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------november-------------------

	/*public function checkpaymentnov($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('nov =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}*/

	//----------------------------------------

	/*public function checkagentnovcomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->where('nov =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}*/

	//------------nov-----------------

	public function savenovpayment($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['nov' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['novagentcomm'],
															'lawmacomm' => $data['novlawmacomm'],
															'nov' => $data['agentcomm'],
															'totalmonthcollection' => $data['novcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function savenovpayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['nov' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['novagentcomm'],
															'lawmacomm' => $data['novlawmacomm'],
															'nov' => $data['partnov'],
															'totalmonthcollection' => $data['novcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//-------------no commission in year, customer paid in year not month

	public function savenovpayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['nov' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		//$this->db->where('agentid =', $data['agentid']);
		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
															'lawmacomm' => $data['lawmacomm'],
															'agentid' => $data['agentid'],
															'agentname' => $data['agentname'],
															'nov' => $data['agentcomm'],
															'year' => $data['year'],
															'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//------------customer pay, agent has comm in year but not in month

	public function savenovpayment3($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['nov' => $data['novamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['novagentcomm'],
															'lawmacomm' => $data['novlawmacomm'],
															'nov' => $data['agentcomm'],
															'totalmonthcollection' => $data['novcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function savenovpayment4($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['nov' => $data['novamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['novagentcomm'],
															'lawmacomm' => $data['novlawmacomm'],
															'nov' => $data['partnov'],
															'totalmonthcollection' => $data['novcollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------customer paid in month,no agent comm in year

	public function savenovpayment5($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['nov' => $data['novamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
															'lawmacomm' => $data['lawmacomm'],
															'agentid' => $data['agentid'],
															'agentname' => $data['agentname'],
															'nov' => $data['agentcomm'],
															'year' => $data['year'],
															'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//-----------december------------------------

	/*public function checkpaymentdecember($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('december =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}*/

	//----------------------------------------

	/*public function checkagentdecembercomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('december =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}*/

	//------------december-----------------

	public function savedecemberpayment($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['december' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['decemberagentcomm'],
															'lawmacomm' => $data['decemberlawmacomm'],
															'december' => $data['agentcomm'],
															'totalmonthcollection' => $data['decembercollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function savedecemberpayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['december' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['decemberagentcomm'],
															'lawmacomm' => $data['decemberlawmacomm'],
															'december' => $data['partdecember'],
															'totalmonthcollection' => $data['decembercollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//-------------no commission in year, customer paid in year not month

	public function savedecemberpayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['december' => $data['amount']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		//$this->db->where('agentid =', $data['agentid']);
		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
															'lawmacomm' => $data['lawmacomm'],
															'agentid' => $data['agentid'],
															'agentname' => $data['agentname'],
															'december' => $data['agentcomm'],
															'year' => $data['year'],
															'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//------------customer pay, agent has comm in year but not in month

	public function savedecemberpayment3($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['december' => $data['decemberamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['decemberagentcomm'],
															'lawmacomm' => $data['decemberlawmacomm'],
															'december' => $data['agentcomm'],
															'totalmonthcollection' => $data['decembercollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function savedecemberpayment4($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['december' => $data['decemberamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update monthly agent commission
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['decemberagentcomm'],
															'lawmacomm' => $data['decemberlawmacomm'],
															'december' => $data['partdecember'],
															'totalmonthcollection' => $data['decembercollection']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------customer paid in month,no agent comm in year

	public function savedecemberpayment5($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['december' => $data['decemberamt']]);

		//update ledger
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('ledger', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentcomm' => $data['agentcomm'],
															'lawmacomm' => $data['lawmacomm'],
															'agentid' => $data['agentid'],
															'agentname' => $data['agentname'],
															'december' => $data['agentcomm'],
															'year' => $data['year'],
															'totalmonthcollection' => $data['amount']]);

		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//-------------dddddddddddd----------------

	public function savefirstjanpayment($data)
	{
		$this->db->trans_begin();
		//update customers table
		$this->db->where('customerid =', $data['customerid']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'jan' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentjancomm'],
													'lawmacomm' => $data['lawmacomm'],
													'totalmonthcollection' => $data['collection'],
													'jan' => $data['agentcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------------------------------------------

	public function savefirstjanpayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'jan' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentjancomm'],
													'lawmacomm' => $data['lawmajancomm'],
													'totalmonthcollection' => $data['collection'],
													'jan' => $data['newcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------------------------------------

	public function savefirstjanpayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//insert into ledger table
		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'jan' => $data['amount'],
											'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'totalmonthcollection' => $data['amount'],
													'jan' => $data['agentcomm'],
													'year' => $data['year']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//-------------february-------------------

	public function savefirstfebpayment($data)
	{
		$this->db->trans_begin();
		//update customers table
		$this->db->where('customerid =', $data['customerid']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'feb' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentfebcomm'],
													'lawmacomm' => $data['lawmafebcomm'],
													'totalmonthcollection' => $data['collection'],
													'feb' => $data['agentcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------------------------------------------

	public function savefirstfebpayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'feb' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentfebcomm'],
													'lawmacomm' => $data['lawmafebcomm'],
													'totalmonthcollection' => $data['collection'],
													'feb' => $data['newcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------------------------------------

	public function savefirstfebpayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//insert into ledger table
		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'feb' => $data['amount'],
											'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'totalmonthcollection' => $data['amount'],
													'feb' => $data['agentcomm'],
													'year' => $data['year']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//------march--------------------------

	public function savefirstmarpayment($data)
	{
		$this->db->trans_begin();
		//update customers table
		$this->db->where('customerid =', $data['customerid']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'mar' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentmarcomm'],
													'lawmacomm' => $data['lawmamarcomm'],
													'totalmonthcollection' => $data['collection'],
													'mar' => $data['agentcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------------------------------------------

	public function savefirstmarpayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'mar' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentmarcomm'],
													'lawmacomm' => $data['lawmamarcomm'],
												'totalmonthcollection' => $data['collection'],
													'mar' => $data['newcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------------------------------------

	public function savefirstmarpayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//insert into ledger table
		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'mar' => $data['amount'],
											'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentid' => $data['agentid'],
															'agentname' => $data['agentname'],
															'agentcomm' => $data['agentcomm'],
															'lawmacomm' => $data['lawmacomm'],
															'totalmonthcollection' => $data['amount'],
															'mar' => $data['agentcomm'],
															'year' => $data['year']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------------april

	public function savefirstaprilpayment($data)
	{
		$this->db->trans_begin();
		//update customers table
		$this->db->where('customerid =', $data['customerid']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'april' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentaprilcomm'],
													'lawmacomm' => $data['lawmaaprilcomm'],
													'totalmonthcollection' => $data['collection'],
													'april' => $data['agentcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------------------------------------------

	public function savefirstaprilpayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'april' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentaprilcomm'],
													'lawmacomm' => $data['lawmaaprilcomm'],
													'totalmonthcollection' => $data['collection'],
													'april' => $data['newcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------------------------------------

	public function savefirstaprilpayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//insert into ledger table
		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'april' => $data['amount'],
											'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'totalmonthcollection' => $data['amount'],
													'april' => $data['agentcomm'],
													'year' => $data['year']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------------may

	public function savefirstmaypayment($data)
	{
		$this->db->trans_begin();
		//update customers table
		$this->db->where('customerid =', $data['customerid']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'may' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentmaycomm'],
													'lawmacomm' => $data['lawmamaycomm'],
													'totalmonthcollection' => $data['collection'],
													'may' => $data['agentcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------------------------------------------

	public function savefirstmaypayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'may' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentmaycomm'],
													'lawmacomm' => $data['lawmamaycomm'],
													'totalmonthcollection' => $data['collection'],
													'may' => $data['newcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------------------------------------

	public function savefirstmaypayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
									'lastpayment' => $data['amount'],
									'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//insert into ledger table
		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'may' => $data['amount'],
											'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'totalmonthcollection' => $data['amount'],
													'may' => $data['agentcomm'],
													'year' => $data['year']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------june

	public function savefirstjunepayment($data)
	{
		$this->db->trans_begin();
		//update customers table
		$this->db->where('customerid =', $data['customerid']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'june' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentjunecomm'],
													'lawmacomm' => $data['lawmajunecomm'],
													'totalmonthcollection' => $data['collection'],
													'june' => $data['agentcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------------------------------------------

	public function savefirstjunepayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
									'lastpayment' => $data['amount'],
									'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'june' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentjunecomm'],
													'lawmacomm' => $data['lawmajunecomm'],
													'totalmonthcollection' => $data['collection'],
													'june' => $data['newcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------------------------------------

	public function savefirstjunepayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
									'lastpayment' => $data['amount'],
									'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//insert into ledger table
		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'june' => $data['amount'],
											'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'totalmonthcollection' => $data['amount'],
													'june' => $data['agentcomm'],
													'year' => $data['year']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------------july

	public function savefirstjulypayment($data)
	{
		$this->db->trans_begin();
		//update customers table
		$this->db->where('customerid =', $data['customerid']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'july' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentjulycomm'],
													'lawmacomm' => $data['lawmajulycomm'],
													'totalmonthcollection' => $data['collection'],
													'july' => $data['agentcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------------------------------------------

	public function savefirstjulypayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
									'lastpayment' => $data['amount'],
									'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'july' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentjulycomm'],
													'lawmacomm' => $data['lawmajulycomm'],
													'totalmonthcollection' => $data['collection'],
													'july' => $data['newcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------------------------------------

	public function savefirstjulypayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
									'lastpayment' => $data['amount'],
									'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//insert into ledger table
		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'july' => $data['amount'],
											'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'totalmonthcollection' => $data['amount'],
													'july' => $data['agentcomm'],
													'year' => $data['year']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//-------------august

	public function savefirstaugpayment($data)
	{
		$this->db->trans_begin();
		//update customers table
		$this->db->where('customerid =', $data['customerid']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'aug' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentaugcomm'],
													'lawmacomm' => $data['lawmaaugcomm'],
													'totalmonthcollection' => $data['collection'],
													'aug' => $data['agentcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------------------------------------------

	public function savefirstaugpayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
									'lastpayment' => $data['amount'],
									'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'aug' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentaugcomm'],
													'lawmacomm' => $data['lawmaaugcomm'],
													'totalmonthcollection' => $data['collection'],
													'aug' => $data['newcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------------------------------------

	public function savefirstaugpayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
									'lastpayment' => $data['amount'],
									'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//insert into ledger table
		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'aug' => $data['amount'],
											'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'totalmonthcollection' => $data['amount'],
													'aug' => $data['agentcomm'],
													'year' => $data['year']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//-----------september

	public function savefirstseptpayment($data)
	{
		$this->db->trans_begin();
		//update customers table
		$this->db->where('customerid =', $data['customerid']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'sept' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentseptcomm'],
													'lawmacomm' => $data['lawmaseptcomm'],
													'totalmonthcollection' => $data['collection'],
													'sept' => $data['agentcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------------------------------------------

	public function savefirstseptpayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
									'lastpayment' => $data['amount'],
									'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'sept' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentseptcomm'],
													'lawmacomm' => $data['lawmaseptcomm'],
													'totalmonthcollection' => $data['collection'],
													'sept' => $data['newcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------------------------------------

	public function savefirstseptpayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
									'lastpayment' => $data['amount'],
									'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//insert into ledger table
		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'sept' => $data['amount'],
											'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'totalmonthcollection' => $data['amount'],
													'sept' => $data['agentcomm'],
													'year' => $data['year']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------------october

	public function savefirstoctpayment($data)
	{
		$this->db->trans_begin();
		//update customers table
		$this->db->where('customerid =', $data['customerid']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'oct' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentoctcomm'],
													'lawmacomm' => $data['lawmaoctcomm'],
													'totalmonthcollection' => $data['collection'],
													'oct' => $data['agentcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------------------------------------------

	public function savefirstoctpayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
									'lastpayment' => $data['amount'],
									'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'oct' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentoctcomm'],
													'lawmacomm' => $data['lawmaoctcomm'],
													'totalmonthcollection' => $data['collection'],
													'oct' => $data['newcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------------------------------------

	public function savefirstoctpayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
									'lastpayment' => $data['amount'],
									'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//insert into ledger table
		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'oct' => $data['amount'],
											'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'totalmonthcollection' => $data['amount'],
													'oct' => $data['agentcomm'],
													'year' => $data['year']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------november

	public function savefirstnovpayment($data)
	{
		$this->db->trans_begin();
		//update customers table
		$this->db->where('customerid =', $data['customerid']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'nov' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentnovcomm'],
													'lawmacomm' => $data['lawmanovcomm'],
													'totalmonthcollection' => $data['collection'],
													'nov' => $data['agentcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------------------------------------------

	public function savefirstnovpayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
									'lastpayment' => $data['amount'],
									'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'nov' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentnovcomm'],
													'lawmacomm' => $data['lawmanovcomm'],
													'totalmonthcollection' => $data['collection'],
													'nov' => $data['newcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------------------------------------

	public function savefirstnovpayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
									'lastpayment' => $data['amount'],
									'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//insert into ledger table
		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'nov' => $data['amount'],
											'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentid' => $data['agentid'],
													'agentname' => $data['agentname'],
													'agentcomm' => $data['agentcomm'],
													'lawmacomm' => $data['lawmacomm'],
													'totalmonthcollection' => $data['amount'],
													'nov' => $data['agentcomm'],
													'year' => $data['year']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//-----------december

	public function savefirstdecemberpayment($data)
	{
		$this->db->trans_begin();
		//update customers table
		$this->db->where('customerid =', $data['customerid']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
										'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'december' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentdecembercomm'],
													'lawmacomm' => $data['lawmadecembercomm'],
													'totalmonthcollection' => $data['collection'],
													'december' => $data['agentcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//--------------------------------------------

	public function savefirstdecemberpayment1($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
									'lastpayment' => $data['amount'],
									'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'december' => $data['amount'],
											'year' => $data['year']]);

		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		//update agentcommissionbymonth
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		$this->db->update('agentscommissionbymonth', ['agentcomm' => $data['agentdecembercomm'],
													'lawmacomm' => $data['lawmadecembercomm'],
													'totalmonthcollection' => $data['collection'],
													'december' => $data['newcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//----------------------------------------

	public function savefirstdecemberpayment2($data)
	{
		$this->db->trans_begin();
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
									'lastpayment' => $data['amount'],
									'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//insert into ledger table
		$this->db->insert('ledger', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'debt' => $data['newdebt'],
									'wallet' => $data['wallet'],
									'monthlycharge' => $data['mntcharge'],
									'amtcollected' => $data['amtcollect'],
									'amtexpected' => $data['amtdue'],
									'year' => $data['year']]);

		//insert into paymentsbymonth table
		$this->db->insert('paymentsbymonth', ['customerid' => $data['customerid'],
											'customername' => $data['customer'],
											'december' => $data['amount'],
											'year' => $data['year']]);

		//insert agent commission
		$this->db->insert('commission', ['agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										'agentcomm' => $data['agentcomm'],
										'lawmacomm' => $data['lawmacomm'],
										'netcomm' => $data['netcomm'],
										'month' => $data['month'],
										'year' => $data['year'],
										'paymentdate' => $data['paymentdate'],
										'entrancedate' => $data['entrydate'],
										'enteredby' => $data['enteredby'],
										'totalcollection' => $data['amount']]);

		$this->db->insert('agentscommissionbymonth', ['agentid' => $data['agentid'],
															'agentname' => $data['agentname'],
															'agentcomm' => $data['agentcomm'],
															'lawmacomm' => $data['lawmacomm'],
													'totalmonthcollection' => $data['amount'],
															'december' => $data['agentcomm'],
															'year' => $data['year']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									//'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'narration' => $data['desc'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id = 0;
			return $insert_id;
		}
		else {
			$this->db->trans_commit();
		    return $insert_id;
		}
	}

	//-------------------------------------------

	public function allinvoice($data)
	{
		$this->db->where('status =', 'Active');
		//$this->db->where('customertype !=', 'Commercial');
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//-----------------------------------------------

	public function invoicebysector($data)
	{
		$this->db->where('sectorid =', $data['sector']);
		$this->db->where('status =', 'Active');
		//$this->db->where('customertype !=', 'Commercial');
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//--------------------------------------

	public function invoicebystreet($data)
	{
		$this->db->where('sectorid =', $data['sector']);
		$this->db->where('streetid =', $data['street']);
		$this->db->where('status =', 'Active');
		//$this->db->where('customertype !=', 'Commercial');
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//------------------------------------------------

	public function invoicebyhouseno($data)
	{
		$this->db->where('sectorid =', $data['sector']);
		$this->db->where('streetid =', $data['street']);
		$this->db->where('houseid =', $data['houseno']);
		$this->db->where('status =', 'Active');
		//$this->db->where('customertype !=', 'Commercial');
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//------------------------------------------

	public function invoicebycustomerid($data)
	{
		$this->db->where('customerid =', $data['id']);
		//$this->db->where('status =', 'Active');
		//$this->db->order_by('name', 'ASC');
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//---------------------------------------------------

	public function updatecustomeraccount($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		return $this->db->update('customer', ['debt' => $data['debt'],
											'wallet' => $data['wallet'],
											'lastinvoicegeneratedate' => $data['today'],
											'formerdebt' => $data['rdebt'],
											'formerwallet' => $data['rwallet'],
											'num' => $data['i']]);
	}

	//---------------------------------

	public function allcustomerinvoicelist()
	{
		$this->db->where('debt >', 0);
		$this->db->where('status =', 'Active');
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('invoice');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//----------------------------------------

	public function customerinvoicebysector($data)
	{
		$this->db->where('debt >', 0);
		$this->db->where('sectorid =', $data['sector']);
		$this->db->where('status =', 'Active');
		$this->db->order_by('customername', 'ASC');
		$query = $this->db->get('invoice');	
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//------------------------------------------

	public function customerinvoicebystreet($data)
	{
		$this->db->where('debt >', 0);
		$this->db->where('sectorid =', $data['sector']);
		$this->db->where('streetid =', $data['street']);
		$this->db->where('status =', 'Active');
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('invoice');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//----------------------------------------

	public function customerinvoicebyhouse($data)
	{
		$this->db->where('debt >', 0);
		$this->db->where('sectorid =', $data['sector']);
		$this->db->where('streetid =', $data['street']);
		$this->db->where('houseid =', $data['houseno']);
		$this->db->where('status =', 'Active');
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('invoice');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//------------------------------------

	public function singlecustomerinvoice($data)
	{
		$this->db->where('customerid =', $data['id']);
		$query = $this->db->get('invoice');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//----------------------------------

	/*public function getsingleinvoice($data)
	{
		$this->db->where('customerid =', $data['id']);
		$query = $this->db->get('customer');
		return $query->row();
	}*/

	//--------------------------------------

	public function getpaymentrecords($customerid)
	{
		$this->db->where('customerid =', $customerid);
		$query = $this->db->get('payments');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//---------------------------------------

	public function checkcustomerdebt($id)
	{
		$this->db->where('customerid =', $id);
		//$this->db->where('debt >', 0);
		$query = $this->db->get('customer');
		return $query->row();
	}

	//-------------------------------------

	public function getpaymentdetails($paymentid)
	{
		$this->db->where('paymentid =', $paymentid);
		$query = $this->db->get('payments');
		return $query->row();
	}

	//------------------------------------------

	public function affectedcustomers($data)
	{
		$this->db->where('housecatid =', $data['id']);
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//-----------------------------------------

	public function gethousetypenos($config)
	{
		$this->db->where('sectorid =', $config['sector']);
		$this->db->where('streetid =', $config['street']);
		$this->db->where('houseno =', $config['house']);
		$this->db->where('housecatid =', $config['housecatid']);
		$query = $this->db->get('customer');
		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//-----------------------------------------

	public function updatecustomercode($config)
	{
		$this->db->where('customerid =', $config['customerid']);
		return $this->db->update('customer', ['housetypecode' => $config['code'],
											'housecat' => $config['housetype'],
											'customercode' => $config['customercode']]);
	}

	//------------------------------------------

	/*public function affectedsectorcustomers($data)
	{
		$this->db->where('sectorid =', $data['id']);
		$query = $this->db->get('customer');
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}*/

	//--------------------------------------------

	public function updatecustomersec($config)
	{
		$this->db->where('customerid =', $config['customerid']);
		return $this->db->update('customer', ['customercode' => $config['code']]);
	}

	//-----------------------------------------

	public function affectedcustomersstr($data)
	{
		$this->db->where('streetid =', $data['id']);
		$query = $this->db->get('customer');
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//----------------------------------------

	public function affectedcustomershouse($data)
	{
		$this->db->where('houseid =', $data['id']);
		$query = $this->db->get('customer');
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//----------------------------------------

	public function checkCommercialType($commercialname)
	{
		$this->db->where('typeName =', $commercialname);
		$query = $this->db->get('commercialtype');
		return $query->row();
	}

	//---------------------------------------

	public function checkarea($areaname)
	{
		$this->db->where('areaname =', $areaname);
		$query = $this->db->get('area');
		return $query->row();
	}

	//----------------------------------------------

	public function addnewarea($areaname)
	{
		return $this->db->insert('area', ['areaname' => $areaname]);
	}

	//----------------------------------

	public function addNewCommercialType($commercialname)
	{
		return $this->db->insert('commercialtype', ['typeName' => $commercialname,
													'status' => 'Active']);
	}

	//---------------------------------------------------

	public function getAreas()
	{
		//$this->db->where('status =', 'Active');
		$this->db->order_by('areaname', 'ASC');
		$query = $this->db->get('area');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//-----------------------------------------------

	public function getsinglearea($areaid)
	{
		$this->db->where('areaid =', $areaid);
		$query = $this->db->get('area');
		return $query->row();
	}

	//--------------------------------------------

	public function checkareabyid($data)
	{
		$this->db->where('areaname =', $data['area']);
		$query = $this->db->get('area');
		return $query->row();
	}

	//--------------------------------------------------

	public function updatearea($data)
	{
		$this->db->where('areaid =', $data['id']);
		$this->db->update('area', ['areaname' => $data['area']]);

		$this->db->where('areaid =', $data['id']);
		$this->db->update('customer', ['areaname' => $data['area']]);

		$this->db->where('areaid =', $data['id']);
		return $this->db->update('sector', ['areaname' => $data['area']]);
	}

	//-------------------------------------------------

	public function getsinglecustomerbycode($code)
	{
		$this->db->where('customercode =', $code);
		$query = $this->db->get('customer');
		return $query->row();
	}

	//-------------------------------------------------

	public function checkinvoicetable($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$query = $this->db->get('invoice');
		return $query->row();
	}

	//-----------------------------------------------

	public function addnewinvoice($data)
	{
		return $this->db->insert('invoice', ['customerid' => $data['customerid'],
								'status' => $data['status'],
								'sectorid' => $data['sectorid'],
								'streetid' => $data['streetid'],
								'houseid' => $data['houseid'],
								'customercode' => $data['customercode'],
								'customername' => $data['name'],
								'sectorname' => $data['sectorname'],
								'address' => $data['address'],
								'deadlinedate' => $data['dateplus7'],
								'invoicemonth' => $data['monthx'],
								'invoicemonthnumber' => $data['month'],
								'invoiceyear' => $data['year'],
								'customertype' => $data['customertype'],
								'lastpaymentdate' => $data['lastpaymentdate'],
								'lastpayment' => $data['lastpayment'],
								'monthlycharge' => $data['monthlycharge'],
								'debt' => $data['debt'],
								'formerdebt' => $data['rdebt'],
								'wallet' => $data['wallet'],
								'formerwallet' => $data['rwallet'],
								'generatedby' => $data['username'],
								//'cStatus' => $data['status'],
								'invoicegeneratedate' => $data['todayx']]);
	}

	//------------------------------------------------

	public function addnewinvoice1($data)
	{
		$this->db->trans_begin();
		//delete previous invoice by same customer
		$this->db->where('customerid =', $data['customerid']);
		$this->db->delete('invoice');

		$this->db->insert('invoice', ['customerid' => $data['customerid'],
								'status' => $data['status'],
								'sectorid' => $data['sectorid'],
								'streetid' => $data['streetid'],
								'houseid' => $data['houseid'],
								'customercode' => $data['customercode'],
								'customername' => $data['name'],
								'sectorname' => $data['sectorname'],
								'address' => $data['address'],
								'deadlinedate' => $data['dateplus7'],
								'invoicemonth' => $data['monthx'],
								'invoicemonthnumber' => $data['month'],
								'invoiceyear' => $data['year'],
								'customertype' => $data['customertype'],
								'lastpaymentdate' => $data['lastpaymentdate'],
								'lastpayment' => $data['lastpayment'],
								'monthlycharge' => $data['monthlycharge'],
								'debt' => $data['debt'],
								'formerdebt' => $data['rdebt'],
								'wallet' => $data['wallet'],
								'formerwallet' => $data['rwallet'],
								'generatedby' => $data['username'],
								//'cStatus' => $data['status'],
								'invoicegeneratedate' => $data['todayx']]);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		}
		else {
			$this->db->trans_commit();
            return TRUE;
		}
	}

	//----------------------------------------

	public function paymentInMonth($data)
	{
		$shh = $data['year'] . '-' . date('m') . '-09';
		$this->db->where('paymentmonth =', $data['month']);
		$this->db->where('paymentyear =', $data['year']);
		$this->db->where('paymentdate <=', $shh);
		$this->db->order_by('paymentdate', 'DESC');

		$query = $this->db->get('payments');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//------------------------------------------------

	public function getotheractivehouses($sectorid, $streetid, $houseid)
	{
		$this->db->where('sectorid =', $sectorid);
		$this->db->where('streetid =', $streetid);
		$this->db->where('houseid !=', $houseid);
		$this->db->where('status =', 'Active');

		$query = $this->db->get('house');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//---------------------------------------------------

	public function fetchMaxCommercialVal()
	{
		$this->db->select_max('counter');
		$this->db->where('customertype =', 'Commercial');
		$query = $this->db->get('customer');  
		return $query->row()->counter;
	}

	//------------------------------------------------

	public function fetchMaxResidential($streetid)
	{
		$this->db->select_max('counter');
		$this->db->where('streetid =', $streetid);
		$this->db->where('customertype =', 'Residential');
		$query = $this->db->get('customer');  
		return $query->row()->counter;
	}

	//----------------------------------------------

	public function updatecode($customerid, $customercode, $counter)
	{
		$this->db->where('customerid =', $customerid);
		$this->db->where('customertype =', 'Commercial');
		return $this->db->update('customer', ['customercode' => $customercode,
										'counter' => $counter]);
	}

	//----------------------------------------------

	public function updaterescode($customerid, $streetid, $counter, $customercode)
	{
		$this->db->where('customerid =', $customerid);
		$this->db->where('streetid =', $streetid);
		$this->db->where('customertype =', 'Residential');
		return $this->db->update('customer', ['customercode' => $customercode,
										'counter' => $counter]);
	}

	//--------------------------------------------

	public function updatestrtcode($streetid, $streetcode)
	{
		$this->db->where('streetid =', $streetid);
		return $this->db->update('street', ['streetcode' => $streetcode]);
	}

	//---------------------------------------------

	public function getinv()
	{
		$query = $this->db->get('invoice');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//---------------------------------------------

	public function updcustomerinvoice($customerid, $address)
	{
		$this->db->where('customerid =', $customerid);
		return $this->db->update('invoice', ['address' => $address]);
	}

	//------------------------------------------------

	public function saveDebit($data)
	{
		return $this->db->insert('cashbook', ['date' => $data['paymentdate'],
											'narration' => $data['narration'],
											'debit' => $data['amount'],
											'credit' => 0]);
	}

	//----------------------------------------------------

	public function saveLawmaComm($data)
	{
		return $this->db->insert('cashbook', ['date' => $data['paymentdate'],
											'narration' => $data['details'],
											'credit' => $data['agentcomm'],
											'debit' => 0]);
	}

	//----------------------------------------------------

	public function saveAgentComm($data)
	{
		return $this->db->insert('cashbook', ['date' => $data['paymentdate'],
											'narration' => $data['details'],
											'credit' => $data['agentcomm'],
											'debit' => 0]);
	}

	//------------------------------------------------

	public function getcustomerinvoicetable()
	{
		$this->db->order_by('customerid', 'ASC');
		$query = $this->db->get('invoice');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//-----------------------------------------

	public function updateInvoiceRecord($id, $month)
	{
		/*$this->db->trans_begin();

		
		$this->db->where('customerid =', $id);
		$query = $this->db->get('customer');
		$query = $query->row();
		$status = $query->status;*/

		//update invoice table
		$this->db->where('customerid =', $id);
		return $this->db->update('invoice', ['invoicemonthnumber' => $month]);

		/*$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		}
		else {
			$this->db->trans_commit();
            return TRUE;
		}*/
	}

	//-------------------------------------------

	public function getSignature($id)
	{
		$this->db->where('userid =', $id);
		$query = $this->db->get('users');
		$query = $query->row();
		$signature = $query->signature;

		return $signature;
	}

	//-------------------------------------------

	public function getCommercialTypes()
	{
		$this->db->order_by('typeName', 'ASC');
		$query = $this->db->get('commercialtype');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//--------------------------------------------

	public function updateCommercialType($data)
	{
		$this->db->where('typeId =', $data['typeId']);
		return $this->db->update('commercialtype', ['typeName' => $data['typeName'],
													'status' => $data['status']]);
	}

	//--------------------------------------------

	public function getCustomersInArea($area)
	{
		$this->db->where('areaid =', $area);
		$this->db->where('status =', 'Active');
		$query = $this->db->get('customer');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//-------------------------------------------

	public function getSectorsInArea($area)
	{
		$this->db->where('areaid =', $area);
		$query = $this->db->get('sector');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//-----------------------------------------

	public function getCustomersInSector($area, $sector)
	{
		$this->db->where('areaname =', $area);
		$this->db->where('sectorname =', $sector);
		//$this->db->where('debt >', 0);
		$this->db->where('status =', 'Active');
		$query = $this->db->get('customer');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//-------------------------------------------

	public function getStreetsInSector($sector)
	{
		$this->db->where('sectorname =', $sector);
		$query = $this->db->get('street');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//-------------------------------------------

	public function getCustomersInStreet($sector, $street)
	{
		$this->db->where('sectorname =', $sector);
		$this->db->where('streetname =', $street);
		//$this->db->where('debt >', 0);
		$this->db->where('status =', 'Active');
		$query = $this->db->get('customer');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//----------------------------------------

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

	//--------------------------------------

	public function getCustomersInHouse($house, $street, $sector)
	{
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

	//----------------------------------

	public function updateInvoiceStatus($row)
	{
		$this->db->where('customerid =', $row->customerid);
		return $this->db->update('invoice', ['status' => $row->status]);
	}

	//----------------------------------------
}