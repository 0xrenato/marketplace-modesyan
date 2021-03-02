//update token
$("form").submit(function () {
    $("input[name='" + csfr_token_name + "']").val($.cookie(csfr_cookie_name));
});

//custom scrollbar
$(function () {
    $('.sidebar-scrollbar').overlayScrollbars({});
});

$('input[type="checkbox"].square-blue, input[type="radio"].square-blue').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' // optional
});
$('input[type="checkbox"].square-purple, input[type="radio"].square-purple').iCheck({
    checkboxClass: 'icheckbox_square-purple',
    radioClass: 'iradio_square-purple',
    increaseArea: '20%' // optional
});

$(function () {
    $('#tags_1').tagsInput({width: 'auto'});
});


//check all checkboxes
$("#checkAll").click(function () {
    $('input:checkbox').not(this).prop('checked', this.checked);
});

//show hide delete button
$('.checkbox-table').click(function () {
    if ($(".checkbox-table").is(':checked')) {
        $(".btn-table-delete").show();
    } else {
        $(".btn-table-delete").hide();
    }
});

//get blog categories
function get_blog_categories_by_lang(val) {
    var data = {
        "lang_id": val
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);

    $.ajax({
        type: "POST",
        url: base_url + "blog_controller/get_categories_by_lang",
        data: data,
        success: function (response) {
            $('#categories').children('option:not(:first)').remove();
            $("#categories").append(response);
        }
    });
}

//delete selected products
function delete_selected_products(message) {
    swal({
        text: message,
        icon: "warning",
        buttons: true,
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var product_ids = [];
            $("input[name='checkbox-table']:checked").each(function () {
                product_ids.push(this.value);
            });
            var data = {
                'product_ids': product_ids,
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + "product_controller/delete_selected_products",
                data: data,
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
};

//delete selected products permanently
function delete_selected_products_permanently(message) {
    swal({
        text: message,
        icon: "warning",
        buttons: true,
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var product_ids = [];
            $("input[name='checkbox-table']:checked").each(function () {
                product_ids.push(this.value);
            });
            var data = {
                'product_ids': product_ids,
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + "product_controller/delete_selected_products_permanently",
                data: data,
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
};

//remove from featured
function remove_from_featured(val) {
    var data = {
        "product_id": val,
        "is_ajax": 1
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "product_controller/add_remove_featured_products",
        data: data,
        success: function (response) {
            location.reload();
        }
    });
}

//add remove special offer
function add_remove_special_offers(val) {
    var data = {
        "product_id": val
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "product_controller/add_remove_special_offers",
        data: data,
        success: function (response) {
            location.reload();
        }
    });
}

//delete item
function delete_item(url, id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: true,
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var data = {
                'id': id,
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + url,
                data: data,
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
};

//confirm user email
function confirm_user_email(id) {
    var data = {
        'id': id,
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "membership_controller/confirm_user_email",
        data: data,
        success: function (response) {
            location.reload();
        }
    });
};

//ban remove user ban
function ban_remove_ban_user(id) {
    var data = {
        'id': id,
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "membership_controller/ban_remove_ban_user",
        data: data,
        success: function (response) {
            location.reload();
        }
    });
};

//get countries by continent
function get_countries_by_continent(key, first_option = null) {
    var data = {
        "key": key
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "ajax_controller/get_countries_by_continent",
        data: data,
        success: function (response) {
            $('#select_countries option').remove();
            if (first_option) {
                $("#select_countries").append('<option value="0">' + first_option + '</option>');
            }
            $("#select_countries").append(response);
        }
    });
}

//get states by country
function get_states_by_country(val, first_option = null) {
    var data = {
        "country_id": val
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "ajax_controller/get_states_by_country",
        data: data,
        success: function (response) {
            $('#select_states option').remove();
            if (first_option) {
                $("#select_states").append('<option value="0">' + first_option + '</option>');
            }
            $("#select_states").append(response);
        }
    });
}

//activate inactivate countries
function activate_inactivate_countries(action) {
    var data = {
        "action": action
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "admin_controller/activate_inactivate_countries",
        data: data,
        success: function (response) {
            location.reload();
        }
    });
};

//open or close user shop
function open_close_user_shop(id, message) {
    if (message.length > 1) {
        swal({
            text: message,
            icon: "warning",
            buttons: true,
            buttons: [sweetalert_cancel, sweetalert_ok],
            dangerMode: true,
        }).then(function (approve) {
            if (approve) {
                var data = {
                    "id": id
                };
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                $.ajax({
                    type: "POST",
                    url: base_url + "membership_controller/open_close_user_shop",
                    data: data,
                    success: function (response) {
                        location.reload();
                    }
                });
            }
        });
    } else {
        var data = {
            "id": id
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "membership_controller/open_close_user_shop",
            data: data,
            success: function (response) {
                location.reload();
            }
        });
    }
};

