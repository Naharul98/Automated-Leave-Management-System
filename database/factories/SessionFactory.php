<?php

use Faker\Generator as Faker;
use App\Session as Session;

$factory->define(Session::class, function (Faker $faker) {
    return [
        //
        'session_name' => 'Test Session',
        'is_locked' => '0',
    ];
});

$factory->state(Session::class,'not_locked',function ($faker){
    return [
        'is_locked'=>'0',
    ];
});

$factory->state(Session::class,'locked',function ($faker){
    return [
        'is_locked'=>'1',
    ];
});
