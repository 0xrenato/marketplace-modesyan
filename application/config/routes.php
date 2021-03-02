<?php
defined('BASEPATH') or exit('No direct script access allowed');
//get route
function getr($key, $rts)
{
    if (!empty($rts)) {
        if (!empty($rts->$key)) {
            return $rts->$key;
        }
    }
    return $key;
}


/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$rts = $this->config->item('routes');

$route['default_controller'] = 'home_controller';
$route['404_override'] = 'home_controller/error_404';
$route['translate_uri_dashes'] = FALSE;
$route['error-404'] = 'home_controller/error_404';

$general_settings = $this->config->item('general_settings');
$languages = $this->config->item('languages');
foreach ($languages as $language) {
    if ($language->status == 1) {
        $key = "";
        if ($general_settings->site_lang != $language->id) {
            $key = $language->short_form . '/';
            $route[$language->short_form] = 'home_controller/index';
            $route[$key . '/error-404'] = 'home_controller/error_404';
        }
        //auth
        $route[$key . getr('register', $rts)]['GET'] = 'auth_controller/register';
        $route[$key . getr('forgot_password', $rts)]['GET'] = 'auth_controller/forgot_password';
        $route[$key . getr('reset_password', $rts)]['GET'] = 'auth_controller/reset_password';
        $route[$key . 'confirm']['GET'] = 'auth_controller/confirm_email';
        //dashboard
        $route[$key . getr('dashboard', $rts)]['GET'] = 'dashboard_controller/index';
        //profile
        $route[$key . getr('profile', $rts) . '/(:any)']['GET'] = 'profile_controller/profile/$1';
        $route[$key . getr('wishlist', $rts) . '/(:any)']['GET'] = 'profile_controller/wishlist/$1';
        $route[$key . getr('wishlist', $rts)]['GET'] = 'home_controller/guest_wishlist/$1';
        $route[$key . getr('followers', $rts) . '/(:any)']['GET'] = 'profile_controller/followers/$1';
        $route[$key . getr('following', $rts) . '/(:any)']['GET'] = 'profile_controller/following/$1';
        $route[$key . getr('reviews', $rts) . '/(:any)']['GET'] = 'profile_controller/reviews/$1';
        /*settings*/
        $route[$key . getr('settings', $rts)]['GET'] = 'profile_controller/update_profile';
        $route[$key . getr('settings', $rts) . '/' . getr('update_profile', $rts)]['GET'] = 'profile_controller/update_profile';
        $route[$key . getr('settings', $rts) . '/' . getr('cover_image', $rts)]['GET'] = 'profile_controller/cover_image';
        $route[$key . getr('settings', $rts) . '/' . getr('social_media', $rts)]['GET'] = 'profile_controller/social_media';
        $route[$key . getr('settings', $rts) . '/' . getr('change_password', $rts)]['GET'] = 'profile_controller/change_password';
        $route[$key . getr('settings', $rts) . '/' . getr('shipping_address', $rts)]['GET'] = 'profile_controller/shipping_address';
        $route[$key . getr('members', $rts)]['GET'] = 'home_controller/members';
        /*product*/
        $route[$key . getr('select_membership_plan', $rts)]['GET'] = 'home_controller/renew_membership_plan';
        $route[$key . getr('start_selling', $rts) . '/' . getr('select_membership_plan', $rts)]['GET'] = 'home_controller/select_membership_plan';
        $route[$key . getr('start_selling', $rts)]['GET'] = 'home_controller/start_selling';
        $route[$key . getr('search', $rts)]['GET'] = 'home_controller/search';
        $route[$key . getr('products', $rts)]['GET'] = 'home_controller/products';
        $route[$key . getr('downloads', $rts)]['GET'] = 'profile_controller/downloads';
        /*blog*/
        $route[$key . getr('blog', $rts)]['GET'] = 'home_controller/blog';
        $route[$key . getr('blog', $rts) . '/(:any)']['GET'] = 'home_controller/blog_category/$1';
        $route[$key . getr('blog', $rts) . '/' . getr('tag', $rts) . '/(:any)']['GET'] = 'home_controller/tag/$1';
        $route[$key . getr('blog', $rts) . '/(:any)/(:any)']['GET'] = 'home_controller/post/$1/$2';
        /*contact*/
        $route[$key . getr('contact', $rts)]['GET'] = 'home_controller/contact';
        /*messages*/
        $route[$key . getr('messages', $rts)]['GET'] = 'message_controller/messages';
        $route[$key . getr('messages', $rts) . '/' . getr('conversation', $rts) . '/(:num)']['GET'] = 'message_controller/conversation/$1';
        /*rss feeds*/
        $route[$key . getr('rss_feeds', $rts)]['GET'] = 'rss_controller/rss_feeds';
        $route[$key . 'rss/' . getr('latest_products', $rts)]['GET'] = 'rss_controller/latest_products';
        $route[$key . 'rss/' . getr('featured_products', $rts)]['GET'] = 'rss_controller/featured_products';
        $route[$key . 'rss/' . getr('category', $rts) . '/(:any)']['GET'] = 'rss_controller/rss_by_category/$1';
        $route[$key . 'rss/' . getr('seller', $rts) . '/(:any)']['GET'] = 'rss_controller/rss_by_seller/$1';
        /*cart*/
        $route[$key . getr('cart', $rts)]['GET'] = 'cart_controller/cart';
        $route[$key . getr('cart', $rts) . '/' . getr('shipping', $rts)]['GET'] = 'cart_controller/shipping';
        $route[$key . getr('cart', $rts) . '/' . getr('payment_method', $rts)]['GET'] = 'cart_controller/payment_method';
        $route[$key . getr('cart', $rts) . '/' . getr('payment', $rts)]['GET'] = 'cart_controller/payment';
        /*orders*/
        $route[$key . getr('orders', $rts)]['GET'] = 'order_controller/orders';
        $route[$key . getr('orders', $rts) . '/' . getr('completed_orders', $rts)]['GET'] = 'order_controller/completed_orders';
        $route[$key . getr('order_details', $rts) . '/(:num)']['GET'] = 'order_controller/order/$1';
        $route[$key . getr('order_completed', $rts) . '/(:num)']['GET'] = 'cart_controller/order_completed/$1';
        $route[$key . getr('promote_payment_completed', $rts)]['GET'] = 'cart_controller/promote_payment_completed';
        $route[$key . getr('membership_payment_completed', $rts)]['GET'] = 'cart_controller/membership_payment_completed';
        $route[$key . 'invoice/(:num)']['GET'] = 'common_controller/invoice/$1';
        $route[$key . 'invoice-promotion/(:num)']['GET'] = 'common_controller/invoice_promotion/$1';
        $route[$key . 'invoice-membership/(:num)']['GET'] = 'common_controller/invoice_membership/$1';
        /*bidding*/
        $route[$key . getr('quote_requests', $rts)]['GET'] = 'bidding_controller/quote_requests';
        /*terms-conditions*/
        $route[$key . getr('terms_conditions', $rts)]['GET'] = 'home_controller/terms_conditions';
        /*dashboard*/
        $route[$key . getr('dashboard', $rts) . '/' . getr('add_product', $rts)]['GET'] = 'dashboard_controller/add_product';
        $route[$key . getr('dashboard', $rts) . '/' . getr('product', $rts) . '/' . getr('product_details', $rts) . '/(:num)']['GET'] = 'dashboard_controller/edit_product_details/$1';
        $route[$key . getr('dashboard', $rts) . '/' . getr('edit_product', $rts) . '/(:num)']['GET'] = 'dashboard_controller/edit_product/$1';

        $route[$key . getr('dashboard', $rts) . '/' . getr('products', $rts)]['GET'] = 'dashboard_controller/products';
        $route[$key . getr('dashboard', $rts) . '/' . getr('pending_products', $rts)]['GET'] = 'dashboard_controller/pending_products';
        $route[$key . getr('dashboard', $rts) . '/' . getr('bulk_product_upload', $rts)]['GET'] = 'dashboard_controller/bulk_product_upload';
        $route[$key . getr('dashboard', $rts) . '/' . getr('sales', $rts)]['GET'] = 'dashboard_controller/sales';
        $route[$key . getr('dashboard', $rts) . '/' . getr('completed_sales', $rts)]['GET'] = 'dashboard_controller/completed_sales';
        $route[$key . getr('dashboard', $rts) . '/' . getr('sale', $rts) . '/(:num)']['GET'] = 'dashboard_controller/sale/$1';
        $route[$key . getr('dashboard', $rts) . '/' . getr('hidden_products', $rts)]['GET'] = 'dashboard_controller/hidden_products';
        $route[$key . getr('dashboard', $rts) . '/' . getr('expired_products', $rts)]['GET'] = 'dashboard_controller/expired_products';
        $route[$key . getr('dashboard', $rts) . '/' . getr('sold_products', $rts)]['GET'] = 'dashboard_controller/sold_products';
        $route[$key . getr('dashboard', $rts) . '/' . getr('drafts', $rts)]['GET'] = 'dashboard_controller/drafts';
        $route[$key . getr('dashboard', $rts) . '/' . getr('earnings', $rts)]['GET'] = 'dashboard_controller/earnings';
        $route[$key . getr('dashboard', $rts) . '/' . getr('withdraw_money', $rts)]['GET'] = 'dashboard_controller/withdraw_money';
        $route[$key . getr('dashboard', $rts) . '/' . getr('payouts', $rts)]['GET'] = 'dashboard_controller/payouts';
        $route[$key . getr('dashboard', $rts) . '/' . getr('set_payout_account', $rts)]['GET'] = 'dashboard_controller/set_payout_account';
        $route[$key . getr('dashboard', $rts) . '/' . getr('quote_requests', $rts)]['GET'] = 'dashboard_controller/quote_requests';
        $route[$key . getr('dashboard', $rts) . '/' . getr('payment_history', $rts)]['GET'] = 'dashboard_controller/payment_history';
        $route[$key . getr('dashboard', $rts) . '/' . getr('comments', $rts)]['GET'] = 'dashboard_controller/comments';
        $route[$key . getr('dashboard', $rts) . '/' . getr('reviews', $rts)]['GET'] = 'dashboard_controller/reviews';
        $route[$key . getr('dashboard', $rts) . '/' . getr('shop_settings', $rts)]['GET'] = 'dashboard_controller/shop_settings';
        $route[$key . getr('dashboard', $rts) . '/' . getr('shipping_settings', $rts)]['GET'] = 'dashboard_controller/shipping_settings';
        $route[$key . getr('dashboard', $rts) . '/' . getr('add_shipping_zone', $rts)]['GET'] = 'dashboard_controller/add_shipping_zone';
        $route[$key . getr('dashboard', $rts) . '/' . getr('edit_shipping_zone', $rts) . '/(:num)']['GET'] = 'dashboard_controller/edit_shipping_zone/$1';
        /*any*/
        if ($general_settings->site_lang != $language->id) {
            $route[$key . '(:any)/(:any)']['GET'] = 'home_controller/subcategory/$1/$2';
            $route[$key . '(:any)']['GET'] = 'home_controller/any/$1';
        }
    }
}

