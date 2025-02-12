<div class="left-menu">
<h3><?php echo _T('[INFORMATION]'); ?></h3>
<div class="left-menu-item<?php echo $page=='publish'?'-hover':'';?>"><a href="<?php echo url('console/publish'); ?>"><?php echo _T('Publish Information'); ?></a></div>
<div class="left-menu-item<?php echo $page=='released'?'-hover':'';?>"><a href="<?php echo url('console/released'); ?>"><?php echo _T('Released'); ?></a></div>
<div class="left-menu-item<?php echo $page=='incompleted'?'-hover':'';?>"><a href="<?php echo url('console/incompleted'); ?>"><?php echo _T('Incompleted'); ?></a></div>
<div class="left-menu-item<?php echo $page=='publishpolicy'?'-hover':'';?>"><a href="<?php echo url('console/publishPolicy'); ?>"><?php echo _T('Publish Policy'); ?></a></div>
</div>