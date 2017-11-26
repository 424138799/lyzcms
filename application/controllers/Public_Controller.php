<?php 
session_start();

defined('BASEPATH') OR exit('No direct script access allowed');


/**
* 
*/
class Public_Controller extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		
		if(!isset($_SESSION['userInfo'])){
          echo "<script>alert('您还没有登陆！');window.location.href='".site_url('/Login/index')."';</script>";
          exit;
        }
	}
}



 ?>