//static routes
include_once "routes_static.php";

/*
 *
 * ADMIN ROUTES
 *
 */
$route[getr('admin', $rts)] = 'admin_controller/index';
//login
$route[getr('admin', $rts) . '/login'] = 'common_controller/admin_login';
/*navigation routes*/
$route[getr('admin', $rts) . '/navigation'] = 'admin_controller/navigation';
$route[getr('admin', $rts) . '/homepage-manager'] = 'admin_controller/homepage_manager';
$route[getr('admin', $rts) . '/edit-banner/(:num)'] = 'admin_controller/edit_index_banner/$1';
/*slider routes*/
$route[getr('admin', $rts) . '/slider'] = 'admin_controller/slider';
$route[getr('admin', $rts) . '/update-slider-item/(:num)'] = 'admin_controller/update_slider_item/$1';
/*page routes*/
$route[getr('admin', $rts)] = 'admin_controller/index';
$route[getr('admin', $rts) . '/settings'] = 'admin_controller/settings';
$route[getr('admin', $rts) . '/email-settings'] = 'admin_controller/email_settings';
$route[getr('admin', $rts) . '/social-login'] = 'admin_controller/social_login_settings';

$route[getr('admin', $rts) . '/add-page'] = 'page_controller/add_page';
$route[getr('admin', $rts) . '/update-page'] = 'page_controller/update_page';
$route[getr('admin', $rts) . '/pages'] = 'page_controller/pages';
$route[getr('admin', $rts) . '/pages'] = 'page_controller/pages';
/*order routes*/
$route[getr('admin', $rts) . '/orders'] = 'order_admin_controller/orders';
$route[getr('admin', $rts) . '/order-details/(:num)'] = 'order_admin_controller/order_details/$1';
$route[getr('admin', $rts) . '/transactions'] = 'order_admin_controller/transactions';
$route[getr('admin', $rts) . '/order-bank-transfers'] = 'order_admin_controller/order_bank_transfers';
$route[getr('admin', $rts) . '/invoices'] = 'order_admin_controller/invoices';
$route[getr('admin', $rts) . '/digital-sales'] = 'order_admin_controller/digital_sales';
/*product routes*/
$route[getr('admin', $rts) . '/products'] = 'product_controller/products';
$route[getr('admin', $rts) . '/pending-products'] = 'product_controller/pending_products';
$route[getr('admin', $rts) . '/hidden-products'] = 'product_controller/hidden_products';
$route[getr('admin', $rts) . '/expired-products'] = 'product_controller/expired_products';
$route[getr('admin', $rts) . '/sold-products'] = 'product_controller/sold_products';
$route[getr('admin', $rts) . '/drafts'] = 'product_controller/drafts';
$route[getr('admin', $rts) . '/deleted-products'] = 'product_controller/deleted_products';
$route[getr('admin', $rts) . '/product-details/(:num)'] = 'product_controller/product_details/$1';
/*featured product routes*/
$route[getr('admin', $rts) . '/featured-products'] = 'product_controller/featured_products';
$route[getr('admin', $rts) . '/featured-products-transactions'] = 'product_controller/featured_products_transactions';
$route[getr('admin', $rts) . '/featured-products-pricing'] = 'product_controller/featured_products_pricing';
/*special-offers*/
$route[getr('admin', $rts) . '/special-offers'] = 'product_controller/special_offers';
/*bidding system*/
$route[getr('admin', $rts) . '/quote-requests'] = 'admin_controller/quote_requests';
/*page routes*/
$route[getr('admin', $rts) . '/pages'] = 'page_controller/pages';
$route[getr('admin', $rts) . '/update-page/(:num)'] = 'page_controller/update_page/$1';
/*category routes*/
$route[getr('admin', $rts) . '/add-category'] = 'category_controller/add_category';
$route[getr('admin', $rts) . '/categories'] = 'category_controller/categories';
$route[getr('admin', $rts) . '/update-category/(:num)'] = 'category_controller/update_category/$1';
$route[getr('admin', $rts) . '/bulk-category-upload'] = 'category_controller/bulk_category_upload';
/*custom fields*/
$route[getr('admin', $rts) . '/add-custom-field'] = 'category_controller/add_custom_field';
$route[getr('admin', $rts) . '/custom-fields'] = 'category_controller/custom_fields';
$route[getr('admin', $rts) . '/update-custom-field/(:num)'] = 'category_controller/update_custom_field/$1';
$route[getr('admin', $rts) . '/custom-field-options/(:num)'] = 'category_controller/custom_field_options/$1';
/*earnings*/
$route[getr('admin', $rts) . '/earnings'] = 'earnings_controller/earnings';
$route[getr('admin', $rts) . '/completed-payouts'] = 'earnings_controller/completed_payouts';
$route[getr('admin', $rts) . '/payout-requests'] = 'earnings_controller/payout_requests';
$route[getr('admin', $rts) . '/payout-settings'] = 'earnings_controller/payout_settings';
$route[getr('admin', $rts) . '/add-payout'] = 'earnings_controller/add_payout';
$route[getr('admin', $rts) . '/seller-balances'] = 'earnings_controller/seller_balances';
$route[getr('admin', $rts) . '/update-seller-balance/(:num)'] = 'earnings_controller/update_seller_balance/$1';
/*blog routes*/
$route[getr('admin', $rts) . '/blog-add-post'] = 'blog_controller/add_post';
$route[getr('admin', $rts) . '/blog-posts'] = 'blog_controller/posts';
$route[getr('admin', $rts) . '/update-blog-post/(:num)'] = 'blog_controller/update_post/$1';
$route[getr('admin', $rts) . '/blog-categories'] = 'blog_controller/categories';
$route[getr('admin', $rts) . '/update-blog-category/(:num)'] = 'blog_controller/update_category/$1';
/*comment routes*/
$route[getr('admin', $rts) . '/pending-product-comments'] = 'product_controller/pending_comments';
$route[getr('admin', $rts) . '/product-comments'] = 'product_controller/comments';
$route[getr('admin', $rts) . '/pending-blog-comments'] = 'blog_controller/pending_comments';
$route[getr('admin', $rts) . '/blog-comments'] = 'blog_controller/comments';
/*review routes*/
$route[getr('admin', $rts) . '/reviews'] = 'product_controller/reviews';
/*abuse reports*/
$route[getr('admin', $rts) . '/abuse-reports'] = 'admin_controller/abuse_reports';
/*ad spaces routes*/
$route[getr('admin', $rts) . '/ad-spaces'] = 'admin_controller/ad_spaces';
/*seo tools routes*/
$route[getr('admin', $rts) . '/seo-tools'] = 'admin_controller/seo_tools';
/*location*/
$route[getr('admin', $rts) . '/location-settings'] = 'admin_controller/location_settings';
$route[getr('admin', $rts) . '/countries'] = 'admin_controller/countries';
$route[getr('admin', $rts) . '/states'] = 'admin_controller/states';
$route[getr('admin', $rts) . '/add-country'] = 'admin_controller/add_country';
$route[getr('admin', $rts) . '/update-country/(:num)'] = 'admin_controller/update_country/$1';
$route[getr('admin', $rts) . '/add-state'] = 'admin_controller/add_state';
$route[getr('admin', $rts) . '/update-state/(:num)'] = 'admin_controller/update_state/$1';
$route[getr('admin', $rts) . '/cities'] = 'admin_controller/cities';
$route[getr('admin', $rts) . '/add-city'] = 'admin_controller/add_city';
$route[getr('admin', $rts) . '/update-city/(:num)'] = 'admin_controller/update_city/$1';
/*users routes*/
$route[getr('admin', $rts) . '/members'] = 'membership_controller/members';
$route[getr('admin', $rts) . '/vendors'] = 'membership_controller/vendors';
$route[getr('admin', $rts) . '/administrators'] = 'membership_controller/administrators';
$route[getr('admin', $rts) . '/shop-opening-requests'] = 'membership_controller/shop_opening_requests';
$route[getr('admin', $rts) . '/add-administrator'] = 'membership_controller/add_administrator';
$route[getr('admin', $rts) . '/edit-user/(:num)'] = 'membership_controller/edit_user/$1';
$route[getr('admin', $rts) . '/membership-plans'] = 'membership_controller/membership_plans';
$route[getr('admin', $rts) . '/transactions-membership'] = 'membership_controller/transactions_membership';
$route[getr('admin', $rts) . '/edit-plan/(:num)'] = 'membership_controller/edit_plan/$1';

