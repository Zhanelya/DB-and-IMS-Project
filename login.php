<?php
        require_once 'connection.php';
        //Connect to DB
        $conn = connect($host,$user,$pwd,$db);
        session_start();
        //Check login info
        try {
            if (!isset($_SESSION['userID'])) { 
                $name = $_POST['name'];
                $password = $_POST['password'];
                    if ($name&&$password) {
                        $sql_select = "SELECT * FROM users WHERE name='$name' AND pswd='$password'";
                        $stmt = $conn->query($sql_select);
                        $registrants = $stmt->fetchAll(); 
                        if(count($registrants) > 0) {
                            $_SESSION['userid'] = $registrants[0]['acc_id'];
                            $_SESSION['username'] = $name;
                            setcookie('userid', $registrants[0]['acc_id'], 
                            time() + (60 * 60 * 24 * 30));
                            setcookie('username', $name,
                            time() + (60 * 60 * 24 * 30));
                            $response_array['status'] = 'success';
                            $response_array['id'] = $registrants[0]['acc_id'];
                            $response_array['msg'] = "You are successfully logged in";
                            echo json_encode($response_array);
                        }else{
                            $response_array['status'] = 'error';
                            $response_array['msg'] = "Your have entered wrong password or login details";
                            echo json_encode($response_array);
                        }
                    }else{
                        $response_array['status'] = 'error';
                        $response_array['msg'] = "You are required to fill all the fields";
                        echo json_encode($response_array);
                    }
                }
            }    
            catch(Exception $e) {
                die(var_dump($e));
            }
        //Disconnect from DB
        $conn = null;
?>
