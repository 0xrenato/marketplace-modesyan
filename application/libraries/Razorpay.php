<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Razorpay PHP library
 *
 **/

require_once APPPATH . "third_party/razorpay/vendor/autoload.php";

use Razorpay\Api\Api;


class Razorpay
{
    /**
     * Privates
     */
    private $ci;
    private $razorpay_client_id = '';
    private $razorpay_secret = '';
    private $client;

    /**
     * Constructor
     *
     * @access public
     * @param array
     */
    public function __construct()
    {
        $razorpay = get_payment_gateway('razorpay');
        if (!empty($razorpay)) {
            $this->razorpay_client_id = $razorpay->public_key;
            $this->razorpay_secret = $razorpay->secret_key;
        }

        $this->client = new Api($this->razorpay_client_id, $this->razorpay_secret);
    }

    /**
     * Create Order
     *
     * @access public
     */
    public function create_order($array)
    {
        try {
            $order = $this->client->order->create($array);
            if (!empty($order)) {
                return $order['id'];
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
            if ($message == 'Currency is not supported') {
                echo "Currency is not supported. You have to enable multi-currency support in your Razorpay account. If you don't know how to enable this option, please contact Razaorpay support.";
            } else {
                echo $message;
            }
        }
        return false;
    }

    /**
     * Verify Payment Signature
     *
     * @access public
     */
    public function verify_payment_signature($array)
    {
        $attributes = array(
            'razorpay_signature' => $array['razorpay_signature'],
            'razorpay_payment_id' => $array['payment_id'],
            'razorpay_order_id' => $array['razorpay_order_id']
        );
        try {
            $order = $this->client->utility->verifyPaymentSignature($attributes);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

/* End of file razorpay.php */
/* Location: ./application/libraries/razorpay.php */
