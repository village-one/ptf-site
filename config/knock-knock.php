<?php

use craft\helpers\App;

return [
  '*' => [
    'enabled' => false,
    'enableCpProtection' => false
  ],
  'staging' => [
    'enabled' => App::env('KNOCK_KNOCK_ENABLED'),
    'enableCpProtection' => true,
    'password' => App::env('KNOCK_KNOCK_PASSWORD'),
  ],
];
