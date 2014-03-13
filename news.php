<?php
    require_once 'connection.php';
    //Connect to DB
    $conn = connect($host,$user,$pwd,$db);
    $q = intval($_GET['q']);
    $sql_select = "SELECT * FROM users WHERE acc_id = '".$q."'";
    $stmt = $conn->query($sql_select);
    $news = $stmt->fetchAll(); 
    
    try {
        if(count($news) > 0) {
            foreach($news as $new)
              {
              echo "<div class=\"row-fluid news_block\"><h5>".$new['acc_id']."</h5>".$new['name']."<h5><small>date</small></h5></div>";
              }
        }
    }catch(Exception $e) {
            die(var_dump($e));
    }
    //Disconnect from DB
    $conn = null;
?>