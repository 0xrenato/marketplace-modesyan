<?php
defined('BASEPATH') or exit('No direct script access allowed');

//fixed
$route['cron/update-sitemap'] = 'cron_controller/update_sitemap';
$route['unsubscribe'] = 'home_controller/unsubscribe';
$route['connect-with-facebook'] = 'auth_controller/connect_with_facebook';
$route['facebook-callback'] = 'auth_controller/facebook_callback';
$route['connect-with-google'] = 'auth_controller/connect_with_google';
$route['connect-with-vk'] = 'auth_controller/connect_with_vk';
$route['logout'] = 'common_controller/logout';
//auth
$route['forgot-password-post']['POST'] = 'auth_controller/forgot_password_post';
$route['reset-password-post']['POST'] = 'auth_controller/reset_password_post';
$route['register-post']['POST'] = 'auth_controller/register_post';
//bidding
$route['request-quote']['POST'] = 'bidding_controller/request_quote';
$route['submit-quote-post']['POST'] = 'dashboard_controller/submit_quote';
$route['accept-quote-post']['POST'] = 'bidding_controller/accept_quote';
$route['reject-quote-post']['POST'] = 'bidding_controller/reject_quote';
//ajax
$route['mds-send-email-post']['POST'] = 'ajax_controller/send_email';
//cart
$route['add-to-cart']['POST'] = 'cart_controller/add_to_cart';
$route['add-to-cart-quote']['POST'] = 'cart_controller/add_to_cart_quote';
$route['update-cart-product-quantity']['POST'] = 'cart_controller/update_cart_product_quantity';
$route['payment-method-post']['POST'] = 'cart_controller/payment_method_post';
$route['shipping-post']['POST'] = 'cart_controller/shipping_post';
$route['bank-transfer-payment-post']['POST'] = 'cart_controller/bank_transfer_payment_post';
$route['cash-on-delivery-payment-post']['POST'] = 'cart_controller/cash_on_delivery_payment_post';
$route['paypal-payment-post']['POST'] = 'cart_controller/paypal_payment_post';
$route['paystack-payment-post']['POST'] = 'cart_controller/paystack_payment_post';
$route['razorpay-payment-post']['POST'] = 'cart_controller/razorpay_payment_post';
$route['flutterwave-payment-post'] = 'cart_controller/flutterwave_payment_post';
$route['stripe-payment-post']['POST'] = 'cart_controller/stripe_payment_post';
$route['iyzico-payment-post'] = 'cart_controller/iyzico_payment_post';
$route['midtrans-payment-post'] = 'cart_controller/midtrans_payment_post';
$route['twocheckout-payment-post'] = 'cart_controller/twocheckout_payment_post';
//earnings
$route['withdraw-money-post']['POST'] = 'dashboard_controller/withdraw_money_post';
$route['set-paypal-payout-account-post']['POST'] = 'dashboard_controller/set_paypal_payout_account_post';
$route['set-iban-payout-account-post']['POST'] = 'dashboard_controller/set_iban_payout_account_post';
$route['set-swift-payout-account-post']['POST'] = 'dashboard_controller/set_swift_payout_account_post';
//message
$route['send-message-post']['POST'] = 'message_controller/send_message';
//file
$route['upload-audio-post']['POST'] = 'file_controller/upload_audio';
$route['load-audio-preview-post']['POST'] = 'file_controller/load_audio_preview';
$route['upload-digital-files-post']['POST'] = 'file_controller/upload_digital_files';
$route['download-digital-file-post']['POST'] = 'file_controller/download_digital_file';
$route['upload-file-manager-images-post']['POST'] = 'file_controller/upload_file_manager_image';
$route['upload-image-post']['POST'] = 'file_controller/upload_image';
$route['get-uploaded-image-post']['POST'] = 'file_controller/get_uploaded_image';
$route['upload-image-session-post']['POST'] = 'file_controller/upload_image_session';
$route['get-sess-uploaded-image-post']['POST'] = 'file_controller/get_sess_uploaded_image';
$route['upload-video-post']['POST'] = 'file_controller/upload_video';
$route['load-video-preview-post']['POST'] = 'file_controller/load_video_preview';
$route['download-purchased-digital-file-post']['POST'] = 'file_controller/download_purchased_digital_file';
$route['download-free-digital-file-post']['POST'] = 'file_controller/download_free_digital_file';
//product
$route['add-product-post']['POST'] = 'dashboard_controller/add_product_post';
$route['edit-product-post']['POST'] = 'dashboard_controller/edit_product_post';
$route['edit-product-details-post']['POST'] = 'dashboard_controller/edit_product_details_post';
$route['start-selling-post']['POST'] = 'home_controller/start_selling_post';
$route['renew-membership-plan-post']['POST'] = 'home_controller/renew_membership_plan_post';
$route['add-remove-wishlist-post']['POST'] = 'ajax_controller/add_remove_wishlist';

