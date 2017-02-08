<?php
namespace Admin\Controller;
use Think\Controller;
/**
 * 菜单
 */
class MenuController extends BaseController
{

	private $menu;

	public function _initialize()
	{
		$this->menu = D('Menu');
        $this->assign('current', CONTROLLER_NAME . '/' . ACTION_NAME);
	}


	public function index()
	{
		if (IS_AJAX) {
			$data = $this->menu->where(array('pid' => 0))->field('id,title')->select();
			exit(json_encode($data));
		}
		$this->display('_index');
	}
		

	/**
     * 新增菜单
     * @author 
     */
    public function add(){
        if(IS_AJAX){
            $data = $this->menu->create();
            if($data){
                $id = $this->menu->add();
                if($id){
                    $this->success('新增成功');
                } else {
                    $this->error('新增失败');
                }
            } else {
                $this->error($this->menu->getError());
            }
        }
    }


}