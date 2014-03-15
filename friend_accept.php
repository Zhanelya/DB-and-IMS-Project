<?php
    session_start();
    $userid = $_SESSION['userid'];
    require_once 'connection.php';
    //Connect to DB
    $conn = connect($host,$user,$pwd,$db);
    
    if(isset($_GET['id'])){
        try {
            $fid = intval($_GET['id']);
            $sql_select = "SELECT id FROM friendship WHERE user1_id='$fid' AND user2_id='$userid'";
            $stmt = $conn->query($sql_select);
            $friends = $stmt->fetchAll(); 
            $friendship_id = $friends[0]['id'];
            $sql_update = "UPDATE friendship SET status_approved=1 WHERE id='$friendship_id'";
            $stmt = $conn->query($sql_update);        
        }catch(Exception $e) {
                die(var_dump($e));
        }
    }
    //Disconnect from DB
    $conn = null;
?>
