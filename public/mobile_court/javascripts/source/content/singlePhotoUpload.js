var mPhoto = {

    context: null,
    regex: null,
    sFiles:[],

    init: function () {
        mPhoto.regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;

        $(document).on('change', '.fileInputCls', function (e) {
            e.preventDefault();
            if (!mPhoto.regex.test(e.target.files[0].name.toLowerCase())) {
                $.alert("Invalid File Format পূনরায় চেষ্টা করুন ।  ", "ধন্যবাদ");
                $(this).parents('.rowContainer').remove();
                return false;
            }
            var files = e.target.files;

            var isValid = mPhoto.validateFileSize(files[0]);

            if(isValid){

                for(var i=0; i < files.length; i++){
                    var img = new Image;
                    img.src = URL.createObjectURL(files[i]);
                    img.setAttribute("class","img-responsive img-thumbnail");
                    img.setAttribute("width","300px");
                    img.setAttribute("height","200px");
                    $(this).parents(".rowContainer").find(".col2").html(img);
                }
            }

            else {
                $.alert("File size must be under 1mb!", "অবহতিকরণ বার্তা");
                $(this).parents('.rowContainer').remove();
            }

        });

        $(document).on('click', '.photoDelete', function (e) {
            e.preventDefault();

            $(this).parents('.rowContainer').remove();
        });

        $(document).on('click', '.fileupload', function (e) {
            e.preventDefault();
            var container = $(this).parent('.photoContainer');

            if(container.find('.rowContainer').find('input[type=file]').length == 0){

                var row = $('<div class="clearfix rowContainer"></div>');
                var col1 = $('<div class="form-group col-xs-3 col-sm-3 col-md-3 col-lg-5 col1"></div>');
                var col2 = $('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-5 col2"></div>');
                var col3 = $('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2 col3"></div>');
                var file = $('<input class="fileInputCls"/>').attr('type', 'file').attr('name', 'someName');
                col1.append(file);
                col3.append('<button type="button" class="btn btn-sm btn-danger m-top-10 photoDelete"><i class="glyphicon glyphicon-remove"></i> অপসারণ</button>');
                row.append(col1,col2,col3);

                container.append(row);
            }else{
                return false;
            }
        });
    },

        validateFileSize: function (file) {
        if(file.size>1000000) {
            return false;
        }
        else {
            return true;
        }
    },

};


$(document).ready(function () {
    mPhoto.init();
});


