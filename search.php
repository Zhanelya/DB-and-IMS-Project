<?php
    require_once 'connection.php';
    //Connect to DB
    $conn = connect($host,$user,$pwd,$db);
    try {
        $fullname = $_GET['name'];
        $name = explode(" ", $fullname);
        $sql_select = "SELECT p.fname, p.lname, p.acc_id
                       FROM profile p
                       WHERE  UPPER(p.fname)=UPPER('".$name[0]."')
                          OR  UPPER(p.lname)=UPPER('".$name[0]."')
                       ORDER BY p.fname ASC";
        $stmt = $conn->query($sql_select);
        $people=$stmt->fetchAll(); 
        if(count($people) > 0) {
            foreach($people as $person)
              {
                $sql_select = " SELECT f.user1_id
                                FROM friendship f
                                WHERE  f.user1_id = '".$person['acc_id']."'
                                   OR  f.user2_id = '".$person['acc_id']."'";
                 $stmt = $conn->query($sql_select);
                 $arefriends=$stmt->fetchAll();          
                 echo "<div class=\"row-fluid friends_block\"><h5><a href=\"..#/p_profile?".$person['acc_id']."/\">".$person['fname']." ".$person['lname']."</a>";
                 if(count ($arefriends)>0){
                     echo "<button id=\"are_friends\">Friends</button>";
                 }else{
                     echo "<button id=\"add_friend\">+1 Add Friend</button>";
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