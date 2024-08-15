<?php

namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:marvielb/job-rss.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('jobs.marvielb.com')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '~/job-rss');

// Hooks

before('deploy', function () {
    run('nix develop');
});

after('deploy:failed', 'deploy:unlock');
