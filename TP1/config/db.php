<?php
    //$HOST       = 'host.docker.internal';
    $HOST       = 'tp1-db-1';
    $PORT       =  3306;
    $DBNAME     = 'Universite2';
    $USER       = 'root';
    $PASSWORD   = 'root';

    $dbConnection = new PDO("mysql:host=$HOST;port=$PORT;dbname=$DBNAME", $USER, $PASSWORD);
?>