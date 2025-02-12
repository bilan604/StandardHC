<HTML>
<HEAD>
<TITLE>网站管理系统</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<script language='javascript'>
if (top != self)top.location.href = "<?php echo url('manage::default'); ?>"; 
</script>
<link rel="shortcut icon" href="<?php echo $_BASE_DIR; ?>favicon.ico">
<link rel="Bookmark" href="<?php echo $_BASE_DIR; ?>favicon.ico">
<base target="right">
</HEAD>
<frameset rows="96,*" framespacing="0" border="0" frameborder="0">
  <frame name="frame_top" src="<?php echo url('manage::default/head'); ?>" noresize target="right" scrolling="no">
  <FRAMESET border=0 frameSpacing=0 frameBorder=0 cols=170,*>
  <FRAME name="left" marginWidth=0 marginHeight=0 src="<?php echo url('manage::default/left'); ?>" noResize target="right" scrolling="auto">
  <FRAME name="right" marginWidth=20 marginHeight=20 src="<?php echo url('manage::default/main'); ?>" noResize target="right" scrolling="yes">
</FRAMESET>
<NOFRAMES>
<body topmargin="0" leftmargin="0">
<p>此网页使用了框架，但您的浏览器不支持框架。</p>
</body>
</NOFRAMES>
</frameset>
</HTML>
