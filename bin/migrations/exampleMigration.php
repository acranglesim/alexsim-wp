<?php

class exampleMigration {
    public function __construct(
        wpdb $wpdb
    ) {
        $this->wpdb = $wpdb;
    }

    public function execute() {
        // Do some database stuff
        // create
        //$this->wpdb->insert('table', array('column' => 'value'));

        // retrieve
        // $results = $this->wpdb->get_results("select * from table");
        // foreach ($result as $result) ... $result->column

        // update
        //$this->wpdb->update('table', array('updateColumn' => "value"), array('whereColumn' => 'value'));

        // delete
        //$this->wpdb->delete('table', array('column' => 'value'));

        // custom
        //$this->wpdb->query("");
    }

    public function addMigrationEntry()
    {
        // Add record to stop it being run on future runs
        $className = get_class();
        $this->wpdb->insert('wp_alexsim_migrations_list', array('name' => $className));
        echo "Installed: " . $className . PHP_EOL;
    }
}