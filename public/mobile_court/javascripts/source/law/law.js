var lawSelector = {

    lawCtrlPrefix: '#ddlLaw',
    sectionCtrlPrefix: '#ddlSection',
    punishmentDescCtrlPrefix: '#txtPunishmentDesc',
    crimeDescCtrlPrefix: '#txtCrimeDesc',

    getProsecutorLaws:function () {
        var prosecutorId=$('#prosecutorIdInProsecution').val();
        var url = '/law/getLawListByProsecutorId?prosecutorId='+prosecutorId;
        return $.ajax({url: url, dataType: 'json'});
    },

  
    getLaws: function () {
        var url = '/law/getLaw';
        return $.ajax({url: url, dataType: 'json'});
    },

    getSections: function (lawID) {
      
        var url = '/section/getSectionByLawId?id=' + lawID;
        return $.ajax({url: url, dataType: 'json'});
    },

    getSectionPunishment: function (sectionID) {
        var url = '/section/getPunishmentBySectionId?id=' + sectionID;
        return $.ajax({url: url, dataType: 'json'});
    },

    init: function (ctrlIndex, selectedLawID, selectedSectionID) {
        var lawCtrl = lawSelector.lawCtrlPrefix + ctrlIndex;
        var sectionCtrl = lawSelector.sectionCtrlPrefix + ctrlIndex;
        var punishmentCtrl = lawSelector.punishmentDescCtrlPrefix + ctrlIndex;
        var crimeDescCtrl = lawSelector.crimeDescCtrlPrefix + ctrlIndex;

        var prosecutorId=$('#prosecutorIdInProsecution').val();
        $(lawCtrl).select2();
        $(sectionCtrl).select2();


        if(prosecutorId){
            lawSelector.getProsecutorLaws().done(function (laws, textStatus, jqXHR) {
                uiUtil.populateSelectOptions(lawCtrl, 'বাছাই করুন...', laws, 'id', 'name', selectedLawID);
                if(selectedLawID && selectedSectionID) {
                    lawSelector.getSections(selectedLawID).done(function (sections, textStatus, jqXHR) {
                        uiUtil.populateSelectOptions(sectionCtrl, 'বাছাই করুন...', sections, 'id', 'sec_description', selectedSectionID);
                    });
                }
                else {
                    uiUtil.populateSelectOptions(sectionCtrl, 'বাছাই করুন...', [], 'id', 'sec_description', null);
                }
            });
        }else{
            lawSelector.getLaws().done(function (laws, textStatus, jqXHR) {
                uiUtil.populateSelectOptions(lawCtrl, 'বাছাই করুন...', laws, 'id', 'name', selectedLawID);
                if(selectedLawID && selectedSectionID) {
                    lawSelector.getSections(selectedLawID).done(function (sections, textStatus, jqXHR) {
                        uiUtil.populateSelectOptions(sectionCtrl, 'বাছাই করুন...', sections, 'id', 'sec_description', selectedSectionID);
                    });
                }
                else {
                    uiUtil.populateSelectOptions(sectionCtrl, 'বাছাই করুন...', [], 'id', 'sec_description', null);
                }
            });
        }


        $(document).on('change', lawCtrl, function(event) {
            var lawIDOnSelect = $(this).val();
            if(lawIDOnSelect === '0') {
                uiUtil.populateSelectOptions(sectionCtrl, 'বাছাই করুন...', [], 'id', 'sec_description', null);
            }
            else {
                lawSelector.getSections(lawIDOnSelect).done(function (sections, textStatus, jqXHR) {
                    uiUtil.populateSelectOptions(sectionCtrl, 'বাছাই করুন...', sections, 'id', 'sec_description', null);
                });
            }
        });

        $(document).on('change', sectionCtrl, function(event) {
            $(punishmentCtrl).val('');
            $(crimeDescCtrl).val('');
            var sectionIDOnSelect = $(this).val();
            lawSelector.getSectionPunishment(sectionIDOnSelect).done(function (punishment, textStatus, jqXHR) {
                $(punishmentCtrl).val(punishment.sectiondes);
                $(crimeDescCtrl).val(punishment.name);
            });
        });

    }



};