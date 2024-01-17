<?php

// load the bootstrap file
require __DIR__ . '/src/bootstrap.php';

session_gc();

session_destroy();
