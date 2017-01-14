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
                        <h5><button type="button" class="btn btn-w-m btn-info" id="addCollege">添加学院/机构</button></h5>
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
                                    <th>ID</th>
                                    <th>账号</th>
                                    <th></th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$c): $mod = ($i % 2 );++$i;?><tr data_id="<?php echo ($c["id"]); ?>">
                                        <td><a data-toggle="tab" href="#contact-1" class="client-link"><?php echo ($c["id"]); ?></a></td>
                                        <td> <?php echo ($c["name"]); ?> </td>
                                        <td class="contact-type"><i class="fa fa-user"> </i></td>
                                        <td class="client-status">
                                        <a class="label label-primary setUser" href="javascript:;">设置负责人</a>
                                        </td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
       
    </div>


    <!-- 设置负责人 -->
    <div id="modal-form" class="modal fade" aria-hidden="true">
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
                                            <div class="col-sm-12" id="userList">

                                             <!--    <?php if(is_array($users)): $i = 0; $__LIST__ = $users;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$u): $mod = ($i % 2 );++$i;?><label class="checkbox-inline i-checks">
                                                        <input type="checkbox" value="<?php echo ($u["id"]); ?>"><?php echo ($u["account"]); ?></label><?php endforeach; endif; else: echo "" ;endif; ?> -->
                                            </div>
                                        </div>
                                     
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-2">
                                                <input type="hidden" id="cid">
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


    <!-- 添加学院/机构 -->
    <!-- 添加管理员 -->
    <div class="modal inmodal" id="add" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInY">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">新增单位</h4>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">名 称：</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="输入学院或组织单位" class="form-control" id="name"> 
                                <span class="help-block m-b-none"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" id="saveCollege">保存</button>
                </div>
            </div>
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
    <script src="/apply/Public/js/plugins/iCheck/icheck.min.js"></script>


    <!-- Page-Level Scripts -->
    <script>
        function setTitile(id, name) {
            $('#title').text(name);
            $('#cid').val(id);
        }

        $(document).ready(function () {
            $('.dataTables-example').dataTable();

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            // 设置负责人
            $(document).on('click', '.setUser', function () {
                var cid = $(this).parents('tr').attr('data_id');
                $('#cid').val(cid);

                $.get("<?php echo U('Group/getUser');?>", {cid :cid}, function (data) {
                    if (data.status) {
                        var str = '';
                        $.each(data.data, function (index, item) {
                            str += '<label class="checkbox-inline i-checks"><input type="checkbox" value="'+item.id+'" '+item.checked+'>'+item.account+'</label>';
                        });
                        $('#userList').html(str);

                        // 添加样式
                        $('.i-checks').iCheck({
                            checkboxClass: 'icheckbox_square-green',
                            radioClass: 'iradio_square-green',
                        });
                        $('#modal-form').modal({backdrop : false});
                    } else {
                        layer.msg('没有数据', {icon: 2});
                    }
                }, 'json');
            });

            // 退出
            $('#cancel').click(function () {
                $('#modal-form').modal('hide');
            });

            // 保存
            $('#save').click(function () {
                var id = $('#cid').val(),
                    arr =[];

                $('input[type="checkbox"]:checked').each(function(){
                    arr.push($(this).val());
                });
                
                $.post("<?php echo U('Group/saveConfigure');?>", {
                    id : id,
                    data : arr
                }, function (data) {
                    if (data.status) {
                        $('#modal-form').modal('hide');
                        layer.msg(data.info, {icon: 1});
                    } else {
                        layer.msg(data.info, {icon: 2});
                    }
                }, 'json');
            });

            $('#addCollege').click(function () {
                $('#add').modal({backdrop : false});
            });

            $('#saveCollege').click(function () {
                var name = $('#name').val();
                if (name.length) {
                    $.post("<?php echo U('Group/addCollege');?>", {name : name}, function (data) {
                        if (data.status) {
                            $('#add').modal('hide');
                        layer.msg(data.info, {icon: 1});
                        } else {
                            layer.msg(data.info, {icon: 2});
                        }
                    } ,'json');
                } else {
                    layer.msg('请输入名称', {icon: 2});
                }
            });


        });

        
    </script>

    
    

</body>

</html>