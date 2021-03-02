<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shipping_model extends CI_Model
{
    /*
    *-------------------------------------------------------------------------------------------------
    * CART
    *-------------------------------------------------------------------------------------------------
    */

    //get seller shipping methods array
    public function get_seller_shipping_methods_array($cart_items, $state_id, $set_session = true)
    {
        //calculate total for each seller
        $seller_total = array();
        $seller_ids = array();
        if (!empty($cart_items)) {
            foreach ($cart_items as $item) {
                if ($item->product_type == "physical") {
                    if (!isset($seller_total[$item->seller_id])) {
                        $seller_total[$item->seller_id] = 0;
                    }
                    $seller_total[$item->seller_id] += $item->total_price;
                    if (!in_array($item->seller_id, $seller_ids)) {
                        array_push($seller_ids, $item->seller_id);
                    }
                }
            }
        }
        //get shipping methods by seller
        $seller_shipping_methods = array();
        $array_shipping_cost = array();
        if (!empty($seller_ids)) {
            foreach ($seller_ids as $seller_id) {
                $seller = get_user($seller_id);
                if (!empty($seller)) {
                    $item = new stdClass();
                    $item->shop_id = $seller->id;
                    $item->total_shipping_cost = 0;
                    $item->shop_name = get_shop_name($seller);
                    $item->methods = array();
                    $shipping_methods = $this->get_cart_shipping_methods($seller->id, $state_id);
                    if (!empty($shipping_methods)) {
                        foreach ($shipping_methods as $shipping_method) {
                            $method = new stdClass();
                            $method->id = $shipping_method->id;
                            $method->method_type = $shipping_method->method_type;
                            $method->name = @parse_serialized_name_array($shipping_method->name_array, $this->selected_lang->id);
                            $method->is_selected = 0;
                            $method->is_free_shipping = 0;
                            $method->free_shipping_min_amount = 0;
                            $method->cost = null;
                            //calculate shipping cost
                            $free_shipping_min_amount = get_price($shipping_method->free_shipping_min_amount, "decimal");
                            $local_pickup_cost = get_price($shipping_method->local_pickup_cost, "decimal");
                            if ($shipping_method->method_type == "free_shipping") {
                                if (isset($seller_total[$seller->id])) {
                                    $total = $seller_total[$seller->id];
                                    if ($total >= $free_shipping_min_amount) {
                                        $method->is_free_shipping = 1;
                                        $method->free_shipping_min_amount = $free_shipping_min_amount;
                                    }
                                }
                            } elseif ($shipping_method->method_type == "local_pickup") {
                                $method->cost = $local_pickup_cost;
                            } elseif ($shipping_method->method_type == "flat_rate") {
                                $method->cost = $this->get_flat_rate_cost($shipping_method, $cart_items, $seller_id);
                            }
                            if (!empty($method->cost)) {
                                $method->cost = number_format($method->cost, 2, ".", "");
                            }
                            //add shipping cost
                            $array_shipping_cost[$method->id] = $method->cost;
                            if ($set_session == true) {
                                $this->session->set_userdata('mds_array_shipping_cost', $array_shipping_cost);
                                $this->session->set_userdata('mds_array_cart_seller_ids', $seller_ids);
                            }
                            array_push($item->methods, $method);
                        }
                    }
                    array_push($seller_shipping_methods, $item);
                }
            }
        }
        //set selected shipping methods
        $total_shipping_cost = 0;
        if (!empty($seller_shipping_methods)) {
            foreach ($seller_shipping_methods as $item) {
                if (!empty($item->methods)) {
                    $i = 0;
                    foreach ($item->methods as $method) {
                        if ($i == 0) {
                            if ($method->method_type == "free_shipping") {
                                if ($method->is_free_shipping == 1) {
                                    $method->is_selected = 1;
                                    $i++;
                                }
                            } else {
                                $method->is_selected = 1;
                                $total_shipping_cost += $method->cost;
                                $i++;
                            }
                        }
                    }
                }
            }
        }
        return $seller_shipping_methods;
    }

    //get cart shipping methods
    public function get_cart_shipping_methods($seller_id, $state_id)
    {
        $continent_code = "";
        $country_id = "";

        //get the state
        $state = get_state($state_id);
        if (!empty($state)) {
            //get country
            $country = get_country($state->country_id);
            if (!empty($country)) {
                $country_id = $country->id;
                $continent_code = $country->continent_code;
            }
            //get shipping options by state
            $zone_locations = array();
            $zone_ids = array();
            if (!empty($state->id)) {
                $zone_locations = $this->db->where('state_id', clean_number($state->id))->where('user_id', clean_number($seller_id))->get('shipping_zone_locations')->result();
            }

            //get shipping options by country
            if (empty($zone_locations) && (!empty($country_id))) {
                $zone_locations = $this->db->where('country_id', clean_number($country_id))->where('state_id', 0)->where('user_id', clean_number($seller_id))->get('shipping_zone_locations')->result();
            }
            //get shipping options by continent
            if (empty($zone_locations) && (!empty($continent_code))) {
                $zone_locations = $this->db->where('continent_code', clean_str($continent_code))->where('country_id', 0)->where('state_id', 0)->where('user_id', clean_number($seller_id))->get('shipping_zone_locations')->result();
            }
            if (!empty($zone_locations)) {
                foreach ($zone_locations as $location) {
                    array_push($zone_ids, $location->zone_id);
                }
            }
            //get shipping methods
            if (!empty($zone_ids)) {
                return $this->db->where_in('zone_id', $zone_ids, FALSE)->where('user_id', clean_number($seller_id))->where('status', 1)->order_by("FIELD(method_type, 'free_shipping', 'local_pickup', 'flat_rate')")->get('shipping_zone_methods')->result();
            }
        }
        return array();
    }

    //calculate cart shipping total cost
    public function calculate_cart_shipping_total_cost()
    {
        $result = array(
            'is_valid' => 1,
            'total_cost' => 0
        );
        $array_shipping_cost = $this->session->userdata('mds_array_shipping_cost');
        $array_cart_seller_ids = $this->session->userdata('mds_array_cart_seller_ids');
        $array_seller_shipping_costs = array();
        $selected_shipping_method_ids = array();
        if (!empty($array_cart_seller_ids)) {
            foreach ($array_cart_seller_ids as $seller_id) {
                $method_id = $this->input->post("shipping_method_" . $seller_id, true);
                if (!empty($method_id)) {
                    if (!array_key_exists($method_id, $array_shipping_cost)) {
                        $result['is_valid'] = 0;
                    }
                    if (isset($array_shipping_cost[$method_id])) {
                        $cost = $array_shipping_cost[$method_id];
                        $result['total_cost'] += $cost;
                    }
                    array_push($selected_shipping_method_ids, $method_id);
                    $item = new stdClass();
                    $item->cost = $cost;
                    $item->shipping_method_id = $method_id;
                    $array_seller_shipping_costs[$seller_id] = $item;
                }
            }
        }
        $this->session->set_userdata('mds_selected_shipping_method_ids', $selected_shipping_method_ids);
        $this->session->set_userdata('mds_seller_shipping_costs', $array_seller_shipping_costs);
        return $result;
    }

    //get flat rate cost
    public function get_flat_rate_cost($shipping_method, $cart_items, $seller_id)
    {
        $total_cost = 0;
        if (!empty($shipping_method)) {
            $items = array();
            if (!empty($cart_items)) {
                foreach ($cart_items as $cart_item) {
                    if ($cart_item->seller_id == $seller_id && $cart_item->product_type == "physical") {
                        $cost = $shipping_method->flat_rate_cost;
                        if (!empty($cart_item->shipping_class_id)) {
                            $class_cost = get_shipping_class_cost_by_method($shipping_method->flat_rate_class_costs_array, $cart_item->shipping_class_id);
                            if (!empty($class_cost)) {
                                $cost = $class_cost;
                            }
                        }
                        if ($shipping_method->flat_rate_cost_calculation_type == "each_product") {
                            $total_cost += $cost * $cart_item->quantity;
                        } elseif ($shipping_method->flat_rate_cost_calculation_type == "each_different_product") {
                            $total_cost += $cost;
                        } elseif ($shipping_method->flat_rate_cost_calculation_type == "cart_total") {
                            if ($cost > $total_cost) {
                                $total_cost = $cost;
                            }
                        }
                    }
                }
            }
        }
        if (!empty($total_cost)) {
            $total_cost = get_price($total_cost, "decimal");
        }
        return $total_cost;
    }

    //get product shipping cost
    public function get_product_shipping_cost($state_id, $product_id)
    {
        $product = $this->product_model->get_product_by_id($product_id);
        if (!empty($product)) {
            $items = array();
            $item = new stdClass();
            $item->product_id = $product->id;
            $item->product_type = $product->product_type;
            $item->quantity = 1;
            $item->total_price = $product->price;
            $item->seller_id = $product->user_id;
            $item->shipping_class_id = $product->shipping_class_id;
            array_push($items, $item);
            $shipping_methods = $this->get_seller_shipping_methods_array($items, $state_id, false);

            $has_methods = false;
            if (!empty($shipping_methods)) {
                foreach ($shipping_methods as $shipping_method) {
                    if (!empty($shipping_method->methods) && item_count($shipping_method->methods) > 0) {
                        $has_methods = true;
                    }
                }
            }
            $response = "";
            if (!empty($shipping_methods)) {
                foreach ($shipping_methods as $shipping_method) {
                    if (!empty($shipping_method->methods)) {
                        foreach ($shipping_method->methods as $method) {
                            if ($method->method_type == "free_shipping") {
                                $response .= "<p><strong class='method-name'>" . $method->name . "</strong><strong>&nbsp(" . trans("minimum_order_amount") . ":&nbsp;" . price_decimal($method->free_shipping_min_amount, $this->selected_currency->code, true) . ")</strong></p>";
                            } else {
                                $response .= "<p><strong class='method-name'>" . $method->name . "</strong><strong>:&nbsp;" . price_decimal($method->cost, $this->selected_currency->code, true) . "</strong></p>";
                            }
                        }
                    }
                }
            }
            if (empty($response)) {
                $response = '<p class="text-muted">' . trans("product_does_not_ship_location") . '</p>';
            }
            $data = array(
                'result' => 1,
                'response' => $response
            );
            echo json_encode($data);
        }
    }

    /*
    *-------------------------------------------------------------------------------------------------
    * DASHBOARD
    *-------------------------------------------------------------------------------------------------
    */

    //add shipping zone
    public function add_shipping_zone()
    {
        $name_array = array();
        foreach ($this->languages as $language) {
            $item = array(
                'lang_id' => $language->id,
                'name' => $this->input->post('zone_name_lang_' . $language->id, true)
            );
            array_push($name_array, $item);
        }
        $data = array(
            'name_array' => serialize($name_array),
            'user_id' => $this->auth_user->id
        );
        if ($this->db->insert('shipping_zones', $data)) {
            $zone_id = $this->db->insert_id();
            //add locations
            $this->add_shipping_zone_locations($zone_id);
            //add paymenet methods
            $this->add_shipping_zone_payment_methods($zone_id);
            return true;
        }
        return false;
    }

    //add shipping zone locations
    public function add_shipping_zone_locations($zone_id)
    {
        $continent_codes = $this->input->post('continent');
        if (!empty($continent_codes)) {
            foreach ($continent_codes as $continent_code) {
                if (in_array($continent_code, array('EU', 'AS', 'AF', 'NA', 'SA', 'OC', 'AN'))) {
                    //check if already exists
                    $zone_continent = $this->db->where('continent_code', clean_str($continent_code))->where('zone_id', clean_number($zone_id))->get('shipping_zone_locations')->row();
                    if (empty($zone_continent)) {
                        $item = array(
                            'zone_id' => $zone_id,
                            'user_id' => $this->auth_user->id,
                            'continent_code' => $continent_code,
                            'country_id' => 0,
                            'state_id' => 0
                        );
                        $this->db->insert('shipping_zone_locations', $item);
                    }
                }
            }
        }
        $country_ids = $this->input->post('country');
        if (!empty($country_ids)) {
            foreach ($country_ids as $country_id) {
                $country = $this->location_model->get_country($country_id);
                if (!empty($country)) {
                    //check if already exists
                    $zone_country = $this->db->where('country_id', clean_number($country_id))->where('zone_id', clean_number($zone_id))->get('shipping_zone_locations')->row();
                    if (empty($zone_country)) {
                        $item = array(
                            'zone_id' => $zone_id,
                            'user_id' => $this->auth_user->id,
                            'continent_code' => $country->continent_code,
                            'country_id' => $country->id,
                            'state_id' => 0
                        );
                        $this->db->insert('shipping_zone_locations', $item);
                    }
                }
            }
        }
        $state_ids = $this->input->post('state');
        if (!empty($state_ids)) {
            foreach ($state_ids as $state_id) {
                $state = $this->location_model->get_state($state_id);
                if (!empty($state)) {
                    $country = $this->location_model->get_country($state->country_id);
                    if (!empty($country)) {
                        //check if already exists
                        $zone_state = $this->db->where('state_id', clean_number($state_id))->where('zone_id', clean_number($zone_id))->get('shipping_zone_locations')->row();
                        if (empty($zone_state)) {
                            $item = array(
                                'zone_id' => $zone_id,
                                'user_id' => $this->auth_user->id,
                                'continent_code' => $country->continent_code,
                                'country_id' => $country->id,
                                'state_id' => $state->id
                            );
                            $this->db->insert('shipping_zone_locations', $item);
                        }
                    }
                }
            }
        }
    }

    //add shipping zone payment methods
    public function add_shipping_zone_payment_methods($zone_id)
    {
        $option_unique_ids = $this->input->post('option_unique_id');
        if (!empty($option_unique_ids)) {
            foreach ($option_unique_ids as $option_unique_id) {
                $name_array = array();
                foreach ($this->languages as $language) {
                    $item = array(
                        'lang_id' => $language->id,
                        'name' => $this->input->post('method_name_' . $option_unique_id . '_lang_' . $language->id, true)
                    );
                    array_push($name_array, $item);
                }
                $data = array(
                    'name_array' => serialize($name_array),
                    'zone_id' => $zone_id,
                    'user_id' => $this->auth_user->id,
                    'method_type' => $this->input->post('method_type_' . $option_unique_id, true),
                    'flat_rate_cost_calculation_type' => $this->input->post('flat_rate_cost_calculation_type_' . $option_unique_id, true),
                    'flat_rate_cost' => $this->input->post('flat_rate_cost_' . $option_unique_id, true),
                    'local_pickup_cost' => $this->input->post('local_pickup_cost_' . $option_unique_id, true),
                    'free_shipping_min_amount' => $this->input->post('free_shipping_min_amount_' . $option_unique_id, true),
                    'status' => $this->input->post('status_' . $option_unique_id, true)
                );
                $data['flat_rate_cost_calculation_type'] = !empty($data['flat_rate_cost_calculation_type']) ? $data['flat_rate_cost_calculation_type'] : "";
                $data['flat_rate_cost'] = !empty($data['flat_rate_cost']) ? $data['flat_rate_cost'] : 0;
                $data['local_pickup_cost'] = !empty($data['local_pickup_cost']) ? $data['local_pickup_cost'] : 0;
                $data['free_shipping_min_amount'] = !empty($data['free_shipping_min_amount']) ? $data['free_shipping_min_amount'] : 0;

                $data["flat_rate_cost"] = get_price($data["flat_rate_cost"], 'database');
                $data["local_pickup_cost"] = get_price($data["local_pickup_cost"], 'database');
                $data["free_shipping_min_amount"] = get_price($data["free_shipping_min_amount"], 'database');

                //shipping classes
                $class_array = array();
                $shipping_classes = $this->shipping_model->get_active_shipping_classes($this->auth_user->id);
                if (!empty($shipping_classes)) {
                    foreach ($shipping_classes as $shipping_class) {
                        $item = array(
                            'class_id' => $shipping_class->id,
                            'cost' => $this->input->post("flat_rate_cost_" . $option_unique_id . "_class_" . $shipping_class->id, true)
                        );
                        $item['cost'] = get_price($item["cost"], 'database');
                        array_push($class_array, $item);
                    }
                }
                $data['flat_rate_class_costs_array'] = "";
                if (!empty($class_array)) {
                    $data['flat_rate_class_costs_array'] = serialize($class_array);
                }
                $this->db->insert('shipping_zone_methods', $data);
            }
        }
    }

    //edit shipping zone
    public function edit_shipping_zone($zone_id)
    {
        $name_array = array();
        foreach ($this->languages as $language) {
            $item = array(
                'lang_id' => $language->id,
                'name' => $this->input->post('zone_name_lang_' . $language->id, true)
            );
            array_push($name_array, $item);
        }
        $data = array(
            'name_array' => serialize($name_array)
        );
        if ($this->db->where('id', clean_number($zone_id))->update('shipping_zones', $data)) {
            //add locations
            $this->add_shipping_zone_locations($zone_id);
            //edit paymenet methods
            $this->edit_shipping_zone_payment_methods($zone_id);
            return true;
        }
        return false;
    }

    //edit shipping zone payment methods
    public function edit_shipping_zone_payment_methods($zone_id)
    {
        $option_unique_ids = $this->input->post('option_unique_id');
        if (!empty($option_unique_ids)) {
            foreach ($option_unique_ids as $option_unique_id) {
                $name_array = array();
                foreach ($this->languages as $language) {
                    $item = array(
                        'lang_id' => $language->id,
                        'name' => $this->input->post('method_name_' . $option_unique_id . '_lang_' . $language->id, true)
                    );
                    array_push($name_array, $item);
                }
                $data = array(
                    'name_array' => serialize($name_array),
                    'zone_id' => $zone_id,
                    'method_type' => $this->input->post('method_type_' . $option_unique_id, true),
                    'flat_rate_cost_calculation_type' => $this->input->post('flat_rate_cost_calculation_type_' . $option_unique_id, true),
                    'flat_rate_cost' => $this->input->post('flat_rate_cost_' . $option_unique_id, true),
                    'local_pickup_cost' => $this->input->post('local_pickup_cost_' . $option_unique_id, true),
                    'free_shipping_min_amount' => $this->input->post('free_shipping_min_amount_' . $option_unique_id, true),
                    'status' => $this->input->post('status_' . $option_unique_id, true)
                );
                $data['flat_rate_cost_calculation_type'] = !empty($data['flat_rate_cost_calculation_type']) ? $data['flat_rate_cost_calculation_type'] : "";
                $data['flat_rate_cost'] = !empty($data['flat_rate_cost']) ? $data['flat_rate_cost'] : 0;
                $data['local_pickup_cost'] = !empty($data['local_pickup_cost']) ? $data['local_pickup_cost'] : 0;
                $data['free_shipping_min_amount'] = !empty($data['free_shipping_min_amount']) ? $data['free_shipping_min_amount'] : 0;

                $data["flat_rate_cost"] = get_price($data["flat_rate_cost"], 'database');
                $data["local_pickup_cost"] = get_price($data["local_pickup_cost"], 'database');
                $data["free_shipping_min_amount"] = get_price($data["free_shipping_min_amount"], 'database');


                //shipping classes
                $class_array = array();
                $shipping_classes = $this->shipping_model->get_shipping_classes($this->auth_user->id);
                if (!empty($shipping_classes)) {
                    foreach ($shipping_classes as $shipping_class) {
                        $item = array(
                            'class_id' => $shipping_class->id,
                            'cost' => $this->input->post("flat_rate_cost_" . $option_unique_id . "_class_" . $shipping_class->id, true)
                        );
                        if (empty($item['cost'])) {
                            $item['cost'] = 0;
                        }
                        $item['cost'] = get_price($item["cost"], 'database');
                        array_push($class_array, $item);
                    }
                }
                $data['flat_rate_class_costs_array'] = "";
                if (!empty($class_array)) {
                    $data['flat_rate_class_costs_array'] = serialize($class_array);
                }

                if ($this->input->post('method_operation_' . $option_unique_id, true) == "edit") {
                    $this->db->where('id', clean_number($option_unique_id))->update('shipping_zone_methods', $data);
                } else {
                    $data['user_id'] = $this->auth_user->id;
                    $this->db->insert('shipping_zone_methods', $data);
                }
            }
        }
    }

    //get shipping zone
    public function get_shipping_zone($id)
    {
        return $this->db->where('id', clean_number($id))->get('shipping_zones')->row();
    }

    //get shipping zones count
    public function get_shipping_zones_count($user_id)
    {
        $this->db->where('user_id', clean_number($user_id));
        return $this->db->count_all_results('shipping_zones');
    }

    //get shipping zones
    public function get_shipping_zones($user_id)
    {
        $this->db->where('user_id', clean_number($user_id))->order_by('id', 'DESC');
        return $this->db->get('shipping_zones')->result();
    }

    //get shipping locations by zone
    public function get_shipping_locations_by_zone($zone_id)
    {
        $this->db->select("shipping_zone_locations.*, (SELECT name FROM location_countries WHERE location_countries.id = shipping_zone_locations.country_id LIMIT 1) As country_name, 
        (SELECT name FROM location_states WHERE location_states.id = shipping_zone_locations.state_id LIMIT 1) As state_name");
        $this->db->where('zone_id', clean_number($zone_id));
        return $this->db->get('shipping_zone_locations')->result();
    }

    //get shipping payment methods by zone
    public function get_shipping_payment_methods_by_zone($zone_id)
    {
        $this->db->where('zone_id', clean_number($zone_id))->order_by('id', 'DESC');
        return $this->db->get('shipping_zone_methods')->result();
    }

    //add shipping class
    public function add_shipping_class()
    {
        $name_array = array();
        foreach ($this->languages as $language) {
            $item = array(
                'lang_id' => $language->id,
                'name' => $this->input->post('name_lang_' . $language->id, true)
            );
            array_push($name_array, $item);
        }
        $data = array(
            'user_id' => $this->auth_user->id,
            'name_array' => serialize($name_array),
            'status' => $this->input->post('status', true)
        );
        if (empty($data['status'])) {
            $data['status'] = 0;
        }
        return $this->db->insert('shipping_classes', $data);
    }

    //edit shipping class
    public function edit_shipping_class($id)
    {
        $row = $this->get_shipping_class($id);
        if (empty($row) || $row->user_id != $this->auth_user->id) {
            return false;
        }
        $name_array = array();
        foreach ($this->languages as $language) {
            $item = array(
                'lang_id' => $language->id,
                'name' => $this->input->post('name_lang_' . $language->id, true)
            );
            array_push($name_array, $item);
        }
        $data = array(
            'name_array' => serialize($name_array),
            'status' => $this->input->post('status', true)
        );
        if (empty($data['status'])) {
            $data['status'] = 0;
        }
        return $this->db->where('id', $row->id)->update('shipping_classes', $data);
    }

    //get shipping classes
    public function get_shipping_classes($user_id)
    {
        return $this->db->where('user_id', clean_number($user_id))->order_by('id', 'DESC')->get('shipping_classes')->result();
    }

    //get active shipping classes
    public function get_active_shipping_classes($user_id)
    {
        return $this->db->where('user_id', clean_number($user_id))->where('status', 1)->order_by('id', 'DESC')->get('shipping_classes')->result();
    }

    //get shipping class
    public function get_shipping_class($id)
    {
        return $this->db->where('id', clean_number($id))->get('shipping_classes')->row();
    }

    //delete shipping class
    public function delete_shipping_class($id)
    {
        $row = $this->get_shipping_class($id);
        if (!empty($row) && $row->user_id == $this->auth_user->id) {
            return $this->db->where('id', clean_number($id))->delete('shipping_classes');
        }
        return false;
    }

    //add shipping delivery time
    public function add_shipping_delivery_time()
    {
        $option_array = array();
        foreach ($this->languages as $language) {
            $item = array(
                'lang_id' => $language->id,
                'option' => $this->input->post('option_lang_' . $language->id, true)
            );
            array_push($option_array, $item);
        }
        $data = array(
            'user_id' => $this->auth_user->id,
            'option_array' => serialize($option_array)
        );
        return $this->db->insert('shipping_delivery_times', $data);
    }

    //edit shipping delivery time
    public function edit_shipping_delivery_time($id)
    {
        $row = $this->get_shipping_delivery_time($id);
        if (empty($row) || $row->user_id != $this->auth_user->id) {
            return false;
        }
        $option_array = array();
        foreach ($this->languages as $language) {
            $item = array(
                'lang_id' => $language->id,
                'option' => $this->input->post('option_lang_' . $language->id, true)
            );
            array_push($option_array, $item);
        }
        $data = array(
            'option_array' => serialize($option_array)
        );
        return $this->db->where('id', $row->id)->update('shipping_delivery_times', $data);
    }

    //get shipping delivery times
    public function get_shipping_delivery_times($user_id, $sort = '')
    {
        $this->db->where('user_id', clean_number($user_id));
        if (!empty($sort)) {
            $this->db->order_by('id', 'DESC');
        } else {
            $this->db->order_by('id');
        }
        return $this->db->get('shipping_delivery_times')->result();
    }

    //get shipping delivery time
    public function get_shipping_delivery_time($id)
    {
        return $this->db->where('id', clean_number($id))->get('shipping_delivery_times')->row();
    }

    //delete shipping location
    public function delete_shipping_location($id)
    {
        $this->db->join('shipping_zones', 'shipping_zones.id = shipping_zone_locations.zone_id');
        $this->db->select('shipping_zone_locations.*');
        $this->db->where('shipping_zone_locations.id', clean_number($id))->where('shipping_zones.user_id', $this->auth_user->id);
        $result = $this->db->get('shipping_zone_locations')->row();
        if (!empty($result)) {
            $this->db->where('id', clean_number($id));
            return $this->db->delete('shipping_zone_locations');
        }
    }

    //delete shipping method
    public function delete_shipping_method($id)
    {
        $this->db->join('shipping_zones', 'shipping_zones.id = shipping_zone_methods.zone_id');
        $this->db->select('shipping_zone_methods.*');
        $this->db->where('shipping_zone_methods.id', clean_number($id))->where('shipping_zones.user_id', $this->auth_user->id);
        $result = $this->db->get('shipping_zone_methods')->row();
        if (!empty($result)) {
            $this->db->where('id', clean_number($id));
            return $this->db->delete('shipping_zone_methods');
        }
    }

    //delete shipping delivery time
    public function delete_shipping_delivery_time($id)
    {
        $row = $this->get_shipping_delivery_time($id);
        if (!empty($row) && $row->user_id == $this->auth_user->id) {
            return $this->db->where('id', clean_number($id))->delete('shipping_delivery_times');
        }
        return false;
    }

    //delete shipping zone
    public function delete_shipping_zone($id)
    {
        $this->db->where('shipping_zones.id', clean_number($id))->where('shipping_zones.user_id', $this->auth_user->id);
        $result = $this->db->get('shipping_zones')->row();
        if (!empty($result)) {
            //delete locations
            $this->db->where('zone_id', clean_number($id))->delete('shipping_zone_locations');
            //delete methods
            $this->db->where('zone_id', clean_number($id))->delete('shipping_zone_methods');
            //delete zone
            $this->db->where('id', clean_number($id))->delete('shipping_zones');
        }
    }
}