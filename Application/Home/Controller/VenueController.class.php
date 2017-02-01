<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 展场展架
 */
class VenueController extends BaseController
{
	

    public function demo()
    {
    	$this->display('index');
    }

    public function up()
    {
    	$config = C('TMPL_PARSE_STRING');
	    $images = $_POST['images'];
	    
	    foreach ($images as $index => $img) {
	        $start=strpos($img,',');
	        $img= substr($img,$start+1);
	        $img = str_replace(' ', '+', $img);
	        $data = base64_decode($img);
	        $fileName = './Public/Upload/' . uniqid() . '.jpg';
	        $success = file_put_contents($fileName, $data);
	    }
	    $data=array();
	    if($success){
	        $data['status']=1;
	        $data['msg']='上传成功';
	        echo json_encode($data);
	    }else{
	        $data['status']=0;
	        $data['msg']='系统繁忙，请售后再试';
	        echo json_encode($data);
	    }
    }


}
