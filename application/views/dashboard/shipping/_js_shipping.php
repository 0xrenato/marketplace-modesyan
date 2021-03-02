<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script>
    var array_regions = [];
    //select continen
    $(document).on("change", "#select_continents", function () {
        $("#btn_select_region_container").show();
        get_countries_by_continent($(this).val(), "<?= trans("all_countries"); ?>");
        if ($(this).val() != '' && $(this).val() != 0) {
            $("#form_group_countries").show();
        } else {
            $("#form_group_countries").hide();
        }
    });
    //select country
    $(document).on("change", "#select_countries", function () {
        get_states_by_country($(this).val(), "<?= trans("all_states"); ?>");
        $("#form_group_states").show();
    });
    //select region
    $(document).on("click", "#btn_select_region", function () {
        var continent = $('#select_continents').val();
        var continent_text = $('#select_continents option:selected').text();
        var country = $('#select_countries').val();
        var country_text = $('#select_countries option:selected').text();
        var state = $('#select_states').val();
        var state_text = $('#select_states option:selected').text();

        var region_id = state;
        var region_text = country_text + '/' + state_text;
        var input_name = 'state';
        if (region_id == '' || region_id == 0 || region_id == null) {
            region_id = country;
            region_text = country_text;
            input_name = 'country';
        }
        if (region_id == '' || region_id == 0 || region_id == null) {
            region_id = continent;
            region_text = continent_text;
            input_name = 'continent';
        }
        if (region_id) {
            if (array_regions.indexOf(input_name + '-' + region_id) === -1) {
                array_regions.push(input_name + '-' + region_id);
                $("#selected_regions_container").append('<div class="region">' + region_text + '<a href="javascript:void(0)"><i class="fa fa-times"></i></a><input type="hidden" value="' + region_id + '" name="' + input_name + '[]"></div>');
            }
        }

        //reset
        $('#select_continents').val(null).trigger('change');
        $('#select_countries option').remove();
        $('#select_states option').remove();
        $('#select_countries').hide();
        $('#form_group_states').hide();
    });
    //delete location
    $(document).on("click", ".region a", function () {
        $(this).parent().remove();
    });

    //delete location database
    function delete_shipping_location(id) {
        var data = {
            "id": id
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "dashboard_controller/delete_shipping_location_post",
            data: data,
            success: function (response) {
            }
        });
    }

    //shipping methods
    $(document).on("click", "#btn_select_shipping_method", function () {
        var data = {
            "selected_option": $('#select_shipping_methods').val()
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "dashboard_controller/select_shipping_method",
            data: data,
            success: function (response) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    $("#selected_shipping_methods").append(obj.html_content);
                }
            }
        });
    });

    //delete shipping method
    $(document).on("click", ".btn-delete-shipping-method", function () {
        var id = $(this).attr('data-id');
        $("#row_shipping_method_" + id).remove();
    });

    //delete shipping method database
    function delete_shipping_method(id, message) {
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
                    url: base_url + "dashboard_controller/delete_shipping_method_post",
                    data: data,
                    success: function (response) {
                        $("#row_shipping_method_" + id).remove();
                    }
                });
            }
        });
    }
</script>
