//update token
$("form").submit(function () {
    $("input[name='" + mds_config.csfr_token_name + "']").val($.cookie(mds_config.csfr_cookie_name));
});

$(document).ready(function () {
    //main slider
    $('#main-slider').on('init', function (e, slick) {
        var $firstAnimatingElements = $('#main-slider .item:first-child').find('[data-animation]');
        doAnimations($firstAnimatingElements);
    });
    $('#main-slider').on('beforeChange', function (e, slick, currentSlide, nextSlide) {
        var $animatingElements = $('#main-slider .item[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
        doAnimations($animatingElements);
    });
    $('#main-slider').slick({
        autoplay: true,
        autoplaySpeed: 9000,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        speed: 500,
        fade: (mds_config.slider_fade_effect == 1) ? true : false,
        swipeToSlide: true,
        rtl: mds_config.rtl,
        cssEase: 'linear',
        prevArrow: $('#main-slider-nav .prev'),
        nextArrow: $('#main-slider-nav .next'),
    });

    //main slider
    $('#main-mobile-slider').on('init', function (e, slick) {
        var $firstAnimatingElements = $('#main-mobile-slider .item:first-child').find('[data-animation]');
        doAnimations($firstAnimatingElements);
    });
    $('#main-mobile-slider').on('beforeChange', function (e, slick, currentSlide, nextSlide) {
        var $animatingElements = $('#main-mobile-slider .item[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
        doAnimations($animatingElements);
    });
    $('#main-mobile-slider').slick({
        autoplay: true,
        autoplaySpeed: 9000,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        speed: 500,
        fade: (mds_config.slider_fade_effect == 1) ? true : false,
        swipeToSlide: true,
        rtl: mds_config.rtl,
        cssEase: 'linear',
        prevArrow: $('#main-mobile-slider-nav .prev'),
        nextArrow: $('#main-mobile-slider-nav .next')
    });

    function doAnimations(elements) {
        var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
        elements.each(function () {
            var $this = $(this);
            var $animationDelay = $this.data('delay');
            var $animationType = 'animated ' + $this.data('animation');
            $this.css({
                'animation-delay': $animationDelay,
                '-webkit-animation-delay': $animationDelay
            });
            $this.addClass($animationType).one(animationEndEvents, function () {
                $this.removeClass($animationType);
            });
        });
    }

    if ($('#slider_special_offers').length != 0) {
        $('#slider_special_offers').slick({
            autoplay: false,
            autoplaySpeed: 4900,
            infinite: true,
            speed: 200,
            swipeToSlide: true,
            rtl: mds_config.rtl,
            cssEase: 'linear',
            lazyLoad: 'progressive',
            prevArrow: $('#slider_special_offers_nav .prev'),
            nextArrow: $('#slider_special_offers_nav .next'),
            slidesToShow: 5,
            slidesToScroll: 5,
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                }
            ]
        });
    }

    $('#product_slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 300,
        arrows: true,
        fade: true,
        infinite: false,
        swipeToSlide: true,
        cssEase: 'linear',
        lazyLoad: 'progressive',
        prevArrow: $('#product-slider-nav .prev'),
        nextArrow: $('#product-slider-nav .next'),
        asNavFor: '#product_thumbnails_slider'
    });
    $('#product_thumbnails_slider').slick({
        slidesToShow: 7,
        slidesToScroll: 1,
        speed: 300,
        focusOnSelect: true,
        arrows: false,
        infinite: false,
        vertical: true,
        centerMode: false,
        arrows: true,
        cssEase: 'linear',
        lazyLoad: 'progressive',
        prevArrow: $('#product-thumbnails-slider-nav .prev'),
        nextArrow: $('#product-thumbnails-slider-nav .next'),
        asNavFor: '#product_slider'
    });

    $(document).on('click', '#product_thumbnails_slider .slick-slide', function () {
        var index = $(this).attr("data-slick-index");
        $('#product_slider').slick('slickGoTo', parseInt(index));
    });

    $(document).ready(function () {
        baguetteBox.run('.product-slider', {
            animation: mds_config.rtl == true ? 'fadeIn' : 'slideIn'
        });
    });

    $(document).ajaxStop(function () {
        baguetteBox.run('.product-slider', {
            animation: mds_config.rtl == true ? 'fadeIn' : 'slideIn'
        });
    });


    $('#blog-slider').slick({
        autoplay: false,
        autoplaySpeed: 4900,
        infinite: true,
        speed: 200,
        swipeToSlide: true,
        rtl: mds_config.rtl,
        cssEase: 'linear',
        prevArrow: $('#blog-slider-nav .prev'),
        nextArrow: $('#blog-slider-nav .next'),
        slidesToShow: 3,
        slidesToScroll: 3,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    //rate product
    $(document).on('click', '.rating-stars .label-star', function () {
        $('#user_rating').val($(this).attr('data-star'));
    });

    //mobile memu
    $(document).on('click', '.btn-open-mobile-nav', function () {
        if ($("#navMobile").hasClass('nav-mobile-open')) {
            $("#navMobile").removeClass('nav-mobile-open');
            $('#overlay_bg').hide();
        } else {
            $("#navMobile").addClass('nav-mobile-open');
            $('#overlay_bg').show();
        }
    });
    $(document).on('click', '#overlay_bg', function () {
        $("#navMobile").removeClass('nav-mobile-open');
        $('#overlay_bg').hide();
    });
    //close menu
    $(document).on('click', '.close-menu-click', function () {
        $("#navMobile").removeClass('nav-mobile-open');
        $('#overlay_bg').hide();
    });

});

//mobile menu
var obj_mobile_nav = {
    id: "",
    name: "",
    parent_id: "",
    parent_name: "",
    back_button: 1
};
$(document).on('click', '#navbar_mobile_categories li a', function () {
    obj_mobile_nav.id = $(this).attr('data-id');
    obj_mobile_nav.name = ($(this).text() != "") ? $(this).text() : '';
    obj_mobile_nav.parent_id = ($(this).attr('data-parent-id') != null) ? $(this).attr('data-parent-id') : 0;
    obj_mobile_nav.back_button = 1;
    mobile_menu();
});
$(document).on('click', '#navbar_mobile_back_button a', function () {
    obj_mobile_nav.id = $(this).attr('data-id');
    obj_mobile_nav.name = ($(this).attr('data-category-name') != null) ? $(this).attr('data-category-name') : '';
    obj_mobile_nav.parent_id = ($(this).attr('data-parent-id') != null) ? $(this).attr('data-parent-id') : 0;
    if (obj_mobile_nav.id == 0) {
        obj_mobile_nav.back_button = 0;
    }
    mobile_menu();
});

function mobile_menu() {
    var categories = $('.mega-menu li a[data-parent-id="' + obj_mobile_nav.id + '"]');
    if (categories.length > 0) {
        if (obj_mobile_nav.back_button == 1) {
            $("#navbar_mobile_links").hide();
        } else {
            $("#navbar_mobile_links").show();
            $("#navbar_mobile_back_button").empty();
        }
        $("#navbar_mobile_categories").empty();
        $("#navbar_mobile_back_button").empty();
        if (obj_mobile_nav.back_button == 1) {
            if (obj_mobile_nav.parent_id == 0) {
                document.getElementById("navbar_mobile_back_button").innerHTML = '<a href="javascript:void(0)" class="nav-link" data-id="0"><strong><i class="icon-angle-left"></i>' + obj_mobile_nav.name + '</strong></a>';
            } else {
                var item_parent_name = $('.mega-menu li a[data-id="' + obj_mobile_nav.parent_id + '"]').text();
                document.getElementById("navbar_mobile_back_button").innerHTML = '<a href="javascript:void(0)" class="nav-link" data-id="' + obj_mobile_nav.parent_id + '" data-category-name="' + item_parent_name + '"><strong><i class="icon-angle-left"></i>' + obj_mobile_nav.name + '</strong></a>';
            }
            var item_all_link = $('.mega-menu li a[data-id="' + obj_mobile_nav.id + '"]').attr("href");
            document.getElementById("navbar_mobile_categories").innerHTML = '<li class="nav-item"><a href="' + item_all_link + '" class="nav-link">' + mds_config.txt_all + '</a></li>';
        }
        $('.mega-menu li a[data-parent-id="' + obj_mobile_nav.id + '"]').each(function () {
            var item_id = $(this).attr("data-id");
            var item_parent_id = obj_mobile_nav.id;
            var item_link = $(this).attr("href");
            var item_text = $(this).text();
            var item_has_sb = $(this).attr("data-has-sb");
            if (item_has_sb == 1) {
                $("#navbar_mobile_categories").append('<li class="nav-item"><a href="javascript:void(0)" class="nav-link" data-id="' + item_id + '" data-parent-id="' + item_parent_id + '">' + item_text + '<i class="icon-arrow-right"></i></a></li>');
            } else {
                $("#navbar_mobile_categories").append('<li class="nav-item"><a href="' + item_link + '" class="nav-link">' + item_text + '</a></li>');
            }
        });

        $(".nav-mobile-links").addClass('slide-in-150s');
        setTimeout(function () {
            $(".nav-mobile-links").removeClass('slide-in-150s');
        }, 150);
    }
}

//search
$(document).on('click', '.mobile-search .search-icon', function () {
    if ($(".mobile-search-form").hasClass("display-block")) {
        $(".mobile-search-form").removeClass("display-block");
        $(".mobile-search .search-icon i").removeClass("icon-close");
        $(".mobile-search .search-icon i").addClass("icon-search")
    } else {
        $(".mobile-search-form").addClass("display-block");
        $(".mobile-search .search-icon i").removeClass("icon-search");
        $(".mobile-search .search-icon i").addClass("icon-close")
    }
});

//custom scrollbar
$(function () {
    $('.filter-custom-scrollbar').overlayScrollbars({});
    $('.search-results-product').overlayScrollbars({});
    $('.search-results-location').overlayScrollbars({});
    $('.messages-sidebar').overlayScrollbars({});
    if ($('#message-custom-scrollbar').length > 0) {
        var instance_message_scrollbar = OverlayScrollbars(document.getElementById('message-custom-scrollbar'), {});
        instance_message_scrollbar.scroll({y: "100%"}, 0);
    }
});

/*mega menu*/
$(".mega-menu .nav-item").hover(function () {
    var menu_id = $(this).attr('data-category-id');
    $("#mega_menu_content_" + menu_id).show();
    $(".large-menu-item").removeClass('active');
    $(".large-menu-item-first").addClass('active');
    $(".large-menu-content-first").addClass('active');
    //$("#menu-overlay").show();
}, function () {
    var menu_id = $(this).attr('data-category-id');
    $("#mega_menu_content_" + menu_id).hide();
    //$("#menu-overlay").hide();
});

$(".mega-menu .dropdown-menu").hover(function () {
    $(this).show();
}, function () {
});

$(".large-menu-item").hover(function () {
    var menu_id = $(this).attr('data-subcategory-id');
    $(".large-menu-item").removeClass('active');
    $(this).addClass('active');
    $(".large-menu-content").removeClass('active');
    $("#large_menu_content_" + menu_id).addClass('active');
}, function () {
});


//scrollup
$(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
        $(".scrollup").fadeIn()
    } else {
        $(".scrollup").fadeOut()
    }
});
$(".scrollup").click(function () {
    $("html, body").animate({scrollTop: 0}, 700);
    return false
});

