<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public $member = "i_user";//用户
	function __construct(){
		parent::__construct();
	}


	public function index()
	{

		if($_POST){

			$username = trim($this->input->post('username'));
			$password = md5(trim($this->input->post('password')));

			//获取用户
			$user = $this->Public_model->select_info($this->member,'username',$username);

			if(!empty($user)){
				if($password != $user['password']){
					$data['title'] = '登陆';
					$data['error'] = '密码错误！';
					$this->load->view('Public_login.html',$data);
				}else{
					session_set_cookie_params('180000');
					session_start();
					$_SESSION['userInfo'] = $user;
					session_write_close();
					redirect('Home/index');
				}
			}else{
				$data['title'] = '登陆';
				$data['error'] = '用户不存在！';
				$this->load->view('Public_login.html',$data);	
			}


		}else{
			$data['title'] = '登陆';
			$this->load->view('Public_login.html',$data);		
		}

	}

	//注销
	function logout(){
		session_start();
		$_SESSION['userInfo'] = '';
		session_write_close();
		redirect('Login/index');

	}
}
