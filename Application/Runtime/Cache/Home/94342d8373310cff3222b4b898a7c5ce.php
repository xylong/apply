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
        <table class="table">
            <caption align="center">青春工坊申请确认表</caption>
            <tr>
                <td width="25%"><span>申请单位</span></td>
                <td width="*" colspan="3">
                    <div class="titleBox">
                        <input id="employ" type="text" placeholder="请输入" value="<?php echo ($unit); ?>" readonly>
                    </div>
                </td>
            </tr>
            <tr>
                <td width="25%"><span>申请人</span></td>
                <td width="*" colspan="3">
                    <div class="titleBox">
                        <input id="emPerson" type="text" placeholder="请输入" value="<?php echo ($apply["emperson"]); ?>" <?php if($apply['emperson']): ?>readonly<?php endif; ?>>
                    </div>
                </td>
            </tr>
            <tr>
                <td width="25%"><span>申请时间</span></td>
                <td width="*" colspan="3">
                    <div class="titleBox">
                        <?php if($apply['apply_time']): ?><input disabled type="text" placeholder="请输入" value="<?php echo ($apply["apply_time"]); ?>">
                        <?php else: ?>
                            <input id="emTime" disabled type="text" placeholder="请输入"><?php endif; ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td><span>借用场地</span></td>
                <?php if($apply['venue']): ?><td colspan="3">
                        <div class="equipmentBox">
                            <?php if(is_array($place)): foreach($place as $key=>$p): ?><label for="checkbox">
                                    <input type="checkbox" name="equip" <?php echo ($p["checked"]); ?>>
                                    <span><?php echo ($p["name"]); ?></span>
                                </label><?php endforeach; endif; ?>
                        </div>
                    </td>
                <?php else: ?>
                    <td colspan="3">
                        <div class="equipmentBox">
                            <?php if(is_array($place)): foreach($place as $k=>$p): ?><label for="radioEq<?php echo ($k + 1); ?>">
                                    <input type="radio" name="equip" value="<?php echo ($p["id"]); ?>" id="radioEq<?php echo ($k + 1); ?>">
                                    <span><?php echo ($p["name"]); ?></span>
                                </label><?php endforeach; endif; ?>
                        </div>
                    </td><?php endif; ?>
            </tr>
            <tr>
                <td width="25%"><span>使用时间</span></td>
                <td width="*" colspan="3">
                    <div class="titleBox">
                        <?php if($apply['id']): ?><input type="text" class="inputUserTime" value="<?php echo ($apply["stime"]); ?> 至 <?php echo ($apply["etime"]); ?>" readonly>
                        <?php else: ?>
                            <input type="text" class="inputUserTime" id="useTime" placeholder="请选择"><?php endif; ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td width="25%"><span>联系方式</span></td>
                <td width="25%">
                    <div class="titleBox">
                        <input type="text" name="contact" id="contact" value="<?php echo ($apply["phone"]); ?>" placeholder="请输入" <?php if($apply['phone']): ?>readonly<?php endif; ?>>
                    </div>
                </td>
                <td width="25%"><span>指导老师</span></td>
                <td width="25%">
                    <div class="titleBox">
                        <input type="text" name="counselor" id="counselor" value="<?php echo ($apply["counselor"]); ?>" placeholder="请输入" <?php if($apply['counselor']): ?>readonly<?php endif; ?> >
                    </div>
                </td>
            </tr>
    <!--         <tr>
                <td colspan="2">
                    <div>我已阅读相关制度,愿自觉遵守,若造成损失,将承担所有赔偿</div>
                </td>
                <td colspan="2">
                    <div class="viewBox" style="text-align:center">
                        <label for="input1">
                            <input type="radio" id="input1" name="isAgree" value="1" <?php if($apply['isagree'] == 1): ?>checked<?php endif; ?>>
                            <span>同意</span>
                        </label>
                        <label for="input2">
                            <input type="radio" id="input2" name="isAgree" value="2" <?php if($apply['isagree'] == 2): ?>checked<?php endif; ?>>
                            <span>不同意</span>
                        </label>
                    </div>
                </td>
            </tr> -->
            <tr>
                <td><span>使用事由</span></td>
                <td colspan="3">
                    <div class="reasonably"><textarea name="note" id="note" cols="30" rows="10" placeholder="请输入" <?php if($apply['reason']): ?>readonly<?php endif; ?>><?php echo ($apply["reason"]); ?></textarea></div>
                </td>
            </tr>
            <?php if($apply['remark']): ?><tr>
                    <td><span>备注</span></td>
                    <td colspan="3">
                        <div class="reasonably"><textarea name="remark" id="remark" cols="30" rows="10" placeholder="请输入拒绝理由" readonly><?php echo ($apply["remark"]); ?></textarea></div>
                    </td>
                </tr>
            <?php else: ?>
                <tr>
                    <td><span>填表说明</span></td>
                    <td colspan="3">
                        <div class="workText">
                            <p>1、填写时须准确填写开始使用时间,须精确到分钟。</p>
                            <p>2、原则上个单位每周预约场地次数不得超过两次,每次不得超过三个小时。</p>
                            <p>3、使用期间请自觉遵守学生专用活动场地的管理制度。</p>
                        </div>
                    </td>
                </tr><?php endif; ?>
            <?php if($apply['id']): ?><tr>
                    <td colspan="2">
                        <div class="isapproval">审核批准</div>
                    </td>
                    <td colspan="2">
                        <div class="viewBox" style="text-align:center">
                            <label for="isApproval1">
                                <input type="radio" id="isApproval1" name="isApproval" value="1" disabled <?php if($apply['isapproval'] == 1): ?>checked<?php endif; ?>>
                                <span>同意</span>
                            </label>
                            <label for="isApproval2">
                                <input type="radio" id="isApproval2" name="isApproval" value="2" disabled <?php if($apply['isapproval'] == 2): ?>checked<?php endif; ?>>
                                <span>不同意</span>
                            </label>
                        </div>
                    </td>
                </tr><?php endif; ?>

            <?php if(!$apply['id']): ?><tr>
                    <td colspan="4">
                        <div class="save">
                            <input class="submit" type="button" value="提交">
                        </div>
                    </td>
                </tr><?php endif; ?>
        </table>
    </div>
