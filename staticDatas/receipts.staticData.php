<?php

return [
    // Receipt 1 items (john.smith's order)
    [
        'receipt_id' => 1,
        'item_id' => 1, // Tactical Backpack
        'item_name' => 'Tactical Backpack',
        'item_description' => 'Durable tactical backpack with multiple compartments',
        'quantity' => 1,
        'unit_price' => 85.50,
        'total_price' => 85.50,
        'seller_name' => 'admin'
    ],
    [
        'receipt_id' => 1,
        'item_id' => 2, // Multi-Tool Pliers
        'item_name' => 'Multi-Tool Pliers',
        'item_description' => 'Compact multi-tool with various functions',
        'quantity' => 2,
        'unit_price' => 45.99,
        'total_price' => 91.98,
        'seller_name' => 'admin'
    ],
    
    // Receipt 2 items (jane.doe's order)
    [
        'receipt_id' => 2,
        'item_id' => 3, // Night Vision Goggles
        'item_name' => 'Night Vision Goggles',
        'item_description' => 'High-quality night vision goggles for low-light observation',
        'quantity' => 1,
        'unit_price' => 950.00,
        'total_price' => 950.00,
        'seller_name' => 'admin'
    ],
    [
        'receipt_id' => 2,
        'item_id' => 9, // Homemade Energy Bars
        'item_name' => 'Homemade Energy Bars',
        'item_description' => 'Pack of 12 homemade energy bars made from scavenged ingredients',
        'quantity' => 2,
        'unit_price' => 18.50,
        'total_price' => 37.00,
        'seller_name' => 'sarah.scavenger'
    ],
    
    // Receipt 3 items (guest order)
    [
        'receipt_id' => 3,
        'item_id' => 5, // Water Purification Tablets
        'item_name' => 'Water Purification Tablets',
        'item_description' => 'Pack of 50 water purification tablets',
        'quantity' => 3,
        'unit_price' => 24.99,
        'total_price' => 74.97,
        'seller_name' => 'admin'
    ],
    
    // Receipt 4 items (mike.trader's order)
    [
        'receipt_id' => 4,
        'item_id' => 11, // Scavenged Medical Kit
        'item_name' => 'Scavenged Medical Kit',
        'item_description' => 'Complete medical kit assembled from various sources',
        'quantity' => 1,
        'unit_price' => 125.00,
        'total_price' => 125.00,
        'seller_name' => 'sarah.scavenger'
    ]
];