<!-- Registration source code: partly provided by Windows Azure PHP tutorial:
http://www.windowsazure.com/en-us/documentation/articles/web-sites-php-mysql-deploy-use-git/-->
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <Title>SocialNet</Title>
    <style type="text/css">
    body { background-color: #fff; 
           color: #333; font-size: .85em; margin: 20; padding: 20;
           font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
    }
    h1, h2, h3 { color: #000; margin-bottom: 0; padding-bottom: 0; }
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
    <header class="navbar navbar-fixed-top header">
        <div class="navbar-inner" >
            <ul class="nav">
                <li>{{#link-to 'index'}}SocialNet{{/link-to}}</li>
                <li>{{#link-to 'register'}}Register{{/link-to}}</li>
                <li>{{#link-to 'login'}}Login{{/link-to}}</li>
            </ul>            
        </div>
     </header>
     
     <div class="container-fluid">
        <nav class="menu">
            <ul class="nav nav-pills nav-stacked span2">
              <li>{{#link-to 'profile'}}My profile{{/link-to}}</li>
              <li>{{#link-to 'news'}}News Feed{{/link-to}}</li>
              <li>{{#link-to 'messages'}}Messages{{/link-to}}</li>
              <li>{{#link-to 'photos'}}Photos{{/link-to}}</li>
              <li>{{#link-to 'friends'}}Friends{{/link-to}}</li>
              <li>{{#link-to 'circles'}}Circles{{/link-to}}</li>
            </ul>
        </nav>
        <article>
            {{outlet}}
        </article>
     </div>
  </script>

  <script type="text/x-handlebars" id="index">
    <h2>Welcome</h2>  
  </script>
  
  <script type="text/x-handlebars" id="register">
    <h2>Register</h2>
    <p>Fill in your name and email address, then click <strong>Submit</strong> to register.</p>
    <form method="post" action="index.php" enctype="multipart/form-data" >
          <input type="text" name="name" id="name" placeholder="Username" /></br>
          <input type="password" name="password" id="password" placeholder="Password"/></br>
          <input type="email" name="email" id="email" placeholder="Email"/></br>
          <input type="email" name="email_c" id="email_c" placeholder="Re-enter your email"/></br>
          <input type="text" name="fname" id="fname" placeholder="First Name"/></br>
          <input type="text" name="lname" id="lname" placeholder="Last Name"/></br>
          <label for="date">Date of birth</label>
          <input id="date" type="date" name="bday"></br>
          Gender <input type="radio" name="sex" value="male" id="male">Male
                 <input type="radio" name="sex" value="female" id="female">Female</br></br>
          <input type="submit" name="submit" value="Create Account" />
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
            $password = $_POST['password'];
            // Insert data
            $sql_insert = "INSERT INTO users (name, pswd, email, date) 
                       VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $name);
            $stmt->bindValue(2, $password);
            $stmt->bindValue(3, $email);
            $stmt->bindValue(4, $date);
            $stmt->execute();
        }
        catch(Exception $e) {
            die(var_dump($e));
        }
        echo "<h3>Your're registered!</h3>";
        }
        
        
        /*
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
         
         */
        $conn = null;
    ?>
  </script>
  
  <script type="text/x-handlebars" id="login">
    <h2>Login</h2>
  </script>
 
  <script type="text/x-handlebars" id="profile">
    <h2>My profile</h2>  
  </script>
  
  <script type="text/x-handlebars" id="news">
    <h2>News Feed</h2>  
  </script>
  
  <script type="text/x-handlebars" id="messages">
    <h2>Messages</h2>  
  </script>
  
  <script type="text/x-handlebars" id="photos">
    <h2>Photos</h2>  
  </script>
  
  <script type="text/x-handlebars" id="friends">
    <h2>Friends</h2>  
  </script>
  
  <script type="text/x-handlebars" id="circles">
    <h2>Circles</h2>  
  </script>
  
  <script src="js/libs/jquery-1.10.2.js"></script>
  <script src="js/libs/handlebars-1.1.2.js"></script>
  <script src="js/libs/ember-1.3.2.js"></script>
  <script src="js/app.js"></script>
  <!-- to activate the test runner, add the "?test" query string parameter -->
  <script src="tests/runner.js"></script>
</body>
</html>