</div>
<script>

    $(function(){
        show.setStarTime($('#emTime'));
        $('#useTime').click(function(){
            var checked = $('input[name="equip"]:checked').val();
            if(checked==undefined)
                return show.info('请先选择需要借用的场地');
            var times = new Dates({
                id:'useTime',
                checked:checked,
                sTime:true
            });
            times.init();
        });
        $('.save .submit').click(function(){
            var self = $(this);
            if($(this).hasClass('gray')) return;
            var employ = $('#employ').val(); // 申请单位;
            var emPerson = $('#emPerson').val(); // 申请人;
            var emTime = $('#emTime').val();
            var contact = $('#contact').val();
            var time = $('#useTime').attr('time');
            var id = $('#useTime').attr('sid');
            var counselor = $('#counselor').val();
            var eqArr = [];
            var isAgree = $('input[name="isAgree"]:checked').val();
            var note = $('#note').val();
            $('input[name="equip"]:checked').each(function(){
                eqArr.push($(this).val());
            });
            if(employ==''||emPerson==''||contact==''||counselor==''||note=='')
                return show.info('请完善信息');
            if(!(/^1[3|4|5|7|8]\d{9}$/.test(contact)))
                return show.info('请输入正确手机号');
            // if(isAgree == 2 || isAgree == undefined)
            //     return show.info('必须同意相关制度条款');
            if(eqArr.length==0)
                return show.info('请选择借用场地');
            $.ajax({
                type:'POST',
                url:"<?php echo U('Index/applyWorkshop');?>",
                cache:false,
                data:{
                    "emPerson":emPerson, // 申请人;
                    "useTime":{time:time,id:id}, // 借用时间;
                    "phone":contact, // 联系方式;
                    "counselor":counselor, // 指导老师;
                    "venue":eqArr, // 借用场地;
                    "reason":note, // 事由;
                },
                dataType:'json',
                beforeSend:function(){
                    $(self).addClass('disabled');
                },
                success:function(data){
                    if (data.status) {
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                        show.info(data.info);
                    } else {
                        show.info(data.info);
                    }
                },
                error:function(msg){
                    console.log(msg.info);
                    show.info(msg.readyState);
                },
                complete:function(){
                    $(self).removeClass('disabled');
                }
            });
        });
    })

</script>