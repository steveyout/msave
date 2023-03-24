<?php

return [

     //Specify the environment mpesa is running, sandbox or production
     'mpesa_env' => 'sandbox',
    /*-----------------------------------------
    |The App consumer key
    |------------------------------------------
    */
    'consumer_key'   => env('CONSUMER_KEY'),

    /*-----------------------------------------
    |The App consumer Secret
    |------------------------------------------
    */
    'consumer_secret' => env('CONSUMER_SECRET'),

    /*-----------------------------------------
    |The paybill number
    |------------------------------------------
    */
    'paybill'         => 601380,

    /*-----------------------------------------
    |Lipa Na Mpesa Online Shortcode
    |------------------------------------------
    */
    'lipa_na_mpesa'  => '174379',

    /*-----------------------------------------
    |Lipa Na Mpesa Online Passkey
    |------------------------------------------
    */
    'lipa_na_mpesa_passkey' => 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919',

    /*-----------------------------------------
    |Initiator Username.
    |------------------------------------------
    */
    'initiator_username' => env('APP_NAME'),

    /*-----------------------------------------
    |Initiator Password
    |------------------------------------------
    */
    'initiator_password' => 'Safaricom007@',

    /*-----------------------------------------
    |Test phone Number
    |------------------------------------------
    */
    'test_msisdn ' => '254708374149',

    /*-----------------------------------------
    |Lipa na Mpesa Online callback url
    |------------------------------------------
    */
    'lnmocallback' => env('LNMO_CALLBACK'),
    /*-----------------------------------------
    |status timeout results url
    |------------------------------------------
    */
    'status_timeout'=>env('STATUS_TIMEOUT_CALLBACK'),
    /*-----------------------------------------
    |status results url
    |------------------------------------------
    */
    'status_result'=>env('STATUS_RESULT_CALLBACK'),

     /*-----------------------------------------
    |C2B  Validation url
    |------------------------------------------
    */
    'c2b_validate_callback' => 'https://b2d7e6a4.ngrok.io/api/validate?key=ertyuiowwws',

    /*-----------------------------------------
    |C2B confirmation url
    |------------------------------------------
    */
    'c2b_confirm_callback' => 'https://b2d7e6a4.ngrok.io/api/confirm?key=ertyuiowwws',

    /*-----------------------------------------
    |B2C timeout url
    |------------------------------------------
    */
    'b2c_timeout' => 'https://b2d7e6a4.ngrok.io/api/validate?key=ertyuiowwws',

    /*-----------------------------------------
    |B2C results url
    |------------------------------------------
    */
    'b2c_result' => 'https://b2d7e6a4.ngrok.io/api/validate?key=ertyuiowwws'

];
