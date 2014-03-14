// to get the ID of a user currently logged in, see innerhtml of a hidden div: 
// $("#userid").html()
// this div is filled in automatically by $_SESSION['userid'] from serverside

App = Ember.Application.create({
  currentPath: ''
});

App.Router.map(function() {
  this.resource('register');
  this.resource('login');
  this.resource('logout');
  this.resource('profile');
  this.resource('p_profile');
  this.resource('search');
  this.resource('news');
  this.resource('messages');
  this.resource('photos');
  this.resource('friends');
  this.resource('circles');
});

App.ApplicationController = Ember.Controller.extend({ //this part tracks change of current page
  updateCurrentPath: function() {
        App.set('currentPath', this.get('currentPath'));
        $( document ).ready(function() {
            if(App.get('currentPath') == 'news'){
                show($("#userid").html(),"newsBlock", "news.php");
            }
            if(App.get('currentPath') == 'profile'){
                show($("#userid").html(),"profileBlock", "profile.php");
            }
            if(App.get('currentPath') == 'friends'){
                show($("#userid").html(),"friendsBlock", "friends.php");
            }
            if(App.get('currentPath') == 'p_profile'){
                url = window.location.toString();
                person_id = (stripTrailingSlash(url).split('?'))[1]; 
                show(person_id,"p_profileBlock", "profile.php");
            }
            if(App.get('currentPath') == 'search'){
                url = window.location.toString();
                person_id = (stripTrailingSlash(url).split('?'))[1]; 
                console.log(person_id);
                search(person_id,"searchBlock", "search.php");
            }
        });
  }.observes('currentPath')
});

function stripTrailingSlash(str) {
    if(str.substr(-1) == '/') {
        return str.substr(0, str.length - 1);
    }
    return str;
}

function show (id, block_id, php_file) 
{
      if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
        }
      else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
      xmlhttp.onreadystatechange=function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
          {
          //news=xmlhttp.responseText;
          document.getElementById(block_id).innerHTML=xmlhttp.responseText;
          }
        }
      xmlhttp.open("GET",php_file+"?q="+id,true);
      xmlhttp.send();
}
function search (id, block_id, php_file) 
{
      if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
        }
      else
        {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
      xmlhttp.onreadystatechange=function()
        {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
          {
          //news=xmlhttp.responseText;
          document.getElementById(block_id).innerHTML=xmlhttp.responseText;
          }
        }
      xmlhttp.open("GET",php_file+"?"+id,true);
      xmlhttp.send();
}

function register() {
    $.ajax({
      type: 'post',
      url: 'register.php',
      dataType : "json",
      data: $('#register_form').serialize(),
      success: function (result) {
        $('#register_sucmsg').html('');
        $('#register_errmsg').html('');

        if(result.status=='success'){
            $('#register_sucmsg').html(result.msg);
            setTimeout(function() { 
                window.location.href = "..#/login"; 
            }, 2000);
        }else{
            $('#register_errmsg').html(result.msg);
        }
      }
    });
}
 
function login () {
    $.ajax({
      type: 'post',
      url: 'login.php',
      dataType : "json",
      data: $('#login_form').serialize(),
      success: function (result) {
        $('#login_sucmsg').html('');
        $('#login_errmsg').html('');
        if(result.status=='success'){
            $('#login_sucmsg').html(result.msg);
            setTimeout(function() { 
               window.location.href = "..#/"; 
               window.location.reload();
            }, 2000);
        }else{
            $('#login_errmsg').html(result.msg);
        }
      }
    });
 }
 
 function logout(){
    $.ajax({
      type: 'post',
      url: 'logout.php',
      success: function () {
               window.location.href = "..#/"; 
               window.location.reload();
      }
    });
 }