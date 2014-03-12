App = Ember.Application.create();

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

App.NewsRoute = Ember.Route.extend({
  model: function(){  
      return news;
  }    
});

var news = [{    //test data to be replaced by real users data retrieved from DB
      id:'1',
      friend:"Adam",
      news:{text:"Added new friend Jenna",date:"22-01-2014"}
},{
      id:'2',
      friend:"Martin",
      news:{text:"Added new friend Jenna",date:"22-01-2014"}
},{
      id:'3',
      friend:"Chris",
      news:{text:"Added new friend Jenna",date:"22-01-2014"}
}];

var myprofile = { //sample data for testing only
      id:'1',
      fname:"Kate",
      lname:"Smith",
      dob:"1890-02-25",
      gender:"f",
      country:"USA",
      city:"New York",
      status:"married",
      prof_img:"/url"
}
   