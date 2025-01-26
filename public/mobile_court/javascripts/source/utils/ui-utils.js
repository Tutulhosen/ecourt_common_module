var uiUtil = {

    populateSelectOptions: function (selector, headerText, dataItems, idFieldName, textFieldName, selectedID) {
        $(selector).empty();
        if(headerText) {
            $(selector).append($('<option>', { value: '', text: headerText }));
        }
        if(dataItems && dataItems.length > 0) {
            $.each(dataItems, function (i, x) {
                $(selector).append($('<option>', { value: x[idFieldName], text: x[textFieldName] }));
            });
        }
        if(selectedID) {
            $(selector).val(selectedID);
        }
    }

};