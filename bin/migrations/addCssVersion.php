<?php

class addCssVersion {
    public function __construct(
        wpdb $wpdb
    ) {
        $this->wpdb = $wpdb;
    }

    public function execute() {
        $this->wpdb->insert('wp_options', array('option_name' => 'css_version', 'option_value' => 1));
    }

    public function addMigrationEntry(): void
    {
        // Add record to stop it being run on future runs
        $className = get_class();
        $this->wpdb->insert('wp_alexsim_migrations_list', array('name' => $className));
        echo "Installed: " . $className . PHP_EOL;
    }
}