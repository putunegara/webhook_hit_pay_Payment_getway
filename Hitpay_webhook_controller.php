public function your_webhook_controller()
    {
        $salt               = 'your salt here'; // get salt from dashboard
        $incoming_date      = json_encode(file_get_contents('php://input')); // data that hitpay send to the webwook

        $data               = explode("&", str_replace('"', '', $incoming_date)); //explode all data that coming

        // Exploded data
        $payment_id         = explode("=", $data[0])[1];
        $payment_request_id = explode("=", $data[1])[1];
        $phone              = explode("=", $data[2])[1];
        $amount             = explode("=", $data[3])[1];
        $currency           = explode("=", $data[4])[1];
        $status             = explode("=", $data[5])[1];
        $reference_number   = explode("=", $data[6])[1];
        $hmac               = explode("=", $data[7])[1]; // This is need to be vefify if it really coming from HitPay.

        // This string to create signature
        $string             = str_replace("=", "", $data[3]) . str_replace("=", "", $data[4]) . str_replace("=", "", $data[0]) . str_replace("=", "", $data[1]) . str_replace("=", "", $data[2]) . str_replace("=", "", $data[6]) . str_replace("=", "", $data[5]);

        $signature          = hash_hmac('sha256', $string, $salt); // Create Signature

        if ($signature == $hmac and $status == "completed") {
            // Verified, its coming from hitpay
            // Do your further database process here, base on exploded data above. Expl Updating Payment status on your data base and confirming purchase
        }
    }
