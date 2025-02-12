<?php $this->_extends('_layouts/default_layout');?>
<?php $this->_block('contents');?>
<!-- Container -->
<div id="container">
    <!-- Header -->
    <div id="header">
        <div id="branding">
		
<h1 id="site-name">【<?php echo $baseinfo['company_name']; ?>】</h1>
	
    

        </div>
        
        <div class="user-tips">
        您好,
        <a href="<?php echo url('manage::user/password',array('uid'=>$current_user['uid'])); ?>" target="right"><?php echo h($current_user['nick']);?></a> 
        欢迎进入网站管理系统
        
        </div>  
        <div class="user-shortcut">
            <div class="date-tips">
                日期：<?php echo date('Y年m月d日');?> <?php $weekarray=array("日","一","二","三","四","五","六"); echo "星期".$weekarray[date("w")];?>
            </div>
            <ul>
            <li>
                <a href="<?php echo url('manage::user/password',array('uid'=>$current_user['uid'])); ?>" target="right">
            
            修改密码</a> 
            </li>
            <li>
                <a href="<?php echo url('manage::default/logout') ?>" target="_top">注销登录</a>
            </li>
            </ul>
        </div>
		
        <ul class="user-menu">
      <?php foreach($lang_config as $key=>$val): ?>
        	<li <?php echo $key==$lang?'class="selected"':''; ?>>
            	<a href="<?php echo url('manage::default',array('lang'=>$key));?>" target="_parent"><?php echo $val; ?>管理</a>
            </li>
	  <?php endforeach; ?>
        </ul>
        
    </div>
    <!-- END Header -->
    
</div>
<?php $this->_endblock();?>