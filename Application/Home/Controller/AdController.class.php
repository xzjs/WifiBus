<?php

namespace Home\Controller;

use Think\Controller;

/**
 *
 * 广告控制器类
 *
 * @author xiuge
 *
 */
class AdController extends Controller
{

	/**
	 * “广告设置”页面
	 */
	public function index(){
		$this->assign('title','广告设置');
		$this->assign('class4','action');
		$Line = A ( 'Line' );
		$data = $Line->getLineList ();
		$this->assign ( 'line_list', $data );
		$Bus=A('Bus');
		$data = $Bus->select(0,$data[0][id],'',0);
		$this->assign ( 'bus_list', $data );
		
		$this->display ();
	}
    /**
     * 添加广告
     */
    public function add()
    {
        $Ad = D('Ad');
        if ($Ad->create()) {
            if (empty ($Bus->click_num))
                $Bus->click_num = 0;
            if ($result = $Ad->add()) {
                $this->success('添加成功！');
            } else {
                $this->error('添加失败！');
            }
        } else {
            $this->error($Ad->getError());
        }
    }

    /**
     * 查询广告信息
     *
     * @param number $id
     *            广告Id
     * @param number $type 广告类型
     */
    public function select()
    {
        $Ad = M('Ad');
    	if(I('param.line_id',0)!=0){
    		$result=$Ad->where('line_id='.I('param.line_id'))->order('click_num desc')->limit(6)->select();
    		$this->ajaxReturn($result);
    	}else{
    		if ($id != 0)
    			$condition ['id'] = $id;
    		if ($type != 0)
    			$condition ['type'] = $type;
    		$result = $Ad->where($condition)->select();
    		if ($result) {
    			var_dump($result);
    		} else {
    			$this->error('查询失败！');
    		}
    	}
        
    }

    /**
     * 测试更新广告信息的方法
     *
     * @param number $id
     *            广告Id
     */
    public function edit($id)
    {
        $Ad = M('Ad');
        if ($id == 0) {
            $result = $Ad->select();
        } else {
            $result = $Ad->find($id);
        }
        if ($result) {
            $this->assign('ad', $result);
        } else {
            $this->error('查询失败！');
        }
        $this->display();
    }

    /**
     * 更新广告
     * @param number $id
     * @param number $click_num
     */
    public function update($id = 0, $click_num = 0, $text = '')
    {
        if (IS_POST) {
            $Ad = D('Ad');
            if ($Ad->create()) {
                $result = $Ad->save();
                if ($result) {
                    $this->success('更新成功！');
                } else {
                    $this->error('更新失败！');
                }
            } else {
                $this->error($Ad->getError());
            }
        } elseif (IS_GET) {
            if ($text != '')
                $data['text'] = $text;
            if ($click_num != 0)
                $data['click_num'] = $click_num;
            $result = $Ad->where('id=' . $id)->setField($data);
        }


    }

    /**
     * 删除广告信息
     * @param unknown $id 广告ID
     */
    public function delete($id)
    {
        $Ad = M('Ad');
        $result = $Ad->delete($id);
        if ($result) {
            $this->success('删除成功！');
        } else {
            $this->error('删除失败！');
        }
    }
    
    public function get_img($ids=0) {
    	$Media=A('Media');
    	$img_list=$Media->get_img();
    	for($i=0;$i<count($img_list);$i++){
    		$img_url[$i]['img']='http://'.GetHostByName($_SERVER['SERVER_NAME']).'/WifiBus/Uploads/'.$img_list[$i]['url'];
    		$img_url[$i]['text']=$img_list[$i]['text'];
    	}
    	$this->ajaxReturn($img_url);
    }
    
    public function upload() {
    	$a=I('param.img_dsc');
    	$b=I('param.text_dsc');
    	$this->ajaxReturn($a);
    }

    
}