//approve product
function approve_product(id) {
    var data = {
        'id': id,
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "product_controller/approve_product",
        data: data,
        success: function (response) {
            location.reload();
        }
    });
};

//restore product
function restore_product(id) {
    var data = {
        'id': id,
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "product_controller/restore_product",
        data: data,
        success: function (response) {
            location.reload();
        }
    });
};

//get filter subcategories
function get_filter_subcategories(val) {
    var data = {
        "parent_id": val
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);

    $.ajax({
        type: "POST",
        url: base_url + "category_controller/get_subcategories",
        data: data,
        success: function (response) {
            $('#subcategories').children('option:not(:first)').remove();
            $("#subcategories").append(response);
        }
    });
}

//upload product image update page
$(document).on('change', '#Multifileupload', function () {
    var MultifileUpload = document.getElementById("Multifileupload");
    if (typeof (FileReader) != "undefined") {
        var MultidvPreview = document.getElementById("MultidvPreview");
        MultidvPreview.innerHTML = "";
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
        for (var i = 0; i < MultifileUpload.files.length; i++) {
            var file = MultifileUpload.files[i];
            var reader = new FileReader();
            reader.onload = function (e) {
                var img = document.createElement("IMG");
                img.height = "100";
                img.width = "100";
                img.src = e.target.result;
                img.id = "Multifileupload_image";
                MultidvPreview.appendChild(img);
                $("#Multifileupload_button").show();
            }
            reader.readAsDataURL(file);
        }
    } else {
        alert("This browser does not support HTML5 FileReader.");
    }
});

function show_preview_image(input) {
    var name = $(input).attr('name');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#img_preview_' + name).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

//delete selected reviews
function delete_selected_reviews(message) {
    swal({
        text: message,
        icon: "warning",
        buttons: true,
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {

            var review_ids = [];
            $("input[name='checkbox-table']:checked").each(function () {
                review_ids.push(this.value);
            });
            var data = {
                'review_ids': review_ids,
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + "product_controller/delete_selected_reviews",
                data: data,
                success: function (response) {
                    location.reload();
                }
            });

        }
    });
};

//delete selected user reviews
function delete_selected_user_reviews(message) {
    swal({
        text: message,
        icon: "warning",
        buttons: true,
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {

            var review_ids = [];
            $("input[name='checkbox-table']:checked").each(function () {
                review_ids.push(this.value);
            });
            var data = {
                'review_ids': review_ids,
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + "admin_controller/delete_selected_user_reviews",
                data: data,
                success: function (response) {
                    location.reload();
                }
            });

        }
    });
};

//approve selected comments
function approve_selected_comments() {
    var comment_ids = [];
    $("input[name='checkbox-table']:checked").each(function () {
        comment_ids.push(this.value);
    });
    var data = {
        'comment_ids': comment_ids,
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "product_controller/approve_selected_comments",
        data: data,
        success: function (response) {
            location.reload();
        }
    });
};


//delete selected comments
function delete_selected_comments(message) {
    swal({
        text: message,
        icon: "warning",
        buttons: true,
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {

            var comment_ids = [];
            $("input[name='checkbox-table']:checked").each(function () {
                comment_ids.push(this.value);
            });
            var data = {
                'comment_ids': comment_ids,
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + "product_controller/delete_selected_comments",
                data: data,
                success: function (response) {
                    location.reload();
                }
            });

        }
    });
};

//approve selected comments
function approve_selected_blog_comments() {
    var comment_ids = [];
    $("input[name='checkbox-table']:checked").each(function () {
        comment_ids.push(this.value);
    });
    var data = {
        'comment_ids': comment_ids,
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "blog_controller/approve_selected_comments",
        data: data,
        success: function (response) {
            location.reload();
        }
    });
};

//delete selected blog comments
function delete_selected_blog_comments(message) {
    swal({
        text: message,
        icon: "warning",
        buttons: true,
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {

            var comment_ids = [];
            $("input[name='checkbox-table']:checked").each(function () {
                comment_ids.push(this.value);
            });
            var data = {
                'comment_ids': comment_ids,
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + "blog_controller/delete_selected_comments",
                data: data,
                success: function (response) {
                    location.reload();
                }
            });

        }
    });
};