//variations
$route['add-variation-post']['POST'] = 'field_controller/add_variation_post';
$route['edit-variation']['POST'] = 'field_controller/edit_variation';
$route['edit-variation-post']['POST'] = 'field_controller/edit_variation_post';
$route['delete-variation-post']['POST'] = 'field_controller/delete_variation_post';

$route['add-variation-option']['POST'] = 'field_controller/add_variation_option';
$route['add-variation-option-post']['POST'] = 'field_controller/add_variation_option_post';
$route['view-variation-options']['POST'] = 'field_controller/view_variation_options';
$route['edit-variation-option']['POST'] = 'field_controller/edit_variation_option';
$route['edit-variation-option-post']['POST'] = 'field_controller/edit_variation_option_post';
$route['delete-variation-option-post']['POST'] = 'field_controller/delete_variation_option_post';
$route['select-variation-post']['POST'] = 'field_controller/select_variation_post';

$route['upload-variation-image-session']['POST'] = 'field_controller/upload_variation_image_session';
$route['get-uploaded-variation-image-session']['POST'] = 'field_controller/get_sess_uploaded_variation_image';
$route['delete-variation-image-session-post']['POST'] = 'field_controller/delete_variation_image_session_post';
$route['set-variation-image-main-session']['POST'] = 'field_controller/set_variation_image_main_session';
$route['set-variation-image-main']['POST'] = 'field_controller/set_variation_image_main';

$route['upload-variation-image']['POST'] = 'field_controller/upload_variation_image';
$route['get-uploaded-variation-image']['POST'] = 'field_controller/get_uploaded_variation_image';
$route['delete-variation-image-post']['POST'] = 'field_controller/delete_variation_image_post';


//select variation
$route['select-variation-option-post']['POST'] = 'ajax_controller/select_product_variation_option';
$route['get-sub-variation-options']['POST'] = 'ajax_controller/get_sub_variation_options';

//profile
$route['follow-unfollow-user-post']['POST'] = 'profile_controller/follow_unfollow_user';
$route['change-password-post']['POST'] = 'profile_controller/change_password_post';
$route['add-shipping-address-post']['POST'] = 'profile_controller/add_shipping_address_post';
$route['edit-shipping-address-post']['POST'] = 'profile_controller/edit_shipping_address_post';

$route['shop-settings-post']['POST'] = 'dashboard_controller/shop_settings_post';
$route['add-shipping-zone-post']['POST'] = 'dashboard_controller/add_shipping_zone_post';
$route['edit-shipping-zone-post']['POST'] = 'dashboard_controller/edit_shipping_zone_post';

$route['add-shipping-class-post']['POST'] = 'dashboard_controller/add_shipping_class_post';
$route['edit-shipping-class-post']['POST'] = 'dashboard_controller/edit_shipping_class_post';

$route['add-shipping-delivery-time-post']['POST'] = 'dashboard_controller/add_shipping_delivery_time_post';
$route['edit-shipping-delivery-time-post']['POST'] = 'dashboard_controller/edit_shipping_delivery_time_post';

$route['social-media-post']['POST'] = 'profile_controller/social_media_post';
$route['update-profile-post']['POST'] = 'profile_controller/update_profile_post';
$route['cover-image-post']['POST'] = 'profile_controller/cover_image_post';
//order
$route['update-order-product-status-post']['POST'] = 'dashboard_controller/update_order_product_status_post';
$route['bank-transfer-payment-report-post']['POST'] = 'order_controller/bank_transfer_payment_report_post';
//promote
$route['pricing-post']['POST'] = 'dashboard_controller/pricing_post';
//home
$route['contact-post']['POST'] = 'home_controller/contact_post';
$route['add-to-subscribers-post']['POST'] = 'home_controller/add_to_subscribers';
$route['set-default-location-post']['POST'] = 'home_controller/set_default_location';
$route['set-selected-currency-post']['POST'] = 'home_controller/set_selected_currency';
$route['add-review-post']['POST'] = 'home_controller/add_review_post';
$route["mds-run-internal-cron"]['POST'] = "ajax_controller/run_internal_cron";