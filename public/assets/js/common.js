$(document).ready(function () {
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    var baseUrl = window.location.origin;
    var assets = window.location.origin + "/assets/";
    var reader = new FileReader();
    var img = new Image();
    function loadJobs(records, page, count) {
        $("#jobCount").html(count + " Jobs Found");
        $("#jobResults").append(records);
    }

    // $(".jslogincheck").on("click", function () {
    //     swal({
    //         title: "Please Login",
    //         text: "Click ok to Login",
    //         icon: "warning",
    //     }).then(function () {
    //         window.location = baseUrl + "/login-jobseeker";
    //     });
    // });
    $(document).on('click', '.jslogincheck', function() {
        swal({
            title: "Please Login",
            text: "Click ok to Login",
            icon: "warning",
        }).then(function () {
            window.location = baseUrl + "/login-jobseeker";
        });
    })
    // Company Name keyup
    $("#emp_com_name").keyup(function () {
        var name = $(this).val();
        $(".com_name_keyup").html(name);
    });

    // select dropwdonw limit

    // $("#job_lang").change(function (event) {
    //     // $("#job_lang").prop("disabled", false);
    //     var selectedOptions = $("#job_lang option:selected");

    //     if (selectedOptions.length > 2) {
    //         $(this).val($(this).data("pre")).change();
    //         alert("You can only select up to three options.");
    //         // $("#job_lang").prop("disabled", true);
    //         event.preventDefault();
    //     } else {
    //         event.preventDefault();
    //         $(this).data("pre", $(this).val());
    //     }
    // });
    // image Preview
    $(".image").on("change", function () {
        $("#img_size_error").hide();
        var logo = this.files[0];
        var size = logo.size / 1024;
        if (logo) {
            reader.onload = function (e) {
                img.src = e.target.result;
                img.onload = function () {
                    var width = img.width;
                    var height = img.height;

                    if (width < 199 && height < 199) {
                        $("#img_size_error").show();
                        $("#ProfileSubmit").prop("disabled", true);
                        return;
                    } else {
                        $("#ProfileSubmit").prop("disabled", false);
                    }
                    if (size > 3072) {
                        $("#img_size_error").show();
                        $("#ProfileSubmit").prop("disabled", true);
                        return;
                    } else {
                        $("#ProfileSubmit").prop("disabled", false);
                    }
                };
                e.preventDefault();
                $(".imagePreview").attr("src", e.target.result);
            };
            reader.readAsDataURL(logo);
        }
    });
    $("#emp_profile_edit").on("click", function (event) {
        event.preventDefault();
        $(this).hide();
        $("input")
            .removeClass("form-control-plaintext")
            .addClass("form-control")
            .removeAttr("readonly");

        $("#emp_profile_view").show();
        $(".textveiw").hide();
        $(".slec")
            .removeClass("d-none")
            .addClass("d-block")
            .removeAttr("disabled");
        $("#ProfileSubmit").removeClass("d-none").addClass("d-block");
        $(".submitButton").removeClass("d-none").addClass("d-block");
        $("#emp_profile_view").show();
    });
    $("#emp_profile_view").on("click", function (event) {
        event.preventDefault();
        $(this).hide();
        $("input")
            .removeClass("form-control")
            .addClass("form-control-plaintext")
            .prop("readonly", "true");
        $("#emp_profile_edit").show();
        $(".textveiw").show();
        $(".slec").addClass("d-none").removeClass("d-block");
        $("#ProfileSubmit").addClass("d-none").removeClass("d-block");
        $(".submitButton").addClass("d-none").removeClass("d-block");
    });
    $("#cat").on("change", function (event) {
        event.preventDefault();

        $("#cat_error").hide();
    });

    $("#submitcontact").on("click", function (event) {
        event.preventDefault();

        $("#cat_error").hide();
        $("#name_error").hide();
        $("#email_error").hide();
        $("#email_ptrn_error").hide();
        $("#code_contact_no_error").hide();
        $("#contact_no_error").hide();
        $("#message_error").hide();

        var cat = $("#cat").val();
        var name = $("#name").val();
        var email = $("#email").val();
        var message = $("#message").val();
        var contry_contact_no = $("#contry_contact_no").val();
        var contact_no = $("#contact_no").val();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (cat.trim() === "") {
            $("#cat_error").show();
            return;
        }
        if (name.trim() === "") {
            $("#name_error").show();
            return;
        }
        if (email.trim() === "") {
            $("#email_error").show();
            return;
        }
        if (!emailRegex.test(email)) {
            $("#email_ptrn_error").show();
            return;
        }
        if (contry_contact_no === "") {
            $("#code_contact_no_error").show();
            return;
        }
        if (contact_no.trim() === "") {
            $("#contact_no_error").show();
            return;
        }
        if (message.trim() === "") {
            $("#message_error").show();
            return;
        }

        $("#loader").fadeIn();
        var form = $("#contactForm").serialize();
        // var form = new FormData($("#contactform")[0]);
        $.ajax({
            url: baseUrl + "/mailEnqiry",
            type: "post",
            data: form,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (response) {
                $("#loader").fadeOut();
                if (response.code === 200) {
                    $("#contactForm")[0].reset();
                    swal({
                        title: "Successfully Send",
                        text: "We will Contact you Soon!!!",
                        icon: "success",
                    });
                } else {
                    swal({
                        title: "Something Went Wrong",
                        text: "Pleas Try Again",
                        icon: "error",
                    });
                }
            },
            error: function (xhr) {
                // Handle the error response
                console.log(xhr.responseText);
            },
        });
    });
    // Registration form Employer
    $("#regSubmit").click(function (event) {
        event.preventDefault();
        $("#bk_com_name_error").hide();
        $("#bk_fname_error").hide();
        $("#bk_email_error").hide();
        $("#bk_email_ptrn_error").hide();
        $("#contact_no_error").hide();
        $("#password_error").hide();
        $("#c_password_error").hide();
        $("#cpassord_error").hide();
        $("#tnc_error").hide();

        var com_name = $("#com_name").val();
        var fullname = $("#fullname").val();
        var bk_email = $("#email_signup").val();
        var contact_no = $("#contact_no_signup").val();
        var password = $("#emp_password").val();
        var c_password = $("#c_password").val();
        var checkbox = $("#tnc");
        // var mob_code = $("#mob_code").val();
        var passwordRegex =
            /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{8,}$/;
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (com_name === "") {
            $("#bk_com_name_error").show();
            return;
        }
        if (fullname === "") {
            $("#bk_fname_error").show();
            return;
        }
        if (bk_email === "") {
            $("#bk_email_error").show();
            return;
        }
        if (!emailRegex.test(bk_email)) {
            $("#bk_email_ptrn_error").show();
            return;
        }
        if (contact_no === "") {
            $("#contact_no_error").show();
            return;
        }
        if (contact_no.length < 8) {
            $("#contact_no_error").show();
            return;
        }
        if (contact_no.length > 8) {
            $("#contact_no_error").show();
            return;
        }
        if (password.trim() === "") {
            $("#password_error").show();
            return;
        }
        if (!passwordRegex.test(password)) {
            $("#password_error").show();
            return;
        }
        if (c_password.trim() === "") {
            $("#c_password_error").show();
            return;
        }
        if (password != c_password) {
            $("#cpassord_error").show();
            return;
        }
        if (!checkbox.is(":checked")) {
            $("#tnc_error").show();
            return;
        }
        var form = $("#regFrom").serialize();
        // var form = new FormData($("#regFrom")[0]);
        if (
            com_name != "" &&
            fullname != "" &&
            bk_email != "" &&
            contact_no != "" &&
            password != "" &&
            com_name != "" &&
            com_name != "" &&
            checkbox.is(":checked")
        ) {
            $("#loader").fadeIn();
            $.ajax({
                url: baseUrl + "/employer-Signup",
                type: "POST",
                data: form,
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                success: function (response) {
                    $("#loader").fadeOut();

                    if (response.code == 200) {
                        $("#regFrom")[0].reset();
                        swal({
                            title: response.message,
                            text: "Please Login",
                            icon: "success",
                        }).then(function () {
                            window.location.href = baseUrl + "/login-employer";
                        });
                    } else {
                        swal({
                            title: response.message,
                            text: "Please Try Again",
                            icon: "error",
                        });
                    }
                },
                // error: function (xhr) {
                //     // Handle the error response
                //     console.log(xhr.responseText);
                //     alert("An error occurred while inserting data.");
                // },
            });
        } else {
            alert("Mandatory Field Missing !!!");
        }
    });
    $("#email_signup").on("focusout", function (e) {
        e.preventDefault();
        $("#bk_email_error").hide();
        $("#bk_email_ptrn_error").hide();
        $("#email_exists_error").hide();
        var email = $(this).val();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === "") {
            $("#bk_email_error").show();
            return;
        }
        if (!emailRegex.test(email)) {
            $("#bk_email_ptrn_error").show();
            return;
        }
        if (email != "") {
            $("#loader").show();
            $.ajax({
                url: baseUrl + "/emp-mail-exist/" + email,
                type: "GET",
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                success: function (response) {
                    $("#loader").hide();
                    if (response.count > 0) {
                        $("#email_exists_error").show();
                        $("#regSubmit").attr("disabled", "true");
                        $("#email_signup").css("border-color", "red");
                        $("#email_signup").attr("value", "");
                    } else {
                        $("#regSubmit").removeAttr("disabled");
                        $("#email_signup").css("border-color", "green");
                        // $("#email_signup").attr("value", psno);
                    }
                },
            });
        }
    });
    $("#js_email").on("focusout", function (e) {
        e.preventDefault();
        $("#js_email_error").hide();
        $("#js_email_ptrn_error").hide();
        $("#email_exists_error").hide();
        var email = $(this).val();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === "") {
            $("#js_email_error").show();
            return;
        }
        if (!emailRegex.test(email)) {
            $("#js_email_ptrn_error").show();
            return;
        }
        if (email != "") {
            $("#loader").show();
            $.ajax({
                url: baseUrl + "/js-mail-exist/" + email,
                type: "GET",
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                success: function (response) {
                    $("#loader").hide();
                    if (response.count > 0) {
                        $("#email_exists_error").show();
                        $("#login_js").attr("disabled", "true");
                        $("#js_email").css("border-color", "red");
                        $("#js_email").attr("value", "");
                    } else {
                        $("#login_js").removeAttr("disabled");
                        $("#js_email").css("border-color", "green");
                        $("#js_email").attr("value", psno);
                    }
                },
            });
        }
    });
    $("#contact_no_signup").on("focusout", function (e) {
        e.preventDefault();

        $("#contact_no_error").hide();
        $("#mob_code_error").hide();
        $("#mob_exists_error").hide();
        var contact_no = $(this).val();
        var mob_code = $("#mob_code_signup").val();
        if (mob_code === "") {
            $("#mob_code_error").show();
            return;
        }
        // if (contact_no.length <= 8 && contact_no.length >= 8) {
        //     $("#contact_no_error").show();
        //     return;
        // }
        if (contact_no === "") {
            $("#contact_no_error").show();
            return;
        }
        if (contact_no.length < 8) {
            $("#contact_no_error").show();
            return;
        }
        if (contact_no.length > 8) {
            $("#contact_no_error").show();
            return;
        }

        if (contact_no != "") {
            $("#loader").show();
            $.ajax({
                url: baseUrl + "/emp-mobile-exist",
                type: "POST",
                data: { mob_code: mob_code, contact_no: contact_no },
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                success: function (response) {
                    $("#loader").hide();
                    if (response.count > 0) {
                        $("#mob_exists_error").show();
                        $("#regSubmit").attr("disabled", "true");
                        $(this).css("border-color", "red");
                        $(this).attr("value", "");
                    } else {
                        $("#regSubmit").removeAttr("disabled");
                        $(this).css("border-color", "green");
                        // $(this).attr("value", psno);
                    }
                },
            });
        }
    });
    $("#js_contact_no").on("focusout", function (e) {
        e.preventDefault();

        $("#js_contact_no_error").hide();
        $("#mob_code_error").hide();
        $("#mob_exists_error").hide();
        var contact_no = $(this).val();
        var mob_code = $("#mob_code").val();
        if (mob_code === "") {
            $("#mob_code_error").show();
            return;
        }
        if (contact_no === "") {
            $("#js_contact_no_error").show();
            return;
        }

        if (contact_no != "") {
            $("#loader").show();
            $.ajax({
                url: baseUrl + "/js-mobile-exist",
                type: "POST",
                data: { mob_code: mob_code, contact_no: contact_no },
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                success: function (response) {
                    $("#loader").hide();
                    if (response.count > 0) {
                        $("#mob_exists_error").show();
                        $("#login_js").attr("disabled", "true");
                        $(this).css("border-color", "red");
                        $(this).attr("value", "");
                    } else {
                        $("#login_js").removeAttr("disabled");
                        $(this).css("border-color", "green");
                        $(this).attr("value", psno);
                    }
                },
            });
        }
    });
    // Employer Login
    $("#login").click(function (e) {
        e.preventDefault();
        $("#login_user_error").hide();
        $("#login_pass_error").hide();
        var username = $("#username").val();
        var password = $("#password").val();
        var form = $("#LoginForm")[0];
        // var formData = new FormData(form);
        var form = $("#LoginForm").serialize();
        if (username.trim() === "") {
            $("#login_user_error").show();
            return;
        }
        if (password.trim() === "") {
            $("#login_pass_error").show();
            return;
        }
        $("#loader").fadeIn();
        $.ajax({
            url: baseUrl + "/employer-Login",
            type: "POST",
            data: form,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (response) {
                $("#LoginForm")[0].reset();
                $("#login_email_error").hide();
                $("#login_password_error").hide();
                $("#loader").fadeOut();
                if (response.code == 200) {
                    window.location.href =
                        baseUrl + "/employer/emp-browse-jobseeker";
                } else {
                    swal({
                        title: response.message,
                        text: "Invalid Credentials",
                        icon: "error",
                    });
                }
            },
            error: function (xhr) {
                // Handle the error response
                console.log(xhr.responseText);
                // alert('An error occurred while inserting data.');
            },
        });
    });

    // Jobseeker Signup
    $("#jsregSubmit").click(function (event) {
        event.preventDefault();
        $("#js_fname_error").hide();
        $("#js_contact_no_error").hide();
        $("#js_email_error").hide();
        $("#js_tnc_error").hide();
        $("#password_error").hide();
        $("#js_email_ptrn_error").hide();
        $("#js_password_error").hide();
        $("#js_c_password_error").hide();
        $("#js_cpassord_error").hide();
        $("#mob_code_error").hide();

        var bk_fname = $("#js_name").val();
        var bk_email = $("#js_email").val();
        var mob_code = $("#mob_code").val();
        var contact_no = $("#js_contact_no").val();
        var password = $("#reg_js_password").val();
        var c_password = $("#reg_js_c_password").val();
        var passwordRegex =
            /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%^&*])[A-Za-z0-9!@#$%^&*]{8,}$/;
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        // var js_tnc = $("#js_tnc").is(":checked");
        if (bk_fname === "") {
            $("#js_fname_error").show();
            return;
        }
        if (bk_email === "") {
            $("#js_email_error").show();
            return;
        }
        if (!emailRegex.test(bk_email)) {
            $("#js_email_ptrn_error").show();
            return;
        }
        if (mob_code === "") {
            $("#mob_code_error").show();
            return;
        }
        if (contact_no === "") {
            $("#js_contact_no_error").show();
            return;
        }
        if (password.trim() === "") {
            $("#js_password_error").show();
            return;
        }
        if (!passwordRegex.test(password)) {
            $("#js_password_error").show();
            return;
        }
        if (c_password.trim() === "") {
            $("#js_c_password_error").show();
            return;
        }
        if (password != c_password) {
            $("#js_cpassord_error").show();
            return;
        }

        if (!$("#js_tnc").is(":checked")) {
            $("#js_tnc_error").show();
            return;
        }
        var form = $("#js_regFrom").serialize();
        // var form = new FormData($("#regFrom")[0]);

        $("#loader").fadeIn();
        $.ajax({
            url: baseUrl + "/jobseeker-Signup",
            type: "POST",
            data: form,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (response) {
                $("#loader").fadeOut();

                if (response.code == 200) {
                    $("#js_regFrom")[0].reset();
                    swal({
                        title: response.message,
                        text: "",
                        icon: "success",
                    }).then(function () {
                        window.location.href =
                            baseUrl + "/jobseeker/jobseeker-profile";
                    });
                } else {
                    swal({
                        title: response.message,
                        text: "Please Try Again",
                        icon: "error",
                    });
                }
            },
        });
    });

    // Jobseeker  Login
    $("#login_js").click(function (e) {
        e.preventDefault();
        $("#js_login_user_error").hide();
        $("#js_login_pass_error").hide();
        var username = $("#js_username").val();
        var password = $("#js_password").val();
        // var formData = new FormData(form);
        var form = $("#js_LoginForm").serialize();
        if (username.trim() === "") {
            $("#js_login_user_error").show();
            return;
        }
        if (password.trim() === "") {
            $("#js_login_pass_error").show();
            return;
        }

        $.ajax({
            url: baseUrl + "/jobseeker-login",
            type: "POST",
            data: form,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (res) {
                $("#js_LoginForm")[0].reset();
                $("#js_login_user_error").hide();
                $("#js_login_pass_error").hide();
                if (res.code == 200) {
                    // swal({
                    //     title: "Successfully Login!",
                    //     icon: "success",
                    // });
                    window.location.href =
                        baseUrl + "/jobseeker/jobseeker-profile";
                } else {
                    swal({
                        title: "Invalid Credentials !!!",
                        text: "Pleas Try Again",
                        icon: "error",
                    });
                }
            },
            error: function (xhr) {
                // Handle the error response
                console.log(xhr.responseText);
                // alert('An error occurred while inserting data.');
            },
        });
    });
    // $("#search").on("click", function (e) {
    $(document).on("click", "#search", function (e) {
        e.preventDefault();
        $("#loader").fadeIn();
        var form = $("#searchFilter").serialize();
        $("#jobResults li").slideUp();
        $.ajax({
            url: "top-search-bar",
            type: "GET",
            dataType: "json",
            data: form,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (res) {
                $("#loader").fadeOut();
                $("#jobCount").html(res.count + " Jobs Found");
                var records = res.records;

                console.log(records);
                var page = res.page;
                var length = res.length;
                // window.location.href = 'browse-all-jobs';
                // return loadJobs(records, page, length);
            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error(error);
                $("#result").html("An error occurred.");
            },
        });
    });
    $(".list_filt").keyup(function (e) {
        e.preventDefault();
        var keyup_val = $(this).val();
        var listno = $(this).data("list");
        var classfil = $(this).data("classfil");
        $("#" + classfil).empty();
        $.ajax({
            url: baseUrl + "/filter_list",
            type: "POST",
            dataType: "json",
            data: { keyup_val: keyup_val, list: listno },
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (res) {
                if (res.html != "") {
                    $("#" + classfil).append(res.html);
                } else {
                    $("#" + classfil).html("No Records Found.");
                }
            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error(error);
                $("." + classfil).html("No Records Found.");
            },
        });
    });

    // Filter Search List (View More Details)
    // $(".left_filters").on("change", function (e) {
    $(".left_filters").on(
        "change",
        "input[type='checkbox'], input[type='radio']",
        function (e) {
            e.preventDefault();
            $("#loader").fadeIn();
            var form = $(".left_filters").serialize();
            $("#jobResults li").slideUp();
            $.ajax({
                url: "top-search-bar",
                type: "GET",
                dataType: "json",
                data: form,
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                success: function (res) {
                    $("#loader").fadeOut();

                    var records = res.html;
                    var page = res.page;
                    var count = res.count;

                    loadJobs(records, page, count);
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error(error);
                    $("#result").html("An error occurred.");
                },
            });
        }
    );

    // Newsletter Mail Subcrib
    $(".newsletterSend").on("click", function (e) {
        e.preventDefault();

        $("#newmail_error").hide();

        var newsemail = $(".newsemail").val();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (newsemail.trim() === "") {
            $(".newmail_error").show();
            return;
        }

        if (newsemail.trim() != "") {
            $("#loader").fadeIn();
            var form = $(".newsLetter").serialize();
            $.ajax({
                url: baseUrl + "/newLetter",
                type: "POST",
                dataType: "json",
                data: form,
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                success: function (res) {
                    $("#loader").fadeOut();
                    if (res.code == 200) {
                        $(".newsemail").empty();
                        // console.log(res.message);
                        swal({
                            title: res.message,
                            text: "We will Send you our Newsletters Update.",
                            icon: "success",
                        });
                    } else {
                        swal({
                            title: res.message,
                            text: "Please Try Again !!!",
                            icon: "error",
                        });
                    }
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error(error);
                    $("#result").html("An error occurred.");
                },
            });
        } else {
            $(".newmail_error").show();
            return;
        }
    });

    // Newsletter Mail Subcrib
    $("#newsletterSend").on("click", function (e) {
        e.preventDefault();

        $("#newmail_error").hide();

        var newsemail = $(".newsemail").val();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (newsemail.trim() === "") {
            $(".newmail_error").show();
            return;
        }

        if (newsemail.trim() != "") {
            $("#loader").fadeIn();
            var form = $(".newsLetter").serialize();
            $.ajax({
                url: baseUrl + "/newLetter",
                type: "POST",
                dataType: "json",
                data: form,
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                success: function (res) {
                    $("#loader").fadeOut();
                    if (res.code == 200) {
                        $(".newsemail").val("");
                        // console.log(res.message);
                        swal({
                            title: res.message,
                            text: "We will Send you our Newsletters Update.",
                            icon: "success",
                        });
                    } else {
                        swal({
                            title: res.message,
                            text: "Please Try Again with Valid Email !!!",
                            icon: "error",
                        });
                    }
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error(error);
                    $("#result").html("An error occurred.");
                },
            });
        } else {
            $(".newmail_error").show();
            return;
        }
    });

    // Pagination
    $(".paginations .next .pre").on("click", function () {
        $("#loader").fadeIn();
        var page_no =
            $("#selected_page").val() === ""
                ? $(this).data("page_no")
                : $("#selected_page").val();
        $.ajax({
            url: "top-search-bar",
            type: "GET",
            dataType: "json",
            data: { page: page_no },
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (res) {
                $("#loader").fadeOut();
                $("#selected_page").val(page_no);

                $("#jobResults li").empty();
                $(document).scrollTop(0);
                var records = res.html;
                var page = res.page;
                var count = res.count;

                loadJobs(records, page, count);
            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error(error);
                $("#result").html("An error occurred.");
            },
        });
    });

    // Profile Pic Upload
    $(".profilePic").on("change", function () {
        $("#loader").fadeIn();
        var form = new FormData($(".proflilImage")[0]);
        // var old_img = $(".curr_img").val();
        $.ajax({
            url: "add-profile-image",
            type: "POST",
            dataType: "json",
            data: form,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (response) {
                $("#loader").fadeOut();
                if (response.code == 200) {
                    $(".curr_img").prop("value", response.new);
                    swal({
                        title: response.message,
                        text: response.text,
                        icon: "success",
                    });
                } else {
                    $(".imagePreview").prop(
                        "src",
                        "/storage/employer/profile_image/" + response.old
                    );
                    swal({
                        title: response.message,
                        text: response.text,
                        icon: "error",
                    });
                }
            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error(error);
                $("#result").html("An error occurred.");
            },
        });
    });

    // Action Apply, Save, Shortlist
    // $(".action").on("click", function () {
    $(document).on("click", ".action", function () {
        $("#loader").fadeIn();
        var job = $(this).data("job_id");
        var action_txt = $(this).data("job_action");
        var is_toggle = $(this).data("is_toggle");
        var posted_by = $(this).data("posted_by");
        var dashjs = $(this).data("dashjs");
        var action = $(this).data("action");

        if (action_txt != "" && (job !== null) & (job !== 0)) {
            $.ajax({
                url: baseUrl + "/jobseeker/job-action",
                type: "POST",
                dataType: "json",
                data: {
                    job_id: job,
                    action: action_txt,
                    is_toggle: is_toggle,
                    posted_by: posted_by,
                    posted_by: posted_by,
                },
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                context: $(".action"),
                success: function (res) {
                    $("#loader").fadeOut();
                    console.log(action_txt);
                    if (res.code === 200) {
                        if (res.lable === "Applied") {
                            $(this).html(res.lable);
                            $(this).removeAttr("data-job_id");
                            $(this).prop("disabled", "true");
                            $(this).removeClass("action");
                        }
                        // $(this).attr("data-job_action", action_txt);
                        if (action_txt === "Saved") {
                            $(this).find("i").removeClass("fa").addClass("far");
                            $(this).data("job_action", "Unsaved");
                            if (dashjs === 0) {
                                setTimeout(
                                    location.reload.bind(location),
                                    1000
                                );
                            }
                        } else {
                            $(this);
                            $(this).find("i").removeClass("far").addClass("fa");
                            $(this).data("job_action", "Saved");
                        }
                        swal({
                            title: res.message,
                            text: "",
                            icon: "success",
                        });
                    } else {
                        swal({
                            title: res.message,
                            text: "Please Try Again",
                            icon: "error",
                        });
                    }
                }.bind(this),
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error(error);
                    $("#result").html("An error occurred.");
                },
            });
        } else {
            swal({
                title: "Something Went Wrong",
                text: "Please Try Again",
                icon: "error",
            });
        }
    });
    $(".verify").on("click", function () {
        $("#loader").fadeIn();
        $.ajax({
            url: baseUrl + "/verfiy-resend",
            type: "POST",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            context: $(".verify"),
            success: function (res) {
                $("#loader").fadeOut();
                console.log(res.lable);
                if (res.code === 200) {
                    // $(this).html("Email Sent!!!");
                    // $(this).removeClass("verify");
                    // $(this).find("a").remove();
                    swal({
                        title: res.message,
                        text: "Please Check your mail Inbox",
                        icon: "success",
                    });
                } else {
                    swal({
                        title: res.message,
                        text: "Please Try Again",
                        icon: "error",
                    });
                }
            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error(error);
                $("#result").html("An error occurred.");
            },
        });
    });

    // Reset Password Link Send
    $("#resetPass").on("click", function () {
        $("#loader").fadeIn();
        var form = $(".resetPassData").serialize();

        $.ajax({
            url: baseUrl + "/reset-password-link",
            type: "POST",
            data: form,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (res) {
                $("#loader").fadeOut();
                if (res.code === 200) {
                    $(".resetPassData")[0].reset();
                    swal({
                        title: res.message,
                        text: "Please Check your mail Inbox",
                        icon: "success",
                    });
                } else {
                    swal({
                        title: res.message,
                        text: res.text,
                        icon: "error",
                    });
                }
            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error(error);
                $("#result").html("An error occurred.");
            },
        });
    });

    // Reset Password Save
    $(".resetNewPassword").on("click", function () {
        $("#new_pass_error").hide();
        $("#new_pass_error2").hide();
        $("#conf_pass_error1").hide();
        $("#conf_pass_error2").hide();

        var new_pass = $("#new_pass").val();
        var confirm_pass = $("#confirm_pass").val();
        var passwordRegex =
            /^(?=.*[a-zA-Z0-9])(?=.*[!@#$%^&*])(?=.{8,})[a-zA-Z0-9!@#$%^&*]+$/;

        if (new_pass === "") {
            $("#new_pass_error").show();
            return;
        }
        if (!passwordRegex.test(new_pass)) {
            $("#new_pass_error2").show();
            return;
        }
        if (confirm_pass === "") {
            $("#conf_pass_error1").show();
            return;
        }
        if (confirm_pass != new_pass) {
            $("#conf_pass_error2").show();
            return;
        }

        var form = $(".ChangePasswordData").serialize();
        $("#loader").fadeIn();
        $.ajax({
            url: baseUrl + "/reset-password",
            type: "POST",
            dataType: "json",
            data: form,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (res) {
                $("#loader").fadeOut();
                if (res.code === 200) {
                    swal({
                        title: res.message,
                        text: "Click Ok to Login",
                        icon: "success",
                    }).then(function () {
                        window.location = baseUrl + res.url;
                    });
                } else {
                    swal({
                        title: res.message,
                        text: res.text,
                        icon: "error",
                    });
                }
            },
            error: function (xhr, status, error) {
                // Handle errors
                console.error(error);
                $("#result").html("An error occurred.");
            },
        });
    });
    $("#updatePassword").on("click", function (e) {
        e.preventDefault();
        $("#old_pass_error").hide();
        $("#new_pass_error").hide();
        $("#new_pass_error2").hide();
        $("#conf_pass_error1").hide();
        $("#conf_pass_error2").hide();

        var old_pass = $("#old_pass").val();
        var new_pass = $("#new_pass").val();
        var confirm_pass = $("#confirm_pass").val();
        var passwordRegex =
            /^(?=.*[a-zA-Z0-9])(?=.*[!@#$%^&*])(?=.{8,})[a-zA-Z0-9!@#$%^&*]+$/;
        if (old_pass === "") {
            $("#old_pass_error").show();
            return;
        }
        if (new_pass === "") {
            $("#new_pass_error").show();
            return;
        }
        if (!passwordRegex.test(new_pass)) {
            $("#new_pass_error2").show();
            return;
        }
        if (confirm_pass === "") {
            $("#conf_pass_error1").show();
            return;
        }
        if (confirm_pass != new_pass) {
            $("#conf_pass_error2").show();
            return;
        }

        var form = $("#changePassword").serialize();
        if (old_pass != "" && confirm_pass != "") {
            $("#loader").show();
            $.ajax({
                url: baseUrl + "/pass-change",
                type: "POST",
                data: form,
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                success: function (response) {
                    $("#loader").fadeOut();
                    if (response.code == 200) {
                        $("#changePassword")[0].reset();
                        swal({
                            title: response.message,
                            // text: "Please Login",
                            icon: "success",
                        });
                    } else {
                        swal({
                            title: response.message,
                            text: "Please Try Again",
                            icon: "error",
                        });
                    }
                },
            });
        }
    });

    $(".accordion-list > li > .answer").hide();

    $(".accordion-list > li").click(function () {
        if ($(this).hasClass("active")) {
            $(this).removeClass("active").find(".answer").slideUp();
        } else {
            $(".accordion-list > li.active .answer").slideUp();
            $(".accordion-list > li.active").removeClass("active");
            $(this).addClass("active").find(".answer").slideDown();
        }
        return false;
    });

    $(".toggle-password").click(function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
});


// Function to fetch jobs for a specific page
// function fetchJobs(page) {
//     // Make an AJAX request
//     var xhr = new XMLHttpRequest();
//     xhr.open('GET', '/searchJobs?page_no=' + page, true);
//     xhr.onload = function () {
//         if (xhr.status >= 200 && xhr.status < 300) {
//             // Parse the JSON response
//             var response = JSON.parse(xhr.responseText);
//             // Update job list container with fetched data
//             document.getElementById('jobListContainer').innerHTML = response.html;
//             // Update pagination container with pagination links
//             document.getElementById('paginationContainer').innerHTML = response.pagination;
//         } else {
//             console.error('Request failed with status:', xhr.status);
//         }
//     };
//     xhr.onerror = function () {
//         console.error('Request failed');
//     };
//     xhr.send();
// }

// // Initial load of jobs for the first page
// fetchJobs(1);

// // Event delegation for pagination links
// document.getElementById('paginationContainer').addEventListener('click', function (event) {
//     if (event.target.tagName === 'A') {
//         event.preventDefault();
//         var page = event.target.getAttribute('data-page');
//         fetchJobs(page);
//     }
// });
