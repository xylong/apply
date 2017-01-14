<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Leagua</title>
	<link rel="stylesheet" href="/apply/Public/home/css/style.css">
	<link rel="stylesheet" href="/apply/Public/home/css/basic.css">
	<link rel="stylesheet" href="/apply/Public/home/js/dates/dates.css">
	<script src="/apply/Public/home/js/jquery-2.2.4.min.js"></script>
	<script src="/apply/Public/home/js/basic.js"></script>
	<script src="/apply/Public/home/js/dates/dates.js"></script>
</head>
<body>
    <!--header-->
    <div id="header">
        <div class="userBox">
			<p class="user"><span><?php echo session('nickname');?></span><a href="<?php echo U('Admin/Apply/index');?>">后台</a>&nbsp;&nbsp;<a href="<?php echo U('Login/logout');?>">退出</a></p>
		</div>
    </div>
    <!--leftNav-->
    <div id="left-nav">
	    <ul>
	        <li <?php if($menu_action == 'index'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Index/index');?>">申请列表</a></li>
	        <li class="application">
	            <span>申请</span>
	            <ul class="app-menu" <?php if(($menu_action == 'applyMaterials') OR ($menu_action == 'applyWorkshop') OR ($menu_action == 'applySite')): ?>style="display: block;"<?php endif; ?>>
	                <li <?php if($menu_action == 'applyMaterials'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Index/applyMaterials');?>">物资申请</a></li>
	                <li <?php if($menu_action == 'applyWorkshop'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Index/applyWorkshop');?>">工坊申请</a></li>
	                <li <?php if($menu_action == 'applySite'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Index/applySite');?>">场地申请</a></li>
	            </ul>
	        </li>
	        <li <?php if($menu_action == 'resetPwd'): ?>class="active"<?php endif; ?>><a href="<?php echo U('Index/resetPwd');?>">修改密码</a></li>
	    </ul>
	</div>


    <script>
        //申请二级菜单
        $('.application span').click(function(){
            $(this).addClass('active').parent('li').siblings("li").find('span').removeClass('active');
            $(this).parent().find('.app-menu').toggle(300);
        });
        $('.app-menu li').click(function(){
            $(this).addClass("m-active").siblings('li').removeClass('m-active');
            $(this).parent().toggle(300);
        });

    </script>
<div id="content">
    <div class="material_form_box">
        <!--<form action="" method="get" id="form" onsubmit="return save();">-->
        <table class="table">
                <caption align="center">四川大学团委重要物资借用申请表</caption>
                <tr>
                    <td width="25%"><span>主题活动</span></td>
                    <td width="*" colspan="3">
                        <div class="titleBox">
                            <input type="text" name="theme" id="theme" placeholder="请输入" value="<?php echo ($data["theme"]); ?>" <?php if($data['theme']): ?>readonly<?php endif; ?>>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="25%"><span>申请单位</span></td>
                    <td width="25%">
                        <div class="titleBox">
                            <input type="text" name="employer" id="employer" value="<?php echo ($unit); ?>" readonly>
                        </div>
                    </td>
                    <td width="25%"><span>申请借用时间</span></td>
                    <td width="25%">
                        <div class="titleBox">
                            <?php if($data['apply_time']): ?><input type="text" readonly value="<?php echo ($data["apply_time"]); ?>">
                            <?php else: ?>
                                <input type="text" name="useTime" id="useTime" disabled placeholder="请输入"><?php endif; ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><span>申请人、联系方式</span></td>
                    <td colspan="3">
                        <div class="titleBox">
                            <input type="text" name="contact" id="contact" placeholder="请输入" value="<?php echo ($data["phone"]); ?>" <?php if($data['phone']): ?>readonly<?php endif; ?>>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><span>物资使用开始时间</span></td>
                    <td colspan="3">
                        <div class="titleBox">
                            <?php if($data['stime']): ?><input type="text" value="<?php echo ($data["stime"]); ?>" readonly>
                            <?php else: ?>
                                <input type="text" name="startTime" id="startTime" placeholder="请选择" readonly><?php endif; ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><span>物资使用结束时间</span></td>
                    <td colspan="3">
                        <div class="titleBox">
                            <?php if($data['stime']): ?><input type="text" value="<?php echo ($data["etime"]); ?>" readonly>
                            <?php else: ?>
                                <input type="text" name="endTime" id="endTime" placeholder="请选择" readonly><?php endif; ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td rowspan="<?php echo ($count); ?>"><span>物资借用详情</span></td>
                </tr>

                <?php if(is_array($category)): foreach($category as $k=>$cate): ?><tr>
                        <td colspan="3">
                            <div class="equipmentBox" style="text-align:left;">
                                <label>
                                    <span><?php echo ($cate["name"]); ?> (库存<?php echo ($cate["stock"]["total"]); ?> 借出<font color="red"><?php echo ($cate["stock"]["occupy"]); ?></font> 剩余<font class="has" color="green"><?php echo ($cate["stock"]["free"]); ?></font>)</span>
                                    <input type="text" class="textInput" placeholder="输入件数" data-class="<?php echo ($cate["id"]); ?>" oninput="this.value=this.value.replace(/\D/g,'1')">
                                    <span>件</span>
                                </label>
                            </div>
                        </td>
                    </tr><?php endforeach; endif; ?>

<style>
    .qOtherBox span,.qOtherBox input{
        display:block;
        margin:4px 0;
    }
    .qOtherBox input{
        width:100%;
        border-bottom:1px solid #333;
        font-size:12px;
    }
</style>

                <tr>
                    <td colspan="3">
                        <div class="qOtherBox">
                            <span>其它：</span>
                            <input type="text" name="other" placeholder="请输入">
                        </div>
                    </td>
                </tr>
              

                <!-- 校团委签字 -->
                <?php if($data['sign']): ?><tr>
                        <td><span>校团委指导老师意见</span></td>
                        <td colspan="3">
                            <div class="setSeal">
                                <div class="sealBox clearfix">
                                    <div class="tableTextarea fl mb5" style="width: 701px;">
                                        <textarea placeholder="请输入" id="leagueViews" readonly><?php echo ($data["opinion"]); ?></textarea>
                                    </div>
                                    <div class="seal fr">
                                        <img class="sealImg" src="/league//Public/image/yz.png" alt="" style="display: inline;">
                                    </div>
                                </div>
                                <div>
                                    <div class="viewBox">
                                        <label for="input1">
                                            <input type="radio" name="secretary" id="input1" <?php if($data['sign'] != 0): ?>disabled<?php endif; ?> <?php if($data['sign'] == 1): ?>checked<?php endif; ?>>
                                            <span>同意</span>
                                        </label>
                                        <label for="input2">
                                            <input type="radio" name="secretary" id="input2" <?php if($data['sign'] != 0): ?>disabled<?php endif; ?> <?php if($data['sign'] == 2): ?>checked<?php endif; ?>>
                                            <span>不同意</span>
                                        </label>
                                    </div>
                                    <div class="yearBox">
                                        <input type="text" class="year" value="<?php echo (substr($data["signtime"],0,4)); ?>" disabled>
                                        <span>年</span>
                                        <input type="text" class="month" value="<?php echo (substr($data["signtime"],5,2)); ?>" disabled>
                                        <span>月</span>
                                        <input type="text" class="day" value="<?php echo (substr($data["signtime"],8,2)); ?>" disabled>
                                        <span>日</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><span>备注</span></td>
                        <td colspan="3">
                            <div class="tableTextarea"><textarea name="note" id="note" cols="30" rows="10" placeholder="请输入" readonly><?php echo ($data["remark"]); ?></textarea></div>
                        </td>
                    </tr><?php endif; ?>

                <!-- 物管审批 -->
                <?php if($data['isapproval']): ?><tr>
                        <td colspan="2">
                            <div style="color:red;">审核批准</div>
                        </td>
                        <td colspan="2">
                            <div class="viewBox" style="text-align:center">
                                <label for="isApproval1">
                                    <input type="radio" id="isApproval1" name="isApproval" value="1" <?php if($data['isapproval']): ?>disabled<?php endif; ?> <?php if($data['isapproval'] == 1): ?>checked<?php endif; ?>>
                                    <span>同意借出</span>
                                </label>
                                <label for="isApproval2">
                                    <input type="radio" id="isApproval2" name="isApproval" value="2" <?php if($data['isapproval']): ?>disabled<?php endif; ?> <?php if($data['isapproval'] == 2): ?>checked<?php endif; ?>>
                                    <span>不同意</span>
                                </label>
                            </div>
                        </td>
                    </tr><?php endif; ?>

                
                <?php if(!$data['id']): ?><tr>
                        <td colspan="4">
                            <div class="save">
                                <input class="submit" type="button" value="提交">
                            </div>
                        </td>
                    </tr><?php endif; ?>


                <?php if($data['isapproval'] == 1): ?><tr>
                        <td><span style="color:#ff7802;">借出物资</span></td>
                        <td colspan="3">
                            <div class="setSeal">
                                <div class="sealBox clearfix" style="border-top: 0;border-left: 0;border-right: 0;border-bottom: 1px solid #ddd;">
                                    <div class="tableTextarea fl mb5" style="width: 701px;padding-top:15px;padding-bottom:15px;font-size:14px;color:#099;">
                                        <?php if(is_array($lend)): foreach($lend as $key=>$vo): ?><p style="line-height:14px;padding-top:10px;text-align:left;">
                                                <?php echo ($key); ?>:
                                                <?php if(is_array($vo)): $i = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; echo ($v["number"]); ?>&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
                                            </p><?php endforeach; endif; ?>
                                    </div>
                                </div>
                                <div>
                                    <?php if($data['isreturn'] == 1): ?><div class="yearBox">
                                            <span style="padding-top:5px;">归还日期</span>
                                            <input type="text" class="year" value="<?php echo (substr($data["return_time"],0,4)); ?>" disabled>
                                            <span>年</span>
                                            <input type="text" class="month" value="<?php echo (substr($data["return_time"],5,2)); ?>" disabled>
                                            <span>月</span>
                                            <input type="text" class="day" value="<?php echo (substr($data["return_time"],8,2)); ?>"  disabled>
                                            <span>日</span>
                                        </div>
                                    <?php else: ?>
                                    <div class="yearBox">
                                        <span style="padding:5px;color:red;font-size:16px;">未归还</span>
                                    </div><?php endif; ?>
                                </div>
                            </div>
                        </td>
                    </tr><?php endif; ?>

            </table>
        <!--</form>-->
    </div>
<script>
    $(function(){

        $('#startTime').click(function(){
            var start = new Dates({
                id:'startTime',
                sTime:false
            });
            start.init();
        });
        $('#endTime').click(function(){
            var end = new Dates({
                id:'endTime',
                sTime:false
            });
            end.init();
        });

        show.seal();
        show.setStarTime($('#useTime'));

        $('.textInput').blur(function(){
            var text = $(this).val(),has=$(this).parents('.equipmentBox').find('.has').text();
            if(!/^[0-9]*[0-9][0-9]*$/.test(text)){
                $(this).focus().css('border-color','#f00');
                return show.info('请正确输入租借件数',80,2000);
            }else{
                $(this).css('border-color','#333');
            }
            if(parseInt(text)>parseInt(has)){
                $(this).focus().css('border-color','#f00');
                return show.info('借出件数必须小于剩余件数',80,2000);
            }else{
                $(this).css('border-color','#333');
            }
        });

        // 提交
        $('.save .submit').click(function(){
            var self = $(this);
            if($(this).hasClass('disabled'))
                return false;
            var theme = $('#theme').val(); // 主题活动
            var contact = $('#contact').val(); // 申请人联系方式;
            var start = {
                time:$('#startTime').attr('time'),
                id:$('#startTime').attr('sid')
            };
            var end = {
                time:$('#endTime').attr('time'),
                id:$('#endTime').attr('sid')
            };
            var secretary = $('input[name="secretary"]:checked').val(); // 是否同意;
            var other = $("input[name='other']").val(); // 其它


            // 借用的物品数量
            var oInput = $('.textInput'),
                arr = [];

            oInput.each(function () {
                if ($(this).val()) {
                    arr.push($(this).attr('data-class') + '_' + $(this).val());
                }
            });

            if(theme=='' || contact=='' || start.time==undefined || end.time == undefined)
                return show.info('请完善信息');
            if(arr.length==0)
                return show.info('请正确输入租借数量');
            if(!(/^1[3|4|5|7|8]\d{9}$/.test(contact)))
                return show.info('请输入正确手机号');
            if(parseInt(start.time)>parseInt(end.time)||(parseInt(start.time)==parseInt(end.time)&&parseInt(start.id)>parseInt(end.id)))
                return show.info('开始时间应该小于结束时间,请重新选择');

            $.ajax({
                "url":"<?php echo U('Index/applyMaterials');?>",
                "type":"post",
                "cache":false,
                "data":{
                    theme : theme,
                    phone : contact,
                    stime : start,
                    etime : end,
                    quantity : arr,
                    other : other
                },
                "dataType":"json",
                "beforeSend":function(){
                    $(self).addClass('disabled');
                },
                "success":function(data){
                    if (data.status == 1) {
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    }
                    show.info(data.info);
                },
                "error":function(msg){
                    show.info(msg.readyState);
                },
                "complete":function(){
                    $(self).removeClass('disabled');
                }
            });
        });

    });

</script>