$(function () {
    $(".search-select a").click(function () {
        $(".search-select .btn").text($(this).text());
        $(".search-select .btn").val($(this).text());
        $(".search_type_input").val($(this).attr("data-value"));
    });
});

$(document).on('click', '.quantity-select-product .dropdown-menu .dropdown-item', function () {
    $(".quantity-select-product .btn span").text($(this).text());
    $("input[name='product_quantity']").val($(this).text());
});

//show phone number
$(document).on('click', '#show_phone_number', function () {
    $(this).hide();
    $("#phone_number").show();
});

$(document).ready(function () {
    $(".select2").select2({
        placeholder: $(this).attr('data-placeholder'),
        height: 42,
        dir: mds_config.rtl == true ? "rtl" : "ltr",
        "language": {
            "noResults": function () {
                return mds_config.txt_no_results_found;
            }
        },
    });
});

/*
 *------------------------------------------------------------------------------------------
 * AUTH FUNCTIONS
 *------------------------------------------------------------------------------------------
 */

//login
$(document).ready(function () {
    $("#form_login").submit(function (event) {
        var form = $(this);
        if (form[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            event.preventDefault();
            var inputs = form.find("input, select, button, textarea");
            var serializedData = form.serializeArray();
            serializedData.push({name: mds_config.csfr_token_name, value: $.cookie(mds_config.csfr_cookie_name)});
            serializedData.push({name: "sys_lang_id", value: mds_config.sys_lang_id});
            $.ajax({
                url: mds_config.base_url + "auth_controller/login_post",
                type: "post",
                data: serializedData,
                success: function (response) {
                    var obj = JSON.parse(response);
                    if (obj.result == 1) {
                        location.reload();
                    } else if (obj.result == 0) {
                        document.getElementById("result-login").innerHTML = obj.error_message;
                    }
                }
            });
        }
        form[0].classList.add('was-validated');
    });
});

//send activation email
function send_activation_email(id, token) {
    $('#result-login').empty();
    $('.spinner-activation-login').show();
    var data = {
        'id': id,
        'token': token,
        'type': 'login',
        "sys_lang_id": mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $('#submit_review').prop("disabled", true);
    $.ajax({
        type: "POST",
        url: mds_config.base_url + "auth_controller/send_activation_email_post",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                $('.spinner-activation-login').hide();
                document.getElementById("result-login").innerHTML = obj.success_message;
            } else {
                location.reload();
            }
        }
    });
}

