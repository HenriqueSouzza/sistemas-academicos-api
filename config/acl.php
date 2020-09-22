<?php

return [
    /**
     * User class used for ACL.
     */
    'user'       => App\User::class,

    /**
     * Cache config.
     */
    'cache'      => [
        'enabled' => true,

        'key' => 'permissions.policies',
    ],
];
