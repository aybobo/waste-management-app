<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customersetup extends CI_Controller {

	//--------------------------------------

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('username'))
			redirect('admin/index');
		$this->load->model('customersetup_model');
	}

	//------ sector home page ---------

	public function sectorhome()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('home/index');
		}
		else {
			//get active agents
			$activeagents = $this->customersetup_model->getactiveagents();
			$agents = $activeagents['rows'];

			//get areas
			$allreas = $this->customersetup_model->getAreas();
			$areas = $allreas['rows'];
			
			/*$sectors = $this->customersetup_model->getSectors();

			$records = $sectors['rows'];
			$num = $sectors['num'];*/

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('sector/sectorpage_view', ['areas' => $areas, 'agents' => $agents]);
			$this->load->view('inc/footer_view');
		}
	}

	//-------Add Sector --------------

	public function addsector()
	{
		//set validation rules
		$this->form_validation->set_rules('sector', 'Sector', 'trim|required');
		$this->form_validation->set_rules('area', 'Area', 'required');
		$this->form_validation->set_rules('agent', 'Agent', 'required');

		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$now = date('Y-m-d');
			$data['createdate'] = $now;

			$fullname = $this->session->userdata('fullname');
			$data['createdby'] = $fullname;

			$data['sector'] = ucfirst(strtolower($data['sector']));

			$agentid = $data['agent'];
			$agent = $this->customersetup_model->getsingleagent($agentid);
			$data['agentname'] = $agent->fname . ' ' . $agent->lname;

			$areaid = $data['area'];
			$area = $this->customersetup_model->getsinglearea($areaid);
			$data['areaname'] = $area->areaname;

			//check if sector with same name exists
			$chksector = $this->customersetup_model->checksector($data);

			if ($chksector) {
				$this->session->set_flashdata('msg', 'Sector name already exists');
				return redirect('customersetup/sectorhome');
			}
			else {
				$newsector = $this->customersetup_model->addsector($data);

				if ($newsector) {
					$this->session->set_flashdata('success', 'Sector Added');
					return redirect('customersetup/sectorhome');
				}
			}

		}
		else {
			//$sectors = $this->customersetup_model->getSectors();

			//get active agents
			$activeagents = $this->customersetup_model->getactiveagents();
			$agents = $activeagents['rows'];

			//get areas
			$allreas = $this->customersetup_model->getAreas();
			$areas = $allreas['rows'];

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('sector/sectorpage_view', ['agents' => $agents, 'areas' => $areas]);
			$this->load->view('inc/footer_view');
		}
	}

	//----------------------------------------

	public function viewsectors()
	{
		$sectors = $this->customersetup_model->getSectors();

		if (!$sectors) {
			$this->session->set_flashdata('msg', 'No sector record');
			return redirect('home/index');
		}
		else {
			$records = $sectors['rows'];
			//$num = $users['num'];
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('sector/viewsectors_view', ['records' => $records]);
			$this->load->view('inc2/footer_view5');
		}
	}

	//-------------edit sector---------------

	public function editsector()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('customersetup/viewsectors');
		}
		else {

			if(isset($_GET['id'])) {
            $id = $_GET['id'];

	        }
	        else {
	        	$id = $this->uri->segment(3);
	        }

	        $sectorid = $id;
			$sector = $this->customersetup_model->getsinglesector($sectorid);

	        //get active agents
	        $agentid = $sector->agentid;
			$activeagents = $this->customersetup_model->getotheractiveagents($agentid);
			$agents = $activeagents['rows'];

			//get areas
			$allreas = $this->customersetup_model->getAreas();
			$areas = $allreas['rows'];

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('sector/editsector_view', ['sector' => $sector, 'agents' => $agents, 'areas' => $areas]);
			$this->load->view('inc/footer_view');
		}
		
	}

	//----------update sector ----------------

	public function updatesector()
	{
		// get hidden form field
    	$id = $this->input->post('id');

    	//set validation rules
		$this->form_validation->set_rules('sector', 'Sector', 'required|trim');
		$this->form_validation->set_rules('status', 'Status', 'required');
		$this->form_validation->set_rules('area', 'Area name', 'required');
		$this->form_validation->set_rules('agent', 'Agent name', 'required');

		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$now = date('Y-m-d');
			$temp = date('Y-m-d H:i:s');
			$data['modifydate'] = $now;

			$fullname = $this->session->userdata('fullname');
			$data['modifiedby'] = $fullname;

			$agentid = $data['agent'];
			$agent = $this->customersetup_model->getsingleagent($agentid);
			$data['agentname'] = $agent->fname . ' ' . $agent->lname;

			$areaid = $data['area'];
			$area = $this->customersetup_model->getsinglearea($areaid);
			$data['areaname'] = $area->areaname;

			//check sector
			$sec = $this->customersetup_model->checksector($data);

			//check if sector name exists
			if ($sec && ($data['sector'] != $data['osecname'])) {
				$this->session->set_flashdata('msg','Sector name exists');
				return redirect(base_url()."customersetup/editsector/".$id);
			}
			else {
				$updsector = $this->customersetup_model->updatesector($data);

				/*if ($updsector) {
					$this->session->set_flashdata('success','Sector updated');
					return redirect(base_url()."customersetup/editsector/".$id);
				}*/

				if ($updsector) {
					//get customers affected with sector update
					$customers = $this->customersetup_model->affectedsectorcustomers($data);

					if (!$customers) {
						$this->session->set_flashdata('success','Sector updated');
						return redirect(base_url()."customersetup/editsector/".$id);
					}
					else {
						$results = $customers['rows'];
						foreach ($results as $result) {
							$code = $result->customercode;

							$sectorname = strtoupper(substr($result->sectorname, 0,2));

							$code = $sectorname.substr($code, 2);

							$config = array(
								'sector' => $data['id'],
								'code' => $code,
								'customerid' => $result->customerid
							);

							//update customercode
							$customerupd = $this->customersetup_model->updatecustomersec($config);
						}

						$this->session->set_flashdata('success','Sector updated');
						return redirect(base_url()."customersetup/editsector/".$id);
					}
				}
			}
		}
		else {
			$this->session->set_flashdata('msg','Fill all compulsory field');
			//get active agents
			$activeagents = $this->customersetup_model->getactiveagents();
			$agents = $activeagents['rows'];

			//get areas
			$allreas = $this->customersetup_model->getAreas();
			$areas = $allreas['rows'];

			$sectorid = $id;
			$sector = $this->customersetup_model->getsinglesector($sectorid);
			
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('sector/editsector_view', ['sector' => $sector, 'agents' => $agents, 'areas' => $areas]);
			$this->load->view('inc/footer_view');
		}
	}

	//--------index street page---------------------

	public function streethome()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('home/index');
		}
		else {
			//get active sectors
			$activesectors = $this->customersetup_model->getactivesectors();

			$sectors = $activesectors['rows'];

			//get all streets
			/*$allstreets = $this->customersetup_model->getallstreet();

			$streets = $allstreets['rows'];
			$num = $allstreets['num'];*/

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('street/streetpage_view', ['sectors' => $sectors]);
			$this->load->view('inc/footer_view');
			//
		}
	}

	//------------ add new street ----------------

	public function addstreet()
	{
		//set validation rules
		$this->form_validation->set_rules('sector', 'Sector', 'required');
		$this->form_validation->set_rules('street', 'Street', 'required|trim');

		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$now = date('Y-m-d');
			$data['createdate'] = $now;

			$fullname = $this->session->userdata('fullname');
			$data['createdby'] = $fullname;

			//check if sector with same name exists
			$chkstr = $this->customersetup_model->checkstreet($data);

			if ($chkstr) {
				$this->session->set_flashdata('msg','Street name not available');
				return redirect('customersetup/streethome');
			}
			else {
				//get sector name
				$sectorid = $data['sector'];
				$sectname = $this->customersetup_model->getsinglesector($sectorid);
				$data['sectorname'] = $sectname->sectorname;

				$newstreet = $this->customersetup_model->addstreet($data);

				if ($newstreet) {
					$this->session->set_flashdata('success', 'Street Added');
					return redirect('customersetup/streethome');
				}
			}
		}
		else {
			//get active sectors
			$activesectors = $this->customersetup_model->getactivesectors();

			/*if (!$activesectors) {
				$this->session->set_flashdata('msg','Add sector before adding street');
				return redirect('customersetup/sectorhome');
			}*/

			$sectors = $activesectors['rows'];

			//get all streets
			/*$allstreets = $this->customersetup_model->getallstreet();

			$streets = $allstreets['rows'];
			$num = $allstreets['num'];*/

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('street/streetpage_view', ['sectors' => $sectors]);
			$this->load->view('inc/footer_view');
		}

	}

	//-------------------------------------

	public function viewstreets()
	{
		$allstreets = $this->customersetup_model->getallstreet();

		if (!$allstreets) {
			$this->session->set_flashdata('msg', 'No record found');
			return redirect('home/index');
		}
		else {
			$streets = $allstreets['rows'];
			//$num = $users['num'];
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('street/viewstreets_view', ['streets' => $streets]);
			$this->load->view('inc2/footer_view5');
		}
		
	}

	//--------- edit street --------------

	public function editstreet()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('customersetup/viewstreets');
		}
		else {
			if(isset($_GET['id'])) {
            $id = $_GET['id'];

	        }
	        else {
	        	$id = $this->uri->segment(3);
	        }

	        $streetid = $id;
			$street = $this->customersetup_model->getsinglestreet($streetid);

	        //get active sectors
	        $sectorid = $street->sectorid;
			$activesectors = $this->customersetup_model->getotheractivesectors($sectorid);
			$sectors = $activesectors['rows'];

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('street/editstreet_view', ['street' => $street, 'sectors' => $sectors]);
			$this->load->view('inc/footer_view');
			///
		}
	}

	//------------------------------------------

	public function updatestreet()
	{
		// get hidden form field
    	$id = $this->input->post('id');

    	//set validation rules
		$this->form_validation->set_rules('sector', 'Sector', 'required');
		$this->form_validation->set_rules('street', 'Street', 'required|trim');
		$this->form_validation->set_rules('status', 'Status', 'required');

		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$now = date('Y-m-ds');
			$data['modifydate'] = $now;

			$fullname = $this->session->userdata('fullname');
			$data['modfiedby'] = $fullname;

			//get sector name
			$sectorid = $data['sector'];
			$sectname = $this->customersetup_model->getsinglesector($sectorid);
			$data['sectorname'] = $sectname->sectorname;

			//check sector
			$str = $this->customersetup_model->checkstreet($data);

			if ($str) {
				if ($str->streetname == $data['ostrname']) {
					$updstrt = $this->customersetup_model->updatestreet($data);

					if ($updstrt) {
						$this->session->set_flashdata('success','Street updated');
						return redirect(base_url()."customersetup/editstreet/".$id);
					}
				}
				else {
					$this->session->set_flashdata('msg','Street name not available');
					return redirect(base_url()."customersetup/editstreet/".$id);
				}
			}
			else {

				$updstr = $this->customersetup_model->updatestreet($data);

				/*if ($updstr) {
					$this->session->set_flashdata('success','Street updated');
					return redirect(base_url()."customersetup/editstreet/".$id);
				}*/

				if ($updstr) {
					//select affected customers
					$customers = $this->customersetup_model->affectedcustomersstr($data);

					if (!$customers) {
						$this->session->set_flashdata('success','Street updated');
						return redirect(base_url()."customersetup/editstreet/".$id);
					}
					else {
						$results = $customers['rows'];
						foreach ($results as $result) {
							$code = strtoupper(substr($result->sectorname, 0,2)) . '/';
							$code = $code . strtoupper(substr($result->streetname, 0,2));

							$code = $code.substr($result->customercode, 5);

							$config = array(
								'street' => $data['id'],
								'code' => $code,
								'customerid' => $result->customerid
							);

							//update customercode
							$customerupd = $this->customersetup_model->updatecustomersec($config);
						}

						$this->session->set_flashdata('success','Street updated');
						return redirect(base_url()."customersetup/editstreet/".$id);
					}
				}
			}
		}
		else {
			//get active sectors
			$activesectors = $this->customersetup_model->getactivesectors();
			$sectors = $activesectors['rows'];
			$streetid = $id;
			$street = $this->customersetup_model->getsinglestreet($streetid);

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('street/editstreet_view', ['street' => $street, 'sectors' => $sectors]);
			$this->load->view('inc/footer_view');
		}
	}

	//-------------------------------------------

	public function househome()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('home/index');
		}
		else {
			$activesectors = $this->customersetup_model->getactivesectors();

			$sectors = $activesectors['rows'];
			//$streets = $activestreets['rows'];

			//get all houses
			/*$allhouses = $this->customersetup_model->getallhouses();

			$houses = $allhouses['rows'];
			$num = $allhouses['num'];*/

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('house/housepage_view', ['sectors' => $sectors]);
			$this->load->view('inc/footer_view');
			//
		}
		
	}

	//----------------------------------------------

	public function fetchactivestreet() {
		if ($this->input->post('sectorid')) {
			echo $this->customersetup_model->fetchactivestreet($this->input->post('sectorid'));
		}
	}

	//-------------------------------------------

	public function addhouse()
	{
		//set validation rules
		$this->form_validation->set_rules('sector', 'Sector', 'required');
		$this->form_validation->set_rules('street', 'Street', 'required');
		$this->form_validation->set_rules('houseno', 'House number', 'required');

		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$now = date('Y-m-d');
			$data['createdate'] = $now;

			$fullname = $this->session->userdata('fullname');
			$data['createdby'] = $fullname;

			//check if exact already exists
			$chkhouse = $this->customersetup_model->checkhouse($data);

			if ($chkhouse) {
				$this->session->set_flashdata('msg','House number already registered');
				return redirect('customersetup/househome');
			}
			else {
				//get sector name
				$sectorid = $data['sector'];
				$sectname = $this->customersetup_model->getsinglesector($sectorid);
				$data['sectorname'] = $sectname->sectorname;

				//get street name
				$streetid = $data['street'];
				$strname = $this->customersetup_model->getsinglestreet($streetid);
				$data['streetname'] = $strname->streetname;

				$newhouse = $this->customersetup_model->addhouse($data);

				if ($newhouse) {
					$this->session->set_flashdata('success', 'House Added');
					return redirect('customersetup/househome');
				}
			}
		}
		else {

			$activesectors = $this->customersetup_model->getactivesectors();

			$sectors = $activesectors['rows'];
			//$streets = $activestreets['rows'];

			//get all houses
			/*$allhouses = $this->customersetup_model->getallhouses();

			$houses = $allhouses['rows'];
			$num = $allhouses['num'];*/

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('house/housepage_view', ['sectors' => $sectors]);
			$this->load->view('inc/footer_view');
		}
	}

	//------------------------------------------

	public function viewhouses()
	{
		$allhouses = $this->customersetup_model->getallhouses();

		if (!$allhouses) {
			$this->session->set_flashdata('msg', 'No record found');
			return redirect('home/index');
		}
		else {
			$houses = $allhouses['rows'];
			//$num = $users['num'];
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('house/viewhouses_view', ['houses' => $houses]);
			$this->load->view('inc2/footer_view5');
		}
		
	}

	//-------------------------------------------

	public function edithouse()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('customersetup/viewhouses');
		}
		else {
			if(isset($_GET['id'])) {
            $id = $_GET['id'];

	        }
	        else {
	        	$id = $this->uri->segment(3);
	        }

	        $houseid = $id;
			$house = $this->customersetup_model->getsinglehouse($houseid);

	        //get active sectors
	        $sectorid = $house->sectorid;
			$activesectors = $this->customersetup_model->getotheractivesectors($sectorid);
			$sectors = $activesectors['rows'];

			//get active street
	        $streetid = $house->streetid;
			$activestreets = $this->customersetup_model->getotheractivestreets($streetid);
			$streets = $activestreets['rows'];

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('house/edithouse_view', ['house' => $house, 'sectors' => $sectors, 'streets' => $streets]);
			$this->load->view('inc/footer_view');
		}
	}

	//-------------------------------------------

	public function updatehouse()
	{
		// get hidden form field
    	$id = $this->input->post('id');

    	//set validation rules
		$this->form_validation->set_rules('sector', 'Sector', 'required');
		$this->form_validation->set_rules('street', 'Street', 'required');
		$this->form_validation->set_rules('houseno', 'houseno', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');

		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$now = date('Y-m-d');
			$data['modifydate'] = $now;

			$fullname = $this->session->userdata('fullname');
			$data['modfiedby'] = $fullname;

			//sector name
			$sectorid = $data['sector'];
			$sector = $this->customersetup_model->getsinglesector($sectorid);
			$data['sectorname'] = $sector->sectorname;

			//sector name
			$streetid = $data['street'];
			$street = $this->customersetup_model->getsinglestreet($streetid);
			$data['streetname'] = $street->streetname;

			//check house
			$house = $this->customersetup_model->checkhouse($data);

			if ($house) {
				if ($house->houseno == $data['oldname']) {
					$updhouse = $this->customersetup_model->updatehouse($data);

					if ($updhouse) {
						$this->session->set_flashdata('success','House updated');
						return redirect(base_url()."customersetup/edithouse/".$id);
					}
				}
				else {
					$this->session->set_flashdata('msg','House no already exists');
					return redirect(base_url()."customersetup/edithouse/".$id);
				}
			}
			else {
				$updthouse = $this->customersetup_model->updatehouse($data);

				/*if ($updthouse) {
					$this->session->set_flashdata('success','House updated');
					return redirect(base_url()."customersetup/edithouse/".$id);
				}*/

				if ($updthouse) {
					
					//select affected customers
					$customers = $this->customersetup_model->affectedcustomershouse($data);

					if (!$customers) {
						$this->session->set_flashdata('success','House updated');
						return redirect(base_url()."customersetup/edithouse/".$id);
					}
					else {
						$results = $customers['rows'];

						foreach ($results as $result) {
							$parts = explode("/", $result->customercode);

							$code = $parts[0] . '/' . $parts[1] . '/' . $result->houseno . '/';
							$code = $code . $parts[3] . '/' . $parts[4];

							$config = array(
								//'street' => $data['id'],
								'code' => $code,
								'customerid' => $result->customerid
							);

							//update customercode
							$customerupd = $this->customersetup_model->updatecustomersec($config);
						}

						$this->session->set_flashdata('success','House updated');
						return redirect(base_url()."customersetup/edithouse/".$id);
					}
				}
			}
		}
		else {
			//get active sectors
			$activesectors = $this->customersetup_model->getactivesectors();
			$sectors = $activesectors['rows'];

			$houseid = $id;
			$house = $this->customersetup_model->getsinglehouse($houseid);

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('house/edithouse_view', ['house' => $house, 'sectors' => $sectors]);
			$this->load->view('inc/footer_view');
		}
	}

	//--------------------------------------------

	public function categoryhome()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('home/index');
		}
		else {
			/*$housecat = $this->customersetup_model->gethousecategories();

			$records = $housecat['rows'];
			$num = $housecat['num'];*/

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('housecat/categoryhome_view');
			$this->load->view('inc/footer_view');
		}
	}

	//------------------------------------------

	public function addcategory()
	{
		//set validation rules
		$this->form_validation->set_rules('housetype', 'House type', 'required');
		$this->form_validation->set_rules('code', 'Housetype code', 'required');
		$this->form_validation->set_rules('mntcharge', 'Monthly Charge', 'required|numeric');

		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$now = date('Y-m-d');
			$data['createdate'] = $now;

			$fullname = $this->session->userdata('fullname');
			$data['createdby'] = $fullname;

			//$data['code'] = str_replace(' ', '', $data['code']);
			$data['code'] = strtoupper(str_replace(' ', '', $data['code']));

			//check house
			$housetype = $this->customersetup_model->checkhousetype($data);

			if ($housetype) {
				$this->session->set_flashdata('msg','House type exists');
				return redirect('customersetup/categoryhome');
			}
			else {
				$newhousetype = $this->customersetup_model->addhousetype($data);

				if ($newhousetype) {
					$this->session->set_flashdata('success', 'House type added');
					return redirect('customersetup/categoryhome');
				}
			}

		}
		else {
			/*$housecat = $this->customersetup_model->gethousecategories();

			$records = $housecat['rows'];
			$num = $housecat['num'];*/

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('housecat/categoryhome_view');
			$this->load->view('inc/footer_view');
		}
	}

	//--------------------------------------------

	public function viewcategories()
	{
		$housecat = $this->customersetup_model->gethousecategories();

		if (!$housecat) {
			$this->session->set_flashdata('msg', 'No record found');
			return redirect('home/index');
		}
		else {
			$records = $housecat['rows'];
			//$num = $users['num'];
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('housecat/viewhousecats_view', ['records' => $records]);
			$this->load->view('inc2/footer_view5');
		}
		
	}

	//------------------------------------------

	public function editcategoryhome()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('customersetup/viewcategories');
		}
		else {
			if(isset($_GET['id'])) {
            $id = $_GET['id'];

	        }
	        else {
	        	$id = $this->uri->segment(3);
	        }
	        $catid = $id;
			$cat = $this->customersetup_model->getsinglecategory($catid);

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('housecat/editcategoryhome_view', ['cat' => $cat]);
			$this->load->view('inc/footer_view');
			//
		}
	}

	//-------------------------------------------

	public function updatecategory()
	{
		// get hidden form field
    	$id = $this->input->post('id');

    	//set validation rules
		$this->form_validation->set_rules('housetype', 'House type', 'required');
		$this->form_validation->set_rules('code', 'Housetype code', 'required');
		$this->form_validation->set_rules('mntcharge', 'Monthly charge', 'required|numeric');
		//$this->form_validation->set_rules('status', 'Status', 'required');

		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$now = date('Y-m-d');
			$data['modifydate'] = $now;

			$fullname = $this->session->userdata('fullname');
			$data['modfiedby'] = $fullname;

			$data['code'] = strtoupper(str_replace(' ', '', $data['code']));

			//check sector
			$house = $this->customersetup_model->checkhousetype($data);

			//check if sector name exists
			if ($house && ($data['housetypecode'] != $data['oldtype'])) {
				$this->session->set_flashdata('msg','House category exists');
				return redirect(base_url()."customersetup/editcategoryhome/".$id);
			}
			else {
				$updcat = $this->customersetup_model->updatecategory($data);

				if ($updcat) {
					//$this->session->set_flashdata('success','House category updated');
					//return redirect(base_url()."customersetup/editcategoryhome/".$id);

					//select all customers that are affected by change of housetype
					$customers = $this->customersetup_model->affectedcustomers($data);
					if (!$customers) {
						$this->session->set_flashdata('success','House category updated');
						return redirect(base_url()."customersetup/editcategoryhome/".$id);
					}
					else {
						$results = $customers['rows'];
						foreach ($results as $result) {
							
							$config = array(
								'sector' => $result->sectorid,
								'street' => $result->streetid,
								'house' => $result->houseno,
								'housecatid' => $result->housecatid,
								//'code' => $result->housetypecode,
								'housetype' => $data['housetype'],
								'customerid' => $result->customerid,
								'code' => $data['code']
							);

							//select housetype number in house
							$customerno = $this->customersetup_model->gethousetypenos($config);

							$num = 0;

							if($customerno) {
								$num = $customerno['num'];
							}

							$config['customercode'] = strtoupper(substr($result->sectorname, 0,2)) . '/';
							$config['customercode'] = $config['customercode'] . strtoupper(substr($result->streetname, 0,2)) . '/';

							$nospace = strtoupper(str_replace(' ', '', $result->houseno));
							$config['customercode'] = $config['customercode'] . $nospace . '/';

							$config['customercode'] = $config['customercode'] . $config['code'] . '/';
							$config['customercode'] = $config['customercode'] . ($num+1);

							//update customer table
							$customerupd = $this->customersetup_model->updatecustomercode($config);
						}

						//redirect with success message
						$this->session->set_flashdata('success','House category updated');
						return redirect(base_url()."customersetup/editcategoryhome/".$id);
					}	
				}
			}
		}
		else {
			$this->session->set_flashdata('msg','Fill all compulsory field');
			$catid = $id;
			$cat = $this->customersetup_model->getsinglecategory($catid);
			
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('housecat/editcategoryhome_view', ['cat' => $cat]);
			$this->load->view('inc/footer_view');
		}
	}

	//----------------------------------------

	public function agenthome()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('home/index');
		}
		else {
			//get active sectors
			/*$activesectors = $this->customersetup_model->getactivesectors();
			$sectors = $activesectors['rows'];*/

			//get all agents
			/*$allagents = $this->customersetup_model->getagents();
			$agents = $allagents['rows'];
			$num = $allagents['num'];*/

			//return view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('agent/agentpage_view');
			$this->load->view('inc/footer_view');
			//
		}
	}

	//------------------------------------------

	public function addagent()
	{
		//set validation rules
		$this->form_validation->set_rules('fname', 'First name', 'trim|required|alpha');
		$this->form_validation->set_rules('oname', 'Middle Name', 'trim|alpha');
		$this->form_validation->set_rules('lname', 'Last name', 'trim|required|alpha');
		//$this->form_validation->set_rules('sector', 'Sector', 'required');
		$this->form_validation->set_rules('telno', 'Phone Number',
			'trim|is_natural|exact_length[11]');

		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$now = date('Y-m-d');
			$data['createdate'] = $now;

			$fullname = $this->session->userdata('fullname');
			$data['createdby'] = $fullname;

			//check agent
			$agent = $this->customersetup_model->checkagent($data);

			if ($agent) {
				$this->session->set_flashdata('msg','Agent already exists');
				return redirect('customersetup/agenthome');
			}
			else {

				//get sector name
				/*$sectorid = $data['sector'];
				$sector = $this->customersetup_model->getsinglesector($sectorid);
				$data['sectorname'] = $sector->sectorname;*/

				//add agent to database
				$newagent = $this->customersetup_model->addagent($data);

				if ($newagent) {
					$this->session->set_flashdata('success', 'Agent Added');
					return redirect('customersetup/agenthome');
				}
			}
		}
		else {
			//get active sectors
			/*$activesectors = $this->customersetup_model->getactivesectors();
			$sectors = $activesectors['rows'];*/

			//get all agents
			/*$allagents = $this->customersetup_model->getagents();
			$agents = $allagents['rows'];
			$num = $allagents['num'];*/

			//return view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('agent/agentpage_view');
			$this->load->view('inc/footer_view');
		}
	}

	//--------------------------------------------

	public function viewagents()
	{
		$allagents = $this->customersetup_model->getagents();

		if (!$allagents) {
			$this->session->set_flashdata('msg', 'No user record');
			return redirect('home/index');
		}
		else {
			$agents = $allagents['rows'];
			//$num = $users['num'];
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('agent/viewagents_view', ['agents' => $agents]);
			$this->load->view('inc2/footer_view5');
		}
		
	}

	//--------------------------------------------

	public function editagent()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('customersetup/viewagents');
		}
		else {
			if(isset($_GET['id'])) {
            $id = $_GET['id'];

	        }
	        else {
	        	$id = $this->uri->segment(3);
	        }

	        //get active sectors
			/*$activesectors = $this->customersetup_model->getactivesectors();
			$sectors = $activesectors['rows'];*/

	        $agentid = $id;
			$agent = $this->customersetup_model->getsingleagent($agentid);

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('agent/editagenthome_view', ['agent' => $agent]);
			$this->load->view('inc/footer_view');
		}
	}

	//------------------------------------------

	public function updateagent()
	{
		// get hidden form field
    	$id = $this->input->post('id');
    	
    	//set validation rules
		$this->form_validation->set_rules('fname', 'First Name', 'trim|required|alpha');
		$this->form_validation->set_rules('oname', 'Middle Name', 'trim|alpha');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|required|alpha');
		//$this->form_validation->set_rules('sector', 'Sector', 'required');
		$this->form_validation->set_rules('telno', 'Phone Number',
			'trim|is_natural|exact_length[11]');
		$this->form_validation->set_rules('status', 'Status', 'required');

		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$now = date('Y-m-d');
			$data['modifydate'] = $now;

			$fullname = $this->session->userdata('fullname');
			$data['modifiedby'] = $fullname;

			//sector name
			/*$sectorid = $data['sector'];
			$sector = $this->customersetup_model->getsinglesector($sectorid);
			$data['sectorname'] = $sector->sectorname;*/

			//check agent
			$agent = $this->customersetup_model->checkagent($data);

			$data['agentname'] = $data['fname'] . ' ' . $data['oname'] . ' ' . $data['lname'];

			if ($agent) {
				if ($agent->telno == $data['old']) {
					//same agent, update record
					$updagent = $this->customersetup_model->updateagent($data);

					if ($updagent) {
						$this->session->set_flashdata('success','Agent record updated');
						return redirect(base_url()."customersetup/editagent/".$id);
					}
				}
				else {
					$this->session->set_flashdata('msg','Agent already exists');
					return redirect(base_url()."customersetup/editagent/".$id);
				}
			}
			else {
				$updtagent = $this->customersetup_model->updateagent($data);

				if ($updtagent) {
					$this->session->set_flashdata('success','Agent record updated');
					return redirect(base_url()."customersetup/editagent/".$id);
				}
			}
		}
		else {
			//get active sectors
			/*$activesectors = $this->customersetup_model->getactivesectors();
			$sectors = $activesectors['rows'];*/

	        $agentid = $id;
			$agent = $this->customersetup_model->getsingleagent($agentid);

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('agent/editagenthome_view', ['agent' => $agent]);
			$this->load->view('inc/footer_view');
		}
	}

	//------------------------------------------

	public function customerhome()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('home/index');
		}
		else {
			//get house categories
			$housecat = $this->customersetup_model->gethousecategories();
			$cats = $housecat['rows'];

			//get active sectors
			$activesectors = $this->customersetup_model->getactivesectors();
			$sectors = $activesectors['rows'];

			//get all customers
			/*$allcustomers = $this->customersetup_model->getcustomers();
			$customers = $allcustomers['rows'];
			$num = $allcustomers['num'];*/

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('customer/customerpage_view', ['cats' => $cats, 'sectors' => $sectors]);
			$this->load->view('inc2/footer_view');
			//
		}
	}

	//----------------------------------------

	public function fetchactivehouses()
	{
		if ($this->input->post('streetid')) {
			echo $this->customersetup_model->getallactivehouses($this->input->post('streetid'));
		}
	}

	//-----------------------------------------

	public function addcustomer()
	{
		//set validation rules
		/*$this->form_validation->set_rules('title', 'Title', 'trim|alpha');
		$this->form_validation->set_rules('fname', 'First Name', 'trim|alpha');
		$this->form_validation->set_rules('oname', 'Middle Name', 'trim|alpha');*/
		$this->form_validation->set_rules('lname', 'Last Name', 'required');
		$this->form_validation->set_rules('telno', 'Phone Number',
			'trim|is_natural|exact_length[11]');
		$this->form_validation->set_rules('debt', 'Debt', 'is_natural');
		$this->form_validation->set_rules('wallet', 'Wallet', 'is_natural');
		$this->form_validation->set_rules('customertype', 'Customer type', 'required');
		$this->form_validation->set_rules('sector', 'Sector', 'required');
		$this->form_validation->set_rules('street', 'Street', 'required');
		$this->form_validation->set_rules('houseno', 'House number', 'required');
		$this->form_validation->set_rules('housetype', 'House type', 'required');
		$this->form_validation->set_rules('entrydate', 'Customer entry date', 'required');

		if ($this->form_validation->run()) {
			$data = $this->input->post();

			$data['entrydate'] = strtotime($data['entrydate']);
			$data['entrydate'] = date('Y-m-d', $data['entrydate']);

			$data['createdate'] = date('Y-m-d');

			if ($data['entrydate'] > $data['createdate']) {
				$this->session->set_flashdata('msg', 'Invalid date');
				return redirect('customersetup/customerhome');
			}

			$data['year'] = date('Y');
			$data['month'] = date('m');

			$data['customername'] = $data['lname'];

			if ($data['debt'] > 0 && $data['wallet'] > 0) {
				$this->session->set_flashdata('msg', 'Customer can not owe and have money in wallet');
				return redirect('customersetup/customerhome');
			}

			$fullname = $this->session->userdata('fullname');
			$data['createdby'] = $fullname;

			//get single sector
			$sectorid = $data['sector'];
			$sector = $this->customersetup_model->getsinglesector($sectorid);
			$data['sectorname'] = $sector->sectorname;
			$data['areaname'] = $sector->areaname;
			$data['areaid'] = $sector->areaid;
			if ($data['customertype'] == 'Commercial') {
				$data['agentid'] = 4;
				$data['agentname'] = 'Lagos State';
			}
			else {
				$data['agentid'] = $sector->agentid;
				$data['agentname'] = $sector->agentname;
			}

			$data['customercode'] = substr($data['sectorname'], 0,2) . '/';

			//get single street
			$streetid = $data['street'];
			$street = $this->customersetup_model->getsinglestreet($streetid);
			$data['streetname'] = $street->streetname;
			$data['customercode'] = $data['customercode'] . substr($data['streetname'], 0,2) . '/';

			//get single house
			$houseid = $data['houseno'];
			$house = $this->customersetup_model->getsinglehouse($houseid);
			$data['house'] = $house->houseno;

			//remove white space from house no
			$nospace = str_replace(' ', '', $data['house']);

			$data['customercode'] = $data['customercode'] . $nospace . '/';

			//get house category
			$catid = $data['housetype'];
			$house = $this->customersetup_model->getsinglecategory($catid);
			$data['housecat'] = $house->housetype;
			$data['code'] = $house->housetypecode;
			$data['mntcharge'] = $house->monthlycharge;

			//get number of customer in house
			$housetypeno = $this->customersetup_model->gethousetypeno($data);
			$num = 0;

			if($housetypeno) {
				$num = $housetypeno['num'];
			}

			$data['customercode'] = $data['customercode'] . $data['code'] . '/' . ($num+1);
			$data['customercode'] = strtoupper($data['customercode']);

			$supposedamt = 0;
			$data['i'] = 0;
			//get amount customer ought to have paid
			if ($data['month'] == '01') {
				$supposedamt = $data['mntcharge'];
				$data['i'] = 1;
			}
			elseif ($data['month'] == '02') {
				$supposedamt = $data['mntcharge'] * 2;
				$data['i'] = 2;
			}
			elseif ($data['month'] == '03') {
				$supposedamt = $data['mntcharge'] * 3;
				$data['i'] = 3;
			}
			elseif ($data['month'] == '04') {
				$supposedamt = $data['mntcharge'] * 4;
				$data['i'] = 4;
			}
			elseif ($data['month'] == '05') {
				$supposedamt = $data['mntcharge'] * 5;
				$data['i'] = 5;
			}
			elseif ($data['month'] == '06') {
				$supposedamt = $data['mntcharge'] * 6;
				$data['i'] = 6;
			}
			elseif ($data['month'] == '07') {
				$supposedamt = $data['mntcharge'] * 7;
				$data['i'] = 7;
			}
			elseif ($data['month'] == '08') {
				$supposedamt = $data['mntcharge'] * 8;
				$data['i'] = 8;
			}
			elseif ($data['month'] == '09') {
				$supposedamt = $data['mntcharge'] * 9;
				$data['i'] = 9;
			}
			elseif ($data['month'] == '10') {
				$supposedamt = $data['mntcharge'] * 10;
				$data['i'] = 10;
			}
			elseif ($data['month'] == '11') {
				$supposedamt = $data['mntcharge'] * 11;
				$data['i'] = 11;
			}
			else {
				$supposedamt = $data['mntcharge'] * 12;
				$data['i'] = 12;
			}

			$data['supposedamt'] = $supposedamt;

			$amtcollect = 0;
			//get amount customer has paid till current month
			if ($data['debt'] == '') {
				$amtcollect = $data['supposedamt'];
			}
			elseif ($data['debt'] > $data['supposedamt']) {
				$amtcollect = 0;
			}
			else {
				$amtcollect = $data['supposedamt'] - $data['debt'];
			}
			$data['amtcollect'] = $amtcollect;

			if ($data['wallet'] == '') {
				$data['amtcollect'] = $data['supposedamt'] + $data['wallet'];
			}

			/*$excessamt = 0;
			//get amount when customer owes more than supposed amount
			if ($data['debt'] > $data['supposedamt']) {
				$excessamt = $data['debt'] - $data['supposedamt'];
			}
			$data['excessamt'] = $excessamt;*/

			//check if sector with same name exists
			$chkcustomer = $this->customersetup_model->checkcustomer($data);

			if ($chkcustomer) {
				$this->session->set_flashdata('msg', 'Customer exists');
				return redirect('customersetup/customerhome');
			}
			else {
				$newcustomer = $this->customersetup_model->addcustomer($data);

				if ($newcustomer) {
					$this->session->set_flashdata('success', 'Customer Added');
					return redirect('customersetup/customerhome');
				}
			}
		}
		else {
			//get house categories
			$housecat = $this->customersetup_model->gethousecategories();
			$cats = $housecat['rows'];

			//get active sectors
			$activesectors = $this->customersetup_model->getactivesectors();
			$sectors = $activesectors['rows'];

			//get all customers
			/*$allcustomers = $this->customersetup_model->getcustomers();
			$customers = $allcustomers['rows'];
			$num = $allcustomers['num'];*/

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('customer/customerpage_view', ['cats' => $cats, 'sectors' => $sectors]);
			$this->load->view('inc2/footer_view');
		}
	}

	//------------------------------------------

	public function viewcustomers()
	{
		$allcustomers = $this->customersetup_model->getcustomers();

		if (!$allcustomers) {
			$this->session->set_flashdata('msg', 'No record found');
			return redirect('home/index');
		}
		else {
			$customers = $allcustomers['rows'];
			//$num = $users['num'];
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('customer/viewcustomers_view', ['customers' => $customers]);
			$this->load->view('inc2/footer_view5');
		}
		
	}

	//------------------------------------------

	public function editcustomer()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('customersetup/viewcustomers');
		}
		else {
			if(isset($_GET['id'])) {
            $id = $_GET['id'];

	        }
	        else {
	        	$id = $this->uri->segment(3);
	        }

	        //get customer details
	        $customerid = $id;
			$customer = $this->customersetup_model->getsinglecustomer($customerid);

	        //get active sectors
	        $sectorid = $customer->sectorid;
			$activesectors = $this->customersetup_model->getotheractivesectors($sectorid);
			$sectors = $activesectors['rows'];

			//get active sectors
	        $streetid = $customer->streetid;
			$activestreets = $this->customersetup_model->getotheractivestreets($streetid);
			$streets = $activestreets['rows'];

			//get active sectors
	        $houseid = $customer->houseid;
			$activehouses = $this->customersetup_model->getotheractivehouses($sectorid, $streetid, $houseid);
			$houses = $activehouses['rows'];

			//get house categories
			$housecatid = $customer->housecatid;
			$housecats = $this->customersetup_model->getotherhousecategories($housecatid);
			$cats = $housecats['rows'];

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('customer/editcustomer_view', ['customer' => $customer, 'sectors' => $sectors, 'cats' => $cats, 'streets' => $streets, 'houses' => $houses]);
			$this->load->view('inc2/footer_view');
		}
	}

	//-------------------------------------------

	public function updatecustomer()
	{
		// get hidden form field
    	$id = $this->input->post('id');

    	//set validation rules
		/*$this->form_validation->set_rules('title', 'Title', 'alpha');
		$this->form_validation->set_rules('fname', 'First Name', 'trim|alpha');
		$this->form_validation->set_rules('oname', 'Middle Name', 'trim|alpha');*/
		$this->form_validation->set_rules('lname', 'Last Name', 'required');
		$this->form_validation->set_rules('telno', 'Phone Number',
			'trim|is_natural|exact_length[11]');
		//$this->form_validation->set_rules('debt', 'Debt', 'is_natural');
		$this->form_validation->set_rules('customertype', 'Customer type', 'required');
		$this->form_validation->set_rules('sector', 'Sector', 'required');
		$this->form_validation->set_rules('street', 'Street', 'required');
		$this->form_validation->set_rules('debt', 'Debt', 'is_natural');
		$this->form_validation->set_rules('wallet', 'Wallet', 'is_natural');
		$this->form_validation->set_rules('houseno', 'House number', 'required');
		$this->form_validation->set_rules('housetype', 'House type', 'required');
		$this->form_validation->set_rules('entrydate', 'Customer entry date', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');

		if ($this->form_validation->run()) {
			$data = $this->input->post();

			$data['entrydate'] = strtotime($data['entrydate']);
			$data['entrydate'] = date('Y-m-d', $data['entrydate']);

			$data['modifydate'] = date('Y-m-d');

			if ($data['entrydate'] > $data['modifydate']) {
				$this->session->set_flashdata('msg', 'Invalid date');
				return redirect(base_url()."customersetup/editcustomer/".$id);
			}

			if ($data['debt'] > 0 && $data['wallet'] > 0) {
				$this->session->set_flashdata('msg', 'Customer can not owe and have money in wallet');
				return redirect(base_url()."customersetup/editcustomer/".$id);
			}

			$fullname = $this->session->userdata('fullname');
			$data['modfiedby'] = $fullname;

			//get single sector
			$sectorid = $data['sector'];
			$sector = $this->customersetup_model->getsinglesector($sectorid);
			$data['sectorname'] = $sector->sectorname;
			$data['areaname'] = $sector->areaname;
			$data['areaid'] = $sector->areaid;
			if ($data['customertype'] == 'Commercial') {
				$data['agentid'] = 4;
				$data['agentname'] = 'Lagos State';
			}
			else {
				$data['agentid'] = $sector->agentid;
				$data['agentname'] = $sector->agentname;
			}
			$data['customercode'] = substr($data['sectorname'], 0,2) . '/';

			//get single street
			$streetid = $data['street'];
			$street = $this->customersetup_model->getsinglestreet($streetid);
			$data['streetname'] = $street->streetname;
			$data['customercode'] = $data['customercode'] . substr($data['streetname'], 0,2) . '/';

			//get single house
			$houseid = $data['houseno'];
			$house = $this->customersetup_model->getsinglehouse($houseid);
			$data['house'] = $house->houseno;
			//$data['code'] = $house->housetypecode;

			//remove white space from house no
			$nospace = str_replace(' ', '', $data['house']);
			$data['customercode'] = $data['customercode'] . $nospace . '/';

			//get house category
			$catid = $data['housetype'];
			$house = $this->customersetup_model->getsinglecategory($catid);
			$data['housecat'] = $house->housetype;
			$data['code'] = $house->housetypecode;
			$data['mntcharge'] = $house->monthlycharge;

			//get number of customer in house
			$housetypeno = $this->customersetup_model->gethousetypeno($data);
			//$num = $customerno['num'];
			$num = 0;

			if($housetypeno) {
				$num = $housetypeno['num'];
			}

			$data['customercode'] = $data['customercode'] . $data['code'] . '/' . ($num+1);
			$data['customercode'] = strtoupper($data['customercode']);	

			//check if sector with same name exists
			$chkcustomer = $this->customersetup_model->checkcustomer($data);

			if ($chkcustomer) {
				if ($data['oldno'] != $data['telno']) {
					$this->session->set_flashdata('msg', 'Customer with matching phone number exists');
					return redirect(base_url()."customersetup/editcustomer/".$id);
				}
				else {
					$updcustomer = $this->customersetup_model->updatecustomer($data);

					if ($updcustomer) {

						if ($data['debt'] != $data['olddebt'] || $data['wallet'] != $data['oldwallet'] || $data['customerentrydate'] != $data['oldentrydate']) {

							$config = array(
									'protocol' => 'sendmail',
									'mailpath' => '/usr/sbin/sendmail',
									'charset'	=>	'iso-8859-1',
									'mailtype'	=>	'html',
									'smtp_port'	=>	25,
									'wordwrap'	=>	TRUE
								);

							$this->load->library('email', $config);
							$this->email->set_newline("\r\n");
							$this->email->from('no-reply@opendoorwastemanagement.com', 'Admin');
							$this->email->to('aderemi_1@yahoo.co.uk');
							$this->email->cc('mfdglobalventures@yahoo.com');
							$this->email->cc('anthonyedede@yahoo.com');
							$this->email->cc('seyiolawumi@gmail.com');
							$this->email->cc('seyiolawumi@yahoo.com');
							$this->email->subject('WMA - Sensitive Customer Information Updated');

							$message = "<p>Good day sir,<br> Here is to notify you that " . $data['modfiedby'] . " has made some sensitive change(s) to a customers information. Below is a breakdown of the changes made: <br></p>";
							$message .= "Name:\t" . $data['lname'] . "<br>";
							$message .= "Customer code from:\t" . $data['oldcustomercode'] . "\tto \t" . $data['customercode'] . "<br>";
							$message .= "Debt from:\t" . $data['olddebt'] . "\tto\t" . $data['debt'] . "<br>";
							$message .= "Wallet from:\t" . $data['oldwallet'] . "\tto\t" . $data['wallet'] . "<br>";
							$message .= "Customer entry date from:\t" . $data['oldentrydate'] . "\tto\t" . 
							$data['entrydate'] . "<br>";

							$this->email->message($message);
							$this->email->send();
						}

						$this->session->set_flashdata('success', 'Customer details updated');
						return redirect(base_url()."customersetup/editcustomer/".$id);
					}
				}
			}
			else {
				$updcustomer = $this->customersetup_model->updatecustomer($data);

				if ($updcustomer) {

					if ($data['debt'] != $data['olddebt'] || $data['wallet'] != $data['oldwallet'] || $data['customerentrydate'] != $data['oldentrydate']) {

						$config = array(
								'protocol' => 'sendmail',
								'mailpath' => '/usr/sbin/sendmail',
								'charset'	=>	'iso-8859-1',
								'mailtype'	=>	'html',
								'smtp_port'	=>	25,
								'wordwrap'	=>	TRUE
							);

						$this->load->library('email', $config);
						$this->email->set_newline("\r\n");
						$this->email->from('no-reply@opendoorwastemanagement.com', 'Admin');
						$this->email->to('aderemi_1@yahoo.co.uk');
						$this->email->cc('mfdglobalventures@yahoo.com');
						$this->email->cc('anthonyedede@yahoo.com');
						$this->email->cc('seyiolawumi@gmail.com');
						$this->email->cc('seyiolawumi@yahoo.com');
						$this->email->subject('WMA - Sensitive Customer Information Updated');

						$message = "<p>Good day sir,<br> Here is to notify you that " . $data['modfiedby'] . " has made some sensitive change(s) to a customers information. Below is a breakdown of the changes made: <br></p>";
						$message .= "Name:\t" . $data['lname'] . "<br>";
						$message .= "Customer code from:\t" . $data['oldcustomercode'] . "\tto \t" . $data['customercode'] . "<br>";
						$message .= "Debt from:\t" . $data['olddebt'] . "\tto\t" . $data['debt'] . "<br>";
						$message .= "Wallet from:\t" . $data['oldwallet'] . "\tto\t" . $data['wallet'] . "<br>";
						$message .= "Customer entry date from:\t" . $data['oldentrydate'] . "\tto\t" . 
						$data['entrydate'] . "<br>";

						$this->email->message($message);
						$this->email->send();
					}
					
					$this->session->set_flashdata('success', 'Customer details updated');
					return redirect(base_url()."customersetup/editcustomer/".$id);
				}
			}

		}
		else {
			//get active sectors
			$activesectors = $this->customersetup_model->getactivesectors();
			$sectors = $activesectors['rows'];

			//get house categories
			$housecat = $this->customersetup_model->gethousecategories();
			$cats = $housecat['rows'];

			//get customer details
	        $customerid = $id;
			$customer = $this->customersetup_model->getsinglecustomer($customerid);

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('customer/editcustomer_view', ['customer' => $customer, 'sectors' => $sectors, 'cats' => $cats]);
			$this->load->view('inc2/footer_view');
		}
	}

	//-----------------------------------------

	public function addpayment()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('home/index');
		}
		else {
			//get active sectors
			$activesectors = $this->customersetup_model->getactivesectors();
			$sectors = $activesectors['rows'];

			//load view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('payments/addpayments_view', ['sectors' => $sectors]);
			$this->load->view('inc2/footer_view2');
		}
	}

	//------------------------------------------

	public function fetchcustomercode()
	{
		if ($this->input->post('houseid')) {
			echo $this->customersetup_model->getcustomercode($this->input->post('houseid'));
		}
	}

	//---------------------------------------------

	public function fetchcustomername()
	{
		if ($this->input->post('codeid')) {
			echo $this->customersetup_model->getcustomername($this->input->post('codeid'));
		}
	}

	//-----------------------------------------

	public function fetchactivecustomer()
	{
		if ($this->input->post('customerid')) {
			echo $this->customersetup_model->fetchactivecustomer($this->input->post('customerid'));
		}
	}

	//-----------------------------------------

	public function confirmpayment()
	{

		//set validation rules
		$this->form_validation->set_rules('sector', 'Sector', 'required');
		$this->form_validation->set_rules('street', 'Street', 'required');
		$this->form_validation->set_rules('houseno', 'House number', 'required');
		$this->form_validation->set_rules('code', 'Customer code', 'required');
		$this->form_validation->set_rules('months', 'Number of months', 'required');
		$this->form_validation->set_rules('paymentdate', 'Payment date', 'required');
		$this->form_validation->set_rules('desc', 'Payment narration', 'required');
		$this->form_validation->set_rules('amount', 'amount', 'required');
		$this->form_validation->set_rules('paymode', 'Payment mode', 'required');

		if ($this->form_validation->run()) {
			$data = $this->input->post();

			$data['paymentdate'] = strtotime($data['paymentdate']);
			$data['paymentdate'] = date('Y-m-d', $data['paymentdate']);

			//get single sector
			$sectorid = $data['sector'];
			$sector = $this->customersetup_model->getsinglesector($sectorid);
			$data['sectorname'] = $sector->sectorname;

			//get single street
			$streetid = $data['street'];
			$street = $this->customersetup_model->getsinglestreet($streetid);
			$data['streetname'] = $street->streetname;

			//get single house
			$houseid = $data['houseno'];
			$house = $this->customersetup_model->getsinglehouse($houseid);
			$data['house'] = $house->houseno;

			//get customer details
			$customer = explode("@", $data['code']);
			$customerid = $customer[0];

			$data['customerid'] = $customerid;
			$customer = $this->customersetup_model->getsinglecustomer($customerid);
			$data['customername'] = $customer->name;
			$data['customercode'] = $customer->customercode;


			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('payments/confirmpayment_view', ['data' => $data]);
			$this->load->view('inc2/footer_view2');
		}
		else {
			//get active sectors
			$activesectors = $this->customersetup_model->getactivesectors();
			$sectors = $activesectors['rows'];

			//load view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('payments/addpayments_view', ['sectors' => $sectors]);
			$this->load->view('inc2/footer_view2');
		}
	}

	//----------------------------------------

	public function savepayment()
	{
		$data = $this->input->post();

		$data['entrydate'] = date('Y-m-d');
		$data['nmonth'] = date('m');
		$data['enteredby'] = $this->session->userdata('fullname');

		$data['year'] = substr($data['paymentdate'], 0, 4);
		$data['month'] = substr($data['paymentdate'], 5, 2);

		//get customer details
		$data['customerid']	 = $customerid = $data['id'];
		$customer = $this->customersetup_model->getsinglecustomer($customerid);
		$data['debt'] = $customer->debt;
		$data['oldwallet'] = $customer->wallet;
		$data['mntcharge'] = $customer->monthlycharge;

		//get amount due in present month

		$data['amtdue'] = $data['mntcharge'] * $data['month'];

		$data['newdebt'] = 0;
		$data['wallet'] = 0;

		if ($data['debt'] >= $data['amount']) {
			$data['newdebt'] = $data['debt'] - $data['amount'];
		}
		else {
			$data['wallet'] = $data['amount'] + $data['oldwallet'] - $data['debt'];
		}

		$data['amtcollect'] = $data['amount'];
		
		$agentid = 0;
		$agentname = '';
		$agentcomm = 0;

		if ($data['paymode'] == 'Direct') {
			
			if ($customer->customertype == 'Residential') {
				$agentid = 3;
				$agentname = 'Open Door';
			}
			else {
				$agentid = 4;
				$agentname = 'Lagos State';

				if ($data['amount'] > $data['mntcharge']) {
					if ($data['mntcharge'] < 10000) {
						$agentcomm = 0;
					}
					elseif ($data['mntcharge'] == 10000) {
						$agentcomm = $data['amount'] * 0.25;
					}
					else {
						$x = $data['amount'] / $data['mntcharge'];
						$y = $data['amount'] % $data['mntcharge'];

						$c = $data['mntcharge'] + $y - 10000;
						$agentcomm = $c * $x * 0.25;
					}
				}
				else {
					$diff = $data['mntcharge'] - 10000;
					$ratio = $diff / $data['mntcharge'];
					$agentcomm = $data['mntcharge'] * $ratio * 0.25;
				}
			}
		}
		else {
			if ($customer->customertype == 'Residential') {
				/*$agentcomm = $data['amount'] * 0.1;
				$agentid = $customer->agentid;
				$agentname = $customer->agentname; */
				$agentid = 3;
				$agentname = 'Open Door';
			}
			else {
				$agentid = 4;
				$agentname = 'Lagos State';

				if ($data['amount'] > $data['mntcharge']) {
					if ($data['mntcharge'] < 10000) {
						$agentcomm = 0;
					}
					elseif ($data['mntcharge'] == 10000) {
						$agentcomm = $data['amount'] * 0.25;
					}
					else {
						$x = $data['amount'] / $data['mntcharge'];
						$y = $data['amount'] % $data['mntcharge'];

						$c = $data['mntcharge'] + $y - 10000;
						$agentcomm = $c * $x * 0.25;
					}
				}
				else {
					$diff = $data['mntcharge'] - 10000;
					$ratio = $diff / $data['mntcharge'];
					$agentcomm = $data['mntcharge'] * $ratio * 0.25;
				}
			}
		}

		$data['lawmacomm'] = $data['amount'] * 0;
		$data['agentid'] = $agentid;
		$data['agentcomm'] = $agentcomm;
		$data['agentname'] = $agentname;
		$data['netcomm'] = $data['amount'] -($data['agentcomm'] + $data['lawmacomm']);

		//check if payment has been made in the year
		$data['collected'] = 0;
		$chkpayment = $this->customersetup_model->checkpaymentinyear($data);

		$resultid = 0;
		if ($chkpayment) { //customer has paid at least ones in year
			
			//payment made in january
			if ($data['month'] == '01') {
				
				//check if payment has been made in the month
				$chkjanpayment = $this->customersetup_model->checkpaymentjan($data);
				
				//$data['collected'] = $chkjanpayment->amtcollected + $data['amount'];
				if ($chkjanpayment->jan == 0) { //customer yet to pay in jan
					
					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //agent has gotten comm in year
						//check if agent has commission in month
						$agentjancomm = $this->customersetup_model->checkagentjancomm($data);



						$data['janagentcomm'] = $agentjancomm->agentcomm + $data['agentcomm'];
						$data['janlawmacomm'] = $agentjancomm->lawmacomm + $data['lawmacomm'];
						$data['jancollection'] = $agentjancomm->totalmonthcollection + $data['amount'];
						if ($agentjancomm->jan == 0) {
							//no commission in jan, no customer pay
							$janpayment = $this->customersetup_model->savejanpayment($data);
							$resultid = $janpayment;
						}
						else {
							//agent has comm in jan, customer not paid in jan
							$data['partjan'] = $agentjancomm->jan + $data['agentcomm'];
							$janpayment1 = $this->customersetup_model->savejanpayment1($data);
							$resultid = $janpayment1;
						}
					}
					else {
						//no commission in year, customer paid in year not month
						$janpayment2 = $this->customersetup_model->savejanpayment2($data);
						$resultid = $janpayment2;
					}
				}
				else {
					//paid in jan
					$data['janamt'] = $chkjanpayment->jan + $data['amount'];

					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //customer paid in jan, agen has comm in year
						
						$agentjancomm = $this->customersetup_model->checkagentjancomm($data);

						$data['janagentcomm'] = $agentjancomm->agentcomm + $data['agentcomm'];
						$data['janlawmacomm'] = $agentjancomm->lawmacomm + $data['lawmacomm'];
						$data['jancollection'] = $agentjancomm->totalmonthcollection + $data['amount'];

						if ($agentjancomm->jan == 0) {//customer pay, no agent comm in month
							
							$janpayment3 = $this->customersetup_model->savejanpayment3($data);
							$resultid = $janpayment3;
						}
						else {//customer pay, agent has comm in month
							$data['partjan'] = $agentjancomm->jan + $data['agentcomm'];
							$janpayment4 = $this->customersetup_model->savejanpayment4($data);
							$resultid = $janpayment4;
						}
					}
					else {
						//customer paid in month,no agent comm in year
						$janpayment5 = $this->customersetup_model->savejanpayment5($data);
						$resultid = $janpayment5;
					}
				}
			}
			//payment made in feb
			elseif ($data['month'] == '02') {
				
				//check if payment has been made in the month
				$chkfebpayment = $this->customersetup_model->checkpaymentjan($data);
				
				//$data['collected'] = $chkjanpayment->amtcollected + $data['amount'];
				if ($chkfebpayment->feb == 0) { //customer yet to pay in jan
					
					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //agent has gotten comm in year
						//check if agent has commission in month
						$agentfebcomm = $this->customersetup_model->checkagentjancomm($data);

						$data['febagentcomm'] = $agentfebcomm->agentcomm + $data['agentcomm'];
						$data['feblawmacomm'] = $agentfebcomm->lawmacomm + $data['lawmacomm'];
						$data['febcollection'] = $agentfebcomm->totalmonthcollection + $data['amount'];
						if ($agentfebcomm->feb == 0) {
							//no commission in feb, no customer pay
							$febpayment = $this->customersetup_model->savefebpayment($data);
							$resultid = $febpayment;
						}
						else {
							//agent has comm in feb, customer not paid in feb
							$data['partfeb'] = $agentfebcomm->feb + $data['agentcomm'];
							$febpayment1 = $this->customersetup_model->savefebpayment1($data);
							$resultid = $febpayment1;
						}
					}
					else {
						//no commission in year, customer paid in year not month
						$febpayment2 = $this->customersetup_model->savefebpayment2($data);
						$resultid = $febpayment2;
					}
				}
				else {
					//paid in feb
					$data['febamt'] = $chkfebpayment->feb + $data['amount'];

					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //customer paid in feb, agen has comm in year
						
						$agentfebcomm = $this->customersetup_model->checkagentjancomm($data);

						$data['febagentcomm'] = $agentfebcomm->agentcomm + $data['agentcomm'];
						$data['feblawmacomm'] = $agentfebcomm->lawmacomm + $data['lawmacomm'];
						$data['febcollection'] = $agentfebcomm->totalmonthcollection + $data['amount'];

						if ($agentfebcomm->feb == 0) {//customer pay, no agent comm in month
							
							$febpayment3 = $this->customersetup_model->savefebpayment3($data);
							$resultid = $febpayment3;
						}
						else {//customer pay, agent has comm in month
							$data['partfeb'] = $agentfebcomm->feb + $data['agentcomm'];
							$febpayment4 = $this->customersetup_model->savefebpayment4($data);
							$resultid = $febpayment4;
						}
					}
					else {
						//customer paid in month,no agent comm in year
						$febpayment5 = $this->customersetup_model->savefebpayment5($data);
						$resultid = $febpayment5;
					}
				}
			}
			//payment made in mar
			elseif ($data['month'] == '03') {
				
				//check if payment has been made in the month
				$chkmarpayment = $this->customersetup_model->checkpaymentjan($data);
				
				//$data['collected'] = $chkjanpayment->amtcollected + $data['amount'];
				if ($chkmarpayment->mar == 0) { //customer yet to pay in jan
					
					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //agent has gotten comm in year
						//check if agent has commission in month
						$agentmarcomm = $this->customersetup_model->checkagentjancomm($data);

						$data['maragentcomm'] = $agentmarcomm->agentcomm + $data['agentcomm'];
						$data['marlawmacomm'] = $agentmarcomm->lawmacomm + $data['lawmacomm'];
						$data['marcollection'] = $agentmarcomm->totalmonthcollection + $data['amount'];
						if ($agentmarcomm->mar == 0) {
							//no commission in mar, no customer pay
							$marpayment = $this->customersetup_model->savemarpayment($data);
							$resultid = $marpayment;
						}
						else {
							//agent has comm in mar, customer not paid in mar
							$data['partmar'] = $agentmarcomm->mar + $data['agentcomm'];
							$marpayment1 = $this->customersetup_model->savemarpayment1($data);
							$resultid = $marpayment1;
						}
					}
					else {
						//no commission in year, customer paid in year not month
						$marpayment2 = $this->customersetup_model->savemarpayment2($data);
						$resultid = $marpayment2;
					}
				}
				else {
					//paid in mar
					$data['maramt'] = $chkmarpayment->mar + $data['amount'];

					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //customer paid in mar, agen has comm in year
						
						$agentmarcomm = $this->customersetup_model->checkagentjancomm($data);

						$data['maragentcomm'] = $agentmarcomm->agentcomm + $data['agentcomm'];
						$data['marlawmacomm'] = $agentmarcomm->lawmacomm + $data['lawmacomm'];
						$data['marcollection'] = $agentmarcomm->totalmonthcollection + $data['amount'];

						if ($agentmarcomm->mar == 0) {//customer pay, no agent comm in month
							
							$marpayment3 = $this->customersetup_model->savemarpayment3($data);
							$resultid = $marpayment3;
						}
						else {//customer pay, agent has comm in month
							$data['partmar'] = $agentmarcomm->mar + $data['agentcomm'];
							$marpayment4 = $this->customersetup_model->savemarpayment4($data);
							$resultid = $marpayment4;
						}
					}
					else {
						//customer paid in month,no agent comm in year
						$marpayment5 = $this->customersetup_model->savemarpayment5($data);
						$resultid = $marpayment5;
					}
				}
			}
			//payment made in april
			elseif ($data['month'] == '04') {
				
				//check if payment has been made in the month
				$chkaprilpayment = $this->customersetup_model->checkpaymentjan($data);
				
				//$data['collected'] = $chkjanpayment->amtcollected + $data['amount'];
				if ($chkaprilpayment->april == 0) { //customer yet to pay in jan
					
					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //agent has gotten comm in year
						//check if agent has commission in month
						$agentaprilcomm = $this->customersetup_model->checkagentjancomm($data);

						$data['aprilagentcomm'] = $agentaprilcomm->agentcomm + $data['agentcomm'];
						$data['aprillawmacomm'] = $agentaprilcomm->lawmacomm + $data['lawmacomm'];
						$data['aprilcollection'] = $agentaprilcomm->totalmonthcollection + $data['amount'];
						if ($agentaprilcomm->april == 0) {
							//no commission in april, no customer pay
							$aprilpayment = $this->customersetup_model->saveaprilpayment($data);
							$resultid = $aprilpayment;
						}
						else {
							//agent has comm in april, customer not paid in april
							$data['partapril'] = $agentaprilcomm->april + $data['agentcomm'];
						  $aprilpayment1 = $this->customersetup_model->saveaprilpayment1($data);
						  $resultid = $aprilpayment1;
						}
					}
					else {
						//no commission in year, customer paid in year not month
						$aprilpayment2 = $this->customersetup_model->saveaprilpayment2($data);
						$resultid = $aprilpayment2;
					}
				}
				else {
					//paid in april
					$data['aprilamt'] = $chkaprilpayment->april + $data['amount'];

					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //customer paid in april, agen has comm in year
						
						$agentaprilcomm = $this->customersetup_model->checkagentjancomm($data);

						$data['aprilagentcomm'] = $agentaprilcomm->agentcomm + $data['agentcomm'];
						$data['aprillawmacomm'] = $agentaprilcomm->lawmacomm + $data['lawmacomm'];
						$data['aprilcollection'] = $agentaprilcomm->totalmonthcollection + $data['amount'];

						if ($agentaprilcomm->april == 0) {//customer pay, no agent comm in month
							
						   $aprilpayment3 = $this->customersetup_model->saveaprilpayment3($data);
						   $resultid = $aprilpayment3;
						}
						else {//customer pay, agent has comm in month
							$data['partapril'] = $agentaprilcomm->april + $data['agentcomm'];
						   $aprilpayment4 = $this->customersetup_model->saveaprilpayment4($data);
						   $resultid = $aprilpayment4;
						}
					}
					else {
						//customer paid in month,no agent comm in year
						$aprilpayment5 = $this->customersetup_model->saveaprilpayment5($data);
						$resultid = $aprilpayment5;
					}
				}
			}
			//payment made in may
			elseif ($data['month'] == '05') {
				
				//check if payment has been made in the month
				$chkmaypayment = $this->customersetup_model->checkpaymentjan($data);
				
				//$data['collected'] = $chkjanpayment->amtcollected + $data['amount'];
				if ($chkmaypayment->may == 0) { //customer yet to pay in jan
					
					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //agent has gotten comm in year
						//check if agent has commission in month
						$agentmaycomm = $this->customersetup_model->checkagentmaycomm($data);

						$data['mayagentcomm'] = $agentmaycomm->agentcomm + $data['agentcomm'];
						$data['maylawmacomm'] = $agentmaycomm->lawmacomm + $data['lawmacomm'];
						$data['maycollection'] = $agentmaycomm->totalmonthcollection + $data['amount'];
						if ($agentmaycomm->may == 0) {
							//no commission in may, no customer pay
							$maypayment = $this->customersetup_model->savemaypayment($data);
							$resultid = $maypayment;
						}
						else {
							//agent has comm in may, customer not paid in may
							$data['partmay'] = $agentmaycomm->may + $data['agentcomm'];
							$maypayment1 = $this->customersetup_model->savemaypayment1($data);
							$resultid = $maypayment1;
						}
					}
					else {
						//no commission in year, customer paid in year not month
						$maypayment2 = $this->customersetup_model->savemaypayment2($data);
						$resultid = $maypayment2;
					}
				}
				else {
					//paid in may
					$data['mayamt'] = $chkmaypayment->may + $data['amount'];

					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //customer paid in may, agen has comm in year
						
						$agentmaycomm = $this->customersetup_model->checkagentjancomm($data);

						$data['mayagentcomm'] = $agentmaycomm->agentcomm + $data['agentcomm'];
						$data['maylawmacomm'] = $agentmaycomm->lawmacomm + $data['lawmacomm'];
						$data['maycollection'] = $agentmaycomm->totalmonthcollection + $data['amount'];

						if ($agentmaycomm->may == 0) {//customer pay, no agent comm in month
							
							$maypayment3 = $this->customersetup_model->savemaypayment3($data);
							$resultid = $maypayment3;
						}
						else {//customer pay, agent has comm in month
							$data['partmay'] = $agentmaycomm->may + $data['agentcomm'];
							$maypayment4 = $this->customersetup_model->savemaypayment4($data);
							$resultid = $maypayment4;
						}
					}
					else {
						//customer paid in month,no agent comm in year
						$maypayment5 = $this->customersetup_model->savemaypayment5($data);
						$resultid = $maypayment5;
					}
				}
			}
			//payment made in june
			elseif ($data['month'] == '06') {
				
				//check if payment has been made in the month
				$chkjunepayment = $this->customersetup_model->checkpaymentjan($data);
				
				//$data['collected'] = $chkjanpayment->amtcollected + $data['amount'];
				if ($chkjunepayment->june == 0) { //customer yet to pay in jan
					
					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //agent has gotten comm in year
						//check if agent has commission in month
						$agentjunecomm = $this->customersetup_model->checkagentjancomm($data);

						$data['juneagentcomm'] = $agentjunecomm->agentcomm + $data['agentcomm'];
						$data['junelawmacomm'] = $agentjunecomm->lawmacomm + $data['lawmacomm'];
						$data['junecollection'] = $agentjunecomm->totalmonthcollection + $data['amount'];
						if ($agentjunecomm->june == 0) {
							//no commission in june, no customer pay
							$junepayment = $this->customersetup_model->savejunepayment($data);
							$resultid = $junepayment;
						}
						else {
							//agent has comm in june, customer not paid in june
							$data['partjune'] = $agentjunecomm->june + $data['agentcomm'];
							$junepayment1 = $this->customersetup_model->savejunepayment1($data);
							$resultid = $junepayment1;
						}
					}
					else {
						//no commission in year, customer paid in year not month
						$junepayment2 = $this->customersetup_model->savejunepayment2($data);
						$resultid = $junepayment2;
					}
				}
				else {
					//paid in june
					$data['juneamt'] = $chkjunepayment->june + $data['amount'];

					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //customer paid in june, agen has comm in year
						
						$agentjunecomm = $this->customersetup_model->checkagentjancomm($data);

						$data['juneagentcomm'] = $agentjunecomm->agentcomm + $data['agentcomm'];
						$data['junelawmacomm'] = $agentjunecomm->lawmacomm + $data['lawmacomm'];
						$data['junecollection'] = $agentjunecomm->totalmonthcollection + $data['amount'];

						if ($agentjunecomm->june == 0) {//customer pay, no agent comm in month
							
							$junepayment3 = $this->customersetup_model->savejunepayment3($data);
							$resultid = $junepayment3;
						}
						else {//customer pay, agent has comm in month
							$data['partjune'] = $agentjunecomm->june + $data['agentcomm'];
							$junepayment4 = $this->customersetup_model->savejunepayment4($data);
							$resultid = $junepayment4;
						}
					}
					else {
						//customer paid in month,no agent comm in year
						$junepayment5 = $this->customersetup_model->savejunepayment5($data);
						$resultid = $junepayment5;
					}
				}
			}
			//payment made in july
			elseif ($data['month'] == '07') {
				
				//check if payment has been made in the month
				$chkjulypayment = $this->customersetup_model->checkpaymentjan($data);
				
				//$data['collected'] = $chkjanpayment->amtcollected + $data['amount'];
				if ($chkjulypayment->july == 0) { //customer yet to pay in jan
					
					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //agent has gotten comm in year
						//check if agent has commission in month
						$agentjulycomm = $this->customersetup_model->checkagentjancomm($data);

						$data['julyagentcomm'] = $agentjulycomm->agentcomm + $data['agentcomm'];
						$data['julylawmacomm'] = $agentjulycomm->lawmacomm + $data['lawmacomm'];
						$data['julycollection'] = $agentjulycomm->totalmonthcollection + $data['amount'];
						if ($agentjulycomm->july == 0) {
							//no commission in july, no customer pay
							$julypayment = $this->customersetup_model->savejulypayment($data);
							$resultid = $julypayment;
						}
						else {
							//agent has comm in july, customer not paid in july
							$data['partjuly'] = $agentjulycomm->july + $data['agentcomm'];
							$julypayment1 = $this->customersetup_model->savejulypayment1($data);
							$resultid = $julypayment1;
						}
					}
					else {
						//no commission in year, customer paid in year not month
						$julypayment2 = $this->customersetup_model->savejulypayment2($data);
						$resultid = $julypayment2;
					}
				}
				else {
					//paid in july
					$data['julyamt'] = $chkjulypayment->july + $data['amount'];

					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //customer paid in july, agen has comm in year
						
						$agentjulycomm = $this->customersetup_model->checkagentjancomm($data);

						$data['julyagentcomm'] = $agentjulycomm->agentcomm + $data['agentcomm'];
						$data['julylawmacomm'] = $agentjulycomm->lawmacomm + $data['lawmacomm'];
						$data['julycollection'] = $agentjulycomm->totalmonthcollection + $data['amount'];

						if ($agentjulycomm->july == 0) {//customer pay, no agent comm in month
							
							$julypayment3 = $this->customersetup_model->savejulypayment3($data);
							$resultid = $julypayment3;
						}
						else {//customer pay, agent has comm in month
							$data['partjuly'] = $agentjulycomm->july + $data['agentcomm'];
							$julypayment4 = $this->customersetup_model->savejulypayment4($data);
							$resultid = $julypayment4;
						}
					}
					else {
						//customer paid in month,no agent comm in year
						$julypayment5 = $this->customersetup_model->savejulypayment5($data);
						$resultid = $julypayment5;
					}
				}
			}
			//payment made in aug
			elseif ($data['month'] == '08') {
				
				//check if payment has been made in the month
				$chkaugpayment = $this->customersetup_model->checkpaymentjan($data);
				
				//$data['collected'] = $chkjanpayment->amtcollected + $data['amount'];
				if ($chkaugpayment->aug == 0) { //customer yet to pay in jan
					
					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //agent has gotten comm in year
						//check if agent has commission in month
						$agentaugcomm = $this->customersetup_model->checkagentjancomm($data);

						$data['augagentcomm'] = $agentaugcomm->agentcomm + $data['agentcomm'];
						$data['auglawmacomm'] = $agentaugcomm->lawmacomm + $data['lawmacomm'];
						$data['augcollection'] = $agentaugcomm->totalmonthcollection + $data['amount'];
						if ($agentaugcomm->aug == 0) {
							//no commission in aug, no customer pay
							$augpayment = $this->customersetup_model->saveaugpayment($data);
							$resultid = $augpayment;
						}
						else {
							//agent has comm in aug, customer not paid in aug
							$data['partaug'] = $agentaugcomm->aug + $data['agentcomm'];
							$augpayment1 = $this->customersetup_model->saveaugpayment1($data);
							$resultid = $augpayment1;
						}
					}
					else {
						//no commission in year, customer paid in year not month
						$augpayment2 = $this->customersetup_model->saveaugpayment2($data);
						$resultid = $augpayment2;
					}
				}
				else {
					//paid in aug
					$data['augamt'] = $chkaugpayment->aug + $data['amount'];

					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //customer paid in aug, agen has comm in year
						
						$agentaugcomm = $this->customersetup_model->checkagentjancomm($data);

						$data['augagentcomm'] = $agentaugcomm->agentcomm + $data['agentcomm'];
						$data['auglawmacomm'] = $agentaugcomm->lawmacomm + $data['lawmacomm'];
						$data['augcollection'] = $agentaugcomm->totalmonthcollection + $data['amount'];

						if ($agentaugcomm->aug == 0) {//customer pay, no agent comm in month
							
							$augpayment3 = $this->customersetup_model->saveaugpayment3($data);
							$resultid = $augpayment3;
						}
						else {//customer pay, agent has comm in month
							$data['partaug'] = $agentaugcomm->aug + $data['agentcomm'];
							$augpayment4 = $this->customersetup_model->saveaugpayment4($data);
							$resultid = $augpayment4;
						}
					}
					else {
						//customer paid in month,no agent comm in year
						$augpayment5 = $this->customersetup_model->saveaugpayment5($data);
						$resultid = $augpayment5;
					}
				}
			}
			//payment made in sept
			elseif ($data['month'] == '09') {
				
				//check if payment has been made in the month
				$chkseptpayment = $this->customersetup_model->checkpaymentjan($data);
				
				//$data['collected'] = $chkjanpayment->amtcollected + $data['amount'];
				if ($chkseptpayment->sept == 0) { //customer yet to pay in jan
					
					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //agent has gotten comm in year
						//check if agent has commission in month
						$agentseptcomm = $this->customersetup_model->checkagentjancomm($data);

						$data['septagentcomm'] = $agentseptcomm->agentcomm + $data['agentcomm'];
						$data['septlawmacomm'] = $agentseptcomm->lawmacomm + $data['lawmacomm'];
						$data['septcollection'] = $agentseptcomm->totalmonthcollection + $data['amount'];
						if ($agentseptcomm->sept == 0) {
							//no commission in sept, no customer pay
							$septpayment = $this->customersetup_model->saveseptpayment($data);
							$resultid = $septpayment;
						}
						else {
							//agent has comm in sept, customer not paid in sept
							$data['partsept'] = $agentseptcomm->sept + $data['agentcomm'];
							$septpayment1 = $this->customersetup_model->saveseptpayment1($data);
							$resultid = $septpayment1;
						}
					}
					else {
						//no commission in year, customer paid in year not month
						$septpayment2 = $this->customersetup_model->saveseptpayment2($data);
						$resultid = $septpayment2;
					}
				}
				else {
					//paid in sept
					$data['septamt'] = $chkseptpayment->sept + $data['amount'];

					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //customer paid in sept, agen has comm in year
						
						$agentseptcomm = $this->customersetup_model->checkagentjancomm($data);

						$data['septagentcomm'] = $agentseptcomm->agentcomm + $data['agentcomm'];
						$data['septlawmacomm'] = $agentseptcomm->lawmacomm + $data['lawmacomm'];
						$data['septcollection'] = $agentseptcomm->totalmonthcollection + $data['amount'];

						if ($agentseptcomm->sept == 0) {//customer pay, no agent comm in month
							
							$septpayment3 = $this->customersetup_model->saveseptpayment3($data);
							$resultid = $septpayment3;
						}
						else {//customer pay, agent has comm in month
							$data['partsept'] = $agentseptcomm->sept + $data['agentcomm'];
							$septpayment4 = $this->customersetup_model->saveseptpayment4($data);
							$resultid = $septpayment4;
						}
					}
					else {
						//customer paid in month,no agent comm in year
						$septpayment5 = $this->customersetup_model->saveseptpayment5($data);
						$resultid = $septpayment5;
					}
				}
			}
			//payment made in oct
			elseif ($data['month'] == '10') {
				
				//check if payment has been made in the month
				$chkoctpayment = $this->customersetup_model->checkpaymentjan($data);
				
				//$data['collected'] = $chkjanpayment->amtcollected + $data['amount'];
				if ($chkoctpayment->oct == 0) { //customer yet to pay in jan
					
					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //agent has gotten comm in year
						//check if agent has commission in month
						$agentoctcomm = $this->customersetup_model->checkagentjancomm($data);

						$data['octagentcomm'] = $agentoctcomm->agentcomm + $data['agentcomm'];
						$data['octlawmacomm'] = $agentoctcomm->lawmacomm + $data['lawmacomm'];
						$data['octcollection'] = $agentoctcomm->totalmonthcollection + $data['amount'];
						if ($agentoctcomm->oct == 0) {
							//no commission in oct, no customer pay
							$octpayment = $this->customersetup_model->saveoctpayment($data);
							$resultid = $octpayment;
						}
						else {
							//agent has comm in oct, customer not paid in oct
							$data['partoct'] = $agentoctcomm->oct + $data['agentcomm'];
							$octpayment1 = $this->customersetup_model->saveoctpayment1($data);
							$resultid = $octpayment1;
						}
					}
					else {
						//no commission in year, customer paid in year not month
						$octpayment2 = $this->customersetup_model->saveoctpayment2($data);
						$resultid = $octpayment2;
					}
				}
				else {
					//paid in oct
					$data['octamt'] = $chkoctpayment->oct + $data['amount'];

					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //customer paid in oct, agen has comm in year
						
						$agentoctcomm = $this->customersetup_model->checkagentjancomm($data);

						$data['octagentcomm'] = $agentoctcomm->agentcomm + $data['agentcomm'];
						$data['octlawmacomm'] = $agentoctcomm->lawmacomm + $data['lawmacomm'];
						$data['octcollection'] = $agentoctcomm->totalmonthcollection + $data['amount'];

						if ($agentoctcomm->oct == 0) {//customer pay, no agent comm in month
							
							$octpayment3 = $this->customersetup_model->saveoctpayment3($data);
							$resultid = $octpayment3;
						}
						else {//customer pay, agent has comm in month
							$data['partoct'] = $agentoctcomm->oct + $data['agentcomm'];
							$octpayment4 = $this->customersetup_model->saveoctpayment4($data);
							$resultid = $octpayment4;
						}
					}
					else {
						//customer paid in month,no agent comm in year
						$octpayment5 = $this->customersetup_model->saveoctpayment5($data);
						$resultid = $octpayment5;
					}
				}
			}
			//payment made in nov
			elseif ($data['month'] == '11') {
				
				//check if payment has been made in the month
				$chknovpayment = $this->customersetup_model->checkpaymentjan($data);
				
				//$data['collected'] = $chkjanpayment->amtcollected + $data['amount'];
				if ($chknovpayment->nov == 0) { //customer yet to pay in jan
					
					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //agent has gotten comm in year
						//check if agent has commission in month
						$agentnovcomm = $this->customersetup_model->checkagentjancomm($data);

						$data['novagentcomm'] = $agentnovcomm->agentcomm + $data['agentcomm'];
						$data['novlawmacomm'] = $agentnovcomm->lawmacomm + $data['lawmacomm'];
						$data['novcollection'] = $agentnovcomm->totalmonthcollection + $data['amount'];
						if ($agentnovcomm->nov == 0) {
							//no commission in nov, no customer pay
							$novpayment = $this->customersetup_model->savenovpayment($data);
							$resultid = $novpayment;
						}
						else {
							//agent has comm in nov, customer not paid in nov
							$data['partnov'] = $agentnovcomm->nov + $data['agentcomm'];
							$novpayment1 = $this->customersetup_model->savenovpayment1($data);
							$resultid = $novpayment1;
						}
					}
					else {
						//no commission in year, customer paid in year not month
						$novpayment2 = $this->customersetup_model->savenovpayment2($data);
						$resultid = $novpayment2;
					}
				}
				else {
					//paid in nov
					$data['novamt'] = $chknovpayment->nov + $data['amount'];

					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //customer paid in nov, agen has comm in year
						
						$agentnovcomm = $this->customersetup_model->checkagentjancomm($data);

						$data['novagentcomm'] = $agentnovcomm->agentcomm + $data['agentcomm'];
						$data['novlawmacomm'] = $agentnovcomm->lawmacomm + $data['lawmacomm'];
						$data['novcollection'] = $agentnovcomm->totalmonthcollection + $data['amount'];

						if ($agentnovcomm->nov == 0) {//customer pay, no agent comm in month
							
							$novpayment3 = $this->customersetup_model->savenovpayment3($data);
							$resultid = $novpayment3;
						}
						else {//customer pay, agent has comm in month
							$data['partnov'] = $agentnovcomm->nov + $data['agentcomm'];
							$novpayment4 = $this->customersetup_model->savenovpayment4($data);
							$resultid = $novpayment4;
						}
					}
					else {
						//customer paid in month,no agent comm in year
						$novpayment5 = $this->customersetup_model->savenovpayment5($data);
						$resultid = $novpayment5;
					}
				}
			}
			//payment made in december
			else {
				
				//check if payment has been made in the month
				$chkdecemberpayment = $this->customersetup_model->checkpaymentjan($data);
				
				//$data['collected'] = $chkjanpayment->amtcollected + $data['amount'];
				if ($chkdecemberpayment->december == 0) { //customer yet to pay in jan
					
					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //agent has gotten comm in year
						//check if agent has commission in month
						$agentdecembercomm = $this->customersetup_model->checkagentjan($data);

						$data['decemberagentcomm'] = $agentdecembercomm->agentcomm + $data['agentcomm'];
						$data['decemberlawmacomm'] = $agentdecembercomm->lawmacomm + $data['lawmacomm'];
						$data['decembercollection'] = $agentdecembercomm->totalmonthcollection + $data['amount'];
						if ($agentdecembercomm->december == 0) {
							//no commission in december, no customer pay
							$decemberpayment = $this->customersetup_model->savedecemberpayment($data);
							$resultid = $decemberpayment;
						}
						else {
							//agent has comm in december, customer not paid in december
							$data['partdecember'] = $agentdecembercomm->december + $data['agentcomm'];
							$decemberpayment1 = $this->customersetup_model->savedecemberpayment1($data);
							$resultid = $decemberpayment1;
						}
					}
					else {
						//no commission in year, customer paid in year not month
						$decemberpayment2 = $this->customersetup_model->savedecemberpayment2($data);
						$resultid = $decemberpayment2;
					}
				}
				else {
					//paid in december
					$data['decemberamt'] = $chkdecemberpayment->december + $data['amount'];

					//check if agent has gotten any commission in year
					$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);

					if ($agentcommyear) { //customer paid in december, agen has comm in year
						
						$agentdecembercomm = $this->customersetup_model->checkagentjancomm($data);

						$data['decemberagentcomm'] = $agentdecembercomm->agentcomm + $data['agentcomm'];
						$data['decemberlawmacomm'] = $agentdecembercomm->lawmacomm + $data['lawmacomm'];
						$data['decembercollection'] = $agentdecembercomm->totalmonthcollection + $data['amount'];

						if ($agentdecembercomm->december == 0) {//customer pay, no agent comm in month
							
							$decemberpayment3 = $this->customersetup_model->savedecemberpayment3($data);
							$resultid = $decemberpayment3;
						}
						else {//customer pay, agent has comm in month
							$data['partdecember'] = $agentdecembercomm->december + $data['agentcomm'];
							$decemberpayment4 = $this->customersetup_model->savedecemberpayment4($data);
							$resultid = $decemberpayment4;
						}
					}
					else {
						//customer paid in month,no agent comm in year
						$decemberpayment5 = $this->customersetup_model->savedecemberpayment5($data);
						$resultid = $decemberpayment5;
					}
				}
			}
			//another month
		}
		//customer yet to pay in year
		else {
			if ($data['month'] == '01') {
				//check if agent has gotten commission in year
				$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);
				if ($agentcommyear) { //agent has comm in year
					//has commission in year,check month
					$agentjancomm = $this->customersetup_model->checkagentjancomm($data);

					$data['agentjancomm'] = $agentjancomm->agentcomm + $data['agentcomm'];
					$data['lawmajancomm'] = $agentjancomm->lawmacomm + $data['lawmacomm'];
					$data['collection'] = $agentjancomm->totalmonthcollection + $data['amount'];
					if ($agentjancomm->jan == 0) {//no commission in month
						//agent has no comm in month but has in year, customer yet to pay in year

					   $firstjanpayment = $this->customersetup_model->savefirstjanpayment($data);
					   $resultid = $firstjanpayment;
					}
					else {//agent has commision in month, customer yet to pay

						$data['newcomm'] = $agentjancomm->jan + $data['agentcomm'];
						$firstjanpayment1 = $this->customersetup_model->savefirstjanpayment1($data);
						$resultid = $firstjanpayment1;
					}

				}
				else {
					//no agent comm in year,customer yet to pay in year
					$firstjanpayment2 = $this->customersetup_model->savefirstjanpayment2($data);
					$resultid = $firstjanpayment2;
				}
			}
			elseif ($data['month'] == '02') {
				//check if agent has gotten commission in year
				$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);
				if ($agentcommyear) { //agent has comm in year
					//has commission in year,check month
					$agentfebcomm = $this->customersetup_model->checkagentjancomm($data);

					$data['agentfebcomm'] = $agentfebcomm->agentcomm + $data['agentcomm'];
					$data['lawmafebcomm'] = $agentfebcomm->lawmacomm + $data['lawmacomm'];
					//$data['febnetcomm'] = $agentfebcomm->netcomm + $data['netcomm'];
					$data['collection'] = $agentfebcomm->totalmonthcollection + $data['amount'];
					if ($agentfebcomm->feb == 0) {//no commission in month
					   //agent has no comm in month but has in year, customer yet to pay in year
					   $firstfebpayment = $this->customersetup_model->savefirstfebpayment($data);
					   $resultid = $firstfebpayment;
					}
					else {//agent has commision in month, customer yet to pay

						$data['newcomm'] = $agentfebcomm->feb + $data['agentcomm'];
						$firstfebpayment1 = $this->customersetup_model->savefirstfebpayment1($data);
						$resultid = $firstfebpayment1;
					}

				}
				else {
					//no agent comm in year,customer yet to pay in year
					$firstfebpayment2 = $this->customersetup_model->savefirstfebpayment2($data);
					$resultid = $firstfebpayment2;
				}
			}
			elseif ($data['month'] == '03') {
				//check if agent has gotten commission in year
				$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);
				if ($agentcommyear) { //agent has comm in year
					//has commission in year,check month
					$agentmarcomm = $this->customersetup_model->checkagentjancomm($data);

					$data['agentmarcomm'] = $agentmarcomm->agentcomm + $data['agentcomm'];
					$data['lawmamarcomm'] = $agentmarcomm->lawmacomm + $data['lawmacomm'];
					//$data['marnetcomm'] = $agentmarcomm->netcomm + $data['netcomm'];
					$data['collection'] = $agentmarcomm->totalmonthcollection + $data['amount'];
					if ($agentmarcomm->mar == 0) {//no commission in month
						//agent has no comm in month but has in year, customer yet to pay in year
					   $firstmarpayment = $this->customersetup_model->savefirstmarpayment($data);
					   $resultid = $firstmarpayment;
					}
					else {//agent has commision in month, customer yet to pay

						$data['newcomm'] = $agentmarcomm->mar + $data['agentcomm'];
						$firstmarpayment1 = $this->customersetup_model->savefirstmarpayment1($data);
						$resultid = $firstmarpayment1;
					}

				}
				else {
					//no agent comm in year,customer yet to pay in year
					$firstmarpayment2 = $this->customersetup_model->savefirstmarpayment2($data);
					$resultid = $firstmarpayment2;
				}
			}
			elseif ($data['month'] == '04') {
				//check if agent has gotten commission in year
				$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);
				if ($agentcommyear) { //agent has comm in year
					//has commission in year,check month
					$agentaprilcomm = $this->customersetup_model->checkagentjancomm($data);

					$data['agentaprilcomm'] = $agentaprilcomm->agentcomm + $data['agentcomm'];
					$data['lawmaaprilcomm'] = $agentaprilcomm->lawmacomm + $data['lawmacomm'];
					//$data['aprilnetcomm'] = $agentaprilcomm->netcomm + $data['netcomm'];
					$data['collection'] = $agentaprilcomm->totalmonthcollection + $data['amount'];
					if ($agentaprilcomm->april == 0) {//no commission in month
						//agent has no comm in month but has in year, customer yet to pay in year
						$firstaprilpayment = $this->customersetup_model->savefirstaprilpayment($data);
						$resultid = $firstaprilpayment;
					}
					else {//agent has commision in month, customer yet to pay

						$data['newcomm'] = $agentaprilcomm->april + $data['agentcomm'];
						$firstaprilpayment1 = $this->customersetup_model->savefirstaprilpayment1($data);
						$resultid = $firstaprilpayment1;
					}

				}
				else {
					//no agent comm in year,customer yet to pay in year
					$firstaprilpayment2 = $this->customersetup_model->savefirstaprilpayment2($data);
					$resultid = $firstaprilpayment2;
				}
			}
			elseif ($data['month'] == '05') {
				//check if agent has gotten commission in year
				$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);
				if ($agentcommyear) { //agent has comm in year
					//has commission in year,check month
					$agentmaycomm = $this->customersetup_model->checkagentjancomm($data);

					$data['agentmaycomm'] = $agentmaycomm->agentcomm + $data['agentcomm'];
					$data['lawmamaycomm'] = $agentmaycomm->lawmacomm + $data['lawmacomm'];
					//$data['maynetcomm'] = $agentmaycomm->netcomm + $data['netcomm'];
					$data['collection'] = $agentmaycomm->totalmonthcollection + $data['amount'];
					if ($agentmaycomm->may == 0) {//no commission in month
						//agent has no comm in month but has in year, customer yet to pay in year
					   $firstmaypayment = $this->customersetup_model->savefirstmaypayment($data);
					   $resultid = $firstmaypayment;
					}
					else {//agent has commision in month, customer yet to pay

						$data['newcomm'] = $agentmaycomm->may + $data['agentcomm'];
						$firstmaypayment1 = $this->customersetup_model->savefirstmaypayment1($data);
						$resultid = $firstmaypayment1;
					}

				}
				else {
					//no agent comm in year,customer yet to pay in year
					$firstmaypayment2 = $this->customersetup_model->savefirstmaypayment2($data);
					$resultid = $firstmaypayment2;
				}
			}
			elseif ($data['month'] == '06') {
				//check if agent has gotten commission in year
				$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);
				if ($agentcommyear) { //agent has comm in year
					//has commission in year,check month
					$agentjunecomm = $this->customersetup_model->checkagentjancomm($data);

					$data['agentjunecomm'] = $agentjunecomm->agentcomm + $data['agentcomm'];
					$data['lawmajunecomm'] = $agentjunecomm->lawmacomm + $data['lawmacomm'];
					//$data['junenetcomm'] = $agentjunecomm->netcomm + $data['netcomm'];
					$data['collection'] = $agentjunecomm->totalmonthcollection + $data['amount'];
					if ($agentjunecomm->june == 0) {//no commission in month
						//agent has no comm in month but has in year, customer yet to pay in year
						$firstjunepayment = $this->customersetup_model->savefirstjunepayment($data);
						$resultid = $firstjunepayment;
					}
					else {//agent has commision in month, customer yet to pay

						$data['newcomm'] = $agentjunecomm->june + $data['agentcomm'];
						$firstjunepayment1 = $this->customersetup_model->savefirstjunepayment1($data);
						$resultid = $firstjunepayment1;
					}

				}
				else {
					//no agent comm in year,customer yet to pay in year
				   $firstjunepayment2 = $this->customersetup_model->savefirstjunepayment2($data);
				   $resultid = $firstjunepayment2;
				}
			}
			elseif ($data['month'] == '07') {
				//check if agent has gotten commission in year
				$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);
				if ($agentcommyear) { //agent has comm in year
					//has commission in year,check month
					$agentjulycomm = $this->customersetup_model->checkagentjancomm($data);

					$data['agentjulycomm'] = $agentjulycomm->agentcomm + $data['agentcomm'];
					$data['lawmajulycomm'] = $agentjulycomm->lawmacomm + $data['lawmacomm'];
					//$data['julynetcomm'] = $agentjulycomm->netcomm + $data['netcomm'];
					$data['collection'] = $agentjulycomm->totalmonthcollection + $data['amount'];
					if ($agentjulycomm->july == 0) {//no commission in month
						//agent has no comm in month but has in year, customer yet to pay in year
						$firstjulypayment = $this->customersetup_model->savefirstjulypayment($data);
						$resultid = $firstjulypayment;
					}
					else {//agent has commision in month, customer yet to pay

						$data['newcomm'] = $agentjulycomm->july + $data['agentcomm'];
						$firstjulypayment1 = $this->customersetup_model->savefirstjulypayment1($data);
						$resultid = $firstjulypayment1;
					}

				}
				else {
					//no agent comm in year,customer yet to pay in year
				   $firstjulypayment2 = $this->customersetup_model->savefirstjulypayment2($data);
				   $resultid = $firstjulypayment2;
				}
			}
			elseif ($data['month'] == '08') {
				//check if agent has gotten commission in year
				$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);
				if ($agentcommyear) { //agent has comm in year
					//has commission in year,check month
					$agentaugcomm = $this->customersetup_model->checkagentjancomm($data);

					$data['agentaugcomm'] = $agentaugcomm->agentcomm + $data['agentcomm'];
					$data['lawmaaugcomm'] = $agentaugcomm->lawmacomm + $data['lawmacomm'];
					//$data['augnetcomm'] = $agentaugcomm->netcomm + $data['netcomm'];
					$data['collection'] = $agentaugcomm->totalmonthcollection + $data['amount'];
					if ($agentaugcomm->aug == 0) {//no commission in month
						//agent has no comm in month but has in year, customer yet to pay in year
					   $firstaugpayment = $this->customersetup_model->savefirstaugpayment($data);
					   $resultid = $firstaugpayment;
					}
					else {//agent has commision in month, customer yet to pay

						$data['newcomm'] = $agentaugcomm->aug + $data['agentcomm'];
						$firstaugpayment1 = $this->customersetup_model->savefirstaugpayment1($data);
						$resultid = $firstaugpayment1;
					}

				}
				else {
					//no agent comm in year,customer yet to pay in year
					$firstaugpayment2 = $this->customersetup_model->savefirstaugpayment2($data);
					$resultid = $firstaugpayment2;
				}
			}
			elseif ($data['month'] == '09') {
				//check if agent has gotten commission in year
				$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);
				if ($agentcommyear) { //agent has comm in year
					//has commission in year,check month
					$agentseptcomm = $this->customersetup_model->checkagentjancomm($data);

					$data['agentseptcomm'] = $agentseptcomm->agentcomm + $data['agentcomm'];
					$data['lawmaseptcomm'] = $agentseptcomm->lawmacomm + $data['lawmacomm'];
					//$data['septnetcomm'] = $agentseptcomm->netcomm + $data['netcomm'];
					$data['collection'] = $agentseptcomm->totalmonthcollection + $data['amount'];
					if ($agentseptcomm->sept == 0) {//no commission in month
						//agent has no comm in month but has in year, customer yet to pay in year
						$firstseptpayment = $this->customersetup_model->savefirstseptpayment($data);
						$resultid = $firstseptpayment;
					}
					else {//agent has commision in month, customer yet to pay

						$data['newcomm'] = $agentseptcomm->sept + $data['agentcomm'];
						$firstseptpayment1 = $this->customersetup_model->savefirstseptpayment1($data);
						$resultid = $firstseptpayment1;
					}

				}
				else {
					//no agent comm in year,customer yet to pay in year
				   $firstseptpayment2 = $this->customersetup_model->savefirstseptpayment2($data);
				   $resultid = $firstseptpayment2;
				}
			}
			elseif ($data['month'] == '10') {
				//check if agent has gotten commission in year
				$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);
				if ($agentcommyear) { //agent has comm in year
					//has commission in year,check month
					$agentoctcomm = $this->customersetup_model->checkagentjancomm($data);

					$data['agentoctcomm'] = $agentoctcomm->agentcomm + $data['agentcomm'];
					$data['lawmaoctcomm'] = $agentoctcomm->lawmacomm + $data['lawmacomm'];
					//$data['octnetcomm'] = $agentoctcomm->netcomm + $data['netcomm'];
					$data['collection'] = $agentoctcomm->totalmonthcollection + $data['amount'];
					if ($agentoctcomm->oct == 0) {//no commission in month
						//agent has no comm in month but has in year, customer yet to pay in year
					   $firstoctpayment = $this->customersetup_model->savefirstoctpayment($data);
					   $resultid = $firstoctpayment;
					}
					else {//agent has commision in month, customer yet to pay

						$data['newcomm'] = $agentoctcomm->oct + $data['agentcomm'];
						$firstoctpayment1 = $this->customersetup_model->savefirstoctpayment1($data);
						$resultid = $firstoctpayment1;
					}

				}
				else {
					//no agent comm in year,customer yet to pay in year
					$firstoctpayment2 = $this->customersetup_model->savefirstoctpayment2($data);
					$resultid = $firstoctpayment2;
				}
			}
			elseif ($data['month'] == '11') {
				//check if agent has gotten commission in year
				$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);
				if ($agentcommyear) { //agent has comm in year
					//has commission in year,check month
					$agentnovcomm = $this->customersetup_model->checkagentjancomm($data);

					$data['agentnovcomm'] = $agentnovcomm->agentcomm + $data['agentcomm'];
					$data['lawmanovcomm'] = $agentnovcomm->lawmacomm + $data['lawmacomm'];
					//$data['novnetcomm'] = $agentnovcomm->netcomm + $data['netcomm'];
					$data['collection'] = $agentnovcomm->totalmonthcollection + $data['amount'];
					if ($agentnovcomm->nov == 0) {//no commission in month
						//agent has no comm in month but has in year, customer yet to pay in year
					   $firstnovpayment = $this->customersetup_model->savefirstnovpayment($data);
					   $resultid = $firstnovpayment;
					}
					else {//agent has commision in month, customer yet to pay

						$data['newcomm'] = $agentnovcomm->nov + $data['agentcomm'];
						$firstnovpayment1 = $this->customersetup_model->savefirstnovpayment1($data);
						$resultid = $firstnovpayment1;
					}

				}
				else {
					//no agent comm in year,customer yet to pay in year
					$firstnovpayment2 = $this->customersetup_model->savefirstnovpayment2($data);
					$resultid = $firstnovpayment2;
				}
			}
			else {
				//check if agent has gotten commission in year
				$agentcommyear = $this->customersetup_model->checkagentcomminyear($data);
				if ($agentcommyear) { //agent has comm in year
					//has commission in year,check month
					$agentdecembercomm = $this->customersetup_model->checkagentjancomm($data);

					$data['agentdecembercomm'] = $agentdecembercomm->agentcomm + $data['agentcomm'];
					$data['lawmadecembercomm'] = $agentdecembercomm->lawmacomm + $data['lawmacomm'];
					//$data['decembernetcomm'] = $agentdecembercomm->netcomm + $data['netcomm'];
					$data['collection'] = $agentdecembercomm->totalmonthcollection + $data['amount'];
					if ($agentdecembercomm->december == 0) {//no commission in month
						//agent has no comm in month but has in year, customer yet to pay in year
						$firstdecemberpayment = $this->customersetup_model->savefirstdecemberpayment($data);
						$resultid = $firstdecemberpayment;
					}
					else {//agent has commision in month, customer yet to pay

						$data['newcomm'] = $agentdecembercomm->december + $data['agentcomm'];
						$firstdecemberpayment1 = $this->customersetup_model->savefirstdecemberpayment1($data);
						$resultid = $firstdecemberpayment1;
					}

				}
				else {
					//no agent comm in year,customer yet to pay in year
					$firstdecemberpayment2 = $this->customersetup_model->savefirstdecemberpayment2($data);
					$resultid = $firstdecemberpayment2;
				}
			}
			//next month
		}

		//redirect
		$this->session->set_flashdata('success', 'Payment successfully added');
		return redirect(base_url()."customersetup/paymentsuccess/".$resultid);
	}

	//-----------------------------------------------

	public function invoicepage()
	{
		//get active sectors
		$activesectors = $this->customersetup_model->getactivesectors();
		$sectors = $activesectors['rows'];

		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('invoice/invoicepage_view', ['sectors' => $sectors]);
		$this->load->view('inc2/footer_view3');
	}

	//---------------------------------------------

	public function generateinvoice()
	{
		//$data
		if (!empty($_POST)) {
			$data = $this->input->post();
		}
		else {
			$id = $this->uri->segment(3);
			
			$data = array(
			        'id' => $id,
			        'sector' => '',
			        'street' => '',
			        'all' => '',
			        'houseno' => ''
					);	
		}
		
		//$data = $this->input->post();

		if (($data['all'] == '') && ($data['sector'] == '') && ($data['street'] == '') && ($data['houseno'] == '') && !isset($data['id'])) {
			$this->session->set_flashdata('msg', 'Select at least one field');
			return redirect('customersetup/invoicepage');
		}
		else {
			$search = '';

			//invoice for all customers
			if ($data['all'] == 'All') {
				$search = $this->customersetup_model->allinvoice($data);
			}

			//invoice by sectors
			elseif (($data['all'] == 'Selected') && ($data['sector'] != '') && ($data['street'] == ''))
			{
				$search = $this->customersetup_model->invoicebysector($data);
			}

			//invoice by streets
			elseif (($data['all'] == 'Selected') && ($data['sector'] != '') && ($data['street'] != '') && ($data['houseno'] == ''))
			{
				$search = $this->customersetup_model->invoicebystreet($data);
			}

			//invoice by house
			elseif (($data['all'] == 'Selected') && ($data['sector'] != '') && ($data['street'] != '') && ($data['houseno'] != ''))
			{
				$search = $this->customersetup_model->invoicebyhouseno($data);
			}

			//invoice individual customer
			else {
				$search = $this->customersetup_model->invoicebycustomerid($data);
			}

			if (!$search) {
				$this->session->set_flashdata('msg', 'No record found');
				return redirect('customersetup/invoicepage');
			}
			else {
				
				$data['month'] = date('m');
				$data['today'] = date('Y-m-d');

				$data['i'] = 0;
				$month = '';

				if ($data['month'] == '01') {
					$data['i'] = 1;
					$month = 'January';
				}
				elseif ($data['month'] == '02') {
					$data['i'] = 2;
					$month = 'February';
				}
				elseif ($data['month'] == '03') {
					$data['i'] = 3;
					$month = 'March';
				}
				elseif ($data['month'] == '04') {
					$data['i'] = 4;
					$month = 'April';
				}
				elseif ($data['month'] == '05') {
					$data['i'] = 5;
					$month = 'May';
				}
				elseif ($data['month'] == '06') {
					$data['i'] = 6;
					$month = 'June';
				}
				elseif ($data['month'] == '07') {
					$data['i'] = 7;
					$month = 'July';
				}
				elseif ($data['month'] == '08') {
					$data['i'] = 8;
					$month = 'August';
				}
				elseif ($data['month'] == '09') {
					$data['i'] = 9;
					$month = 'September';
				}
				elseif ($data['month'] == '10') {
					$data['i'] = 10;
					$month = 'October';
				}
				elseif ($data['month'] == '11') {
					$data['i'] = 11;
					$month = 'November';
				}
				else {
					$data['i'] = 12;
					$month = 'December';
				}
				$data['monthx'] = $month;
				
				$customers = $search['rows'];
				//$count = $search['num'];

				foreach ($customers as $row) {
					$data['debt'] = $row->debt;
					$data['wallet'] = $row->wallet;
					$data['rdebt'] = $row->debt;
					$data['rwallet'] = $row->wallet;
					
					//last invoice generate date
					/*$invoicedate = DateTime::createFromFormat("Y-m-d", $row->lastinvoicegeneratedate);
					$invoiceyr = $invoicedate->format("Y");
					$invoicemnt = $invoicedate->format("m");
					$invoiceday = $invoicedate->format("d");*/

					$parts = explode("-", $row->lastinvoicegeneratedate);
					$invoicemnt = $parts[1];
					//$castmnt = (int)$invoicemnt;
					$invoiceday = $parts[2];
					$invoiceyr = $parts[0];

					//get current date
					$currentyr = date('Y');
					$currentday = date('d');

					if ($invoiceyr != '0000') { // invoice has been generated for customer before
						if ($currentyr == $invoiceyr) {//invoice has been generated in current year
							if ($data['i'] > (int)$invoicemnt) {
								$outstandingmnt = $data['month'] - $invoicemnt;
								$topay = $row->monthlycharge * $outstandingmnt;

								if ($data['wallet'] > 0) {
									if ($data['wallet'] >= $topay) {
										$data['wallet'] = $row->wallet - $topay;
									}
									else {
										$data['debt'] = $topay - $row->wallet;
									}
								}
								else {
									$data['debt'] = $row->debt + $topay;
								}
							}
						}
						else { //invoice is yet to be generated in current year

							$x = 12 - $invoicemnt;
							$y = $currentyr - ($invoiceyr + 1);
							$outstandingmnt = ($y * 12) + $x + $data['month'];
							$topay = $row->monthlycharge * $outstandingmnt;

							if ($data['wallet'] > 0) {
								if ($data['wallet'] >= $topay) {
									$data['wallet'] = $row->wallet - $topay;
								}
								else {
									$data['debt'] = $topay - $row->wallet;
								}
							}
							else {
								$data['debt'] = $row->debt + $topay;
							}
						}
					}

					else { // no invoice has been generated for customer
						//get year from date customer was created
						/*$createdate = DateTime::createFromFormat("Y-m-d", $row->customerentrydate);
						$yearcreated = $createdate->format("Y");
						$mntcreated = $createdate->format("m");
						$daycreated = $createdate->format("d");*/

						$split = explode("-", $row->customerentrydate);
						$mntcreated = $split[1];
						$daycreated = $split[2];
						$yearcreated = $split[0];

						$yr = $currentyr - ($yearcreated + 1);
						$yr = $yr * 12;

						$outstandingmnt = 12 - $mntcreated;
						$outstandingmnt = $outstandingmnt + $data['month'] + $yr;

						$topay = 0;

						if ((int)$daycreated > 10) {
							
							$partday = $row->monthlycharge * $daycreated;
							$partday = $partday/30;

							$topay = ($outstandingmnt * $row->monthlycharge) + $partday;
						}
						else {
							$topay = $outstandingmnt * $row->monthlycharge;
						}

						if ($data['wallet'] > 0) {
							if ($data['wallet'] >= $topay) {
								$data['wallet'] = $row->wallet - $topay;
							}
							else {
								$data['debt'] = $topay - $row->wallet;
							}
						}
						else {
							$data['debt'] = $row->debt + $topay;
						}
					}

					$data['customerid'] = $row->customerid;

					//$now = date('d/m/Y');
					//$dd = date('d');
					//$year = date('Y');
					$conc = $currentday . '-' . $data['month'] . '-' . $currentyr;
					$date = date_create($conc);
					$interval = date_interval_create_from_date_string('7 days');
	   				$res = date_add($date, $interval);   
	   				$data['dateplus7'] = date_format( $res, "d-m-Y");
	   				$data['year'] = $currentyr;
	   				$data['todayx'] = date('d-m-Y');
	   				$data['sectorid'] = $row->sectorid;
	   				$data['sectorname'] = $row->sectorname;
	   				$data['status'] = $row->status;
	   				$data['streetid'] = $row->streetid;
	   				$data['houseid'] = $row->houseid;
	   				$data['customertype'] = $row->customertype;
	   				$data['name'] = $row->name;
	   				$data['customercode'] = $row->customercode;
	   				$data['monthlycharge'] = $row->monthlycharge;
	   				$data['lastpaymentdate'] = $row->lastpaymentdate;
	   				$data['lastpayment'] = $row->lastpayment;
	   				$data['username'] = $this->session->userdata('fullname');
	   				$data['address'] = $row->houseno . ', ' . $row->streetname. ', ' . $row->areaname . ', Lagos State.';

	   				

	   				//check invoice table
	   				$chkinvoice = $this->customersetup_model->checkinvoicetable($data);

					if ($chkinvoice) {
						if ($chkinvoice->invoiceyear == $data['year']) { //same yr update only mnt
							if ($chkinvoice->invoicemonth != $data['monthx']) {
								//update customer record
								$account = $this->customersetup_model->updatecustomeraccount($data);

								$addinvoice = $this->customersetup_model->addnewinvoice1($data);
							}
						}
						else { //difft yr update yr & mnt
							//update customer record
							$account = $this->customersetup_model->updatecustomeraccount($data);

							$addinvoice = $this->customersetup_model->addnewinvoice1($data);
						}
					}
					else { //no customer record in invoice table
						//update customer record
						$account = $this->customersetup_model->updatecustomeraccount($data);

						//insert invoice table
						$addinvoice = $this->customersetup_model->addnewinvoice($data);
					}
					
				}// end foreach

				//select all customers owing
				//$invoice = $this->customersetup_model->customerinvoicelist();

				//----------------------------

				$invoice = '';
				//select all customers owing
				if ($data['all'] == 'All') {
					$invoice = $this->customersetup_model->allcustomerinvoicelist();
				}

				//select customers owing in sector
				elseif (($data['sector'] != '') && ($data['street'] == ''))
				{
					$invoice = $this->customersetup_model->customerinvoicebysector($data);
				}

				//select customers owing in street
				elseif (($data['street'] != '') && ($data['houseno'] == ''))
				{
					$invoice = $this->customersetup_model->customerinvoicebystreet($data);
				}

				//select customers owing in house
				elseif (($data['all'] == 'Selected') && ($data['sector'] != '') && ($data['street'] != '') && ($data['houseno'] != ''))
				{
					$invoice = $this->customersetup_model->customerinvoicebyhouse($data);
				}
				//select individual customers owing
				else {
					$invoice = $this->customersetup_model->singlecustomerinvoice($data);
				}

				/*$config = array();
				$config['source_image'] = '/assets/images/opendoorlogo.jpg';
				$config['wm_text'] = 'Open Door Systems International Ltd';
				$config['wm_type'] = 'text';
				$config['wm_font_path'] = './system/fonts/texb.ttf';
				$config['wm_font_size'] = '16';
				$config['wm_font_color'] = '000';
				$config['wm_vrt_alignment'] = 'middle';
				$config['wm_hor_alignment'] = 'center';
				$config['wm_padding'] = '20';

				$this->load->library('image_lib', $config);      
				$this->image_lib->initialize($config);                       
				$this->image_lib->watermark();*/

				//------------------
				$num = $invoice['num'];
				$records = $invoice['rows'];
				
				$this->load->view('inc/header_view1');
				//$this->load->view('inc/sidebar_view');
				$this->load->view('invoice/printinvoice_view', ['rows' => $records, 'num' => $num]);
				$this->load->view('inc/footer_view');
			}
		}
	}

	//----------------------------------------------

	public function payrecord()
	{
		$customerid = $_GET['id'];

		//get customer payment records
		$payments = $this->customersetup_model->getpaymentrecords($customerid);

		if (!$payments) {
			$this->session->set_flashdata('msg', 'No payment record');
			return redirect('customersetup/viewcustomers');
		}
		else {

			//get customername
			$customername = $this->customersetup_model->getsinglecustomer($customerid);

			$name = $customername->name;

			$results = $payments['rows'];
			//$num = $payments['num'];

			//load view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('customer/customerpayrecord_view', ['rows' => $results, 'name' => $name]);
			$this->load->view('inc/footer_view');
		}
	}

	//----------------------------------------------

	public function singlecustomerinvoice()
	{
		$id = $_GET['id'];

		/*$payments = $this->customersetup_model->checkcustomerdebt($id);

		if (!$payments) {
			$this->session->set_flashdata('msg', 'Customer is not owing');
			return redirect('customersetup/viewcustomers');
		}
		else {
			return redirect(base_url()."customersetup/generateinvoice/".$id);
		}*/

		return redirect(base_url()."customersetup/generateinvoice/".$id);
	}

	//-----------------------------------

	public function singlecustomer()
	{
		$customerid = $_GET['id'];

		//select customer details
		$customer = $this->customersetup_model->getsinglecustomer($customerid);

		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('customer/singlecustomer_view', ['row' => $customer]);
		$this->load->view('inc/footer_view');

	}

	//------------------------------------------

	public function paymentsuccess()
	{
		$id = $this->uri->segment(3);

		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('payments/paymentsuccess_view', ['id' => $id]);
		$this->load->view('inc/footer_view');
	}

	//-----------------------------------------------

	public function printreceipt()
	{
		$paymentid = $_GET['id'];

		//select payment details
		$paydetails = $this->customersetup_model->getpaymentdetails($paymentid);

		$customerid = $paydetails->customerid;

		//get customer details
		$customer = $this->customersetup_model->getsinglecustomer($customerid);
		$now = date('d/m/Y');

		$address = $customer->houseno . ', ' . $customer->streetname . ', ' . $customer->areaname . ', Lagos State.';

		$this->load->library('MyLibrary');
		$amountinwords = $this->mylibrary->convert_number($paydetails->amount) . ' ' . 'Naira';

		$data = array(
			        'name' => $paydetails->customername,
			        'address' => $address,
			        'date' => $paydetails->entrancedate,
			        'receiptno' => $paymentid,
			        'amount' => $paydetails->amount,
			        'purpose' => $paydetails->narration,
			        'debt' => $customer->debt,
			        'wallet' => $customer->wallet,
			        'amountinwords' => $amountinwords,
			        'tel' => $customer->telno
					);

		$this->load->view('inc/header_view');
		//$this->load->view('inc/sidebar_view');
		$this->load->view('payments/printreceipt_view', ['data' => $data]);
		$this->load->view('inc/footer_view');
	}

	//----------------------------------------------

	public function areahome()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('home/index');
		}
		else {

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('area/areapage_view');
			$this->load->view('inc/footer_view');
		}
	}

	//---------------------------------------------------

	public function addarea()
	{
		//set validation rules
		$this->form_validation->set_rules('area', 'Sector Area', 'trim|required');

		if ($this->form_validation->run()) {
			$areaname = $this->input->post('area');

			//check if areaname exists
			$chkarea = $this->customersetup_model->checkarea($areaname);

			if ($chkarea) {
				$this->session->set_flashdata('msg', 'Area already exists');
				return redirect('customersetup/areahome');
			}
			else {
				$addarea = $this->customersetup_model->addnewarea($areaname);

				if ($addarea) {
					$this->session->set_flashdata('success', 'Area added');
					return redirect('customersetup/areahome');
				}
			}
		}
		else {
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('area/areapage_view');
			$this->load->view('inc/footer_view');
		}
	}

	//----------------------------------------------------

	public function viewareas()
	{
		$areas = $this->customersetup_model->getAreas();

		if (!$areas) {
			$this->session->set_flashdata('msg', 'No record found');
			return redirect('home/index');
		}
		else {
			$records = $areas['rows'];
			//$num = $users['num'];
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('area/viewareas_view', ['records' => $records]);
			$this->load->view('inc2/footer_view5');
		}
	}

	//----------------------------------------------------

	public function editarea()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('customersetup/viewareas');
		}
		else {

			if(isset($_GET['id'])) {
            $id = $_GET['id'];

	        }
	        else {
	        	$id = $this->uri->segment(3);
	        }

	        $areaid = $id;
			$area = $this->customersetup_model->getsinglearea($areaid);

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('area/editarea_view', ['area' => $area]);
			$this->load->view('inc/footer_view');
		}
	}

	//-------------------------------------------------------

	public function updatearea()
	{
		// get hidden form field
    	$id = $this->input->post('id');

    	//set validation rules
		$this->form_validation->set_rules('area', 'Sector area', 'required|trim');

		if ($this->form_validation->run()) {
			$data = $this->input->post();
			/*$now = date('Y-m-d');
			$temp = date('Y-m-d H:i:s');
			$data['modifydate'] = $now;

			$fullname = $this->session->userdata('fullname');
			$data['modifiedby'] = $fullname;

			$agentid = $data['agent'];
			$agent = $this->customersetup_model->getsingleagent($agentid);
			$data['agentname'] = $agent->fname . ' ' . $agent->lname;*/

			//check area
			$chkarea = $this->customersetup_model->checkareabyid($data);

			//check if sector name exists
			if ($chkarea) {
				$this->session->set_flashdata('msg','Area name exists');
				return redirect(base_url()."customersetup/editarea/".$id);
			}
			else {
				$updarea = $this->customersetup_model->updatearea($data);

				if ($updarea) {
					$this->session->set_flashdata('success','Area name updated');
					return redirect(base_url()."customersetup/editarea/".$id);
				}
				else {
					$this->session->set_flashdata('msg','Error updating area');
					return redirect(base_url()."customersetup/editarea/".$id);
				}
			}
		}
		else {
			$this->session->set_flashdata('msg','Area name is required');

			$areaid = $id;
			$area = $this->customersetup_model->getsinglearea($areaid);
			
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('area/editarea_view', ['area' => $area]);
			$this->load->view('inc/footer_view');
		}
	}

	//--------------------------------------------------

	public function addpaymentbycode()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('home/index');
		}
		else {
		
			//load view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('payments/addpaymentbycode_view');
			$this->load->view('inc2/footer_view2');
		}
	}

	//----------------------------------------------------

	public function getcustomerdetails()
	{
		//validate input
		$this->form_validation->set_rules('code', 'Customer code', 'required');

		if ($this->form_validation->run()) {
			$code = $this->input->post('code');

			//get customer record
			$customer = $this->customersetup_model->getsinglecustomerbycode($code);

			if (!$customer) {
				$this->session->set_flashdata('msg', 'No record found');
				return redirect('customersetup/addpaymentbycode');
			}
			else {

				$this->load->view('inc/header_view');
				$this->load->view('inc/sidebar_view');
				$this->load->view('payments/addpaymentdetailsbycode_view', ['customer' => $customer]);
				$this->load->view('inc2/footer_view2');
			}
		}
		else {
			//load view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('payments/addpaymentbycode_view');
			$this->load->view('inc2/footer_view2');
		}
	}

	//------------------------------------------------

	public function confirmpaymentcode()
	{
		$code = $this->input->post('xcode');

		//set validation rules
		$this->form_validation->set_rules('months', 'Number of months', 'required');
		$this->form_validation->set_rules('paymentdate', 'Payment date', 'required');
		$this->form_validation->set_rules('amount', 'amount', 'required');
		$this->form_validation->set_rules('desc', 'Payment narration', 'required');
		$this->form_validation->set_rules('paymode', 'Payment mode', 'required');

		if ($this->form_validation->run()) {
			$data = $this->input->post();

			$data['paymentdate'] = strtotime($data['paymentdate']);
			$data['paymentdate'] = date('Y-m-d', $data['paymentdate']);

			$customerid = $data['customerid'];
			$customer = $this->customersetup_model->getsinglecustomer($customerid);
			$data['customername'] = $customer->name;
			$data['customercode'] = $customer->customercode;
			$data['sectorname'] = $customer->sectorname;
			$data['streetname'] = $customer->streetname;
			$data['house'] = $customer->houseno;

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('payments/confirmpayment_view', ['data' => $data]);
			$this->load->view('inc2/footer_view2');
		}
		else {
			//get customer record
			$customer = $this->customersetup_model->getsinglecustomerbycode($code);

			//load view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('payments/addpaymentdetailsbycode_view', ['customer' => $customer]);
			$this->load->view('inc2/footer_view2');
		}
	}

	//-------------------------------------------
}