//send activation email register
function send_activation_email_register(id, token) {
    $('#result-register').empty();
    $('.spinner-activation-register').show();
    var data = {
        'id': id,
        'token': token,
        'type': 'register',
        'sys_lang_id': mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $('#submit_review').prop("disabled", true);
    $.ajax({
        type: "POST",
        url: mds_config.base_url + "auth_controller/send_activation_email_post",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                $('.spinner-activation-register').hide();
                document.getElementById("result-register").innerHTML = obj.success_message;
            } else {
                location.reload();
            }
        }
    });
}

/*
 *------------------------------------------------------------------------------------------
 * VARIATION FUNCTIONS
 *------------------------------------------------------------------------------------------
 */
function select_product_variation_option(variation_id, variation_type, selected_option_id) {
    var data = {
        'variation_id': variation_id,
        'selected_option_id': selected_option_id,
        'sys_lang_id': mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: mds_config.base_url + "select-variation-option-post",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.status == 1) {
                if (obj.html_content_price != "") {
                    document.getElementById("product_details_price_container").innerHTML = obj.html_content_price;
                }
                if (obj.html_content_stock != "") {
                    document.getElementById("text_product_stock_status").innerHTML = obj.html_content_stock;
                    if (obj.stock_status == 0) {
                        $(".btn-product-cart").attr("disabled", true);
                    } else {
                        $(".btn-product-cart").attr("disabled", false);
                    }
                }
                if (obj.html_content_slider != "") {
                    $('#product_slider').slick('unslick');
                    $('#product_thumbnails_slider').slick('unslick');
                    document.getElementById("product_slider_container").innerHTML = obj.html_content_slider;
                    $('#product_slider').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        speed: 300,
                        arrows: true,
                        fade: true,
                        infinite: false,
                        swipeToSlide: true,
                        cssEase: 'linear',
                        lazyLoad: 'progressive',
                        prevArrow: $('#product-slider-nav .prev'),
                        nextArrow: $('#product-slider-nav .next'),
                        asNavFor: '#product_thumbnails_slider'
                    });
                    $('#product_thumbnails_slider').slick({
                        slidesToShow: 7,
                        slidesToScroll: 1,
                        speed: 300,
                        focusOnSelect: true,
                        arrows: false,
                        infinite: false,
                        vertical: true,
                        centerMode: false,
                        arrows: true,
                        cssEase: 'linear',
                        lazyLoad: 'progressive',
                        prevArrow: $('#product-thumbnails-slider-nav .prev'),
                        nextArrow: $('#product-thumbnails-slider-nav .next'),
                        asNavFor: '#product_slider'
                    });
                }
            }

            if (variation_type == 'dropdown') {
                get_sub_variation_options(variation_id, selected_option_id);
            }
        }
    });
}

function get_sub_variation_options(variation_id, selected_option_id) {
    var data = {
        "variation_id": variation_id,
        "selected_option_id": selected_option_id,
        "sys_lang_id": mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $.ajax({
        url: mds_config.base_url + "get-sub-variation-options",
        type: "POST",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.status == 1) {
                if (selected_option_id == "") {
                    document.getElementById("variation_dropdown_" + obj.subvariation_id).innerHTML = "";
                } else {
                    document.getElementById("variation_dropdown_" + obj.subvariation_id).innerHTML = obj.html_content;
                }
            }
        }
    });
}

/*
 *------------------------------------------------------------------------------------------
 * NUMBER SPINNER FUNCTIONS
 *------------------------------------------------------------------------------------------
 */
//number spinner
$(document).on('click', '.product-add-to-cart-container .number-spinner button', function () {
    update_number_spinner($(this));
});

function update_number_spinner(btn) {
    var btn = btn,
        oldValue = btn.closest('.number-spinner').find('input').val().trim(),
        newVal = 0;
    if (btn.attr('data-dir') == 'up') {
        newVal = parseInt(oldValue) + 1;
    } else {
        if (oldValue > 1) {
            newVal = parseInt(oldValue) - 1;
        } else {
            newVal = 1;
        }
    }
    btn.closest('.number-spinner').find('input').val(newVal);
}


$(document).on("input keyup paste change", ".number-spinner input", function () {
    var val = $(this).val();
    val = val.replace(",", "");
    val = val.replace(".", "");
    if (!$.isNumeric(val)) {
        val = 1;
    }
    if (isNaN(val)) {
        val = 1;
    }
    $(this).val(val);
});

$(document).on("input paste change", ".cart-item-quantity .number-spinner input", function () {
    var data = {
        'product_id': $(this).attr("data-product-id"),
        'cart_item_id': $(this).attr("data-cart-item-id"),
        'quantity': $(this).val(),
        'sys_lang_id': mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: mds_config.base_url + "update-cart-product-quantity",
        data: data,
        success: function (response) {
            location.reload();
        }
    });
});
$(document).on("click", ".cart-item-quantity .btn-spinner-minus", function () {
    update_number_spinner($(this));
    var cart_id = $(this).attr("data-cart-item-id");
    if ($("#q-" + cart_id).val() != 0) {
        $("#q-" + cart_id).change();
    }
});
$(document).on("click", ".cart-item-quantity .btn-spinner-plus", function () {
    update_number_spinner($(this));
    var cart_id = $(this).attr("data-cart-item-id");
    $("#q-" + cart_id).change();
});

/*
 *------------------------------------------------------------------------------------------
 * REVIEW FUNCTIONS
 *------------------------------------------------------------------------------------------
 */

$(document).on('click', '.rate-product .rating-stars label', function () {
    $('.rate-product  .rating-stars label i').removeClass("icon-star");
    $('.rate-product  .rating-stars label i').addClass("icon-star-o");
    var selected_star = $(this).attr("data-star");
    $('.rate-product  .rating-stars label').each(function () {
        var star = $(this).attr("data-star");
        if (star <= selected_star) {
            $(this).find('i').removeClass("icon-star-o");
            $(this).find('i').addClass("icon-star");
        }
    });
});

$(document).on('click', '.rate-product .label-star-open-modal', function () {
    var product_id = $(this).attr("data-product-id");
    var rate = $(this).attr("data-star");
    $("#rateProductModal #review_product_id").val(product_id);
    $("#rateProductModal #user_rating").val(rate);
});
$(document).on('click', '.btn-add-review', function () {
    var product_id = $(this).attr("data-product-id");
    $("#rateProductModal #review_product_id").val(product_id);
});

//delete review
function delete_review(review_id, product_id, user_id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [mds_config.sweetalert_cancel, mds_config.sweetalert_ok],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var limit = parseInt($("#product_review_limit").val());
            var data = {
                "id": review_id,
                "product_id": product_id,
                "user_id": user_id,
                "limit": limit,
                "sys_lang_id": mds_config.sys_lang_id
            };
            data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
            $.ajax({
                method: "POST",
                url: mds_config.base_url + "home_controller/delete_review",
                data: data
            })
                .done(function (response) {
                    document.getElementById("review-result").innerHTML = response;
                })
        }
    });
}

/*
 *------------------------------------------------------------------------------------------
 * PRODUCT COMMENT FUNCTIONS
 *------------------------------------------------------------------------------------------
 */
