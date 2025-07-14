<?php
    declare(strict_types=1);

    // 1) Composer autoload
    require 'vendor/autoload.php';

    // 2) Composer bootstrap
    require 'bootstrap.php';

    // 3) envSetter
    require_once UTILS_PATH . 'envSetter.util.php';

    // ——— Connecting to PostgreSQL ———
    $dsn = "pgsql:host={$pgConfig['pg_host']};port={$pgConfig['pg_port']};dbname={$pgConfig['pg_db']}";
    $pdo = new PDO($dsn, $pgConfig['pg_user'], $pgConfig['pg_pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    // Listing SQL files in correct order (respecting foreign key dependencies)
    $sqlFiles = [
        'sql/users.model.sql',      // Must be first (referenced by others)
        'sql/items.model.sql',      // Second (references users)
        'sql/cart.model.sql',       // Third (references users and items)
        'sql/receipts.model.sql'    // Last (references users and items)
    ];

    foreach ($sqlFiles as $file) {
        echo "Applying schema from {$file}...\n";

        if (!file_exists($file)) {
            echo "[ERROR] File $file not found, skipping.\n";
            continue;
        }

        $sql = file_get_contents($file);
        if ($sql === false) {
            throw new RuntimeException("Could not read {$file}");
        }

        $pdo->exec($sql);
        echo "✅ Schema applied successfully from {$file}\n";
    }

    // Seeding tables with static data
    echo "\nSeeding tables with static data...\n";

    // Define mapping of tables to their static data files (PHP files returning arrays)
    $seedFiles = [
        'users' => DUMMIES_PATH . '/users.staticData.php',
        'items' => DUMMIES_PATH . '/items.staticData.php',
    ];

    // Loop over each table and seed data
    foreach ($seedFiles as $table => $seedFile) {
        echo "Seeding table: $table from $seedFile\n";

        if (!file_exists($seedFile)) {
            echo "⚠️ Seed file $seedFile not found, skipping.\n";
            continue;
        }

        // Load static data array from seed file
        $data = require $seedFile;

        if (!is_array($data) || empty($data)) {
            echo "⚠️ Seed file $seedFile did not return a valid array, skipping.\n";
            continue;
        }

        // Optional: Clear existing data before seeding
        // $pdo->exec("TRUNCATE TABLE public.\"$table\" RESTART IDENTITY CASCADE;");

        // Prepare insert statement dynamically based on keys of first row
        $columns = array_keys($data[0]);
        $columnsList = implode(', ', array_map(fn($col) => "\"$col\"", $columns));
        $placeholders = implode(', ', array_map(fn($col) => ":$col", $columns));

        $insertSql = "INSERT INTO public.\"$table\" ($columnsList) VALUES ($placeholders) ON CONFLICT DO NOTHING";
        $stmt = $pdo->prepare($insertSql);

        // Insert each row
        $insertedCount = 0;
        foreach ($data as $row) {
            try {
                // Bind values dynamically
                foreach ($row as $col => $val) {
                    $stmt->bindValue(":$col", $val);
                }
                $stmt->execute();
                $insertedCount++;
            } catch (PDOException $e) {
                echo "⚠️ Skipping duplicate row in $table: " . $e->getMessage() . "\n";
            }
        }

        echo "✅ Seeded $insertedCount rows into $table.\n";
    }

    echo "\n🎉 Database setup completed successfully!\n";
?>