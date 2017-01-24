<?php
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