//delete custom field option
function delete_custom_field_option(message, id) {
    swal({
        text: message,
        icon: "warning",
        buttons: true,
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
                url: base_url + "category_controller/delete_custom_field_option",
                data: data,
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
};

//delete custom field category
function delete_custom_field_category(message, field_id, category_id) {
    swal({
        text: message,
        icon: "warning",
        buttons: true,
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var data = {
                "field_id": field_id,
                "category_id": category_id
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + "category_controller/delete_custom_field_category",
                data: data,
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
};

//approve bank transfer
function approve_bank_transfer(id, order_id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: true,
        buttons: [sweetalert_cancel, sweetalert_ok],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var data = {
                'id': id,
                'order_id': order_id,
                'option': 'approved',
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + "order_admin_controller/bank_transfer_options_post",
                data: data,
                success: function (response) {
                    location.reload();
                }
            });

        }
    });
};

//remove by homepage manager
function remove_by_homepage_manager(category_id, submit) {
    var data = {
        "submit": submit,
        "category_id": category_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "admin_controller/homepage_manager_post",
        data: data,
        success: function (response) {
            location.reload();
        }
    });
};

//update featured category order
$(document).on("input", ".input-featured-categories-order", function () {
    var val = $(this).val();
    var category_id = $(this).attr("data-category-id");
    var data = {
        "order": val,
        "category_id": category_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "category_controller/update_featured_categories_order_post",
        data: data
    });
});

//update homepage category order
$(document).on("input", ".input-index-categories-order", function () {
    var val = $(this).val();
    var category_id = $(this).attr("data-category-id");
    var data = {
        "order": val,
        "category_id": category_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "category_controller/update_index_categories_order_post",
        data: data
    });
});

//update exchange rate
$(document).on("input", ".input-exchange-rate", function () {
    var val = $(this).val();
    var currency_id = $(this).attr("data-currency-id");
    var data = {
        "exchange_rate": val,
        "currency_id": currency_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "admin_controller/edit_currency_rate",
        data: data
    });
});

$('.increase-count').each(function () {
    $(this).prop('Counter', 0).animate({
        Counter: $(this).text()
    }, {
        duration: 1000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});

$('#selected_system_marketplace').on('ifChecked', function () {
    $('.system-currency-select').show();
});
$('#selected_system_classified_ads').on('ifChecked', function () {
    $('.system-currency-select').hide();
});

$(document).ready(function () {
    $('.magnific-image-popup').magnificPopup({type: 'image'});
});

$(document).on("input keyup paste change", ".validate_price .price-input", function () {
    var val = $(this).val();
    val = val.replace(',', '.');
    if ($.isNumeric(val) && val != 0) {
        $(this).removeClass('is-invalid');
    } else {
        $(this).addClass('is-invalid');
    }
});

$(document).ready(function () {
    $('.validate_price').submit(function (e) {
        $('.validate_price .validate-price-input').each(function () {
            var val = $(this).val();
            val = val.replace(',', '.');
            if ($.isNumeric(val) && val != 0) {
                $(this).removeClass('is-invalid');
            } else {
                e.preventDefault();
                $(this).addClass('is-invalid');
                $(this).focus();
            }
        });
    });
});

//delete category image
function delete_category_image(category_id) {
    var data = {
        "category_id": category_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "category_controller/delete_category_image_post",
        data: data,
        success: function (response) {
            $(".img-category").remove();
            $(".btn-delete-category-img").hide();
        }
    });
};

//delete category watermark
function delete_category_watermark(category_id) {
    var data = {
        "category_id": category_id
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "admin_controller/delete_category_watermark_post",
        data: data,
        success: function (response) {
            location.reload();
        }
    });
};

$(document).ready(function () {
    $(".select2").select2({
        placeholder: $(this).attr('data-placeholder'),
        height: 40,
        dir: directionality,
        "language": {
            "noResults": function () {
                return txt_no_results_found;
            }
        },
    });
});


//update translation
$(document).on("input keyup paste change", ".input_translation", function () {
    var data = {
        "lang_id": $(this).attr("data-lang"),
        "label": $(this).attr("data-label"),
        "translation": $(this).val()
    };
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: base_url + "language_controller/update_translation_post",
        data: data,
        success: function (response) {
        }
    });
});

$(document).on('input keyup paste', '.number-spinner input', function () {
    var val = $(this).val();
    val = parseInt(val);
    if (val < 1) {
        val = 1;
    }
    $(this).val(val);
});


$(document).on("input keyup paste change", ".price-input", function () {
    var val = $(this).val();
    var subst = '';
    var regex = /[^\d.]|\.(?=.*\.)/g;
    val = val.replace(regex, subst);
    $(this).val(val);
});

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

$(document).ajaxStop(function () {

    $('input[type="checkbox"].square-purple, input[type="radio"].square-purple').iCheck({
        checkboxClass: 'icheckbox_square-purple',
        radioClass: 'iradio_square-purple',
        increaseArea: '20%' // optional
    });

});