$(document).ready(function () {
    //add comment
    $("#form_add_comment").submit(function (event) {
        event.preventDefault();
        var is_logged_in = true;
        var is_valid = true;
        var form_serialized = $("#form_add_comment").serializeArray();
        object_serialized = {};
        $(form_serialized).each(function (i, field) {
            object_serialized[field.name] = field.value;
            if (field.name == "g-recaptcha-response") {
                g_recaptcha = field.value;
            }
        });
        if ($("#form_add_comment").find("#comment_name").length > 0) {
            is_logged_in = false;
        }
        if (is_logged_in == false) {
            if (str_lenght(object_serialized.name) < 1) {
                $('#comment_name').addClass("is-invalid");
                is_valid = false;
            } else {
                $('#comment_name').removeClass("is-invalid");
            }
            if (str_lenght(object_serialized.email) < 1) {
                $('#comment_email').addClass("is-invalid");
                is_valid = false;
            } else {
                $('#comment_email').removeClass("is-invalid");
            }
            if (mds_config.is_recaptcha_enabled == true && is_logged_in == false) {
                if (g_recaptcha == "") {
                    $("#form_add_comment .g-recaptcha").addClass("is-recaptcha-invalid");
                    is_valid = false;
                } else {
                    $("#form_add_comment .g-recaptcha").removeClass("is-recaptcha-invalid");
                }
            }
        }
        if (str_lenght(object_serialized.comment) < 1) {
            $('#comment_text').addClass("is-invalid");
            is_valid = false;
        } else {
            $('#comment_text').removeClass("is-invalid");
        }

        if (!is_valid) {
            return false;
        }

        form_serialized.push({name: mds_config.csfr_token_name, value: $.cookie(mds_config.csfr_cookie_name)});
        form_serialized.push({name: "limit", value: parseInt($("#product_comment_limit").val())});
        form_serialized.push({name: "sys_lang_id", value: mds_config.sys_lang_id});

        $.ajax({
            url: mds_config.base_url + "ajax_controller/add_comment",
            type: "post",
            data: form_serialized,
            success: function (response) {
                if (mds_config.is_recaptcha_enabled == true && is_logged_in == false) {
                    grecaptcha.reset();
                }
                $("#form_add_comment")[0].reset();
                var obj = JSON.parse(response);
                if (obj.type == 'message') {
                    document.getElementById("message-comment-result").innerHTML = obj.html_content;
                } else {
                    document.getElementById("comment-result").innerHTML = obj.html_content;
                }
            }
        });
    });
});

//add subcomment
$(document).on('click', '.btn-submit-subcomment', function () {
    var comment_id = $(this).attr("data-comment-id");
    var data = {};
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $("#form_add_subcomment_" + comment_id).ajaxSubmit({
        beforeSubmit: function () {
            var is_logged_in = true;
            var is_valid = true;
            var g_recaptcha = "";
            if ($("#form_add_subcomment_" + comment_id).find(".form-comment-name").length > 0) {
                is_logged_in = false;
            }
            var form_serialized = $("#form_add_subcomment_" + comment_id).serializeArray();
            object_serialized = {};
            $(form_serialized).each(function (i, field) {
                object_serialized[field.name] = field.value;
                if (field.name == "g-recaptcha-response") {
                    g_recaptcha = field.value;
                }
            });
            if (is_logged_in == false) {
                if (object_serialized.name.length < 1) {
                    $(".form-comment-name").addClass("is-invalid");
                    is_valid = false;
                } else {
                    $(".form-comment-name").removeClass("is-invalid");
                }
                if (object_serialized.email.length < 1 || !is_email(object_serialized.email)) {
                    $(".form-comment-email").addClass("is-invalid");
                    is_valid = false;
                } else {
                    $(".form-comment-email").removeClass("is-invalid");
                }
                if (mds_config.is_recaptcha_enabled == true) {
                    if (g_recaptcha == "") {
                        $("#form_add_subcomment_" + comment_id + ' .g-recaptcha').addClass("is-recaptcha-invalid");
                        is_valid = false;
                    } else {
                        $("#form_add_subcomment_" + comment_id + ' .g-recaptcha').removeClass("is-recaptcha-invalid");
                    }
                }
            }
            if (object_serialized.comment.length < 1) {
                $(".form-comment-text").addClass("is-invalid");
                is_valid = false;
            } else {
                $(".form-comment-text").removeClass("is-invalid");
            }
            if (is_valid == false) {
                return false;
            }
        },
        type: "POST",
        url: mds_config.base_url + "ajax_controller/add_comment",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.type == 'message') {
                document.getElementById("sub_comment_form_" + comment_id).innerHTML = obj.html_content;
            } else {
                document.getElementById("comment-result").innerHTML = obj.html_content;
            }
        }
    });
});

//load more comment
function load_more_comment(product_id) {
    var limit = parseInt($("#product_comment_limit").val());
    var data = {
        "product_id": product_id,
        "limit": limit,
        "sys_lang_id": mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $("#load_comment_spinner").show();
    $.ajax({
        url: mds_config.base_url + "ajax_controller/load_more_comment",
        type: "POST",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.type == 'comments') {
                setTimeout(function () {
                    $("#load_comment_spinner").hide();
                    document.getElementById("comment-result").innerHTML = obj.html_content;
                }, 500);
            }
        }
    });
}

//validate email
function is_email(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!regex.test(email)) {
        return false;
    } else {
        return true;
    }
}

//get string lenght
function str_lenght(str) {
    if (str == "" || str == null) {
        return 0;
    }
    str = str.trim();
    return str.length;
}

//delete comment
function delete_comment(comment_id, product_id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [mds_config.sweetalert_cancel, mds_config.sweetalert_ok],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var limit = parseInt($("#product_comment_limit").val());
            var data = {
                "id": comment_id,
                "product_id": product_id,
                "limit": limit,
                "sys_lang_id": mds_config.sys_lang_id
            };
            data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
            $.ajax({
                url: mds_config.base_url + "ajax_controller/delete_comment",
                type: "POST",
                data: data,
                success: function (response) {
                    var obj = JSON.parse(response);
                    if (obj.type == 'comments') {
                        document.getElementById("comment-result").innerHTML = obj.html_content;
                    }
                }
            });
        }
    });
}

//show comment box
function show_comment_box(comment_id) {
    $('.visible-sub-comment').empty();
    var limit = parseInt($("#product_comment_limit").val());
    var data = {
        "comment_id": comment_id,
        "limit": limit,
        "sys_lang_id": mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: mds_config.base_url + "ajax_controller/load_subcomment_box",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.type == 'form') {
                $('#sub_comment_form_' + comment_id).append(obj.html_content);
            }
        }
    });
}

/*
 *------------------------------------------------------------------------------------------
 * BLOG COMMENTS FUNCTIONS
 *------------------------------------------------------------------------------------------
 */

