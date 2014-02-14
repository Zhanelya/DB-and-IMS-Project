<!-- Registration source code: partly provided by Windows Azure PHP tutorial:
http://www.windowsazure.com/en-us/documentation/articles/web-sites-php-mysql-deploy-use-git/-->
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <Title>Registration Form</Title>
    <style type="text/css">
    body { background-color: #fff; border-top: solid 10px #000;
        color: #333; font-size: .85em; margin: 20; padding: 20;
        font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
    }
    h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
    h1 { font-size: 2em; }
    h2 { font-size: 1.75em; }
    h3 { font-size: 1.2em; }
    table { margin-top: 0.75em; }
    th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
    td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
</style>
    <link rel="stylesheet" href="//ajax.aspnetcdn.com/ajax/bootstrap/2.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="//ajax.aspnetcdn.com/ajax/bootstrap/2.3.1/css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <script type="text/x-handlebars">
    <?php
        echo "Hello team, this is COMP3013 project";
    ?>  
    <div class="navbar">
        <div class="navbar-inner">
            <ul class="nav">
                <li>{{#link-to 'index'}}Home{{/link-to}}</li>
                <li>{{#link-to 'register'}}Register here!{{/link-to}}</li>
                <li>{{#link-to 'about'}}About{{/link-to}}</li>
            </ul>            
        </div>
     </div>
    {{outlet}}
  </script>

  <script type="text/x-handlebars" id="index">
    <h2>Welcome</h2>  
  </script>
  
  <script type="text/x-handlebars" id="about">
    <h2>About</h2>
  </script>
  
  <script type="text/x-handlebars" id="register">
    <h2>Register</h2>
    <p>Fill in your name and email address, then click <strong>Submit</strong> to register.</p>
<form method="post" action="index.php" enctype="multipart/form-data" >
      Name  <input type="text" name="name" id="name"/></br>
      Email <input type="text" name="email" id="email"/></br>
      <input type="submit" name="submit" value="Submit" />
</form>
<?php
    // DB connection info
    //TODO: Update the values for $host, $user, $pwd, and $db
    //using the values you retrieved earlier from the portal.
    $host = "eu-cdbr-azure-west-b.cloudapp.net";
    $user = "b6a70abeba0a70";
    $pwd = "6d447729";
    $db = "comp3013";
    // Connect to database.
    try {
        $conn = new PDO( "mysql:host=$host;dbname=$db", $user, $pwd);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch(Exception $e){
        die(var_dump($e));
    }
    // Insert registration info
    if(!empty($_POST)) {
    try {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $date = date("Y-m-d");
        // Insert data
        $sql_insert = "INSERT INTO users (name, email, date) 
                   VALUES (?,?,?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $email);
        $stmt->bindValue(3, $date);
        $stmt->execute();
    }
    catch(Exception $e) {
        die(var_dump($e));
    }
    echo "<h3>Your're registered!</h3>";
    }
    // Retrieve data
    $sql_select = "SELECT * FROM users";
    $stmt = $conn->query($sql_select);
    $registrants = $stmt->fetchAll(); 
    if(count($registrants) > 0) {
        echo "<h2>People who are registered:</h2>";
        echo "<table>";
        echo "<tr><th>Name</th>";
        echo "<th>Email</th>";
        echo "<th>Date</th></tr>";
        foreach($registrants as $registrant) {
            echo "<tr><td>".$registrant['name']."</td>";
            echo "<td>".$registrant['email']."</td>";
            echo "<td>".$registrant['date']."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<h3>No one is currently registered.</h3>";
    }
    $conn = null;
?>
  </script>
  
  <script src="js/libs/jquery-1.10.2.js"></script>
  <script src="js/libs/handlebars-1.1.2.js"></script>
  <script src="js/libs/ember-1.3.2.js"></script>
  <script src="js/app.js"></script>
  <!-- to activate the test runner, add the "?test" query string parameter -->
  <script src="tests/runner.js"></script>
</body>
</html>
