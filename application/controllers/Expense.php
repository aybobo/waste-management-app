<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense extends CI_Controller {

	//-------------------------------------
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('username'))
			redirect('admin/index');
		$this->load->model('expense_model');
	}

	//------------------------------------

	public function expensehome()
	{
		//get active assets
		$assets = $this->expense_model->getactiveassets();
		$rows = $assets['rows'];

		//load view


	}

	//-----------------------------------
}