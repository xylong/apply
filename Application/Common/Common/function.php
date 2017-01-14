<?php
/**
 * 操作结果
 * @param  boolean $flag 标识(true/false)
 * @param  array $data 内容
 * @return json       返回操作结果
 */
function handle($flag, $data = null)
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
 * 检查参数id是否是正整数
 * @param  integer $id 参数id
 * @return boolean     true/false
 */
function check_param_id($id)
{
	$id = (string) $id;
	if (ctype_digit($id) && $id) {
		return true;
	}
	return false;
}


/**
 * 获取申请类型id数组
 * @return array
 */
function getApllyTypeInId()
{
	$config = C('apply_type');
	foreach ($config as $type) {
		$data[] = $type['id'];
	}

	return $data;
}


/**
 * 树形结构
 * @param  array  $data   需要递归的数组
 * @param  array  $access 
 * @param  integer $pid    父级id
 * @return array          树形结构的数组
 */
function tree($data, $access = null, $pid = 0) {
	$arr = array();

	foreach ($data as $value) {
		if (is_array($access)) {
			$value['access'] = in_array($value['id'], $access) ? 1 : 0;
		}

		if ($value['pid'] == $pid) {
			$value['child'] = tree($data, $access, $value['id']);
			$arr[] = $value;
		}
	}

	return $arr;
}


// 生成时间
function generateTime()
{
	return date('Y-m-d H:i:s', time());
}


/**
 * 申请码
 * @return string 申请码
 */
function getApplyCode()
{
	return date('Ymd', time()) . rand(100, 999);
}


/**
 * 获取申请者id
 * @return integer 申请者id
 */
