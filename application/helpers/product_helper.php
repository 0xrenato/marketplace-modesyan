<?php defined('BASEPATH') or exit('No direct script access allowed');

//get product title
if (!function_exists('get_product_title')) {
    function get_product_title($product)
    {
        if (!empty($product)) {
            if (!empty($product->title)) {
                return $product->title;
            } elseif (!empty($product->second_title)) {
                return $product->second_title;
            }
        }
        return "";
    }
}

//get available product
if (!function_exists('get_active_product')) {
    function get_active_product($id)
    {
        $ci =& get_instance();
        return $ci->product_model->get_active_product($id);
    }
}

//get product details
if (!function_exists('get_product_details')) {
    function get_product_details($id, $lang_id, $get_main_on_null = true)
    {
        $ci =& get_instance();
        return $ci->product_model->get_product_details($id, $lang_id, $get_main_on_null);
    }
}

//product location cache key
if (!function_exists('get_location_cache_key')) {
    function get_location_cache_key($ci)
    {
        $key = "";
        if (!empty($ci->default_location->country_id)) {
            $key .= $ci->default_location->country_id;
        }
        if (!empty($ci->default_location->state_id)) {
            $key .= "_" . $ci->default_location->state_id;
        }
        if (!empty($ci->default_location->city_id)) {
            $key .= "_" . $ci->default_location->city_id;
        }
        if (empty($key)) {
            $key = "1";
        }
        $key = trim($key);
        return $key;
    }
}

//get parent categories
if (!function_exists('get_parent_categories')) {
    function get_parent_categories()
    {
        $ci =& get_instance();
        if (!empty($ci->categories_array)) {
            if (isset($ci->categories_array[0])) {
                return $ci->categories_array[0];
            }
        }
        return null;
    }
}

//get subcategories
if (!function_exists('get_subcategories')) {
    function get_subcategories($parent_id)
    {
        $ci =& get_instance();
        return $ci->category_model->get_subcategories($parent_id);
    }
}

//get categories json
if (!function_exists('get_categories_json')) {
    function get_categories_json($lang_id)
    {
        $ci =& get_instance();
        return $ci->category_model->get_categories_json($lang_id);
    }
}

if (!function_exists('get_category_by_id')) {
    function get_category_by_id($id)
    {
        $ci =& get_instance();
        return $ci->category_model->get_category($id);
    }
}

//get category name
if (!function_exists('category_name')) {
    function category_name($category)
    {
        if (!empty($category)) {
            if (!empty($category->name)) {
                return html_escape($category->name);
            } else {
                if (!empty($category->second_name)) {
                    return html_escape($category->second_name);
                }
            }
        }
        return "";
    }
}

//get category image url
if (!function_exists('get_category_image_url')) {
    function get_category_image_url($category)
    {
        if ($category->storage == "aws_s3") {
            $ci =& get_instance();
            return $ci->aws_base_url . $category->image;
        } else {
            return base_url() . $category->image;
        }
    }
}

//get parent categories tree
if (!function_exists('get_parent_categories_tree')) {
    function get_parent_categories_tree($category, $only_visible = true)
    {
        $ci =& get_instance();
        return $ci->category_model->get_parent_categories_tree($category, $only_visible);
    }
}

if (!function_exists('get_ids_from_array')) {
    function get_ids_from_array($array, $column = 'id')
    {
        if (!empty($array)) {
            return get_array_column_values($array, $column);
        }
        return array();
    }
}

