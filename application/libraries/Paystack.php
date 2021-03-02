<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * PayStack PHP library
 *
 **/
class Paystack
{

    /**
     * Privates
     */
    private $ci;
    private $paystack_secret_key = '';
    private $paystack_public_key = '';

    /**
     * Constructor
     *
     * @access public
     * @param array
     */
    public function __construct()
    {
        $paystack = get_payment_gateway('paystack');
        if (!empty($paystack)) {
            $this->paystack_secret_key = $paystack->secret_key;
        }
    }

    /**
     * Verify Transaction
     *
     * @access public
     */
    public function verify_transaction($reference)
    {
        if (empty($reference)) {
            return false;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer " . $this->paystack_secret_key,
                "cache-control: no-cache"
            ],
        ));
        $response = curl_exec($curl);
        if (curl_error($curl)) {
            return false;
        }
        $transaction = json_decode($response);

        if (empty($transaction->status)) {
            return false;
        }
        if ($transaction->data->status == 'success') {
            return true;
        }
    }
}

/* End of file paystack.php */
/* Location: ./application/libraries/paystack.php */
