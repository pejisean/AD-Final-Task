<?php
declare(strict_types=1);


require 'vendor/autoload.php';
require 'bootstrap.php';
require_once UTILS_PATH . '/envSetter.util.php';

echo "🔄 Starting database migration (drop and recreate tables)...\n";

try {
    // Connect to PostgreSQL using PDO
    $dsn = "pgsql:host={$pgConfig['pg_host']};port={$pgConfig['pg_port']};dbname={$pgConfig['pg_db']}";
    $pdo = new PDO($dsn, $pgConfig['pg_user'], $pgConfig['pg_pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    echo "✅ Connected to PostgreSQL successfully!\n";

    // Start a transaction for safety
    $pdo->beginTransaction();

    // Drop existing tables first (in reverse dependency order)
    dropExistingTables($pdo);

    // Create new tables (in dependency order)
    createTables($pdo);

    // Commit the transaction
    $pdo->commit();

    echo "🎉 Database migration completed successfully!\n";
    echo "📊 All tables have been recreated with fresh structure.\n";

    // Optional: Show table status
    echo "\n📋 Created tables:\n";
    showTableStatus($pdo);

} catch (Exception $e) {
    // Rollback on error
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollback();
    }
    echo "❌ Error during database migration: " . $e->getMessage() . "\n";
    echo "❌ Stack trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}

// ===== MIGRATION FUNCTIONS =====

function dropExistingTables($pdo)
{
    echo "🧹 Dropping existing tables...\n";

    // Drop tables in reverse dependency order to avoid foreign key issues
    $dropTables = [
        'receipt_items',
        'receipts',
        'cart',
        'items',
        'users'
    ];

    // Disable foreign key checks temporarily
    $pdo->exec("SET session_replication_role = replica;");

    foreach ($dropTables as $table) {
        try {
            // Check if table exists before dropping
            $checkQuery = "SELECT EXISTS (
                SELECT FROM information_schema.tables 
                WHERE table_schema = 'public' 
                AND table_name = ?
            )";
            $stmt = $pdo->prepare($checkQuery);
            $stmt->execute([$table]);
            $tableExists = $stmt->fetchColumn();

            if ($tableExists) {
                $pdo->exec("DROP TABLE IF EXISTS public.\"$table\" CASCADE;");
                echo "❌ Dropped table: $table\n";
            } else {
                echo "⚠️ Table $table does not exist, skipping drop\n";
            }
        } catch (PDOException $e) {
            echo "⚠️ Could not drop table $table: " . $e->getMessage() . "\n";
            // Continue with other tables instead of failing completely
        }
    }

    // Re-enable foreign key checks
    $pdo->exec("SET session_replication_role = DEFAULT;");
}

function createTables($pdo)
{
    echo "🏗️ Creating new tables...\n";

    // Create tables in dependency order
    $modelFiles = [
        'users.model.sql',
        'items.model.sql',
        'cart.model.sql',
        'receipts.model.sql',
        'receipt_items.model.sql'
    ];

    foreach ($modelFiles as $modelFile) {
        $filePath = "sql/$modelFile";

        if (!file_exists($filePath)) {
            echo "⚠️ Model file $filePath not found, skipping.\n";
            continue;
        }

        echo "📄 Applying schema from $filePath...\n";

        $sql = file_get_contents($filePath);
        if ($sql === false) {
            throw new RuntimeException("❌ Could not read $filePath");
        }

        try {
            $pdo->exec($sql);
            echo "✅ Created table from $modelFile\n";
        } catch (PDOException $e) {
            throw new RuntimeException("❌ Failed to create table from $modelFile: " . $e->getMessage());
        }
    }
}

function showTableStatus($pdo)
{
    try {
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
        echo "⚠️ Could not show table status: " . $e->getMessage() . "\n";
    }
}