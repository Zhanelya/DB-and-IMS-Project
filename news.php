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
                echo "<div class=\"row-fluid news_block\"><h5>".$new['fname']." ".$new['lname']."</h5>";
                echo "Added new ".$new['category'];
                echo "<h5><small>".date("j M Y",strtotime($new['timestmp']))." at ".date("H:i:s",strtotime($new['timestmp']))."</small></h5></div>";
              }
        }
    }catch(Exception $e) {
            die(var_dump($e));
    }
    //Disconnect from DB
    $conn = null;
?>