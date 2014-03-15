<?php
    require_once 'connection.php';
    //Connect to DB
    $conn = connect($host,$user,$pwd,$db);
    session_start();
    $userid = $_SESSION['userid'];
    try {
        $q = intval($_GET['q']);
        $sql_select = "SELECT p.fname, p.lname, p.acc_id, f.status_approved,f.user2_id
                       FROM profile p , friendship f 
                       WHERE ((f.user1_id = '".$q."' AND f.user2_id = p.acc_id)
                               OR 
                              (f.user2_id = '".$q."' AND f.user1_id = p.acc_id))
                       ORDER BY p.fname ASC";
        $stmt = $conn->query($sql_select);
        $friends=$stmt->fetchAll(); 
        echo "<br><h4>Friends List</h4>";
        if(count($friends) > 0) {
            foreach($friends as $friend)
              {
                if($friend['status_approved']==1){
                    echo "<a href=\"..#/p_profile?".$friend['acc_id']."/\"><div class=\"row-fluid friends_block\"><h5>".$friend['fname']." ".$friend['lname']."</h5></div></a>";
                }  
              }
        }
        echo "<br><h4>Friend Requests</h4>";
            foreach($friends as $friend)
              {
                if($friend['status_approved']==0 and $friend['user2_id']==$userid){
                    echo "<a href=\"..#/p_profile?".$friend['acc_id']."/\"><div class=\"row-fluid friends_block\"><h5>".$friend['fname']." ".$friend['lname']."</h5></div></a>";
                    echo "<button onclick=\"accept_friend(".$friend['acc_id'].")\">Accept</button> ";
                    echo " <button onclick=\"unfriend(".$friend['acc_id'].");setTimeout(function(){window.location.reload();},2000);\">Decline</button>";
                }  
              }
    }catch(Exception $e) {
            die(var_dump($e));
    }
    //Disconnect from DB
    $conn = null;
?>