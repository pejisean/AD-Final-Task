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

echo "🔄 Starting database reset (truncate only - preserving structure)...\n";

try {
    // Start a transaction for safety
    $pdo->beginTransaction();
    
    // Truncate tables in correct order (reverse of dependencies to avoid foreign key issues)
    $truncateTables = [
        'receipt_items', 
        'receipts', 
        'cart', 
        'items', 
        'users'
    ];

    echo "Truncating existing data...\n";
    
    // Disable foreign key checks temporarily
    $pdo->exec("SET session_replication_role = replica;");
    
    foreach ($truncateTables as $table) {
        try {
            // Check if table exists before truncating
            $checkQuery = "SELECT EXISTS (
                SELECT FROM information_schema.tables 
                WHERE table_schema = 'public' 
                AND table_name = ?
            )";
            $stmt = $pdo->prepare($checkQuery);
            $stmt->execute([$table]);
            $tableExists = $stmt->fetchColumn();
            
            if ($tableExists) {
                // TRUNCATE with RESTART IDENTITY to reset auto-increment sequences
                // CASCADE to handle foreign key dependencies
                $pdo->exec("TRUNCATE TABLE public.\"$table\" RESTART IDENTITY CASCADE;");
                echo "✅ Truncated table: $table\n";
            } else {
                echo "⚠️ Table $table does not exist, skipping truncation\n";
            }
        } catch (PDOException $e) {
            echo "⚠️ Could not truncate table $table: " . $e->getMessage() . "\n";
            // Continue with other tables instead of failing completely
        }
    }
    
    // Re-enable foreign key checks
    $pdo->exec("SET session_replication_role = DEFAULT;");
    
    // Optional: Create tables if they don't exist (for first-time setup)
    $createTablesIfNeeded = false; // Set to true if you want to create missing tables
    
    if ($createTablesIfNeeded) {
        echo "Checking for missing tables and creating if needed...\n";
        
        $sqlFiles = [
            'sql/users.model.sql',
            'sql/items.model.sql',      
            'sql/cart.model.sql',       
            'sql/receipts.model.sql'    
        ];

        foreach ($sqlFiles as $file) {
            if (!file_exists($file)) {
                echo "⚠️ File $file not found, skipping.\n";
                continue;
            }

            $sql = file_get_contents($file);
            if ($sql === false) {
                echo "❌ Could not read {$file}\n";
                continue;
            }

            try {
                // Only create tables if they don't exist (most schema files should have IF NOT EXISTS)
                $pdo->exec($sql);
                echo "✅ Schema checked/applied from {$file}\n";
            } catch (PDOException $e) {
                echo "⚠️ Note from {$file}: " . $e->getMessage() . "\n";
                // Continue anyway as this might just be "table already exists" errors
            }
        }
    }
    
    // Commit the transaction
    $pdo->commit();
    
    echo "🎉 Database reset (truncate) completed successfully.\n";
    echo "📊 All data has been cleared but table structures are preserved.\n";
    
    // Optional: Show table status
    echo "\n📋 Current table status:\n";
    $tablesQuery = "SELECT table_name FROM information_schema.tables WHERE table_schema = 'public' ORDER BY table_name";
    $stmt = $pdo->query($tablesQuery);
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    foreach ($tables as $table) {
        $countQuery = "SELECT COUNT(*) FROM public.\"$table\"";
        try {
            $stmt = $pdo->query($countQuery);
            $count = $stmt->fetchColumn();
            echo "  • $table: $count rows\n";
        } catch (PDOException $e) {
            echo "  • $table: Could not count rows\n";
        }
    }

} catch (Exception $e) {
    // Rollback on error
    if ($pdo->inTransaction()) {
        $pdo->rollback();
    }
    echo "❌ Error during database reset: " . $e->getMessage() . "\n";
    echo "❌ Stack trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}
?>