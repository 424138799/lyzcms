<?php 
/**
* 
*/
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Public_Controller.php');

class Home extends Public_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	function index(){
		$data['title'] = '欢迎登陆！';
		$data['menu'] = '';
		$this->load->view('Index_index.html',$data);
	}
}
 ?>








