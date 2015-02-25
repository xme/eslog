function esLog(){
	
}
SuperLog.prototype={
	get:function(){
		var datas = {debug:true};
		$('#eslog_filter input,#eslog_filter select').each(function(){
			if($(this).val()!=''){
				datas[$(this).attr('id').replace('eslog_','')]=$(this).val();
			}
		});
		$.ajax({
			type: 'GET',
			url:OC.linkTo('eslog', 'ajax/list.php'),
			dataType: 'json',
			data:datas,
			async: true,
			success: function (logs) {
				var n=0;
				for(var i in logs['data']){
					n++;
					the_item=logs['data'][i];
					console.log(the_item);
					var line='<tr>';
					line+='<td>'+the_item['user']+'</td>';
					line+='<td>'+the_item['activity']+'</td>';
					line+='<td>'+the_item['date']+'</td>';
					line+='</tr>';
					$('#eslogs_results').append(line);
				}
				if(n==0){
					$('#eslog_more').fadeOut(500);
				}
				$('#eslog_start').val(parseInt($('#eslog_start').val())+n);
			}				
		});
	}
};

$(document).ready(function(){
	if($('#eslog').length>0){
		eslogs=new SuperLog();
		
		$('#eslog_filter label').hide();
		$('#eslog_filters').click(function(){
			$('#eslog_filter label').toggle();
		});
		$('#eslog_filter input,#eslog_filter select').change(function(){
			$('#eslog_more').fadeIn(500);
			$('#eslogs_results tr').remove();
			$('#eslog_start').val(0);
		});
		$('#eslog_more').click(function(){
			eslogs.get();
		});
		
		eslogs.get();
	}
});
