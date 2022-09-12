function setAjaxSelectionBox(object, id, target_id, url, method = 'POST', onError = 'Error') {
	$.ajax({
		type    : method,
		url     : url,
		data    : object.serialize(),
		success : function(d) {
			
			loader(target_id, 'show');
			updateSelectChosen('select#' + target_id, true, '');
			
			$.each(JSON.parse(d), function(index, item) {
				if (item != '') {
					var optValue = null;
					
					if (~item.indexOf('_')) {
						optValue = ucwords(item.replace('_', ' '));
					} else if (~item.indexOf('.')) {
						optValue = ucwords(item.replace('.', ' '));
					} else {
						optValue = ucwords(item);
					}
					
					$('select#' + target_id).append('<option value=\"' + id + '::' + item + '\">' + optValue + '</option>');
				}
			});
			
			updateSelectChosen('select#' + target_id, false, '');
		},
		error: function() {
			alert(onError);
		},
		complete: function() {
			loader(target_id, 'fadeOut');
		}
	});
}

function mappingPageTableFieldname(id, target_id, url, target_opt = null, nodebtn = null, method = 'POST', onError = 'Error') {
	var node_btn = $('#' + nodebtn);
	node_btn.hide();
	
	updateSelectChosen('select#' + target_id);
	if (null != target_opt) {
		updateSelectChosen('select#' + target_opt);
	}
	
	$('#' + id).change(function(e) {
		if ($(this).is(':checked')) {
			node_btn.fadeIn(1800);
			
			setAjaxSelectionBox($(this), id, target_id, url, method, onError);
		} else {
			node_btn.fadeOut(1800);
			
			loader(target_id, 'show');
			loader(target_id, 'fadeOut');
			updateSelectChosen('select#' + target_id);
			
			if (null != target_opt) {
				loader(target_opt, 'show');
				loader(target_opt, 'fadeOut');
				updateSelectChosen('select#' + target_opt);
			}
		}
	});
}

function mappingPageFieldnameValues(id, target_id, url, method = 'POST', onError = 'Error') {
	updateSelectChosen('select#' + target_id);
	$('#' + id).change(function(e) {
		if ($(this).val() !== '') {
			setAjaxSelectionBox($(this), id, target_id, url, method, onError);
		} else {
			loader(target_id, 'show');
			loader(target_id, 'fadeOut');
			updateSelectChosen('select#' + target_id);
		}
	});
}

function mappingPageButtonManipulation(node_btn, id, target_id, second_target, url, method = 'POST', onError = 'Error') {
	var node_add = 'role-add-' + target_id;
	$('#reset' + node_btn).hide();
	
	$('#plus' + node_btn).click(function(e) {
		var random_target_id         = target_id     + diy_random();
		var random_second_target     = second_target + diy_random();
		var node_row                 = 'remove-row'  + random_target_id;
		
		var clone_target_id          = $('select#' + target_id).clone().attr({'id': random_target_id});
		var clone_box_target_id      = $('<div id=\"row-box-' + random_target_id + '\" class=\"' + node_add + ' ' + node_row + ' relative-box\"></div>').insertBefore($('div#row-box-' + target_id)).prepend(clone_target_id);
		clone_box_target_id.children('#' + random_target_id).chosen();
		var clone_delete_button      = $('span#remove-row' + target_id).clone().attr({'id': 'remove-row' + random_target_id});
		clone_delete_button.insertAfter($('select#' + random_target_id));		
		
		var clone_second_target      = $('select#' + second_target).clone().attr({'id': random_second_target});
		var clone_box_second_target  = $('<div id=\"row-box-' + random_second_target + '\" class=\"' + node_add + ' ' + node_row + ' relative-box\"></div>').insertBefore($('div#row-box-' + second_target)).prepend(clone_second_target);
		clone_box_second_target.children('#' + random_second_target).chosen(); //var clone_second_target  = $('select#' + second_target).clone().attr({'id': random_second_target, 'class': node_add}).insertAfter($('#' + second_target));clone_second_target.chosen();
		
		mappingPageFieldnameValues(random_target_id, random_second_target, url, method, onError);
		
		if (clone_target_id.length >= 1) {
			$('#reset' + node_btn).fadeIn();
		} else {
			$('#reset' + node_btn).fadeOut();
		}
		
		$('span#' + node_row).click(function(x){
			$('div.' + node_row).fadeOut(300, function() { $(this).remove(); });
		});
	});
	
	$('#reset' + node_btn).click(function(e) {
		$('div.' + node_add).chosen('destroy').fadeOut(500, function() { $(this).remove(); });//.chosen('destroy').remove();
		$('#reset'  + node_btn).fadeOut(500);
	});
}