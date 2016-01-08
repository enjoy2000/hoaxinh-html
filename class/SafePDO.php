<?php

class SafePDO extends PDO
{
    public static function exception_handler($exception)
    {
        // Output the exception details
        die('Uncaught exception: '.$exception->getMessage());
    }

    public function __construct()
    {
        $dbConfig = include __DIR__.'/../config.php';
        // Temporarily change the PHP exception handler while we . . .
        set_exception_handler([__CLASS__, 'exception_handler']);

        // . . . create a PDO object
        parent::__construct("mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']}", $dbConfig['user'], $dbConfig['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        ]);

        // Change the exception handler back to whatever it was before
        restore_exception_handler();
    }
}
