<?php
        require_once 'connection.php';
        //Connect to DB
        $conn = connect($host,$user,$pwd,$db);
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
            if(!isset($_POST['dob'])||!isset($_POST['gender'])) {
                $response_array['status'] = 'error';
                $response_array['msg'] = "You are required to fill all the fields!";
                echo json_encode($response_array);
            }else{
                $dob = $_POST['dob'];
                $gender = $_POST['gender'];
                if ($fname&&$lname&&$name&&$em&&$em2&&$password&&$date) {
                    // Insert data
                    $sql_select = "SELECT * FROM users WHERE name='$name'";
                    $stmt = $conn->query($sql_select);
                    $registrants = $stmt->fetchAll(); 
                    if(count($registrants) > 0) {
                        $response_array['status'] = 'error';
                        $response_array['msg'] = "User already exists";
                        echo json_encode($response_array);
                    }
                    else if ($em!=$em2) {
                        $response_array['status'] = 'error';
                        $response_array['msg'] = "You have entered different emails";
                        echo json_encode($response_array);
                    }
                    else if (strlen($name)>25||strlen($fname)>25||strlen($lname)>25) {
                        $response_array['status'] = 'error';
                        $response_array['msg'] = "The maximum limit for username/first name/last name is 25 characters!";
                        echo json_encode($response_array);
                    }
                    else if (strlen($password)>30||strlen($password)<5) {
                        $response_array['status'] = 'error';
                        $response_array['msg'] = "Your password must be between 5 and 30 characters long!";
                        echo json_encode($response_array);
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
                    
                    $response_array['status'] = 'success';
                    $response_array['msg'] = "You are successfully registered, please log in";
                    echo json_encode($response_array);
                    }
                }
                else{
                    $response_array['status'] = 'error';
                    $response_array['msg'] = "You are required to fill all the fields!";
                    echo json_encode($response_array);
                }
            }
        }
        catch(Exception $e) {
            die(var_dump($e));
        }
        }
        //Disconnect from DB
        $conn = null;
?>