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

	//
	function userAdd(){
		if($_POST){
			$data['username'] = trim($this->input->post('username'));
			$password = trim($this->input->post('password'));
			$password_confirm = trim($this->input->post('password_confirm'));

			if($password != $password_confirm){
				$data['error'] = '密码与确认密码错误！';
				$data['jumpUrl'] = site_url('/User/userAdd');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
				$data['password'] = md5($password);

				if($this->Public_model->insert($this->user,$data)){
					$data['message'] = '操作成功！';
					$data['jumpUrl'] = site_url('/User/index');
					$data['waitSecond'] = '3';
					$this->load->view('Public_jump.html',$data);
				}else{
					$data['error'] = '操作失败！';
					$data['jumpUrl'] = site_url('/User/index');
					$data['waitSecond'] = '3';
					$this->load->view('Public_jump.html',$data);
				}
			}
		}else{

			$data['menu'] = 'User';
			$data['title'] = "新增用户";
			$this->load->view('User_add.html',$data);
		}
	}

	//编辑用户
	function userEdit(){
		if($_POST){
			$password = trim($this->input->post('password'));
			$password_confirm = trim($this->input->post('password_confirm'));
			$arr['id'] = trim($this->input->post('id'));

			if($password != $password_confirm){
				$data['error'] = '密码与确认密码错误！';
				$data['jumpUrl'] = site_url('/User/userEdit/'.$arr['id']);
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
				$arr['password'] = md5($password);

				if($this->Public_model->edit($this->user,'id',$arr['id'],$arr)){
					$data['message'] = '操作成功！';
					$data['jumpUrl'] = site_url('/User/index');
					$data['waitSecond'] = '3';
					$this->load->view('Public_jump.html',$data);
				}else{
					$data['error'] = '操作失败！';
					$data['jumpUrl'] = site_url('/User/index');
					$data['waitSecond'] = '3';
					$this->load->view('Public_jump.html',$data);
				}

			}
		}else{
			$id = intval($this->uri->segment(3));
			if($id == '0'){
				$data['error'] = '请求错误！';
				$data['jumpUrl'] = site_url('/Post/index');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
				//获取文章详情
				$data['the_user'] = $this->Public_model->select_info($this->user,'id',$id);
				$data['menu'] = 'User';
				$data['title'] = "编辑用户";
				$this->load->view('User_edit.html',$data);
			}
		}
	}

	//删除用户
	function delete(){
		$id = intval($this->uri->segment(3));

		if($id == '0'){
			$data['error'] = '请求错误！';
			$data['jumpUrl'] = site_url('/User/index');
			$data['waitSecond'] = '3';
			$this->load->view('Public_jump.html',$data);
		}else{
			if($id == '1'){
				$data['error'] = '不能删除CMS建立账户！';
				$data['jumpUrl'] = site_url('/User/index');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
				if($this->Public_model->delete($this->user,'id',$id)){
					$data['message'] = '操作成功！';
					$data['jumpUrl'] = site_url('/User/index');
					$data['waitSecond'] = '3';
					$this->load->view('Public_jump.html',$data);
				}else{
					$data['error'] = '操作失败！';
					$data['jumpUrl'] = site_url('/User/index');
					$data['waitSecond'] = '3';
					$this->load->view('Public_jump.html',$data);
				}
			}
		}
	}




}








 ?>