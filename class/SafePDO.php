<?php
class SafePDO extends PDO {

    public static function exception_handler($exception) {
        // Output the exception details
        die('Uncaught exception: '. $exception->getMessage());
    }

    public function __construct() {
        $dbConfig = parse_ini_file(__DIR__ . '/../config.ini');
        // Temporarily change the PHP exception handler while we . . .
        set_exception_handler(array(__CLASS__, 'exception_handler'));

        // . . . create a PDO object
        parent::__construct("mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']}", $dbConfig['user'], $dbConfig['password'], array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ));

        // Change the exception handler back to whatever it was before
        restore_exception_handler();
    }

}