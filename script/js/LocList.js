(function($) {
	$.LocList = function(config) {
		
		if (!config || !config.fields || !$.isArray(config.fields) || config.fields.length < 2 || !config.topLevel || !config.url) {
			return false;
		}
		if ($.inArray(config.topLevel, ['country', 'state', 'city']) === -1) {
			return false;
		}
		
		var types = ['country', 'state', 'city', 'region'];
		var fields = {};
		var url = config.url;
		var preload = !!config.preload;
		var method = config.method ? config.method : 'get';
		var disableFields = function(type1, type2) {
			var type1Index = types.indexOf(type1);
			var type2Index = type2 === undefined ? types.length : types.indexOf(type2);
			
			if (type1Index === -1 || type1Index === types.length - 1) return;
			if (type1Index >= type2Index) return;
			
			for (var i = type1Index + 1; i < type2Index; i ++) {
				if (fields[types[i]]) {
					fields[types[i]].empty().attr('disabled', true);
				}
			}
		};
		
		(function() {
			var start = types.indexOf(config.topLevel);
			var length = config.fields.length < types.length ? config.fields.length + start : types.length;
			
			for (var i = start; i < length; i++) {
				fields[types[i]] = $(config.fields[i]);
			}
		})();
		
		(function() {
			var fieldsKeys = Object.keys(fields);
			fieldsKeys.pop();
			
			for (var i in fieldsKeys) {
				(function() {
					var type = fieldsKeys[i];
					fields[type].bind('change', function(e) {
						$.ajax({
							url : url,
							type : method,
							dataType : 'json',
							data : {id : $(this).val()},
							success : function(data, textStatus, jqXHR) {
								if (data.status === '1') {
									if (fields[data.type]) {
										disableFields(type, data.type);
										fields[data.type].attr('disabled', false).html(data.html).change();
									}
								} else if (data.status === '0') {
									disableFields(type);
								}
							},
							error : function(XMLHttpRequest, textStatus, errorThrown) {
								alert(textStatus);
							}
						})
					})
				})();
			}
		})();
		
		if (preload) {
			fields[config.topLevel].change();
		}
	}
})(jQuery);