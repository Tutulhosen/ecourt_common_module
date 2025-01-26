/**
 * Created by sarker.pranab on 5/18/2017.
 */

var nagorikOvijogRegistere = {


    nagorikOvijogTable:function (search_data) {
        $("#regiDataLoder").css("display", "block");
        $("#saveComplain").attr("disabled", true);
        $.ajax({
            data: search_data,
            type: "POST",
            dataType: 'json',
            url: "../register_list/printcitizenregister", // This is the URL to the API
            success:function (data) {
                if(data.result==''){
                    message_show(" কোন তথ্য পাওয়া যায় নি।");
                }
                $("#nameOfRegi").val(data.name);
                $("#saveComplain").attr("disabled", false);
                $("#regiDataLoder").css("display", "none");

                 register.setLabelAndComunOfTable(data);
                 table = $('#data_table').DataTable({

                    "data": data.result,
                    "columns": [
                        {"data": null},
                        {"data": "cdate"},
                        {"data": "user_idno"},
                        {"data": "name_bng"},
                        {"data": "idate"},
                        {"data": "location"},
                        {"data": "complain_details"},
                        {"data": "complain_status"},
                        {"data": "estimated_date"},
                        {"data": "mag_name"},
                        {"data": "divname","searchable": false,"visible": false},
                        {"data": "zillaname","searchable": false,"visible": false}
                    ],
                     "columnDefs":[ {
                        "targets": 7,
                        "render": function ( data, type, row) {
                            if(data =='accepted'){
                                return "গ্রহণকৃত";
                            }else if(data =='initial'){
                                 return "অপেক্ষমান";
                            }else if(data =='ignore'){
                                 return "বাতিলকৃত";
                            }else if(data =='solved'){
                                 return "নিস্পপ্তিকৃত";
                            }else if(data =='re-send'){
                                 return "পুঃবিবেচনার জন্য প্রেরিত";
                            }else if(data =='no-comment'){
                                 return "মন্তব্য নাই";
                            }
                            else{
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
                                             grouped_array_index: [10]
                                        },
                                        "title": "নাগরিক অভিযোগ রেজিস্টার",
                                        "text": '<a href="#" class="btn btn-success btn-sm">'+
                                        '<span class="glyphicon glyphicon-print"></span> Print'+
                                    '</a>'
                                    }
                    ]*/

                });

                /* table.on( 'order.dt search.dt', function () {
                    table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                        cell.innerHTML = i+1;
                    } );
                } ).draw();*/
                 //$('#data_table tbody').addClass("scrollDataTable");

               /* $('a.toggle-vis').on('click', function (e) {
                    e.preventDefault();
                    if ($(this).attr('class') == "toggle-vis btn-sm btn-primary") {
                        $(this).removeClass("btn-primary");
                        $(this).addClass("btn-default");
                    } else {
                        $(this).removeClass("btn-default");
                        $(this).addClass("btn-primary");
                    }
                    // Get the column API object
                    //var column = table.api().column($(this).attr('data-column'));
                    var column = table.column($(this).attr('data-column'));

                    // Toggle the visibility
                    column.visible(!column.visible());
                }); */


                $('#register_column_fields .regiLabelList').on('click', function (e) {
                    var label_id = $(this).attr('id');
                    /*if($(this).is(":checked")){
                    }
                    else if($(this).is(":not(:checked)")){
                    }*/
                    var column = table.column($(this).attr('data-column'));
                    column.visible(!column.visible());

                   
                });
                         

            },
            error:function () {
                 $("#saveComplain").attr("disabled", false);
            },
            complete:function () {
                $("#regiDataLoder").css("display", "none");
            }
        });
    }
};

