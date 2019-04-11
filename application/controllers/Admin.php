<?php


class Admin extends CI_Controller
{
	public function __construct(){			//this function always called when any of function below will be call
		parent::__construct();				
		$this->load->library('session');
		$this->load->helper('url');
		if(!isset($_SESSION['name']))			//check for login
			return redirect('login_signup');
	}

	public function index(){
		return redirect('admin/dashboard');
	}

	public function dashboard()
	{	
		$this->load->model('My_model','m_obj');
		$rows = $this->m_obj->fetch_articals_user('by_admin','abc@gmail.com');
		$this->load->view('admin_dashboard',['articals'=>$rows]);		//$rows access as $articals on view
	}

	public function add_artical()
	{
		$this->load->view('add_artical');		//$rows access as $articals on view
	}

	public function submit_artical()	//for adding end editing
	{
		$action = $this->input->post('action');
		$artical_id = $this->input->post('artical');	//valid in edit action
		$title = $this->input->post('title');
		$content = $this->input->post('content');
		$admin = $this->session->userdata('email');
		date_default_timezone_set('Asia/Kolkata');
		$date = date("d-M-Y");
		$this->load->model('My_model','m_obj');
		$this->m_obj->add_update_artical($action,$title,$content,$admin,$date,$artical_id);
		return redirect('admin/dashboard');
	}

	public function edit_artical()
	{	
		$artical_id = $this->input->get('artical');

		$this->load->model('My_model','m_obj');
		$rows = $this->m_obj->fetch_articals_user('by_artical_id','',$artical_id);
		$this->load->view('add_artical',['artical_id'=>$artical_id,'title'=>$rows[0]['title'],'content'=>$rows[0]['content']]);
		
	}

	public function delete_artical()
	{
		$artical_id = $this->input->get('artical');

		$this->load->model('My_model','m_obj');

		$this->m_obj->delete_artical($artical_id);
		return redirect('admin/dashboard');
	}
}