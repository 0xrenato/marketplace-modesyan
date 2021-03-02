<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PayPal PHP library
 *
 **/


require_once APPPATH . "third_party/paypal/vendor/autoload.php";

use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;

class Paypal
{

    /**
     * Privates
     */
    private $ci;
    private $paypal_client_id = '';
    private $paypal_secret = '';
    private $client;

    /**
     * Constructor
     *
     * @access public
     * @param array
     */
    public function __construct()
    {
        $paypal = get_payment_gateway('paypal');
        if (!empty($paypal)) {
            $this->paypal_client_id = $paypal->public_key;
            $this->paypal_secret = $paypal->secret_key;
        }

        $environment = null;
        if ($paypal->environment == 'sandbox') {
            $environment = new SandboxEnvironment($this->paypal_client_id, $this->paypal_secret);
        } else {
            $environment = new ProductionEnvironment($this->paypal_client_id, $this->paypal_secret);
        }
        $this->client = new PayPalHttpClient($environment);
    }

    /**
     * Get Order
     *
     * @access public
     */
    public function get_order($order_id)
    {
        try {
            $response = $this->client->execute(new OrdersGetRequest($order_id));
            if (!empty($response) && $response->result->status == 'COMPLETED') {
                return true;
            } else {
                return false;
            }
        } catch (BraintreeHttp\HttpException $ex) {
            return false;
        } catch (HttpException $ex) {
            return false;
        }
        return false;
    }
}

/* End of file paypal.php */
/* Location: ./application/libraries/paypal.php */
