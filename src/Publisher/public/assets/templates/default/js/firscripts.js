function ajaxSelectionProcess(object, id, target_id, url, data = [], method = 'POST', onError = 'Error') {
	var dataInfo = JSON.parse(data);
	var lURL     = 'l=' + dataInfo.labels;
	var vURL     = 'v=' + dataInfo.values;
	var sURL     = 's=' + dataInfo.selected;
	var qURL     = diy_random() + '=' + dataInfo.query;
	var selected = null;
	var pinned   = '';
	
	$.ajax({
		type    : method,
		url     : url + '&' + lURL + '&' + vURL + '&' + sURL + '&' + qURL,
		data    : object.serialize(),
		success : function(d) {
			var result = JSON.parse(d);
			selected   = result.selected;
			
			loader(target_id, 'show');
			updateSelectChosen('select#' + target_id, true, '');
			$.each(result.data, function(value, label) {				
				if (selected === value) pinned = ' selected';
				
				if (value != '') {
					var optionLabel = null;
					
					if (~label.indexOf('_')) {
						optionLabel = ucwords(label.replaceAll('_', ' '));
					} else if (~label.indexOf('.')) {
						optionLabel = ucwords(label.replaceAll('.', ' '));
					} else {
						optionLabel = ucwords(label);
					}
					
					$('select#' + target_id).append('<option value=\"' + value + '\"' + pinned + '>' + optionLabel + '</option>');
				}
			});
			updateSelectChosen('select#' + target_id, false, false);
		},
		error: function() {
			alert(onError);
		},
		complete: function() {
			loader(target_id, 'fadeOut');
		}
	});
}

function ajaxSelectionBox(id, target_id, url, data = [], method = 'POST', onError = 'Error') {
	var object   = $('select#' + id);
	if (object.val() !== '') {
		ajaxSelectionProcess(object, id, target_id, url, data, method, onError);
	}
	object.change(function(e) {
		ajaxSelectionProcess(object, id, target_id, url, data, method, onError);
	});
}

function ucwords(str, force) {
	str=force ? str.toLowerCase() : str;  
	return str.replace(/(\b)([a-zA-Z])/g, function(firstLetter) {
		return firstLetter.toUpperCase();
	});
}

function updateSelectChosen(target, reset = true, optstring = 'Select an Option') {
	var chosenTarget = $(target);
	if (true === reset) {
		chosenTarget.find('option').remove().end();
	}
	if (false !== optstring) {
		chosenTarget.append('<option value=\"\">' + optstring + '</option>').trigger('chosen:updated');
	} else {
		chosenTarget.trigger('chosen:updated');
	}
}

function loader(target_id, view = 'hide') {
	var _loaderTarget = '#' + target_id;
	var _loaderID     = 'cdyInpLdr' + target_id;
	
	if ('remove' == view) {
		$('span.inputloader').remove();
	} else if ('fadeOut' == view) {
		$('span.inputloader').fadeOut(1800, function() { $(this).remove(); });
	} else {
		$(_loaderTarget).before('<span class=\"inputloader loader ' + view + '\" id=\"'+ _loaderID + '\"></span>');
	}
}

function diy_random(length = 8) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
	for ( var i = 0; i < length; i++ ) {
		result += characters.charAt(Math.floor(Math.random() * charactersLength));
	}
	return result;
}

function exportFromModal(modalID, exportID, filterID, token, url, link = null) {
	$('#exportFilterButton' + modalID).on('click', function(event) {
		var inputFilters        = $('#' + modalID + ' > .form-group.row > .input-group.col-sm-9 > select.' + exportID);
		var inputData           = [];
		inputData['exportData'] = true;
		inputData['_token']     = '' + token +'';
		inputFilters.each(function(x, y) {
			inputData[y.name]   = y.value;
		});
		if (null != link) {
			inputData['lurExp'] = link;
		}
	
		var postData = Object.assign({}, inputData);
		
		$.ajax ({
			type: 'POST',
			data: postData,
			dataType: 'JSON',
			url: '' + url + '',
			success : function(n) {
				window.location.href = n.diyExportStreamPath;
			},
			complete : function() {
				$('#' + filterID).modal('hide');
			}
		});
	});
}