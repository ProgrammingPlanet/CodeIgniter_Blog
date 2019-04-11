<?php

class Login_signup extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
	}
	
	public function index(){
		if(isset($_SESSION['name']))
			return redirect('admin');
		$this->load->view('login',['login_error'=>$this->session->flashdata('login_error')]);
	}

	public function login_validate(){
		$email = $this->input->post('email');
		$password = md5($this->input->post('password'));
		$this->load->model('My_model','m_obj');	//second optional parameter is modal obj new name
		if($session_ = $this->m_obj->login($email,$password)){
			$this->session->set_userdata($session_);		//$session is an array containe name and email
			//print_r($_SESSION); exit;
			return redirect('admin/dashboard');
		}else{
			$this->session->set_flashdata(['login_error'=>'Email or Password Was Wrong.']);	//flashdata mean availble for next request only
			return redirect('Login_signup');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata(['name','email']); 	
		return redirect('admin');
	}
}