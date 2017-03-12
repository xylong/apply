<?php
namespace Admin\Controller;
use Think\Controller;
/**
* 青春工坊
*/
class HouseController extends BaseController
{
	private $house;
	private $rent;

	public function _initialize()
	{
		$auth_id = session(C('USER_AUTH_KEY'));
		if (!isset($auth_id)) {
			redirect(U(C('USER_AUTH_GATEWAY')));
		}
		
		$this->house = D('House');
		$this->rent = D('Rent');
		$this->assign('current', CONTROLLER_NAME . '/' . ACTION_NAME);
	}

	// 青春工坊管理
	public function index()
	{
		if (IS_AJAX) {
			$data = $this->house->getHouse();
			exit(json_encode($data));
		}
		$this->display('_index');
	}


	// 青春工坊申请
	public function apply()
	{
		if (IS_AJAX) {
			$is_examine = I('get.is_examine', 0);
			$p = I('get.p', 1);
			$data = $this->rent->getApplyByUid($is_examine, $p);
			exit(json_encode($data));
		}
		$this->display();
	}


	// 申请详情
	public function applyDetail()
	{
		if (IS_AJAX) {
			$id = I('get.id', 0);
			$data = $this->rent->detail($id);
			exit(json_encode($data));
		}
	}


	// 提交审核结果
	public function review()
	{
		if (IS_AJAX) {
			$data = I('post.');
			if ($this->rent->audit($data)) {
				returnJson(true, '审核成功');
			} else {
				returnJson(true, '审核成功');
			}
		}
	}


	// 编辑青春工坊
    public function edit()
    {
        if (IS_AJAX) {
            if (!$this->house->create()) {
                $this->error($this->house->getError());
            } else {
                if ($this->house->id) {
                    $handle = $this->house->save();
                } else {
                    unset($this->house->id);
                    $handle = $this->house->add();
                }
                if ($handle) {
                    returnJson(true, '申请提交成功');
                } else {
                    returnJson(false, '申请提交失败');
                }
            }
        }
    }


    public function export()
	{
		$sdate = I('post.sdate', '');	// 开始时间
		$edate = I('post.edate', '');	// 结束时间

		$sdate = formatDate($sdate) . ' 00:00:00';
		$edate = formatDate($edate) . ' 23:59:59';
		$data = $this->rent->getApplyByTimes($sdate, $edate, true);
		foreach ($data as $index => $item) {
			switch ($item['house']) {
				case 1:
					$data[$index]['house'] = '绘智格';
					break;

				case 2:
					$data[$index]['house'] = '艺韵厅';
					break;
				
				default:
					$data[$index]['house'] = '创意格';
					break;
			}
			
		}

		$title = array(
			'code' 			=> '申请码',
			'account' 		=> '申请单位',
			'house' 		=> '青春工坊',
			'proposer' 		=> '申请人',
			'phone' 		=> '联系方式',
			'tutor' 		=> '指导老师',
			'reason' 		=> '使用事由',
			'stime'			=> '开始时间',
			'etime'			=> '结束时间',
			'apply_time' 	=> '申请时间',
		);

		array_unshift($data, $title);
		$this->applyExport($data);
	}



}
