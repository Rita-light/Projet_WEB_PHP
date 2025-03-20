<?php
    $HOST       = 'host.docker.internal';
    $PORT       =  3306;
    $DBNAME     = 'test';
    $USER       = 'test';
    $PASSWORD   = 'test';

    $db = new PDO("mysql:host=$HOST;port=$PORT;dbname=$DBNAME", $USER, $PASSWORD);
?>