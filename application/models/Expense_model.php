<?php

class Expense_model extends CI_Model {

	public function getactiveassets()
	{
		$this->db->where('status =', 'Active');
		$query = $this->db->get('asset');
		if($query->num_rows() > 0) {
			$record = $query->result();
			return array('rows' => $record, 'num' => count($record));
		}	
	}

	//------------------------------
}