$(document).ready(function () {
    //add comment
    $("#form_add_blog_comment").submit(function (event) {
        event.preventDefault();
        var is_logged_in = true;
        var is_valid = true;
        var form_serialized = $("#form_add_blog_comment").serializeArray();
        object_serialized = {};
        $(form_serialized).each(function (i, field) {
            object_serialized[field.name] = field.value;
            if (field.name == "g-recaptcha-response") {
                g_recaptcha = field.value;
            }
        });
        if ($("#form_add_blog_comment").find("#comment_name").length > 0) {
            is_logged_in = false;
        }
        if (is_logged_in == false) {
            if (str_lenght(object_serialized.name) < 1) {
                $('#comment_name').addClass("is-invalid");
                is_valid = false;
            } else {
                $('#comment_name').removeClass("is-invalid");
            }
            if (str_lenght(object_serialized.email) < 1) {
                $('#comment_email').addClass("is-invalid");
                is_valid = false;
            } else {
                $('#comment_email').removeClass("is-invalid");
            }
            if (mds_config.is_recaptcha_enabled == true && is_logged_in == false) {
                if (g_recaptcha == "") {
                    $("#form_add_blog_comment .g-recaptcha").addClass("is-recaptcha-invalid");
                    is_valid = false;
                } else {
                    $("#form_add_blog_comment .g-recaptcha").removeClass("is-recaptcha-invalid");
                }
            }
        }
        if (str_lenght(object_serialized.comment) < 1) {
            $('#comment_text').addClass("is-invalid");
            is_valid = false;
        } else {
            $('#comment_text').removeClass("is-invalid");
        }

        if (!is_valid) {
            return false;
        }

        form_serialized.push({name: mds_config.csfr_token_name, value: $.cookie(mds_config.csfr_cookie_name)});
        form_serialized.push({name: "limit", value: parseInt($("#blog_comment_limit").val())});
        form_serialized.push({name: "sys_lang_id", value: mds_config.sys_lang_id});
        $.ajax({
            url: mds_config.base_url + "ajax_controller/add_blog_comment",
            type: "post",
            data: form_serialized,
            success: function (response) {
                if (mds_config.is_recaptcha_enabled == true && is_logged_in == false) {
                    grecaptcha.reset();
                }
                $("#form_add_blog_comment")[0].reset();
                var obj = JSON.parse(response);
                if (obj.type == 'message') {
                    document.getElementById("message-comment-result").innerHTML = obj.html_content;
                } else {
                    document.getElementById("comment-result").innerHTML = obj.html_content;
                }
            }
        });
    });
});

//load more blog comment
function load_more_blog_comment(post_id) {
    var limit = parseInt($("#blog_comment_limit").val());
    var data = {
        "post_id": post_id,
        "limit": limit,
        "sys_lang_id": mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $("#load_comment_spinner").show();
    $.ajax({
        url: mds_config.base_url + "ajax_controller/load_more_blog_comments",
        type: "post",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.type == 'comments') {
                setTimeout(function () {
                    $("#load_comment_spinner").hide();
                    document.getElementById("comment-result").innerHTML = obj.html_content;
                }, 500);
            }
        }
    });
}

//delete blog comment
function delete_blog_comment(comment_id, post_id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [mds_config.sweetalert_cancel, mds_config.sweetalert_ok],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var limit = parseInt($("#blog_comment_limit").val());
            var data = {
                "comment_id": comment_id,
                "post_id": post_id,
                "limit": limit,
                "sys_lang_id": mds_config.sys_lang_id
            };
            data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
            $.ajax({
                url: mds_config.base_url + "ajax_controller/delete_blog_comment",
                type: "post",
                data: data,
                success: function (response) {
                    var obj = JSON.parse(response);
                    if (obj.type == 'comments') {
                        document.getElementById("comment-result").innerHTML = obj.html_content;
                    }
                }
            });
        }
    });
}


/*
 *------------------------------------------------------------------------------------------
 * MESSAGE FUNCTIONS
 *------------------------------------------------------------------------------------------
 */

//delete conversation
function delete_conversation(conversation_id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [mds_config.sweetalert_cancel, mds_config.sweetalert_ok],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var data = {
                "conversation_id": conversation_id,
                "sys_lang_id": mds_config.sys_lang_id
            };
            data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
            $.ajax({
                method: "POST",
                url: mds_config.base_url + "message_controller/delete_conversation",
                data: data
            })
                .done(function (response) {
                    location.reload();
                })

        }
    });
}


/*
 *------------------------------------------------------------------------------------------
 * CART FUNCTIONS
 *------------------------------------------------------------------------------------------
 */

//remove from cart
function remove_from_cart(cart_item_id) {
    var data = {
        "cart_item_id": cart_item_id,
        "sys_lang_id": mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: mds_config.base_url + "cart_controller/remove_from_cart",
        data: data,
        success: function (response) {
            location.reload();
        }
    });
};

//update cart product quantity
$(document).on('click', '.btn-cart-product-quantity-item', function () {
    var quantity = $(this).val();
    var product_id = $(this).attr("data-product-id");
    var data = {
        "product_id": product_id,
        "quantity": quantity,
        "sys_lang_id": mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: mds_config.base_url + "cart_controller/update_cart_product_quantity",
        data: data,
        success: function (response) {
            location.reload();
        }
    });
});

$(document).ready(function () {
    $('#use_same_address_for_billing').change(function () {
        if ($(this).is(":checked")) {
            $('.cart-form-billing-address').hide();
            $('.cart-form-billing-address select').removeClass('select2-req');
        } else {
            $('.cart-form-billing-address').show();
            $('.cart-form-billing-address select').addClass('select2-req');
        }
    });
});

//approve order product
function approve_order_product(id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [mds_config.sweetalert_cancel, mds_config.sweetalert_ok],
        dangerMode: true,
    }).then(function (approve) {
        if (approve) {
            var data = {
                "order_product_id": id,
                "sys_lang_id": mds_config.sys_lang_id
            };
            data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: mds_config.base_url + "order_controller/approve_order_product_post",
                data: data,
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
};

//get shipping methods by location
function get_shipping_methods_by_location(state_id) {
    $('#cart_shipping_methods_container').hide();
    $('.cart-shipping-loader').show();
    var data = {
        "state_id": state_id,
        "sys_lang_id": mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: mds_config.base_url + "cart_controller/get_shipping_methods_by_location",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("cart_shipping_methods_container").innerHTML = obj.html_content;
                setTimeout(function () {
                    $('#cart_shipping_methods_container').show();
                    $('.cart-shipping-loader').hide();
                }, 400);
            }
        }
    });
};


/*
 *------------------------------------------------------------------------------------------
 * LOCATION FUNCTIONS
 *------------------------------------------------------------------------------------------
 */

//search location
$(document).on("input paste click", "#input_location", function () {
    var input_value = $(this).val();
    if (input_value.length > 0) {
        $('.btn-reset-location-input').show();
    } else {
        $('#location_id_inputs input').val('');
        $('.btn-reset-location-input').hide();
    }
    if (input_value.length < 2) {
        $('#response_search_location').hide();
        return false;
    }
    var data = {
        "input_value": input_value,
        "sys_lang_id": mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: mds_config.base_url + "ajax_controller/search_location",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("response_search_location").innerHTML = obj.response;
                $('#response_search_location').show();
            }
            //search text
            $('#response_search_location ul li a').wrapInTag({
                words: [input_value]
            });
        }
    });
});

