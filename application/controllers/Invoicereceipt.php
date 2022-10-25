<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoicereceipt extends CI_Controller {

	//--------------------------------------

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('username'))
			redirect('admin/index');
		$this->load->model('invoice_model');
	}

	//------ ---------------- ---------

	public function customerrecord()	
	{
		//get sectors
		$allsectors = $this->invoice_model->getSectors();
		$sectors = $allsectors['rows'];

		//get all agents
		$allagents = $this->invoice_model->getagents();
		$agents = $allagents['rows'];
		
		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('customerrecord/customerrecord_view', ['sectors' => $sectors, 'agents' => $agents]);
		$this->load->view('inc2/footer_view1');
	}

	//---------------------------------

	public function fetchactivestreet()
	{
		if ($this->input->post('sectorid')) {
			echo $this->invoice_model->fetchactivestreet($this->input->post('sectorid'));
		}
	}

	//-----------------------------------

	public function fetchactivehouses()
	{
		if ($this->input->post('streetid')) {
			echo $this->invoice_model->getallactivehouses($this->input->post('streetid'));
		}
	}

	//------------------------------------

	public function customerbylocation()
	{
		$data = $this->input->post();

		if (($data['sector'] == '') && ($data['street'] == '') && ($data['houseno'] == '')) {
			$this->session->set_flashdata('msg', 'Select at least one field');
			return redirect('invoicereceipt/customerrecord');
		}
		else {
			$search = '';

			//customer search by sector
			if (($data['sector'] != '') && ($data['street'] == '')) {
				$search = $this->invoice_model->customerbysector($data);
			}

			//customer search by sector and street
			elseif (($data['sector'] != '') && ($data['street'] != '') && ($data['houseno'] == '')) {
				$search = $this->invoice_model->customerbysectornstreet($data);
			}

			//customer search by sector, street and house
			else {
				$search = $this->invoice_model->customerbysectorstreetnhouse($data);
			}

			if (!$search) {
				$this->session->set_flashdata('msg', 'No record found');
				return redirect('invoicereceipt/customerrecord');
			}
			else {
				$customers = $search['rows'];
				//$num = $search['num'];

				//load view
				$this->load->view('inc/header_view');
				$this->load->view('inc/sidebar_view');
				$this->load->view('customerrecord/customerinfo_view', ['rows' => $customers]);
				$this->load->view('inc/footer_view');
			}
		}
	}

	//-------------------------------------

	public function customerbyagent()
	{
		$data = $this->input->post();

		if ($data['agent'] == '') {
			$this->session->set_flashdata('msg', 'Select an agent');
			return redirect('invoicereceipt/customerrecord');
		}
		else {
			$search = $this->invoice_model->customerbyagent($data);

			if (!$search) {
				$this->session->set_flashdata('msg', 'No record found');
				return redirect('invoicereceipt/customerrecord');
			}
			else {
				$customers = $search['rows'];
				//$num = $search['num'];

				//load view
				$this->load->view('inc/header_view');
				$this->load->view('inc/sidebar_view');
				$this->load->view('customerrecord/customerinfo_view', ['rows' => $customers]);
				$this->load->view('inc/footer_view');
			}
		}
	}

	//---------------------------------------------

}