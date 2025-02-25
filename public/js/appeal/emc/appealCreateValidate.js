"use strict";

// Class definition
var KTProjectsAdd = (function () {
    // Base elements
    var _wizardEl;
    var _formEl;
    var _wizardObj;
    var fv;
    var _validations = [];

    // Private functions to form Wizard
    var _initWizard = function () {
        // Initialize form wizard
        _wizardObj = new KTWizard(_wizardEl, {
            startStep: 1, // initial active step number
            clickableSteps: false, // allow step clicking
        });

        // Validation before going to next page
        _wizardObj.on("change", function (wizard) {
            if (wizard.getStep() > wizard.getNewStep()) {
                return; // Skip if stepped back
            }

            // Validate form before change wizard step
            var validator = _validations[wizard.getStep() - 1]; // get validator for current step

            if (validator) {
                validator.validate().then(function (status) {
                    // console.log(status)
                    if (status == "Valid") {
                        // dynamic working to victim section (skip or set)
                        const typeID = document.getElementById("kt").value;
                        if (typeID == 1) {
                            wizard.goTo(wizard.getNewStep());
                        } else {
                            if (wizard.getStep() == 2) {
                                wizard.goTo(4);
                            } else {
                                wizard.goTo(wizard.getNewStep());
                            }
                        }
                        // when back, if victim not set, when skip victim
                        document
                            .getElementById("wizardBack")
                            .addEventListener("click", function () {
                                var wizardBack =
                                    $("#victim_wizard").attr("wizardVal");
                                if (wizard.getStep() == 3 && wizardBack != 2) {
                                    wizard.goTo(2);
                                }
                            });

                        KTUtil.scrollTop();
                    } else {
                        KTUtil.scrollTop();
                    }
                });
            }

            return false; // Do not change wizard step, further action will be handled by he validator
        });

        // Change event
        _wizardObj.on("changed", function (wizard) {
            KTUtil.scrollTop();
        });

        // Submit event
        _wizardObj.on("submit", function (wizard) {
            var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step
            if (validator) {
                validator.validate().then(function (status) {
                    if (status == "Valid") {
                        Swal.fire({
                            title: "আপনি কি সংরক্ষণ করতে চান?",
                            text: "আপনি ভুল তথ্য প্রদান করলে আপনার অভিযোগ বাতিল হতে পারে এবং আপনার বিরুদ্ধে আইনগত ব্যবস্থা নেয়া হতে পারে",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "হ্যাঁ",
                            cancelButtonText: "না",
                        }).then(function (result) {
                            if (result.value) {
                                // _formEl.submit(); // Submit form
                                // KTApp.blockPage({
                                //     // overlayColor: '#1bc5bd',
                                //     overlayColor: "black",
                                //     opacity: 0.2,
                                //     // size: 'sm',
                                //     message: "Please wait...",
                                //     state: "danger", // a bootstrap color
                                // });
                                // Swal.fire({
                                //     position: "top-right",
                                //     icon: "success",
                                //     title: "সফলভাবে সাবমিট করা হয়েছে!",
                                //     showConfirmButton: false,
                                //     timer: 1500,
                                // });

                                var val1 = [];
                                $(".nid_important").each(function () {
                                    val1.push($(this).val());
                                });

                                // swal.showLoading();
                                $.ajax({
                                    url: $("#citizen_appeal_check").val(),
                                    method: "post",
                                    data: {
                                        nids: val1,
                                        district: $("#district_id").val(),
                                        upazila: $("#upazila_id").val(),
                                        case_details: $("#case_details").val(),
                                        _token: $(
                                            'meta[name="csrf-token"]'
                                        ).attr("content"),
                                    },
                                    success: function (response) {
                                        if (response.status == "error") {
                                            Swal.fire(response.message);
                                            toastr.error(response.error);
                                            swal.fire({
                                                text: response.message,
                                            });
                                        } else {
                                            swal.close();
                                            _formEl.submit();
                                        }
                                    },
                                });
                            } else if (result.dismiss === "cancel") {
                                return;
                            }
                        });
                    }
                });
            }
            return false; // Do not submit, further action will be handled by he validator
        });
    };

    // form validation start
    var _initValidation = function () {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        // Step 1 start
        _validations.push(
            FormValidation.formValidation(_formEl, {
                fields: {
                    // Step 1
                    caseDate: {
                        validators: {
                            notEmpty: {
                                message: "This field is required",
                            },
                        },
                    },
                    lawSection: {
                        validators: {
                            notEmpty: {
                                message: "অভিযোগের ধরণ নির্বাচন করুন",
                            },
                            /* choice: {
                                message: "This field is required",
                            }, */
                        },
                    },
                    division: {
                        validators: {
                            notEmpty: {
                                message: "বিভাগ নির্বাচন করুন",
                            },
                        },
                    },
                    district: {
                        validators: {
                            notEmpty: {
                                message: "জেলা নির্বাচন করুন",
                            },
                        },
                    },
                    upazila: {
                        validators: {
                            notEmpty: {
                                message: "উপজেলা / থানা নির্বাচন করুন",
                            },
                        },
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        //eleInvalidClass: '',
                        eleValidClass: "",
                    }),
                    icon: new FormValidation.plugins.Icon({
                        valid: "fa fa-check",
                        invalid: "fa fa-times",
                        validating: "fa fa-refresh",
                    }),
                },
            })
        );
        // step 1 end

        // step 2 start
        _validations.push(
            FormValidation.formValidation(_formEl, {
                fields: {
                    "applicant[phn]": {
                        validators: {
                            notEmpty: {
                                message: "Phone is required",
                            },
                            regexp: {
                                // regexp: /^([3-9]\d{8})$/,
                                regexp: "(^(01){1}[3-9]{1}(\\d){8})$",
                                message: "The input is not valid Phone number",
                            },
                        },
                    },
                    "applicant[presentAddress]": {
                        validators: {
                            notEmpty: {
                                message:
                                    "applicant present address is required",
                            },
                        },
                    },
                    "applicant[email]": {
                        validators: {
                            emailAddress: {
                                message:
                                    "The value is not a valid email address",
                            },
                        },
                    },
                    "applicant[nid]": {
                        validators: {
                            notEmpty: {
                                message: "applicant NID is required",
                            },
                        },
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        //eleInvalidClass: '',
                        eleValidClass: "",
                    }),
                    icon: new FormValidation.plugins.Icon({
                        valid: "fa fa-check",
                        invalid: "fa fa-times",
                        validating: "fa fa-refresh",
                    }),
                },
            })
        );
        // step 2 end

        // victim section ========================= start ====================
        $("#victim #kt").change(function () {
            const typeID = document.getElementById("kt").value;
            if (typeID == 1) {
                $("#victim_wizard").show(); // show wizard step
                $("#victim_wizard").attr("wizardVal", 2); // show wizard step
            } else {
                $("#victim_wizard").hide(); // hide wizard step
                $("#victim_wizard").removeAttr("wizardVal");
            }

            var id = $("option:selected", "#kt").attr("law_section");

            if (parseInt(id) == 144 || parseInt(id) == 145) {
                $("#status").val("SEND_TO_ASST_DM");
            } else {
                $("#status").val("SEND_TO_ASST_EM");
            }
        });
        // victim section ========================= end ====================

        _validations.push(
            FormValidation.formValidation(_formEl, {
                fields: {
                    // "victim[phn]": {
                    //     validators: {
                    //         regexp: {
                    //             // regexp: /^(01[3-9]\d{8})$/,
                    //             // regexp: /^([3-9]\d{8})$/,
                    //             regexp: "(^(01){1}[3-9]{1}(\\d){8})$",
                    //             message: "The input is not valid Phone number",
                    //         },
                    //     },
                    // },
                    "victim[presentAddress]": {
                        validators: {
                            notEmpty: {
                                message: "ভিক্টিমের বর্তমান ঠিকানা দিতে হবে",
                            },
                        },
                    },
                    "victim[phn]": {
                        validators: {
                            // notEmpty: {
                            //     message: "ভিক্টিমের মোবাইল নং দিতে হবে",
                            // },
                            regexp: {
                                // regexp: /^([3-9]\d{8})$/,
                                regexp: "(^(01){1}[3-9]{1}(\\d){8})$",
                                message: "মোবাইল নং সঠিক নয়",
                            },
                        },
                    },
                    /*"victim[nid]": {
                        validators: {
                            notEmpty: {
                                message: "Victim NID is required",
                            },
                        },
                    },*/
                    "victim[email]": {
                        validators: {
                            emailAddress: {
                                message: "ইমেইল সঠিক নয়",
                            },
                        },
                    },
                    "victim[name]": {
                        validators: {
                            notEmpty: {
                                message: "ভিক্টিমের নাম দিতে হবে",
                            },
                        },
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        //eleInvalidClass: '',
                        eleValidClass: "",
                    }),
                    icon: new FormValidation.plugins.Icon({
                        valid: "fa fa-check",
                        invalid: "fa fa-times",
                        validating: "fa fa-refresh",
                    }),
                },
            })
        );

        // Step 3 start
        const defaulterPhoneValidators = {
            validators: {
                notEmpty: {
                    message: "২য় পক্ষের মোবাইল নং দিতে হবে",
                },
                regexp: {
                    // regexp: /^([3-9]\d{8})$/,
                    regexp: "(^(01){1}[3-9]{1}(\\d){8})$",
                    message: "মোবাইল নং সঠিক নয়",
                },
            },
        };
        const defaulterPresentAddressValidators = {
            validators: {
                notEmpty: {
                    message: "২য় পক্ষের বর্তমান ঠিকানা দিতে হবে",
                },
            },
        };
        const defaulterNameValidators = {
            validators: {
                notEmpty: {
                    message: "২য় পক্ষের নাম দিতে হবে",
                },
            },
        };
        const defaulterEmailValidators = {
            validators: {
                emailAddress: {
                    message: "ইমেইল সঠিক নয়",
                },
            },
        };
        const defaulterFatherValidators = {
            validators: {
                notEmpty: {
                    message: "২য় পক্ষের নাম দিতে হবে",
                },
            },
        };
        const defaultermotherValidators = {
            validators: {
                notEmpty: {
                    message: "২য় পক্ষের নাম দিতে হবে",
                },
            },
        };
        // const defaulterNIDValidators = {
        //     validators: {
        //         notEmpty: {
        //             message: "২য় পক্ষের জাতীয় পরিচয়পত্র নম্বর দিতে হবে",
        //         },
        //     },
        // };
        const fv1 = FormValidation.formValidation(_formEl, {
            fields: {
                "defaulter[phn][0]": defaulterPhoneValidators,
                "defaulter[presentAddress][0]":
                    defaulterPresentAddressValidators,
                //"defaulter[nid][0]": defaulterNIDValidators,
                "defaulter[email][0]": defaulterEmailValidators,
                "defaulter[name][0]": defaulterNameValidators,
                "defaulter[father][0]": defaulterFatherValidators,
                "defaulter[mother][0]": defaultermotherValidators,
            },
            plugins: {
                submitButton: new FormValidation.plugins.SubmitButton(),
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap({
                    //eleInvalidClass: '',
                    eleValidClass: "",
                }),
                icon: new FormValidation.plugins.Icon({
                    valid: "fa fa-check",
                    invalid: "fa fa-times",
                    validating: "fa fa-refresh",
                }),
            },
        });

        // remove template
        const removeDefaulterRow = function (rowIndex) {
            const defaultRow = document.getElementById("RemoveDefaulter").value;
            if (parseInt(defaultRow) >= 1 || rowIndex >= 1) {
                Swal.fire({
                    title: "আপনি কি মুছে ফেলতে চান?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "হ্যাঁ",
                    cancelButtonText: "না",
                }).then(function (result) {
                    if (result.value) {
                        const row = _formEl.querySelector(
                            '[data-row-index="' + rowIndex + '"]'
                        );
                        // Remove field
                        fv1.removeField(
                            "defaulter[phn][" + rowIndex + "]",
                            defaulterPhoneValidators
                        )
                            .removeField(
                                "defaulter[email][" + rowIndex + "]",
                                defaulterEmailValidators
                            )
                            .removeField(
                                "defaulter[presentAddress][" + rowIndex + "]",
                                defaulterPresentAddressValidators
                            )
                            .removeField(
                                "defaulter[name][" + rowIndex + "]",
                                defaulterNameValidators
                            )
                            .removeField(
                                "defaulter[father][" + rowIndex + "]",
                                defaulterFatherValidators
                            )
                            .removeField(
                                "defaulter[mother][" + rowIndex + "]",
                                defaultermotherValidators
                            );
                        // .removeField("defaulter[nid][" + rowIndex + "]", defaulterNIDValidators);

                        // Remove row
                        document.getElementById("defaulterAdd").value =
                            parseInt(parseInt(rowIndex) - 1);
                        document.getElementById("RemoveDefaulter").value =
                            parseInt(parseInt(rowIndex) - 1);
                        row.parentNode.removeChild(row);

                        Swal.fire({
                            position: "top-right",
                            icon: "success",
                            title: "সফলভাবে মুছে ফেলা হয়েছে!",
                            showConfirmButton: false,
                            timer: 1500,
                        });
                    }
                });
            } else {
                Swal.fire({
                    position: "top-right",
                    icon: "error",
                    title: "আবেদনকারীর তথ্য সর্বনিম্ম একটি থাকতে হবে",
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        };

        const defaulterTemplate = document.getElementById("defaulterTemplate");
        let defaulterRowIndex = 0;
        document
            .getElementById("defaulterAdd")
            .addEventListener("click", function () {
                defaulterRowIndex =
                    document.getElementById("defaulterAdd").value;
                defaulterRowIndex = parseInt(parseInt(defaulterRowIndex) + 1);

                const clone = defaulterTemplate.cloneNode(true);
                clone.removeAttribute("id");

                // Show the row
                clone.style.display = "block";
                clone.setAttribute("data-row-index", defaulterRowIndex);

                clone.querySelector(
                    '[data-name="defaulter.info"]'
                ).textContent =
                    "২য় পক্ষ (" + parseInt(defaulterRowIndex + 1) + ")";
                clone.removeAttribute("data-name");

                // Insert before the template
                defaulterTemplate.before(clone);

                clone
                    .querySelector('[data-name="defaulter.NIDNumber"]')
                    .setAttribute(
                        "data-row-index",
                        "" + defaulterRowIndex + ""
                    );
                clone
                    .querySelector('[data-name="defaulter.NIDNumber"]')
                    .setAttribute(
                        "id",
                        "defaulter_nid_input_" + defaulterRowIndex + ""
                    );

                clone
                    .querySelector('[data-name="defaulter.DOBNumber"]')
                    .setAttribute(
                        "data-row-index",
                        "" + defaulterRowIndex + ""
                    );
                clone
                    .querySelector('[data-name="defaulter.DOBNumber"]')
                    .setAttribute(
                        "id",
                        "defaulter_dob_input_" + defaulterRowIndex + ""
                    );

                clone
                    .querySelector('[data-name="defaulter.NIDCheckButton"]')
                    .setAttribute(
                        "data-row-index",
                        "" + defaulterRowIndex + ""
                    );
                clone
                    .querySelector('[data-name="defaulter.NIDCheckButton"]')
                    .setAttribute(
                        "id",
                        "defaulter_nid_" + defaulterRowIndex + ""
                    );

                var defaulterBuutonNIDCHECKID =
                    "defaulter_nid_" + defaulterRowIndex;
                clone
                    .querySelector('[data-name="defaulter.NIDCheckButton"]')
                    .setAttribute(
                        "onclick",
                        "NIDCHECK('" + defaulterBuutonNIDCHECKID + "')"
                    );

                clone
                    .querySelector('[data-name="defaulter.name"]')
                    .setAttribute(
                        "name",
                        "defaulter[name][" + defaulterRowIndex + "]"
                    );
                //clone.querySelector('[data-name="defaulter.name"]').setAttribute("onclick", "nid_data_pull_warning_function('" + defaulterRowIndex + "')")

                clone
                    .querySelector('[data-name="defaulter.type"]')
                    .setAttribute(
                        "name",
                        "defaulter[type][" + defaulterRowIndex + "]"
                    );
                clone
                    .querySelector('[data-name="defaulter.id"]')
                    .setAttribute(
                        "name",
                        "defaulter[id][" + defaulterRowIndex + "]"
                    );
                clone
                    .querySelector('[data-name="defaulter.thana"]')
                    .setAttribute(
                        "name",
                        "defaulter[thana][" + defaulterRowIndex + "]"
                    );
                clone
                    .querySelector('[data-name="defaulter.upazilla"]')
                    .setAttribute(
                        "name",
                        "defaulter[upazilla][" + defaulterRowIndex + "]"
                    );
                clone
                    .querySelector('[data-name="defaulter.age"]')
                    .setAttribute(
                        "name",
                        "defaulter[age][" + defaulterRowIndex + "]"
                    );
                clone
                    .querySelector('[data-name="defaulter.gender"]')
                    .setAttribute(
                        "name",
                        "defaulter[gender][" + defaulterRowIndex + "]"
                    );

                clone
                    .querySelector('[data-name="defaulter.father"]')
                    .setAttribute(
                        "name",
                        "defaulter[father][" + defaulterRowIndex + "]"
                    );
                // clone.querySelector('[data-name="defaulter.father"]').setAttribute("onclick", "nid_data_pull_warning_function('" + defaulterRowIndex + "')")

                clone
                    .querySelector('[data-name="defaulter.mother"]')
                    .setAttribute(
                        "name",
                        "defaulter[mother][" + defaulterRowIndex + "]"
                    );
                // clone.querySelector('[data-name="defaulter.mother"]').setAttribute("onclick", "nid_data_pull_warning_function('" + defaulterRowIndex + "')")

                clone
                    .querySelector('[data-name="defaulter.nid"]')
                    .setAttribute(
                        "name",
                        "defaulter[nid][" + defaulterRowIndex + "]"
                    );
                //clone.querySelector('[data-name="defaulter.nid"]').setAttribute("onclick", "nid_data_pull_warning_function('" + defaulterRowIndex + "')")

                clone
                    .querySelector('[data-name="defaulter.phn"]')
                    .setAttribute(
                        "name",
                        "defaulter[phn][" + defaulterRowIndex + "]"
                    );
                clone
                    .querySelector('[data-name="defaulter.presentAddress"]')
                    .setAttribute(
                        "name",
                        "defaulter[presentAddress][" + defaulterRowIndex + "]"
                    );
                //clone.querySelector('[data-name="defaulter.presentAddress"]').setAttribute("onclick", "nid_data_pull_warning_function('" + defaulterRowIndex + "')")

                clone
                    .querySelector('[data-name="defaulter.email"]')
                    .setAttribute(
                        "name",
                        "defaulter[email][" + defaulterRowIndex + "]"
                    );

                // Add new fields
                // Note that we also pass the validator rules for new field as the third parameter
                fv1.addField(
                    "defaulter[phn][" + defaulterRowIndex + "]",
                    defaulterPhoneValidators
                )
                    .addField(
                        "defaulter[presentAddress][" + defaulterRowIndex + "]",
                        defaulterPresentAddressValidators
                    )
                    .addField(
                        "defaulter[email][" + defaulterRowIndex + "]",
                        defaulterEmailValidators
                    )
                    .addField(
                        "defaulter[name][" + defaulterRowIndex + "]",
                        defaulterNameValidators
                    )
                    .addField(
                        "defaulter[father][" + defaulterRowIndex + "]",
                        defaulterFatherValidators
                    )
                    .addField(
                        "defaulter[mother][" + defaulterRowIndex + "]",
                        defaultermotherValidators
                    );
                //.addField("defaulter[nid][" + defaulterRowIndex + "]", defaulterNIDValidators);

                // Handle the click event of removeButton
                document.getElementById("defaulterAdd").value =
                    defaulterRowIndex;
                document.getElementById("RemoveDefaulter").value =
                    defaulterRowIndex;
                document.getElementById("RemoveDefaulter").onclick = function (
                    e
                ) {
                    // Get the row index
                    const index = e.target.value;
                    removeDefaulterRow(index);
                };
            });

        _validations.push(fv1);

        // step 3 end

        // step 4 start

        const witnessPresentAddressValidators = {
            validators: {
                notEmpty: {
                    message: "সাক্ষীর বর্তমান ঠিকানা দিতে হবে",
                },
            },
        };
        const witnessNIDValidators = {
            validators: {
                function(input) {
                    let value = input.value;
                    if (value == "") {
                        return { valid: true };
                    }
                    if (
                        value.length != 10 ||
                        value.length != 13 ||
                        value.length != 16 ||
                        value.length != 17
                    ) {
                        return {
                            valid: false,
                            message: "জাতীয় পরিচয়পত্র ১০,১৩ বা ১৭ সংখ্যার হবে",
                        };
                    }
                },
            },
        };
        const witnessPhoneValidators = {
            validators: {
                notEmpty: {
                    message: "সাক্ষীর মোবাইল নং দিতে হবে",
                },
                regexp: {
                    // regexp: /^([3-9]\d{8})$/,
                    regexp: "(^(01){1}[3456789]{1}(\\d){8})$",
                    message: "মোবাইল নং সঠিক নয়",
                },
            },
        };
        const witnessNameValidators = {
            validators: {
                notEmpty: {
                    message: "সাক্ষীর নাম দিতে হবে",
                },
            },
        };
        const witnessFatherValidators = {
            validators: {
                notEmpty: {
                    message: "সাক্ষীর পিতার নাম দিতে হবে",
                },
            },
        };
        const witnessmotherValidators = {
            validators: {
                notEmpty: {
                    message: "সাক্ষীর মাতার নাম দিতে হবে",
                },
            },
        };

        const fv2 = FormValidation.formValidation(_formEl, {
            fields: {
                "witness[phn][0]": witnessPhoneValidators,
                "witness[presentAddress][0]": witnessPresentAddressValidators,
                "witness[name][0]": witnessNameValidators,
                "witness[father][0]": witnessFatherValidators,
                "witness[mother][0]": witnessmotherValidators,
                "witness[nid][0]": witnessNIDValidators,
            },
            plugins: {
                submitButton: new FormValidation.plugins.SubmitButton(),
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap({
                    //eleInvalidClass: '',
                    eleValidClass: "",
                }),
                icon: new FormValidation.plugins.Icon({
                    valid: "fa fa-check",
                    invalid: "fa fa-times",
                    validating: "fa fa-refresh",
                }),
            },
        });

        // remove template
        const removeWitnessRow = function (rownewIndex) {
            const witnessRow = document.getElementById("witnessRemove").value;
            if (parseInt(witnessRow) >= 1 || rownewIndex >= 1) {
                Swal.fire({
                    title: "আপনি কি মুছে ফেলতে চান?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "হ্যাঁ",
                    cancelButtonText: "না",
                }).then(function (result) {
                    if (result.value) {
                        const rownew = _formEl.querySelector(
                            '[data-row-withnessindex="' + rownewIndex + '"]'
                        );
                        // Remove field
                        fv2.removeField(
                            "witness[phn][" + rownewIndex + "]",
                            witnessPhoneValidators
                        )
                            .removeField(
                                "witness[presentAddress][" + rownewIndex + "]",
                                witnessPresentAddressValidators
                            )
                            .removeField(
                                "witness[name][" + rownewIndex + "]",
                                witnessNameValidators
                            )
                            .removeField(
                                "witness[father][" + rownewIndex + "]",
                                witnessFatherValidators
                            )
                            .removeField(
                                "witness[mother][" + rownewIndex + "]",
                                witnessmotherValidators
                            )
                            .removeField(
                                "witness[nid][" + rownewIndex + "]",
                                witnessNIDValidators
                            );

                        // Remove row
                        document.getElementById("witnessAdd").value = parseInt(
                            parseInt(rownewIndex) - 1
                        );
                        document.getElementById("witnessRemove").value =
                            parseInt(parseInt(rownewIndex) - 1);
                        rownew.parentNode.removeChild(rownew);

                        Swal.fire({
                            position: "top-right",
                            icon: "success",
                            title: "সফলভাবে মুছে ফেলা হয়েছে!",
                            showConfirmButton: false,
                            timer: 1500,
                        });
                    }
                });
            } else {
                Swal.fire({
                    position: "top-right",
                    icon: "error",
                    title: "আবেদনকারীর তথ্য সর্বনিম্ম একটি থাকতে হবে",
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        };

        const witnessTemplate = document.getElementById("witnessTemplate");
        let witnessRowIndex = 0;
        document
            .getElementById("witnessAdd")
            .addEventListener("click", function () {
                witnessRowIndex = document.getElementById("witnessAdd").value;
                witnessRowIndex = parseInt(parseInt(witnessRowIndex) + 1);

                const clone = witnessTemplate.cloneNode(true);
                clone.removeAttribute("id");

                // Show the row
                clone.style.display = "block";
                clone.setAttribute("data-row-withnessindex", witnessRowIndex);

                clone.querySelector('[data-name="witness.info"]').textContent =
                    "সাক্ষীর তথ্য (" + parseInt(witnessRowIndex + 1) + ")";
                clone.removeAttribute("data-name");

                // Insert before the template
                witnessTemplate.before(clone);

                clone
                    .querySelector('[data-name="witness.NIDNumber"]')
                    .setAttribute(
                        "data-rownew-index",
                        "" + witnessRowIndex + ""
                    );
                clone
                    .querySelector('[data-name="witness.NIDNumber"]')
                    .setAttribute(
                        "id",
                        "witness_nid_input_" + witnessRowIndex + ""
                    );

                clone
                    .querySelector('[data-name="witness.DOBNumber"]')
                    .setAttribute(
                        "data-rownew-index",
                        "" + witnessRowIndex + ""
                    );
                clone
                    .querySelector('[data-name="witness.DOBNumber"]')
                    .setAttribute(
                        "id",
                        "witness_dob_input_" + witnessRowIndex + ""
                    );

                clone
                    .querySelector('[data-name="witness.NIDCheckButton"]')
                    .setAttribute(
                        "data-rownew-index",
                        "" + witnessRowIndex + ""
                    );
                clone
                    .querySelector('[data-name="witness.NIDCheckButton"]')
                    .setAttribute("id", "witness_nid_" + witnessRowIndex + "");

                var defaulterBuutonNIDCHECKID =
                    "witness_nid_" + witnessRowIndex;
                clone
                    .querySelector('[data-name="witness.NIDCheckButton"]')
                    .setAttribute(
                        "onclick",
                        "NIDCHECKwitness('" + defaulterBuutonNIDCHECKID + "')"
                    );

                clone
                    .querySelector('[data-name="witness.name"]')
                    .setAttribute(
                        "name",
                        "witness[name][" + witnessRowIndex + "]"
                    );

                clone
                    .querySelector('[data-name="witness.type"]')
                    .setAttribute(
                        "name",
                        "witness[type][" + witnessRowIndex + "]"
                    );
                clone
                    .querySelector('[data-name="witness.id"]')
                    .setAttribute(
                        "name",
                        "witness[id][" + witnessRowIndex + "]"
                    );
                clone
                    .querySelector('[data-name="witness.thana"]')
                    .setAttribute(
                        "name",
                        "witness[thana][" + witnessRowIndex + "]"
                    );
                clone
                    .querySelector('[data-name="witness.upazilla"]')
                    .setAttribute(
                        "name",
                        "witness[upazilla][" + witnessRowIndex + "]"
                    );
                clone
                    .querySelector('[data-name="witness.designation"]')
                    .setAttribute(
                        "name",
                        "witness[designation][" + witnessRowIndex + "]"
                    );
                clone
                    .querySelector('[data-name="witness.organization"]')
                    .setAttribute(
                        "name",
                        "witness[organization][" + witnessRowIndex + "]"
                    );
                clone
                    .querySelector('[data-name="witness.gender"]')
                    .setAttribute(
                        "name",
                        "witness[gender][" + witnessRowIndex + "]"
                    );

                clone
                    .querySelector('[data-name="witness.father"]')
                    .setAttribute(
                        "name",
                        "witness[father][" + witnessRowIndex + "]"
                    );

                clone
                    .querySelector('[data-name="witness.mother"]')
                    .setAttribute(
                        "name",
                        "witness[mother][" + witnessRowIndex + "]"
                    );

                clone
                    .querySelector('[data-name="witness.phn"]')
                    .setAttribute(
                        "name",
                        "witness[phn][" + witnessRowIndex + "]"
                    );

                clone
                    .querySelector('[data-name="witness.presentAddress"]')
                    .setAttribute(
                        "name",
                        "witness[presentAddress][" + witnessRowIndex + "]"
                    );

                clone
                    .querySelector('[data-name="witness.nid"]')
                    .setAttribute(
                        "name",
                        "witness[nid][" + witnessRowIndex + "]"
                    );

                // Add new fields
                // Note that we also pass the validator rules for new field as the third parameter
                fv2.addField(
                    "witness[phn][" + witnessRowIndex + "]",
                    witnessPhoneValidators
                )
                    .addField(
                        "witness[presentAddress][" + witnessRowIndex + "]",
                        witnessPresentAddressValidators
                    )
                    .addField(
                        "witness[name][" + witnessRowIndex + "]",
                        witnessNameValidators
                    )
                    .addField(
                        "witness[father][" + witnessRowIndex + "]",
                        witnessFatherValidators
                    )
                    .addField(
                        "witness[mother][" + witnessRowIndex + "]",
                        witnessmotherValidators
                    )
                    .addField(
                        "witness[nid][" + witnessRowIndex + "]",
                        witnessNIDValidators
                    );

                // Handle the click event of removeButton
                document.getElementById("witnessAdd").value = witnessRowIndex;
                document.getElementById("witnessRemove").value =
                    witnessRowIndex;
                document.getElementById("witnessRemove").onclick = function (
                    e
                ) {
                    // Get the row index
                    const index = e.target.value;
                    removeWitnessRow(index);
                };
            });

        _validations.push(fv2);
        // step 4 end

        // step 5 start
        _validations.push(
            FormValidation.formValidation(_formEl, {
                fields: {
                    "lawyer[phn]": {
                        validators: {
                            notEmpty: {
                                message: "আইনজীবীর মোবাইল নং দিতে হবে",
                            },
                            regexp: {
                                // regexp: /^([3-9]\d{8})$/,w
                                regexp: "(^(01){1}[3456789]{1}(\\d){8})$",
                                message: "মোবাইল নং সঠিক নয়",
                            },
                        },
                    },
                    "lawyer[email]": {
                        validators: {
                            emailAddress: {
                                message: "ইমেইল সঠিক নয়",
                            },
                        },
                    },
                    "lawyer[nid]": {
                        validators: {
                            notEmpty: {
                                message:
                                    "আইনজীবীর জাতীয় পরিচয়পত্র নম্বর দিতে হবে",
                            },
                        },
                    },
                    "lawyer[father]": {
                        validators: {
                            notEmpty: {
                                message: "আইনজীবীর পিতার নাম দিতে হবে",
                            },
                        },
                    },
                    "lawyer[mother]": {
                        validators: {
                            notEmpty: {
                                message: "আইনজীবীর মাতার নাম দিতে হবে",
                            },
                        },
                    },
                    "lawyer[name]": {
                        validators: {
                            notEmpty: {
                                message: "আইনজীবীর  নাম দিতে হবে",
                            },
                        },
                    },
                    "lawyer[presentAddress]": {
                        validators: {
                            notEmpty: {
                                message: "আইনজীবীর ঠিকানা দিতে হবে",
                            },
                        },
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        //eleInvalidClass: '',
                        eleValidClass: "",
                    }),
                    icon: new FormValidation.plugins.Icon({
                        valid: "fa fa-check",
                        invalid: "fa fa-times",
                        validating: "fa fa-refresh",
                    }),
                },
            })
        );
        // step 5 end
    };

    return {
        // public functions
        init: function () {
            _wizardEl = KTUtil.getById("appealWizard");
            _formEl = KTUtil.getById("appealCase");

            _initWizard();
            _initValidation();
        },
    };
})();

jQuery(document).ready(function () {
    KTProjectsAdd.init();
});