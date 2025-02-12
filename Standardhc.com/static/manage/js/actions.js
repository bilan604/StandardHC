$(function(){
	$('.trashlink').bind('click',
		function(){
			if(confirm('确定删除此数据？')){
				return true;
			}
			return false;
		}
	);
	
	$('#action-toggle').bind('click',
		function(){
			var checkbox=$(":input[className='action-select']");
			if($(this).attr('checked')){
				checkbox.attr('checked','checked');
			}else{
				checkbox.attr('checked','');
			}
			
/*			checkbox.each(
				function(){
					var $this=$(this);
					if($this.attr('checked')){
						$this.parent().parent().css('background','#FFFFCC');
					}else{
						$this.parent().parent().css('background','');	
					}
				}
			);*/
		}
	);
	
	$('#result_list tbody td').hover(
		function(){
			$(this).parent().css('background','#F3F3F3');
		},
		function(){
			$(this).parent().css('background','');
		}
	);
	
/*	$('#batchAction').bind('change',
		function(){
			
			$('#changelist-form').attr('action',$(this).val()+'');
			console.debug($('#changelist-form').attr('action'));
		}
	);*/
	
	$('#changelist-form').submit(
		function(){
			if($('[name="id[]"]:checked').size()<=0){
				alert('请选择要执行该操作的数据！');
				return false;
			}
			if(confirm('确定执行该操作吗？'))
			{
				$(this).attr('action',$('#batchAction').val() );
			}
			else
			{
				return false;
			}
		}
	);
	//ajax update
	$('span.ajax').hover(
		function(){
			$(this).css('background','#5EA0EA');
		},
		function(){
			$(this).css('background','');
		}
	
	);
	var genPanel=function(id,idname,label,value){
		var panel='<div class="panel">'
			+'<form ><input type="text" name="'+label+'" value="'+value+'" />'
			+'<input type="button" value="修改" /><input type="button" value="取消" />'
			+'<input type="hidden" name="'+idname+'" value="'+id+'" />'
			+'</form></div>';
	}
	$('span.ajax').click(
		function(){
			var label=$(this).parent().attr('className');
			var idtd=$(this).parent().parent().find('td:eq(1)');
			var idname=idtd.attr('className');
			var id=idtd.text();
			var value=$(this).text();
		}
	);
});