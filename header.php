<header class="navbar navbar-fixed-top">
    <div class="navbar-inner" >
        <ul class="nav header">
            <li class="logo">{{#link-to 'index'}}SocialNet{{/link-to}}</li>
            <li class="searchbox"> 
                <form action="search.php" method="GET" id="search">
                    <input style="width:100%" type="text" name="search" size="60" placeholder="Search friends">
                </form>
            </li>
            <li class="register">{{#link-to 'register'}}Register{{/link-to}}</li>
            <li class="login">{{#link-to 'login'}}Login{{/link-to}}</li>
         </ul>   
    </div>
 </header>

