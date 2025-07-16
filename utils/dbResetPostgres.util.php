<?php
declare(strict_types=1);

// 1) Composer autoload
require 'vendor/autoload.php';

// 2) Bootstrap
require 'bootstrap.php';

// 3) envSetter
require_once UTILS_PATH . 'envSetter.util.php';

// ——— Connecting to PostgreSQL ———
$dsn = "pgsql:host={$pgConfig['pg_host']};port={$pgConfig['pg_port']};dbname={$pgConfig['pg_db']}";
$pdo = new PDO($dsn, $pgConfig['pg_user'], $pgConfig['pg_pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

echo "🔄 Starting database reset...\n";

// First, drop all tables in correct order (reverse of dependencies)
$dropTables = [
    'receipt_items', 
    'receipts', 
    'cart', 
    'items', 
    'users'
];

echo "Dropping existing tables...\n";
foreach ($dropTables as $table) {
    try {
        $pdo->exec("DROP TABLE IF EXISTS public.\"$table\" CASCADE;");
        echo "✅ Dropped table: $table\n";
    } catch (PDOException $e) {
        echo "⚠️ Could not drop table $table: " . $e->getMessage() . "\n";
    }
}

// Then apply schemas
$sqlFiles = [
    'sql/users.model.sql',
    'sql/items.model.sql',      
    'sql/cart.model.sql',       
    'sql/receipts.model.sql'    
];

foreach ($sqlFiles as $file) {
    echo "Applying schema from {$file}...\n";

    if (!file_exists($file)) {
        echo "❌ File $file not found, skipping.\n";
        continue;
    }

    $sql = file_get_contents($file);
    if ($sql === false) {
        throw new RuntimeException("Could not read {$file}");
    }

    try {
        $pdo->exec($sql);
        echo "✅ Schema applied successfully from {$file}\n";
    } catch (PDOException $e) {
        echo "❌ Error applying schema from {$file}: " . $e->getMessage() . "\n";
        throw $e;
    }
}

echo "🎉 Database reset completed successfully.\n";
?>