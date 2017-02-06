<?php
namespace Admin\Controller;
use Think\Controller;
/**
* 
*/
class GoodsController extends BaseController
{
	private $goods;
	private $borrow;

	public function _initialize()
	{
		$this->goods = D('Goods');
		$this->borrow = D('Borrow');
	}
	
	public function index()
	{
		if (IS_AJAX) {
			$pid = I('get.pid', 0);
			$data = $this->goods->getGoods($pid);
			exit(json_encode($data));
		}
		$this->display('_index');
	}


	public function apply()
	{
		if (IS_AJAX) {
			$is_examine = I('get.is_examine', 0);
			$p = I('get.p', 1);
			$data = $this->borrow->getApplyByUid($is_examine, $p);
			exit(json_encode($data));
		}
		$this->display();
	}


	// 申请详情
	public function applyDetail()
	{
		if (IS_AJAX) {
			$id = I('get.id', 0);
			$data = $this->borrow->getApplyById($id);
			exit(json_encode($data));
		}
	}


	// 展示可预约的数据
	public function order()
	{
		if (IS_AJAX) {
			$id = I('get.id');
			$need = $this->borrow->where(array('id' => $id))->getField('borrow');
			$need = explode(',', $need);
        	$need = D('Goods')->getNeed($need);

        	foreach ($need as $key => $value) {
				$arr[] = $value['id'];
			}
			$selection = $this->goods->provideSelection($arr);
			exit(json_encode($selection));
		}
	}


	// 提交预约
	public function makeAppointment()
	{
		if (IS_AJAX) {
			$id = I('post.id');
			$goods = I('post.goods');
			return $this->goods->occupyStatus($id, $goods);
		}
	}


	// 提交审核结果
	public function review()
	{
		if (IS_AJAX) {
			$data = I('post.');
			if ($this->borrow->audit($data)) {
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
		$data = $this->borrow->getApplyByTimes($sdate, $edate, true);

		$title = array(
			'code' 			=> '申请码',
			'account' 		=> '申请单位',
			'theme' 		=> '主题',
			'phone' 		=> '联系方式',
			'stime'			=> '开始时间',
			'etime'			=> '结束时间',
			'apply_time' 	=> '申请时间',
		);

		array_unshift($data, $title);
		$this->applyExport($data);
	}

	

}