<?php
    session_start();
    $userid = $_SESSION['userid'];
    require_once 'connection.php';
    //Connect to DB
    $conn = connect($host,$user,$pwd,$db);

    if(isset($_GET['id'])){
        try {
            $fid = intval($_GET['id']);
            //Check if exists
            $sql_select = "SELECT id,status_approved,user2_id FROM friendship WHERE user1_id='$userid' AND user2_id='$fid'";
            $stmt = $conn->query($sql_select);
            $friends = $stmt->fetchAll(); 
            if (count ($friends) <= 0){
                //Update friendship table
                $sql_insert = "INSERT INTO friendship (user1_id, user2_id, status_approved) 
                       VALUES (?,?,?)";
                $stmt = $conn->prepare($sql_insert);
                $stmt->bindValue(1, $userid);
                $stmt->bindValue(2, $fid);
                $stmt->bindValue(3, 0);
                $stmt->execute();

                //Update activity table
                $stmt = $conn->query($sql_select);
                $friends = $stmt->fetchAll(); 
                $a_id = array_values($friends)[0]['id'];
                $date = new DateTime();
                $date = $date->format('Y-m-d H:i:s');
                try{
                    $sql_insert = "INSERT INTO activity (acc_id, timestmp, category_id, a_id) 
                           VALUES (?,?,?,?)";
                    $stmt = $conn->prepare($sql_insert);
                    $stmt->bindValue(1, $userid);
                    $stmt->bindValue(2, $date);
                    $stmt->bindValue(3, 1);
                    $stmt->bindValue(4, $a_id);
                    $stmt->execute();
                }
                catch(Exception $e) {
                    die();
                }
            }
            echo "Friend request sent";
        }
        catch(Exception $e) {
            die(var_dump($e));
        }
    }else{
        echo "Error, please try again";
    }
    //Disconnect from DB
    $conn = null;
?>