function getApplicant()
{
	return session('applicant');
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
 * 验证日期
 * @param  string $date 日期
 * @return Boolean
 */
function check_date($date)
{
	return preg_match('/([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})-(((0[13578]|1[02])-(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)-(0[1-9]|[12][0-9]|30))|(02-(0[1-9]|[1][0-9]|2[0-8])))/', $date);
}


/**
 * 选中多选项
 * @param  array $data  被选数据
 * @param  string $str   数据库中选中的值
 * @param  string $judge 判断字段
 * @param  string $flag  标识符
 * @return array        返回带有选中标识的被选数据
 */
function mixChecked($data, $str, $judge = 'id', $flag = ',')
{
	$arr = explode($flag, $str);
    foreach ($data as $key => $value) {
        if (in_array($value[$judge], $arr)) {
            $data[$key]['checked'] = 'checked';
        }
    }
    return $data;
}


/**
 * 取出借用的时间段
 * @param  array $data 使用时间
 * @return array       组装成日期格式的使用时间
 */
function getUseTime($data)
{
	$time = substr($data['time'], 0, -3);
	$arr = explode(',', $data['id']);
	$brr = array('00:00', '00:30', '01:00', '01:30', '02:00', '02:30', '03:00', '03:30', '04:00', '04:30', '05:00', '05:30', '06:00', '06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00', '23:00');
	return array(
		'stime' => date('Y-m-d', $time) . ' ' .$brr[min($arr) - 1],
		'etime' => date('Y-m-d', $time) . ' ' .$brr[max($arr) - 1]
	);
}


/**
 * 把占用的日期转成时间插件的对应id
 * @param  array $data 占用的时间
 * @return array       对应的插件id
 */
function useTime2Num($data)
{
	$number = array('00:00', '00:30', '01:00', '01:30', '02:00', '02:30', '03:00', '03:30', '04:00', '04:30', '05:00', '05:30', '06:00', '06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00', '23:00');

	$pattern = '/([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})-(((0[13578]|1[02])-(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)-(0[1-9]|[12][0-9]|30))|(02-(0[1-9]|[1][0-9]|2[0-8])))/';
	$arr = array();

	foreach ($data as $key => $value) {
		$brr = array();
		$start = trim(substr(preg_replace($pattern, '', $value['stime']), 0, -3));
		$end = trim(substr(preg_replace($pattern, '', $value['etime']), 0, -3));
		array_push($brr, (array_search($start, $number) + 1));
		array_push($brr, (array_search($end, $number) + 1));

		for ($i=$brr[0]; $i <= $brr[1]; $i++) {
			array_push($arr, $i);
		}
	}
	return $arr;
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
 * 下载(支持图片)
 * @param  [string] $path_name [文件路径]
 */
function download_by_path($path_name){
	ob_end_clean();

	$len = strrpos($path_name,"/");
	$save_name = substr($path_name,$len+1);
	$hfile = fopen($path_name, "rb") or die("Can not find file: $path_name\n");

	Header("Content-type: application/octet-stream");
	Header("Content-Transfer-Encoding: binary");
	Header("Accept-Ranges: bytes");
	Header("Content-Length: ".filesize($path_name));
	Header("Content-Disposition: attachment; filename=\"$save_name\"");

	while (!feof($hfile)) {
		echo fread($hfile, 32768);
	}
	fclose($hfile);
}


/**
 * 数组转成字符串
 * @param  array $data 设备类型id
 * @param  string $flag 标识符
 * @return string
 */
function array2string($data, $flag = ',')
{
	return implode($flag, $data);
}


/**
 * 把上下午晚上转成具体时间
 * @param  array $data 提交的时间
 * @return string       datetime时间格式
 */
function id2time($data)
{
	$date = date('Y-m-d', substr($data['time'], 0, -3));
	$hour = $data['id'] == 1 ? ' 08:00' : ($data['id'] == 2 ? ' 13:00' : ' 18:00');
	return $date . $hour;
}


/**
 * 把具体时间转成上午下午晚上
 * @param  string $data 具体时间
 * @return string
 */
function time2str($data)
{
	$date = substr($data, 10, 3);
	switch ($date) {
		case '08':
			$date = '上午';
			break;
		case '13':
			$date = '下午';
			break;
		case '18':
			$date = '晚上';
			break;
	}
	return $date;
}


/**
 * 把展架展场申请的时间转成具体时间
 * @param  [type] $data [description]
 * @return [type]       [description]
 */
function str2time($data)
{
	$arr = explode(',', $data);
	$brr['time'] = $arr[0];
	$brr['id'] = $arr[1];
	$date = date('Y-m-d', substr($brr['time'], 0, -3));
	$hour = $brr['id'] == 1 ? ' 08:00' : ($brr['id'] == 2 ? ' 13:00' : ' 18:00');
	return $date . $hour;
}


function getApplyTime()
{
	return date('Y-m-d H:i:s', time());
}


/**
 * 递归数组分类
 * @param  array $array 所有设备
 * @return array        
 */
function array2tree($array){
    $tree = array();
    if( $array ){
        foreach ( $array as $v ){
            $pid = $v['pid'];
            $list = @$tree[$pid] ? $tree[$pid] : array();
            array_push( $list, $v );
            $tree[$pid] = $list;
        }
    }
    return $tree;
}


/**
 * 数组分类
 * @param  array  $data 被分类的数组
 * @param  array  $access 被选中的设备类型
 * @param  integer $pid  父级id
 * @return array        分类后的数组
 */
function node_merge($node, $access = null, $pid = 0) {
	$tree = array();

	foreach ($node as $value) {
		if ($value['pid'] == 0) {
			if (!in_array($value['id'], $access)) {
				continue;
			}
		}

		if ($value['pid'] == $pid) {
			$value['child'] = node_merge($node, $access, $value['id']);
			$tree[] = $value;
		}
	}

	return $tree;
}


/**
 * 文件上传
 */
function upload()
{
	$upload = new \Think\Upload();
    $upload->maxSize   =     3145728;
    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg', 'zip', 'rar', 'zip', '7z');
    $upload->rootPath  =     './Public/Uploads/';
    $upload->savePath  =     '';
    
    $info   =   $upload->upload();
    if (!$info) {
		$this->error($upload->getError());
    } else {
    	$filename = '';
    	foreach ($info as $file){
	        $filename .= $file['savepath'].$file['savename'];
	    }
	    return $filename;
    }
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
 * 生成压缩文件下载地址
 * @param  string $filename 文件名
 * @return string           下载路径
 */
function downloadZip($filename)
{
	$tmp = C('TMPL_PARSE_STRING');
	return $tmp['__UPLOAD__'].'/'.$filename;
}


/**
 * 检测活动申请展板展架使用天数
 * @param  date $start 开始时间
 * @param  date $end   结束时间
 * @return boolean
 */
function checkDays($start, $end, $limit)
{
	$startdate = strtotime($start);
	$enddate = strtotime($end);
	$days = round(($enddate - $startdate) / 86400) + 1;
	return $days > $limit ? false : true;
}


/**
 * 检查活动申请展板展架使用数量
 * @param  integer $data 使用数量
 * @return boolean
 */
function checkUseCount($data)
{
	if (is_numeric($data)) {
		return $data > 3 ? false : true;
	}
	return false;
}


/**
 * 获取申请单位
 * @param  integer $id 申请者id
 * @return string     申请单位名称
 */
function getUnit($id)
{
	$arr = C('user_type');
	$brr = array();
	foreach ($arr as $key => $value) {
		$brr[$value['id']] = $value['name'];
	}
	return $brr[$id];
}


/**
 * 将数据组装成excel导出格式
 * @param  array $data 数据库查出来的数据
 * @return array
 */
function recombineExportData($data)
{
	$letter = array('A','B', 'C', 'D', 'E', 'F','G','H','I','J','K','L','M','N','O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
	$res = array();
	
	foreach ($data as $index => $item) {
		$i = 0;
		foreach ($item as $key => $value) {
			$tmp = array(
				$letter[$i] . ($index + 1),
				$value
			);
			array_push($res, $tmp);
			$i++;
		}
	}
	return $res;
}