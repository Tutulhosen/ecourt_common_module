/**
 * Created by johirul on 6/16/17.
 */
/**
 * Created by johirul on 6/15/17.
 */

var punishmentJailRegister = {

    punishmentJailTable:function (search_data) {
        $("#regiDataLoder").css("display", "block");
        $("#saveComplain").attr("disabled", true);

        $.ajax({
            data: search_data,
            type: "POST",
            dataType: 'json',
            url: "../register_list/printPunishmentJailRegister", // This is the URL to the API

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
                        {"data": "order_details"},
                        {"data": "next_order"},
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


