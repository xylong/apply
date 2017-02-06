<?php
namespace Admin\Controller;
use Think\Controller;
/**
* 站场展架
*/
class VenueController extends BaseController
{
	private $venue;
	
	public function _initialize()
	{
		$this->venue = D('Venue');
	}


	public function index()
	{
		if (IS_AJAX) {
			$is_examine = I('get.is_examine', 0);
			$p = I('get.p', 1);
			$data = $this->venue->getApplyByUid($is_examine, $p);
			exit(json_encode($data));
		}
		$this->display('_index');
	}


	// 审核详情
	public function applyDetail()
	{
		if (IS_AJAX) {
			$id = I('get.id', 0);
			$data = $this->venue->getApplyById($id);

			$url = array();
			$config = C('TMPL_PARSE_STRING');
			$imgs = explode(',', $data['apply']['img']);
			foreach ($imgs as $img) {
				$url[] = $config['__UPLOAD__'] . $img;
			}
			$data['apply']['img'] = implode(',', $url);

			exit(json_encode($data));
		}
	}


	// 提交审核结果
	public function review()
	{
		if (IS_AJAX) {
			$data = I('post.');
			if ($this->venue->audit($data)) {
				returnJson(true, '审核成功');
			} else {
				returnJson(true, '审核成功');
			}
		}
	}


	public function export()
	{
		$sdate = I('post.sdate', '');	// 开始时间
		$edate = I('post.edate', '');	// 结束时间

		$sdate = formatDate($sdate) . ' 00:00:00';
		$edate = formatDate($edate) . ' 23:59:59';
		$data = $this->venue->getApplyByTimes($sdate, $edate, true);
		
		foreach ($data as $index => $item) {
			switch ($item['utype']) {
				case 1:
					$data[$index]['utype'] = '学院团委学生会';
					break;

				case 2:
					$data[$index]['utype'] = '社团';
					break;
				
				default:
					$data[$index]['utype'] = '校级学生组织';
					break;
			}
			
		}

		$title = array(
			'code' 			=> '申请码',
			'account' 		=> '申请单位',
			'theme' 		=> '主题',
			'proposer' 		=> '申请人',
			'phone' 		=> '联系方式',
			'num' 			=> '展架数量',
			'remark' 		=> '备注',
			'utype' 		=> '申请类型',
			'stime'			=> '开始时间',
			'etime'			=> '结束时间',
			'apply_time' 	=> '申请时间',
		);

		array_unshift($data, $title);
		$this->applyExport($data);
	}



}