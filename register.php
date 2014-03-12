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
$em = strip_tags(@$_POST['email']);
$em2 = strip_tags(@$_POST['email_c']);

            $name = $_POST['name'];
            $email = $_POST['email'];
            $date = date("Y-m-d");
            $password = $_POST['password'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $dob = $_POST['dob'];
 

if ($fname&&$lname&&$name&&$em&&$em2&&$password&&$date) {
        
            if(isset($_POST['gender'])) $gender = $_POST['gender'];
            
            // Insert data
            $sql_select = "SELECT * FROM users WHERE name='$name'";
            $stmt = $conn->query($sql_select);
            $registrants = $stmt->fetchAll(); 
            if(count($registrants) > 0) {
                echo "User already exists";
                header('refresh:2; ..#/register');
            }

            else if ($em!=$em2) {
                echo "Different emails";
                header('refresh:2; ..#/register');
            }

            else if (strlen($name)>25||strlen($fname)>25||strlen($lname)>25) {
                echo "The maximum limit for username/first name/last name is 25 characters!";
                header('refresh:2; ..#/register');
            }
            else if (strlen($password)>30||strlen($password)<5) {
                echo "Your password must be between 5 and 30 characters long!";
                header('refresh:2; ..#/register');
            }


 else {
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
else{

    echo "You are required to fill all the fields!";
    header('refresh:2; ..#/register');
}

        }

        catch(Exception $e) {
            die(var_dump($e));
        }
        }




        $conn = null;
?>