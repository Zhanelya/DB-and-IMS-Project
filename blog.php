<?php
session_start();




 require_once 'connection.php';
        //Connect to DB
 $conn = connect($host,$user,$pwd,$db);

 if(!empty($_POST)) {
      try {
          $id=$_SESSION['userid'];
          $post_id=intval($_POST['id']);
          $text=mysql_real_escape_string ($_POST['post']); 
          $title=mysql_real_escape_string ($_POST['title']);

          $date = new DateTime();
          $date = $date->format('Y-m-d H:i:s');
               //check if exists
          
          $sql_select = "SELECT acc_id
                       FROM post
                       WHERE  acc_id='$id' AND post_id='$post_id'";
          $stmt = $conn->query($sql_select);
          $posts=$stmt->fetchAll(); 
          
          //Exist:
          if(count($posts) > 0) {
              //Update
            
              $sql_update = "UPDATE post SET title='$title', post='$text' WHERE acc_id='$id' AND post_id='$post_id'";
              $stmt = $conn->query($sql_update);
              
               //Not exist:
          }else{
            
              //Insert
          $sql_insert = "INSERT INTO post (acc_id, post_id, timestmp, title, post) 
                           VALUES (?,?,?,?,?)";
          $stmt = $conn->prepare($sql_insert);
          $stmt->bindValue(1, $id);
          $stmt->bindValue(2, $post_id);
          $stmt->bindValue(3, $date);
          $stmt->bindValue(4, $title);
          $stmt->bindValue(5, $text);
          $stmt->execute();
          
          }
          
          echo "Success ";
          echo $post_id." ";
          echo $text." ";
          echo $title;


        } catch(Exception $e) {
            die(var_dump($e));
        }
  }
$conn = null;

?>

