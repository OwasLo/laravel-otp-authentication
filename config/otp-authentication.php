<?php
// config for Owaslo/OtpAuthentication
return [
    'is_block_sms'=>true,
    'phone_attribute_name' => 'phone',
    'otp' => [
        'length' => 5,
        'characters' => '0123456789',
        'expire_duration' => 5,
    ]
];
