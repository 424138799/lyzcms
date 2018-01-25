<?php 

/**
* 
*/
class Public_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	//查询
	function select($table,$sort,$desc){
		$query = $this->db->order_by($sort,$desc)->get($table);
		return $query->result_array();
	}
	//查询分页
	function select_page($table,$size,$page,$sort,$desc){
		$query = $this->db->order_by($sort,$desc)->limit($page,$size)->get($table);
		return $query->result_array();
	}

	//查询某一条数据
	function select_info($table,$where,$id){
		$query = $this->db->where($where,$id)->get($table);
		return $query->row_array();
	}
	//条件
	function select_where($table,$where,$id,$sort,$desc){
		$query = $this->db->where($where,$id)->order_by($sort,$desc)->get($table);
		return $query->result_array();
	}
	//分页条件查询
	function select_where_page($table,$where,$id,$size,$page,$sort,$desc){
		$query = $this->db->where($where,$id)->order_by($sort,$desc)->limit($page,$size)->get($table);
		return $query->result_array();
	}


	//新增
	function insert($table,$data){
		return $this->db->insert($table,$data);
	}
	//编辑
	function edit($table,$id,$where,$data){
		return $this->db->where($id,$where)->update($table,$data);
	}
	//删除
	function delete($table,$id,$where){
		return $this->db->where($id,$where)->delete($table);
	}

	//返回商学院条数
	function schoolNum($table){
		$sql = "SELECT count(*) FROM $table";
        $query = $this->db->query($sql);
        return $query->row_array();
	}
	function paletteNum($table,$cateid){
		$sql = "SELECT count(*) FROM $table where cateId='$cateid'";
        $query = $this->db->query($sql);
        return $query->row_array();
	}
	//返回最新的数据
	function selectLimit($table,$where,$type,$limit,$sort){
		$query = $this->db->where($where,$type)->order_by($sort,'desc')->limit($limit,'0')->get($table);
		return $query->row_array();
	}





}






 ?>