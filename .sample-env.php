<?php
/**
 * Created by Apptitud.mx.
 * User: diegogonzalez
 * Date: 7/19/15
 * Time: 10:20 PM
 */
return [
    'mysql' => [
        'hostname' => 'localhost',
        'database' => '',
        'username' => 'homestead',
        'password' => 'secret'
    ],
    'mail' => [
        'driver' => 'smtp',
        'host' => 'smtp.mailgun.org',
        'port' => '587',
        'from' => '',
        'name' => '',
        'encryption' => 'tls',
        'user' => '',
        'pass' => '',
    ],
    'services' => [
        'mandrill' => [
            'apikey' => ''
        ],
        'twilio' => [
            'sid'   => '',
            'token' => ''
        ],
    ]
];