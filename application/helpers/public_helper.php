<?php 
//是否登陆

function get_cate_name($id){
	$CI = &get_instance();
    $a = $CI->db->query("select * from i_cate where id ='$id'");
    $ret = $a->row_array();
    return $ret['name'];
}

//返回分类树
function subtree($arr,$a = '',$id=0,$lev=1) {
    $subs = array(); // 子孙数组
    foreach($arr as $k=>$v) {
        if(!empty($a)){
            if(in_array($v['id'],$a)){
                 $v['true'] = '1';
            }else{
                $v['true'] = '0';
            }   
        }         
        if($v['p_id'] == $id) {
            $v['lev'] = $lev;
            $subs[] = $v; // 举例说找到array('id'=>1,'name'=>'安徽','parent'=>0),
            $subs = array_merge($subs,subtree($arr,$a,$v['id'],$lev+1));
        }
    }
    return $subs;
}

function get_option($name = '') {
    $CI = &get_instance();
    $sql = "select value from i_option where name='$name'";
    $query = $CI->db->query($sql);
    $value = $query->row_array();

    if ($value) {
        return $value['value'];
    }
    return NULL;
}


 ?>