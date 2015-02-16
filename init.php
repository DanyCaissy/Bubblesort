<?php

    // Enable error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    // Set the relevant timezone
    date_default_timezone_set('America/Montreal');

    // Start sessions
    session_cache_limiter(false);
    session_start();
