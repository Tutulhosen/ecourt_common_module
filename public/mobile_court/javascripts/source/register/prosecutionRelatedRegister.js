/**
 * Created by sarker.pranab on 5/18/2017.
 */
var prosecutionRegistere = {

    prosecutionTable:function (search_data) {
        $("#regiDataLoder").css("display", "block");
        $("#saveComplain").attr("disabled", true);

        var xhr = $.ajax({data: search_data, type: "POST", dataType: 'json', url: "../register_list/printprosecutionreport",

        success:function (data)  {
            if(data.result==''){
                message_show(" কোন তথ্য পাওয়া যায় নি।");
            }
            if(data && data.result) {
                data.result = prosecutionRegistere.parseResult(data.result);
                prosecutionRegistere.prepareTable(data);
            }
            $("#nameOfRegi").val(data.name);
            $("#saveComplain").attr("disabled", false);
            $("#regiDataLoder").css("display", "none");
        },

        error:function () {$("#saveComplain").attr("disabled", false);},

        complete:function () { $("#regiDataLoder").css("display", "none");}
        });

    },

    parseResult: function(rawJson) {
        var processedResult = [];
        if(rawJson.length > 0) {
            $.each(rawJson, function(i, x) {
                if(x.crime_description) {
                    x = prosecutionRegistere.cleanseRegisterResult(x);

                    // try {
                    //     var crimeDesc = typeof x.crimedescription === 'string' ? x.crimedescription : String(x.crimedescription);
                    //     crimeDesc = crimeDesc.trim();  // Remove leading/trailing whitespaces
                    // }
                    // catch(err) {
                    //     crimeDesc = [""];
                    // }
                    // try {
                    //     // JSON.parse not working for some invalid characters
                    //     x.crime_description = eval(x.crime_description);
                    // }
                    // catch(err) {
                    //     x.crime_description = [""];
                    // }
                   var idddd= x.crime_description;

                    x.crime_description = idddd.replace(/<\/?[^>]+(>|$)/g, "");
                }
                processedResult.push(x);
            });
        }
        return processedResult;
    },

    cleanseRegisterResult: function(register) {
        if(register.crime_description) {
            register.crime_description = register.crime_description.replace(/<br>/g, '');
            register.crime_description = register.crime_description.replace(/<br >/g, '');
            register.crime_description = register.crime_description.replace(/<br\/>/g, '');
            register.crime_description = register.crime_description.replace(/<br \/>/g, '');
        }
        return register;
    },

    prepareTable: function(data) {
        console.log(data.groupingValue);
        register.setLabelAndComunOfTable(data);
        table = $('#data_table').DataTable({

            "data": data.result,
            "columns": [
                {"data": null},
                {"data": "law_section_number"},
                {"data": "crime_description"},
                {"data": "criminal_details"},
                {"data": "pdate"},
                {"data": "case_no"},
                {"data": "order_detail"},
                {"data": "mag_name"},
                {"data": "divname","searchable": false,"visible": false},
                {"data": "zillaname","searchable": false,"visible": false}
            ],

            "columnDefs":[ {
                "targets":6,
                "render": function ( data, type, row) {
                    if(!data){
                        return "আদেশ প্রদান করা হয়নি ।";
                    }else{
                        return data;
                    }
                }
            } ],

            "scrollY": "500px",
            "scrollX": "400px",
            "scrollCollapse": true,
            "paging": false,
            "responsive": false,
            "searching": true,
            "rowGroup": {
                "dataSrc": data.groupingValue
            },

            "drawCallback": function (settings){
                var api = this.api();
                api.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                     cell.innerHTML = i+1;
                } );
            },
            "destroy": true,
            "autoWidth": false,
            "processing": false,
            "language": {
                        "emptyTable": "কোন তথ্য পাওয়া যায় নি।",
                        "zeroRecords": "কোন তথ্য পাওয়া যায় নি।",
                        "infoEmpty": "",
                        "info":"_START_ থেকে _END_ পর্যন্ত তথ্য দেখানো হল।",
            },

        });
        
        $('#register_column_fields .regiLabelList').on('click', function (e) {
            var label_id = $(this).attr('id');
            var column = table.column($(this).attr('data-column'));
            column.visible(!column.visible());
           
        });
    }


};
