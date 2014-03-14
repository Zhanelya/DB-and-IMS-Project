<?php
    require_once 'connection.php';
    //Connect to DB
    $conn = connect($host,$user,$pwd,$db);
    try {
        $q = intval($_GET['q']);
        $sql_select = "SELECT p.fname, p.lname, p.acc_id
                       FROM profile p , friendship f 
                       WHERE ((f.user1_id = '".$q."' AND f.user2_id = p.acc_id)
                               OR 
                              (f.user2_id = '".$q."' AND f.user1_id = p.acc_id))
                              AND f.status_approved=1
                       ORDER BY p.fname DESC";
        $stmt = $conn->query($sql_select);
        $friends=$stmt->fetchAll(); 
        if(count($friends) > 0) {
            foreach($friends as $friend)
              {
                echo "<a href=\"#/p_profile?".$friend['acc_id']."/\"><div class=\"row-fluid friends_block\"><h5>".$friend['fname']." ".$friend['lname']."</h5></div></a>";
              }
        }
    }catch(Exception $e) {
            die(var_dump($e));
    }
    //Disconnect from DB
    $conn = null;
?>