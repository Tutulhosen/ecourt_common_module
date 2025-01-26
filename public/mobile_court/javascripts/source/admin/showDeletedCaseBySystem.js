var DeletedCase = {
    init:function () {
        $.ajax({
            url:"/punishment/getAllRemovedCaseBySystem",
            method:"post",
            dataType: 'json',
            contentType: false,
            processData: false,

            success:function (data) {
                $('#dataTable').dataTable({
                    data: data.result,
                    "columns": [
                        {"data": "case_no"},
                        {"data": "prosecution_date"},
                        {"data": "prosecution_location"},
                        {"data": "prosecutor_name"},
                        {"data": "witness1_name"},
                        {"data": "witness2_name"},
                        {"data": "law_section_number"},
                        {"data": "criminal_name"},
                        {"data": "crime_type"},
                    ],
                    "scrollY": "500px",
                    "scrollX": "400px",
                    "scrollCollapse": true,
                    "paging": false,
                    "responsive": false,
                    "searching": true,
                    "destroy": true,
                    "autoWidth": false,
                    "processing": false,
                    "language": {
                        "emptyTable": "কোন তথ্য পাওয়া যায় নি।",
                        "zeroRecords": "কোন তথ্য পাওয়া যায় নি।",
                        "infoEmpty": ""
                    },
                });

            }
        })
    },
};

$(document).ready(function () {
    DeletedCase.init();
});
