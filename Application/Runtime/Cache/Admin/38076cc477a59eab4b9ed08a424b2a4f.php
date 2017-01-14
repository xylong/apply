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

    <link href="/apply/Public/css/animate.css" rel="stylesheet">
    <link href="/apply/Public/css/style.css?v=4.1.0" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">

                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>账号</th>
                                    <th>昵称</th>
                                    <th>类型</th>
                                    <th>手机</th>
                                    <th>学院</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$u): $mod = ($i % 2 );++$i;?><tr class="gradeX" data_id="<?php echo ($u["id"]); ?>">
                                        <td class="account"><?php echo ($u["account"]); ?></td>
                                        <td class="card"><?php echo ($u["nickname"]); ?></td>
                                        <td class="phone">
                                            <?php if($u['utype'] == 1): ?>学院团委学生会
                                            <?php elseif($u['utype'] == 2): ?>社团
                                            <?php else: ?>校级学生组织<?php endif; ?>
                                        </td>
                                        <td class="center"><?php echo ($u["phone"]); ?></td>
                                        <td class="center"><?php echo ($u["cname"]); ?></td>
                                        <td class="client-status">
                                            <a class="label label-primary setRole modify" href="javascript:;">编辑</a>
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


    <div class="modal inmodal" id="edit" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInY">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">编辑</h4>
                </div>
                <div class="ibox-content">
                    <form method="get" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">账号</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="account">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">密码</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="password"> <span class="help-block m-b-none text-warning">不修改密码勿填</span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">昵称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nickname">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">手机</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="phone">
                            </div>
                        </div>
                        <!-- <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">禁用</label>
                            <div class="col-sm-10">
                                <input type="text" disabled="" placeholder="已被禁用" class="form-control">
                            </div>
                        </div> -->
                    </form>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="user_id">
                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" id="save">保存</button>
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
    <script src="/apply/Public/js/layer/layer.js"></script>
    <script src="/apply/Public/js/content.js?v=1.0.0"></script>


    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function () {
            $('.dataTables-example').dataTable();
        });

        $(document).on('click', '.modify', function () {
            var id = $(this).parents('tr').attr('data_id');

            $.get("<?php echo U('Applicant/getInfo');?>", {id : id}, function (data) {
                if (data.status) {
                    $('#user_id').val(data.data.id),
                    $('#account').val(data.data.account);
                    $('#nickname').val(data.data.nickname);
                    $('#phone').val(data.data.phone);
                }
            }, 'json');

            $('#edit').modal({backdrop : false});
        });

        // 修改
        $(document).on('click', '#save', function () {
            var data = {
                id : $('#user_id').val(),
                account : $('#account').val(),
                nickname : $('#nickname').val(),
                phone : $('#phone').val()
            };

            if ($('#password').val().length !== 0) {
                data.password = $('#password').val();
            }

            $.post("<?php echo U('Applicant/edit');?>", data, function (data) {
                if (data.status) {
                    layer.msg(data.info, {icon: 1});
                } else {
                    layer.msg(data.info, {icon: 2});
                }
            }, 'json');
        });

        $(document).on('click', '.label-danger', function () {
            var id = $(this).parents('tr').attr('data_id'),
                _this = $(this);

            $.get("<?php echo U('Applicant/del');?>", {id : id}, function (data) {
                if (data.status) {
                    _this.parents('tr').remove();
                    layer.msg(data.info, {icon: 1});
                } else {
                    layer.msg(data.info, {icon: 2});
                }
            }, 'json');
        });
    </script>

    
    

</body>

</html>