<?php
namespace Deployer;

require 'recipe/common.php';

// Config
set('keep_releases', 5);
set('rsync_src', __DIR__);
set('release_path','/var/www/alexsimcap');

add('shared_files', ['wp-config.php']);
add('shared_dirs', ['wp-content/uploads']);
add('writable_dirs', []);

// Hosts
// Set an identitykey in /home/user/.ssh/config or ~/.ssh/config
host('prod.alexsim.co.uk')
    ->set('remote_user', 'deploy')
    ->set('hostname', 'prod.alexsim.co.uk')
    ->set('port', 22)
    ->set('deploy_path','{{release_path}}')
    ->set('rsync_src', '{{rsync_src}}')
    ->set('rsync_dest','{{release_path}}');

// Override deploy - to use rsync
task('deploy:update_code', function () {
    writeln("<info>Uploading files to server</info>");
    upload(__DIR__ . "/", '{{deploy_path}}' . "/releases/" . "{{release_name}}", ["options" => ["--exclude-from=deployment-exclude-list.txt"]]);
});

// Override symlink - to point to correct folder
task('deploy:shared', function () {
    $sharedPath = "{{deploy_path}}/shared";
    // Symlink Folders
    foreach (get('shared_dirs') as $dir) {
        run("{{bin/symlink}} $sharedPath/$dir {{deploy_path}}/releases/{{release_name}}/$dir");
    }
    // Symlink Files
    foreach (get('shared_files') as $file) {
        run("{{bin/symlink}} $sharedPath/$file {{deploy_path}}/releases/{{release_name}}/$file");
    }

});

// Update Database Variables
task('setup:upgrade', function(){
    writeln("<info>Updating Database Variables - Sets new version ID for js/css etc");
    run("cd {{deploy_path}}/releases/{{release_name}} && bin/wordpress setup:upgrade");
});


// Tasks
task('deploy', [
]);


// Hooks
// Before
// After
after('deploy:failed', 'deploy:unlock');