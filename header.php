<header class="navbar navbar-fixed-top">
    <div class="navbar-inner" >
        <ul class="nav header">
            <li class="logo">{{#link-to 'index'}}SocialNet{{/link-to}}</li>
            <li class="searchbox"> 
                <form method="GET" id="search" action="#/search">
                    <input style="width:80%" type="text" name="name" size="60" placeholder="Search friends"/>
                </form>
            </li>
            <?php 
            if ($userid!=0){
              echo "<li class=\"logout\" onclick=\"logout()\">{{#link-to 'logout'}}Logout{{/link-to}}</li>";
            }else{
              echo "<li class=\"register\">{{#link-to 'register'}}Register{{/link-to}}</li>";
              echo "<li class=\"login\">{{#link-to 'login'}}Login{{/link-to}}</li>";
                }
            ?>
         </ul>   
    </div>
 </header>

