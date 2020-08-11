<?php
/*
return [

    'driver' => env('MAIL_DRIVER', 'smtp'),



    'host' => env('MAIL_HOST', 'smtp.mailgun.org'),



    'port' => env('MAIL_PORT', 587),



    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],



    'encryption' => env('MAIL_ENCRYPTION', 'tls'),



    'username' => env('MAIL_USERNAME'),

    'password' => env('MAIL_PASSWORD'),



    'sendmail' => '/usr/sbin/sendmail -bs',



    'markdown' => [
        'theme' => 'default',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],


    'log_channel' => env('MAIL_LOG_CHANNEL'),

];
*/
return [
    'driver' => env('MAIL_DRIVER', 'smtp'),
    'host' => env('MAIL_HOST', 'smtp.gmail.com'),
    'port' => env('MAIL_PORT', 587),
    'from' => [
    'address' => env(
        'MAIL_FROM_ADDRESS', 'holidayreservation90@gmail.com'
    ),
    'name' => env(
        'MAIL_FROM_NAME', 'Holiday Reservation'
    ),
],
    'encryption' => env('MAIL_ENCRYPTION', 'tls'),
    'username' => env('MAIL_USERNAME','kcl.buddyscheme@gmail.com'),
    'password' => env('MAIL_PASSWORD','1234%^&*'),
    'sendmail' => '/usr/sbin/sendmail -bs',
    'pretend' => false,
    'stream' => [
    'ssl' => [
        'allow_self_signed' => true,
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
],

];