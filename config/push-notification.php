<?php

return array(

    'ios'     => array(
        'environment' =>'development',
        'certificate' =>'/path/to/certificate.pem',
        'passPhrase'  =>'password',
        'service'     =>'apns'
    ),
    'android' => array(
        'environment' => 'production',
        'apiKey'      => env('VAPID_PRIVATE_KEY'),
        'service'     => 'fmc'
    )

);