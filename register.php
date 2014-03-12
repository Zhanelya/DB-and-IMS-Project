<?php
        require_once 'connection.php';
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
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $dob = $_POST['dob'];
            if(isset($_POST['gender'])) $gender = $_POST['gender'];
            
            // Insert data
            $sql_select = "SELECT * FROM users WHERE name='$name'";
            $stmt = $conn->query($sql_select);
            $registrants = $stmt->fetchAll(); 
            if(count($registrants) > 0) {
                echo "User already exists";
                header('refresh:2; ..#/register');
            } else {
                //Update users table
                $sql_insert = "INSERT INTO users (name, pswd, email, date) 
                       VALUES (?,?,?,?)";
                $stmt = $conn->prepare($sql_insert);
                $stmt->bindValue(1, $name);
                $stmt->bindValue(2, $password);
                $stmt->bindValue(3, $email);
                $stmt->bindValue(4, $date);
                $stmt->execute();
                
                //Update profile table
                $stmt = $conn->query($sql_select);
                $registrant = $stmt->fetchAll(); 
                $acc_id = array_values($registrant)[0]['acc_id'];
                $sql_insert = "INSERT INTO profile (acc_id, fname, lname, dob, gender) 
                       VALUES (?,?,?,?,?)";
                $stmt = $conn->prepare($sql_insert);
                $stmt->bindValue(1, $acc_id);
                $stmt->bindValue(2, $fname);
                $stmt->bindValue(3, $lname);
                $stmt->bindValue(4, $dob);
                $stmt->bindValue(5, $gender);
                $stmt->execute();
                
                echo "You are successfully registered, please log in";
                header('refresh:3; ..#/login');
            }
        }
        catch(Exception $e) {
            die(var_dump($e));
        }
        }
        $conn = null;
?>