<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

		<title> SmartAdmin </title>
		<meta name="description" content="">
		<meta name="darker" content="">

		<!-- Use the correct meta names below for your web application
			 Ref: http://davidbcalhoun.com/2010/viewport-metatag 
			 
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">-->
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- Basic Styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="/apply/Public/home/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="/apply/Public/home/css/font-awesome.min.css">

		<!-- SmartAdmin Styles : Please note (smartadmin-production.css) was created using LESS variables -->
		<link rel="stylesheet" type="text/css" media="screen" href="/apply/Public/home/css/smartadmin-production.css">
		<link rel="stylesheet" type="text/css" media="screen" href="/apply/Public/home/css/smartadmin-skins.css">

		<!-- SmartAdmin RTL Support is under construction
		<link rel="stylesheet" type="text/css" media="screen" href="/apply/Public/home/css/smartadmin-rtl.css"> -->

		<!-- We recommend you use "your_style.css" to override SmartAdmin
		     specific styles this will also ensure you retrain your customization with each SmartAdmin update.
		<link rel="stylesheet" type="text/css" media="screen" href="/apply/Public/home/css/your_style.css"> -->


		<!-- FAVICONS -->
		<link rel="shortcut icon" href="/apply/Public/home/image/favicon/favicon.ico" type="image/x-icon">
		<link rel="icon" href="/apply/Public/home/image/favicon/favicon.ico" type="image/x-icon">

		<style>
			ul {list-style: none;}
			#main {
				margin-left: 0;
			}
		</style>
	</head>
	<body class="">
		<!-- possible classes: minified, fixed-ribbon, fixed-header, fixed-width-->




		<!-- MAIN PANEL -->
		<div id="main" role="main">

			<!-- RIBBON -->
			<div id="ribbon">

				<span class="ribbon-button-alignment"> <span id="re" class="btn btn-ribbon" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true"><i class="fa fa-refresh"></i></span> </span>

				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li>
						申请查看
					</li>
					<li>
						物资申请
					</li>
				</ol>
				<!-- end breadcrumb -->


			</div>
			<!-- END RIBBON -->

			<!-- MAIN CONTENT -->
			<div id="content">

				<!-- row -->
				<div class="row">
					
					<div class="superbox col-sm-12">
						<?php if(is_array($data['img'])): $i = 0; $__LIST__ = $data['img'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$img): $mod = ($i % 2 );++$i;?><div class="superbox-list">
								<img src="__UPLOAD__/<?php echo ($img); ?>" data-img="__UPLOAD__/<?php echo ($img); ?>" alt="" class="superbox-img">
							</div><?php endforeach; endif; else: echo "" ;endif; ?>
						<div class="superbox-float"></div>
					</div>
					<div class="superbox-show" style="height:300px; display: none"></div>
					

					<article class="col-xs-12 col-sm-6 col-md-6 col-lg-12 sortable-grid ui-sortable">

				
						<div class="jarviswidget jarviswidget-color-blue jarviswidget-sortable" id="wid-id-1" data-widget-colorbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" role="widget" style="">
								
								<header role="heading">

									<h2><strong>申请内容</strong></h2>				
									
								<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>
				
								<table id="user" class="table table-bordered table-striped" style="clear: both">
									<tbody>
										<tr>
											<td style="width:35%;"><span class="text-primary">活动主题</span></td>
											<td style="width:65%"><span class="text-info"><?php echo ($data["info"]["theme"]); ?></span></td>
										</tr>
										<tr>
											<td style="width:35%;"><span class="text-primary">申请单位</span></td>
											<td style="width:65%"><span class="text-info"><?php echo ($data["info"]["nickname"]); ?></span></td>
										</tr>
										<tr>
											<td style="width:35%;"><span class="text-primary">联系方式</span></td>
											<td style="width:65%"><span class="text-info"><?php echo ($data["info"]["phone"]); ?></span></td>
										</tr>
										<tr>
											<td style="width:35%;"><span class="text-primary">申请时间</span></td>
											<td style="width:65%"><span class="text-info"><?php echo ($data["info"]["apply_time"]); ?></span></td>
										</tr>
										<tr>
											<td style="width:35%;"><span class="text-primary">借用物资</span></td>
											<td style="width:65%">
												<ul style="list-style:none;">
													<?php if(is_array($data["info"]["borrow"])): $i = 0; $__LIST__ = $data["info"]["borrow"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
										        			<span class="txt-color-blue"><?php echo ($vo["name"]); ?></span>&nbsp;&nbsp;
															<span class="text-warning"><?php echo ($vo["number"]); ?>个</span>
										        		</li><?php endforeach; endif; else: echo "" ;endif; ?>
									         	</ul>
							          		</td>
										</tr>
										<tr>
											<td style="width:35%;"><span class="text-primary">开始时间</span></td>
											<td style="width:65%"><span class="text-info"><?php echo ($data["info"]["stime"]); ?></span></td>
										</tr>
										<tr>
											<td style="width:35%;"><span class="text-primary">结束时间</span></td>
											<td style="width:65%"><span class="text-info"><?php echo ($data["info"]["etime"]); ?></span></td>
										</tr>
										<?php if($data['info']['isagree'] == 1): ?><tr>
												<td style="width:35%;"><span class="text-primary">借出设备</span></td>
												<td style="width:65%">
													<div class="col-sm-6">
														<div class="bs-example">
															<ul>	
																<?php if(is_array($data["info"]["equipments"])): $i = 0; $__LIST__ = $data["info"]["equipments"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li><strong><?php echo ($item["name"]); ?></strong>
																		<ul>
																			<?php if(is_array($item["child"])): $i = 0; $__LIST__ = $item["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$e): $mod = ($i % 2 );++$i;?><li class="txt-color-purple"><?php echo ($e["number"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
																		</ul>
																	</li><?php endforeach; endif; else: echo "" ;endif; ?>
															</ul>
														</div>
													</div>
												</td>
											</tr><?php endif; ?>
										<?php if($data['info']['other']): ?><tr>
												<td style="width:35%;"><span class="text-primary">其它借用</span></td>
												<td style="width:65%"><span class="text-info"><?php echo ($data["info"]["other"]); ?></span></td>
											</tr><?php endif; ?>
									</tbody>
								</table>
						</div>
								
					</article>
				
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				
						<div class="well well-sm">
	

							<!-- Timeline Content -->
							<div class="smart-timeline">
								<ul class="smart-timeline-list">
									<?php if(is_array($data["step"])): $i = 0; $__LIST__ = $data["step"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><li>
											<?php if($p['isagree'] == 1): ?><div class="smart-timeline-icon bg-color-green">
													<i class="fa fa-check"></i>
												</div>
											<?php elseif($p["isagree"] == 2): ?>
												<div class="smart-timeline-icon bg-color-red">
													<i class="fa fa-times"></i>
												</div>
											<?php else: ?>
												<div class="smart-timeline-icon bg-color-yellow">
													<i class="fa fa-spinner"></i>
												</div><?php endif; ?>
											
											<div class="smart-timeline-time">
												<?php if($p.time): if($p["isagree"] == 1): ?><small style="color:#00b33b;">
													<?php elseif($p["isagree"] == 2): ?>
														<small style="color:#c7254e;">
													<?php else: endif; ?>
														<?php echo ($p["time"]); ?>
													</small>
												<?php else: ?>
													<small style="color:#f8b551;">审核中</small><?php endif; ?>
											</div>

											<div class="smart-timeline-content">
												<p>
													<strong><a href="javascript:;"><?php echo ($p["name"]); ?></a></strong>
												</p>
												
												<?php if($p["isagree"] == 1): ?><div class="well-sm display-inline" style="width:100%;background-color:#d6dde7;">
												<?php elseif($p["isagree"] == 2): ?>
													<div class="well-sm display-inline" style="width:100%;background-color:#efe1b3;">
												<?php else: ?>
													<div class="well-sm display-inline"><?php endif; ?>
												
													<p><?php echo ($p["opinion"]); ?></p>
												</div>		
															
											</div>
										</li><?php endforeach; endif; else: echo "" ;endif; ?>
								</ul>
							</div>
							<!-- END Timeline Content -->
				
						</div>
				
					</div>
				
				</div>
				
				<!-- end row -->

			</div>
			<!-- END MAIN CONTENT -->

		</div>
		<!-- END MAIN PANEL -->


		<!--================================================== -->

		<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
		<script data-pace-options='{ "restartOnRequestAfter": true }' src="/apply/Public/home/js/pace.min.js"></script>

		<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
		<script src="/apply/Public/home/js/jquery-2.2.4.min.js"></script>

		<script src="/apply/Public/home/js/jquery-ui-1.10.3.min.js"></script>

		<script src="/apply/Public/home/js/layer_mobile/layer.js"></script>

		<!-- JS TOUCH : include this plugin for mobile drag / drop touch events
		<script src="js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> -->

		<!--[if IE 7]>

		<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

		<![endif]-->

		<!-- MAIN APP JS FILE -->
		<script src="/apply/Public/home/js/app.js"></script>

		<!-- PAGE RELATED PLUGIN(S) -->
		<script src="/apply/Public/home/js/superbox.min.js"></script>

		<!-- PAGE RELATED PLUGIN(S) -->
		<script src="/apply/Public/home/js/bootstrap-progressbar.js"></script>


		<script>
			$(document).ready(function() {
				
				$('.superbox').SuperBox();

				$('#re').click(function () {
					location.reload();
				});
			
			})
		</script>
	</body>

</html>