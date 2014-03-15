<?php
    require_once 'connection.php';
    //Connect to DB
    $conn = connect($host,$user,$pwd,$db);
    try {
        $q = intval($_GET['q']);
        $sql_select = "SELECT p.fname, p.lname,a.* , ac.category
                       FROM profile p , activity a, friendship f, activity_category ac 
                       WHERE ((f.user1_id = '".$q."' AND f.user2_id = a.acc_id)
                               OR 
                              (f.user2_id = '".$q."' AND f.user1_id = a.acc_id))
                             AND a.acc_id = p.acc_id 
                             AND a.category_id = ac.id
                             AND f.status_approved=1
                       ORDER BY timestmp DESC";
        $stmt = $conn->query($sql_select);
        $news=$stmt->fetchAll(); 
        if(count($news) > 0) {
            foreach($news as $new)
              {
                $activity_id = $new['a_id'];
                if($new['category_id'] == 1){
                    $sql_select = "SELECT f.user2_id, p.fname, p.lname FROM friendship f, profile p WHERE id='$activity_id' 
                                                                                                    AND p.acc_id=f.user2_id";
                    $stmt = $conn->query($sql_select);
                    $friendship=$stmt->fetchAll(); 
                    $added= $friendship[0]['fname']." ".$friendship[0]['lname'];
                    $added_id = $friendship[0]['user2_id'];
                }
                echo "<div class=\"row-fluid news_block\"><h5><a href=\"..#/p_profile?".$new['acc_id']."/\">".$new['fname']." ".$new['lname']."</a></h5>";
                echo "Added new ".$new['category']." <a href=\"..#/p_profile?".$added_id."/\">".$added."</a>";   
                echo "<h5><small>".date("j M Y",strtotime($new['timestmp']))." at ".date("H:i:s",strtotime($new['timestmp']))."</small></h5></div>";
              }
        }
    }catch(Exception $e) {
            die(var_dump($e));
    }
    //Disconnect from DB
    $conn = null;
?>