@extends('layout.app')
@section('content')
<style>
    /* Style the custom file input */
    .custom-file-upload {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .file-input {
        display: none; /* Hide the default file input */
    }

    .file-label {
        display: inline-block;
        padding: 8px 16px;
        background-color: green;
        color: #fff;
        cursor: pointer;
        border-radius: 4px;
        font-size: 14px;
    }

    .file-label:hover {
        background-color: green;
    }

    /* File preview container */
    .file-preview {
        margin-top: 10px;
    }

    .file-preview img {
        max-width: 100px;
        max-height: 100px;
        margin-right: 10px;
    }

    /* Error message */
    .text-danger {
        color: white;
    }

    /* Add a warning for file size (optional) */
    .file-size-warning {
        font-size: 12px;
        color: white;
        margin-top: 5px;
    }

</style>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('mc_sottogolpo.update', $golpo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card card-default p-3">
            {{-- <div class="card-heading">
                <h2 class="card-title text-center">গল্প </h2>
            </div> --}}
            <div class="card-body p-15 cpv">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label class="control-label"><span class="text-danger">*</span>গল্পের নাম</label>
                            <input type="text" name="title" class="input form-control" required
                                value="{{ $golpo->title }}">
                        </div>
                        <!-- form-group -->
                    </div>
                </div>
                <!-- row -->

                <span class="control-label" style="font-size: 17px; font-weight: 700"><span
                        class="text-danger">*</span>বিস্তারিত </span>
                <div class="row" id="content-wrapper"> <!-- Changed ID to avoid conflict -->
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <textarea class="form-control" id="editorContent" name="content"
                                style="width: 100%; height: 200px; font-size: 14px; line-height: 18px;">{{ $golpo->details }}</textarea>
                        </div>
                    </div>
                </div>
                {{-- <div class="row mt-3">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label class="control-label"><span class="text-danger">*</span>গল্পের মূলবিষয় (স্থানের নাম,
                                ঘটনা)</label>
                            <input type="text" name="keyword" class="input form-control" required>
                        </div>
                        <!-- form-group -->
                    </div>

                </div> --}}
                <!-- row -->
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="control-label"><span class="text-danger">*</span>আইন</label>
                            <select name="law_id" class="form-control">
                                <option value="">বাছাই করুন...</option>
                                @foreach ($laws as $law)
                                    <option value="{{ $law->id }}" {{ $law->id == $golpo->law_id ? 'selected' : '' }}
                                        data-details="{{ $law->title }}">
                                        {{ $law->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- form-group -->
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="control-label"><span class="text-danger">*</span>অপরাধের ধরন</label>
                            <select name="case_type_id" class="form-control">
                                <option value="">বাছাই করুন...</option>
                                @foreach ($case_type as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $item->id == $golpo->case_type_id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <!-- row -->

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label class="control-label">
                                <span class="text-danger">*</span>প্রচ্ছদ ছবি সংযুক্ত করুন (সর্বোচ্চ ফাইল সাইজ 1MB)
                            </label>
                            
                            <div class="custom-file-upload">
                                <input name="attachments[]" type="file" multiple id="file-upload" class="file-input" accept="image/*">
                                <label for="file-upload" class="file-label">
                                    <span style="color: #fff">ফাইল নির্বাচন করুন</span>
                                </label>
                                <div id="file-preview" class="file-preview"></div>
                            </div>
                           
                        </div>
                        <!-- form-group -->
                    </div>
                    <!-- col-sm-6 -->
                </div>
                <div class="flex flex-wrap" id="preview_div">
                    <img src="{{ asset('mobile_court/uploads/golpo/' . $golpo->story_pic) }}" alt="Story Image"
                        width="120" height="120">
                    <img src="{{ asset('mobile_court/uploads/golpo/' . $golpo->story_pic_body) }}" alt="Story Image"
                        width="120" height="120">
                </div>
                <!-- row -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label class="control-label" style="font-weight: bold; font-size: 17px" ><span class="text-danger">*</span>স্ট্যাটাস</label>
                        <div class="radio-inline">
                            <label class="radio">
                                <input type="radio" name="status" value="1"
                                    <?= $golpo->status == 1 ? 'checked' : '' ?> />
                                <span></span>এনাবল</label>
                            <label class="radio text-danger">
                                <input type="radio" name="status" value="0"
                                    <?= $golpo->status == 0 ? 'checked' : '' ?> />
                                <span></span>ডিসএবল</label>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="filename" value="{{ old('filename') }}">
            <input type="hidden" name="filenamebody" value="{{ old('filenamebody') }}">
            <input type="hidden" name="id" value="{{ old('id') }}">
            <div class="card-footer">
                {{-- {{ link_to("index", "&larr; প্রথম পাতা") }} --}}
                <div class="pull-right">
                    <button class="btn btn-success" type="submit"><i class="fas fa-check"></i>
                        আপডেট</button>
                </div>
            </div>
            <!-- panel-footer -->
        </div><!-- panel -->
    </form>

    <div id="successsottogolpo" class="modal fade" style="display: none; ">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal">×</a>

                    <h1>ধন্যবাদ</h1>
                </div>
                <div class="modal-body">
                    <h1>
                        সফলভাবে সংরক্ষণ করা হয়েছে ।
                    </h1>

                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-mideum" data-dismiss="modal">সমাপ্ত</a>
                </div>
            </div>
        </div>
    </div>

    <div id="errorsottogolpo" class="modal fade" style="display: none; ">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal">×</a>

                    <h3>ধন্যবাদ</h3>
                </div>
                <div class="modal-body">
                    <h3 style="color: red;">
                    </h3>
                    <br />

                    <h3 style="color: green;">
                        পূনরায় চেষ্টা করুন ।
                    </h3>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-mideum" data-dismiss="modal">সমাপ্ত</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="{{ asset('mobile_court/cssmc/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile_court/cssmc/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('mobile_court/cssmc/dropzone.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('mobile_court/css/jquery.fileupload-ui-noscript.css') }}"> -->
    <!-- <link rel="stylesheet" href="{{ asset('mobile_court/css/jquery.fileupload-ui.css') }}"> -->

    <script src="{{ asset('mobile_court/js/select2.min.js') }}"></script>
    <script src="{{ asset('mobile_court/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('mobile_court/js/dropzone.min.js') }}"></script>
    <script src="{{ asset('mobile_court/js/jquery-ui-1.10.3.min.js') }}"></script>

    <script src="{{ asset('mobile_court/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('mobile_court/js/bootstrap-wizard.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('mobile_court/cssmc/bootstrap-wysihtml5.css') }}">
    <script src="{{ asset('mobile_court/js/wysihtml5-0.3.0.min.js') }}"></script>
    <script src="{{ asset('mobile_court/js/bootstrap-wysihtml5.js') }}"></script>
    <!-- <script src="{{ asset('mobile_court/js/jquery.fileupload.js') }}"></script> -->
    <!-- <script src="{{ asset('mobile_court/js/jquery.fileupload-ui-noscript.js') }}"></script> -->
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <script>
        document.getElementById('file-upload').addEventListener('change', function(e) {
            const previewContainer = document.getElementById('file-preview');
            previewContainer.innerHTML = '';  // Clear existing preview
            const files = e.target.files;
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                
                // Display preview for image files
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const imgElement = document.createElement('img');
                        imgElement.src = event.target.result;
                        previewContainer.appendChild(imgElement);
                    };
                    reader.readAsDataURL(file);
                    $('#preview_div').hide();
                }
            }
        });

    </script>
    <script>
        var IMG_INDEX = 1;

        jQuery(document).ready(function() {
            $(document).ready(function() {
                jQuery(" #law_id , #case_type_id").select2();

            });
            $('.textarea').wysihtml5({});

            jQuery('#datesottogolpo').datepicker({
                dateFormat: 'yy/mm/dd'
            });
            $("#datesottogolpo").datepicker("setDate", new Date());
            $('#datesottogolpo').datepicker({
                autoclose: true
            });


            jQuery("#templatesottogolpo .delete").click(function(e) {
                e.preventDefault();
                return false;
            });

            //Callback handler for form submit event
            $("#mysottogolpoForm").submit(function(e) {
                var formObj = $(this);
                //var formURL = formObj.attr("action");
                var formURL = base_path + "/sottogolpo/create";
                var formData = new FormData(this);

                console.log(formData);

                $.ajax({
                    url: formURL,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {},
                    success: function(response, textStatus, jqXHR) {
                        // var jsonObject = JSON.parse(response);
                        if (response) {
                            if (response.flag == 'true') {

                                $('#successsottogolpo').modal('show');
                                $("#mysottogolpoForm")[0].reset();

                            } else {
                                $('#errorsottogolpo').modal('show');
                            }
                        }

                    },
                    error: function(jqXHR, textStatus, errorThrown) {}
                });
                e.preventDefault(); //Prevent Default action.
                // e.unbind();

                return false;

            });

        });

        function today() {
            var d = new Date();
            var curr_date = d.getDate();
            var curr_month = d.getMonth() + 1;
            var curr_year = d.getFullYear();
            document.write(curr_date + "-" + curr_month + "-" + curr_year);
        }
    </script>
    {{-- <script>
        jQuery(document).ready(function() {
            // Locate the preview template and remove it from the document, storing the HTML for reuse.
            var previewNode = document.querySelector("#templatesottogolpo");
            previewNode.id = ""; // Clear the ID to avoid duplicates
            var previewTemplate = previewNode.parentNode.innerHTML;
            previewNode.parentNode.removeChild(previewNode); // Remove template from the DOM

            var IMG_INDEX = 1; // Set initial index for uploaded images

            // Initialize Dropzone on the body element
            var myDropzone = new Dropzone("#templatesottogolpo", {
                url: base_path + "/sottogolpo/upload",
                thumbnailWidth: 80,
                thumbnailHeight: 80,
                maxFilesize: 1, // Set max file size to 1MB as per label
                acceptedFiles: "image/*,application/pdf,.doc,.docx",
                maxFiles: 2, // Limit number of files
                paramName: "file",
                uploadMultiple: true,
                previewTemplate: previewTemplate,
                autoQueue: false, // Manual upload control
                previewsContainer: "#previews", // Display preview in #previews
                clickable: ".fileinput-button", // Trigger file input on click
                init: function() {
                    this.on("maxfilesexceeded", function(file) {
                        this.removeFile(file); // Remove excess files
                        alert("No more files, please!");
                    });
                }
            });

            myDropzone.on("addedfile", function(file) {
                // Attach functionality to start, cancel, and delete buttons
                file.previewElement.querySelector(".start").onclick = function() {
                    myDropzone.enqueueFile(file);
                };
                file.previewElement.querySelector(".cancel").onclick = function() {
                    myDropzone.removeFile(file);
                };
                file.previewElement.querySelector(".delete").onclick = function() {
                    myDropzone.removeFile(file);
                };
            });

            myDropzone.on("error", function(file) {
                file.previewElement.querySelector(".start").style.display =
                    "none"; // Hide start button on error
            });

            myDropzone.on("success", function(file, responseText) {
                // Store response filename in input fields based on IMG_INDEX
                var msgInput = IMG_INDEX === 1 ? "#filename" : "#filenamebody";
                document.querySelector(msgInput).value = responseText.msgfilename;
                IMG_INDEX++;
            });

            // Update progress bar based on total upload progress
            myDropzone.on("totaluploadprogress", function(progress) {
                document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
            });

            myDropzone.on("sending", function(file, xhr, formData) {
                formData.append('nofile', IMG_INDEX);
                document.querySelector("#total-progress").style.opacity = "1";
                file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
            });

            myDropzone.on("queuecomplete", function() {
                document.querySelector("#total-progress").style.opacity =
                    "0"; // Hide progress bar after all uploads complete
            });

            // Setup start and cancel actions for the action buttons
            document.querySelector("#actions .start").onclick = function() {
                myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
            };
            document.querySelector("#actions .cancel").onclick = function() {
                myDropzone.removeAllFiles(true);
            };
        })
    </script> --}}
    <script>
        ClassicEditor.create(document.querySelector('#editorContent'))
            .catch(error => {
                console.error(error);
            });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
@endsection
