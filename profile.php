<?php
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
                    echo "<div class=\"avatar\"></div>
                          <div class=\"info\">
                              <h4>".$new['fname']." ".$new['lname']."</h4>
                              <div class=\"nav\">
                                  <div class=\"pers_info\"><span class=\"info_tag\">Birth Date</span>".$bday." ".$bmonth."</div>
                                  <div class=\"pers_info\"><span class=\"info_tag\">Year of Birth</span>".$byear."</div>
                                  <div class=\"pers_info\"><span class=\"info_tag\">Gender</span>".$gender."</div>
                                  <div class=\"pers_info\"><span class=\"info_tag\">Country</span>".$new['country']."</div>
                                  <div class=\"pers_info\"><span class=\"info_tag\">City</span>".$new['city']."</div>
                                  <div class=\"pers_info\"><span class=\"info_tag\">Status</span>".$new['status']."</div>
                              </div>
                          </div>";
                  }
            }
        }catch(Exception $e) {
                die(var_dump($e));
        }
        //Disconnect from DB
        $conn = null;
?>