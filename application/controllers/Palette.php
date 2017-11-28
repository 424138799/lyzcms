<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/Public_Controller.php');
/**
* 
*/
class Palette extends Public_Controller
{	
	public $cates = "i_cate";
	public $color = "i_palette";
	
	function __construct()
	{
		parent::__construct();
	}

	//类别
	function cate(){

		//获取所有类别
		$cates = $this->Public_model->select($this->cates,'p_id','asc');
		// foreach ($cates as $key => $v) {
		// 	$cates[$key]['cate'] = $this->Public_model->select_where($this->cates,'p_id',$v['id'],'sort','asc');
		// }
		$data['cates'] = subtree($cates);

		$data['menu'] = 'Palette';
		$data['title'] = '调色板类别';
		$this->load->view('Cate_index.html',$data);
	}

	//新增类别
	function addCate(){
		if($_POST){
			$data = $this->input->post();
			if($this->Public_model->insert($this->cates,$data)){
				$data['message'] = '操作成功！';
				$data['jumpUrl'] = site_url('/Palette/cate');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
				$data['error'] = '操作失败！';
				$data['jumpUrl'] = site_url('/Palette/cate');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}
		}else{
			//h获取顶级类别
			$data['cates'] = $this->Public_model->select_where($this->cates,'p_id','0','sort','asc');

			$data['menu'] = "Palette";
			$data['title'] = "新增调色板类别";
			$this->load->view('Cate_add.html',$data);
		}
	}

	//编辑类别
	function editCate(){
		if($_POST){
			$data = $this->input->post();
			if($this->Public_model->edit($this->cates,'id',$data['id'],$data)){
				$data['message'] = '操作成功！';
				$data['jumpUrl'] = site_url('/Palette/cate');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
				$data['error'] = '操作失败！';
				$data['jumpUrl'] = site_url('/Palette/cate');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}
		}else{
			$id = intval($this->uri->segment('3'));
			if($id == '0'){
				$data['error'] = '请求错误！';
				$data['jumpUrl'] = site_url('/Palette/cate');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
				//获取分类详情
				$data['the_cate'] = $this->Public_model->select_info($this->cates,'id',$id);
				//h获取顶级类别
				$data['cates'] = $this->Public_model->select_where($this->cates,'p_id','0','sort','asc');

				$data['menu'] = "Palette";
				$data['title'] = "编辑调色板类别";
				$this->load->view('Cate_edit.html',$data);
			}
		}
	}

	//删除类别
	function delCate(){
		$id = intval($this->uri->segment('3'));
		if($id == '0'){
			$data['message'] = '请求错误！';
			$data['jumpUrl'] = site_url('/Palette/cate');
			$data['waitSecond'] = '3';
			$this->load->view('Public_jump.html',$data);
		}else{
			if($this->Public_model->delete($this->cates,'id',$id)){
				$data['message'] = '操作成功！';
				$data['jumpUrl'] = site_url('/Palette/cate');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
				$data['error'] = '操作失败！';
				$data['jumpUrl'] = site_url('/Palette/cate');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}
		}
	}

	//调色板
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

        
        $total = count($this->Public_model->select($this->color,'create_time','desc'));
        $config['total_rows'] = $total;
        $listpage =  $this->Public_model->select_page($this->color,$current_page,$config['per_page'],'create_time','desc');

    
        $this->load->library('pagination');//加载ci pagination类
        $this->pagination->initialize($config);
        //获取系统公告
        //获取所有类别
		$cates = $this->Public_model->select_where($this->cates,'p_id !=','0','sort','asc');


        $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links(),'menu'=>'Palette','title'=>'色板管理','cates'=>$cates);
		//获取我的公众号

		$this->load->view('palette_index.html',$data);
	}

	//
	function search(){

		$config['per_page'] = 10;
        //获取页码
        $current_page=intval($this->input->get("size"));//index.php 后数第4个/
        $id = $this->input->get('c_id');

        //配置
        $config['base_url'] = site_url('/Palette/search?').'c_id='.$id;
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

        
        $total = count($this->Public_model->select_where($this->color,'cateId',$id,'create_time','desc'));
        $config['total_rows'] = $total;
        $listpage =  $this->Public_model->select_where_page($this->color,'cateId',$id,$current_page,$config['per_page'],'create_time','desc');

    	$config['page_query_string'] = TRUE;//关键配置

    	$config['query_string_segment'] = 'size';

        $this->load->library('pagination');//加载ci pagination类
        $this->pagination->initialize($config);
        //获取系统公告
        //获取所有类别
		$cates = $this->Public_model->select_where($this->cates,'p_id !=','0','sort','asc');


        $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links(),'menu'=>'Palette','title'=>'色板管理','cates'=>$cates);
		//获取我的公众号

		$this->load->view('palette_index.html',$data);
	}



	//新增色板
	function paletteAdd(){
		if($_POST){
			$data = $this->input->post();
			$data['create_time'] = time();
			if($this->Public_model->insert($this->color,$data)){
				$data['message'] = '操作成功！';
				$data['jumpUrl'] = site_url('/Palette/index');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
				$data['error'] = '操作失败！';
				$data['jumpUrl'] = site_url('/Palette/index');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}
		}else{
			$data['cates'] = $this->Public_model->select_where($this->cates,'p_id !=','0','sort','asc');
			$data['menu'] = 'Palette';
			$data['title'] = '新增调色板';
			$this->load->view('Palette_add.html',$data);
		}
		
	}

	function paletteEdit(){
		if($_POST){
			$data = $this->input->post();
			if($this->Public_model->edit($this->color,'id',$data['id'],$data)){
				$data['message'] = '操作成功！';
				$data['jumpUrl'] = site_url('/Palette/index');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
				$data['error'] = '操作失败！';
				$data['jumpUrl'] = site_url('/Palette/index');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}

		}else{
			$id = intval($this->uri->segment(3));
			if($id == '0'){
				$data['error'] = '请求错误！';
				$data['jumpUrl'] = site_url('/Palette/cate');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
				$data['the_post'] = $this->Public_model->select_info($this->color,'id',$id);

				$data['cates'] = $this->Public_model->select_where($this->cates,'p_id !=','0','sort','asc');
				$data['menu'] = 'Palette';
				$data['title'] = '编辑调色板';
				$this->load->view('Palette_edit.html',$data);
			}
		}
	}
	//删除
	function paletteDel(){
		$id = intval($this->uri->segment(3));
		if($id == '0'){
			$data['error'] = '请求错误！';
			$data['jumpUrl'] = site_url('/Palette/cate');
			$data['waitSecond'] = '3';
			$this->load->view('Public_jump.html',$data);
		}else{
			if($this->Public_model->delete($this->color,'id',$id)){
				$data['message'] = '操作成功！';
				$data['jumpUrl'] = site_url('/Palette/index');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}else{
				$data['error'] = '操作失败！';
				$data['jumpUrl'] = site_url('/Palette/index');
				$data['waitSecond'] = '3';
				$this->load->view('Public_jump.html',$data);
			}
		}
	}


}






 ?>