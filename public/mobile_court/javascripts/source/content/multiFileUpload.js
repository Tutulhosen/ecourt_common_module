var mFile = {
    context: null,
    regex: null,
    sFiles: [],

    init: function () {
        mFile.regex =
            /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp|.doc|.docx|.pdf|.xlsx|.xlsm|xltx|.xltm|.txt)$/;
        $(document).on("change", ".multiFileInputCls", function (e) {
            e.preventDefault();
            if (!mFile.regex.test(e.target.files[0].name.toLowerCase())) {
                $.alert(
                    "Invalid File Format, Supported File .jpg/.jpeg/.gif/.png/.bmp/.doc/.docx/.pdf/.xlsx/.xlsm/ xltx/.xltm/.txt । ",
                    "ধন্যবাদ"
                );
                $(this).parents(".multiRowContainer").remove();
                return false;
            }

            var files = e.target.files;
            var fileType = "";

            var ext = files[0]["name"].split(".").pop().toLowerCase();
            // console.log(ext);
            if ($.inArray(ext, ["gif", "png", "jpg", "jpeg", "bmp"]) != -1) {
                fileType = "IMAGE";
            }

            if (
                $.inArray(ext, [
                    "doc",
                    "docx",
                    "pdf",
                    "xlsx",
                    "xlsm",
                    "xltx",
                    "xltm",
                    "txt",
                ]) != -1
            ) {
                fileType = "DOCUMENT";
            }

            var isValid = mFile.validateFileSize(files[0]);

            if (isValid) {
                if (fileType == "IMAGE") {
                    for (var i = 0; i < files.length; i++) {
                        var img = new Image();
                        img.src = URL.createObjectURL(files[i]);
                        img.setAttribute(
                            "class",
                            "img-responsive img-thumbnail multi-image"
                        );
                        img.setAttribute("width", "150px");
                        img.setAttribute("height", "100px");
                        $(this)
                            .parents(".multiRowContainer")
                            .find(".col2")
                            .html(img);
                    }
                }
                if (fileType == "DOCUMENT") {
                    $(this)
                        .parents(".multiRowContainer")
                        .find(".col2")
                        .html(
                            ' <img src="/doc.png" alt="DOC" class="img-responsive img-thumbnail" width="300px" height="200px" />'
                        );
                }
            } else {
                $.alert("File size must be under 25mb!", "অবহতিকরণ বার্তা");
                $(this).parents(".multiRowContainer").remove();
            }
        });

        $(document).on("click", ".photoDelete", function (e) {
            e.preventDefault();

            $(this).parents(".multiRowContainer").remove();
        });

        // $(document).on("click", ".multifileupload", function (e) {
        //     e.preventDefault();

        //     var container = $(this).parent(".photoContainer");
        //     var newNumber = Math.random();
        //     var row = $('<div class="clearfix multiRowContainer"></div>');
        //     // var col1 = $('<div class="form-group col-xs-3 col-sm-3 col-md-3 col-lg-2 col1"></div>');
        //     var col1 = $('<div class="form-group  col1"></div>');
        //     var col2 = $('<div class=" col2"></div>');
        //     var col3 = $('<div class="  col3"></div>');
        //     var label = $(
        //         '<label class="btn btn-primary custom-file-upload">' +
        //             '<i class="glyphicon glyphicon-upload"></i> সংযুক্তি ' +
        //             "</label>"
        //     ).attr("for", newNumber);
        //     var fileInput = $('<input class="multiFileInputCls hidden "/>')
        //         .attr("type", "file")
        //         .attr("name", "files[][someName]")
        //         .attr("id", newNumber);
        //     var file = label.append(fileInput);
        //     col1.append(file);
        //     col3.append(
        //         '<button type="button" class="btn btn-danger photoDelete"><i class="glyphicon glyphicon-remove"></i> অপসারণ</button>'
        //     );
        //     row.append(col1, col2, col3);
        //     container.append(row);

        //     return false;
        // });


        // =====================NEW======================//

        // $(document).ready(function () {
        // Function to add a new row
        function addRow() {
            var newRow = $(`
                    <tr class="attachment-row">
                       
                        <td>
                            <div class="d-flex align-items-center">
                                <input type="file" name="files[][someName]" class="form-control-file d-none" onchange="displayFileDetails(this)">
                                <button 
    type="button" 
    class="btn btn-outline-secondary btn-sm chooseFileBtn text-center" 
    style="padding: 2px 10px; font-size: 0.875rem; border-radius: 0.25rem;">
    ফাইল নির্বাচন করুন
</button>
                             <span class="fileNameDisplay ms-2 text-secondary ml-3">নির্বাচিত ফাইলের নাম</span>
                                <div class="filePreviewContainer ml-2">
                                    <!-- Image preview or file type icon will be injected here -->
                                </div>
                            </div>
                        </td>
                        <td class="d-flex justify-content-end ">
                            <button type="button" class="btn btn-danger p-1 rounded-circle removeRowBtn" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">-</button>
                        </td>
                    </tr>
                `);

            $(".attachmentTableBody").append(newRow);
        }

        // Function to display selected file name and preview based on file type
        window.displayFileDetails = function (input) {
            var file = input.files[0];
            var fileNameDisplay = $(input).siblings(".fileNameDisplay");
            var previewContainer = $(input).siblings(".filePreviewContainer");

            // Clear any previous preview
            previewContainer.empty();

            if (file) {
                fileNameDisplay.text(file.name).addClass("text-primary");

                if (file.type.startsWith("image/")) {
                    // Image preview
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var imgPreview = $('<img class="filePreview" />').attr("src", e.target.result);
                        previewContainer.append(imgPreview);
                    };
                    reader.readAsDataURL(file);
                } else if (file.type === "application/pdf") {
                    // PDF preview icon
                    previewContainer.append('<i class="fileIcon bi bi-file-earmark-pdf text-danger"></i>');
                } else if (file.name.endsWith(".doc") || file.name.endsWith(".docx")) {
                    // DOC/DOCX preview icon
                    previewContainer.append('<i class="fileIcon bi bi-file-earmark-word text-primary"></i>');
                } else {
                    // Other files, display just the file name
                    fileNameDisplay.text(file.name).addClass("text-primary");
                }
            } else {
                fileNameDisplay.text("Browse").removeClass("text-primary");
            }
        };

        // Add initial row
        addRow();

        // Add row on add button click
        $(document).on("click", ".addRowBtn", function () {
            addRow();
        });

        // Remove row on delete button click
        $(document).on("click", ".removeRowBtn", function () {
            $(this).closest("tr").remove();
        });

        // Trigger file input on "Choose File" button click
        $(document).on("click", ".chooseFileBtn", function () {
            $(this).siblings("input[type='file']").trigger("click");
        });
        // });




    },

    validateFileSize: function (file) {
        if (file.size > 25000000) {
            return false;
        } else {
            return true;
        }
    },
};

$(document).ready(function () {
    mFile.init();
});