$.fn.wrapInTag = function (opts) {
    function getText(obj) {
        return obj.textContent ? obj.textContent : obj.innerText;
    }

    var tag = opts.tag || 'strong',
        words = opts.words || [],
        regex = RegExp(words.join('|'), 'gi'),
        replacement = '<' + tag + '>$&</' + tag + '>';
    $(this).contents().each(function () {
        if (this.nodeType === 3) {
            $(this).replaceWith(getText(this).replace(regex, replacement));
        } else if (!opts.ignoreChildNodes) {
            $(this).wrapInTag(opts);
        }
    });
};

//set location
$(document).on("click", "#response_search_location ul li a", function () {
    $('#input_location').val($(this).text());
    var country_id = $(this).attr('data-country');
    var state_id = $(this).attr('data-state');
    var city_id = $(this).attr('data-city');
    $('#location_id_inputs').empty();
    if (country_id != null && country_id != 0) {
        $('#location_id_inputs').append("<input type='hidden' value='" + country_id + "' name='country' class='input-location-filter'>");
    }
    if (state_id != null && state_id != 0) {
        $('#location_id_inputs').append("<input type='hidden' value='" + state_id + "' name='state' class='input-location-filter'>");
    }
    if (city_id != null && city_id != 0) {
        $('#location_id_inputs').append("<input type='hidden' value='" + city_id + "' name='city' class='input-location-filter'>");
    }
});

$(document).on('click', '#btn_submit_location', function () {
    var data = {
        "country_id": $("#location_id_inputs input[name='country']").val(),
        "state_id": $("#location_id_inputs input[name='state']").val(),
        "city_id": $("#location_id_inputs input[name='city']").val(),
        "sys_lang_id": mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: mds_config.base_url + "set-default-location-post",
        data: data,
        success: function (response) {
            location.reload();
        }
    });
});

$(document).on('click', '.btn-reset-location-input', function () {
    $('#input_location').val('');
    $('#location_id_inputs input').val('');
    $(this).hide();
});

$(document).on('click', function (e) {
    if ($(e.target).closest(".filter-location").length === 0) {
        $("#response_search_location").hide();
    }
});

/*
 *------------------------------------------------------------------------------------------
 * ABUSE REPORT FUNCTIONS
 *------------------------------------------------------------------------------------------
 */

//report product
$("#form_report_product").submit(function (event) {
    event.preventDefault();
    report_abuse("form_report_product", "product");
});

//report seller
$("#form_report_seller").submit(function (event) {
    event.preventDefault();
    report_abuse("form_report_seller", "seller");
});

//report review
$("#form_report_review").submit(function (event) {
    event.preventDefault();
    report_abuse("form_report_review", "review");
});

//report comment
$("#form_report_comment").submit(function (event) {
    event.preventDefault();
    report_abuse("form_report_comment", "comment");
});


function report_abuse(form_id, item_type) {
    var form_serialized = $("#" + form_id).serializeArray();
    form_serialized.push({name: "item_type", value: item_type});
    form_serialized.push({name: mds_config.csfr_token_name, value: $.cookie(mds_config.csfr_cookie_name)});
    form_serialized.push({name: "sys_lang_id", value: mds_config.sys_lang_id});
    $.ajax({
        url: mds_config.base_url + "ajax_controller/report_abuse_post",
        type: "post",
        data: form_serialized,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.message != '') {
                document.getElementById("response_" + form_id).innerHTML = obj.message;
                $("#" + form_id)[0].reset();
            }
        }
    });
}

if ($(".profile-cover-image")[0]) {
    document.addEventListener('lazybeforeunveil', function (e) {
        var bg = e.target.getAttribute('data-bg-cover');
        if (bg) {
            e.target.style.backgroundImage = 'url(' + bg + ')';
        }
    });
}

/*
 *------------------------------------------------------------------------------------------
 * OTHER FUNCTIONS
 *------------------------------------------------------------------------------------------
 */

//AJAX search
$(document).on("input", "#input_search", function () {
    var search_type = $('.search_type_input').val();
    var input_value = $(this).val();
    if (input_value.length < 2) {
        $('#response_search_results').hide();
        return false;
    }
    var data = {
        "search_type": search_type,
        "input_value": input_value,
        "lang_base_url": mds_config.lang_base_url,
        "sys_lang_id": mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: mds_config.base_url + "ajax_controller/ajax_search",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("response_search_results").innerHTML = obj.response;
                $('.search-results-product').overlayScrollbars({});
                $('#response_search_results').show();
            }
            //search text
            $('#response_search_results ul li a').wrapInTag({
                words: [input_value]
            });
        }
    });
});

$(document).on("input", "#input_search_mobile", function () {
    var search_type = $('#search_type_input_mobile').val();
    var input_value = $(this).val();
    if (input_value.length < 2) {
        $('#response_search_results_mobile').hide();
        return false;
    }
    var data = {
        "search_type": search_type,
        "input_value": input_value,
        "lang_base_url": mds_config.lang_base_url,
        "sys_lang_id": mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: mds_config.base_url + "ajax_controller/ajax_search",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("response_search_results_mobile").innerHTML = obj.response;
                $('.search-results-product').overlayScrollbars({});
                $('#response_search_results_mobile').show();
            }
            //search text
            $('#response_search_results_mobile ul li a').wrapInTag({
                words: [input_value]
            });
        }
    });
});

$(document).on('click', function (e) {
    if ($(e.target).closest(".top-search-bar").length === 0) {
        $("#response_search_results").hide();
    }
});

