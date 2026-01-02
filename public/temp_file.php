<?php
require_once __DIR__ . '/../config/config.php';
var_dump(getenv('GROQ_API_KEY'));
var_dump($_ENV['GROQ_API_KEY'] ?? null);
var_dump($_SERVER['GROQ_API_KEY'] ?? null);