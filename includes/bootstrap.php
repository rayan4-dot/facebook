<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Session.php';
require_once __DIR__ . '/Auth.php';
require_once __DIR__ . '/helpers.php';

// Auto-load models
spl_autoload_register(function ($className) {
    if (file_exists(__DIR__ . '/../models/' . $className . '.php')) {
        require_once __DIR__ . '/../models/' . $className . '.php';
    }
});

Session::start();