//search product filters
$(document).on("change keyup paste", ".filter-search-input", function () {
    var filter_id = $(this).attr('data-filter-id');
    var input = $(this).val().toLowerCase();
    var list_items = $("#" + filter_id + " li");
    list_items.each(function (idx, li) {
        var text = $(this).find('label').text().toLowerCase();
        if (text.indexOf(input) > -1) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
});

$(document).on("click", "#btn_filter_price", function () {
    var price_min = $('#price_min').val();
    var price_max = $('#price_max').val();
    var page = $(this).attr('data-page');
    if (price_min != "" || price_max != "") {
        var query_string = $(this).attr('data-query-string');
        var current_url = $(this).attr('data-current-url');
        var params = "";
        if (price_min != "") {
            params = "p_min=" + price_min;
            if (price_max != "") {
                params += "&p_max=" + price_max;
            }
        } else {
            if (price_max != "") {
                params = "p_max=" + price_max;
            }
        }
        if (query_string == "") {
            query_string = "?" + params;
        } else {
            query_string = query_string + "&" + params;
        }
        if (page == "profile") {
            query_string = query_string + "#products";
        }
        window.location.replace(current_url + query_string);
    }
});

$(document).on("change", "#select_sort_items", function () {
    var val = $(this).val();
    var query_string = $(this).attr('data-query-string');
    var current_url = $(this).attr('data-current-url');
    var page = $(this).attr('data-page');
    if (val == "most_recent" || val == "lowest_price" || val == "highest_price") {
        var params = "sort=" + val;
        if (query_string == "") {
            query_string = "?" + params;
        } else {
            query_string = query_string + "&" + params;
        }
    }
    if (page == "profile") {
        query_string = query_string + "#products";
    }
    window.location.replace(current_url + query_string);
});

$(document).on("click", "#btn_search_vendor", function () {
    var val = $('#input_search_vendor').val();
    if (val != "") {
        var query_string = $(this).attr('data-query-string');
        var current_url = $(this).attr('data-current-url');
        var params = "search=" + val;
        if (query_string == "") {
            query_string = "?" + params;
        } else {
            query_string = query_string + "&" + params;
        }
        window.location.replace(current_url + query_string + "#products");
    }
});
$("#input_search_vendor").keyup(function (event) {
    if (event.keyCode === 13) {
        $("#btn_search_vendor").click();
    }
});

//set site language
function set_site_language(lang_id) {
    var data = {
        "lang_id": lang_id,
        "sys_lang_id": mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $.ajax({
        method: "POST",
        url: mds_config.base_url + "home_controller/set_site_language",
        data: data
    })
        .done(function (response) {
            location.reload();
        })
}


//load more posts
function load_more_promoted_products() {
    $("#load_promoted_spinner").show();
    var data = {
        'offset': parseInt($("#promoted_products_offset").val()),
        'sys_lang_id': mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: mds_config.base_url + "home_controller/load_more_promoted_products",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                setTimeout(function () {
                    $("#promoted_products_offset").val(obj.offset);
                    $("#row_promoted_products").append(obj.html_content);
                    $("#load_promoted_spinner").hide();
                    if (obj.hide_button) {
                        $(".promoted-load-more-container").hide();
                    }
                }, 300);
            } else {
                setTimeout(function () {
                    $("#load_promoted_spinner").hide();
                    if (obj.hide_button) {
                        $(".promoted-load-more-container").hide();
                    }
                }, 300);
            }
        }
    });
}

//send message
$("#form_send_message").submit(function (event) {
    event.preventDefault();
    var message_subject = $('#message_subject').val();
    var message_text = $('#message_text').val();
    var message_receiver_id = $('#message_receiver_id').val();
    var message_send_em = $('#message_send_em').val();

    if (message_subject.length < 1) {
        $('#message_subject').addClass("is-invalid");
        return false;
    } else {
        $('#message_subject').removeClass("is-invalid");
    }
    if (message_text.length < 1) {
        $('#message_text').addClass("is-invalid");
        return false;
    } else {
        $('#message_text').removeClass("is-invalid");
    }
    var $form = $(this);
    var $inputs = $form.find("input, select, button, textarea");
    var serializedData = $form.serializeArray();
    serializedData.push({name: mds_config.csfr_token_name, value: $.cookie(mds_config.csfr_cookie_name)});
    serializedData.push({name: "sys_lang_id", value: mds_config.sys_lang_id});
    $inputs.prop("disabled", true);
    $.ajax({
        url: mds_config.base_url + "message_controller/add_conversation",
        type: "post",
        data: serializedData,
        success: function (response) {
            $inputs.prop("disabled", false);
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("send-message-result").innerHTML = obj.html_content;
                $("#form_send_message")[0].reset();
            }
            //send email
            if (message_send_em == 1) {
                send_message_as_email(obj.sender_id, message_receiver_id, message_subject, message_text);
            }
        }
    });
});

function send_message_as_email(message_sender_id, message_receiver_id, message_subject, message_text) {
    var data = {
        'email_type': 'new_message',
        'sender_id': message_sender_id,
        "receiver_id": message_receiver_id,
        "message_subject": message_subject,
        "message_text": message_text,
        "sys_lang_id": mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: mds_config.base_url + "ajax_controller/send_email",
        data: data,
        success: function (response) {
        }
    });
}

function get_states(val, map, id_suffix = "") {
    if (id_suffix != "") {
        id_suffix = '_' + id_suffix;
    }
    $('#select_states' + id_suffix).children('option').remove();
    $('#get_states_container' + id_suffix).hide();
    if ($('#select_cities' + id_suffix).length) {
        $('#select_cities' + id_suffix).children('option').remove();
        $('#get_cities_container' + id_suffix).hide();
    }
    var data = {
        "country_id": val,
        "sys_lang_id": mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: mds_config.base_url + "ajax_controller/get_states",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("select_states" + id_suffix).innerHTML = obj.content;
                $('#get_states_container' + id_suffix).show();
            } else {
                document.getElementById("select_states" + id_suffix).innerHTML = "";
                $('#get_states_container' + id_suffix).hide();
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
        "sys_lang_id": mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: mds_config.base_url + "ajax_controller/get_cities",
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


$(document).on('change', '#address_input', function () {
    update_product_map();
});
$(document).on('change', '#zip_code_input', function () {
    update_product_map();
});

$(document).on('click', '.btn-add-remove-wishlist', function () {
    var product_id = $(this).attr("data-product-id");
    var reload_page = $(this).attr("data-reload");
    if (reload_page == "0") {
        if ($(this).find("i").hasClass("icon-heart-o")) {
            $(this).find("i").removeClass("icon-heart-o");
            $(this).find("i").addClass("icon-heart");
        } else {
            $(this).find("i").removeClass("icon-heart");
            $(this).find("i").addClass("icon-heart-o");
        }
    }
    var data = {
        "product_id": product_id,
        "sys_lang_id": mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: mds_config.base_url + "add-remove-wishlist-post",
        data: data,
        success: function (response) {
            if (reload_page == "1") {
                location.reload();
            }
        }
    });
});

$(document).on('click', '.btn-item-add-to-cart', function () {
    var product_id = $(this).attr("data-product-id");
    var data = {
        "product_id": product_id,
        "is_ajax": true,
        "sys_lang_id": mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: mds_config.base_url + "cart_controller/add_to_cart",
        data: data,
        success: function (response) {
            setTimeout(function () {
                window.location.href = mds_config.lang_base_url + mds_config.cart_route;
            }, 100);
        }
    });
});

$("#form_validate").submit(function () {
    $('.custom-control-validate-input').removeClass('custom-control-validate-error');
    setTimeout(function () {
        $('.custom-control-validate-input .error').each(function () {
            var name = $(this).attr('name');
            if ($(this).is(":visible")) {
                name = name.replace('[]', '');
                $('.label_validate_' + name).addClass('custom-control-validate-error');
            }
        });
    }, 100);
});

$('.custom-control-validate-input input').click(function () {
    var name = $(this).attr('name');
    name = name.replace('[]', '');
    $('.label_validate_' + name).removeClass('custom-control-validate-error');
});

