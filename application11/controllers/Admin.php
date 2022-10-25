<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	//---------------------------------------------------------------
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin_model');
	}

	//----login page------------------

	public function index()
	{
		//$this->load->view('home/index_view');
		$this->load->view('inc1/header_view');
		$this->load->view('inc1/login');
		$this->load->view('inc1/footer_view');
	}

	//--------- login user -------------

	public function login ()
	{

		//validate login details
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('pwd', 'Password', 'required');

		if($this->form_validation->run()) {
			$useremail = $this->input->post('email');
			$password = $this->input->post('pwd');
			$password = hash('sha256', $password . KEY);

			//check if user record exists in db
			$res = $this->admin_model->islogin($useremail, $password);
			
			if($res) {
		    	$status = $res->status;
		    	$fname = $res->fname;
		    	$userid = $res->userid;
		    	$role = $res->role;
		    	$fullname = $res->fname . ' ' . $res->oname . ' ' . $res->lname;

		    	//check if account has been deactivated
		    	if ($status == 'Inactive') {
		    	  $this->session->set_flashdata('msg','Account Suspended. Contact Admin');
					return redirect('admin/index');	
		    	}
					
					//set session variables
					$this->session->set_userdata('username', $fname); //first name
					$this->session->set_userdata('userId', $userid); //userId
					$this->session->set_userdata('role', $role); //user role
					$this->session->set_userdata('userEmail', $useremail); //email
					$this->session->set_userdata('fullname', $fullname); //fullname
					return redirect('home/index'); 
			}

			//Login failed
			else {
				$this->session->set_flashdata('msg','Invalid Email/Password');
				return redirect('admin/index'); 
			}
		}

		//validation fails, back to home page
		else {
			$this->session->set_flashdata('msg','Fill in your email and password');
			return redirect('admin/index'); 
		}
	}

	//------------logout --------------

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('admin/index');
	}

	//------------------------------------

	public function setPassword()
	{
		//$this->load->view('home/setpassword_view');
		$this->load->view('inc1/header_view');
		$this->load->view('inc1/setpassword_view');
		$this->load->view('inc1/footer_view');
	}

	//------------------------------------

	public function newPassword()
	{
		// get hidden form fields
    	$id = $this->input->post('id');

    	//validate user input
		$this->form_validation->set_rules('pwd', 'Password', 'required');
		$this->form_validation->set_rules('confirm-pwd', 'Confirm Password', 'matches[pwd]|required');

		if($this->form_validation->run()) {
			$info = $this->input->post();
			$info['pwd'] = hash('sha256', $info['pwd'] . KEY);
			$info['key'] = 5;
			$chkUsr = $this->admin_model->getSingleUser($id);

			if ($info['key'] == $chkUsr->num) {
				$this->session->set_flashdata('msg','Link already used');
				return redirect('admin/setPassword');
			}
			else {
				$setpwd = $this->admin_model->setpassword($info);

				if ($setpwd) {
					$this->session->set_flashdata('success', 'Account Activated');
					return redirect('admin/index');
				}
			}
		}
		else {
			$this->load->view('inc1/setPassword_view', ['id' => $id]);
		}
	}

	//---------------------------------------

	public function forgotpassword()
	{
		//$this->load->view('home/forgotpassword_view');
		$this->load->view('inc1/header_view');
		$this->load->view('inc1/forgotpassword_view');
		$this->load->view('inc1/footer_view');
	}

	//----------------------------------------

		public function sendpwdresetlink()
		{
		//validate login details
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		if($this->form_validation->run()) {
			$email = $this->input->post('email');
			$chkemail = $this->admin_model->checkEmail($email);
			
			if (!$chkemail) {
				$this->session->set_flashdata('msg','No account with such email');
			}
			else {
				$now = date('Y-m-d H:i:s');
				$token = $email . $now;
				$token = hash('sha256', $token . KEY);
				$num = 4;
				$saveToken = $this->admin_model->updateToken($email, $token, $num);

				if ($saveToken) {
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
					$this->email->from('no-reply@opendoorwastemanagement.com');
					$this->email->to($email);
					$this->email->subject('Password Reset');

					$message = "Click the link below or copy and paste in your browser to reset your password
								<br><br></p>";
	$message .= '<a href="http:opendoorwastemanagement.com/admin/resetPassword/?token=' . $token . '">Click here to reset your password</a>';

					$this->email->message($message);

					if($this->email->send()) {
						$this->session->set_flashdata('success', 'Check your email for password reset link');
					}

					else {
						$this->session->set_flashdata('msg', 'Failed to send password reset link');
					}
				}
				else {
					$this->session->set_flashdata('msg','Error saving to database');
				}
			}
			return redirect('admin/forgotpassword');
		}// validation
		else {
			$this->load->view('inc1/header_view');
			$this->load->view('inc1/forgotpassword_view');
			$this->load->view('inc1/footer_view');
		}
	}

	//-------------------------------------------

	public function resetPassword()
	{
		//$this->load->view('home/resetPassword_view');
		$this->load->view('inc1/header_view');
		$this->load->view('inc1/resetPassword_view');
		$this->load->view('inc1/footer_view');
	}

	//----------------------------------------

		public function updatePassword()
		{
		//get hidden form field values
		$token = $this->input->post('token');

		//validate user input
		$this->form_validation->set_rules('pwd', 'Password', 'required');
		$this->form_validation->set_rules('confirm-pwd', 'Password2', 'matches[pwd]|required');

		if($this->form_validation->run()) {
			$data = $this->input->post();
			$data['pwd']= hash('sha256', $data['pwd'] . KEY);
			$data['num'] = 10;

			$verifyToken = $this->admin_model->verifyToken($data);

			if ($verifyToken->token != $data['token']) {
				$this->session->set_flashdata('msg', 'Unable to reset password');
				return redirect('admin/resetPassword');
			}
			elseif ($verifyToken->num == $data['num']) {
				$this->session->set_flashdata('msg', 'Link has been used');
				return redirect('admin/resetPassword');
			}
			else {
				$updPassword = $this->admin_model->updatePassword($data);

				if($updPassword) {
					$this->session->set_flashdata('success', 'Password reset succesful');
					return redirect('admin/index');
				}
				else {
					$this->session->set_flashdata('msg', 'Unable to reset password');
					return redirect('admin/resetPassword');
				}
			}
		}
		else {
			$this->load->view('inc1/resetPassword_view', ['token' => $token]);
		}
	}

	//----------------------------------------------

}