//generate ids string
if (!function_exists('generate_ids_string')) {
    function generate_ids_string($array)
    {
        if (empty($array)) {
            return "0";
        } else {
            return implode(',', $array);
        }
    }
}
//product form data
if (!function_exists('get_product_form_data')) {
    function get_product_form_data($product)
    {
        $ci =& get_instance();
        $data = new stdClass();
        $data->add_to_cart_url = "";
        $data->button = "";

        if (!empty($product)) {
            $disabled = "";
            if (!check_product_stock($product)) {
                $disabled = " disabled";
            }
            if ($product->listing_type == 'sell_on_site' || $product->listing_type == 'license_key') {
                if ($product->is_free_product != 1) {
                    $data->add_to_cart_url = base_url() . 'add-to-cart';
                    $data->button = '<button class="btn btn-md btn-block btn-product-cart"' . $disabled . '><i class="icon-cart-solid"></i>' . trans("add_to_cart") . '</button>';
                }
            } elseif ($product->listing_type == 'bidding') {
                $data->add_to_cart_url = base_url() . 'request-quote';
                $data->button = '<button class="btn btn-md btn-block btn-product-cart"' . $disabled . '>' . trans("request_a_quote") . '</button>';
                if (!$ci->auth_check && $product->listing_type == 'bidding') {
                    $data->button = '<button type="button" data-toggle="modal" data-target="#loginModal" class="btn btn-md btn-block btn-product-cart"' . $disabled . '>' . trans("request_a_quote") . '</button>';
                }
            } else {
                if ($ci->auth_check) {
                    $data->button = '<button type="button" class="btn btn-md btn-block btn-product-cart" data-toggle="modal" data-target="#messageModal">' . trans("contact_seller") . '</button>';
                } else {
                    $data->button = '<button type="button" class="btn btn-md btn-block btn-product-cart" data-toggle="modal" data-target="#loginModal">' . trans("contact_seller") . '</button>';
                }
                if (!empty($product->external_link)) {
                    $data->button = '<a href="' . $product->external_link . '" class="btn btn-md btn-block" target="_blank" rel="nofollow">' . trans("buy_now") . '</a>';
                }
            }
        }
        return $data;
    }
}

//get product item image
if (!function_exists('get_product_item_image')) {
    function get_product_item_image($product, $get_second = false)
    {
        $ci =& get_instance();
        if (!empty($product)) {
            $image = $product->image;
            if (!empty($product->image_second) && $get_second == true) {
                $image = $product->image_second;
            }
            if (!empty($image)) {
                $image_array = explode("::", $image);
                if (!empty($image_array[0]) && !empty($image_array[1])) {
                    if ($image_array[0] == "aws_s3") {
                        return $ci->aws_base_url . "uploads/images/" . $image_array[1];
                    } else {
                        return base_url() . "uploads/images/" . $image_array[1];
                    }
                }
            }
        }
        return base_url() . 'assets/img/no-image.jpg';
    }
}

//get index categories products
if (!function_exists('get_index_categories_products')) {
    function get_index_categories_products($ci, $categories)
    {
        return $ci->product_model->get_index_categories_products($categories);
    }
}

//is product in wishlist
if (!function_exists('is_product_in_wishlist')) {
    function is_product_in_wishlist($product)
    {
        $ci =& get_instance();
        if ($ci->auth_check) {
            if (!empty($product->is_in_wishlist)) {
                return true;
            }
        } else {
            $wishlist = $ci->session->userdata('mds_guest_wishlist');
            if (!empty($wishlist)) {
                if (in_array($product->id, $wishlist)) {
                    return true;
                }
            }
        }
        return false;
    }
}

//get currency by code
if (!function_exists('get_currency_by_code')) {
    function get_currency_by_code($currency_code)
    {
        $ci =& get_instance();
        if (!empty($ci->currencies[$currency_code])) {
            return $ci->currencies[$currency_code];
        }
    }
}

//get currency symbol
if (!function_exists('get_currency_symbol')) {
    function get_currency_symbol($currency_code)
    {
        $ci =& get_instance();
        if (!empty($ci->currencies)) {
            if (isset($ci->currencies[$currency_code])) {
                return $ci->currencies[$currency_code]->symbol;
            }
        }
        return "";
    }
}

//calculate product price
if (!function_exists('calculate_product_price')) {
    function calculate_product_price($price, $discount_rate)
    {
        if (!empty($price)) {
            $price = $price / 100;
            if (!empty($discount_rate)) {
                $price = $price - (($price * $discount_rate) / 100);
            }
            $price = number_format($price, 2, ".", "");
            $price = $price * 100;
            return $price;
        }
        return 0;
    }
}

//calculate product vat
if (!function_exists('calculate_product_vat')) {
    function calculate_product_vat($product)
    {
        if (!empty($product)) {
            if (!empty($product->vat_rate)) {
                $price = calculate_product_price($product->price, $product->discount_rate);
                return ($price * $product->vat_rate) / 100;
            }
        }
        return 0;
    }
}

