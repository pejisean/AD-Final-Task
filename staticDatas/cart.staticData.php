<?php

return [
    [
        'session_token' => 'sess_demo_12345',
        'user_id' => 1, // john.smith
        'item_id' => 1, // Tactical Backpack
        'quantity' => 1,
        'price_at_time' => 85.50
    ],
    [
        'session_token' => 'sess_demo_12345',
        'user_id' => 1, // john.smith
        'item_id' => 2, // Multi-Tool Pliers
        'quantity' => 2,
        'price_at_time' => 45.99
    ],
    [
        'session_token' => 'sess_guest_67890',
        'user_id' => null, // Guest user
        'item_id' => 5, // Water Purification Tablets
        'quantity' => 3,
        'price_at_time' => 24.99
    ],
    [
        'session_token' => 'sess_jane_54321',
        'user_id' => 3, // jane.doe
        'item_id' => 3, // Night Vision Goggles
        'quantity' => 1,
        'price_at_time' => 950.00
    ],
    [
        'session_token' => 'sess_jane_54321',
        'user_id' => 3, // jane.doe
        'item_id' => 9, // Homemade Energy Bars
        'quantity' => 2,
        'price_at_time' => 18.50
    ],
    [
        'session_token' => 'sess_mike_98765',
        'user_id' => 4, // mike.trader
        'item_id' => 11, // Scavenged Medical Kit
        'quantity' => 1,
        'price_at_time' => 125.00
    ]
];