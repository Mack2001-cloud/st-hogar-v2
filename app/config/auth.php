<?php
declare(strict_types=1);

/**
 * Configuración de autenticación
 * Ajusta AUTH_COOKIE_SECURE a true cuando uses HTTPS.
 */

const AUTH_SESSION_NAME  = 'st_hogar_session';
const AUTH_LOGIN_PATH    = '/app/auth/login.php';
const AUTH_HOME_PATH     = '/public/index.php';
const AUTH_COOKIE_SECURE = false;


