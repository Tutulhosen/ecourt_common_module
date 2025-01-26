/**
 * Created by johirul on 6/15/17.
 */
var dailyRegister = {

dailyTable:function (search_data) {
        $("#regiDataLoder").css("display", "block");
        $("#saveComplain").attr("disabled", true);
        var xhr = $.ajax({
            data: search_data, type: "POST", dataType: 'json', url: "../register_list/printdailyregister",

        success:function (data)  {
            if(data && data.result) {
                data.result = dailyRegister.parseResult(data.result);
                dailyRegister.prepareTable(data);
            }
            if(data.result==''){
                message_show(" কোন তথ্য পাওয়া যায় নি।");
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
                if(x.crime_details) {
                    x = dailyRegister.cleanseRegisterResult(x);

                    try {
                        // JSON.parse not working for some invalid characters
                        x.crime_details = eval(x.crime_details);
                    }
                    catch(err) {
                        x.crime_details = [""];
                    }
                }
                processedResult.push(x);
            });
        }
        return processedResult;
    },

    cleanseRegisterResult: function(register) {
        if(register.crime_details) {
            register.crime_details = register.crime_details.replace(/<br>/g, '');
            register.crime_details = register.crime_details.replace(/<br >/g, '');
            register.crime_details = register.crime_details.replace(/<br\/>/g, '');
            register.crime_details = register.crime_details.replace(/<br \/>/g, '');
        }
        return register;
    },

    prepareTable: function(data) {

                register.setLabelAndComunOfTable(data);
                table = $('#data_table').DataTable({

                    "data": data.result,
                    "columns": [
                        {"data": null},
                        {"data": "case_date"},
                        {"data": "case_no"},
                        {"data": "mag_name"},
                        {"data": "proc_name_and_designation"},
                        {"data": "law_details"},
                        {"data": "crime_details"},
                        {"data": "order_details"},
                        {"data": "receipt_no"},
                        {"data": "next_order"},
                        {"data": "divname","searchable": false,"visible": false},
                        {"data": "zillaname","searchable": false,"visible": false}
                    ],
                    "columnDefs":[ {
                        "targets":7,
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
                        "info":"_START_ থেকে _END_ পর্যন্ত তথ্য দেখানো হল।"
                    },

                    /*dom: 'Bfrtip',
                    "buttons": [
                        {
                            extend: 'print',
                            exportOptions: {
                                grouped_array_index: [11]
                            },
                            "title": "প্রাত্যহিক রেজিষ্টার ",
                            "text": '<a href="#" class="btn btn-success btn-sm">'+
                            '<span class="glyphicon glyphicon-print"></span> Print'+
                            '</a>'
                        }
                    ]*/
                });


                $('#register_column_fields .regiLabelList').on('click', function (e) {
                    var label_id = $(this).attr('id');
                    var column = table.column($(this).attr('data-column'));
                    column.visible(!column.visible());
                     $('#printButtonForRegi').css('display','block');
                   
                });


    }


};
