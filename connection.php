<?php
        $host = "eu-cdbr-azure-west-b.cloudapp.net";
        $user = "b6a70abeba0a70";
        $pwd = "6d447729";
        $db = "comp3013";
        
        function connect ($host,$user,$pwd,$db) {
            try {
                $conn = new PDO( "mysql:host=$host;dbname=$db", $user, $pwd);
                $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            }
            catch(Exception $e){
                die(var_dump($e));
            }
        return $conn;
        }
?>
