<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Public_Controller.php');
/**
* 
*/
class Post extends Public_Controller
{
	public $news = "i_post";	
	public $banner = "i_banner";	
	public $slogan = "i_slogan";	
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
				$this->load->view('Public_jump.html',$data);
			}else{
				$data['error'] = '操作失败！';
				$data['jumpUrl'] = site_url('/Post/index');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}
		}else{
			$id = intval($this->uri->segment('3'));
			if($id == '0'){
				$data['error'] = '请求错误！';
				$data['jumpUrl'] = site_url('/Post/index');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
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
			$this->load->view('Public_jump.html',$data);
		}else{
			if($this->Public_model->delete($this->news,"id",$id)){
				$data['message'] = '操作成功！';
				$data['jumpUrl'] = site_url('/Post/index');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
				$data['error'] = '操作失败！';
				$data['jumpUrl'] = site_url('/Post/index');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}
			
		}
	}

	//bannerlist
	function bannerList(){
		$data['banner'] = $this->Public_model->select($this->banner,'id','desc');
		  $city =json_decode(curl_post('http://119.23.149.7:9999/app/city/list',''),true);
		  $data['city'] = $city['content'];

		$data['menu'] = 'Banner';
		$data['title'] = 'banner管理';
		$this->load->view('bannerList.html',$data);
	}
	function bannerAdd(){
		if($_POST){
			$data = $this->input->post();
			// $data['createtime'] = time();
			if($this->Public_model->insert($this->banner,$data)){
				$data['message'] = '操作成功！';
				$data['jumpUrl'] = site_url('/Post/bannerList');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
				// echo "<script>alert('操作成功！');window.location.href='".site_url('/Post/bannerList')."'</script>";
			}else{
				$data['error'] = '操作失败';
				$data['jumpUrl'] = site_url('/Post/bannerList');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);			}

		}else{
			//获取城市
            $city =json_decode(curl_post('http://119.23.149.7:9999/app/city/list',''),true);
            $data['city'] = $city['content'];
			$data['menu'] = 'Banner';
			$data['title'] = "新增banner";
			$this->load->view('banner_add.html',$data);
		}
	}
	function bannerEdit(){
		if($_POST){
			$data = $this->input->post();
			// $data['updatetime'] = time();
			if($this->Public_model->edit($this->banner,'id',$data['id'],$data)){
				$data['message'] = '操作成功！';
				$data['jumpUrl'] = site_url('/Post/bannerList');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
				$data['error'] = '操作失败！';
				$data['jumpUrl'] = site_url('/Post/bannerList');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}
		}else{

			$id = intval($this->uri->segment('3'));
			if($id == '0'){
				$data['error'] = '请求错误！';
				$data['jumpUrl'] = site_url('/Post/bannerlist');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
 				$city =json_decode(curl_post('http://119.23.149.7:9999/app/city/list',''),true);
            	$data['city'] = $city['content'];			
            	//获取文章详情
				$data['the_post'] = $this->Public_model->select_info($this->banner,'id',$id);
				$data['menu'] = 'Banner';
				$data['title'] = "编辑banner";
				$this->load->view('banner_edit.html',$data);
			}
		}
	}
	function bannerDel(){
		$id = intval($this->uri->segment('3'));
		if($id == '0'){
			$data['error'] = '请求错误！';
			$data['jumpUrl'] = site_url('/Post/bannerlist');
			$data['waitSecond'] = '3';
			$this->load->view('Public_jump.html',$data);
		}else{
			if($this->Public_model->delete($this->banner,"id",$id)){
				$data['message'] = '操作成功！';
				$data['jumpUrl'] = site_url('/Post/bannerlist');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
				$data['error'] = '操作失败！';
				$data['jumpUrl'] = site_url('/Post/bannerlist');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}
		}
	}
	//icon 管理
	function iconList(){
		$id = intval($this->uri->segment(3));
		if($id == '0'){
			$data['error'] = '请求错误！';
			$data['jumpUrl'] = site_url('/Home/index');
			$data['waitSecond'] = '3';
			$this->load->view('Public_jump.html',$data);
		}else{
			//1顾客首页icon。2工人首页icon 3导购首页icon 4
			if($id == '1'){
				$data['name'] = "home_icon";
				$data['icon'] =json_decode(get_option('home_icon'),true);
			}elseif($id == '2'){
				$data['name'] = "worker_icon";
				$data['icon'] =json_decode(get_option('worker_icon'),true);
			}elseif($id == '3'){
				$data['name']= 'guide_icon';
				$data['icon'] =json_decode(get_option('guide_icon'),true);
			}elseif($id == '4'){
				$data['name']= 'goods_icon';
				$data['icon'] =json_decode(get_option('goods_icon'),true);
			}
			// $data['icon'] =json_decode(get_option('home_icon'),true);
			// var_dump($data);
			$data['menu'] = 'Banner';
			$data['title'] = "icon管理";
			$this->load->view('iconList.html',$data);
		}
	}

	//修改icon
	function iconEdit(){
		if($_POST){
			$data = $this->input->post();
			//var_dump($data);
			$icon =json_decode(get_option($data['type']),true);
			foreach ($icon as $key => $value) {
			  	if($value['id'] == $data['id']){
			  		$icon[$key]['name'] =$data['name'];
			  		$icon[$key]['pic'] =$data['pic'];
			  		// $icon[$key]['url'] =$data['url'];
			  	}
			}
			$arr['value'] = json_encode($icon);
			if($this->Public_model->edit('i_option','name',$data['type'],$arr)){
				$data['message'] = '操作成功！';
				$data['jumpUrl'] = site_url('/Post/iconList/1');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
				$data['error'] = '操作失败！';
				$data['jumpUrl'] = site_url('/Post/iconList/1');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}


		}else{
			$id = intval($this->uri->segment(4));
			$type = $this->uri->segment(3);
			if($id == '0' || empty($type)){
				$data['error'] = '请求错误！';
				$data['jumpUrl'] = site_url('/Home/index');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
				$icon =json_decode(get_option($type),true);
				$data['the_post'] = $icon[$id-1];
				$data['type'] = $type;
	 			// var_dump($data);
				$data['menu'] = 'Banner';
				$data['title'] = "icon管理";
				$this->load->view('icon_edit.html',$data);
			}
		}
	}

	//标语
	function slogan(){
		$data['slogan']=$this->Public_model->select($this->slogan,'id','desc');
	 			//获取城市
        $city =json_decode(curl_post('http://119.23.149.7:9999/app/city/list',''),true);
        $data['city'] = $city['content'];
		$data['menu'] = 'Banner';
		$data['title'] = "标语";
		$this->load->view('Slogan_index.html',$data);
	}

	function sloganAdd(){
		if($_POST){
			$data = $this->input->post();
			$data['create_time']=date('Y-m-d H:i:s',time());

			if($this->Public_model->insert($this->slogan,$data)){
				$data['message'] = '新增成功！';
				$data['jumpUrl'] = site_url('/Post/slogan');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
				$data['error'] = '新增失败！';
				$data['jumpUrl'] = site_url('/Post/sloganAdd');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}
		}else{

			$city =json_decode(curl_post('http://119.23.149.7:9999/app/city/list',''),true);
	        $data['city'] = $city['content'];
			$data['menu'] = 'Banner';
			$data['title'] = "新增标语";
			$this->load->view('Slogan_add.html',$data);
		}
	}
	function sloganEdit(){
		if($_POST){
			$data = $this->input->post();
			// $data['create_time']=date('Y-m-d H:i:s',time());

			if($this->Public_model->edit($this->slogan,'id',$data['id'],$data)){
				$data['message'] = '编辑成功！';
				$data['jumpUrl'] = site_url('/Post/slogan');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
				$data['error'] = '编辑失败！';
				$data['jumpUrl'] = site_url('/Post/sloganEdit/').$data['id'];
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}
		}else{
			$id = intval($this->uri->segment('3'));
			if($id == '0'){
				$data['error'] = '请求错误！';
				$data['jumpUrl'] = site_url('/Post/slogan');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
 				$city =json_decode(curl_post('http://119.23.149.7:9999/app/city/list',''),true);
            	$data['city'] = $city['content'];			
            	//获取文章详情
				$data['the_post'] = $this->Public_model->select_info($this->slogan,'id',$id);
				
				$data['menu'] = 'Banner';
				$data['title'] = "修改标语";
				$this->load->view('Slogan_edit.html',$data);
			}
			
		}
	}

	//
	function sloganDel(){
		$id = intval($this->uri->segment('3'));
		if($id == '0'){
			$data['error'] = '请求错误！';
			$data['jumpUrl'] = site_url('/Post/slogan');
			$data['waitSecond'] = '3';
			$this->load->view('Public_jump.html',$data);
		}else{
			
			if($this->Public_model->delete($this->slogan,'id',$id)){
				$data['message'] = '删除成功！';
				$data['jumpUrl'] = site_url('/Post/slogan');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
				$data['error'] = '删除失败！';
				$data['jumpUrl'] = site_url('/Post/slogan');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}
			
		}
	}




}








 ?>