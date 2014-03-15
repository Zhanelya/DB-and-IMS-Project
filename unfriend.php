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
                $sql_delete = "DELETE FROM friendship WHERE (user1_id='$userid' AND user2_id='$fid')
                                                         OR (user1_id='$fid' AND user2_id='$userid')";
                $stmt = $conn->query($sql_delete);
            }
            catch(Exception $e) {
                die();
            }
            echo "You are no longer friends";
        }else{
            echo "Error, please try again";
        }
    //Disconnect from DB
    $conn = null;
?>
