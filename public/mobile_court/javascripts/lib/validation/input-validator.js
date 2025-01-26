/**
 * Created by newton.sarker on 5/24/2017.
 */
/*
 * validation classes are -
 *	required: For textbox, textarea, select
 *	date: For date textbox
 *	radiorequired: For radio group
 *
 * example - validator.validateFields("#ContainerID")
*/

validator = {

	// check if any value is there
	hasValue: function(val) {
		return val.length > 0 ;
	},

	// check valid integer 1, 15, 18
	isInteger: function(val) {
		var re = new RegExp("^[0-9০-৯]+$");
		return re.test(val);
	},
	
	// check valid date dd/mm/yyyy
	isDate: function(val) {
		var dateaprts = val.split('/');
		var dt = new Date(dateaprts[2], dateaprts[1] - 1, dateaprts[0]);
		return (dt.getDate() == dateaprts[0] && dt.getMonth() == dateaprts[1] - 1 && dt.getFullYear() == dateaprts[2]);
	},
	
	// check valid time valid, 00:01 to 00:59 or 0:01 to 23:59
	isTime: function(val) {
		var re = new RegExp("^(2[0-3]|[01]?[0-9]):(0[1-9]{1}|[1-5]{1}[0-9])$");
		return re.test(val);
	},

	// check if any of the radio is checked in the group
	isRadioCheck: function(radioContainer) {
		var checkCount = 0;
        $(radioContainer).find('input[type=radio]').each(function(i, x) {
        	if($(x).attr("checked")) {
        		checkCount++ ;
        	}
        });
        return checkCount > 0;
	},

	
	markError : function(control, isValid) {
		if (isValid) {
			$(control).removeClass("input-error");
			return 0;
		} else {
			$(control).addClass("input-error");
			return 1;
		}

	},

    validateFields : function(_targetArea, _msgHolder, _msg) {
		
		var targetArea = "";
		var errMsg = "Please provide all required information";
		var msgHolder = "#lblMsg";
		var notValid = 0;
		
		if (_targetArea) { targetArea = _targetArea; } else { targetArea = $(document); }
		if (_msg) { errMsg = _msg; }
		if (_msgHolder) { msgHolder = _msgHolder; }
		
		$(targetArea).find("input.required").each(function(i) {
			var currValue = $.trim(this.value);
			notValid += validator.markError(this, validator.hasValue(currValue));
		});
		
		$(targetArea).find("textarea.required").each(function(i) {
			var currValue = $.trim(this.value);
			notValid += validator.markError(this, currValue.length > 0);
		});
		
		$(targetArea).find("select.required").not('.select2-hidden-accessible').each(function(i) {
			notValid += validator.markError(this, $(this).val().length > 0);
		});


        $(targetArea).find("select.select2-hidden-accessible.required").each(function(i) {
        	var isValid = validator.markError(this, $(this).val().length > 0);
            notValid += isValid;
			if(isValid > 0){
                $(this).parents('.form-group').find('.select2-selection').addClass("input-error");
            }else{
                $(this).parents('.form-group').find('.select2-selection').removeClass("input-error");
			}
        });
		
		$(targetArea).find("input.date").each(function(i) {
			var currValue = $.trim(this.value);
			notValid += validator.markError(this, validator.isDate(currValue));
		});

		$(targetArea).find(".radiorequired").not(':hidden').each(function(i) {
			var radioContainer = $(this);
			var isValid = false;
            radioContainer.find("input[type=radio]").each(function(index,obj) {
            	if($(obj).is(':checked')){
                    isValid = true
				}
            });
            if(isValid){
                radioContainer.find("input[type=radio]").parent('label').removeClass("input-error");
			}else{
                radioContainer.find("input[type=radio]").parent('label').addClass("input-error");
			}
            notValid += isValid ? 0 : 1;
        });

        $(targetArea).find(".checkboxrequired").each(function(i) {
            var checkCount = $(this).find('input[type="checkbox"]:checked').map(function(){return this}).get();
            notValid += validator.markError(this, checkCount.length > 0);
        });

        $(targetArea).find("input.password").each(function(i) {
			notValid += validator.markError(this, this.value.length > 0);
		});
		
		return notValid < 1;

	}
		
};