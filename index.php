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
    <?php 
    session_start();
    $userid = 0;
    if(isset($_SESSION['userid'])){
        $userid = $_SESSION['userid'];
        $username= $_SESSION['username'];
    }
    ?>
    <?php require_once 'header.php';?>
     <div id="userid" hidden><?php echo $userid;?></div>
     <div id="username" hidden><?php echo $username;?></div>
     <div class="container-fluid">
        <nav class="menu">
            <ul class="nav nav-pills nav-stacked span2">
            <?php 
            if ($userid!=0)
              echo
              "<li>{{#link-to 'profile'}}My profile{{/link-to}}</li>
              <li>{{#link-to 'news'}}News Feed{{/link-to}}</li>
              <li>{{#link-to 'messages'}}Messages{{/link-to}}</li>
              <li>{{#link-to 'photos'}}Photos{{/link-to}}</li>
              <li>{{#link-to 'friends'}}Friends{{/link-to}}</li>
              <li>{{#link-to 'circles'}}Circles{{/link-to}}</li>
              <li>{{#link-to 'posts'}}Posts{{/link-to}}</li>"
            ?>
            </ul>
        </nav>
        <article>
            {{outlet}}
        </article>
     </div>
  </script>

  <script type="text/x-handlebars" id="index">
    <?php 
            if ($userid!=0)
              echo "<br>Welcome back, <b>".$username."</b>";
            else
              echo "<br>Please <a href=\"..#/login\"><b>Login</b></a> or <a href=\"..#/register\"><b>Register</b></a>";
    ?>
  </script>
  
  <script type="text/x-handlebars" id="register">
    <h3>Register</h3>
    <p>Fill in your details, then click <strong>Create Account</strong> to register.</p>
    <form id="register_form" method="post"  enctype="multipart/form-data" >
          <input type="text" name="name" id="name" placeholder="Username" /></br>
          <input type="password" name="password" id="password" placeholder="Password"/></br>
          <input type="email" name="email" id="email" placeholder="Email"/></br>
          <input type="email" name="email_c" id="email_c" placeholder="Re-enter your email"/></br>
          <input type="text" name="fname" id="fname" placeholder="First Name"/></br>
          <input type="text" name="lname" id="lname" placeholder="Last Name"/></br>
          <label for="dob">Date of birth</label>
          <input id="dob" type="date" name="dob"></br>
          Gender <input type="radio" name="gender" value="m" id="male">Male
                 <input type="radio" name="gender" value="f" id="female">Female</br>
          <div id="register_errmsg"></div>
          <div id="register_sucmsg"></div>
          <input type="button" name="submit_register" onclick="register()" value="Create Account"/>
    </form>
  </script>
  
  <script type="text/x-handlebars" id="login">
    <h3>Login</h3>
    <p>Please enter your login details, then click <strong>Login</strong>.</p>
    <form id="login_form" method="post"  enctype="multipart/form-data" >
          <input type="text" name="name" id="name" placeholder="Username" /></br>
          <input type="password" name="password" id="password" placeholder="Password"/></br>
          <div id="login_errmsg"></div>
          <div id="login_sucmsg"></div>
          <input type="button" name="submit_login" onclick="login()" value="Login"/> 
    </form>
  </script>
 
  <script type="text/x-handlebars" id="logout">
  </script>    
  
  <script type="text/x-handlebars" id="profile">
    <h3>My profile</h3>  
    <div id="profileBlock"></div>
    <button onclick="edit_profile();">Edit</button>
    <button onclick="save_profile();">Save</button>
    <div id="profile_save_msg"></div>
  </script>
  
  <script type="text/x-handlebars" id="p_profile">
    <h3>Profile</h3>  
    <div id="p_profileBlock"></div>
  </script>
  
  <script type="text/x-handlebars" id="search">
    <h3>Search</h3>  
    <div id="searchBlock"></div>
  </script>
  
  <script type="text/x-handlebars" id="news">
    <h3>News Feed</h3> 
    <div id="newsBlock"></div>
  </script>
  
  <script type="text/x-handlebars" id="messages">
    <h3>Messages</h3>  
  </script>
  
  <script type="text/x-handlebars" id="photos">
    <h3>Photos</h3>  
  </script>
  
  <script type="text/x-handlebars" id="friends">
    <h3>Friends</h3>  
    <div id="friendsBlock"></div>
  </script>
  
  <script type="text/x-handlebars" id="circles">
    <h3>Circles</h3>  
  </script>
  
 <script type="text/x-handlebars" id="posts">
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span3">
          <table class='table'>
            <thead>
              <tr><th>Recent Posts</th></tr>
            </thead>
            {{#each model}}
            <tr><td>
                {{#link-to 'post' this}}{{title}} <small class='muted'>by {{author.name}}</small>{{/link-to}}
            </td></tr>
            {{/each}}
          </table>
        </div>
        <div class="span9">
          {{outlet}}
        </div>
      </div>
    </div>
  </script>

 <script type="text/x-handlebars" id="posts/index">
    <p class="text-warning">Please select a post</p>
  </script>

  <script type="text/x-handlebars" id="post">
    {{#if isEditing}}
      {{partial 'post/edit'}}
      <button {{action 'doneEditing'}}>Done</button>
    {{else}}
      <button {{action 'edit'}}>Edit</button>
    {{/if}}

    <h1>{{title}}</h1>
    <h2>by {{author.name}} <small class='muted'>({{format-date date}})</small></h2>

    <hr>

    <div class='intro'>
      {{format-markdown excerpt}}
    </div>

    <div class='below-the-fold'>
      {{format-markdown body}}
    </div>
  </script>

  <script type="text/x-handlebars" id="post/_edit">
    <p>{{input type="text" value=title}}</p>
    <p>{{input type="text" value=excerpt}}</p>
    <p>{{textarea value=body}}</p>
  </script>







  
  <script src="js/libs/jquery-1.10.2.js"></script>
  <script src="js/libs/handlebars-1.1.2.js"></script>
  <script src="js/libs/ember-1.3.2.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/showdown/0.3.1/showdown.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.1.0/moment.min.js"></script>
  <script src="js/app.js"></script>
  <!-- to activate the test runner, add the "?test" query string parameter -->
  <script src="tests/runner.js"></script>
</body>
</html>
