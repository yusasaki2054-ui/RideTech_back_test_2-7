<?php
declare(strict_types=1);
function ensure_session(): void {
  if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
      'httponly' => true,
      'samesite' => 'Lax',
      'secure'   => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    ]);
    session_start();
  }
}
function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function csrf_token(): string {
  ensure_session();
  if (empty($_SESSION['csrf_token'])) { $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); }
  return $_SESSION['csrf_token'];
}
function csrf_field(): string { return '<input type="hidden" name="csrf_token" value="'.e(csrf_token()).'">'; }
function verify_csrf(?string $t): bool { ensure_session(); return (!empty($t) && !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $t)); }
function flash_get(string $k, $d=null){ ensure_session(); $v=$_SESSION[$k]??$d; unset($_SESSION[$k]); return $v; }
function flash_set(string $k, $v): void { ensure_session(); $_SESSION[$k]=$v; }
function redirect_see_other(string $loc): void { header('Location: '.$loc, true, 303); exit; }
function csp_meta(): string { return '<meta http-equiv="Content-Security-Policy" content="default-src \'self\'; img-src \'self\' data:; object-src \'none\'; base-uri \'self\'; frame-ancestors \'none\'; form-action \'self\'">'; }
