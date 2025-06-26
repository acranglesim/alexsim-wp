<?php
global $wpdb;
$migrations = $wpdb->get_results("select name from wp_alexsim_migrations_list");
$migrationsPath = "bin/migrations/";
$targetDirectory = $migrationsPath;
$files = glob($targetDirectory . "*.*");
foreach ($files as $file) {
    $pathInfo = pathinfo($file);
    $pathToFile = $pathInfo["dirname"] . "/" . $pathInfo["basename"];
    $className = $pathInfo["filename"];
    // Skip over the example
    if ($className === "exampleMigration") {
        continue;
    }
    foreach ($migrations as $migration) {
        // If we have already installed the migration - skip over
        if ($migration->name === $className) {
            echo "Already installed: " . $className . PHP_EOL;
            continue 2;
        }
    }

    require_once($pathToFile);
    $class = new $className($wpdb);
    $class->execute();
    $class->addMigrationEntry();
}

// TODO: increase css version
$cssVersion = (int) get_option('css_version');
$newCssVersion = $cssVersion + 1;
$wpdb->update('wp_options', array('option_value' => $newCssVersion), array('option_name' => 'css_version'));