<?php

header("Content-Type: text/html; charset=utf-8");

require_once(dirname(__FILE__) . '/' . 'IGt.Push.php');
require_once(dirname(__FILE__) . '/' . 'igetui/IGt.AppMessage.php');
require_once(dirname(__FILE__) . '/' . 'igetui/IGt.APNPayload.php');
require_once(dirname(__FILE__) . '/' . 'igetui/template/IGt.BaseTemplate.php');
require_once(dirname(__FILE__) . '/' . 'IGt.Batch.php');
require_once(dirname(__FILE__) . '/' . 'igetui/utils/AppConditions.php');

//http的域名
define('HOST','http://sdk.open.api.igexin.com/apiex.htm');


//定义常量, appId、appKey、masterSecret 采用本文档 "第二步 获取访问凭证 "中获得的应用配置               
define('APPKEY','O8dShsMUiK7MZTyfPXDUy2');
define('APPID','Npuq5Gtr4b7EFd4urKowg1');
define('MASTERSECRET','ekPvNh6zLk6sn7BoR7sEC8');

//define('BEGINTIME','2015-03-06 13:18:00');
//define('ENDTIME','2015-03-06 13:24:00');



pushMessageToApp();
//群推接口案例
function pushMessageToApp(){
    $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
    //定义透传模板，设置透传内容，和收到消息是否立即启动启用
    $template = IGtNotyPopLoadTemplateDemo();
    // $template = IGtLinkTemplateDemo();
    // $template = IGtNotyPopLoadTemplateDemo();
    // 定义"AppMessage"类型消息对象，设置消息内容模板、发送的目标App列表、是否支持离线发送、以及离线消息有效期(单位毫秒)
    $message = new IGtAppMessage();
    $message->set_isOffline(true);
    $message->set_offlineExpireTime(10 * 60 * 1000);//离线时间单位为毫秒，例，两个小时离线为3600*1000*2
    $message->set_data($template);

    $appIdList=array(APPID);
    // $phoneTypeList=array('ANDROID');
    // $provinceList=array('浙江');
    // $tagList=array('haha');
    //用户属性
    //$age = array("0000", "0010");


    //$cdt = new AppConditions();
   // $cdt->addCondition(AppConditions::PHONE_TYPE, $phoneTypeList);
   // $cdt->addCondition(AppConditions::REGION, $provinceList);
    //$cdt->addCondition(AppConditions::TAG, $tagList);
    //$cdt->addCondition("age", $age);

    $message->set_appIdList($appIdList);
    //$message->set_conditions($cdt->getCondition());

    $rep = $igt->pushMessageToApp($message,"任务组名");

    var_dump($rep);
    echo ("<br><br>");
}

function IGtLinkTemplateDemo(){
    $template =  new IGtLinkTemplate();
    $template ->set_appId(APPID);                  //应用appid
    $template ->set_appkey(APPKEY);                //应用appkey
    $template ->set_title("12333");       //通知栏标题
    $template ->set_text("345464erewrwe");        //通知栏内容
    $template->set_logo("");                       //通知栏logo
    $template->set_logoURL("");                    //通知栏logo链接
    $template ->set_isRing(true);                  //是否响铃
    $template ->set_isVibrate(true);               //是否震动
    $template ->set_isClearable(true);             //通知栏是否可清除
    $template ->set_url("http://img.hb.aicdn.com/f7181383b0b6b3a7d91def12c64c3cd5e584d1f8530f3-NnMhzJ_fw658"); //打开连接地址
    //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
    return $template;
}
function IGtNotificationTemplateDemo(){
    $template =  new IGtNotificationTemplate();
    $template->set_appId(APPID);                   //应用appid
    $template->set_appkey(APPKEY);                 //应用appkey
    $template->set_transmissionType(1);            //透传消息类型
    $template->set_transmissionContent("测试离线");//透传内容
    $template->set_title("个推");                  //通知栏标题
    $template->set_text("342342");     //通知栏内容
    $template->set_logo("");                       //通知栏logo
    $template->set_logoURL("http://img.hb.aicdn.com/f7181383b0b6b3a7d91def12c64c3cd5e584d1f8530f3-NnMhzJ_fw658");                    //通知栏logo链接
    $template->set_isRing(true);                   //是否响铃
    $template->set_isVibrate(true);                //是否震动
    $template->set_isClearable(true);              //通知栏是否可清除

    return $template;
}
function IGtNotyPopLoadTemplateDemo(){
    $template =  new IGtNotyPopLoadTemplate();
    $template ->set_appId(APPID);   //应用appid
    $template ->set_appkey(APPKEY); //应用appkey
    //通知栏
    $template ->set_notyTitle("花瓣下载");                 //通知栏标题
    $template ->set_notyContent("花瓣下载"); //通知栏内容
    $template ->set_notyIcon("");                      //通知栏logo
    $template ->set_isBelled(true);                    //是否响铃
    $template ->set_isVibrationed(true);               //是否震动
    $template ->set_isCleared(true);                   //通知栏是否可清除
    //弹框
    $template ->set_popTitle("花瓣下载");   //弹框标题
    $template ->set_popContent("花瓣下载"); //弹框内容
    $template ->set_popImage("");           //弹框图片
    $template ->set_popButton1("下载");     //左键
    $template ->set_popButton2("取消");     //右键
    //下载
    $template ->set_loadIcon("http://img.hb.aicdn.com/f7181383b0b6b3a7d91def12c64c3cd5e584d1f8530f3-NnMhzJ_fw658");           //弹框图片
    $template ->set_loadTitle("地震速报下载");
    $template ->set_loadUrl("http://dizhensubao.igexin.com/dl/com.ceic.apk");
    $template ->set_isAutoInstall(false);
    $template ->set_isActived(true);
    //$template->set_duration(BEGINTIME,ENDTIME); //设置ANDROID客户端在此时间区间内展示消息
    return $template;
}


?>