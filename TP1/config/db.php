<?php
    //$HOST       = 'host.docker.internal';
    $HOST       = 'tp1-db-1';
    $PORT       =  3306;
    $DBNAME     = 'Universite3';
    $USER       = 'root';
    $PASSWORD   = 'root';

    $options = [ 
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
        PDO::ATTR_EMULATE_PREPARES => false, // Force l'utilisation de vraies requêtes préparées 
    ]; 


    $dbConnection = new PDO("mysql:host=$HOST;port=$PORT;dbname=$DBNAME", $USER, $PASSWORD, $options);
?>