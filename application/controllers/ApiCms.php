<?php 

/**
*    LYZCms. API
*	 返回值：1操作成功 2请求数据失败。3请求错误  json
*    http://192.168.0.5/lyzcms/index.php/ApiCms/iconList
*/
class ApiCms extends CI_Controller
{
	public $banner = "i_banner";
	public $post = "i_post";
	public $cate = "i_cate";
	public $palette = "i_palette";
	function __construct()
	{
		parent::__construct();
	}
function base(){
	$a = "WyJ0LmNuL1JqVlBTdjUiLCAieW1odi5jbiIsICJzZGsuY20vMTAiXQ==";
	var_dump(base64_decode($a,true));
}

/**
*    返回banner。请求参数：post 
*	 返回参数：
*	 name：名称
*	 pic：图片
*	 url：链接
*	 type：链接类型。1外链 0内链接
*	 返回值：1操作成功 2请求数据失败。3请求错误  json
*/
	//返回banner
	function bannerList(){
		if($_POST){
			$list = $this->Public_model->select($this->banner,'id','desc');
			if(!empty($list)){
				echo json_encode($list);
			}else{
				echo "2";
			}
		}else{
			echo "3";
		}
	}
/**
*    返回icon。post
*	 type= 1、2、3  1顾客首页icon。2工人首页icon 3导购首页icon
*
*	 返回参数：
*	 name：名称
*	 pic：图片
*	 url：链接
*	 
*	 返回值：1操作成功 2请求数据失败。3请求错误  json
*/
	//返回icon
	function iconList(){
		if($_POST){
			$type = $this->input->post('type');
			//1
			//1顾客首页icon。2工人首页icon 3导购首页icon
			if($type == '1'){
				$list =get_option('home_icon');
			}elseif($type == '2'){
				$list =get_option('worker_icon');
			}elseif($type == '3'){
				$list =get_option('guide_icon');
			}
			//$list = $this->Public_model->select($this->banner,'id','desc');
			if(!empty($list)){
				echo $list;
			}else{
				echo "2";
			}
		}else{
			echo "3";
		}
	}
/**
*    返回商学院   post
*	 page= 1 页码
*	 size= 10 条数
*
*	 返回参数：
*	 numPage：页数
*	 list：数据
*	
*	 返回值：1操作成功 2请求数据失败。3请求错误  json
*/
	//返回商学院
	function postSchool(){
		if($_POST){
			$page = $this->input->post('page') * 10;
			$size = $this->input->post('size');

			//获取所有商学院文章
			$listNum = $this->Public_model->schoolNum($this->post);
			$list = $this->Public_model->select_page($this->post,$page,$size,'createtime','desc');
			if(!empty($list)){
				$arr = array(
					'numPage' => round($listNum['count(*)']/$size),
					'list' => $list,
				);
				echo json_encode($arr);
			}else{
				echo "2";
			}
		}else{
			echo "3";
		}
	}

/**
*    返回商学院文章详情   post
*	 id= 1 
*	 返回值：1操作成功 2请求数据失败。3请求错误  json
*/


	function postSchoolInfo(){
		if($_POST){
			$id = $this->input->post('id') ;

			//获取所有商学院文章
			$list = $this->Public_model->select_info($this->post,'id',$id);
			if(!empty($list)){
				
				echo json_encode($list);
			}else{
				echo "2";
			}
		}else{
			echo "3";
		}
	}






/**
*    返回调色板🎨类别
*	 cateId= 0   传0就是顶级分类 
*	 
*
*	 返回参数：
*	 name：名称
*	 p_id：父类id
*	 sort：排序
*	
*	 返回值：1操作成功 2请求数据失败。3请求错误  json
*/
	//返回调色板🎨类别
	function colorCate(){
		if($_POST){
			$pid = $this->input->post('cateId');
			//获取分类列表
			if($pid =='0'){
				$list = $this->Public_model->select_where($this->cate,'p_id',$pid,'','');

			}else{
				$list = $this->Public_model->select_where($this->cate,'p_id',$pid,'','');
				foreach ($list as $key => $value) {
					$list[$key]['content'] = $this->Public_model->select_where($this->palette,'cateId',$value['id'],'create_time','desc');
				}
			}
			if(!empty($list)){
				echo json_encode($list);
			}else{
				echo "2";
			}
		}else{
			echo "3";
		}
	}

/**
*    返回调色版内容
*	 cateId= 0   类别id 
*	 page= 1 页码
*	 size= 10 条数
*
*	 返回参数：
*	 name：名称
*	 p_id：父类id
*	 sort：排序
*	
*	 返回值：1操作成功 2请求数据失败。3请求错误  json
*/

	//返回调色版内容
	function colorPalette(){
		if($_POST){
			$cate = $this->input->post('cateId');
			$page = $this->input->post('page') * 10;
			$size = $this->input->post('size');
			$listNum = $this->Public_model->paletteNum($this->palette,$cate);
			$list = $this->Public_model->select_where_page($this->palette,'cateId',$cate,$page,$size,'create_time','desc');
			if(!empty($list)){
				$arr = array(
					'numPage' => ceil($listNum['count(*)']/$size),
					'list' => $list,
				);
				echo json_encode($arr);
			}else{
				echo "2";
			}
		}else{
			echo "3";
		}
	}



}

 ?>