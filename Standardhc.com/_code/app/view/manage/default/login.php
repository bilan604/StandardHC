<!doctype html> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<title>登录 | 系统管理</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<link rel="shortcut icon" href="<?php echo $_BASE_DIR; ?>favicon.ico">
<link rel="Bookmark" href="<?php echo $_BASE_DIR; ?>favicon.ico">
<link rel="stylesheet" type="text/css" href="<?php echo $_BASE_DIR; ?>static/manage/css/common.css" />
<meta name="robots" content="NONE,NOARCHIVE" />
</head>
<body class="login">


<div id="login-main">
	<div class="login-header"></div>
    <div class="login-box clearfix">
    
        <div class="login-box-copyright">
        	<h1>【<?php echo $baseinfo['company_name']; ?>网站后台】</h1>
            <p>
            	<img src="<?php echo $_BASE_DIR; ?>static/manage/images/cms-logo.jpg" />
            </p>
            
            <p class="copyright">
            	技术支持 <br />
                <a href="http://www.shbewell.com/" target="_blank" title="上海网站建设">上海百为网络科技有限公司</a> <br />
                系统版本：v3.0
            </p>
        </div>
        <div class="login-box-form">
        	<h1><img src="<?php echo $_BASE_DIR; ?>static/manage/images/login-title.jpg" /></h1>
    <form action="<?php echo url("manage::default/login"); ?>" method="post" id="login-form">
    <?php $is_validate = true; ?>
    <?php $message = array(); ?>
    <?php
    foreach ($form->elements() as $element):
        if(!$element->isValid()){
            $is_validate = false;
            $message[] = $element->errorMsg();
        }
    endforeach;
    ?>
    <?php if(!$is_validate):?>
    <p class="errornote">
    <?php
    foreach ($message as $msg):
        echo nl2br(h(implode("，", $msg))) . '<br />';
    endforeach;
    ?>
    </p>
    <?php endif; ?>
      <div class="form-row">
        <label for="id_username"><img src="<?php echo $_BASE_DIR; ?>static/manage/images/login-username.gif" /></label> <input type="text" name="username" id="id_username" />
      </div>
      <div class="form-row">
        <label for="id_password"><img src="<?php echo $_BASE_DIR; ?>static/manage/images/login-password.gif" /></label> <input type="password" name="password" id="id_password" />
      </div>
      <div class="form-row">
        <label for="id_vcode"><img src="<?php echo $_BASE_DIR; ?>static/manage/images/login-vcode.gif" /></label> <input type="text" name="vcode" id="id_vcode" class="vcode" maxlength="4" /> <img src="<?php echo url('default/vcode');?>" onClick="this.src='<?php echo url('default/vcode');?>?'+Math.random();" title="看不清？换一张" alt="看不清？换一张" style="vertical-align:middle;" />
      </div>
<!--      <div class="form-row remember">
      	<input type="checkbox" name="remember" value="1" id="id_remember" /> <label for="id_remember">记住我的密码？</label>
      </div>-->
      <div class="submit-row">
        <input type="image" src="<?php echo $_BASE_DIR; ?>static/manage/images/login-btn.gif" value="登录" />
      </div>
    </form>
    
    		<div class="login-tips">
            	<h2>注意：</h2>
            	<p>1.不要在公共场合保存登录信息。</p>
                <p>2.为保证您的账户安全，退出系统时请注销登录。</p>
                <p>3.如忘记密码等问题导致无法正常登录请及时联系我们。</p>
            </div>
        </div>
	</div>
<script type="text/javascript">
document.getElementById('id_username').focus()
</script>
	<div class="login-footer"></div>
</div>

</body>
</html>
