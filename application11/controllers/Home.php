<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	//---------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('username'))
			redirect('admin/index');
		$this->load->model('config_model');
	}

	//--------------------------------------

	public function index() {

		//get all sectors
		$sectors = $this->config_model->getSectors();
		$sectors = $sectors['num'];

		//get all streets
		$allstreets = $this->config_model->getallstreet();
		$streets = $allstreets['num'];

		//get all houses
		$allhouses = $this->config_model->getallhouses();
		$houses = $allhouses['num'];

		//get all customers
		$allcustomers = $this->config_model->getcustomers();
		$customers = $allcustomers['num'];
		$customerrecords = $allcustomers['rows'];

		//get commercial customers
		$commercialcustomers = $this->config_model->getcommercialcustomers();
		$commercial = $commercialcustomers['num'];

		//get total collection for month
		$month = date('m');
		$year = date('Y');

		$payments = $this->config_model->getmonthpayment($month, $year);

		if (!$payments) {
			$mntcollection = 0;
			$netcomm = 0;
			$lawmacomm = 0;
			$agentcomm = 0;
		}
		else {
			$rows = $payments['rows'];
			$mntcollection = 0;
			$netcomm = 0;
			$lawmacomm = 0;
			$agentcomm = 0;

			foreach ($rows as $row) {
				$mntcollection = $mntcollection + $row->totalcollection;
				$netcomm = $netcomm + $row->netcomm;
				/*$lawmacomm = $lawmacomm + $row->lawmacomm;
				$agentcomm = $agentcomm + $row->agentcomm;*/
			}
		}

		$data = array(
			        'sectors' => $sectors,
			        'streets' => $streets,
			        'houses' => $houses,
			        'customers' => $customers,
			        'mntcollection' => $mntcollection,
			        'netcomm' => $netcomm,
			        'commercial' => $commercial
					);

		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('home/dashboard_view', ['data' => $data, 'customerrecords' => $customerrecords]);
		$this->load->view('inc/footer_view');
	}

	//---------------------------------------

	/*public function hashPassword() {
		echo hash('sha256', $password . KEY);
	}*/

	//-------change password view -----------------

	public function changepassword()
	{
		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('home/changepassword_view');
		$this->load->view('inc/footer_view');
	}

	//------ update new password -----------

	public function updatepassword()
	{
		//validate user input
		$this->form_validation->set_rules('pwd', 'New Password', 'required');
		$this->form_validation->set_rules('confirm', 'Confirm Password', 'matches[newPass]|required');

		if($this->form_validation->run()) {
			
			$info = $this->input->post();

			if($info['pwd'] == $info['confirm']) {
				$info['pwd'] = hash('sha256', $info['pwd'] . KEY);
				$info['useremail'] = $this->session->userdata('userEmail');

				$newPassword = $this->config_model->changeUserPassword($info);

				if($newPassword) {
				$this->session->set_flashdata('success', 'Password Changed 									Successfully');
				}
				else {
					$this->session->set_flashdata('msg', 'Failed To 
													Change Password');
				}
			}
			else {
				//password mismatch
				$this->session->set_flashdata('msg', 'Password Mismatch');
			}
			return redirect('home/changepassword');
		}// validation if

		else {
			$this->session->set_flashdata('msg', 'Both fields are required');
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('home/changepassword_view');
			$this->load->view('inc/footer_view');
		}
	}

	//------------------------------------------------

}