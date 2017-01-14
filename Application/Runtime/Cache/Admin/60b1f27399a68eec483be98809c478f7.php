<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 角色管理</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="/apply/Public/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/apply/Public/css/font-awesome.css?v=4.4.0" rel="stylesheet">

    <link href="/apply/Public/css/animate.css" rel="stylesheet">
    <link href="/apply/Public/css/style.css?v=4.1.0" rel="stylesheet">

</head>

<body class="gray-bg" id="role">
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-sm-6">
                <div class="ibox">
                    <div class="ibox-content">
                        <span class="text-muted small pull-right">最后更新：<i class="fa fa-clock-o"></i> 2015-09-01 12:00</span>
                        <h2>角色管理</h2>
                        <p>
                            角色列表
                        </p>
                        <div class="row m-b-sm m-t-sm">
                            <div class="col-md-1">
                                <button type="button" id="loading-example-btn" class="btn btn-white btn-sm" @click="reload"><i class="fa fa-refresh"></i> 刷新</button>
                            </div>
                            <div class="col-md-11">
                                <form role="form" class="form-inline" action="<?php echo U('Borrow/export');?>" method="post" id="export">
                                    <button class="btn btn-primary" type="button" @click="addRole"><i class="fa fa-user-plus"></i>&nbsp;新增角色</button>
                                </form>
                            </div>
                        </div>
                        <div class="clients-list">
                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                    <div class="full-height-scroll">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <tbody>
                                                    <tr v-for="v in list">
                                                        <td><a data-toggle="tab" href="javascript:;" class="client-link" v-text="v.id"></a></td>
                                                        <td v-text="v.name"></td>
                                                        <td v-text="v.remark"></td>
                                                        <td class="client-status"><span style="cursor:pointer;" class="label label-primary" @click="review(v.id, v.name)">成员</span></td>
                                                        <td class="client-status"><span style="cursor:pointer;" class="label label-danger pull-right" @click="setRight(v.id, v.name)">配置权限</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6" v-if="list.length !== 0">
                <div class="ibox float-e-margins">
                    <div class="ibox-content mailbox-content">
                        <div class="file-manager">
                            <div class="space-25"></div>
                            <h5 class="tag-title" v-text="title"></h5>
                            <ul class="tag-list" style="padding: 0">
                                <li v-for="v in users">
                                    <a href="javascript:;"><i class="fa fa-user"></i>&nbsp;{{v.account}}</a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- 弹窗 -->
    <div class="modal inmodal" id="add" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInY">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">新增角色</h4>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">名 称：</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="输入分类名称" class="form-control" v-model="name"> 
                                <span class="help-block m-b-none"></span>
                            </div>
                            <label class="col-sm-3 control-label">描 述：</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" placeholder="输入简介描述" aria-required="true" v-model="remark"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" @click="saveRole">保存</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal inmodal" id="right" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated flipInY">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" v-text="title"></h4>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">内联复选框</label>

                            <div class="col-sm-10">
                                <label class="checkbox-inline" v-for="v in right">
                                    <input type="checkbox" value="{{v.id}}" v-model="checked">{{v.name}}</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" @click="saveRight">保存</button>
                </div>
            </div>
        </div>
    </div>


    <!-- 全局js -->
    <script src="/apply/Public/js/jquery.min.js?v=2.1.4"></script>
    <script src="/apply/Public/js/bootstrap.min.js?v=3.3.6"></script>

    <script src="/apply/Public/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- 自定义js -->
    <script src="/apply/Public/js/content.js?v=1.0.0"></script>
    <script src="/apply/Public/js/layer/layer.js"></script>
    <script src="/apply/Public/js/vue.js"></script>

    <script>
        $(function () {
            $('.full-height-scroll').slimScroll({
                height: '100%'
            });
        });

        var role = new Vue({
            el : '#role',
            data : {
                list : [],
                users : [],

                title : '',
                name : '',
                remark : '',

                right : [],
                checked : [],
                id : ''
            },
            methods : {
                reload : function () {
                    // body...
                },

                addRole : function () {
                    $('#add').modal({backdrop : false});
                },

                // 查看
                review : function (id, name) {
                    this.users = [];
                    this.title = name;

                    $.get("<?php echo U('Rbac/get_user_by_role');?>", {
                        id : id
                    },function (data) {
                        if (data.status) {
                            role.users = data.data;
                        } else {
                            layer.msg(data.info, {icon: 2});
                        }
                    }, 'json');
                },

                saveRole : function () {
                    $.post("<?php echo U('Rbac/addRole');?>", {
                        name : this.name,
                        remark : this.remark
                    },function (data) {
                        if (data.status) {
                            layer.msg('新增成功', {icon: 1});
                        } else {
                            layer.msg('新增失败', {icon: 2});
                        }
                    }, 'json');
                },

                setRight : function (id, name) {
                    this.title = name;
                    this.id = id;

                    $.get("<?php echo U('Rbac/getRight');?>", {
                        id : id
                    },function (data) {
                        if (data.status) {
                            role.right = data.data;
                            $('#right').modal({backdrop : false});
                        }
                    }, 'json');
                },

                saveRight : function () {
                    $.post("<?php echo U('Rbac/setRight');?>", {
                        id : this.id,
                        aid : this.checked
                    },function (data) {
                        if (data.status) {
                            layer.msg(data.info, {icon: 1});
                        } else {
                            layer.msg(data.info, {icon: 2});
                        }
                    }, 'json');
                }

            },
            ready : function () {
                $.get("<?php echo U('Rbac/roleList');?>", function (data) {
                    if (data.status) {
                        role.list = data.data;
                    }
                }, 'json');
            }
        });

    </script>
</body>

</html>