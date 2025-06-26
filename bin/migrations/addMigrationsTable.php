<?php

class addMigrationsTable {
    public function __construct(
      wpdb $wpdb
    ) {
        $this->wpdb = $wpdb;
    }

    public function execute() {
        $this->wpdb->query("CREATE TABLE wp_alexsim_migrations_list(entity_id int auto_increment primary key, name varchar(255))");
    }

    public function addMigrationEntry(): void
    {
        // Add record to stop it being run on future runs
        $className = get_class();
        $this->wpdb->insert('wp_alexsim_migrations_list', array('name' => $className));
        echo "Installed: " . $className . PHP_EOL;
    }
}