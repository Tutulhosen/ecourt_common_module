/**
 * Created by johirul on 6/15/17.
 */

var punishmentFineRegister = {

    punishmentFineTable:function (search_data) {
        $("#regiDataLoder").css("display", "block");
        $("#saveComplain").attr("disabled", true);
        $.ajax({
            data: search_data,
            type: "POST",
            dataType: 'json',
            url: "../register_list/printPunishmentFineRegister", // This is the URL to the API

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
                        {"data": "case_date"},
                        {"data": "case_no"},
                        {"data": "court_name"},
                        {"data": "crim_name"},
                        {"data": "law_details"},
                        {"data": "collected_fine"},
                        {"data": "receipt_no"},
                        {"data": "divname","searchable": false,"visible": false},
                        {"data": "zillaname","searchable": false,"visible": false}
                    ],
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
                                grouped_array_index: [8]
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