//calculate earned amount
if (!function_exists('calculate_earned_amount')) {
    function calculate_earned_amount($product)
    {
        $ci =& get_instance();
        if (!empty($product)) {
            $price = calculate_product_price($product->price, $product->discount_rate) + calculate_product_vat($product);
            return $price - (($price * $ci->general_settings->commission_rate) / 100);
        }
        return 0;
    }
}

//price formatted
if (!function_exists('price_formatted')) {
    function price_formatted($price, $currency_code, $convert_currency = false)
    {
        $ci =& get_instance();
        $price = $price / 100;
        //convert currency
        if ($ci->payment_settings->currency_converter == 1 && $convert_currency == true) {
            $rate = 1;
            if (isset($ci->selected_currency) && isset($ci->selected_currency->exchange_rate)) {
                $rate = $ci->selected_currency->exchange_rate;
                $price = $price * $rate;
                $currency_code = $ci->selected_currency->code;
            }
        }

        $dec_point = '.';
        $thousands_sep = ',';
        if (isset($ci->currencies[$currency_code]) && $ci->currencies[$currency_code]->currency_format != 'us') {
            $dec_point = ',';
            $thousands_sep = '.';
        }

        if (filter_var($price, FILTER_VALIDATE_INT) !== false) {
            $price = number_format($price, 0, $dec_point, $thousands_sep);
        } else {
            $price = number_format($price, 2, $dec_point, $thousands_sep);
        }
        $price = price_currency_format($price, $currency_code);
        return $price;
    }
}

//price cart
if (!function_exists('price_decimal')) {
    function price_decimal($price, $currency_code, $convert_currency = false)
    {
        $ci =& get_instance();
        //convert currency
        if ($ci->payment_settings->currency_converter == 1 && $convert_currency == true) {
            $rate = 1;
            if (isset($ci->selected_currency) && isset($ci->selected_currency->exchange_rate)) {
                $rate = $ci->selected_currency->exchange_rate;
                $price = $price * $rate;
                $currency_code = $ci->selected_currency->code;
            }
        }

        $dec_point = '.';
        $thousands_sep = ',';
        if (isset($ci->currencies[$currency_code]) && $ci->currencies[$currency_code]->currency_format != 'us') {
            $dec_point = ',';
            $thousands_sep = '.';
        }
        if (strpos($price, '.00') !== false) {
            $price = str_replace('.00', '', $price);
        }
        if (filter_var($price, FILTER_VALIDATE_INT) !== false) {
            $price = number_format($price, 0, $dec_point, $thousands_sep);
        } else {
            $price = number_format($price, 2, $dec_point, $thousands_sep);
        }
        $price = price_currency_format($price, $currency_code);
        return $price;
    }
}

//price currency format
if (!function_exists('price_currency_format')) {
    function price_currency_format($price, $currency_code)
    {
        $ci =& get_instance();
        if (isset($ci->currencies[$currency_code])) {
            $currency = $ci->currencies[$currency_code];
            $space = "";
            if ($currency->space_money_symbol == 1) {
                $space = " ";
            }
            if ($currency->symbol_direction == "left") {
                $price = "<span>" . $currency->symbol . "</span>" . $space . $price;
            } else {
                $price = $price . $space . "<span>" . $currency->symbol . "</span>";
            }
        }
        return $price;
    }
}

//get price
if (!function_exists('get_price')) {
    function get_price($price, $format_type)
    {
        $ci =& get_instance();
        if ($format_type == "input") {
            $price = $price / 100;
            if (filter_var($price, FILTER_VALIDATE_INT) !== false) {
                $price = number_format($price, 0, ".", "");
            } else {
                $price = number_format($price, 2, ".", "");
            }
            if ($ci->thousands_separator == ',') {
                $price = str_replace('.', ',', $price);
            }
            return $price;
        } elseif ($format_type == "decimal") {
            $price = $price / 100;
            if (filter_var($price, FILTER_VALIDATE_INT) !== false) {
                return number_format($price, 0, ".", "");
            } else {
                return number_format($price, 2, ".", "");
            }
        } elseif ($format_type == "database") {
            $price = str_replace(',', '.', $price);
            $price = floatval($price);
            $price = number_format($price, 2, '.', '') * 100;
            return $price;
        } elseif ($format_type == "separator_format") {
            $price = $price / 100;
            $dec_point = '.';
            $thousands_sep = ',';
            if ($ci->thousands_separator != '.') {
                $dec_point = ',';
                $thousands_sep = '.';
            }
            return number_format($price, 2, $dec_point, $thousands_sep);
        }
    }
}

