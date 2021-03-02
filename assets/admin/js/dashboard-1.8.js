//delete product
function delete_product(product_id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var data = {
                "id": product_id
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                method: "POST",
                url: base_url + "dashboard_controller/delete_product",
                data: data
            })
                .done(function (response) {
                    location.reload();
                })

        }
    });
}

//delete quote request
function delete_quote_request(id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var data = {
                "id": id
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + "bidding_controller/delete_quote_request",
                data: data,
                success: function (response) {
                    ;
                    location.reload();
                }
            });
        }
    });
}

function get_states(val, map) {
    $('#select_states').children('option').remove();
    $('#select_cities').children('option').remove();
    $('#get_states_container').hide();
    $('#get_cities_container').hide();
    var data = {
        "country_id": val,
        "sys_lang_id": sys_lang_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "ajax_controller/get_states",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("select_states").innerHTML = obj.content;
                $('#get_states_container').show();
            } else {
                document.getElementById("select_states").innerHTML = "";
                $('#get_states_container').hide();
            }
            if (map) {
                update_product_map();
            }
        }
    });
}

function get_cities(val, map) {
    var data = {
        "state_id": val,
        "sys_lang_id": sys_lang_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "ajax_controller/get_cities",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("select_cities").innerHTML = obj.content;
                $('#get_cities_container').show();
            } else {
                document.getElementById("select_cities").innerHTML = "";
                $('#get_cities_container').hide();
            }
            if (map) {
                update_product_map();
            }
        }
    });
}

//set main image session
$(document).on('click', '.btn-set-image-main-session', function () {
    var file_id = $(this).attr('data-file-id');
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
        url: base_url + "file_controller/set_image_main_session",
        data: data,
        success: function (response) {
        }
    });
});

//set main image
$(document).on('click', '.btn-set-image-main', function () {
    var image_id = $(this).attr('data-image-id');
    var product_id = $(this).attr('data-product-id');
    var data = {
        "image_id": image_id,
        "product_id": product_id,
        "sys_lang_id": sys_lang_id
    };
    $('.btn-is-image-main').removeClass('btn-success');
    $('.btn-is-image-main').addClass('btn-secondary');
    $(this).removeClass('btn-secondary');
    $(this).addClass('btn-success');
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "file_controller/set_image_main",
        data: data,
        success: function (response) {
        }
    });
});

//delete product image session
$(document).on('click', '.btn-delete-product-img-session', function () {
    var file_id = $(this).attr('data-file-id');
    var data = {
        "file_id": file_id,
        "sys_lang_id": sys_lang_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "file_controller/delete_image_session",
        data: data,
        success: function () {
            $('#uploaderFile' + file_id).remove();
        }
    });
});

//delete product image
$(document).on('click', '.btn-delete-product-img', function () {
    var file_id = $(this).attr('data-file-id');
    var data = {
        "file_id": file_id,
        "sys_lang_id": sys_lang_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "file_controller/delete_image",
        data: data,
        success: function (response) {
            location.reload();
        }
    });
});

function update_product_map() {
    var country_text = $("#select_countries").find('option:selected').text();
    var country_val = $("#select_countries").find('option:selected').val();
    var state_text = $("#select_states").find('option:selected').text();
    var state_val = $("#select_states").find('option:selected').val();
    var address = $("#address_input").val();
    var zip_code = $("#zip_code_input").val();
    var data = {
        "country_text": country_text,
        "country_val": country_val,
        "state_text": state_text,
        "state_val": state_val,
        "address": address,
        "zip_code": zip_code,
        "sys_lang_id": sys_lang_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "dashboard_controller/show_address_on_map",
        data: data,
        success: function (response) {
            document.getElementById("map-result").innerHTML = response;
        }
    });
}

//delete product video preview
function delete_product_video_preview(product_id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var data = {
                "product_id": product_id,
                "sys_lang_id": sys_lang_id
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                url: base_url + "file_controller/delete_video",
                type: "post",
                data: data,
                success: function (response) {
                    document.getElementById("video_upload_result").innerHTML = response;
                }
            });
        }
    });
}

//delete product audio preview
function delete_product_audio_preview(product_id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var data = {
                "product_id": product_id,
                "sys_lang_id": sys_lang_id
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                url: base_url + "file_controller/delete_audio",
                type: "post",
                data: data,
                success: function (response) {
                    document.getElementById("audio_upload_result").innerHTML = response;
                }
            });
        }
    });
}

function generateUniqueString() {
    var time = String(new Date().getTime()),
        i = 0,
        output = '';
    for (i = 0; i < time.length; i += 2) {
        output += Number(time.substr(i, 2)).toString(36);
    }
    return (output.toUpperCase());
}


$('input[type=radio][name=product_type]').change(function () {
    $('input[name=listing_type]').prop('checked', false);
    if (this.value == 'digital') {
        $('.listing_ordinary_listing').hide();
        $('.listing_take_offers').hide();
        $('.listing_license_keys').show();
    } else {
        $('.listing_ordinary_listing').show();
        $('.listing_take_offers').show();
        $('.listing_license_keys').hide();
    }
});

//delete product digital file
function delete_product_digital_file(product_id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var data = {
                "product_id": product_id,
                "sys_lang_id": sys_lang_id
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                url: base_url + "file_controller/delete_digital_file",
                type: "post",
                data: data,
                success: function (response) {
                    var obj = JSON.parse(response);
                    if (obj.result == 1) {
                        document.getElementById("digital_files_upload_result").innerHTML = obj.html_content;
                    }
                }
            });
        }
    });
}

/*
 *------------------------------------------------------------------------------------------
 * LICENSE KEY FUNCTIONS
 *------------------------------------------------------------------------------------------
 */

//add license key
function add_license_keys(product_id) {
    var license_keys = $('#textarea_license_keys').val();
    if (license_keys.trim() != "") {
        $(".btn-add-license-keys").prop('disabled', true);
        $(".loader-license-keys").show();
        var data = {
            'product_id': product_id,
            'license_keys': license_keys,
            'allow_dublicate': $("input[name='allow_dublicate_license_keys']:checked").val(),
            'sys_lang_id': sys_lang_id
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "dashboard_controller/add_license_keys",
            data: data,
            success: function (response) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("result-add-license-keys").innerHTML = obj.success_message;
                    $('#textarea_license_keys').val('');
                    setTimeout(function () {
                        $(".btn-add-license-keys").prop('disabled', false);
                        $(".loader-license-keys").hide();
                    }, 500);
                }
            }
        });
    }
}

//delete license key
function delete_license_key(id, product_id) {
    var data = {
        'id': id,
        'product_id': product_id,
        'sys_lang_id': sys_lang_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "dashboard_controller/delete_license_key",
        data: data,
        success: function (response) {
            $('#tr_license_key_' + id).remove();
        }
    });
}

//update license code list on modal open
$("#viewLicenseKeysModal").on('show.bs.modal', function () {
    var product_id = $('#license_key_list_product_id').val();
    var data = {
        'product_id': product_id,
        'sys_lang_id': sys_lang_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "dashboard_controller/refresh_license_keys_list",
        data: data,
        success: function (response) {
            document.getElementById("response_license_key").innerHTML = response;
        }
    });
});

//get filter subcategories
function get_filter_subcategories_dashboard(val) {
    var data = {
        "parent_id": val
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);

    $.ajax({
        type: "POST",
        url: base_url + "dashboard_controller/get_subcategories",
        data: data,
        success: function (response) {
            $('#subcategories').children('option:not(:first)').remove();
            $("#subcategories").append(response);
        }
    });
}