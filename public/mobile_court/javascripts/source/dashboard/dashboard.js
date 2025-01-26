/**
 * Created by sarker.pranab on 5/18/2017.
 */
var dashboard = {

    init: function () {
        var user_prfoile = $('#user_prfoile').val();
        if((user_prfoile == 'Divisional Commissioner')||(user_prfoile == 'JS' )){
            $('#division').select2();
            $('#zilla').select2();
        }
        /* Make Searchable 'Auto Complete' */
        $('#upazila').select2();

        $('#GeoCityCorporations').select2();
        $('#GeoMetropolitan').select2();
        $('#GeoThanas').select2();
        $('#graph').select2();

        var zillaid = $('#zilla').val();
        if(zillaid!=''){
            showupozilladiv();
        }
        $('#startdate,#enddate').datepicker({dateFormat: 'yy/mm/dd'});
    },
    getSelectedValues: function () {
        var graph = $('#graph').val();
        var divid = $('#division').val();
        var zillaid = $('#zilla').val();
        var upozilaid = $('#upazila').val();

        var GeoCityCorporations = $('#GeoCityCorporations').val();

        var GeoMetropolitan = $('#GeoMetropolitan').val();
        var GeoThanas = $('#GeoThanas').val();

        if((GeoMetropolitan == '') && (GeoThanas!='')){
            alert("অনুগ্রহ করে মেট্রোপলিটন নির্বাচন করুন ");
            die;
        }
        if((GeoMetropolitan != '') && (GeoThanas=='')){
            alert("অনুগ্রহ করে থানা নির্বাচন করুন ");
            die;
        }

        var start_date = $('#startdate').val();
        var end_date = $('#enddate').val();
        return {
            graph: graph,
            divid: divid,
            zillaid: zillaid,
            upozilaid: upozilaid,
            GeoCityCorporations: GeoCityCorporations,
            GeoMetropolitan: GeoMetropolitan,
            GeoThanas: GeoThanas,
            start_date: start_date,
            end_date: end_date
        };
    },
    getFormatedString: function (__ret) {
        return "&divisionid=" + __ret.divid + "&zillaid=" + __ret.zillaid + "&upozilaid=" + __ret.upozilaid + "&GeoCityCorporations=" + __ret.GeoCityCorporations + "&GeoMetropolitan=" + __ret.GeoMetropolitan + "&GeoThanas=" + __ret.GeoThanas + "&start_date=" + __ret.start_date + "&end_date=" + __ret.end_date;
    },
    searchGraphInformation: function () {
        var __ret = this.getSelectedValues();

        if(!__ret.graph){
            alert("অনুগ্রহ করে গ্রাফ নির্বাচন করুন ");
            die;
        }

        var search_data = this.getFormatedString(__ret);

        if (__ret.graph == '1') {
            citizen_complain.init(search_data);
        } else if (__ret.graph == '2') {
            location_vs_case.init(search_data);
        } else if (__ret.graph == '3') {
            citizen_fine_graph.init(search_data);
        } else if (__ret.graph == '4') {
            law_vs_case.init(search_data);
        }

    },

    citizenComplainStatisticsBlock: function () {
        $('#criminal_info').loading();
        var __ret = this.getSelectedValues();
        var search_data = this.getFormatedString(__ret);
        dashboard_statistics_citizen_complain.getCriminalInfo(search_data)

    },
    caseStatisticsBlock: function () {
        $('#case_statistics').loading();
        var __ret = this.getSelectedValues();

        var search_data = this.getFormatedString(__ret);

        dashboard_statistics_case.getCaseInfo(search_data)
    },
    collupsableTable: function () {
        $('.collaptable').aCollapTable({
            startCollapsed: true,
            addColumn: false,
            plusButton: "<i class='fa fa-plus'></i> ",
            minusButton: "<i class='fa fa-minus'></i> "
        });

    }

};

$(document).ready(function() {
    dashboard.init();
});