//convert currency for payments in the cart
if (!function_exists('convert_currency_by_exchange_rate')) {
    function convert_currency_by_exchange_rate($amount, $exchange_rate)
    {
        $ci =& get_instance();
        if ($amount <= 0) {
            return 0;
        }
        if (empty($exchange_rate)) {
            $exchange_rate = 1;
        }
        if ($ci->payment_settings->currency_converter == 1) {
            $amount = $amount * $exchange_rate;
            if (filter_var($amount, FILTER_VALIDATE_INT) !== false) {
                $amount = number_format($amount, 0, ".", "");
            } else {
                $amount = number_format($amount, 2, ".", "");
            }
        }
        return $amount;
    }
}

//get variation label
if (!function_exists('get_variation_label')) {
    function get_variation_label($label_array, $lang_id)
    {
        $ci =& get_instance();
        $label = "";
        if (!empty($label_array)) {
            $label_array = unserialize_data($label_array);
            foreach ($label_array as $item) {
                if ($lang_id == $item['lang_id']) {
                    $label = $item['label'];
                    break;
                }
            }
            if (empty($label)) {
                foreach ($label_array as $item) {
                    if ($ci->general_settings->site_lang == $item['lang_id']) {
                        $label = $item['label'];
                        break;
                    }
                }
            }
        }
        return $label;
    }
}

//get variation option name
if (!function_exists('get_variation_option_name')) {
    function get_variation_option_name($names_array, $lang_id)
    {
        $ci =& get_instance();
        $name = "";
        if (!empty($names_array)) {
            $names_array = unserialize_data($names_array);
            foreach ($names_array as $item) {
                if ($lang_id == $item['lang_id']) {
                    $name = $item['option_name'];
                    break;
                }
            }
            if (empty($name)) {
                foreach ($names_array as $item) {
                    if ($ci->general_settings->site_lang == $item['lang_id']) {
                        $name = $item['option_name'];
                        break;
                    }
                }
            }
        }
        return $name;
    }
}

//get variation default option
if (!function_exists('get_variation_default_option')) {
    function get_variation_default_option($variation_id)
    {
        $ci =& get_instance();
        return $ci->variation_model->get_variation_default_option($variation_id);
    }
}

//get variation sub options
if (!function_exists('get_variation_sub_options')) {
    function get_variation_sub_options($parent_id)
    {
        $ci =& get_instance();
        return $ci->variation_model->get_variation_sub_options($parent_id);
    }
}

//is there variation uses different price
if (!function_exists('is_there_variation_uses_different_price')) {
    function is_there_variation_uses_different_price($product_id, $except_id = null)
    {
        $ci =& get_instance();
        return $ci->variation_model->is_there_variation_uses_different_price($product_id, $except_id);
    }
}

//discount rate format
if (!function_exists('discount_rate_format')) {
    function discount_rate_format($discount_rate)
    {
        return $discount_rate . "%";
    }
}

//check product stock
if (!function_exists('check_product_stock')) {
    function check_product_stock($product)
    {
        if (!empty($product)) {
            if ($product->product_type == 'digital') {
                return true;
            }
            if ($product->stock > 0) {
                return true;
            }
        }
        return false;
    }
}

//get product stock status
if (!function_exists('get_product_stock_status')) {
    function get_product_stock_status($product)
    {
        if (!empty($product)) {
            if ($product->product_type == 'digital') {
                return '<span class="text-success">' . trans("in_stock") . '</span>';
            } elseif ($product->listing_type == 'ordinary_listing') {
                if ($product->is_sold == 1) {
                    return '<span class="text-danger">' . trans("sold") . '</span>';
                } else {
                    return '<span class="text-success">' . trans("active") . '</span>';
                }
            } else {
                if ($product->stock < 1) {
                    return '<span class="text-danger">' . trans("out_of_stock") . '</span>';
                } else {
                    return '<span class="text-success">' . trans("in_stock") . " (" . $product->stock . ")" . '</span>';
                }
            }
        }
        return "";
    }
}

