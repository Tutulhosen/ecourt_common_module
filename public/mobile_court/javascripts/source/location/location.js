var locationService = {

    getDivisions: function () {
        var url = '/location/division/';
        return $.ajax({url: url, dataType: 'json'});
    },

    getZillas: function (divisionID) {
        var url = '/location/zilla/' + divisionID;
        return $.ajax({url: url, dataType: 'json'});
    },

    getUpazillas: function (zillaID) {
        var url = '/location/upazilla/' + zillaID;
        return $.ajax({url: url, dataType: 'json'});
    },

    getCityCorporations: function (zillaID) {
        var url = '/location/citycorporation/' + zillaID;
        return $.ajax({url: url, dataType: 'json'});
    },

    getMetropolitans: function (zillaID) {
      
        var url = '/location/metropolitan/' + zillaID;
        return $.ajax({url: url, dataType: 'json'});
    },

    getThanas: function (metropolitanID) {

        var url = '/location/thana/' + metropolitanID;
        return $.ajax({url: url, dataType: 'json'});
    }

};

var eMobileLocation = {

    ddlDivision: 'ddlDivision',
    ddlZilla: 'ddlZilla',
    optLocationType: 'optLocationType',
    ddlUpazilla: 'ddlUpazilla',
    ddlCityCorporation: 'ddlUpazilla',
    ddlMetropolitan: 'ddlUpazilla',
    ddlThana: 'ddlThana',
    locationType: {Division: 'DIVISION', Zilla: 'ZILLA', Upazilla: 'UPAZILLA', CityCorporation: 'CITYCORPORATION', Metropolitan: 'METROPOLITAN', Thana: 'THANA'},

    init: function (ctrlID) {

        // bind events
        eMobileLocation.bindEvents(ctrlID);

        // populate division
        eMobileLocation.populateDivision(ctrlID, null);

    },

    populateLocation: function (ctrlID, locationType, divID, zillaID, upazillaID, citycorporationID, metropolitanID, thanaID) {

       
        // bind events
        eMobileLocation.bindEvents(ctrlID);

        var optLocationTypeCtrlID = '.' + eMobileLocation.optLocationType + ctrlID;

        // populate dropdowns
        eMobileLocation.populateDivision(ctrlID, divID).then(function() {
            eMobileLocation.populateZilas(ctrlID, divID, zillaID).then(function () {
                $(optLocationTypeCtrlID).each(function (i, x) {
                    $(x).removeAttr('checked');
                    if($(x).val() === locationType) {
                        $(x).attr('checked', 'checked');
                    }
                });
                if(locationType === eMobileLocation.locationType.Upazilla) { eMobileLocation.populateUpazillas(ctrlID, zillaID, upazillaID); }
                if(locationType === eMobileLocation.locationType.CityCorporation) { eMobileLocation.populateCityCorporations(ctrlID, zillaID, citycorporationID); }
                if(locationType === eMobileLocation.locationType.Metropolitan) {
                    eMobileLocation.populateMetropolitans(ctrlID, zillaID, metropolitanID).then(function () {
                        eMobileLocation.populateThanas(ctrlID, metropolitanID, thanaID);
                    });
                }
            });
        });

    },

    bindEvents: function (ctrlID) {

        // generate control id
        var ddlDivisionCtrlID = '#' + eMobileLocation.ddlDivision + ctrlID;
        var ddlZillaCtrlID = '#' + eMobileLocation.ddlZilla + ctrlID;
        var optLocationTypeCtrlID = '.' + eMobileLocation.optLocationType + ctrlID;
        var ddlUpazillaCtrlID = '#' + eMobileLocation.ddlUpazilla + ctrlID;
        var ddlMetropolitanCtrlID = '#' + eMobileLocation.ddlMetropolitan + ctrlID;
        var ddlThanaCtrlID = '#' + eMobileLocation.ddlThana + ctrlID;

        $(ddlDivisionCtrlID).select2();
        $(ddlZillaCtrlID).select2();
        $(ddlUpazillaCtrlID).select2();
        $(ddlThanaCtrlID).select2();

        // clear controls
        eMobileLocation.clearDropdown(ddlDivisionCtrlID, ctrlID);
        eMobileLocation.clearDropdown(ddlZillaCtrlID, ctrlID);
        eMobileLocation.clearDropdown(ddlUpazillaCtrlID, ctrlID);
        eMobileLocation.clearDropdown(ddlThanaCtrlID, ctrlID);
        eMobileLocation.clearLocationType(optLocationTypeCtrlID, ctrlID);

        // bind change event to division
        $(document).on( 'change', ddlDivisionCtrlID, function(event) {
            var divCtrlID = $(this).attr('ctrlID');
            var divID = $(this).val();
      
            eMobileLocation.clearDropdown(ddlZillaCtrlID, ctrlID);
            eMobileLocation.clearDropdown(ddlUpazillaCtrlID, ctrlID);
            eMobileLocation.clearDropdown(ddlThanaCtrlID, ctrlID);
            eMobileLocation.populateZilas(divCtrlID, divID, null);
        });

        // bind change event to zilla
        $(document).on( 'change', ddlZillaCtrlID, function(event) {
            var zillaCtrlID = $(this).attr('ctrlID');
            var zillaID = $(this).val();
            var type = eMobileLocation.getLocationType(ctrlID);
            eMobileLocation.clearDropdown(ddlUpazillaCtrlID, ctrlID);
            eMobileLocation.clearDropdown(ddlThanaCtrlID, ctrlID);
            if(type === eMobileLocation.locationType.Upazilla) { eMobileLocation.populateUpazillas(zillaCtrlID, zillaID, null); }
            if(type === eMobileLocation.locationType.CityCorporation) { eMobileLocation.populateCityCorporations(zillaCtrlID, zillaID, null); }
            if(type === eMobileLocation.locationType.Metropolitan) { eMobileLocation.populateMetropolitans(zillaCtrlID, zillaID, null); }
        });

        // bind change event to metropolitan
        $(document).on( 'change', ddlMetropolitanCtrlID, function(event) {
            var ddl = this;
            var type = eMobileLocation.getLocationType(ctrlID);
            eMobileLocation.clearDropdown(ddlThanaCtrlID, ctrlID);
            if(type === eMobileLocation.locationType.Metropolitan) {
                // $(ddlThanaCtrlID).removeClass('hidden');
                $(ddlThanaCtrlID + ' ~ .select2').show();
                var metropolitanCtrlID = $(ddl).attr('ctrlID');
                var metropolitanID = $(ddl).val();
                eMobileLocation.populateThanas(metropolitanCtrlID, metropolitanID, null);
            }
        });

        // bind change event to location type radio
        $(document).on( 'change', optLocationTypeCtrlID, function(event) {
            $(optLocationTypeCtrlID).each(function (i, x) { $(x).removeAttr('checked'); });
            $(this).attr('checked', 'checked');
            eMobileLocation.clearDropdown(ddlUpazillaCtrlID, ctrlID);
            eMobileLocation.clearDropdown(ddlThanaCtrlID, ctrlID);
            var zillaCtrlID = $(this).attr('ctrlID');
            var zillaID = $(ddlZillaCtrlID).val();
            var type = this.value;
            // $(ddlThanaCtrlID).addClass('hidden');
            $(ddlThanaCtrlID + ' ~ .select2').hide();
            if(type === eMobileLocation.locationType.Upazilla) { eMobileLocation.populateUpazillas(zillaCtrlID, zillaID, null); }
            if(type === eMobileLocation.locationType.CityCorporation) { eMobileLocation.populateCityCorporations(zillaCtrlID, zillaID, null); }
            if(type === eMobileLocation.locationType.Metropolitan) {
                // $(ddlThanaCtrlID).removeClass('hidden');
                $(ddlThanaCtrlID + ' ~ .select2').show();
                eMobileLocation.populateMetropolitans(zillaCtrlID, zillaID, null);
            }
        });

    },

    populateDivision: function (ctrlID, selectedDivID) {
        return eMobileLocation.populateDropDown(eMobileLocation.ddlDivision, ctrlID, eMobileLocation.locationType.Division, null, selectedDivID);
    },

    populateZilas: function (ctrlID, divID, selectedZillaID) {
        return eMobileLocation.populateDropDown(eMobileLocation.ddlZilla, ctrlID, eMobileLocation.locationType.Zilla, divID, selectedZillaID);
    },

    populateUpazillas: function (ctrlID, zillaID, selectedUpazillaID) {
        return eMobileLocation.populateDropDown(eMobileLocation.ddlUpazilla, ctrlID, eMobileLocation.locationType.Upazilla, zillaID, selectedUpazillaID);
    },

    populateCityCorporations: function (ctrlID, zillaID, selectedCityCorporationID) {
        return eMobileLocation.populateDropDown(eMobileLocation.ddlCityCorporation, ctrlID, eMobileLocation.locationType.CityCorporation, zillaID, selectedCityCorporationID);
    },

    populateMetropolitans: function (ctrlID, zillaID, selectedMetropolitanID) {
        return eMobileLocation.populateDropDown(eMobileLocation.ddlMetropolitan, ctrlID, eMobileLocation.locationType.Metropolitan, zillaID, selectedMetropolitanID);
    },

    populateThanas: function (ctrlID, metropolitanID, selectedThanaID) {
        return eMobileLocation.populateDropDown(eMobileLocation.ddlThana, ctrlID, eMobileLocation.locationType.Thana, metropolitanID, selectedThanaID);
    },

    populateDropDown: function (title, ctrlID, type, paramID, selectedID) {

        // generate control id
        var controlID = '#' + title + ctrlID;

        // clear the control
        eMobileLocation.clearDropdown(controlID, ctrlID);

        // load values
        if(type === eMobileLocation.locationType.Division) {
            return locationService.getDivisions().done(function (locations, textStatus, jqXHR) {
                eMobileLocation.populateOptions(controlID, locations, selectedID);
            });
        } else if(type === eMobileLocation.locationType.Zilla) {
            return locationService.getZillas(paramID).done(function (locations, textStatus, jqXHR) {
                eMobileLocation.populateOptions(controlID, locations, selectedID);
            });
        } else if(type === eMobileLocation.locationType.Upazilla) {
            return locationService.getUpazillas(paramID).done(function (locations, textStatus, jqXHR) {
                eMobileLocation.populateOptions(controlID, locations, selectedID);
            });
        } else if(type === eMobileLocation.locationType.CityCorporation) {
            return locationService.getCityCorporations(paramID).done(function (locations, textStatus, jqXHR) {
                eMobileLocation.populateOptions(controlID, locations, selectedID);
            });
        } else if(type === eMobileLocation.locationType.Metropolitan) {
            return locationService.getMetropolitans(paramID).done(function (locations, textStatus, jqXHR) {
                eMobileLocation.populateOptions(controlID, locations, selectedID);
                $("#ddlThana999").select2();
            });
        } else if(type === eMobileLocation.locationType.Thana) {
            return locationService.getThanas(paramID).done(function (locations, textStatus, jqXHR) {
                eMobileLocation.populateOptions(controlID, locations, selectedID);
            });
        }

    },

    populateOptions: function (controlID, locations, selectedID) {
        
        if(locations && locations.length > 0) {
            $.each(locations, function (i, x) {
                $(controlID).append($('<option>', { value: x.code, text: x.desc }));
            });
        }
        if(selectedID) {
            $(controlID).val(selectedID);
        }
    },

    clearDropdown: function (controlID, controlIndex) {
        $(controlID).empty();
        $(controlID).append($('<option>', { value: '', text: 'বাছাই করুন...' }));
        $(controlID).attr('ctrlID', controlIndex);
    },

    clearLocationType: function(controlID, controlIndex) {
        $(controlID).each(function (i, x) {
            $(x).attr('ctrlID', controlIndex);
            $(x).removeAttr('checked');
            if(i===0) {
                $(x).attr('checked', 'checked');
            }
        });
        var ddlThanaCtrlID = '#' + eMobileLocation.ddlThana + controlIndex;
        // $(ddlThanaCtrlID).addClass('hidden');
        $(ddlThanaCtrlID + ' ~ .select2').hide();
    },

    getLocationType: function (ctrlID) {
        var optLocationTypeCtrlID = '.' + eMobileLocation.optLocationType + ctrlID;
        var type = '';
        $(optLocationTypeCtrlID).each(function (i, x) {
            if($(x).attr('checked') === 'checked') {
                type = $(x).val();
            }
        });
        return type;
    }

};