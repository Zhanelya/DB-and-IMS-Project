<?php
    require_once 'connection.php';
    //Connect to DB
    $conn = connect($host,$user,$pwd,$db);
    try {
        $fullname = $_GET['name'];
        $name = explode(" ", $fullname);
        $sql_select = "SELECT p.fname, p.lname, p.acc_id
                       FROM profile p 
                       WHERE UPPER(p.fname)=UPPER('".$name[0]."')
                          OR UPPER(p.lname)=UPPER('".$name[0]."')
                       ORDER BY p.fname ASC";
        $stmt = $conn->query($sql_select);
        $people=$stmt->fetchAll(); 
        if(count($people) > 0) {
            foreach($people as $person)
              {
                echo "<a href=\"..#/p_profile?".$person['acc_id']."/\"><div class=\"row-fluid friends_block\"><h5>".$person['fname']." ".$person['lname']."</h5></div></a>";
              }
        }
    }catch(Exception $e) {
            die(var_dump($e));
    }
    //Disconnect from DB
    $conn = null;
?>