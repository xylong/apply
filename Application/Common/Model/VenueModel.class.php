<?php
namespace Common\Model;
use Think\Model;
/**
 * 展场展架
 */
class VenueModel extends Model
{
    const UPLOAD_DIR = './Public/Upload/';

    protected $_validate = array(
        array('theme', 'require', '活动主题不能为空', 1),   // 活动主题
        array('proposer', 'require', '申请人不能为空', 1), // 申请人
        array('phone', 'checkPhone', '手机格式错误', 1, 'function'),  // 手机号
        array('num', 'number', '展架数量必填', 1),    // 展架数量
        array('place', 'require', '摆放地点必填', 1), // 摆放地点
        array('remark', 'require', '', 2),  // 备注
        array('stime', 'require', '开始时间不能为空', 1),   // 开始时间
        array('etime', 'require', '结束时间不能为空', 2, ),	// 结束时间
	);

    protected $_auto = array (
		array('code', 'apply_code', 1, 'function'),	// 申请码
		array('apply_time', 'getApplyTime', 1, 'function'),	// 申请时间
        array('uid', 'getApplicant', 1, 'function'), // 申请者id
        array('img', 'saveImg', 1, 'callback'), // 活动海报
        // array('planning', 'savePlan', 1, 'callback'),    // 活动策划
        array('utype', 'getUserType', 1, 'callback'),   // 申请者类型即申请类型
		array('receiver', 'initReceiver', 1, 'callback')	// 接受者角色
	);


    // 初始化接收角色
    public function initReceiver()
    {
        $step = C('STEP');
        $utype = $this->getUserType();
        return $utype == 3 ? $step[2][2][0] : $step[2][0][0];
    }


    // 用户类型(申请类型)
    public function getUserType()
    {
        $uid = getApplicant();
        return M('User')->where(array('id' => $uid))->getField('type');
    }


    public function saveImg()
    {
        $images = $_POST['images'];
        $dir = mk_dir(self::UPLOAD_DIR);
        
        $str = '';
        foreach ($images as $index => $img) {
            $start=strpos($img,',');
            $img= substr($img,$start+1);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $fileName = uniqid() . '.jpg';
            $saveName = self::UPLOAD_DIR . $dir . $fileName;

            $success = file_put_contents($saveName, $data);
            $str .= ',' . $dir . $fileName;
        }
        return ltrim(rtrim($str, ','), ',');
    }


    public function savePlan()
    {
        $plan = $_POST['plan'];
        $start=strpos($plan, ',');
        $plan= substr($plan, $start+1);
        $plan = str_replace(' ', '+', $plan);
        $data = base64_decode($plan);
        $fileName = UPLOAD_DIR . uniqid() . '.zip';
        $success = file_put_contents($fileName, $data);
        if ($success) {
            return $fileName;
        }
    }

}
