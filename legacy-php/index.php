<?php
/**
 * Root Bridge / Fallback Handler
 * Memungkinkan website langsung berjalan baik jika DocumentRoot diarahkan ke folder root maupun folder public
 */

// Arahkan ke public/index.php
require_once __DIR__ . '/public/index.php';
