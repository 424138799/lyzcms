<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Public_Controller.php');

/**
* 
*/
class User extends Public_Controller
{
	public $user = "i_user";
	
	function __construct()
	{
		parent::__construct();
	}

	function index(){

		//获取所有用户
		$data['users'] = $this->Public_model->select($this->user,'id','desc');

		$data['menu'] = 'User';
		$data['title'] = "后台用户管理";
		$this->load->view('User_index.html',$data);

	}




}








 ?>