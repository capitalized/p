<?php

use spark\middlewares\CsrfGuard\CsrfGuard;

// Add CSRF Guard
if (session_id() !== '') {
    $app->add(new CsrfGuard);
}
