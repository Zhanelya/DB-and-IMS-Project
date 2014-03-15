<?php
    session_start();
    $userid = $_SESSION['userid'];
    require_once 'connection.php';
    //Connect to DB
    $conn = connect($host,$user,$pwd,$db);
    $data = $_POST['data'];
    if(isset($data)){
        try {
            foreach($data as $field){
                if($field['id']=='bday'){
                    $bday=$field['val'];
                }
                if($field['id']=='bmonth'){
                    $bmonth=$field['val'];
                }
                if($field['id']=='byear'){
                    $byear=$field['val'];
                }
                if($field['id']=='gender'){
                    $gender= substr($field['val'], 0, 1);
                }
                if($field['id']=='country'){
                    $country=$field['val'];
                }
                if($field['id']=='city'){
                    $city=$field['val'];
                }
            }
            $dob=$byear."-".$bmonth."-".$bday;
            $dob = date("Y-m-d",strtotime($dob));
            $sql_update = "UPDATE profile SET dob='$dob', gender='$gender', country='$country', city ='$city' WHERE acc_id='$userid'";
            $stmt = $conn->query($sql_update);
            try{
                    $date = new DateTime();
                    $date = $date->format('Y-m-d H:i:s');
                    $sql_insert = "INSERT INTO activity (acc_id, timestmp, category_id, a_id) 
                           VALUES (?,?,?,?)";
                    $stmt = $conn->prepare($sql_insert);
                    $stmt->bindValue(1, $userid);
                    $stmt->bindValue(2, $date);
                    $stmt->bindValue(3, 3);
                    $stmt->bindValue(4, $userid);
                    $stmt->execute();
                }
                catch(Exception $e) {
                    die();
                }
            echo "Information successfully updated";
        }catch(Exception $e) {
                die(var_dump($e));
        }
    }
    //Disconnect from DB
    $conn = null;
?>
