<?php

declare(strict_types=1);

use AspectMock\Kernel;

include codecept_root_dir('vendor/autoload.php'); // composer autoload.
$kernel = Kernel::getInstance();
$kernel->init(
    [
        'debug' => true,
        'includePaths' => [
            codecept_root_dir('src/'),
        ],
    ]
);
