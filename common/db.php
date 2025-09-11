<?php
declare(strict_types=1);
function load_dotenv(string $path): void {
  if (!is_file($path)) return;
  foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
    if (str_starts_with(trim($line), '#')) continue;
    [$k,$v]=array_map('trim', explode('=', $line, 2));
    if ($k!=='' && !isset($_ENV[$k])) { $_ENV[$k]=$v; putenv("$k=$v"); }
  }
}
function pdo(): PDO {
  static $pdo=null; if ($pdo instanceof PDO) return $pdo;
  $env=dirname(__DIR__).'/.env'; if (is_file($env)) load_dotenv($env);
  $host=$_ENV['DB_HOST']??getenv('DB_HOST')?:'127.0.0.1';
  $port=(int)($_ENV['DB_PORT']??getenv('DB_PORT')?:3306);
  $name=$_ENV['DB_NAME']??getenv('DB_NAME')?:'appdb';
  $user=$_ENV['DB_USER']??getenv('DB_USER')?:'app';
  $pass=$_ENV['DB_PASS']??getenv('DB_PASS')?:'app';
  $dsn="mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";
  $pdo=new PDO($dsn,$user,$pass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]);
  return $pdo;
}
