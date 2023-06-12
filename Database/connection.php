<?php 
           
    $con = null;
    function connect_db()
    {
        global $con;
        $con = NULL;

        $servername     = 'localhost';
        $username       = 'root';
        $password       = '';
        $db_name        = 'university_election';

        // Set DSN
        $dsn ="mysql:host=$servername;dbname=$db_name";
        $option = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        // Create a PDO instance
        try{
            $con = new PDO($dsn, $username, $password, $option);

            $con = $con;
        }
        catch(\PDOExecption $e){
            echo  "DB Connectivity error" ;
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
            $con = NULL;
        }       
    }

    function disconnect_db()
    {
        global $db_myats;
        $con = NULL;
    }
?>