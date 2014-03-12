<?php
        // DB connection info
        //TODO: Update the values for $host, $user, $pwd, and $db
        //using the values you retrieved earlier from the portal.
        $host = "eu-cdbr-azure-west-b.cloudapp.net";
        $user = "b6a70abeba0a70";
        $pwd = "6d447729";
        $db = "comp3013";
        // Connect to database.
        try {
            $conn = new PDO( "mysql:host=$host;dbname=$db", $user, $pwd);
            $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        }
        catch(Exception $e){
            die(var_dump($e));
        }
        // Insert registration info
        if(!empty($_POST)) {
        try {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $date = date("Y-m-d");
            $password = $_POST['password'];
            // Insert data
            $sql_insert = "INSERT INTO users (name, pswd, email, date) 
                       VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $name);
            $stmt->bindValue(2, $password);
            $stmt->bindValue(3, $email);
            $stmt->bindValue(4, $date);
            $stmt->execute();
        }
        catch(Exception $e) {
            die(var_dump($e));
        }
        header('Location:..#/login');
        }
        $conn = null;
?>