//hide cookies warning
function hide_cookies_warning() {
    $(".cookies-warning").hide();
    var data = {
        "sys_lang_id": mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: mds_config.base_url + "home_controller/cookies_warning",
        data: data,
        success: function (response) {
        }
    });
}

$(document).ready(function () {
    if ($(".validate-form").length > 0) {
        $('.validate-form').each(function (i, obj) {
            var id = $(this).attr('id');
            $("#" + id).validate();
        });
    }
});
//validate select2
$(".validate-form").submit(function () {
    $('.select2-req').each(function (i, obj) {
        var id = $(this).attr('id');
        var val = $(this).val();
        if (val == "" || val == null || val == undefined) {
            $('.select2-selection[aria-controls="select2-' + id + '-container"]').addClass('error');
        } else {
            $('.select2-selection[aria-controls="select2-' + id + '-container"]').removeClass('error');
        }
    });
});
$(document).on('change', '.select2-req', function () {
    var id = $(this).attr('id');
    if ($('.select2-selection[aria-controls="select2-' + id + '-container"]').hasClass("error")) {
        $('.select2-selection[aria-controls="select2-' + id + '-container"]').removeClass('error');
    }
});

$("#form_validate").validate();
$("#form_validate_search").validate();
$("#form_validate_search_mobile").validate();
$("#form_validate_newsletter").validate();
$("#form_add_cart").validate();
$("#form_validate_checkout").validate();
//validate product variations
$("#form_add_cart").submit(function () {
    $('#form_add_cart .custom-control-variation input').each(function () {
        if ($(this).hasClass('error')) {
            var id = $(this).attr('id');
            $('#form_add_cart .custom-control-variation label').each(function () {
                if ($(this).attr('for') == id) {
                    $(this).addClass('is-invalid');
                }
            });
        } else {
            var id = $(this).attr('id');
            $('#form_add_cart .custom-control-variation label').each(function () {
                if ($(this).attr('for') == id) {
                    $(this).removeClass('is-invalid');
                }
            });
        }
    });
});

$(document).on('click', '.custom-control-variation input', function () {
    var name = $(this).attr('name');
    $('.custom-control-variation label').each(function () {
        if ($(this).attr('data-input-name') == name) {
            $(this).removeClass('is-invalid');
        }
    });
});

$(document).ready(function () {
    $('.validate_terms').submit(function (e) {
        $('.custom-control-validate-input p').remove();
        if (!$('.custom-control-validate-input input').is(":checked")) {
            e.preventDefault();
            $('.custom-control-validate-input').addClass('custom-control-validate-error');
            $('.custom-control-validate-input').append("<p class='text-danger'>" + mds_config.msg_accept_terms + "</p>");
        } else {
            $('.custom-control-validate-input').removeClass('custom-control-validate-error');
        }
    });
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
            if (val != '') {
                val = val.replace(',', '.');
                if ($.isNumeric(val) && val != 0) {
                    $(this).removeClass('is-invalid');
                } else {
                    e.preventDefault();
                    $(this).addClass('is-invalid');
                    $(this).focus();
                }
            }
        });
    });
});

$(document).on("input keyup paste change keypress", ".price-input", function () {
    if (typeof mds_config.thousands_separator == 'undefined') {
        mds_config.thousands_separator = '.';
    }
    if (mds_config.thousands_separator == '.') {
        var $this = $(this);
        if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
            ((event.which < 48 || event.which > 57) &&
                (event.which != 0 && event.which != 8))) {
            event.preventDefault();
        }
        var text = $(this).val();
        if ((text.indexOf('.') != -1) &&
            (text.substring(text.indexOf('.')).length > 2) &&
            (event.which != 0 && event.which != 8) &&
            ($(this)[0].selectionStart >= text.length - 2)) {
            event.preventDefault();
        }
    } else {
        var $this = $(this);
        if ((event.which != 44 || $this.val().indexOf(',') != -1) &&
            ((event.which < 48 || event.which > 57) &&
                (event.which != 0 && event.which != 8))) {
            event.preventDefault();
        }
        var text = $(this).val();
        if ((text.indexOf(',') != -1) &&
            (text.substring(text.indexOf(',')).length > 2) &&
            (event.which != 0 && event.which != 8) &&
            ($(this)[0].selectionStart >= text.length - 2)) {
            event.preventDefault();
        }
    }
});

//full screen
$(document).ready(function () {
    $("iframe").attr("allowfullscreen", "")
});

//delete quote request
function delete_quote_request(id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [mds_config.sweetalert_cancel, mds_config.sweetalert_ok],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var data = {
                "id": id,
                "sys_lang_id": mds_config.sys_lang_id
            };
            data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: mds_config.base_url + "bidding_controller/delete_quote_request",
                data: data,
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
}

function get_product_shipping_cost(val, product_id) {
    $("#product_shipping_cost_container").empty();
    $(".product-shipping-loader").show();
    var data = {
        "state_id": val,
        "product_id": product_id,
        "sys_lang_id": mds_config.sys_lang_id
    };
    data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: mds_config.base_url + "ajax_controller/get_product_shipping_cost",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                setTimeout(function () {
                    document.getElementById("product_shipping_cost_container").innerHTML = obj.response;
                    $(".product-shipping-loader").hide();
                }, 300);
            }
        }
    });
}

function delete_shipping_address(id, message) {
    swal({
        text: message,
        icon: "warning",
        buttons: [mds_config.sweetalert_cancel, mds_config.sweetalert_ok],
        dangerMode: true,
    }).then(function (willDelete) {
        if (willDelete) {
            var data = {
                "id": id,
                "sys_lang_id": mds_config.sys_lang_id
            };
            data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: mds_config.base_url + "profile_controller/delete_shipping_address_post",
                data: data,
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
}


$(document).on("change", ".input-show-selected", function () {
    var id = $(this).attr("data-id");
    var val = $(this).val();
    $("#" + id).html(val.replace(/.*[\/\\]/, ''));
});

if ($('.fb-comments').length > 0) {
    $(".fb-comments").attr("data-href", window.location.href);
}
if ($('.post-text-responsive').length > 0) {
    $(function () {
        $('.post-text-responsive iframe').wrap('<div class="embed-responsive embed-responsive-16by9"></div>');
        $('.post-text-responsive iframe').addClass('embed-responsive-item');
    });
}

//load product shop location map
function load_product_shop_location_map() {
    var address = $("#span_shop_location_address").text();
    document.getElementById("iframe_shop_location_address").setAttribute("src", "https://maps.google.com/maps?width=100%&height=600&hl=en&q=" + address + "&ie=UTF8&t=&z=8&iwloc=B&output=embed&disableDefaultUI=true");
}

//player modal preview
$('#productVideoModal').on('hidden.bs.modal', function (e) {
    $(this).find('video')[0].pause();
});
$('#productAudioModal').on('hidden.bs.modal', function (e) {
    Amplitude.pause();
});

//payment completed circle
$(document).ready(function () {
    $('.circle-loader').toggleClass('load-complete');
    $('.checkmark').toggle();
});

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});
