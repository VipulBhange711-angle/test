$(document).ready(function () {
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    var baseUrl = window.location.origin;
    var reader = new FileReader();
    var img = new Image();
    function loadJobseeker(records, page, count) {
        $("#jobseekerCount").html(count + " Jobseekers Found");
        $("#jobseekerResults").append(records);
    }
    function manageJobs() {
        $.ajax({
            url: baseUrl + "/emp-manage-job",
            type: "POST",
            data: form,
            dataType: "json",
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (response) {
                $("#loader").fadeOut();
                if (length != 0) {
                    $.each(response, function (index, value) {
                        // let img = "{{ asset('images/logo/svg/" + records[index].profile_img + "') }}";
                        $("#jobResults").append(
                            "<li><div class='post-bx'><div class='d-flex m-b30'><div class='job-post-company'><a href='javascript:void(0);'><span><img alt='' src=" +
                                assets +
                                "images/employer/" +
                                records[index].profile_img +
                                "></span></a></div><div class='job-post-info'><h4 ><a href='" +
                                baseUrl +
                                "/job-details-view/" +
                                btoa(records[index].id) +
                                "'>" +
                                records[index].job_title +
                                "</a></h4><ul><li><i class='fas fa-map-marker-alt'></i> " +
                                records[index].location_hiring_name +
                                "</li><li><i class='far fa-bookmark'></i> " +
                                records[index].job_type_name +
                                "</li><li><i class='far fa-clock'></i> Published 11 months ago</li></ul></div></div><div class='d-flex'><div class='job-time me-auto'><a href='javascript:void(0);'><span>" +
                                records[index].job_type_name +
                                "</span></a></div><div class='salary-bx'><span>" +
                                records[index].job_salary_to_name +
                                "</span></div></div><label class='like-btn'><input type='checkbox'><span class='checkmark'></span></label></div></li>"
                        );
                    });
                    $.each(page, function (index, value) {
                        $("#jobResults").append(
                            "<li class=''><a href='javascript:void(0);'>" +
                                page[index].page +
                                "</a></li>"
                        );
                    });
                } else {
                    $("#jobResults").append("<li>No Jobs Found</li>");
                }
            },
        });
    }
    $(".basic").on("click", function (e) {
        $(".basics").removeClass("d-none");
        $(".educations").addClass("d-none");
        $(".experiences").addClass("d-none");
        $(".profiles").addClass("d-none");
        $(".personal_detailss").addClass("d-none");
    });

    $(".education").on("click", function (e) {
        $(".basics").addClass("d-none");
        $(".educations").removeClass("d-none");
        $(".experiences").addClass("d-none");
        $(".profiles").addClass("d-none");
        $(".personal_detailss").addClass("d-none");
    });
    $(".experience").on("click", function (e) {
        $(".basics").addClass("d-none");
        $(".educations").addClass("d-none");
        $(".experiences").removeClass("d-none");
        $(".profiles").addClass("d-none");
        $(".personal_detailss").addClass("d-none");
    });
    $(".profile-summary").on("click", function (e) {
        $(".basics").addClass("d-none");
        $(".educations").addClass("d-none");
        $(".experiences").addClass("d-none");
        $(".profiles").removeClass("d-none");
        $(".personal_detailss").addClass("d-none");
    });
    $(".personal_details").on("click", function (e) {
        $(".basics").addClass("d-none");
        $(".educations").addClass("d-none");
        $(".experiences").addClass("d-none");
        $(".profiles").addClass("d-none");
        $(".personal_detailss").removeClass("d-none");
    });

    $("#ProfileSubmit").on("click", function (event) {
        $("#fullname_error").hide();
        $("#com_name_error").hide();
        $("#license_no_error").hide();
        $("#img_size_error").hide();
        event.preventDefault();

        var fullname = $("#full_name").val();
        var com_name = $("#emp_com_name").val();
        var license_no = $("#license_no").val();

        if (fullname === "") {
            $("#fullname_error").show();
            return;
        }
        if (com_name === "") {
            $("#com_name_error").show();
            return;
        }
        if (license_no === "") {
            $("#license_no_error").show();
            return;
        }

        //    var form = $("#comProfile").serialize();
        var form = new FormData($("#comProfile")[0]);
        $("#loader").fadeIn();
        $.ajax({
            url: baseUrl + "/employer/addemp-profiledata",
            type: "POST",
            data: form,
            dataType: "json",
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (response) {
                $("#loader").fadeOut();

                if (response.code == 200) {
                    $("#emp_profile_view").hide();
                    $("input")
                        .removeClass("form-control")
                        .addClass("form-control-plaintext")
                        .prop("readonly", "true");
                    $("#emp_profile_edit").show();
                    $(".textveiw").show();
                    $(".slec").addClass("d-none");
                    $("#empProfileSubmit")
                        .addClass("d-none")
                        .removeClass("d-block");
                    swal({
                        title: response.message,
                        // text: "Please Login",
                        icon: "success",
                    }).then(function () {
                        window.location.reload();
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

    // Post a job
    $("#empProfileSubmit").on("click", function (event) {
        event.preventDefault();
        var form = $("#comProfile").serialize();
        $("#loader").fadeIn();
        $.ajax({
            url: baseUrl + "/employer/addemp-profiledata",
            type: "POST",
            data: form,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (response) {
                $("#loader").fadeOut();

                if (response.code == 200) {
                    $("#emp_profile_view").hide();
                    $("input")
                        .removeClass("form-control")
                        .addClass("form-control-plaintext")
                        .prop("readonly", "true");
                    $("#emp_profile_edit").show();
                    $(".textveiw").show();
                    $(".slec").addClass("d-none");
                    $("#empProfileSubmit")
                        .addClass("d-none")
                        .removeClass("d-block");
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
    });
    $(".job_delete").on("click", function (event) {
        event.preventDefault();
        var enc_id = $(this).data("enc_id");
        var del_row = $(this).data("del_row");
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this Job!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $("#loader").fadeIn();
                $.ajax({
                    url: baseUrl + "/employer/emp-job-delete",
                    type: "POST",
                    data: { enc_id: enc_id },
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    success: function (response) {
                        $("#loader").fadeOut();
                        if (response.code == 200) {
                            $(".tr_no_" + del_row).remove();
                            // swal({
                            //     title: response.message,
                            //     // text: "Please Login",
                            //     icon: "success",
                            // });
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
    });
    $(".job_update").on("click", function (event) {
        event.preventDefault();
        var enc_id = $(this).data("enc_id");
        $("#loader").fadeIn();
        $.ajax({
            url: baseUrl + "/employer/emp-job-viewJob",
            type: "POST",
            data: { enc_id: enc_id },
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (response) {
                $("#loader").fadeOut();
                if (response.code == 200) {
                    swal({
                        title: response.message,
                        // text: "Please Login",
                        icon: "success",
                    }).then(function () {
                        window.location.href =
                            baseUrl + "/employer/emp-post-a-job-update";
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

    $(".job_inactive").on("change", function (event) {
        event.preventDefault();
        var enc_id = $(this).data("enc_id_inc");
        var row = $(this).data("row");
        var status = $(this).val();

        $("#loader").fadeIn();
        $.ajax({
            url: baseUrl + "/employer/emp-job-inactiveJob",
            type: "POST",
            data: { enc_id: enc_id, status: status },
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            // context: $(".job_inactive"),
            success: function (response) {
                $("#loader").fadeOut();

                if (response.code == 200) {
                    if (response.message === "Inactive") {
                        $("#flexSwitchCheckDefault_" + row).val("Live");
                        $(".statusChange" + row)
                            .removeClass("text-success")
                            .addClass("text-danger")
                            .html(
                                response.message +
                                    " <i class='fa fa-circle'></i>"
                            );
                    } else {
                        $("#flexSwitchCheckDefault_" + row).val("Inactive");
                        $(".statusChange" + row)
                            .removeClass("text-danger")
                            .addClass("text-success")
                            .html(
                                response.message +
                                    " <i class='fa fa-circle'></i>"
                            );
                    }
                    swal({
                        title: response.message,
                        // text: "Please Login",
                        icon: "success",
                    });
                    //     .then(function () {
                    //     window.location.href =
                    //         baseUrl + "/employer/emp-manage-job";
                    // });
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

    $("#job_sal").on("change", function (event) {
        var sal_range = $(this).val();
        if (sal_range != "") {
            $(".sal_disply").removeClass("d-none");
        } else {
            $(".sal_disply").addClass("d-none");
        }
    });
    // Shorlisted
    // $(".shortlist").on("click", function (event) {
    $(document).on("click", ".shortlist", function (e) {
        e.preventDefault();
        var js_id = $(this).data("js_id");
        var job_id = $(this).data("job_id") ?? 0;
        var short_action = $(this).data("short_action");
        var row = $(this).data("row");
        if (js_id !== null && js_id !== 0) {
            $("#loader").fadeIn();
            $.ajax({
                url: baseUrl + "/employer/emp-job-shortlist",
                type: "POST",
                data: {
                    js_id: js_id,
                    job_id: job_id,
                    short_action: short_action,
                },
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                context: $(".shortlist"),
                success: function (response) {
                    $("#loader").fadeOut();
                    if (response.code == 200) {
                        if (atob(short_action) === "No") {
                            $("#candidate_" + row).remove();
                        }
                        // $(this).html("<span>" + response.message + "</span>");
                        // $(this).removeAttr("data-job_id");
                        // $(this).removeAttr("data-js_id");
                        // $(this).removeClass("shortlist");
                        // $(this).find("a").remove();

                        if (response.message === "Shortlisted") {
                            $(this).find("i").removeClass("far").addClass("fa");
                            $(this).attr("data-short_action", btoa("No"));
                            $(this).data("short_action", btoa("No"));
                            // if (dashjs === 0) {
                            //     setTimeout(
                            //         location.reload.bind(location),
                            //         1000
                            //     );
                            // }
                        } else {
                            $(this).find("i").removeClass("fa").addClass("far");
                            $(this).attr("data-short_action", btoa("Yes"));
                            $(this).data("short_action", btoa("Yes"));
                        }
                        swal({
                            title: response.message,
                            text: "",
                            icon: "success",
                        });
                    } else {
                        swal({
                            title: response.message,
                            text: "Please Try Again",
                            icon: "error",
                        });
                    }
                }.bind(this),
            });
        } else {
            swal({
                title: "Something Went Wrong",
                text: "Please Try Again",
                icon: "error",
            });
        }
    });

    // $('.job_language').select2({
    //     maximumSelectionLength: 3,
    //     placeholder: 'Skills, Keywords',
    //     closeOnSelect: false,
    //     allowClear: true,
      
    //   });
    // Post a Job
    $("#postJob").click(function (event) {
        event.preventDefault();
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        $("#job_title_error").hide();
        $("#job_type_error").hide();
        $("#job_lang_error").hide();
        $("#job_indus_error").hide();
        $("#job_func_area_error").hide();
        $("#job_designation_error").hide();
        $("#job_expr_error").hide();
        $("#job_location_error").hide();
        $("#job_shift_error").hide();
        $("#job_gender_error").hide();
        $("#job_disc_error").hide();
        $("#job_educ_error").hide();
        $("#job_con_person_error").hide();
        $("#job_con_phone_error").hide();
        $("#job_con_phone_limit_error").hide();
        $("#job_con_email_error").hide();
        $("#job_con_email_ver_error").hide();
        $("#job_spec_error").hide();
        $("#vacancy_count_error").hide();

        var job_title = $("#job_title").val();
        var job_type = $("#job_type").val();
        var job_lang = $("#job_lang").val();
        var job_indus = $("#job_indus").val();
        var job_func_area = $("#job_func_area").val();
        var job_designation = $("#job_designation").val();
        var job_expr = $("#job_expr").val();
        var job_location = $("#job_location").val();
        // var job_gender = $("#job_gender").val();
        var job_skills = $("#job_skills").val();
        var job_disc = $("#job_disc").val();
        var job_educ = $("#job_educ").val();
        var job_con_person = $("#job_con_person").val();
        var job_con_phone = $("#job_con_phone").val();
        var job_con_email = $("#job_con_email").val();
        var vacancy_count = $("#vacancy_count").val();

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (job_title === "") {
            $("#job_title_error").show();
            return;
        }
        if (job_type === "") {
            $("#job_type_error").show();
            return;
        }
        if (job_lang.length === 0) {
            $("#job_lang_error").show();
            return;
        }
        if (job_indus === null) {
            $("#job_indus_error").show();
            return;
        }

        if (job_func_area === null) {
            $("#job_func_area_error").show();
            return;
        }

        if (job_designation === null) {
            $("#job_designation_error").show();
            return;
        }
        if (job_expr === null) {
            $("#job_expr_error").show();
            return;
        }
        if (job_location === null) {
            $("#job_location_error").show();
            return;
        }

        if (vacancy_count === "") {
            $("#vacancy_count_error").show();
            return;
        }
        if (job_skills.length === 0) {
            $("#job_skills_error").show();
            return;
        }
        if (job_disc === "") {
            $("#job_disc_error").show();
            return;
        }
        if (job_educ === null) {
            $("#job_educ_error").show();
            return;
        }
        if (job_con_person === "") {
            $("#job_con_person_error").show();
            return;
        }
        if (job_con_phone === "") {
            $("#job_con_phone_error").show();
            return;
        }
        if (job_con_phone.length < 8) {
            $("#job_con_phone_error").show();
            return;
        }
        if (job_con_phone.length > 8) {
            $("#job_con_phone_error").show();
            return;
        }

        if (job_con_email === "") {
            $("#job_con_email_error").show();
            return;
        }

        if (!emailRegex.test(job_con_email)) {
            $("#job_con_email_ver_error").show();
            return;
        }
        var form = $("#addJobForm").serialize();
        // var form = new FormData($("#regFrom")[0]);

        $("#loader").fadeIn();
        $.ajax({
            url: baseUrl + "/employer/add-jobs-post",
            type: "POST",
            data: form,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            success: function (response) {
                $("#loader").fadeOut();

                if (response.code == 200) {
                    $("#addJobForm")[0].reset();
                    swal({
                        title: response.message,
                        text: "",
                        icon: "success",
                    }).then(function () {
                        window.location.href =
                            baseUrl + "/employer/emp-manage-job";
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
    });
    $("#immidate_join").on("click", function (e) {
        $("#immidiate_shuffle").toggleClass("d-none");
    });

    // Jobseeker Found on Employer Section Left filter
    $(".jsfound_left_filters").on(
        "change",
        "input[type='checkbox'], input[type='radio']",
        function (e) {
            e.preventDefault();
            $("#loader").fadeIn();
            var form = $(".jsfound_left_filters").serialize();
            $("#jobseekerResults li").slideUp();
            $.ajax({
                url: baseUrl + "/employer/emp-browse-jobseeker",
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

                    loadJobseeker(records, page, count);
                },
                error: function (xhr, status, error) {
                    // Handle errors
                    console.error(error);
                    $("#result").html("An error occurred.");
                },
            });
        }
    );
});

// Function to fetch jobs for a specific page
function fetchJobs(page) {
    // Make an AJAX request
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/searchJobs?page_no=' + page, true);
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            // Parse the JSON response
            var response = JSON.parse(xhr.responseText);
            // Update job list container with fetched data
            document.getElementById('jobListContainer').innerHTML = response.html;
            // Update pagination container with pagination links
            document.getElementById('paginationContainer').innerHTML = response.pagination;
        } else {
            console.error('Request failed with status:', xhr.status);
        }
    };
    xhr.onerror = function () {
        console.error('Request failed');
    };
    xhr.send();
}

// Initial load of jobs for the first page
fetchJobs(1);

// Event delegation for pagination links
document.getElementById('paginationContainer').addEventListener('click', function (event) {
    if (event.target.tagName === 'A') {
        event.preventDefault();
        var page = event.target.getAttribute('data-page');
        fetchJobs(page);
    }
});