//get query string array
if (!function_exists('get_query_string_array')) {
    function get_query_string_array($custom_filters = null)
    {
        $array_filter_keys = array();
        if ($custom_filters != null) {
            $array_filter_keys = get_array_column_values($custom_filters, 'product_filter_key');
        }
        array_push($array_filter_keys, "p_min");
        array_push($array_filter_keys, "p_max");
        array_push($array_filter_keys, "product_type");
        array_push($array_filter_keys, "sort");
        array_push($array_filter_keys, "search");
        array_push($array_filter_keys, "p_cat");

        $queries = array();
        $array_queries = array();
        $str = $_SERVER["QUERY_STRING"];
        $str = str_replace('<', '', $str);
        $str = str_replace('>', '', $str);
        $str = str_replace('*', '', $str);
        $str = str_replace('"', '', $str);
        $str = str_replace('(', '', $str);
        $str = str_replace(')', '', $str);
        @parse_str($str, $queries);
        if (!empty($queries)) {
            foreach ($queries as $key => $value) {
                if (in_array($key, $array_filter_keys)) {
                    $key = str_slug($key);
                    $array_values = explode(',', $value);
                    for ($i = 0; $i < item_count($array_values); $i++) {
                        $array_values[$i] = remove_forbidden_characters($array_values[$i]);
                    }
                    $array_queries[$key] = $array_values;
                }
            }
        }
        return $array_queries;
    }
}

//generate filter url
if (!function_exists('generate_filter_url')) {
    function generate_filter_url($query_string_array, $key, $value)
    {
        $key = str_slug($key);
        $query = "";
        if (!empty($key) && $key != "rmv_prc" && $key != "rmv_psrc" && $key != "rmv_srt" && $key != "rmv_p_cat") {
            if (empty($query_string_array) || !is_array($query_string_array)) {
                return "?" . $key . "=" . @urlencode($value);
            }

            //add remove the key value
            if (!empty($query_string_array[$key])) {
                if ($key == "sort") {
                    $query_string_array[$key] = [$value];
                }
                if ($key == "p_cat") {
                    $query_string_array[$key] = [$value];
                } else {
                    if (in_array($value, $query_string_array[$key])) {
                        $new_array = array();
                        foreach ($query_string_array[$key] as $item) {
                            if (!empty($item) && $item != $value) {
                                $new_array[] = $item;
                            }
                        }
                        $query_string_array[$key] = $new_array;
                    } else {
                        $query_string_array[$key][] = $value;
                    }
                }
            } else {
                $query_string_array[$key][] = $value;
            }
        }

        //generate query string
        $i = 0;
        foreach ($query_string_array as $array_key => $array_values) {
            $add_keys = true;
            if ($key == "rmv_prc" && ($array_key == "p_min" || $array_key == "p_max")) {
                $add_keys = false;
            }
            if ($key == "rmv_psrc" && ($array_key == "search")) {
                $add_keys = false;
            }
            if ($key == "rmv_srt" && ($array_key == "sort")) {
                $add_keys = false;
            }
            if ($key == "rmv_p_cat" && ($array_key == "p_cat")) {
                $add_keys = false;
            }
            if ($add_keys && !empty($array_values)) {
                if ($i == 0) {
                    $query = "?" . generate_filter_string($array_key, $array_values);
                } else {
                    $query .= "&" . generate_filter_string($array_key, $array_values);
                }
                $i++;
            }
        }
        return $query;
    }
}

//generate filter string
if (!function_exists('generate_filter_string')) {
    function generate_filter_string($key, $array_values)
    {
        $str = "";
        $j = 0;
        if (!empty($array_values)) {
            foreach ($array_values as $value) {
                if (!empty($value) && !is_array($value)) {
                    $value = urlencode($value);
                    if ($j == 0) {
                        $str = $value;
                    } else {
                        $str .= "," . $value;
                    }
                    $j++;
                }
            }
            $str = $key . "=" . $str;
        }
        return $str;
    }
}

