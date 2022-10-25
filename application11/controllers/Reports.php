<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

	//---------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('role') != 'Admin')
			redirect('home/index');
		$this->load->model('reports_model');
	}

	//----login page------------------

	public function paymentsrecord()	
	{
		//get sectors
		$allsectors = $this->reports_model->getSectors();
		$sectors = $allsectors['rows'];

		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('reports/paymentrecord_view', ['sectors' => $sectors]);
		$this->load->view('inc2/footer_view4');
	}

	//-------------------------------

	public function fetchstreet()
	{
		if ($this->input->post('sectorid')) {
			echo $this->reports_model->fetchstreet($this->input->post('sectorid'));
		}
	}

	//-----------------------------------

	public function fetchhouses()
	{
		if ($this->input->post('streetid')) {
			echo $this->reports_model->getallhouses($this->input->post('streetid'));
		}
	}

	//-----------------------------------

	public function monthlybreakdown()
	{
		$data = $this->input->post();
		$data['year'] = date('Y');

		if (($data['all'] == '') && ($data['sector'] == '') && ($data['street'] == '') && ($data['houseno'] == '')) {
			$this->session->set_flashdata('msg', 'Select at least one field');
			return redirect('reports/paymentsrecord');
		}
		else {
			
			//get all payment records
			$allpayments = $this->reports_model->allpayments($data);

			if (!$allpayments) {
				$this->session->set_flashdata('msg', 'No record found');
				return redirect('reports/paymentsrecord');
			}
			else {
				$payments = $allpayments['rows'];
				$search = '';
				$results = '';
				//all customer record
				if ($data['all'] == 'All') {
					$search = $this->reports_model->allcustomers();
					$results = $search['rows'];
				}

				//customer record in sector
				elseif (($data['all'] == 'Selected') && ($data['sector'] != '') && ($data['street'] == ''))
				{
					$search = $this->reports_model->customersbysector($data);
					if (!$search) {
						$this->session->set_flashdata('msg', 'No record found');
						return redirect('reports/paymentsrecord');
					}
					else {
						$results = $search['rows'];
					}
				}

				//customer record in street
				elseif (($data['all'] == 'Selected') && ($data['sector'] != '') && ($data['street'] != '') && ($data['houseno'] == ''))
				{
					$search = $this->reports_model->customersbystreet($data);
					if (!$search) {
						$this->session->set_flashdata('msg', 'No record found');
						return redirect('reports/paymentsrecord');
					}
					else {
						$results = $search['rows'];
					}
				}

				//customer record in house
				else
				{
					$search = $this->reports_model->customersbyhouse($data);
					if (!$search) {
						$this->session->set_flashdata('msg', 'No record found');
						return redirect('reports/paymentsrecord');
					}
					else {
						$results = $search['rows'];
					}
				}

				$this->load->view('inc/header_view');
				//$this->load->view('inc/sidebar_view');
				$this->load->view('reports/monthlypayments_view', ['payments' => $payments, 'results' => $results]);
				$this->load->view('inc2/footer_view4');
			}
		}
	}

	//--------------------------------------

	public function paymentsbydate()
	{
		$data = $this->input->post();

		if ($data['startdate'] > $data['enddate']) {
			$this->session->set_flashdata('msg', 'Invalid date range');
			return redirect('reports/paymentsrecord');
		}

		//get payment from db
		$allpayments = $this->reports_model->paymentsbydate($data);
		
		if (!$allpayments) {
			$this->session->set_flashdata('msg', 'No record found');
			return redirect('reports/paymentsrecord');
		}
		else {
			$payments = $allpayments['rows'];

			$customers = $this->reports_model->allcustomers();
			$results = $customers['rows'];

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('reports/paymentsbydate_view', ['payments' => $payments, 'results' => $results]);
			$this->load->view('inc2/footer_view4');
		}
	}

	//----------------------------------------

	public function debtorspage()
	{
		//get sectors
		$allsectors = $this->reports_model->getSectors();
		$sectors = $allsectors['rows'];

		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('reports/debtorspage_view', ['sectors' => $sectors]);
		$this->load->view('inc2/footer_view4');
	}

	//----------------------------------------

	public function fetchdebtors()
	{
		$data = $this->input->post();

		if (($data['all'] == '') && ($data['sector'] == '') && ($data['street'] == '') && ($data['houseno'] == '')) {
			$this->session->set_flashdata('msg', 'Select at least one field');
			return redirect('reports/debtorspage');
		}
		else {
			$search = '';
			$results = '';

			//all debtors
			if ($data['all'] == 'All') {
				$search = $this->reports_model->alldebtors();
				if (!$search) {
					$this->session->set_flashdata('msg', 'No record found');
					return redirect('reports/debtorspage');
				}
				else {
					$results = $search['rows'];
				}
			}

			//debtors in sector
			elseif (($data['all'] == 'Selected') && ($data['sector'] != '') && ($data['street'] == ''))
			{
				$search = $this->reports_model->debtorsinsector($data);
				if (!$search) {
					$this->session->set_flashdata('msg', 'No record found');
					return redirect('reports/debtorspage');
				}
				else {
					$results = $search['rows'];
				}
			}

			//debtors in street
			elseif (($data['all'] == 'Selected') && ($data['sector'] != '') && ($data['street'] != '') && ($data['houseno'] == ''))
			{
				$search = $this->reports_model->debtorsinstreet($data);
				if (!$search) {
					$this->session->set_flashdata('msg', 'No record found');
					return redirect('reports/debtorspage');
				}
				else {
					$results = $search['rows'];
				}
			}

			//debtors in house
			else
			{
				$search = $this->reports_model->debtorsinhouse($data);
				if (!$search) {
					$this->session->set_flashdata('msg', 'No record found');
					return redirect('reports/debtorspage');
				}
				else {
					$results = $search['rows'];
				}
			}
			
			//get all payments
			/*$allpayments = $this->reports_model->getpayments();

			if ($allpayments) {
				$payments = $allpayments['rows'];
			}*/

			//load view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('reports/debtorslist_view', ['results' => $results]);
			$this->load->view('inc2/footer_view4');
		}
	}

	//------------------------------------------

	public function commissions()
	{
		//get all agents
		$allagents = $this->reports_model->getagents();
		$agents = $allagents['rows'];

		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('reports/commissionpage_view', ['agents' => $agents]);
		$this->load->view('inc2/footer_view4');
	}

	//-------------------------------------------

	public function fetchcommissions()
	{
		$data = $this->input->post();
		$data['year'] = date('Y');

		if ($data['agent'] == '') {
			$this->session->set_flashdata('msg', 'Select at least one field');
			return redirect('reports/commissions');
		}
		else {
			//get all payment records
			$allcommissions = $this->reports_model->allcommissions($data);

			if (!$allcommissions) {
				$this->session->set_flashdata('msg', 'No record found');
				return redirect('reports/commissions');
			}
			else {
				$commissions = $allcommissions['rows'];
				$search = '';
				$results = '';

				//all agent record
				if ($data['agent'] == 'All') {
					$search = $this->reports_model->allagents();
					$results = $search['rows'];
				}

				//agent record in sector
				else
				{
					$search = $this->reports_model->agentsbyid($data);
					if (!$search) {
						$this->session->set_flashdata('msg', 'No record found');
						return redirect('reports/commissions');
					}
					else {
						$results = $search['rows'];
					}
				}
				
				$this->load->view('inc/header_view');
				//$this->load->view('inc/sidebar_view');
				$this->load->view('reports/monthlycommissions_view', ['commissions' => $commissions, 'results' => $results]);
				$this->load->view('inc2/footer_view4');
			}
		}
	}

	//-----------------------------------------

	public function commissionsbydate()
	{
		$data = $this->input->post();

		if ($data['startdate'] > $data['enddate']) {
			$this->session->set_flashdata('msg', 'Invalid date range');
			return redirect('reports/commissions');
		}

		//get payment from db
		$allcommissions = $this->reports_model->commissionsbydate($data);
		
		if (!$allcommissions) {
			$this->session->set_flashdata('msg', 'No record found');
			return redirect('reports/commissions');
		}
		else {
			$commissions = $allcommissions['rows'];

			$agents = $this->reports_model->allagents();
			$results = $agents['rows'];

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('reports/commissionsbydate_view', ['commissions' => $commissions, 'results' => $results]);
			$this->load->view('inc2/footer_view4');
		}
	}

	//------------------------------------------------

	public function customerrecords()
	{
		//get sectors
		$allsectors = $this->reports_model->getSectors();
		$sectors = $allsectors['rows'];

		//get all agents
		$allagents = $this->reports_model->getagents();
		$agents = $allagents['rows'];
		
		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('reports/customerrecord_view', ['sectors' => $sectors, 'agents' => $agents]);
		$this->load->view('inc2/footer_view4');
	}

	//-------------------------------------------------

	public function customerbylocation()
	{
		$data = $this->input->post();

		if (($data['all'] == '') && ($data['sector'] == '') && ($data['street'] == '') && ($data['houseno'] == '')) {
			$this->session->set_flashdata('msg', 'Select at least one field');
			return redirect('reports/customerrecords');
		}
		else {
			$search = '';
			$results = '';
			//all customer record
			if ($data['all'] == 'All') {
				$search = $this->reports_model->allcustomers();
				if (!$search) {
					$this->session->set_flashdata('msg', 'No record found');
					return redirect('reports/customerrecords');
				}
				else {
					$results = $search['rows'];
				}
			}
			//customer record in sector
			elseif (($data['all'] == 'Selected') && ($data['sector'] != '') && ($data['street'] == ''))
			{
				$search = $this->reports_model->customersbysector($data);
				if (!$search) {
					$this->session->set_flashdata('msg', 'No record found');
					return redirect('reports/customerrecords');
				}
				else {
					$results = $search['rows'];
				}
			}

			//customer record in street
			elseif (($data['all'] == 'Selected') && ($data['sector'] != '') && ($data['street'] != '') && ($data['houseno'] == ''))
			{
				$search = $this->reports_model->customersbystreet($data);
				if (!$search) {
					$this->session->set_flashdata('msg', 'No record found');
					return redirect('reports/customerrecords');
				}
				else {
					$results = $search['rows'];
				}
			}

			//customer record in house
			else
			{
				$search = $this->reports_model->customersbyhouse($data);
				if (!$search) {
					$this->session->set_flashdata('msg', 'No record found');
					return redirect('reports/customerrecords');
				}
				else {
					$results = $search['rows'];
				}
			}

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('reports/customerinfo_view', ['results' => $results]);
			$this->load->view('inc2/footer_view4');
		}
	}

	//---------------------------------------------

	public function customerbyagent()
	{
		$data = $this->input->post();

		if ($data['agent'] == '') {
			$this->session->set_flashdata('msg', 'Select an agent');
			return redirect('reports/customerrecords');
		}
		else {
			$search = $this->reports_model->getagentcustomers($data);
			if (!$search) {
				$this->session->set_flashdata('msg', 'No record found');
				return redirect('reports/customerrecords');
			}
			else {
				$results = $search['rows'];

				$this->load->view('inc/header_view');
				$this->load->view('inc/sidebar_view');
				$this->load->view('reports/customerbyagent_view', ['results' => $results]);
				$this->load->view('inc2/footer_view4');
			}
		}
	}

	//--------------------------------------------

	public function cashbook()
	{
		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('reports/cashbook_view');
		$this->load->view('inc2/footer_view4');
	}

	//----------------------------------------------

	public function creditreport()
	{
		$data = $this->input->post();

		if ($data['startdate'] > $data['enddate']) {
			$this->session->set_flashdata('msg', 'Invalid date range');
			return redirect('reports/cashbook');
		}

		//get payment from db
		$allCredit = $this->reports_model->creditReport($data);

		if (!$allCredit) {
			$this->session->set_flashdata('msg', 'No record found');
			return redirect('reports/cashbook');
		}
		else {
			$credit = $allCredit['rows'];
			$count = $allCredit['num'];

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('reports/creditreport_view', ['credit' => $credit, 'count' => $count]);
			$this->load->view('inc2/footer_view4');
		}
	}

	//------------------------------------------------

	public function debitreport()
	{
		$data = $this->input->post();

		if ($data['startdate'] > $data['enddate']) {
			$this->session->set_flashdata('msg', 'Invalid date range');
			return redirect('reports/cashbook');
		}

		//get payment from db
		$allDebit = $this->reports_model->debitReport($data);

		if (!$allDebit) {
			$this->session->set_flashdata('msg', 'No record found');
			return redirect('reports/cashbook');
		}
		else {
			$debit = $allDebit['rows'];

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('reports/debitreport_view', ['debit' => $debit]);
			$this->load->view('inc2/footer_view4');
		}
	}

	//-------------------------------------------

	public function commercialdebts()
	{
		//get commercial debtors
		$allcustomers = $this->reports_model->getCommercialDebtors();

		if (!$allcustomers) {
			$this->session->set_flashdata('msg', 'No record found');
			return redirect('home/index');
		}
		$customers = $allcustomers['rows'];


		//get all sectors
		$allsectors = $this->reports_model->getSectors();
		if (!$allsectors) {
			$this->session->set_flashdata('msg', 'No record found');
			return redirect('home/index');
		}
		$sectors = $allsectors['rows'];

		//add debt for each sector
		$sectordebt = array();
		foreach ($sectors as $sector) {
			$j = 0;
			foreach ($customers as $customer) {
				if ($sector->sectorid == $customer->sectorid) {
					if ($customer->debt > 0) {
						$j += $customer->debt;
					}
				}
			}

			if ($j > 0) {
				$sectordebt[$sector->sectorname] = $j;
			}
		}

		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('reports/commercialdebtpersector_view', ['sectordebt' => $sectordebt]);
		$this->load->view('inc2/footer_view4');
	}

	//-----------------------------------------

	public function commercialdebtpersector()
	{
		$sector = $this->input->get('sector');

		//get customers in sector
		$allcustomers = $this->reports_model->getCommercialDebtorsInSector($sector);

		if (!$allcustomers) {
			$this->session->set_flashdata('msg', 'No record found.');
			return redirect('home/index');
		}

		$customers = $allcustomers['rows'];

		//get all street in sector
		$allstreets = $this->reports_model->getStreetsInSector($sector);
		if (!$allstreets) {
			$this->session->set_flashdata('msg', 'No record found.');
			return redirect('home/index');
		}

		$streets = $allstreets['rows'];

		//add debt for each sector
		$streetdebt = array();
		foreach ($streets as $street) {
			$j = 0;
			foreach ($customers as $customer) {
				if ($street->streetname == $customer->streetname) {
					if ($customer->debt > 0) {
						$j += $customer->debt;
					}
				}
			}

			if ($j > 0) {
				$streetdebt[$street->streetname] = $j;
			}
		}
		//======================================

		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('reports/commercialdebtorsbystreet_view', ['streetdebt' => $streetdebt, 'sector' => $sector]);
		$this->load->view('inc2/footer_view4');
	}

	//----------------------------------------

	public function commercialdebtperhouse()
	{
		$sector = $this->input->get('sector');
		$street = $this->input->get('street');

		//get customers in street
		$allcustomers = $this->reports_model->getCommercialDebtorsInStreet($sector, $street);

		if (!$allcustomers) {
			$this->session->set_flashdata('msg', 'No record found.');
			return redirect('home/index');
		}

		$customers = $allcustomers['rows'];

		//get all houses in street
		$allhouses = $this->reports_model->getHousesInStreet($sector, $street);
		if (!$allhouses) {
			$this->session->set_flashdata('msg', 'No record found.');
			return redirect('home/index');
		}

		$houses = $allhouses['rows'];

		//==================================

		//add debt for each sector
		$housedebt = array();
		foreach ($houses as $house) {
			$j = 0;
			foreach ($customers as $customer) {
				if ($house->houseno == $customer->houseno) {
					if ($customer->debt > 0) {
						$j += $customer->debt;
					}
				}
			}

			if ($j > 0) {
				$housedebt[$house->houseno] = $j;
			}
		}

		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('reports/commercialhousedebt_view', ['housedebt' => $housedebt, 'street' => $street, 'sector' => $sector]);
		$this->load->view('inc2/footer_view4');
	}

	//-------------------------------------

	public function commercialdebtorsinhouse()
	{
		$house = $this->input->get('house');
		$street = $this->input->get('street');
		$sector = $this->input->get('sector');

		//get customers in house
		$allcustomers = $this->reports_model->getCommercialDebtorsInHouse($house, $street, $sector);

		if (!$allcustomers) {
			$this->session->set_flashdata('msg', 'No record found.');
			return redirect('home/index');
		}

		$customers = $allcustomers['rows'];

		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('reports/commercialdebtinhouse_view', ['customers' => $customers]);
		$this->load->view('inc2/footer_view4');
	}

	//=======================================

	public function residentialdebts()
	{
		//get commercial debtors
		$allcustomers = $this->reports_model->getResidentialDebtors();

		if (!$allcustomers) {
			$this->session->set_flashdata('msg', 'No record found');
			return redirect('home/index');
		}
		$customers = $allcustomers['rows'];

		//get all sectors
		$allsectors = $this->reports_model->getSectors();
		if (!$allsectors) {
			$this->session->set_flashdata('msg', 'No record found');
			return redirect('home/index');
		}
		$sectors = $allsectors['rows'];

		//add debt for each sector
		$sectordebt = array();
		foreach ($sectors as $sector) {
			$j = 0;
			foreach ($customers as $customer) {
				if ($sector->sectorid == $customer->sectorid) {
					if ($customer->debt > 0) {
						$j += $customer->debt;
					}
				}
			}

			if ($j > 0) {
				$sectordebt[$sector->sectorname] = $j;
			}
		}

		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('reports/residentialdebtpersector_view', ['sectordebt' => $sectordebt]);
		$this->load->view('inc2/footer_view8');
	}

	//-----------------------------------------

	public function residentialdebtpersector()
	{
		$sector = $this->input->get('sector');

		//get customers in sector
		$allcustomers = $this->reports_model->getResidentialDebtorsInSector($sector);

		if (!$allcustomers) {
			$this->session->set_flashdata('msg', 'No record found.');
			return redirect('home/index');
		}

		$customers = $allcustomers['rows'];

		//get all street in sector
		$allstreets = $this->reports_model->getStreetsInSector($sector);
		if (!$allstreets) {
			$this->session->set_flashdata('msg', 'No record found.');
			return redirect('home/index');
		}

		$streets = $allstreets['rows'];

		//add debt for each sector
		$streetdebt = array();
		foreach ($streets as $street) {
			$j = 0;
			foreach ($customers as $customer) {
				if ($street->streetname == $customer->streetname) {
					if ($customer->debt > 0) {
						$j += $customer->debt;
					}
				}
			}

			if ($j > 0) {
				$streetdebt[$street->streetname] = $j;
			}
		}
		//======================================

		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('reports/residentialdebtorsbystreet_view', ['streetdebt' => $streetdebt, 'sector' => $sector]);
		$this->load->view('inc2/footer_view8');
	}

	//=======================================

	public function residentialdebtperhouse()
	{
		$sector = $this->input->get('sector');
		$street = $this->input->get('street');

		//get customers in street
		$allcustomers = $this->reports_model->getResidentialDebtorsInStreet($sector, $street);

		if (!$allcustomers) {
			$this->session->set_flashdata('msg', 'No record found.');
			return redirect('home/index');
		}

		$customers = $allcustomers['rows'];

		//get all houses in street
		$allhouses = $this->reports_model->getHousesInStreet($sector, $street);
		if (!$allhouses) {
			$this->session->set_flashdata('msg', 'No record found.');
			return redirect('home/index');
		}

		$houses = $allhouses['rows'];

		//==================================

		//add debt for each sector
		$housedebt = array();
		foreach ($houses as $house) {
			$j = 0;
			foreach ($customers as $customer) {
				if ($house->houseno == $customer->houseno) {
					if ($customer->debt > 0) {
						$j += $customer->debt;
					}
				}
			}

			if ($j > 0) {
				$housedebt[$house->houseno] = $j;
			}
		}

		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('reports/residentialhousedebt_view', ['housedebt' => $housedebt, 'street' => $street, 'sector' => $sector]);
		$this->load->view('inc2/footer_view8');
	}

	//-------------------------------------

	public function residentialdebtorsinhouse()
	{
		$house = $this->input->get('house');
		$street = $this->input->get('street');
		$sector = $this->input->get('sector');

		//get customers in house
		$allcustomers = $this->reports_model->getResidentialDebtorsInHouse($house, $street, $sector);

		if (!$allcustomers) {
			$this->session->set_flashdata('msg', 'No record found.');
			return redirect('home/index');
		}

		$customers = $allcustomers['rows'];

		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('reports/residentialdebtinhouse_view', ['customers' => $customers]);
		$this->load->view('inc2/footer_view8');
	}

	//------------------------------------

	public function allresidentialdebtors()
	{
		//get commercial debtors
		$allcustomers = $this->reports_model->getResidentialDebtors();

		if (!$allcustomers) {
			$this->session->set_flashdata('msg', 'No record found');
			return redirect('home/index');
		}
		$customers = $allcustomers['rows'];

		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('reports/allresidentialdebtors_view', ['customers' => $customers]);
		$this->load->view('inc2/footer_view8');
	}

	//---------------------------------------

	public function allcommercialdebts()
	{
		//get commercial debtors
		$allcustomers = $this->reports_model->getCommercialDebtors();

		if (!$allcustomers) {
			$this->session->set_flashdata('msg', 'No record found');
			return redirect('home/index');
		}
		$customers = $allcustomers['rows'];

		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('reports/allcommercialdebtors_view', ['customers' => $customers]);
		$this->load->view('inc2/footer_view8');
	}

	//----------------------------------------

	public function commercialbytype()
	{
		//get all commercial customers
		$allcustomers = $this->reports_model->getcommercialcustomers();

		if (!$allcustomers) {
			$this->session->set_flashdata('msg', 'No record found');
			return redirect('home/index');
		}
		$customers = $allcustomers['rows'];

		//get all commercial types
		$alltypes = $this->reports_model->getcommercialtypes();
		$types = $alltypes['rows'];

		//add debt for each sector
		$commercialtypes = array();
		foreach ($types as $row) {
			$j = 0;
			foreach ($customers as $customer) {
				if ($row->typeId == $customer->commercialtype) {
					$j++;
				}
			}

			$commercialtypes[$row->typeName] = $j;
		}

		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('reports/allcommercialbytypes_view', ['commercialtypes' => $commercialtypes]);
		$this->load->view('inc2/footer_view8');
	}

	//----------------------------------------
}