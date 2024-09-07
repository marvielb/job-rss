<?php

namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'https://github.com/marvielb/job-rss.git');
set('branch', 'flake');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('jobs.marvielb.com')
    ->set('remote_user', 'jobs')
    ->set('port', 1022)
    ->set('deploy_path', '~/');

task('bun:build', function () {
    run('cd {{release_path}} && bun install --omit=dev');
    run('cd {{release_path}} && bun run build');
})->desc('Compile npm files locally');

// Hooks
after('deploy:update_code', function () {
    $file_contents = file_get_contents('./.env.prod', FILE_TEXT);
    run('touch ./shared/.env');
    run("echo '{$file_contents}' > ./shared/.env");
});

after('deploy:vendors', function () {
    run('cd release && composer install');
});
after('deploy:vendors', 'bun:build');

after('deploy:failed', 'deploy:unlock');
