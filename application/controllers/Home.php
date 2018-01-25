<?php 
/**
* 
*/
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'controllers/Public_Controller.php');

class Home extends Public_Controller
{	
    public $activity = 'i_activity';
	public $edition = 'i_edition';
	
	function __construct()
	{
		parent::__construct();
	}

	function index(){
		$data['title'] = '欢迎登陆！';
		$data['menu'] = '';
		$this->load->view('Index_index.html',$data);
	}

	//活动列表
	function activityList(){
		$config['per_page'] = 10;
                //获取页码
                $current_page=intval($this->uri->segment(3));//index.php 后数第4个/
                //配置
                $config['base_url'] = site_url('/Home/activityList');
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
                
                $total = count($this->Public_model->select($this->activity,'aid','desc'));
                $config['total_rows'] = $total;
            
                $this->load->library('pagination');//加载ci pagination类
                $listpage =  $this->Public_model->select_page($this->activity,$current_page,$config['per_page'],'aid','desc');
                $this->pagination->initialize($config);
                //获取城市
                $city =json_decode(curl_post('http://119.23.149.7:9999/app/city/list',''),true);


                $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links(),'menu'=>'Activity','title'=>'最新活动','city'=>$city['content'],'the_cid'=>'0');


		$this->load->view('Activity_index.html',$data);
	}

	//新增活动
	function addActivity(){
	   if($_POST){
                $data = $this->input->post();
                $data['create_time'] = date('Y-m-d H:i:s',time());
                if($this->Public_model->insert($this->activity,$data)){
                        $data['message'] = '操作成功！';
                        $data['jumpUrl'] = site_url('/Home/activityList');
                        $data['waitSecond'] = '3';
                        $this->load->view('Public_jump.html',$data);
                }else{
                        $data['error'] = '操作失败！';
                        $data['jumpUrl'] = site_url('/Home/activityList');
                        $data['waitSecond'] = '3';
                        $this->load->view('Public_jump.html',$data);
                }
           }else{
                //获取城市
                $city =json_decode(curl_post('http://119.23.149.7:9999/app/city/list',''),true);
                $data['menu'] = 'Activity';
                $data['title'] = '新增活动';
                $data['city'] = $city['content'];
                $this->load->view('Activity_add.html',$data);

           }
	}
        //编辑活动
        function editActivity(){
                if($_POST){
                        $data = $this->input->post();
                        if($this->Public_model->edit($this->activity,'aid',$data['aid'],$data)){
                                $data['message'] = '操作成功！';
                                $data['jumpUrl'] = site_url('/Home/activityList');
                                $data['waitSecond'] = '3';
                                $this->load->view('Public_jump.html',$data);
                        }else{
                                $data['error'] = '操作失败！';
                                $data['jumpUrl'] = site_url('/Home/activityList');
                                $data['waitSecond'] = '3';
                                $this->load->view('Public_jump.html',$data);
                        }
                }else{  
                        $id = intval($this->uri->segment('3'));
                        //获取活动
                        if($id == '0'){
                                $data['error'] = '请求错误！';
                                $data['jumpUrl'] = site_url('/Home/activityList');
                                $data['waitSecond'] = '3';
                                $this->load->view('Public_jump.html',$data);
                        }else{
                                $data['the_post'] = $this->Public_model->select_info($this->activity,'aid',$id);
                                //获取城市
                                $city =json_decode(curl_post('http://119.23.149.7:9999/app/city/list',''),true);
                                $data['menu'] = 'Activity';
                                $data['title'] = '新增活动';
                                $data['city'] = $city['content'];
                                $this->load->view('Activity_edit.html',$data);
                        }

                }  
        }

        //删除活动
        function delActivity(){
                $id = intval($this->uri->segment('3'));
                if($id == '0'){
                        $data['error'] = '请求错误！';
                        $data['jumpUrl'] = site_url('/Home/activityList');
                        $data['waitSecond'] = '3';
                        $this->load->view('Public_jump.html',$data);
                }else{
                        if($this->Public_model->delete($this->activity,'aid',$id)){
                                $data['message'] = '操作成功！';
                                $data['jumpUrl'] = site_url('/Home/activityList');
                                $data['waitSecond'] = '3';
                                $this->load->view('Public_jump.html',$data);
                        }else{
                                $data['error'] = '操作失败！';
                                $data['jumpUrl'] = site_url('/Home/activityList');
                                $data['waitSecond'] = '3';
                                $this->load->view('Public_jump.html',$data);
                        }
                }
        }


        //APP版本
        function App_edition(){
            $config['per_page'] = 10;
            //获取页码
            $current_page=intval($this->uri->segment(3));//index.php 后数第4个/
            //配置
            $config['base_url'] = site_url('/Home/activityList');
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
            
            $total = count($this->Public_model->select($this->edition,'create_time','desc'));
            $config['total_rows'] = $total;
        
            $this->load->library('pagination');//加载ci pagination类
            $listpage =  $this->Public_model->select_page($this->edition,$current_page,$config['per_page'],'create_time','desc');
            $this->pagination->initialize($config);
          

            $data = array('lists'=>$listpage,'pages' => $this->pagination->create_links(),'menu'=>'appversion','title'=>'APP版本管理');

            $this->load->view('AppVersion.html',$data);
        }

        //新增版本
        function addVersion(){
            if($_POST){
                $data = $this->input->post();
                $data['create_time'] = date('Y-m-d H:i:s',time());
                // var_dump($data);
                if($this->Public_model->insert($this->edition,$data)){
                        $data['message'] = '操作成功！';
                        $data['jumpUrl'] = site_url('/Home/App_edition');
                        $data['waitSecond'] = '3';
                        $this->load->view('Public_jump.html',$data);
                }else{
                        $data['error'] = '操作失败！';
                        $data['jumpUrl'] = site_url('/Home/App_edition');
                        $data['waitSecond'] = '3';
                        $this->load->view('Public_jump.html',$data);
                }
            }else{
                $data['menu'] = 'appversion';
                $data['title'] = '新增APP版本';
                $this->load->view('Appversion_add.html',$data);
            }
        }

        //修改版本号
        function editVersion(){
            if($_POST){
                $data = $this->input->post();
                // var_dump($data);
                if($this->Public_model->edit($this->edition,'id',$data['id'],$data)){
                        $data['message'] = '操作成功！';
                        $data['jumpUrl'] = site_url('/Home/App_edition');
                        $data['waitSecond'] = '3';
                        $this->load->view('Public_jump.html',$data);
                }else{
                        $data['error'] = '操作失败！';
                        $data['jumpUrl'] = site_url('/Home/App_edition');
                        $data['waitSecond'] = '3';
                        $this->load->view('Public_jump.html',$data);
                }
            }else{
                //编辑
                $id = intval($this->uri->segment(3));
                if($id == '0'){
                    $data['error'] = '请求错误！';
                    $data['jumpUrl'] = site_url('/Home/App_edition');
                    $data['waitSecond'] = '3';
                    $this->load->view('Public_jump.html',$data);
                }else{
                    $data['the_post'] = $this->Public_model->select_info($this->edition,'id',$id);

                    $data['menu'] = 'appversion';
                    $data['title'] = '编辑APP版本';
                    $this->load->view('Appversion_edit.html',$data);
                }
            }
        }

        //删除版本号
        function delVersion(){
            $id = intval($this->uri->segment(3));
            if($id == '0'){
                $data['error'] = '请求错误！';
                $data['jumpUrl'] = site_url('/Home/App_edition');
                $data['waitSecond'] = '3';
                $this->load->view('Public_jump.html',$data);
            }else{
                if($this->Public_model->delete($this->edition,'id',$id)){
                        $data['message'] = '操作成功！';
                        $data['jumpUrl'] = site_url('/Home/App_edition');
                        $data['waitSecond'] = '3';
                        $this->load->view('Public_jump.html',$data);
                }else{
                        $data['error'] = '操作失败！';
                        $data['jumpUrl'] = site_url('/Home/App_edition');
                        $data['waitSecond'] = '3';
                        $this->load->view('Public_jump.html',$data);
                }
            }
        }


}
 ?>








