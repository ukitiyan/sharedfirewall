(function(){

function updateStatus(statusEl, result){
	statusEl.removeClass('success error loading-small');
	if (result && result.status == 'success' && result.data.id) {
		statusEl.addClass('success');
		return true;
	} else {
		statusEl.addClass('error');
		return false;
	}
}

OC.FirewallConfig={
	saveFirewall:function(tr, callback) {
		var statusSpan = $(tr).closest('tr').find('.status span');
		statusSpan.addClass('loading-small').removeClass('error success');
		var id = $(tr).data('id');
		var shareid = $(tr).data('shareid');
		var accept = $(tr).find('.accept').children().val();
		var status = false;
		$.ajax({type: 'POST',
			url: OC.filePath('sharedfirewall', 'ajax', 'saveFirewall.php'),
			data: {
				id: id,
				shareid: shareid,
				accept: accept
			},
			success: function(result) {
				if (result.status == 'success') {
					$(tr).data('id', result.data.id);
				}
				status = updateStatus(statusSpan, result);
				if (callback) {
					callback(status);
				}
			},
			error: function(result){
				status = updateStatus(statusSpan, result);
				if (callback) {
					callback(status);
				}
			}
		});
		return status;
	}
};

$(document).ready(function() {
	$('.chzn-select').chosen();

	$('#firewallTable').on('change', '#selectPath', function() {
		var tr = $(this).parent().parent();
		$('#firewallTable tbody').append($(tr).clone());
		var selected = $(this).find('option:selected').text();
		var shareid = $(this).val();
		$(tr).data('shareid', shareid);
		$(tr).find('.status').append('<span></span>');
		$(tr).find('.path').append('<label>'+selected+'</label>');
		$(tr).find('.accept').append('<input type="text" name="accept" class="ipaddress" placeholder="'+t('sharedfirewall', 'IP Address')+'" />');

		// Reset chosen
		var chosen = $(tr).find('.applicable select');
		chosen.parent().find('div').remove();
		chosen.removeAttr('id').removeClass('chzn-done').css({display:'inline-block'});
		chosen.chosen();
		$(tr).find('td').last().attr('class', 'remove');
		$(tr).find('td').last().removeAttr('style');
		$(tr).removeAttr('id');
		$(this).remove();
	});

	$('#firewallTable').on('paste', 'td', function() {
		var tr = $(this).parent();
		setTimeout(function() {
			OC.FirewallConfig.saveStorage(tr);
		}, 20);
	});

	var timer;

	$('#firewallTable').on('keyup', 'td input', function() {
		clearTimeout(timer);
		var tr = $(this).parent().parent();
		if ($(this).val) {
			timer = setTimeout(function() {
				OC.FirewallConfig.saveFirewall(tr);
			}, 2000);
		}
	});

	$('#firewallTable').on('click', 'td.remove>img', function() {
		var tr = $(this).parent().parent();
		var id = $(tr).data('id');
		$.post(OC.filePath('sharedfirewall', 'ajax', 'removeFirewall.php'), { id: id });
		$(tr).remove();
	});

});

})();
