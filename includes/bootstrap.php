<?php
declare(strict_types=1);

session_start();

require __DIR__ . '/env.php';
require __DIR__ . '/db.php';
require __DIR__ . '/helpers.php';

const POST_TYPES = [
    'lost' => 'Lost',
    'found' => 'Found',
];

const POST_CATEGORIES = [
    'CIN',
    'Phone',
    'Document',
    'Wallet',
    'Other',
];