$route[getr('admin', $rts) . '/cache-system'] = 'admin_controller/cache_system';
$route[getr('admin', $rts) . '/storage'] = 'admin_controller/storage';
/*languages routes*/
$route[getr('admin', $rts) . '/languages'] = 'language_controller/languages';
$route[getr('admin', $rts) . '/update-language/(:num)'] = 'language_controller/update_language/$1';
$route[getr('admin', $rts) . '/translations/(:num)'] = 'language_controller/update_translations/$1';
$route[getr('admin', $rts) . '/search-phrases'] = 'language_controller/search_phrases';
/*payment routes*/
$route[getr('admin', $rts) . '/payment-settings'] = 'settings_controller/payment_settings';
$route[getr('admin', $rts) . '/visual-settings'] = 'admin_controller/visual_settings';
$route[getr('admin', $rts) . '/system-settings'] = 'admin_controller/system_settings';
/*currency*/
$route[getr('admin', $rts) . '/currency-settings'] = 'admin_controller/currency_settings';
$route[getr('admin', $rts) . '/add-currency'] = 'admin_controller/add_currency';
$route[getr('admin', $rts) . '/update-currency/(:num)'] = 'admin_controller/update_currency/$1';
//newsletter
$route[getr('admin', $rts) . '/send-email-subscribers'] = 'admin_controller/send_email_subscribers';
$route[getr('admin', $rts) . '/subscribers'] = 'admin_controller/subscribers';

$route[getr('admin', $rts) . '/contact-messages'] = 'admin_controller/contact_messages';
$route[getr('admin', $rts) . '/preferences'] = 'admin_controller/preferences';

//form settings
$route[getr('admin', $rts) . '/product-settings'] = 'settings_controller/product_settings';

$route[getr('admin', $rts) . '/font-settings'] = 'settings_controller/font_settings';
$route[getr('admin', $rts) . '/update-font/(:num)'] = 'settings_controller/update_font/$1';
$route[getr('admin', $rts) . '/route-settings'] = 'settings_controller/route_settings';

$route['(:any)/(:any)']['GET'] = 'home_controller/subcategory/$1/$2';
$route['(:any)']['GET'] = 'home_controller/any/$1';
