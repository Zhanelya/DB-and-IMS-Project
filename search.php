<?php
    require_once 'connection.php';
    //Connect to DB
    $conn = connect($host,$user,$pwd,$db);
    try {
        session_start();
        $userid = $_SESSION['userid'];
        $fullname = $_GET['name'];
        $name = explode(" ", $fullname);
        $sql_select = "SELECT p.fname, p.lname, p.acc_id
                       FROM profile p
                       WHERE  (UPPER(p.fname)=UPPER('".$name[0]."')
                          OR  UPPER(p.lname)=UPPER('".$name[0]."'))
                          AND (p.acc_id != '$userid')    
                       ORDER BY p.fname ASC";
        $stmt = $conn->query($sql_select);
        $people=$stmt->fetchAll(); 
        if(count($people) > 0) {
            foreach($people as $person)
              {
                $sql_select = " SELECT f.user1_id, f.status_approved
                                FROM friendship f
                                WHERE  (f.user1_id = '".$person['acc_id']."' AND f.user2_id = '".$userid."')
                                   OR  (f.user2_id = '".$person['acc_id']."' AND f.user1_id = '".$userid."')";
                 $stmt = $conn->query($sql_select);
                 $arefriends=$stmt->fetchAll();          
                 echo "<div class=\"row-fluid friends_block\"><h5><a href=\"..#/p_profile?".$person['acc_id']."/\">".$person['fname']." ".$person['lname']."</a>";
                 echo "<div id=\"fmsg_".$person['acc_id']."\" class=\"friend_msg\"></div>";
                 if(count ($arefriends)>0){
                    if ($arefriends[0]['status_approved']==0){
                       echo "<button class=\"requested_friend\" id=\"req_\" onclick=\"friend_a_person(".$person['acc_id'].")\">Request Sent</button>";
                    }else{
                       echo "<button class=\"are_friends\" id=\"friends_".$person['acc_id']."\" onclick=\"unfriend(".$person['acc_id'].")\">Unfriend</button>";
                    }
                 }else{
                       echo "<button class=\"add_friend\" id=\"addfr_".$person['acc_id']."\" onclick=\"friend_a_person(".$person['acc_id'].")\">+1 Add Friend</button>";
                 }
                 echo "</h5></div>";
              }
        }
    }catch(Exception $e) {
            die(var_dump($e));
    }
    //Disconnect from DB
    $conn = null;
?>