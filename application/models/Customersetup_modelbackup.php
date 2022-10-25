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
								'agentid' => $data['agent'],
								'agentname' => $data['agentname'],
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
									'agentid' => $data['agent'],
									'agentname' => $data['agentname'],
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

		//update customer table
		$this->db->where('sectorid =', $data['id']);
		return $this->db->update('customer', ['status' => $data['status'],
											'agentid' => $data['agent'],
											'temp' => $data['var'],
											'sectorname' => $data['sector']]);
	}

	//----------------------------------------------

	public function getaffectedrows($data)
	{
		$this->db->where('temp =', $data['var']);
		$query = $this->db->get('customer');
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//---------get active sectors ------------------

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

	//-------- add new street -------------

	public function addstreet($data)
	{
		return $this->db->insert('street', ['sectorid' => $data['sector'],
											'sectorname' => $data['sectorname'],
											'streetname' => $data['street'],
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
											'temp' => $data['var'],
											'streetname' => $data['street']]);

	}

	//--------------------------------------

	public function getaffectedstreetrows($data)
	{
		$this->db->where('temp =', $data['var']);
		$query = $this->db->get('customer');
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
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

	//------------------------------------

	public function checkhousetype($data)
	{
		$this->db->where('housetype =', $data['housetype']);
		$query = $this->db->get('housecategory');
		return $query->row();
	}

	//------------------------------------------

	public function addhousetype($data)
	{
		return $this->db->insert('housecategory', ['housetype' => $data['housetype'],
								'monthlycharge' => $data['mntcharge'],
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
		return $this->db->update('housecategory',
									['housetype' => $data['housetype'],
									'monthlycharge' => $data['mntcharge'],
									'modifiedby' => $data['modifiedby'],
									'datemodified' => $data['modifydate']]);
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
		return $this->db->update('sector', ['agentname', $data['agentname']]);
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
		$this->db->insert('customer', ['houseid' => $data['houseno'],
											'houseno' => $data['house'],
											'customercode' => $data['customercode'],
											'streetid' => $data['street'],
											'streetname' => $data['streetname'],
											'sectorid' => $data['sector'],
											'sectorname' => $data['sectorname'],
											'housecatid' => $data['housetype'],
											'housecat' => $data['housecat'],
											'status' => 'Active',
											'num' => $data['i'],
											'agentid' => $data['agentid'],
											'agentname' => $data['agentname'],
											//'title' => $data['title'],
											//'fname' => $data['fname'],
											'monthlycharge' => $data['mntcharge'],
											//'oname' => $data['oname'],
											'name' => $data['lname'],
											'telno' => $data['telno'],
											'debt' => $data['debt'],
											'wallet' => $data['wallet'],
											'customertype' => $data['customertype'],
											'createdby' => $data['createdby'],
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

		return $this->db->insert('ledger', ['customerid' => $insert_id,
											'customername' => $data['customername'],
											'amtcollected' => $data['amtcollect'],
											'amtexpected' => $data['supposedamt'],
											'debt' => $data['debt'],
											'wallet' => $data['wallet'],
											'monthlycharge' => $data['mntcharge'],
											'year' => $data['year']]);
	}

	//-------------------------------------------

	public function getsinglecustomer($customerid)
	{
		$this->db->where('customerid =', $customerid);
		$query = $this->db->get('customer');
		return $query->row();
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
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['houseid' => $data['houseno'],
										'houseno' => $data['house'],
										'streetid' => $data['street'],
										'streetname' => $data['streetname'],
										'customercode' => $data['customercode'],
										'sectorid' => $data['sector'],
										'sectorname' => $data['sectorname'],
										'housecatid' => $data['housetype'],
										'housecat' => $data['housecat'],
										'status' => $data['status'],
										'agentid' => $data['agentid'],
										'agentname' => $data['agentname'],
										/*'title' => $data['title'],
										'fname' => $data['fname'],
										'oname' => $data['oname'],*/
										'name' => $data['lname'],
										'telno' => $data['telno'],
										'monthlycharge' => $data['mntcharge'],
										'customertype' => $data['customertype'],
										'modifiedby' => $data['modifiedby'],
										'datemodified' => $data['modifydate']]);

		$this->db->where('customerid =', $data['id']);
		return $this->db->update('ledger', ['monthlycharge' => $data['mntcharge']]);	
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

		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['jan' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();

		return $insert_id;
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function savejanpayment1($data)
	{

		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['jan' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();

		return $insert_id;
	}

	//-------------no commission in year, customer paid in year not month

	public function savejanpayment2($data)
	{
		
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['jan' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//------------customer pay, agent has comm in year but not in month

	public function savejanpayment3($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['jan' => $data['janamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function savejanpayment4($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['jan' => $data['janamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------customer paid in month,no agent comm in year

	public function savejanpayment5($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['jan' => $data['janamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-------------februaryyyyyy----------------

	public function checkpaymentfeb($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('feb =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}

	//----------------------------------------

	public function checkagentfebcomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('feb =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}

	//------------feb-----------------

	public function savefebpayment($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['feb' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function savefebpayment1($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['feb' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-------------no commission in year, customer paid in year not month

	public function savefebpayment2($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['feb' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//------------customer pay, agent has comm in year but not in month

	public function savefebpayment3($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['feb' => $data['febamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function savefebpayment4($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['feb' => $data['febamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------customer paid in month,no agent comm in year

	public function savefebpayment5($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['feb' => $data['febamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-----------------march -------------------

	public function checkpaymentmar($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('mar =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}

	//----------------------------------------

	public function checkagentmarcomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('mar =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}

	//------------mar-----------------

	public function savemarpayment($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['mar' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function savemarpayment1($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['mar' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-------------no commission in year, customer paid in year not month

	public function savemarpayment2($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['mar' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//------------customer pay, agent has comm in year but not in month

	public function savemarpayment3($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['mar' => $data['maramt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function savemarpayment4($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['mar' => $data['maramt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------customer paid in month,no agent comm in year

	public function savemarpayment5($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['mar' => $data['maramt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------------- april--------------------

	public function checkpaymentapril($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('april =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}

	//----------------------------------------

	public function checkagentaprilcomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('april =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}

	//------------april-----------------

	public function saveaprilpayment($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['april' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function saveaprilpayment1($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['april' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-------------no commission in year, customer paid in year not month

	public function saveaprilpayment2($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['april' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//------------customer pay, agent has comm in year but not in month

	public function saveaprilpayment3($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['april' => $data['aprilamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function saveaprilpayment4($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['april' => $data['aprilamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------customer paid in month,no agent comm in year

	public function saveaprilpayment5($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['april' => $data['aprilamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------------may0000----------

	public function checkpaymentmay($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('may =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}

	//----------------------------------------

	public function checkagentmaycomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('may =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}

	//------------may-----------------

	public function savemaypayment($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['may' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function savemaypayment1($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['may' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-------------no commission in year, customer paid in year not month

	public function savemaypayment2($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['may' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//------------customer pay, agent has comm in year but not in month

	public function savemaypayment3($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['may' => $data['mayamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function savemaypayment4($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['may' => $data['mayamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------customer paid in month,no agent comm in year

	public function savemaypayment5($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['may' => $data['mayamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------------june ------------------------

	public function checkpaymentjune($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('june =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}

	//----------------------------------------

	public function checkagentjunecomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('june =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}

	//------------june-----------------

	public function savejunepayment($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['june' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function savejunepayment1($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['june' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-------------no commission in year, customer paid in year not month

	public function savejunepayment2($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['june' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//------------customer pay, agent has comm in year but not in month

	public function savejunepayment3($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['june' => $data['juneamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function savejunepayment4($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['june' => $data['juneamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------customer paid in month,no agent comm in year

	public function savejunepayment5($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['june' => $data['juneamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------july------------------------

	public function checkpaymentjuly($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('july =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}

	//----------------------------------------

	public function checkagentjulycomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('july =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}

	//------------july-----------------

	public function savejulypayment($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['july' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function savejulypayment1($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['july' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-------------no commission in year, customer paid in year not month

	public function savejulypayment2($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['july' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//------------customer pay, agent has comm in year but not in month

	public function savejulypayment3($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['july' => $data['julyamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function savejulypayment4($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['july' => $data['julyamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------customer paid in month,no agent comm in year

	public function savejulypayment5($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['july' => $data['julyamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-------------august----------------------

	public function checkpaymentaug($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('aug =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}

	//----------------------------------------

	public function checkagentaugcomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('aug =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}

	//------------aug-----------------

	public function saveaugpayment($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['aug' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function saveaugpayment1($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['aug' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-------------no commission in year, customer paid in year not month

	public function saveaugpayment2($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['aug' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//------------customer pay, agent has comm in year but not in month

	public function saveaugpayment3($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['aug' => $data['augamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function saveaugpayment4($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['aug' => $data['augamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------customer paid in month,no agent comm in year

	public function saveaugpayment5($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['aug' => $data['augamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//------------september----------------

	public function checkpaymentsept($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('sept =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}

	//----------------------------------------

	public function checkagentseptcomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('sept =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}

	//------------sept-----------------

	public function saveseptpayment($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['sept' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function saveseptpayment1($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['sept' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-------------no commission in year, customer paid in year not month

	public function saveseptpayment2($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['sept' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//------------customer pay, agent has comm in year but not in month

	public function saveseptpayment3($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['sept' => $data['septamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function saveseptpayment4($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['sept' => $data['septamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------customer paid in month,no agent comm in year

	public function saveseptpayment5($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['sept' => $data['septamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-----------october-----------------

	public function checkpaymentoct($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('oct =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}

	//----------------------------------------

	public function checkagentoctcomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('oct =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}

	//------------oct-----------------

	public function saveoctpayment($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['oct' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function saveoctpayment1($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['oct' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-------------no commission in year, customer paid in year not month

	public function saveoctpayment2($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['oct' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//------------customer pay, agent has comm in year but not in month

	public function saveoctpayment3($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['oct' => $data['octamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function saveoctpayment4($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['oct' => $data['octamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------customer paid in month,no agent comm in year

	public function saveoctpayment5($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['oct' => $data['octamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------november-------------------

	public function checkpaymentnov($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('nov =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}

	//----------------------------------------

	public function checkagentnovcomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('nov =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}

	//------------nov-----------------

	public function savenovpayment($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['nov' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function savenovpayment1($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['nov' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-------------no commission in year, customer paid in year not month

	public function savenovpayment2($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['nov' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//------------customer pay, agent has comm in year but not in month

	public function savenovpayment3($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['nov' => $data['novamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function savenovpayment4($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['nov' => $data['novamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------customer paid in month,no agent comm in year

	public function savenovpayment5($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['nov' => $data['novamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-----------december------------------------

	public function checkpaymentdecember($data)
	{
		$this->db->where('customerid =', $data['customerid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('december =', 0);
		$query = $this->db->get('paymentsbymonth');
		return $query->row();
	}

	//----------------------------------------

	public function checkagentdecembercomm($data)
	{
		$this->db->where('agentid =', $data['agentid']);
		$this->db->where('year =', $data['year']);
		//$this->db->where('december =', 0);
		$query = $this->db->get('agentscommissionbymonth');
		return $query->row();
	}

	//------------december-----------------

	public function savedecemberpayment($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['december' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------agent has comm in jan, customer not paid in jan but paid in year

	public function savedecemberpayment1($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['december' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-------------no commission in year, customer paid in year not month

	public function savedecemberpayment2($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['december' => $data['amount']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate ' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//------------customer pay, agent has comm in year but not in month

	public function savedecemberpayment3($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['december' => $data['decemberamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrancedate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------customer has existing pay in mnt, agent has comm in month

	public function savedecemberpayment4($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['december' => $data['decemberamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											//'lastenteredby' => $data['enteredby'],
											/*'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------customer paid in month,no agent comm in year

	public function savedecemberpayment5($data)
	{
		//update customer table
		$this->db->where('customerid =', $data['id']);
		$this->db->update('customer', ['debt' => $data['newdebt'],
										'lastpayment' => $data['amount'],
										'lastpaymentdate' => $data['paymentdate'],
									'wallet' => $data['wallet']]);

		//update paymentsbymonth
		$this->db->where('customerid =', $data['id']);
		$this->db->where('year =', $data['year']);
		$this->db->update('paymentsbymonth', ['december' => $data['decemberamt']
											//'year =', $data['year'],
											//'amtcollected' => $data['collected'],
											//'amtexpected' => $data['amtdue'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-------------dddddddddddd----------------

	public function savefirstjanpayment($data)
	{
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
											'year' => $data['year']
											//'amtcollected' => $data['amount'],
											//'amtexpected' => $data['amtdue'],
											//'arears' => $data['debt'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
													'jan' => $data['agentcomm']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------------------------------------------

	public function savefirstjanpayment1($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------------------------------------

	public function savefirstjanpayment2($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-------------february-------------------

	public function savefirstfebpayment($data)
	{
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
											'year' => $data['year']
											//'amtcollected' => $data['amount'],
											//'amtexpected' => $data['amtdue'],
											//'arears' => $data['debt'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------------------------------------------

	public function savefirstfebpayment1($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------------------------------------

	public function savefirstfebpayment2($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//------march--------------------------

	public function savefirstmarpayment($data)
	{
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
											'year' => $data['year']
											//'amtcollected' => $data['amount'],
											//'amtexpected' => $data['amtdue'],
											//'arears' => $data['debt'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------------------------------------------

	public function savefirstmarpayment1($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------------------------------------

	public function savefirstmarpayment2($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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

		return $this->db->insert('agentscommissionbymonth', ['agentid' => $data['agentid'],
															'agentname' => $data['agentname'],
															'agentcomm' => $data['agentcomm'],
															'lawmacomm' => $data['lawmacomm'],
													'totalmonthcollection' => $data['amount'],
															'mar' => $data['agentcomm'],
															'year' => $data['year']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------------april

	public function savefirstaprilpayment($data)
	{
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
											'year' => $data['year']
											//'amtcollected' => $data['amount'],
											//'amtexpected' => $data['amtdue'],
											//'arears' => $data['debt'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------------------------------------------

	public function savefirstaprilpayment1($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------------------------------------

	public function savefirstaprilpayment2($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------------may

	public function savefirstmaypayment($data)
	{
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
											'year' => $data['year']
											//'amtcollected' => $data['amount'],
											//'amtexpected' => $data['amtdue'],
											//'arears' => $data['debt'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------------------------------------------

	public function savefirstmaypayment1($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------------------------------------

	public function savefirstmaypayment2($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------june

	public function savefirstjunepayment($data)
	{
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
											'year' => $data['year']
											//'amtcollected' => $data['amount'],
											//'amtexpected' => $data['amtdue'],
											//'arears' => $data['debt'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------------------------------------------

	public function savefirstjunepayment1($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------------------------------------

	public function savefirstjunepayment2($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------------july

	public function savefirstjulypayment($data)
	{
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
											'year' => $data['year']
											//'amtcollected' => $data['amount'],
											//'amtexpected' => $data['amtdue'],
											//'arears' => $data['debt'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------------------------------------------

	public function savefirstjulypayment1($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------------------------------------

	public function savefirstjulypayment2($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-------------august

	public function savefirstaugpayment($data)
	{
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
											'year' => $data['year']
											//'amtcollected' => $data['amount'],
											//'amtexpected' => $data['amtdue'],
											//'arears' => $data['debt'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------------------------------------------

	public function savefirstaugpayment1($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------------------------------------

	public function savefirstaugpayment2($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-----------september

	public function savefirstseptpayment($data)
	{
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
											'year' => $data['year']
											//'amtcollected' => $data['amount'],
											//'amtexpected' => $data['amtdue'],
											//'arears' => $data['debt'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------------------------------------------

	public function savefirstseptpayment1($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------------------------------------

	public function savefirstseptpayment2($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------------october

	public function savefirstoctpayment($data)
	{
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
											'year' => $data['year']
											//'amtcollected' => $data['amount'],
											//'amtexpected' => $data['amtdue'],
											//'arears' => $data['debt'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------------------------------------------

	public function savefirstoctpayment1($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------------------------------------

	public function savefirstoctpayment2($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------november

	public function savefirstnovpayment($data)
	{
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
											'year' => $data['year']
											//'amtcollected' => $data['amount'],
											//'amtexpected' => $data['amtdue'],
											//'arears' => $data['debt'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------------------------------------------

	public function savefirstnovpayment1($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------------------------------------

	public function savefirstnovpayment2($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-----------december

	public function savefirstdecemberpayment($data)
	{
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
											'year' => $data['year']
											//'amtcollected' => $data['amount'],
											//'amtexpected' => $data['amtdue'],
											//'arears' => $data['debt'],
											/*'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//--------------------------------------------

	public function savefirstdecemberpayment1($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		//insert into payments table
		$this->db->insert('payments', ['customerid' => $data['id'],
									'customername' => $data['customer'],
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//----------------------------------------

	public function savefirstdecemberpayment2($data)
	{
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
											'year' => $data['year']
											/*'amtcollected' => $data['amount'],
											'amtexpected' => $data['amtdue'],
											'arears' => $data['debt'],
											'lastenteredby' => $data['enteredby'],
											'lastentrydate' => $data['entrydate']*/]);

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
									'paymentmode' => $data['paymode'],
									'amount' => $data['amount'],
									'agentid' => $data['agentid'],
									'agentname' => $data['agentname'],
									'paymentdate' => $data['paymentdate'],
									'paymentmonth' => $data['month'],
									'paymentyear' => $data['year'],
									'enteredby' => $data['enteredby'],
									'entrancedate' => $data['entrydate']]);

		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	//-------------------------------------------

	public function allinvoice($data)
	{
		$this->db->where('status =', 'Active');
		$this->db->where('customertype !=', 'Commercial');
		$this->db->order_by('name', 'ASC');
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
		$this->db->where('customertype !=', 'Commercial');
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
		$this->db->where('customertype !=', 'Commercial');
		$this->db->order_by('name', 'ASC');
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
		$this->db->where('customertype !=', 'Commercial');
		$this->db->order_by('name', 'ASC');
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
		$this->db->where('status =', 'Active');
		$this->db->order_by('name', 'ASC');
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
											'num' => $data['i']]);
	}

	//---------------------------------

	public function allcustomerinvoicelist()
	{
		$this->db->where('debt >', 0);
		$this->db->where('status =', 'Active');
		$this->db->where('customertype !=', 'Commercial');
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('customer');		
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
		$this->db->where('customertype !=', 'Commercial');
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('customer');	
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
		$this->db->where('customertype !=', 'Commercial');
		$this->db->where('status =', 'Active');
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('customer');		
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
		$this->db->where('customertype !=', 'Commercial');
		$this->db->where('status =', 'Active');
		$this->db->order_by('sectorname', 'ASC');
		$query = $this->db->get('customer');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//------------------------------------

	public function singlecustomerinvoice($data)
	{
		$this->db->where('debt >', 0);
		$this->db->where('customerid =', $data['id']);
		//$this->db->where('status =', 'Active');
		$query = $this->db->get('customer');		
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
		$this->db->where('debt >', 0);
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

	public function gethousetypenos($config)
	{
		$this->db->where('sectorid =', $config['sector']);
		$this->db->where('streetid =', $config['street']);
		$this->db->where('houseno =', $config['house']);
		$this->db->where('housecat =', $config['housecat']);
		$query = $this->db->get('customer');
		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//------------------------------------------

	public function updatecustomercode($data)
	{
		$this->db->where('temp =', $data['var']);
		return $this->db->update('customer', ['customercode' => $data['customercode'],
												'temp' => '']);
	}

	//------------------------------------------------

}