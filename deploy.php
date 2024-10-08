<?php

namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'https://github.com/marvielb/job-rss.git');
set('branch', 'master');
set('bin/composer', '/etc/profiles/per-user/{{remote_user}}/bin/composer');
set('bin/php', '/etc/profiles/per-user/{{remote_user}}/bin/php');
set('keep_releases', 1);

add('shared_files', ['database/database.sqlite', '.env']);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('aws.box') //set in the etc hosts file
    ->set('remote_user', 'jobs')
    ->set('port', 1022)
    ->set('deploy_path', '~/');

// Tasks
task('bun:build', function () {
    runLocally('nix develop --command bash -c "bun install --omit=dev"');
    runLocally('nix develop --command bash -c "bun run build"');
    upload('./public/build/', '{{release_path}}/public/build');
})->desc('Build bun files locally and deploy');

task('artisan:app:scrape', artisan('app:scrape', ['showOutput']));

// Hooks

after('deploy:vendors', 'bun:build');

after('deploy:failed', 'deploy:unlock');
