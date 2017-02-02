<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 展场展架
 */
class VenueController extends BaseController
{
	const UPLOAD_DIR = './Public/Upload/';
	private $venue;

	public function _initialize()
	{
		$this->venue = D('Venue');
	}

    public function demo()
    {
    	$this->display('index');
    }

    public function up()
    {
	    $images = $_POST['images'];
	    
	    foreach ($images as $index => $img) {
	        $start=strpos($img,',');
	        $img= substr($img,$start+1);
	        $img = str_replace(' ', '+', $img);
	        $data = base64_decode($img);
	        $fileName = self::UPLOAD_DIR . uniqid() . '.jpg';
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


    public function apply()
    {
    	if (IS_AJAX) {
    		if (!$this->venue->create()) {
				$this->error($this->venue->getError());
			} else {
				if ($this->venue->add()) {
					returnJson(true, '申请提交成功');
				} else {
					returnJson(false, '申请提交失败');
				}
			}
    	}
    	$this->display();
    }


  


}