//get query string array to array of objects
if (!function_exists('convert_query_string_to_object_array')) {
    function convert_query_string_to_object_array($query_string_array)
    {
        $array = array();
        if (!empty($query_string_array)) {
            foreach ($query_string_array as $key => $array_values) {
                if (!empty($array_values)) {
                    foreach ($array_values as $value) {
                        $obj = new stdClass();
                        $obj->key = $key;
                        $obj->value = $value;
                        array_push($array, $obj);
                    }
                }
            }
        }
        return $array;
    }
}

//is custom field option selected
if (!function_exists('is_custom_field_option_selected')) {
    function is_custom_field_option_selected($query_string_object_array, $key, $value)
    {
        if (!empty($query_string_object_array)) {
            foreach ($query_string_object_array as $item) {
                if ($item->key == $key && $item->value == $value) {
                    return true;
                    break;
                }
            }
        }
        return false;
    }
}

//get product filter id by key
if (!function_exists('get_product_filter_id_by_key')) {
    function get_product_filter_id_by_key($custom_filters, $key)
    {
        if (!empty($custom_filters)) {
            foreach ($custom_filters as $item) {
                if ($item->product_filter_key == $key) {
                    return $item->id;
                    break;
                }
            }
        }
        return false;
    }
}

//get continents
if (!function_exists('get_continents')) {
    function get_continents()
    {
        return array('EU' => 'Europe', 'AS' => 'Asia', 'AF' => 'Africa', 'NA' => 'North America', 'SA' => 'South America', 'OC' => 'Oceania', 'AN' => 'Antarctica');
    }
}

//get continent name by key
if (!function_exists('get_continent_name_by_key')) {
    function get_continent_name_by_key($continent_key)
    {
        $continents = get_continents();
        if (!empty($continents)) {
            foreach ($continents as $key => $value) {
                if ($key == $continent_key) {
                    return $value;
                }
            }
        }
        return "";
    }
}

//get shipping methods
if (!function_exists('get_shipping_methods')) {
    function get_shipping_methods()
    {
        return array('flat_rate', 'local_pickup', 'free_shipping');
    }
}

//get shipping locations by zone
if (!function_exists('get_shipping_locations_by_zone')) {
    function get_shipping_locations_by_zone($zone_id)
    {
        $ci =& get_instance();
        return $ci->shipping_model->get_shipping_locations_by_zone($zone_id);
    }
}

//get shipping payment methods by zone
if (!function_exists('get_shipping_payment_methods_by_zone')) {
    function get_shipping_payment_methods_by_zone($zone_id)
    {
        $ci =& get_instance();
        return $ci->shipping_model->get_shipping_payment_methods_by_zone($zone_id);
    }
}

//parse shipping name array
if (!function_exists('parse_shipping_name_array')) {
    function parse_shipping_name_array($name_array, $lang_id)
    {
        $ci =& get_instance();
        if (!empty($name_array)) {
            $name_array = unserialize_data($name_array);
            if (!empty($name_array)) {
                foreach ($name_array as $item) {
                    if ($item['lang_id'] == $lang_id && !empty($item['method_name'])) {
                        return html_escape($item['method_name']);
                    }
                }
            }
            //if not exist
            if ($get_main_name == true) {
                if (!empty($name_array)) {
                    foreach ($name_array as $item) {
                        if ($item['lang_id'] == $ci->site_lang->id) {
                            return html_escape($item['name']);
                        }
                    }
                }
            }
        }
    }
}

//get shipping class cost by method
if (!function_exists('get_shipping_class_cost_by_method')) {
    function get_shipping_class_cost_by_method($cost_array, $class_id)
    {
        $ci =& get_instance();
        if (!empty($cost_array) && !empty($class_id)) {
            $shipping_class = $ci->shipping_model->get_shipping_class($class_id);
            if (!empty($shipping_class) && $shipping_class->status == 1) {
                $cost_array = unserialize_data($cost_array);
                if (!empty($cost_array)) {
                    foreach ($cost_array as $item) {
                        if ($item['class_id'] == $class_id && !empty($item['cost'])) {
                            return html_escape($item['cost']);
                        }
                    }
                }
            }
        }
    }
}
?>