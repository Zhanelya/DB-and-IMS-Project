App = Ember.Application.create({
  currentPath: '',
  id:981, //App.set('id', 1) to set id afterlogin, App.get('id') to get it
});

App.Router.map(function() {
  this.resource('register');
  this.resource('login');
  this.resource('profile');
  this.resource('news');
  this.resource('messages');
  this.resource('photos');
  this.resource('friends');
  this.resource('circles');
});

App.ApplicationController = Ember.Controller.extend({ //this part tracks change of current page
  updateCurrentPath: function() {
        App.set('currentPath', this.get('currentPath'));
        if(App.get('currentPath') == 'news'){
            show(App.get('id'),"newsBlock", "news.php");
        }
        if(App.get('currentPath') == 'profile'){
            show(App.get('id'),"profileBlock", "profile.php");
        }
        
  }.observes('currentPath')
});

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

$(function () {
  $('#register_form').on('submit', function (e) {
    $.ajax({
      type: 'post',
      url: 'register.php',
      dataType : "json",
      data: $('form').serialize(),
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
    e.preventDefault();
  });
});



