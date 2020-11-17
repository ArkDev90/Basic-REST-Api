 <?php

    $db_user        = 'root';
    $db_password    = '';
    $db_name        = 'mydatabases_phprest';

    $db = new PDO('mysql:host=127.0.0.1;dbname='.$db_name.';charset=utf8', $db_user, $db_password);

    //set some db attributes
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, TRUE);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING ); 
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 

    define('APP_NAME', 'MY BASIC PHP REST');



?>