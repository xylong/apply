<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 客户管理</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="/apply/Public/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="/apply/Public/css/font-awesome.css?v=4.4.0" rel="stylesheet">

    <link href="/apply/Public/css/animate.css" rel="stylesheet">
    <link href="/apply/Public/css/style.css?v=4.1.0" rel="stylesheet">

</head>

<body class="gray-bg" id="apply">
    <div class="wrapper wrapper-content  animated fadeInRight">
        <div class="row">
            <div class="col-sm-6">
                <div class="ibox">
                    <div class="ibox-content">
                        <span class="text-muted small pull-right">最后更新：<i class="fa fa-clock-o"></i> 2015-09-01 12:00</span>
                        <h2>申请列表</h2>
                        <p>
                            物资申请
                        </p>
                        <div class="row m-b-sm m-t-sm">
                            <div class="col-md-1">
                                <button type="button" id="loading-example-btn" class="btn btn-white btn-sm" @click="relaod"><i class="fa fa-refresh"></i> 刷新</button>
                            </div>
                            <div class="col-md-11">
                                <form role="form" class="form-inline" action="<?php echo U('Borrow/export');?>" method="post" id="export">
                                    <div class="form-group" id="data_5">
                                        <div class="input-daterange input-group" id="datepicker">
                                            <input id="sdate" class="input-sm form-control" name="sdate" placeholder="选择开始时间" readonly>
                                            <span class="input-group-addon">到</span>
                                            <input id="edate" class="input-sm form-control" name="edate" placeholder="选择结束时间" readonly>
                                        </div>
                                    </div>
                                    <button class="btn btn-white" type="button" @click="export"><i class="fa fa-sign-out"></i>导出</button>
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
                                                    <tr v-for="v in application">
                                                        <td><a data-toggle="tab" href="javascript:;" class="client-link" v-text="v.apply_code"></a></td>
                                                        <td v-text="v.theme"></td>
                                                        <td v-if="v.isagree == 1" class="text-navy"><i class="fa fa-check"></i></td>
                                                        <td v-if="v.isagree == 2" class="text-danger"><i class="fa fa-close"></i></td>
                                                        <td v-if="v.isagree == null" class="text-warning"><i class="fa fa-spinner"></i></td>
                                                        <td v-text="v.apply_time"></td>
                                                        <td class="client-status"><span style="cursor:pointer;" class="label label-primary" @click="review(v.id)">审核</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div id="page"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6" v-if="info.length !== 0">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row m-t-sm">
                            <div class="col-sm-12">
                                <div class="panel blank-panel">
                                    <div class="panel-body">
                                        <div class="tab-content">
                                            <div v-bind:class="[isActive ? activeClass : '', showClass]">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="m-b-md">
                                                            <h2 v-text="info.theme"></h2>
                                                        </div>
                                                        <dl class="dl-horizontal">
                                                            <dt>当前进度</dt>
                                                            <dd>
                                                                <div class="progress progress-striped active m-b-sm">
                                                                    <div v-bind:style="progress;" class="progress-bar"></div>
                                                                </div>
                                                                <small>当前已完成申请总进度的 <strong v-text="progress.width"></strong></small>
                                                            </dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <dl class="dl-horizontal">
                                                            <dt>联系方式：</dt>
                                                            <dd v-text="info.phone"></dd>
                                                            <dt>申请单位：</dt>
                                                            <dd v-text="info.nickname"></dd>
                                                        </dl>
                                                    </div>
                                                    <div class="col-sm-7" id="cluster_info">
                                                        <dl class="dl-horizontal">
                                                            <dt>开始时间：</dt>
                                                            <dd v-text="info.stime"></dd>
                                                            <dt>结束时间：</dt>
                                                            <dd v-text="info.etime"></dd>
                                                            <dt>借用详情</dt>
                                                            <dd>
                                                                <ul>
                                                                    <li v-for="item in info.borrow">
                                                                        <span class="text-primary">{{item.name}}</span>&nbsp;&nbsp;
                                                                        <span class="text-warning">{{item.number}}个</span>
                                                                    </li>
                                                                  </ul>
                                                            </dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="form-group" v-for="item in info.equipments">
                                                        <label class="col-sm-2 control-label" v-text="item.name"></label>
                                                        <div class="col-sm-10">
                                                            <label class="checkbox-inline" v-for="e in item.child">
                                                                <input v-if="info.isagree == null" type="checkbox" v-bind:value="e.id" v-model="equipments">{{e.number}}</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="hr-line-dashed"></div>

                                                <div class="ibox float-e-margins">
                                                    <div class="ibox-title">
                                                        <h5 v-text="info.theme + '审核详情'"></h5>
                                                    </div>

                                                    <div class="timeline-item" v-for="(index, v) in step">
                                                        <div class="row">
                                                            <div class="col-xs-3 date" :class="highlight">
                                                                <i v-if="v.isagree == null" class="fa fa-spinner"></i>
                                                                <i v-if="v.isagree == 1" class="fa fa-check"></i>
                                                                <i v-if="v.isagree == 2" class="fa fa-close"></i>
                                                                <p v-if="v.time" class="text-info" v-text="v.time"></p>
                                                                <p v-else class="text-info">待审核</p>
                                                                <br>
                                                                <button v-if="v.isagree == null && v.access == 1" type="button" class="btn btn-primary btn-xs" @click="submit">提交</button>
                                                            </div>
                                                            <div class="col-xs-7 content">
                                                                <p class="m-b-xs"><strong class="text-warning" v-text="v.name"></strong></p>
                                                                <div class="col-sm-12">
                                                                    <textarea v-if="v.isagree == null && v.access == 1" class="form-control" v-model="opinion"></textarea>
                                                                    <p v-else v-text="v.opinion" class="text-success"></p>

                                                                    <div class="switch" v-if="v.isagree == null && v.access == 1">
                                                                        <div class="onoffswitch">
                                                                            <input type="checkbox" v-model="isagree" class="onoffswitch-checkbox" id="{{'example' + index}}">
                                                                            <label class="onoffswitch-label" for="{{'example' + index}}">
                                                                                <span class="onoffswitch-inner"></span>
                                                                                <span class="onoffswitch-switch"></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 全局js -->
    <script src="/apply/Public/js/jquery.min.js?v=2.1.4"></script>
    <script src="/apply/Public/js/bootstrap.min.js?v=3.3.6"></script>

    <script src="/apply/Public/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- 自定义js -->
    <script src="/apply/Public/js/jquery.twbsPagination.js" charset="utf-8"></script>
    <script src="/apply/Public/js/plugins/layer/laydate/laydate.js"></script>
    <script src="/apply/Public/js/content.js?v=1.0.0"></script>
    <script src="/apply/Public/js/layer/layer.js"></script>
    <script src="/apply/Public/js/vue.js"></script>

    <script>
        $(function () {
            $('.full-height-scroll').slimScroll({
                height: '100%'
            });
        });

        laydate({
            elem: '#sdate',
            event: 'focus'
        });
        laydate({
            elem: '#edate',
            event: 'focus'
        });

        var apply = new Vue({
            el : '#apply',
            data : {
                activeClass: 'active',
                showClass: 'tab-pane',
                isActive : true,
                highlight : '',

                info : [],  // 申请内容
                step : [],  // 审核流程
                type : 1,    // 申请类型

                application : [],    // 申请
                visiblePages : '',
                equipments : [],    // 选中的要借出的设备

                opinion : '',
                isagree : false,
                progress : {
                    width : '0%',
                }
            },
            methods : {
                tab : function (bool) {
                    this.isActive = bool;
                },

                // 刷新
                relaod : function () {
                    $.get("<?php echo U('Borrow/lists');?>", function (data) {
                        if (data.status) {
                            apply.application = data.data.data;
                        }
                    }, 'json');
                },

                page : function (pageid) {
                    $.get("<?php echo U('Borrow/lists');?>", {
                        pageid : localStorage.page
                    }, function (data) {
                        if (data.status) {
                            apply.application = data.data.data;
                            apply.visiblePages = data.data.count;

                            $('#page').twbsPagination({
                                totalPages: apply.visiblePages,
                                visiblePages: apply.visiblePages,
                                version: '1.1',
                                onPageClick: function(event, page) {
                                    localStorage.page = page;
                                    apply.page(apply.type, page);
                                    $('#page-content').text('Page ' + page);
                                }
                            });
                        }
                    }, 'json');
                },

                // 查看审核
                review : function (id) {
                    $.get("<?php echo U('Borrow/review');?>", {
                        id : id,
                        type : this.type
                    }, function (data) {
                        if (data.status) {
                            apply.info = data.data.info;
                            apply.step = data.data.step;

                            // 审核进程高亮
                            switch (apply.step[0]['isagree']) {
                                case '1':
                                    apply.highlight = 'text-success';
                                    break;
                                case '2':
                                    apply.highlight = 'text-danger';
                                    break;
                                default:
                                    apply.highlight = 'text-warning';
                                    break;
                            }

                             // 计算进度
                            var numerator = 0, // 分子
                                denominator = apply.step.length;

                            for (var i = 0; i < denominator; i++) {
                                if (apply.step[i].isagree != null) {
                                    numerator++;
                                }
                            }
                            apply.progress.width = Math.ceil(numerator / denominator * 100) + '%';
                        } else {
                            layer.msg('获取审核信息失败', {icon: 2});
                        }
                    }, 'json');
                },

                export : function () {
                    var sdate = $('#sdate').val(),
                        edate = $('#edate').val();

                    if (sdate.length !== 0 && edate.length !== 0) {
                        // 结束时间大于开始时间
                        if (sdate <= edate) {
                            $('#export').submit();
                        } else {
                            layer.msg('开始日期不能大于结束日期', {icon: 2});
                        }
                    } else {
                        layer.msg('请选择日期范围', {icon: 2});
                    }
                },

                submit : function () {
                    // 设备锁定(分配)
                    if (this.equipments.length === 0) {
                        if (this.isagree) {
                            layer.msg('您还未选择借出的设备', {icon: 2});
                            return;
                        }
                    } else {
                        if (this.isagree) {
                            $.post("<?php echo U('Material/review');?>", {
                                id : this.info.id,
                                data : this.equipments
                            }, function (data) {
                                if (data.status) {
                                    apply.equipments = [];
                                } else {
                                    layer.msg('error', {icon: 2});
                                    return;
                                }
                            }, 'json');
                        }
                    }

                    // 提交审核结果
                    $.post("<?php echo U('Borrow/approve');?>", {
                        aid : this.info.id,
                        type : this.type,
                        isagree : this.isagree ? 1 : 2,
                        opinion : this.opinion
                    }, function (data) {
                        if (data.status) {
                            layer.msg(data.info, {icon: 1});
                            this.opinion = '';
                            this.isagree = false;
                        } else {
                            layer.msg(data.info, {icon: 2});
                        }
                    });
                }

            },
            ready : function () {
                this.page(1);
            }
        });
    </script>
</body>

</html>