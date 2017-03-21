<!DOCTYPE html>
<?php 
header("Content-type: text/html; charset=utf-8"); 
$md_path_all = $lister->getListedPath();
$md_path = explode("pw", $md_path_all);
if($md_path[1] != ""){
	$md_path_last = substr($md_path[1], -1);
	if($md_path_last != "/"){
		$md_file = ".".$md_path[1]."/README.html";
	}else{
		$md_file = ".".$md_path[1]."README.html";
	}
}
$md_text = file_get_contents($md_file);
?>
<html>
    <head>
        <title>DOUBI Soft <?php echo $md_path_all; ?></title>
        <link rel="shortcut icon" href="<?php echo THEMEPATH; ?>/img/folder.png">
        <!-- STYLES -->
        <link rel="stylesheet" href="/resources/themes/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/resources/themes/bootstrap/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo THEMEPATH; ?>/css/style.css">
		<link href="/resources/themes/bootstrap/css/prism.css" rel="stylesheet" />
        <!-- SCRIPTS -->
        <!-- <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> -->
        <script src="/resources/themes/bootstrap/js/prism.js"></script>
		<script src="/resources/themes/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo THEMEPATH; ?>/js/directorylister.js"></script>
        <!-- FONTS -->
        <!-- <link rel="stylesheet" type="text/css"  href="//fonts.googleapis.com/css?family=Cutive+Mono"> -->
        <!-- META -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <?php file_exists('analytics.inc') ? include('analytics.inc') : false; ?>
		<script type="text/JavaScript">
// 收藏本站
		function AddFavorite(title, url) {
			try {
				window.external.addFavorite(url, title);
			}
			catch (e) {
				try {
					window.sidebar.addPanel(title, url, "");
				}
				catch (e) {
					alert("抱歉，您所使用的浏览器无法完成此操作。\n\n加入收藏失败，请使用Ctrl+D进行添加");
				}
			}
		}
</script>
    </head>
    <body>
        <div id="page-navbar" class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <?php $breadcrumbs = $lister->listBreadcrumbs(); ?>
                <p class="navbar-text">
                    <?php foreach($breadcrumbs as $breadcrumb): ?>
                        <?php if ($breadcrumb != end($breadcrumbs)): ?>
                                <a href="<?php echo $breadcrumb['link']; ?>"><?php echo $breadcrumb['text']; ?></a>
                                <span class="divider">/</span>
                        <?php else: ?>
                            <?php echo $breadcrumb['text']; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </p>
            </div>
        </div>
		<div class="container">
        <div class="announcement">
		<i class="fa fa-volume-down" style="display: inline-block;font-size: 15px;margin: 0;line-height: 1;color: #444;"></i><p style="display: inline-block;font-size: 15px;margin: 0;line-height: 1;text-indent: 5px;" >顶部公告栏</p>
		</div>
		</div>
		<div id="page-content" class="container">
            <?php file_exists('header.php') ? include('header.php') : include($lister->getThemePath(true) . "/default_header.php"); ?>
            <?php if($lister->getSystemMessages()): ?>
                <?php foreach ($lister->getSystemMessages() as $message): ?>
                    <div class="alert alert-<?php echo $message['type']; ?>">
                        <?php echo $message['text']; ?>
                        <a class="close" data-dismiss="alert" href="#">&times;</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <div id="directory-list-header">
                <div class="row">
                    <div class="col-md-7 col-sm-6 col-xs-10">文件</div>
                    <div class="col-md-2 col-sm-2 col-xs-2 text-right">大小</div>
                    <div class="col-md-3 col-sm-4 hidden-xs text-right">最后修改时间</div>
                </div>
            </div>
            <ul id="directory-listing" class="nav nav-pills nav-stacked">
                <?php foreach($dirArray as $name => $fileInfo): ?>
                    <li data-name="<?php echo $name; ?>" data-href="<?php echo $fileInfo['url_path']; ?>">
                        <a href="<?php echo $fileInfo['url_path']; ?>" class="clearfix" data-name="<?php echo $name; ?>">
                            <div class="row">
                                <span class="file-name col-md-7 col-sm-6 col-xs-9">
                                    <i class="fa <?php echo $fileInfo['icon_class']; ?> fa-fw"></i>
                                    <?php echo $name; ?>
                                </span>
                                <span class="file-size col-md-2 col-sm-2 col-xs-3 text-right">
                                    <?php echo $fileInfo['file_size']; ?>
                                </span>
                                <span class="file-modified col-md-3 col-sm-4 hidden-xs text-right">
                                    <?php echo $fileInfo['mod_time']; ?>
                                </span>
                            </div>
                        </a>
                        <?php if (is_file($fileInfo['file_path'])): ?>
                            <!-- a href="javascript:void(0)" class="file-info-button">
                                <i class="fa fa-info-circle"></i>
                            </a -->
                        <?php else: ?>
                            <?php if ($lister->containsIndex($fileInfo['file_path'])): ?>
                                <a href="<?php echo $fileInfo['file_path']; ?>" class="web-link-button" <?php if($lister->externalLinksNewWindow()): ?>target="_blank"<?php endif; ?>>
                                    <i class="fa fa-external-link"></i>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
		<!-- 说明 -->
		<?php
		if($md_text != ""){
			echo $md_text;
		}
		?>
		<!-- 说明 -->
        <?php file_exists('footer.php') ? include('footer.php') : include($lister->getThemePath(true) . "/default_footer.php"); ?>
        <!-- div id="file-info-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{modal_header}}</h4>
                    </div>
                    <div class="modal-body">
                        <table id="file-info" class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td class="table-title">MD5</td>
                                    <td class="md5-hash">{{md5_sum}}</td>
                                </tr>
                                <tr>
                                    <td class="table-title">SHA1</td>
                                    <td class="sha1-hash">{{sha1_sum}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div -->
    </body>
</html>
