/**
 * Created by Rima on 7/06/17.
 */
var lawBasedRegistere = {

    lawBasedTable:function (search_data) {
        $("#regiDataLoder").css("display", "block");
        $("#saveComplain").attr("disabled", true);
        var xhr = $.ajax({data: search_data, type: "POST", dataType: 'json', url: "../register_list/printlawbasedReport",

        success:function (data)  {
            if(data.result==''){
                message_show(" কোন তথ্য পাওয়া যায় নি।");
            }
            if(data && data.result) {
                data.result = lawBasedRegistere.parseResult(data.result);
                lawBasedRegistere.prepareTable(data);
            }
            $("#nameOfRegi").val(data.name);
            $("#saveComplain").attr("disabled", false);
            $("#regiDataLoder").css("display", "none");
        },

        error:function () { $("#saveComplain").attr("disabled", false);},

        complete:function () {$("#regiDataLoder").css("display", "none");}
        });

    },

    parseResult: function(rawJson) {
        var processedResult = [];
        if(rawJson.length > 0) {
            $.each(rawJson, function(i, x) {
                if(x.crimedescription) {
                    x = lawBasedRegistere.cleanseRegisterResult(x);

                    try {
                        var crimeDesc = typeof x.crimedescription === 'string' ? x.crimedescription : String(x.crimedescription);
                        crimeDesc = crimeDesc.trim();  // Remove leading/trailing whitespaces
                    }
                    catch(err) {
                        crimeDesc = [""];
                    }
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
              console.log(data);
                register.setLabelAndComunOfTable(data);
                table = $('#data_table').DataTable({

                    "data": data.result,
                    "columns": [
                        {"data": null},
                        {"data": "divname"},
                        {"data": "zillaname"},
                        {"data": "pdate"},
                        {"data": "case_no"},
                        {"data": "name_bng"},
                        {"data": "sec_number"},
                        {"data": "crimedescription"},
                        {"data": "order_detail"},
                        {"data": "title","searchable": false,"visible": false, "orderData": [0, 1]}
                    ],
                    "scrollY": "500px",
                    "scrollX": "400px",
                    "scrollCollapse": true,
                    "paging": false,
                    "responsive": false,
                    "searching": true,
                    "rowGroup": {
                        "dataSrc": "title"
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

                });
                
                /*table.on( 'order.dt search.dt', function () {
                    table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                        cell.innerHTML = i+1;
                    } );
                } ).draw();*/

                $('#register_column_fields .regiLabelList').on('click', function (e) {
                    var label_id = $(this).attr('id');
                    var column = table.column($(this).attr('data-column'));
                    column.visible(!column.visible());
                   
                });


    }


};
