<?php
        session_start();
        $userid = $_SESSION['userid'];
        require_once 'connection.php';
        //Connect to DB
        $conn = connect($host,$user,$pwd,$db);
        try {
            $q = intval($_GET['q']);
            $sql_select = "SELECT * FROM profile WHERE acc_id = '".$q."'";
            $stmt = $conn->query($sql_select);
            $news = $stmt->fetchAll(); 
            if(count($news) > 0) {
                foreach($news as $new)
                  {
                    $date = DateTime::createFromFormat("Y-m-d", $new['dob']);
                    $bday = $date->format("j"); //day in a format without preceding 0
                    $bmonth = $date->format("F"); //full month name
                    $byear = $date->format("Y"); 
                    $gender = ($new['gender']=='m'?"male":"female");
                    echo "<div style=\"width:100%\">
                          <div class=\"avatar\"></div>
                          <div class=\"info\">
                              <h4>".$new['fname']." ".$new['lname']."</h4>
                              <div class=\"nav\">
                                  <div class=\"pers_info\"><span class=\"info_tag\">Birth Date</span>  <span data-tesname='test' class=\"p_edit\"  id=\"bday\">" 
                                        .$bday."</span> <span class=\"p_edit\" id=\"bmonth\">".$bmonth."</span></div>
                                  <div class=\"pers_info\"><span class=\"info_tag\">Year of Birth</span><span data-tesname='test' class=\"p_edit\"  id=\"byear\">"
                                        .$byear."</span></div>
                                  <div class=\"pers_info\"><span class=\"info_tag\">Gender</span>  <span class=\"p_edit\" id=\"gender\">".$gender."</span></div>
                                  <div class=\"pers_info\"><span class=\"info_tag\">Country</span>  <span class=\"p_edit\" id=\"country\">".$new['country']."</span></div>
                                  <div class=\"pers_info\"><span class=\"info_tag\">City</span>  <span class=\"p_edit\" id=\"city\">".$new['city']."</span></div>
                                  <div class=\"pers_info\"><span class=\"info_tag\">Status</span>  <span class=\"p_edit\" id=\"status\">".$new['status']."</span></div>
                              </div>
                          </div>
                          </div>";
                    if($q!=$userid){
                        $sql_select = " SELECT f.user1_id, f.status_approved
                                    FROM friendship f
                                    WHERE  (f.user1_id = '".$q."' AND f.user2_id = '".$userid."')
                                       OR  (f.user2_id = '".$q."' AND f.user1_id = '".$userid."')";
                        $stmt = $conn->query($sql_select);
                        $arefriends=$stmt->fetchAll();      
                        echo "<div id=\"fmsg_".$q."\" class=\"friend_msg\"></div>";
                        if(count ($arefriends)>0){
                           if ($arefriends[0]['status_approved']==0){
                              echo "<div class=\"requested_friend\" id=\"".$q. "\"onclick=\"friend_a_person(".$q.")\"></div>";
                           }else{
                              echo "<div class=\"are_friends\" id=\"".$q."\" onclick=\"unfriend(".$q.")\"></div>";
                           }
                        }else{
                              echo "<div class=\"add_friend\" id=\"".$q."\" onclick=\"friend_a_person(".$q.")\"></div>";
                        }
                        echo "</h5></div>";
                    }
                  }
            }
        }catch(Exception $e) {
                die(var_dump($e));
        }
        //Disconnect from DB
        $conn = null;
?>