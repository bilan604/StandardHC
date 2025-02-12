<?php $this->_extends('_layouts/main_layout');?>
<?php $this->_block('main_style');?>
<link rel="stylesheet" type="text/css" href="<?php echo $_BASE_DIR; ?>static/manage/css/home.css" />
<?php $this->_endblock(); ?>
<?php $this->_block('main_contents');?>

<div class="boxk">

   <div class="leftk">
      <div class="titk"><span class="tit_textk">网站服务器的有关参数</span></div>
      <div class="left_nrk">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td width="140" height="28" bgcolor="#FFFFFF" style="padding-left:20px; border-top:1px solid #e6e6e6; border-right:1px solid #e6e6e6">当前语言版本</td>
    <td width="391" height="28" bgcolor="#FFFFFF" style="padding-left:20px; border-top:1px solid #e6e6e6;">
    【<?php echo $lang_config[$lang]; ?>版】&nbsp;切换版本：
        <?php foreach($lang_config as $key=>$val): ?>
            	<a href="<?php echo url('manage::default',array('lang'=>$key));?>" target="_parent"><?php echo $val; ?></a>
	    <?php endforeach; ?>
    </td>
  </tr>
  <tr>
    <td width="140" height="28" bgcolor="#FFFFFF" style="padding-left:20px; border-top:1px solid #e6e6e6; border-right:1px solid #e6e6e6">服务器名</td>
    <td width="391" height="28" bgcolor="#FFFFFF" style="padding-left:20px; border-top:1px solid #e6e6e6;"><?php echo $_SERVER['SERVER_NAME'] ?></td>
  </tr>
  <tr>
    <td height="28" bgcolor="#FFFFFF" style="padding-left:20px; border-top:1px solid #e6e6e6; border-right:1px solid #e6e6e6">服务器IP</td>
    <td height="28" bgcolor="#FFFFFF" style="padding-left:20px; border-top:1px solid #e6e6e6;"><?php echo gethostbyname($_SERVER['HTTP_HOST']) ?></td>
  </tr>
  <tr>
    <td height="28" bgcolor="#FFFFFF" style="padding-left:20px; border-top:1px solid #e6e6e6; border-right:1px solid #e6e6e6">服务器端口 </td>
    <td height="28" bgcolor="#FFFFFF" style="padding-left:20px; border-top:1px solid #e6e6e6;"><?php echo $_SERVER['SERVER_PORT'] ?> </td>
  </tr>
  <tr>
    <td height="28" bgcolor="#FFFFFF" style="padding-left:20px; border-top:1px solid #e6e6e6; border-right:1px solid #e6e6e6">服务器时间</td>
    <td height="28" bgcolor="#FFFFFF" style="padding-left:20px; border-top:1px solid #e6e6e6;"><?php echo date("Y/m/d",$_SERVER['REQUEST_TIME']);?></td>
  </tr>
  <tr>
    <td height="28" bgcolor="#FFFFFF" style="padding-left:20px; border-top:1px solid #e6e6e6; border-right:1px solid #e6e6e6">版本</td>
    <td height="28" bgcolor="#FFFFFF" style="padding-left:20px; border-top:1px solid #e6e6e6;"><?php echo $_SERVER['SERVER_SOFTWARE'];?></td>
  </tr>

  <tr>
    <td height="28" bgcolor="#FFFFFF" style="padding-left:20px; border-top:1px solid #e6e6e6; border-right:1px solid #e6e6e6">用户主机名IP</td>
    <td height="28" bgcolor="#FFFFFF" style="padding-left:20px; border-top:1px solid #e6e6e6;"><?php echo $_SERVER['REMOTE_ADDR'] ?> </td>
  </tr>

    <tr>
    <td height="28" bgcolor="#FFFFFF" style="padding-left:20px; border-top:1px solid #e6e6e6; border-right:1px solid #e6e6e6">&nbsp;</td>
    <td height="28" bgcolor="#FFFFFF" style="padding-left:20px; border-top:1px solid #e6e6e6;">&nbsp;</td>
  </tr>
  <tr>
    <td height="28" bgcolor="#FFFFFF" style="padding-left:20px; border-top:1px solid #e6e6e6; border-right:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6 ">&nbsp;</td>
    <td height="28" bgcolor="#FFFFFF" style="padding-left:20px; border-top:1px solid #e6e6e6; border-bottom:1px solid #e6e6e6">&nbsp;</td>
  </tr>
</table>
</div>
   </div>
   
   <div class="rightk">
     <div class="right_topk">
       <div class="titk"><span class="tit_textk">服务商最新公告</span></div>
       <div class="right_nrk" >

       </div>
     </div>
     
     <div class="right_bottomk"><h1>技术支持：</h1>
       <div class=" right_textk">       上海百为网络科技有限公司<br />
技术部：86-21-60870392-8002<br />
售后服务：86-21-60870392-8005</div>
     </div>
     
   </div>
   
</div>
<?php $this->_endblock();?>