<?php

/**
 * 操作结果
 * @param  boolean $flag 标识(true/false)
 * @param  array $data 内容
 * @return json       返回操作结果
 */
function returnJson($flag, $data = null)
{
	header("Content-type: application/json");
	$key = is_array($data) ? 'data' : 'info';

	print_r(json_encode(
		array(
			'status' => $flag ? 1 : 0,
			$key => $data
		)
	));
	exit;
}

/**
 * 获取申请者id
 * @return integer 申请者id
 */
function getApplicant()
{
	return session('uid');
}

/**
 * 申请时间
 * @return [type] [description]
 */
function getApplyTime()
{
	return date('Y-m-d H:i:s', time());
}

/**
 * 申请码
 * @return [type] [description]
 */
function apply_code()
{
	return date('Ymd', time()) . rand(1000, 9999);
}

/**
 * 验证用户账号
 * @param  integer $data 手机号
 * @return boolean
 */
function checkAccount($data)
{
	return preg_match('/^\d{6}$/', $data);
}

/**
 * 验证手机号
 * @param  integer $data 手机号
 * @return boolean
 */
function checkPhone($data)
{
	return preg_match('/^((\(\d{2,3}\))|(\d{3}\-))?13\d{9}$/', $data);
}