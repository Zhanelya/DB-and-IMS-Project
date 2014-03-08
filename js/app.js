App = Ember.Application.create();

App.Router.map(function() {
  this.resource('register');
  this.resource('login');
  this.resource('messages');
});

App.IndexRoute = Ember.Route.extend({
  model: function() {
    return ['red', 'yellow', 'blue'];
  }
});
