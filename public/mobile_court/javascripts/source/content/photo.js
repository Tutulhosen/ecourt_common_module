var mPhoto = {

    context: null,
    regex: null,

    init: function () {
        mPhoto.regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
        mPhoto.context = document.getElementById('dvPreview').getContext('2d');

        $('#viewImgModal').on('show.bs.modal', function (e) {
            mPhoto.clearPhotoUploadForm();
        });

        $(document).on('change', '#fileupload', function (e) {
            if (!mPhoto.regex.test(e.target.files[0].name.toLowerCase())) {
                mPhoto.clearPhotoUploadForm();
                return false;
            }
            var files = e.target.files;

            for(var i=0; i < files.length; i++){
                var img = new Image;
                var canvas = document.getElementById('dvPreview');

                img.onload = function(){
                    var wrh = this.width / this.height;
                    var newWidth = canvas.width;
                    var newHeight = newWidth / wrh;

                    if (newHeight > canvas.height) {
                        newHeight = canvas.height;
                        newWidth = newHeight * wrh;
                    }

                    mPhoto.context.drawImage(this,
                        canvas.width / 2 - newWidth / 2,
                        canvas.height / 2 - newHeight / 2,
                        newWidth, newHeight);
                };

                img.src = URL.createObjectURL(files[i]);
            }
        });
    },

    //For Edit/Delete Image
    showPhoto: function(){
        $('#divImageListContainer').remove();
        var url = "/file_upload/getPhotoInformation";
        $.ajax({ type: "POST", url: url,
            success: function (images) {
                var listItem = '';
                if(images && images.length > 0) {
                    $(images).each(function (i, image) {
                        listItem += '<div class="thumbnail col-xs-3 col-sm-3 col-md-3 col-lg-2" FileID="'+ image.FileID +'" FileCaption="'+ image.FileCaption +'" FilePath="'+ image.FilePath +'" onclick="return mPhoto.editImage(event, this); " >' +
                            '<button class="img-button close" FileID="'+ image.FileID +'" FileCaption="'+ image.FileCaption +'" FilePath="'+ image.FilePath +'" onclick="return mPhoto.deleteImage(event, this); ">'+
                            '<span aria-hidden="true">&times;</span>' +
                            '</button>'+
                            '<div class="img-label">'+ image.FileCaption +'</div>' +
                            '<img class="img-responsive multi-image" src="'+ image.FilePath +'">' +
                            '</div>';
                    });
                }
                var container = '<div id="divImageListContainer" class="docs-pictures clearfix">'+listItem+'</div>';
                $('#photoView').append(container);
            }
        });
    },

    //Populate Edit Modal
    editImage: function (event, element) {
        event.preventDefault();
        $('#txtEditImageCaption').attr('fileid', $(element).attr('FileID'));
        $('#txtEditImageCaption').val($(element).attr('FileCaption'));
        $('#imgEditImage').attr('src', $(element).attr('FilePath'));
        $('#editImgModal').modal('show');
        return false;
    },

    //Append Data for Edit Caption

    getEditPhoto: function () {
        var formData = new FormData();
        formData.append("FileCaption", $('#txtEditImageCaption').val());
        formData.append("FileID", $('#txtEditImageCaption').attr("fileid"));
        return formData;
    },

    //Send Data for Edit Caption

    editNewPhoto: function (event) {
        event.preventDefault();

        var formData = mPhoto.getEditPhoto();
        var formURL = "/file_upload/editPhoto";

        $.ajax({url: formURL, type: 'POST', data: formData, dataType: 'json', mimeType: "multipart/form-data", contentType: false, cache: false, processData: false,
            success: function (response) {
                $('#editImgModal').modal('hide');
                $.alert("ক্যাপশন পরিবর্তন সম্পন্ন হয়েছে ।","ধন্যবাদ");
                // location.reload();
                mPhoto.showPhoto();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("ক্যাপশন পরিবর্তন সম্পন্ন হয়নি । পূনরায় চেষ্টা করুন ।", "অবহতিকরণ বার্তা");
            }
        });

        return false;
    },


    clearPhotoUploadForm: function () {
        $('#dvError').text('');
        $('#fileupload').val(null);
        mPhoto.context.fillRect(0, 0, document.getElementById('dvPreview').width, document.getElementById('dvPreview').height);
    },

    getNewPhoto: function () {
        var formData = new FormData();

        formData.append("caption", $('#txtCaption').val());
        formData.append("appName", $('#hiddenApp').val());
        formData.append("category", $('#hiddenCategory').val());
        formData.append("image", document.getElementById('fileupload').files[0]);
        return formData;
    },

    saveNewPhoto: function (event) {
        event.preventDefault();

        // Cache DOM
        var $dvError        = $("#dvError");
        var $txtCaption     = $("#txtCaption");
        var $viewImgModal   = $('#viewImgModal');

        // check valid file
        var $ErrorMsg = {
            "valid-image"   : "<i class='fa fa-info-circle'></i> গ্রহণযোগ্য ফাইল ফরম্যাট .jpg / .jpeg / .gif / .png / .bmp!",
            "title-missing" : "<i class='fa fa-info-circle'></i> ক্যাপশন সংযুক্ত করুন !",
            "file-size"     : "<i class='fa fa-info-circle'></i> সর্বোচ্চ ফাইল সাইজ ৫ মেগাবাইট!"
        };

        $($dvError).html('');

        if(document.getElementById('fileupload').files.length < 1) {
            $($dvError).html($ErrorMsg['valid-image']);
            return false;
        }
        // check caption

        if($.trim($($txtCaption).val()) == ''){
            $($dvError).html($ErrorMsg['title-missing']);
            return false;
        }
        // check file size

        var fi = document.getElementById('fileupload');

        if(fi.files[0].size  > 5000000 )
        {
            $($dvError).html($ErrorMsg['file-size']);
            return false;
        }

        var formData = mPhoto.getNewPhoto();
        var formURL = "/file_upload/photoSave";

        $.ajax({url: formURL, type: 'POST', data: formData, dataType: 'json', mimeType: "multipart/form-data", contentType: false, cache: false, processData: false,
            success: function (response) {
                $('#viewImgModal').modal('hide');
                $('#txtCaption').val('');
                $.alert("ছবি আপলোড সম্পন্ন হয়েছে ।","ধন্যবাদ");
                // location.reload();
                mPhoto.showPhoto();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("ছবি আপলোড সম্পন্ন হয়নি । পূনরায় চেষ্টা করুন ।", "অবহতিকরণ বার্তা");
            }
        });

        return false;
    },

    deleteImage: function (event, element) {

        event.preventDefault();

        $('#txtDeleteImageCaption').attr('fileid', $(element).attr('FileID'));
        $('#txtDeleteImageCaption').val($(element).attr('FileCaption'));
        $('#txtDeleteImageCaption').attr('readonly','readonly');
        $('#imgDeleteImage').attr('src', $(element).attr('FilePath'));
        $('#deleteImgModal').modal('show');
        event.stopPropagation();
        return false;
    },

    //Append Data for Edit Caption

    getDeletePhoto: function () {
        var formData = new FormData();
        formData.append("FileID", $('#txtDeleteImageCaption').attr("fileid"));
        return formData;
    },

    //Send Data for Edit Caption

    deleteNewPhoto: function (event) {
        event.preventDefault();

        var formData = mPhoto.getDeletePhoto();
        var formURL = "/file_upload/deletePhoto";

        $.ajax({url: formURL, type: 'POST', data: formData, dataType: 'json', mimeType: "multipart/form-data", contentType: false, cache: false, processData: false,
            success: function (response) {
                $('#deleteImgModal').modal('hide');
                $.alert("ছবি ডিলিট সম্পন্ন হয়েছে ।","ধন্যবাদ");
                // location.reload();
                mPhoto.showPhoto();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.alert("ছবি ডিলিট সম্পন্ন হয়নি । পূনরায় চেষ্টা করুন ।", "অবহতিকরণ বার্তা");
            }
        });

        return false;
    },

};


$(document).ready(function () {
   mPhoto.init();
   mPhoto.showPhoto();
});


