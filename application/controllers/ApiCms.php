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
			$city = $this->input->post('city');
			$list = $this->Public_model->select_where($this->banner,'city',$city,'sort','asc');

			if(!empty($list)){
				$arr = array(
					'code'=>'0',
					'message'=>'成功！',
					'banner'=>$list,
				);
				echo json_encode($arr);
			}else{
				$arr = array(
					'code'=>'2',
					'message'=>'请求数据失败！',
					'banner'=>'',
				);
				echo json_encode($arr);
			}
		}else{
			$arr = array(
				'code'=>'2',
				'message'=>'请求错误！',
				'banner'=>'',
			);
			echo json_encode($arr);
			
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
			$home = get_option('goods_icon');

			//$list = $this->Public_model->select($this->banner,'id','desc');
			if(!empty($list)){
				$arr = array(
					'code'=>'0',
					'message'=>'成功！',
					'icon'=>json_decode($list,true),
					'cates'=>json_decode($home,true),
				);
				echo json_encode($arr);
			}else{
				$arr = array(
					'code'=>'2',
					'message'=>'请求数据失败！',
					'icon'=>'',
					'cates'=>'',
				);
				echo json_encode($arr);
			}
		}else{
			$arr = array(
				'code'=>'2',
				'message'=>'请求错误！',
				'icon'=>'',
				'cates'=>'',
			);
			echo json_encode($arr);
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
			
			$size = $this->input->post('size');
			$page = ($this->input->post('page')-1)*$size;

		
			//获取所有商学院文章
			$listNum = $this->Public_model->schoolNum($this->post);
			$list = $this->Public_model->select_where_page($this->post,'status','1',$page,$size,'createtime','desc');
			
			if(!empty($list)){
				$arr = array(
					'code'=>'0',
					'message'=>'成功！',
					'numPage' => round($listNum['count(*)']/$size),
					'list' => $list,
				);
				echo json_encode($arr);
			}else{
				$arr = array(
					'code'=>'2',
					'message'=>'请求数据为空！',
					'numPage' => '',
					'list' => '',
				);
				echo json_encode($arr);
			}
		}else{
			$arr = array(
				'code'=>'2',
				'message'=>'请求错误！',
				'numPage' => '',
				'list' => '',
			);
			echo json_encode($arr);
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
				$num = $list['read'] +'1';
				$data['read'] = $num; 
				$this->Public_model->edit($this->post,'id',$id,$data);
				$arr = array(
					'code'=>'0',
					'message'=>'成功',
					'content' => $list,
				);
				echo json_encode($arr);
			}else{
				$arr = array(
					'code'=>'2',
					'message'=>'请求数据为空！',
					'content' => '',
				);
				echo json_encode($arr);
			}
		}else{
			$arr = array(
				'code'=>'2',
				'message'=>'请求错误！',
				'content' => '',
			);
			echo json_encode($arr);
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
				$arr = array(
					'code'=>'0',
					'message'=>'成功！',
					'cate' => $list,
				);
				echo json_encode($arr);
			}else{
				$arr = array(
					'code'=>'2',
					'message'=>'请求数据为空！',
					'cate' => '',
				);
				echo json_encode($arr);
			}
		}else{
			$arr = array(
				'code'=>'2',
				'message'=>'请求错误！',
				'cate' => '',
			);
			echo json_encode($arr);
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


/**
*    返回APP更新 请求方式post  http://120.78.73.217:8090/index.php/ApiCms/appVersion
*	 请求数据 type = 1安卓 2ios
*
*	
*	 返回值：1操作成功 2请求数据失败。3请求错误  json
*/
	function appVersion(){
		if($_POST){
			$type = $this->input->post('type');
			$list = $this->Public_model->selectLimit('i_edition','type',$type,'1','id');
			if(!empty($list)){
				$arr = array(
					'code'=>'0',
					'message'=>'成功！',
					'app' => $list,
				);
				echo json_encode($arr);
			}else{
				$arr = array(
					'code'=>'2',
					'message'=>'请求错误！',
					'app' => '',
				);
				echo json_encode($arr);
			}

		}else{
			$arr = array(
				'code'=>'2',
				'message'=>'请求错误！',
				'app' => '',
			);
			echo json_encode($arr);
		}
	}


/**
*    返回首页最新活动 请求方式post http://120.78.73.217:8090/index.php/ApiCms/activity
*	 请求数据 city = 城市id
*
*	
*	 返回值：1操作成功 2请求数据失败。3请求错误  json
*/
	function activity(){
		if($_POST){
			$type = $this->input->post('city');
			$list = $this->Public_model->selectLimit('i_activity','city',$type,'1','');
			if(!empty($list)){
				$arr = array(
					'code'=>'0',
					'message'=>'成功！',
					'activity' => $list,
				);
				echo json_encode($arr);
			}else{
				$arr = array(
					'code'=>'2',
					'message'=>'请求错误！',
					'activity' => '',
				);
				echo json_encode($arr);
			}

		}else{
			$arr = array(
				'code'=>'2',
				'message'=>'请求错误！',
				'activity' => '',
			);
			echo json_encode($arr);
		}
	}

// 
	function sloganList(){
		if($_POST){
			$type = $this->input->post('city');
			$list = $this->Public_model->select_where('i_slogan','city',$type,'create_time','desc');
			if(!empty($list)){
				$arr = array(
					'code'=>'0',
					'message'=>'成功！',
					'slogan' => $list,
				);
				echo json_encode($arr);
			}else{
				$arr = array(
					'code'=>'2',
					'message'=>'请求错误！',
					'slogan' => '',
				);
				echo json_encode($arr);
			}

		}else{
			$arr = array(
				'code'=>'2',
				'message'=>'请求错误！',
				'slogan' => '',
			);
			echo json_encode($arr);
		}
	}


}

 ?>