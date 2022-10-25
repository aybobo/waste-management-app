<?php

class Assets_model extends CI_Model {

	public function getassetcategories()
	{
		//$this->db->order_by('status', 'ASC');
		$this->db->where('categoryname !=', 'Agent');
		$this->db->or_where('categoryname !=', 'Lagos');
		$query = $this->db->get('assetcategory');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//-----------------------------

	public function checkassetcategories($data)
	{
		$this->db->where('categoryname =', $data['catname']);
		$query = $this->db->get('assetcategory');
		return $query->row();
	}

	//---------------------------------

	public function addassetcategory($data)
	{
		return $this->db->insert('assetcategory', ['categoryname' => $data['catname'],
													'status' => 'Active',
													'createdby' => $data['createdby'],
													'datecreated' => $data['createdate']]);
	}

	//----------------------------------

	public function getsingleassetcategory($catid)
	{
		$this->db->where('catid =', $catid);
		$query = $this->db->get('assetcategory');
		return $query->row();
	}

	//---------------------------------------

	public function updateassetcategory($data)
	{
		$this->db->where('catid =', $data['id']);
		$this->db->update('assetcategory', ['categoryname' => $data['catname'],
									'status' => $data['status'],
									'modifiedby' => $data['modifiedby'],
									'datemodified' => $data['modifydate']]);

		$this->db->where('catid =', $data['id']);
		return $this->db->update('asset', ['catname' => $data['catname']]);
	}

	//-----------------------------------

	public function getactiveassetcategories()
	{
		//$this->db->where('categoryname !=', 'Agent');
		//$this->db->where('categoryname !=', 'Lagos');
		$this->db->where('status =', 'Active');
		$this->db->order_by('categoryname', 'ASC');
		$query = $this->db->get('assetcategory');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//------------------------------------------

	public function getotheractiveassetcategories($id)
	{
		//$this->db->where('categoryname !=', 'Agent');
		//$this->db->where('categoryname !=', 'Lagos');
		$this->db->where('catid !=', $id);
		$this->db->where('status =', 'Active');
		$this->db->order_by('categoryname', 'ASC');
		$query = $this->db->get('assetcategory');

		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//------------------------------------------

	public function getassets()
	{
		$this->db->where('catname !=', 'Agent');
		$this->db->where('catname !=', 'Lagos');
		$query = $this->db->get('asset');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//-------------------------------------------

	public function checkasset($data)
	{
		$this->db->where('catid =', $data['catname']);
		$this->db->where('assetname =', $data['asset']);
		$this->db->where('description =', $data['desc']);
		$query = $this->db->get('asset');
		return $query->row();
	}

	//------------------------------------------

	public function addasset($data)
	{
		return $this->db->insert('asset', ['catid' => $data['catname'],
											'catname' => $data['categoryname'],
											'assetname' => $data['asset'],
											'quantity' => $data['qty'],
											'description' => $data['desc'],
											'value' => $data['assetval'],
											'purchasedate' => $data['purchasedate'],
											'status' => 'Active',
											'createdby' => $data['createdby'],
											'datecreated' => $data['createdate']]);
	}

	//-----------------------------------------

	public function getsingleasset($assetid)
	{
		$this->db->where('assetid =', $assetid);
		$query = $this->db->get('asset');
		return $query->row();
	}

	//--------------------------------------------

	public function updateasset($data)
	{
		$this->db->where('assetid =', $data['id']);
		return $this->db->update('asset', ['catid' => $data['catname'],
											'catname' => $data['categoryname'],
											'assetname' => $data['asset'],
											'quantity' => $data['qty'],
											'description' => $data['desc'],
											'value' => $data['assetval'],
											'purchasedate' => $data['purchasedate'],
											'status' => $data['status'],
											'modifiedby' => $data['modifiedby'],
											'datemodified' => $data['modifydate']]);
	}

	//-------------------------------------------

	public function getactiveassets()
	{
		$this->db->where('status =', 'Active');
		$query = $this->db->get('asset');
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//-------------------------------------

	public function getfewexpenses()
	{
		$this->db->order_by('expensedate', 'DESC');
		$this->db->limit(20); 
		$query = $this->db->get('expense');
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//-------------------------------------

	public function getallexpenses()
	{
		$this->db->order_by('expensedate', 'DESC');
		$query = $this->db->get('expense');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//-------------------------------------

	public function addexpense($data)
	{
		$this->db->insert('expense', ['purpose' => $data['desc'],
											'assetname' => $data['asset'],
											'assetid' => $data['id'],
											'expensedate' => $data['expensedate'],
											'amount' => $data['amt'],
											'addedby' => $data['createdby'],
											'dateadded' => $data['createdate']]);

		return $this->db->insert('cashbook', ['date' => $data['expensedate'],
												'narration' => $data['desc'],
												'credit' => $data['amt'],
												'debit' => 0]);
	}

	//-------------------------------------

	public function assetexpense($id)
	{
		$this->db->where('assetid =', $id);
		$this->db->order_by('expensedate', 'DESC');
		$query = $this->db->get('expense');
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//-----------------------------------

	public function checkliability($data)
	{
		$this->db->where('name =', $data['name']);
		$query = $this->db->get('liability');
		return $query->row();
	}

	//--------------------------------------

	public function saveliability($data)
	{
		$this->db->insert('liability', ['name' => $data['name'],
											'amount' => $data['amt'],
											'date' => $data['date'],
											'enteredby' => $data['enteredby'],
											'entrydate' => $data['entrydate'],
											'status' => $data['status']]);

		$insert_id = $this->db->insert_id();

		return $this->db->insert('liabilitytrail', ['liabilityid' => $insert_id,
													'liabilityname' => $data['name'],
													'amount' => $data['amt'],
													'action' => $data['action'],
													'purpose' => $data['desc'],
													'date' => $data['date'],
													'enteredby' => $data['enteredby'],
													'entrydate' => $data['entrydate']]);
	}

	//--------------------------------------

	public function getallliabilities()
	{
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get('liability');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//---------------------------------------

	public function getliability($liabilityid)
	{
		$this->db->where('liabilityid =', $liabilityid);
		$query = $this->db->get('liability');
		return $query->row();
	}

	//-------------------------------------

	public function saveliabilityupdate($data)
	{
		$this->db->where('liabilityid =', $data['id']);
		$this->db->update('liability', ['amount' => $data['amt'],
										'status' => $data['status']]);

		//$this->db->where('liabilityid =', $data['id']);
		return $this->db->insert('liabilitytrail', ['amount' => $data['amountPaid'],
													'liabilityid' => $data['id'],
													'liabilityname' => $data['name'],
													'purpose' => $data['desc'],
													'action' => $data['action'],
													'date' => $data['date'],
													'enteredby' => $data['modifiedby'],
													'entrydate' => $data['modifydate']]);
	}

	//-------------------------------------

	public function getliabilitytrail($liabilityid)
	{
		$this->db->where('liabilityid =', $liabilityid);
		$this->db->order_by('trailid', 'ASC');
		$query = $this->db->get('liabilitytrail');		
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}
	}

	//--------------------------------------

	public function deleteliability($id)
	{
		$this->db->where('liabilityid =', $id);
		$this->db->delete('liability');

		$this->db->where('liabilityid =', $id);
		return $this->db->delete('liabilitytrail');	
	}

	//---------------------------------------

	public function saveToCashbook($data)
	{
		return $this->db->insert('cashbook', ['date' => $data['date'],
												'narration' => $data['narration'],
												'debit' => $data['amt'],
												'credit' => 0]);
	}

	//-----------------------------------------

	public function debitCashbook($data)
	{
		return $this->db->insert('cashbook', ['date' => $data['date'],
												'narration' => $data['narration'],
												'credit' => $data['amountPaid'],
												'debit' => 0]);
	}

	//-----------------------------------------
}