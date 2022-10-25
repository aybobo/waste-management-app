<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assets extends CI_Controller {

	//--------------------------------------------
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('username'))
			redirect('admin/index');
		$this->load->model('assets_model');
	}

	//--------------------------------------

	public function assetcategory()
	{
		//get all categories
		/*$assetcat = $this->assets_model->getassetcategories();
		$records = $assetcat['rows'];
		$num = $assetcat['num'];*/
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('home/index');
		}
		else {
			//load view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('assets/assetcategory_view');
			$this->load->view('inc/footer_view');
			//
		}
	}

	//---------------------------------------

	public function addassetcategory()
	{
		//set validation rules
		$this->form_validation->set_rules('catname', 'Asset Category', 'required');

		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$now = date('Y-m-d');
			$data['createdate'] = $now;

			$fullname = $this->session->userdata('fullname');
			$data['createdby'] = $fullname;

			//check if asset category exists
			$chkassetcat = $this->assets_model->checkassetcategories($data);

			if ($chkassetcat) {
				$this->session->set_flashdata('msg', 'Asset category already exists');
				return redirect('assets/assetcategory');
			}
			else {
				//save to db
				$newcat = $this->assets_model->addassetcategory($data);

				if ($newcat) {
					$this->session->set_flashdata('success', 'Asset category added');
					return redirect('assets/assetcategory');
				}
			}
			
		}
		else {
			//get all categories
			/*$assetcat = $this->assets_model->getassetcategories();
			$records = $assetcat['rows'];
			$num = $assetcat['num'];*/

			//load view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('assets/assetcategory_view');
			$this->load->view('inc/footer_view');
		}
	}

	//--------------------------------------

	public function viewassetcategory()
	{
		$assetcat = $this->assets_model->getassetcategories();

		if (!$assetcat) {
			$this->session->set_flashdata('msg', 'No record found');
			return redirect('home/index');
		}
		else {
			$records = $assetcat['rows'];
			//$num = $users['num'];
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('assets/viewassetcategory_view', ['records' => $records]);
			$this->load->view('inc2/footer_view5');
		}
		
	}

	//-------------------------------------

	public function editassetcategory()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('assets/viewassetcategory');
		}
		else {
			if(isset($_GET['id'])) {
            $id = $_GET['id'];

	        }
	        else {
	        	$id = $this->uri->segment(3);
	        }

	        $catid = $id;
			$category = $this->assets_model->getsingleassetcategory($catid);

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('assets/editassetcategory_view', ['category' => $category]);
			$this->load->view('inc/footer_view');
		}
	}

	//-----------------------------------

	public function updateassetcategory()
	{
		// get hidden form field
    	$id = $this->input->post('id');

    	//set validation rules
		$this->form_validation->set_rules('catname', 'Asset Category', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');

		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$now = date('Y-m-d');
			$data['modifydate'] = $now;

			$fullname = $this->session->userdata('fullname');
			$data['modfiedby'] = $fullname;

			//check sector
			$chkassetcat = $this->assets_model->checkassetcategories($data);

			//check if sector name exists
			if ($chkassetcat) {
				if ($data['catname'] != $data['oldname']) {
					$this->session->set_flashdata('msg','Asset category name exists');
					return redirect(base_url()."assets/editassetcategory/".$id);
				}
				else {
					$updtcat = $this->assets_model->updateassetcategory($data);
					if ($updtcat) {
					$this->session->set_flashdata('success','Asset category updated');
					return redirect(base_url()."assets/editassetcategory/".$id);
					}
				}
			}
			else {
				$updcat = $this->assets_model->updateassetcategory($data);

				if ($updcat) {
					$this->session->set_flashdata('success','Asset category updated');
					return redirect(base_url()."assets/editassetcategory/".$id);
				}
			}
		}
		else {
			$catid = $id;
			$category = $this->assets_model->getsingleassetcategory($catid);

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('assets/editassetcategory_view', ['category' => $category]);
			$this->load->view('inc/footer_view');
		}
	}

	//-------------------------------------

	public function assetindex()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('home/index');
		}
		else {
			//get asset categories
			$activecats = $this->assets_model->getactiveassetcategories();
			$cats = $activecats['rows'];

			//get assets
			/*$assets = $this->assets_model->getassets();
			$records = $assets['rows'];
			$num = $assets['num'];*/

			//load view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('assets/assetindex_view', ['cats' => $cats]);
			$this->load->view('inc/footer_view');
			//
		}
	}

	//--------------------------------------

	public function addassets()
	{
		//set validation rules
		$this->form_validation->set_rules('catname', 'Asset category name', 'required');
		$this->form_validation->set_rules('asset', 'Asset', 'required');
		$this->form_validation->set_rules('qty', 'Quantity', 'numeric');
		$this->form_validation->set_rules('desc', 'Asset Description', 'required');
		$this->form_validation->set_rules('assetval', 'Asset Value', 'required|numeric');
		$this->form_validation->set_rules('purchasedate', 'Date of purchase', 'required');

		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$now = date('Y-m-d');
			$data['createdate'] = $now;

			$fullname = $this->session->userdata('fullname');
			$data['createdby'] = $fullname;

			$data['purchasedate'] = strtotime($data['purchasedate']);
			$data['purchasedate'] = date('Y-m-d', $data['purchasedate']);

			//get asset category name
			$catid = $data['catname'];
			$category = $this->assets_model->getsingleassetcategory($catid);
			$data['categoryname'] = $category->categoryname;

			//check if asset name exists
			$chkasset = $this->assets_model->checkasset($data);

			if ($chkasset) {
				$this->session->set_flashdata('msg', 'Asset name already exists');
				return redirect('assets/assetindex');
			}
			else {
				$newasset = $this->assets_model->addasset($data);

				if ($newasset) {
					$this->session->set_flashdata('success', 'Asset Added');
					return redirect('assets/assetindex');
				}
			}
		}
		else {
			//get asset categories
			$activecats = $this->assets_model->getactiveassetcategories();
			$cats = $activecats['rows'];

			//get assets
			/*$assets = $this->assets_model->getassets();
			$records = $assets['rows'];
			$num = $assets['num'];*/

			//load view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('assets/assetindex_view', ['cats' => $cats]);
			$this->load->view('inc/footer_view');
		}
	}

	//---------------------------------------------

	public function viewassets()
	{
		$assets = $this->assets_model->getassets();

		if (!$assets) {
			$this->session->set_flashdata('msg', 'No record found');
			return redirect('home/index');
		}
		else {
			$records = $assets['rows'];
			//$num = $users['num'];
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('assets/viewassets_view', ['records' => $records]);
			$this->load->view('inc2/footer_view5');
		}
		
	}

	//--------------------------------------------

	public function editasset()
	{

		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('assets/viewassets');
		}
		else {
			if(isset($_GET['id'])) {
            $id = $_GET['id'];

	        }
	        else {
	        	$id = $this->uri->segment(3);
	        }

	        //get active asset categories
			$activecats = $this->assets_model->getotheractiveassetcategories($id);
			$cats = $activecats['rows'];

			//get single asset
	        $assetid = $id;
			$asset = $this->assets_model->getsingleasset($assetid);

			//return view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('assets/editasset_view', ['asset' => $asset, 'cats' => $cats]);
			$this->load->view('inc/footer_view');
		}
	}

	//----------------------------------------------

	public function updateasset()
	{
		// get hidden form field
    	$id = $this->input->post('id');

    	//set validation rules
		$this->form_validation->set_rules('catname', 'Asset category name', 'required');
		$this->form_validation->set_rules('asset', 'Asset', 'required');
		$this->form_validation->set_rules('qty', 'Quantity', 'required|numeric');
		$this->form_validation->set_rules('desc', 'Asset Description', 'required');
		$this->form_validation->set_rules('assetval', 'Asset Value', 'required|numeric');
		$this->form_validation->set_rules('purchasedate', 'Date of purchase', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');

		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$now = date('Y-m-d');
			$data['modifydate'] = $now;

			$fullname = $this->session->userdata('fullname');
			$data['modfiedby'] = $fullname;

			$data['purchasedate'] = strtotime($data['purchasedate']);
			$data['purchasedate'] = date('Y-m-d', $data['purchasedate']);

			//get asset category name
			$catid = $data['catname'];
			$category = $this->assets_model->getsingleassetcategory($catid);
			$data['categoryname'] = $category->categoryname;

			//check if asset name exists
			$chkasset = $this->assets_model->checkasset($data);

			if ($chkasset) {
				if ($data['oldname'] == $data['asset']) {
					$updtasset = $this->assets_model->updateasset($data);

					if ($updtasset) {
						$this->session->set_flashdata('success', 'Asset Updated');
						return redirect(base_url()."assets/editasset/".$id);
					}
				}
				else {
					$this->session->set_flashdata('msg', 'Asset already exists');
					return redirect(base_url()."assets/editasset/".$id);
				}
			}
			else {
				$updasset = $this->assets_model->updateasset($data);

				if ($updasset) {
					$this->session->set_flashdata('success', 'Asset Updated');
					return redirect(base_url()."assets/editasset/".$id);
				}
			}


		}
		else {
			//get active asset categories
			$activecats = $this->assets_model->getactiveassetcategories();
			$cats = $activecats['rows'];

			//get single asset
	        $assetid = $id;
			$asset = $this->assets_model->getsingleasset($assetid);

			//return view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('assets/editasset_view', ['asset' => $asset, 'cats' => $cats]);
			$this->load->view('inc/footer_view');
		}
	}

	//--------------------------------------------

	public function expensehome()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('home/index');
		}
		else {
			//get active assets
			$assets = $this->assets_model->getactiveassets();
			$rows = $assets['rows'];

			//get last 20 expense
			/*$expenses = $this->assets_model->getfewexpenses();
			$records = $expenses['rows'];
			$num = $expenses['num'];*/

			//load view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('expense/expense_view', ['rows' => $rows]);
			$this->load->view('inc/footer_view');
		}
	}

	//-----------------------------------

	public function confirmexpense()
	{
		//set validation rules
		$this->form_validation->set_rules('asset', 'Asset', 'required');
		$this->form_validation->set_rules('desc', 'Purpose', 'required');
		$this->form_validation->set_rules('amt', 'Expense amount', 'required|numeric');
		$this->form_validation->set_rules('expensedate', 'Expense date', 'required');

		if ($this->form_validation->run()) {
			$data = $this->input->post();
			/*$now = date('Y-m-d H:i:s');
			$data['createdate'] = $now;

			$fullname = $this->session->userdata('fullname');
			$data['createdby'] = $fullname;

			$data['expensedate'] = strtotime($data['expensedate']);
			$data['expensedate'] = date('Y-m-d', $data['expensedate']);*/

			//get asset name
			$assetname = '';
			if (!($data['asset'] == '' || $data['asset'] == 'Others')) {
				$assetid = $data['asset'];
				$asset = $this->assets_model->getsingleasset($assetid);
				$assetname = $asset->assetname;
			}

			if ($data['misc'] == '' && $data['asset'] == 'Others') {
				$this->session->set_flashdata('misc', 'Others field is empty');
				return redirect('assets/expensehome');
			}

			//load view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('expense/confirmexpense_view', ['data' => $data, 'asset' => $assetname]);
			$this->load->view('inc/footer_view');
		}
		else {
			//get active assets
			$assets = $this->assets_model->getactiveassets();
			$rows = $assets['rows'];

			//get last 20 expense
			/*$expenses = $this->assets_model->getfewexpenses();
			$records = $expenses['rows'];
			$num = $expenses['num'];*/

			//load view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('expense/expense_view', ['rows' => $row]);
			$this->load->view('inc/footer_view');
		}
	}

	//--------------------------------------

	public function saveexpense()
	{
		$data = $this->input->post();
		$now = date('Y-m-d');
		$data['createdate'] = $now;

		$fullname = $this->session->userdata('fullname');
		$data['createdby'] = $fullname;

		$data['expensedate'] = strtotime($data['expensedate']);
		$data['expensedate'] = date('Y-m-d', $data['expensedate']);

		//save expense to db
		$newexpense = $this->assets_model->addexpense($data);

		if ($newexpense) {
			$this->session->set_flashdata('success', 'Expense Added');
			return redirect('assets/expensehome');
		}

	}

	//----------------------------------------

	public function assetexpense()
	{
		$id = $_GET['id'];

		//get asset expense from expense table
		$expenses = $this->assets_model->assetexpense($id);
		if (!$expenses) {
			$this->session->set_flashdata('msg', 'Asset has no expense record');
			return redirect('assets/viewassets');
		}
		else {
			$assetid = $id;
			$asset = $this->assets_model->getsingleasset($assetid);
			$assetname = $asset->assetname;

			$records = $expenses['rows'];
			//$num = $expenses['num'];

			//load view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('expense/assetexpense_view', ['records' => $records, 'assetname' => $assetname]);
			$this->load->view('inc/footer_view');
		}
	}

	//-----------------------------------------

	public function viewexpense()
	{
		//get all expense
		$expenses = $this->assets_model->getallexpenses();

		if (!$expenses) {
			$this->session->set_flashdata('success', 'No expense record');
			return redirect('assets/assetindex');
		}
		else {
			$records = $expenses['rows'];
			//$num = $expenses['num'];

			//load view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('expense/allexpense_view', ['records' => $records]);
			$this->load->view('inc2/footer_view4');
		}
	}

	//--------------------------------------------

	public function addliability()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('home/index');
		}
		else {

			//load view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('liability/liability_view');
			$this->load->view('inc/footer_view');
		}
	}

	//--------------------------------------------

	public function saveliability()
	{
		//set validation rules
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('amt', 'Amount', 'required|numeric');
		$this->form_validation->set_rules('desc', 'Purpose', 'required');
		$this->form_validation->set_rules('type', 'Liability type', 'required');
		$this->form_validation->set_rules('date', 'Date', 'required');

		if ($this->form_validation->run()) {
			$data = $this->input->post();
			
			$data['enteredby'] = $this->session->userdata('fullname');
			$data['entrydate'] = date('Y-m-d');

			$data['action'] = 'Borrow';
			$data['status'] = 'Active';

			//check if liability name exists
			$chkliability = $this->assets_model->checkliability($data);

			if ($chkliability) {
				$this->session->set_flashdata('msg', 'Record already exists');
				return redirect('assets/addliability');
			}
			else {
				//save to db
				$newliability = $this->assets_model->saveliability($data);

				if ($data['type'] == 'Cash') { //save to cashbook
					$data['narration'] = $data['name'] . ' ,' . $data['desc'];
					$saveCashbook = $this->assets_model->saveToCashbook($data);
				}

				//if ($newliability) {
				$this->session->set_flashdata('success', 'Liability added');
				return redirect('assets/addliability');
				//}
			}	
		}
		else {
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('liability/liability_view');
			$this->load->view('inc/footer_view');
		}
	}

	//---------------------------------------------

	public function viewliabilities()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('home/index');
		}
		else {
			//get active assets
			$liabilities = $this->assets_model->getallliabilities();
			if (!$liabilities) {
				$this->session->set_flashdata('success', 'No record found');
				return redirect('home/index');
			}
			else {
				$rows = $liabilities['rows'];

				//load view
				$this->load->view('inc/header_view');
				$this->load->view('inc/sidebar_view');
				$this->load->view('liability/viewliabilities_view', ['rows' => $rows]);
				$this->load->view('inc2/footer_view4');
			}
		}
	}

	//-------------------------------------------

	public function editliability()
	{
		if(isset($_GET['id'])) {
        	$id = $_GET['id'];
        }
        else {
        	$id = $this->uri->segment(3);
        }

        $liabilityid = $id;

        //check if liability name exists
		$liability = $this->assets_model->getliability($liabilityid);

		//load view
		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('liability/editliability_view', ['liability' => $liability]);
		$this->load->view('inc/footer_view');
	}

	//-------------------------------------------

	public function saveliabilityupdate()
	{
		// get hidden form field
    	$id = $this->input->post('id');

		//set validation rules
		$this->form_validation->set_rules('amt', 'Amount', 'required|numeric');
		$this->form_validation->set_rules('action', 'Action', 'required');
		$this->form_validation->set_rules('date', 'Date', 'required');

		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$data['modifydate'] = date('Y-m-d');

			$data['modifiedby'] = $this->session->userdata('fullname');

			if ($data['action'] == 'Borrow' && $data['desc'] == '') {
				$this->session->set_flashdata('msg', 'Give a reason for the facility');
				return redirect(base_url()."assets/editliability/".$id);
			}

			if ($data['action'] == 'Paid' && $data['desc'] == '') {
				$data['desc'] = 'Paid';
			}

			//get liability details
			$liabilityid = $data['id'];
			$liability = $this->assets_model->getliability($liabilityid);
			$oldamount = $liability->amount;

			if (($data['action'] == 'Paid') && ($data['amt']  > $oldamount)) {
				$this->session->set_flashdata('msg', 'Amount paid more than facility ');
				return redirect(base_url()."assets/editliability/".$id);
			}

			$data['amountPaid'] = $data['amt'];

			$data['status'] = 'Active';
			if ($data['action'] == 'Borrow') {
				$data['amt'] += $oldamount;
			}
			else {
				$data['amt'] = $oldamount - $data['amt'];
				if ($data['amt'] == 0) {
					$data['status'] = 'Paid Off';
				}
			}
			
			//save update
			$updliability = $this->assets_model->saveliabilityupdate($data);

			$data['narration'] = $data['name'] . ' ,' . $data['desc'];

			if ($data['action'] == 'Borrow') { //credit cashbook
				$saveCashbook = $this->assets_model->saveToCashbook($data);
			}
			else { //debit cashbook
				$debit = $this->assets_model->debitCashbook($data);
			}

			//if ($updliability) {
			$this->session->set_flashdata('success', 'Liability updated');
			//return redirect(base_url()."assets/editliability/".$id);
			return redirect('assets/viewliabilities');
			//}
		}
		else {
			$liabilityid = $id;

	        //get liability details
			$liability = $this->assets_model->getliability($liabilityid);

			//load view
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('liability/editliability_view', ['liability' => $liability]);
			$this->load->view('inc/footer_view');
		}
	}

	//-------------------------------------------

	public function singleliability()
	{
		$liabilityid = $_GET['id'];

		//get liability details
		$liabilitydet = $this->assets_model->getliability($liabilityid);
		$name = $liabilitydet->name;

		//get liability trail
		$liability = $this->assets_model->getliabilitytrail($liabilityid);

		$rows = $liability['rows'];

		//load view
		$this->load->view('inc/header_view');
		$this->load->view('inc/sidebar_view');
		$this->load->view('liability/unitliability_view', ['rows' => $rows, 'name' => $name]);
		$this->load->view('inc2/footer_view4');
	}

	//----------------------------------------------

	public function deleteliability()
	{
		// get hidden form field
    	$id = $this->input->post('id');

		//delete liability
		$delliability = $this->assets_model->deleteliability($id);

		if ($delliability) {
			$this->session->set_flashdata('success', 'Liability deleted');
			return redirect('assets/viewliabilities');
		}
	}

	//--------------------------------------------
}