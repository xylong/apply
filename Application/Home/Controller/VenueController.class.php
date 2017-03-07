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
		$this->assign('menu_action', 'venue');
	}

    public function index()
    {
    	if (IS_AJAX) {
    		$start = I('get.start');
    		$end = I('get.end');
    		$data = $this->venue->getApplyByTimes($start, $end);
    		foreach ($data as $index => $item) {
    			if ($item['end'] != '0000-00-00 00:00:00') {
	    			$data[$index]['end'] = substr($item['end'], 0, 8) . (substr($item['end'], 8, 2) + 1);
    			}
    			// 区分自己的申请
    			if (session(C('USER_AUTH_KEY')) == $item['uid']) {
    				$data[$index]['color'] = '#52d1e3';
    				$data[$index]['viewable'] = true;
    			} else {
    				$data[$index]['viewable'] = false;
    			}
    		}
    		exit(json_encode($data));
    	}
        $this->display('_index');
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
    	if (IS_POST) {
    		if (!$this->venue->create()) {
				$this->error($this->venue->getError());
			} else {
				if ($this->venue->add()) {
					// $this->success('申请提交成功');
					echo "<script>alert('申请提交成功');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
				} else {
					$this->error('申请提交失败');
				}
			}
    	}

    	$this->display();
    }


  


}
