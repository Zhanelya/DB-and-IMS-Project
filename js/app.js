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
  this.resource('posts');
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
 var username = $("#username").html();
 var posts = [{
  id: '1',
  title: "Save more with Google Drive",
  author: { name: 'username'},
  date: new Date('03-13-2014'),
  excerpt: "Having launched Google Drive just two years ago, we’re excited that so many people are now using it as their go-to place for keeping all their files.",
  body: "Having launched Google Drive just two years ago, we’re excited that so many people are now using it as their go-to place for keeping all their files. Whether it's all the footage of your kids' baseball games, the novel you're working on, or even just your grocery list for the week, we all have files that are too important to lose. Today, thanks to a number of recent infrastructure improvements, we’re able to make it more affordable for you to keep everything safe and easy to reach on any device, from anywhere."
}, {
  id: '2',
  title: "Thank you, and welcome to the new Google Maps",
  author: { name: 'username'},
  date: new Date('02-19-2014'),
  excerpt: "Over the coming weeks the new Google Maps will make its way onto desktops around the world.",
  body: "Over the coming weeks the new Google Maps will make its way onto desktops around the world. Many of you have been previewing it since its debut last May, and thanks to your helpful feedback we’re ready to make the new Maps even more widely available. It’s now even easier to plan your next trip, check live traffic conditions, discover what’s happening around town, and learn about a new area—with Pegman’s help if needed."  
}];

App.Router.map(function() {
  this.resource('posts', function() {
    this.resource('post', { path: ':post_id' });
  });
});

App.PostsRoute = Ember.Route.extend({
  model: function() {
    return posts;
  }
});

App.PostRoute = Ember.Route.extend({
  model: function(params) {
    return posts.findBy('id', params.post_id);
  }
});

App.PostController = Ember.ObjectController.extend({
  isEditing: false,

  edit: function() {
    this.set('isEditing', true);
  },

  doneEditing: function() {
    this.set('isEditing', false);
    id = this.get('id');
    post = this.get('body');
    title = this.get('title');
    var json_arr = {id:id, post:post, title:title};
    insertBlog(json_arr);
  }
});

var showdown = new Showdown.converter();

Ember.Handlebars.helper('format-markdown', function(input) {
  return new Handlebars.SafeString(showdown.makeHtml(input));
});

Ember.Handlebars.helper('format-date', function(date) {
  return moment(date).fromNow();
});

function insertBlog(json_arr){
    $.ajax({
      type: 'post',
      url: 'blog.php',
      data: json_arr, // working
      success: function (result) {
        console.log('Success');
      }
    });
}





