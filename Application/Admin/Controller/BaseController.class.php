<?php
namespace Admin\Controller;
use Think\Controller;
/**
*
*/
class BaseController extends Controller
{
	function _initialize() {
		$auth_id = session(C('USER_AUTH_KEY'));
		if (!isset($auth_id)) {
			redirect(U(C('USER_AUTH_GATEWAY')));
		}
		// $this -> _assign_menu();
		// $this -> _assign_badge_count();
		// $this->_system_log();
	}


	/**
	 * 导出excel表格
	 * @param  array $data 需要导出的数据
	 */
	public function applyExport($data)
	{
		$data = recombineExportData($data);
        Vendor('PHPExcel.Classes.PHPExcel');
        $excel = new \PHPExcel();
        $write = new \PHPExcel_Writer_Excel5($excel);

        $excel->createSheet();
        $excel->setActiveSheetIndex(0);
        $excel->getActiveSheet()->setTitle('demo');


        foreach ($data as $index => $item) {
        	$excel->getActiveSheet()->setCellValue($item[0], $item[1]);
        }

        
        //处理文件名
        $fname = date("Y-m-d H:i:s",time());
        $fname = $fname.".xls";
        //清除缓存区,避免乱码
        ob_end_clean();
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header('Content-Disposition:attachment;filename="'.$fname.'"');
        header("Content-Transfer-Encoding:binary");
        $write->save('php://output');
    }
	

}
