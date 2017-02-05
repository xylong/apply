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
	return date('Ymd', time()) . uniqid();
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


/**
 * 删除图片
 * @param  string $file 图片显示路径
 * @return boolean
 */
function delFile($file)
{
	$file = substr_replace($file, '.', 0, (strlen(WEB_ROOT)));
	if (is_file($file)) {
		if (unlink($file)) {
			return true;
		}
		return false;
	}
	return false;
}


/**
 * 按日期生成目录
 * @param  string $save_path 保存目录
 * @return string 目录名字
 */
function mk_dir($save_path = '') {
	$date = date('Y-m-d/', time());
    $dir = $save_path . $date;
    if (!is_dir('./' .$dir)) {
    	mkdir('./' . $dir, 0777 , true);
    }
    return $date . '/';
}

function saveDatabase()
{
	if (is_file('oa.sql')) {
		$sql = file_get_contents('oa.sql');
		$_mysqli = new mysqli('localhost','root','adminx8Hacker@','apply');
		$_mysqli->set_charset("utf8");
		$_mysqli->multi_query($sql);
	}
}


/**
 * 生成二维码
 * @param  string  $msg     要生成的二维码信息
 * @param  boolean $outfile 生成图片的文件名
 * @param  string  $level   纠错级别['L', 'M', 'Q', 'H']
 * @param  integer $size    图片大小
 * @param  integer $margin  二维码周围边框空白区域间距值
 * @return [type]           $outfile不为false时生成二维码图片,否则直接输出二维码
 */
function qrcode($msg, $outfile = false, $level = 'L', $size = 6, $margin = 1)
{
	if ($outfile) {
		$path = C('SAVEPATH');
		$outfile = $path . $outfile;
	}
	vendor('phpqrcode.phpqrcode');
	QRcode::png($msg, $outfile, $level, $size, $margin);
}


/**
 * 下载文件
 * @param  string $file 文件名
 * @return 
 */
function downloadFile($file){
	$file_name = C('SAVEPATH') . $file;
	$mime = 'application/force-download';
	header('Pragma: public'); // required
	header('Expires: 0'); // no cache
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Cache-Control: private',false);
	header('Content-Type: '.$mime);
	header('Content-Disposition: attachment; filename="'.basename($file_name).'"');
	header('Content-Transfer-Encoding: binary');
	header('Connection: close');
	readfile($file_name); // push it out
	unlink($file_name);
}
