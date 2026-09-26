<?php
$pdo = new PDO('mysql:host=localhost;port=3306', 'root', '');
$pdo->exec('CREATE DATABASE IF NOT EXISTS laravel');
echo "Database 'laravel' created successfully!\n";
