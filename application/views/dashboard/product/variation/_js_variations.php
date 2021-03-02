<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/colorpicker/bootstrap-colorpicker.min.css">
<script src="<?php echo base_url(); ?>assets/vendor/colorpicker/bootstrap-colorpicker.min.js"></script>
<script>
    var selected_lang_id = '<?php echo $this->selected_lang->id;?>';

    //add product variation post
    $("#form_add_product_variation").submit(function (event) {
        event.preventDefault();
        var input_variation_label = $.trim($('#input_variation_label').val());
        if (input_variation_label.length < 1) {
            $('#input_variation_label').addClass("is-invalid");
            return false;
        } else {
            $('#input_variation_label').removeClass("is-invalid");
        }
        var form = $(this);
        var serializedData = form.serializeArray();
        serializedData.push({name: csfr_token_name, value: $.cookie(csfr_cookie_name)});
        serializedData.push({name: "sys_lang_id", value: sys_lang_id});
        $.ajax({
            url: base_url + "add-variation-post",
            type: "post",
            data: serializedData,
            success: function (response) {
                $(".input-variation-label").val('');
                $("#addVariationModal").modal('hide');
                $(".variation-options-container").empty();
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("response_product_variations").innerHTML = obj.html_content;
                }
            }
        });
    });

    //edit product variation
    function edit_product_variation(id) {
        $("#btn-variation-edit-" + id).css("visibility", "hidden");
        $("#sp-edit-" + id).show();
        var data = {
            "id": id,
            "sys_lang_id": sys_lang_id
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            url: base_url + "edit-variation",
            type: "post",
            data: data,
            success: function (response) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("response_product_variation_edit").innerHTML = obj.html_content;
                }
                setTimeout(
                    function () {
                        $("#editVariationModal").modal('show');
                        $("#btn-variation-edit-" + id).css("visibility", "visible");
                        $("#sp-edit-" + id).hide();
                    }, 250);
            }
        });
    }

    //edit product variation post
    $("#form_edit_product_variation").submit(function (event) {
        event.preventDefault();
        var input_variation_label = $.trim($('#input_variation_label_edit').val());
        if (input_variation_label.length < 1) {
            $('#input_variation_label_edit').addClass("is-invalid");
            return false;
        } else {
            $('#input_variation_label_edit').removeClass("is-invalid");
        }
        var form = $(this);
        var serializedData = form.serializeArray();
        serializedData.push({name: csfr_token_name, value: $.cookie(csfr_cookie_name)});
        serializedData.push({name: "sys_lang_id", value: sys_lang_id});
        $.ajax({
            url: base_url + "edit-variation-post",
            type: "post",
            data: serializedData,
            success: function (response) {
                $(".input-variation-label").val('');
                $("#editVariationModal").modal('hide');
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("response_product_variations").innerHTML = obj.html_content;
                }
            }
        });
    });

    //delete product variation
    function delete_product_variation(id, message) {
        swal({
            text: message,
            icon: "warning",
            buttons: [sweetalert_cancel, sweetalert_ok],
            dangerMode: true,
        })
            .then(function (willDelete) {
                if (willDelete) {
                    var data = {
                        "id": id,
                        "sys_lang_id": sys_lang_id
                    };
                    data[csfr_token_name] = $.cookie(csfr_cookie_name);
                    $.ajax({
                        url: base_url + "delete-variation-post",
                        type: "post",
                        data: data,
                        success: function (response) {
                            var obj = JSON.parse(response);
                            if (obj.result == 1) {
                                document.getElementById("response_product_variations").innerHTML = obj.html_content;
                            }
                        }
                    });
                }
            });
    }

    //add product variation option
    function add_product_variation_option(id) {
        $("#btn-variation-text-add-" + id).css("visibility", "hidden");
        $("#sp-options-add-" + id).show();
        var data = {
            "variation_id": id,
            "sys_lang_id": sys_lang_id
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            url: base_url + "add-variation-option",
            type: "post",
            data: data,
            success: function (response) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("response_product_add_variation_option").innerHTML = obj.html_content;
                }
                setTimeout(
                    function () {
                        $("#addVariationOptionModal").modal('show');
                        $("#btn-variation-text-add-" + id).css("visibility", "visible");
                        $("#sp-options-add-" + id).hide();
                    }, 250);
            }
        });
    }

    //view product variation options
    function view_product_variation_options(id) {
        $("#btn-variation-text-options-" + id).css("visibility", "hidden");
        $("#sp-options-" + id).show();
        var data = {
            "variation_id": id,
            "sys_lang_id": sys_lang_id
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            url: base_url + "view-variation-options",
            type: "post",
            data: data,
            success: function (response) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("response_product_variation_options_edit").innerHTML = obj.html_content;
                }
                setTimeout(
                    function () {
                        $("#viewVariationOptionsModal").modal('show');
                        $("#btn-variation-text-options-" + id).css("visibility", "visible");
                        $("#sp-options-" + id).hide();
                    }, 250);
            }
        });
    }

    //edit product variation option
    function edit_product_variation_option(variation_id, option_id) {
        var data = {
            "variation_id": variation_id,
            "option_id": option_id,
            "sys_lang_id": sys_lang_id
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            url: base_url + "edit-variation-option",
            type: "post",
            data: data,
            success: function (response) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("response_product_edit_variation_option").innerHTML = obj.html_content;
                }
                setTimeout(
                    function () {
                        $("#editVariationOptionModal").modal('show');
                    }, 200);
            }
        });
    }

    $(document).on('click', '#btn_add_variation_option', function () {
        var input_variation_option = $.trim($('#input_variation_option_name').val());
        if (input_variation_option.length < 1) {
            $('#input_variation_option_name').addClass("is-invalid");
            return false;
        } else {
            $('#input_variation_option_name').removeClass("is-invalid");
        }
        var form = $("#form_add_product_variation_option");
        var serializedData = form.serializeArray();
        serializedData.push({name: csfr_token_name, value: $.cookie(csfr_cookie_name)});
        serializedData.push({name: "sys_lang_id", value: sys_lang_id});
        $(".input-variation-label").val('');
        $.ajax({
            url: base_url + "add-variation-option-post",
            type: "post",
            data: serializedData,
            success: function (response) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("response_product_add_variation_option").innerHTML = obj.html_content;
                }
            }
        });
    });

    $(document).on('click', '#btn_edit_variation_option', function () {
        var variation_id = $("#form_edit_variation_id").val();
        var input_variation_option = $.trim($('#input_edit_variation_option_name').val());
        if (input_variation_option.length < 1) {
            $('#input_edit_variation_option_name').addClass("is-invalid");
            return false;
        } else {
            $('#input_edit_variation_option_name').removeClass("is-invalid");
        }
        var form = $("#form_edit_product_variation_option");
        var serializedData = form.serializeArray();
        serializedData.push({name: csfr_token_name, value: $.cookie(csfr_cookie_name)});
        serializedData.push({name: "sys_lang_id", value: sys_lang_id});
        $(".input-variation-label").val('');
        $.ajax({
            url: base_url + "edit-variation-option-post",
            type: "post",
            data: serializedData,
            success: function (response) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("response_product_edit_variation_option").innerHTML = obj.html_content;
                    //refresh variation option lists
                    view_product_variation_options(variation_id);
                }
            }
        });
    });

    //delete product variation option
    function delete_product_variation_option(variation_id, option_id, message) {
        swal({
            text: message,
            icon: "warning",
            buttons: [sweetalert_cancel, sweetalert_ok],
            dangerMode: true,
        })
            .then(function (willDelete) {
                if (willDelete) {
                    var data = {
                        "variation_id": variation_id,
                        "option_id": option_id,
                        "sys_lang_id": sys_lang_id
                    };
                    data[csfr_token_name] = $.cookie(csfr_cookie_name);
                    $.ajax({
                        url: base_url + "delete-variation-option-post",
                        type: "post",
                        data: data,
                        success: function (response) {
                            var obj = JSON.parse(response);
                            if (obj.result == 1) {
                                document.getElementById("response_product_variation_options_edit").innerHTML = obj.html_content;
                            }
                        }
                    });
                }
            });
    }

    //select product variation
    $("#form_select_product_variation").submit(function (event) {
        event.preventDefault();
        var form = $(this);
        var serializedData = form.serializeArray();
        serializedData.push({name: csfr_token_name, value: $.cookie(csfr_cookie_name)});
        serializedData.push({name: "sys_lang_id", value: sys_lang_id});
        $.ajax({
            url: base_url + "select-variation-post",
            type: "post",
            data: serializedData,
            success: function (response) {
                $("#variationModalSelect").modal('hide');
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("response_product_variations").innerHTML = obj.html_content;
                }
            }
        });
    });

    $(document).on('click', '.btn-delete-variation-image-session', function () {
        var file_id = $(this).attr("data-file-id");
        var data = {
            "file_id": file_id,
            "sys_lang_id": sys_lang_id
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            url: base_url + "delete-variation-image-session-post",
            type: "post",
            data: data,
            success: function (response) {
                $("#uploaderFile" + file_id).remove();
            }
        });
    });

    $(document).on('click', '.btn-delete-variation-image', function () {
        var variation_id = $(this).attr("data-variation-id");
        var image_id = $(this).attr("data-file-id");
        var data = {
            "variation_id": variation_id,
            "image_id": image_id,
            "sys_lang_id": sys_lang_id
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            url: base_url + "delete-variation-image-post",
            type: "post",
            data: data,
            success: function (response) {
                $("#uploaderFile" + image_id).remove();
                $("#uploaded_vr_img_" + image_id).remove();
            }
        });
    });

    //set main variation image session
    $(document).on('click', '.btn-set-variation-image-main-session', function () {
        var file_id = $(this).attr('data-file-id');
        if (file_id) {
            var data = {
                "file_id": file_id,
                "sys_lang_id": sys_lang_id
            };
            $('.btn-is-image-main').removeClass('btn-success');
            $('.btn-is-image-main').addClass('btn-secondary');
            $(this).removeClass('btn-secondary');
            $(this).addClass('btn-success');
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + "set-variation-image-main-session",
                data: data,
                success: function (response) {
                }
            });
        }
    });

    $(document).on('click', '.btn-set-variation-image-main', function () {
        var file_id = $(this).attr('data-file-id');
        var option_id = $(this).attr('data-option-id');
        var data = {
            "file_id": file_id,
            "option_id": option_id,
            "sys_lang_id": sys_lang_id
        };
        $('.btn-is-image-main').removeClass('btn-success');
        $('.btn-is-image-main').addClass('btn-secondary');
        $(this).removeClass('btn-secondary');
        $(this).addClass('btn-success');
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "set-variation-image-main",
            data: data,
            success: function (response) {
            }
        });
    });

    $(document).on('change', '#checkbox_discount_rate_variation', function () {
        if (!this.checked) {
            $("#discount_input_container_variation").show();
        } else {
            $('#input_discount_rate_variation').val("0");
            $("#discount_input_container_variation").hide();
        }
    });
    $(document).on('change', '#checkbox_price_variation', function () {
        if (!this.checked) {
            $("#price_input_container_variation").show();
        } else {
            $('#price_input_container_variation input').val("0");
            $("#price_input_container_variation").hide();
        }
    });
    $(document).on('change', '#checkbox_price_variation', function () {
        if (!this.checked) {
            $("#price_input_container_variation").show();
        } else {
            $('#price_input_container_variation input').val("0");
            $("#price_input_container_variation").hide();
        }
    });

    $(document).on('change', 'input[name=is_default]', function () {
        var value = $('input[name=is_default]:checked').val();
        if (value == 1) {
            $(".hide-if-default").addClass("display-none");
        } else {
            $(".hide-if-default").removeClass("display-none");
        }
    });

    function show_hide_form_option_images(val) {
        if (val == "radio_button" || val == "dropdown") {
            $(".form-group-show-option-images").show();
        } else {
            $(".form-group-show-option-images").hide();
        }

        if (val == "text" || val == "number" || val == "dropdown") {
            $(".form-group-display-type").hide();
        } else {
            $(".form-group-display-type").show();
        }

        if (val == "dropdown") {
            $(".form-group-parent-variation").show();
        } else {
            $(".form-group-parent-variation").hide();
        }
    }

    $(document).ajaxStop(function () {
        $(".colorpicker").colorpicker();
    });
</script>

