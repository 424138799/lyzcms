<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Public_Controller.php');
/**
* 
*/
class Post extends Public_Controller
{
	public $news = "i_post";	
	function __construct()
	{
		parent::__construct();
	}


	function index(){

		$config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->uri->segment(3));//index.php 后数第4个/
        //配置
        $config['base_url'] = site_url('/Post/index');
        //分页配置

        $config['full_tag_open'] = '<ul class="pagination">';

        $config['full_tag_close'] = '</ul>';

        $config['first_tag_open'] = '<li>';

        $config['first_tag_close'] = '</li>';

        $config['prev_tag_open'] = '<li>';

        $config['prev_tag_close'] = '</li>';

        $config['next_tag_open'] = '<li>';

        $config['next_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a>';

        $config['cur_tag_close'] = '</a></li>';

        $config['last_tag_open'] = '<li>';

        $config['last_tag_close'] = '</li>';

        $config['num_tag_open'] = '<li>';

        $config['num_tag_close'] = '</li>';

        $config['first_link']= '首页';

        $config['next_link']= '»';

        $config['prev_link']= '«';

        $config['last_link']= '末页';
        $config['num_links'] = 4;
        
        $total = count($this->Public_model->select($this->news,'createtime','desc'));
        $config['total_rows'] = $total;
    
        $this->load->library('pagination');//加载ci pagination类
        $listpage =  $this->Public_model->select_page($this->news,$current_page,$config['per_page'],'createtime','desc');
        $this->pagination->initialize($config);
        //获取系统公告

        $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links(),'menu'=>'Post','title'=>'乐易装商学院');
		//获取我的公众号


		$this->load->view('Post_index.html',$data);
	}


	//新增
	function add(){
		if($_POST){
			$data = $this->input->post();
			$data['createtime'] = time();
			if($this->Public_model->insert($this->news,$data)){
				echo "<script>alert('操作成功！');window.location.href='".site_url('/Post/index')."'</script>";
			}else{
				echo "<script>alert('操作失败！');window.location.href='".site_url('/Post/index')."'</script>";
			}
		}else{
			$data['menu'] = 'Post';
			$data['title'] = "新增乐易装商学院文章";
			$this->load->view('Post_add.html',$data);
		}
	}
	//编辑
	function edit(){
		if($_POST){
			$data = $this->input->post();
			$data['updatetime'] = time();
			if($this->Public_model->edit($this->news,'id',$data['id'],$data)){
				$data['message'] = '操作成功！';
				$data['jumpUrl'] = site_url('/Post/index');
				$data['waitSecond'] = '3';
				$this->load->view('error.html',$data);
			}else{
				$data['error'] = '操作失败！';
				$data['jumpUrl'] = site_url('/Post/index');
				$data['waitSecond'] = '3';
				$this->load->view('error.html',$data);
			}
		}else{
			$id = intval($this->uri->segment('3'));
			if($id == '0'){
				$data['error'] = '请求错误！';
				$data['jumpUrl'] = site_url('/Post/index');
				$data['waitSecond'] = '3';
				$this->load->view('error.html',$data);
			}else{
				//获取文章详情
				$data['the_post'] = $this->Public_model->select_info($this->news,'id',$id);
				$data['menu'] = 'Post';
				$data['title'] = "编辑乐易装商学院文章";
				$this->load->view('Post_edit.html',$data);
			}
		}
	}

	//删除
	function delete(){
		$id = intval($this->uri->segment('3'));
		if($id == '0'){
			$data['error'] = '请求错误！';
			$data['jumpUrl'] = site_url('/Post/index');
			$data['waitSecond'] = '3';
			$this->load->view('error.html',$data);
		}else{
			if($this->Public_model->delete($this->news,"id",$id)){
				$data['message'] = '操作成功！';
				$data['jumpUrl'] = site_url('/Post/index');
				$data['waitSecond'] = '3';
				$this->load->view('error.html',$data);
			}else{
				$data['error'] = '操作失败！';
				$data['jumpUrl'] = site_url('/Post/index');
				$data['waitSecond'] = '3';
				$this->load->view('error.html',$data);
			}
			
		}
	}

}








 ?>