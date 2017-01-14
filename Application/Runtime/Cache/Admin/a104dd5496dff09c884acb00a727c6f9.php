<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 数据表格</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="/apply/Public/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/apply/Public/css/font-awesome.css?v=4.4.0" rel="stylesheet">

    <!-- Data Tables -->
    <link href="/apply/Public/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <link href="/apply/Public/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/apply/Public/css/animate.css" rel="stylesheet">
    <link href="/apply/Public/css/style.css?v=4.1.0" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><button type="button" class="btn btn-w-m btn-info" id="addUser">添加管理员</button></h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="table_data_tables.html#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="table_data_tables.html#">选项1</a>
                                </li>
                                <li><a href="table_data_tables.html#">选项2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>账号</th>
                                    <th>一卡通</th>
                                    <th>手机</th>
                                    <th>最后一次登录时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$u): $mod = ($i % 2 );++$i;?><tr class="gradeX" data_id="<?php echo ($u["id"]); ?>">
                                        <td class="account"><?php echo ($u["account"]); ?></td>
                                        <td class="card"><?php echo ($u["id_number"]); ?></td>
                                        <td class="phone"><?php echo ($u["phone"]); ?></td>
                                        <td class="center"><?php echo ($u["last_login_time"]); ?></td>
                                        <td class="client-status">
                                            <a class="label label-primary setRole" href="javascript:;">配置角色</a>
                                            <a class="label label-danger" href="javascript:;">删除</a>
                                        </td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- 添加管理员 -->
    <div class="modal inmodal" id="add" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInY">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">添加管理员</h4>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">用户名：</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="用户名" class="form-control" v-model="account"> 
                                <span class="help-block m-b-none"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">密码：</label>
                            <div class="col-sm-8">
                                <input type="password" placeholder="密码" class="form-control" v-model="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">确认密码：</label>
                            <div class="col-sm-8">
                                <input type="password" placeholder="确认密码" class="form-control" v-model="repassword">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">手机号：</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="输入手机号" class="form-control" v-model="phone"> 
                                <span class="help-block m-b-none"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">一卡通：</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="一卡通号码" class="form-control" v-model="id_number"> 
                                <span class="help-block m-b-none"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal" @click="cancel">关闭</button>
                    <button type="button" class="btn btn-primary" @click="add">保存</button>
                </div>
            </div>
        </div>
    </div>


    <!-- 配置角色 -->
    <div id="role" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <!-- <div class="modal-content"> -->
                <!-- <div class="modal-body"> -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5 id="title"></h5>
                                </div>
                                <div class="ibox-content">
                                    <form class="form-horizontal">

                                        <div class="form-group">
                                            <div class="col-sm-12" id="roleList">

                                                <!-- <?php if(is_array($role)): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><label class="checkbox-inline i-checks">
                                                        <input type="checkbox" value="<?php echo ($r["id"]); ?>" <?php echo ($r["checked"]); ?>><?php echo ($r["name"]); ?></label><?php endforeach; endif; else: echo "" ;endif; ?> -->
                                            </div>
                                        </div>
                                     
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-2">
                                                <input type="hidden" id="uid">
                                                <button class="btn btn-primary" type="button" id="save">保存内容</button>
                                                <button class="btn btn-white" type="button" id="cancel">取消</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- </div> -->
            <!-- </div> -->
        </div>
    </div>

    <!-- 全局js -->
    <script src="/apply/Public/js/jquery.min.js?v=2.1.4"></script>
    <script src="/apply/Public/js/bootstrap.min.js?v=3.3.6"></script>



    <script src="/apply/Public/js/plugins/jeditable/jquery.jeditable.js"></script>

    <!-- Data Tables -->
    <script src="/apply/Public/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="/apply/Public/js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- 自定义js -->
    <script src="/apply/Public/js/content.js?v=1.0.0"></script>
    <script src="/apply/Public/js/plugins/layer/layer.min.js"></script>
    <script src="/apply/Public/js/vue.js"></script>

    <script src="/apply/Public/js/plugins/iCheck/icheck.min.js"></script>


    <!-- Page-Level Scripts -->
    <script>
        function editPhone(id, phone, obj) {
            if (/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/.test(phone) && id) {
                $.post("<?php echo U('User/editPhone');?>", {
                    id : id,
                    phone : phone
                }, function (data) {
                    if (data.status) {
                        layer.msg(data.info, {icon: 1});
                    } else {
                        layer.msg(data.info, {icon: 2});
                    }
                }, 'json');
                obj.parentNode.innerHTML = phone;
            } else {
                obj.focus();
            }
        }

        function editCard(id, id_number, obj) {
            if (id_number && id) {
                $.post("<?php echo U('User/editPhone');?>", {
                    id : id,
                    id_number : id_number
                }, function (data) {
                    if (data.status) {
                        layer.msg(data.info, {icon: 1});
                    } else {
                        layer.msg(data.info, {icon: 2});
                    }
                }, 'json');
                obj.parentNode.innerHTML = id_number;
            } else {
                obj.focus();
            }
        }


        $(document).ready(function () {
            $('.dataTables-example').dataTable();

            // 添加管理员
            $('#addUser').click(function () {
                $('#add').modal({backdrop : false});
            });

            new Vue({
                el : '#add',
                data : {
                    account : '',
                    password : '',
                    repassword : '',
                    phone : '',
                    id_number : ''
                },
                methods : {
                    // 添加
                    add : function () {
                        var _this = this;
                        $.post("<?php echo U('User/addUser');?>", {
                            account : this.account,
                            password : this.password,
                            repassword : this.repassword,
                            phone : this.phone,
                            id_number : this.id_number
                        }, function (data) {
                            if (data.status) {
                                _this.cancel();
                                $('#add').modal('hide');
                                layer.msg(data.info, {icon: 1});
                            } else {
                                layer.msg(data.info, {icon: 2});
                            }
                        });
                    },

                    // 取消
                    cancel : function () {
                        this.account = this.password = this.repassword = this.phone = this.id_number = '';
                    }
                }
            });


            // 修改手机号
            $(document).on('dblclick', '.phone', function () {
                var val = $(this).text(),
                    id = $(this).parent().attr('data_id');
                $(this).html('<input type="text" value="'+val+'" onblur="editPhone('+id+', this.value, this)">');
            });

            // 修改一卡通
            $(document).on('dblclick', '.card', function () {
                var val = $(this).text(),
                    id = $(this).parent().attr('data_id');
                $(this).html('<input type="text" value="'+val+'" onblur="editCard('+id+', this.value, this)">');
            });

            // 设置角色
            $(document).on('click', '.setRole', function () {
                var uid = $(this).parents('tr').attr('data_id');
                $('#uid').val(uid);

                $.get("<?php echo U('User/getRole');?>", {uid :uid}, function (data) {
                    if (data.status) {
                        var str = '';
                        $.each(data.data, function (index, item) {
                            str += '<label class="checkbox-inline i-checks"><input type="checkbox" value="'+item.id+'" '+item.checked+'>'+item.name+'</label>';
                        });
                        $('#roleList').html(str);

                        // 添加样式
                        $('.i-checks').iCheck({
                            checkboxClass: 'icheckbox_square-green',
                            radioClass: 'iradio_square-green',
                        });
                        $('#role').modal({backdrop : false});
                    } else {
                        layer.msg('没有数据', {icon: 2});
                    }
                }, 'json');
            });

            // 配置角色
            $('#save').click(function () {
                var id = $('#uid').val(),
                    arr =[];

                $('input[type="checkbox"]:checked').each(function(){
                    arr.push($(this).val());
                });
                
                if (id && arr.length > 0) {
                    $.post("<?php echo U('User/setRole');?>", {
                        uid : id,
                        role : arr
                    }, function (data) {
                        if (data.status) {
                            $('#role').modal('hide');
                            layer.msg(data.info, {icon: 1});
                        } else {
                            layer.msg(data.info, {icon: 2});
                        }
                    });
                } else {layer.msg('请选择角色', {icon: 2});}
            });

            $('#cancel').click(function () {
                $('#role').modal('hide');
            });


            // 删除
            $(document).on('click', '.label-danger', function () {
                var id = $(this).parents('tr').attr('data_id'),
                    _this = $(this);

                $.get("<?php echo U('User/del');?>", {id : id}, function (data) {
                    if (data.status) {
                        _this.parents('tr').remove();
                        layer.msg(data.info, {icon: 1});
                    } else {
                        layer.msg(data.info, {icon: 2});
                    }
                }, 'json');
            });

        });
    </script>

    
    

</body>

</html>