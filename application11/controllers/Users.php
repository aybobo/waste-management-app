<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	//--------------------------------------

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('username'))
			redirect('admin/index');
		$this->load->model('users_model');
	}

	//------ sector home page ---------

	public function userhome()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('home/index');
		}
		else {
			
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('users/userpage_view');
			$this->load->view('inc/footer_view');
		}
		
	}

	//--------- add new user ------------

	public function adduser()
	{
		//load file upload library
		$config['upload_path']          = './signatures/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 500000;
        $config['max_width']            = 12000;
        $config['max_height']           = 76800;

        $this->load->library('upload', $config);

		//set validation rules
		$this->form_validation->set_rules('fname', 'First Name', 'trim|required|alpha');
		$this->form_validation->set_rules('oname', 'Middle Name', 'trim|alpha');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|required|alpha');
		$this->form_validation->set_rules('role', 'User role', 'required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$now = date('Y-m-d');
			$data['createdate'] = $now;

			$data['filename'] = '';

			if (!$this->upload->do_upload('signature')) {
				//large image or wrong file type
				$this->session->set_flashdata('msg', 'Failed to upload: File too large or wrong filetype');
                return redirect('users/userhome');
			}
			else {
				$upload_data = $this->upload->data();
                $data['filename'] = $upload_data['file_name'];
			}

			$data['fname'] = ucfirst(strtolower($data['fname']));
			$data['oname'] = ucfirst(strtolower($data['oname']));
			$data['lname'] = ucfirst(strtolower($data['lname']));
			$data['email'] = strtolower($data['email']);

			//get name of user creating another user from session
			$fullname = $this->session->userdata('fullname');
			$data['createdby'] = $fullname;

			//check if user exists
			$user = $this->users_model->checkuser($data);

			//user exists
			if ($user) {
				$this->session->set_flashdata('msg', 'User with email already exists');
				return redirect('users/userhome');
			}

			//add user
			else {
				$newUser = $this->users_model->addUser($data);

				$username = $data['fname'] . ' ' . $data['oname'] . $data['lname'];

				if ($newUser) {

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
					$this->email->to($data['email']);

					$this->email->subject('WMA - Activate Account');

					$message = "<p>Hello " . $username . ", <br>
									 an account has been created for you on the Waste Management Application. Click the link below or copy and paste in your browser to activate your account.<br><br</p>";
				$message .= '<a href="http:opendoorwastemanagement.com/admin/setPassword/?id=' . $newUser. '">Click here to activate your account</a>';

					//$this->email->message('Testing the email class.');
					$this->email->message($message);

					if ($this->email->send()) {
						$this->session->set_flashdata('success', 'User Account Created');
					}
					//account created but mail not sent
					else {
						$this->session->set_flashdata('success', 'Account Created');
					}
					return redirect('users/userhome');
				}
			}
		}
		else {

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('users/userpage_view');
			$this->load->view('inc/footer_view');
		}
	}

	//---------------------------------------

	public function viewusers()
	{
		$users = $this->users_model->getUsers();

		if (!$users) {
			$this->session->set_flashdata('msg', 'No user record');
			return redirect('home/index');
		}
		else {
			$records = $users['rows'];
			//$num = $users['num'];
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('users/viewusers_view', ['records' => $records]);
			$this->load->view('inc2/footer_view5');
		}
		
	}

	//--------- edit user details ------------

	public function edituser()
	{
		if ($this->session->userdata('role') != 'Admin') {
			$this->session->set_flashdata('msg', 'Access Denied');
			return redirect('users/viewusers');
		}
		else {

			if(isset($_GET['id'])) {
            $id = $_GET['id'];

	        }
	        else {
	        	$id = $this->uri->segment(3);
	        }

			$user = $this->users_model->getSingleUser($id);

			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('users/edituser_view', ['user' => $user]);
			$this->load->view('inc/footer_view');
			//------
		}
		
	}

	//-------save user update----------------

	public function updateuser()
	{
		//load file upload library
		$config['upload_path']          = './signatures/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 500000;
        $config['max_width']            = 12000;
        $config['max_height']           = 76800;

        $this->load->library('upload', $config);

		// get hidden form field
    	$id = $this->input->post('id');
    	
    	//set validation rules
		$this->form_validation->set_rules('fname', 'First Name', 'trim|required|alpha');
		$this->form_validation->set_rules('mname', 'Middle Name', 'trim|alpha');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|required|alpha');
		$this->form_validation->set_rules('role', 'User role', 'required');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('status', 'Status', 'required');

		if ($this->form_validation->run()) {
			$data = $this->input->post();
			$now = date('Y-m-d');
			$data['modifydate'] = $now;

			if (!$this->upload->do_upload('signature')) {
				//large image or wrong file type
				$this->session->set_flashdata('msg', 'Failed to upload: File too large or wrong filetype');
                return redirect(base_url()."users/edituser/".$id);
			}
			else {
				$upload_data = $this->upload->data();
                $data['filename'] = $upload_data['file_name'];
			}

			$fullname = $this->session->userdata('fullname');
			$data['modfiedby'] = $fullname;

			//check user
			$user = $this->users_model->checkuser($data);

			//check if user with new email exists
			if ($user && $data['email'] != $data['oemail']) {
				$this->session->set_flashdata('msg','User with matching record exists');
				return redirect(base_url()."users/edituser/".$id);
			}
			else {
				$upduser = $this->users_model->updateuser($data);
				$username = $data['fname'] . ' ' . $data['oname'] . $data['lname'];

				if ($upduser) {
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
					
					$this->email->from('no-reply@wma.opendoorlimited', 'Admin');
					$this->email->to($data['email']);
					
					if ($data['email'] == $data['oemail']) {
						$this->email->subject('WMA - Activate Account');
						$message = "<p>Hello " . $username . ", <br>
									your WMA account was updated.<br></p>";
						$this->email->message($message);

						if ($this->email->send()) {
							$this->session->set_flashdata('success', 'Accountx updated');
						}
						else {
							$this->session->set_flashdata('success', 'Accountx updated!');
						}
					}
					else {
						$this->email->subject('WMA - Activate Account');
						$message = "<p>Hello " . $username . ", <br>
										 your WMA account was updated. Click the link below or copy and paste in your browser to set your password.<br><br></p>";
			$message .= '<a href="http:opendoorwastemanagement.com/admin/setPassword/?id=' . $id . '">Click here to set your password</a>';
						$this->email->message($message);

						if ($this->email->send()) {
							$this->session->set_flashdata('success', 'Account updated');
						}
						else {
							$this->session->set_flashdata('success', 'Account updated!');
						}
						//
					}
					return redirect(base_url()."users/edituser/".$id);
				}
			}
		}
		else {
			$this->session->set_flashdata('msg','Fill all compulsory field');
			
			$user = $this->users_model->getSingleUser($id);
			
			$this->load->view('inc/header_view');
			$this->load->view('inc/sidebar_view');
			$this->load->view('users/edituser_view', ['user' => $user]);
			$this->load->view('inc/footer_view');
		}	
	}

	//--------------------------------------------------

}