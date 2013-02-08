(function ($) {

  var Message = Backbone.Model.extend({
    status: 'ok',
    messages: [
      {
        id: 0,
        app_name: 'lowphashion',
        body: '',
        type: 'info'
      }
    ]
  });

  var MessageList = Backbone.Collection.extend({
    model: Message,
    url: 'http://localhost/lowphashion/message/error',
    parse: function(response) {
      return response;
    }
  });

  var MessagesView = Backbone.View.extend({
    el: $('#messages'),

    initialize: function() {
      this.collection = new MessageList();
      this.render();
    },

    render: function() {
      var that = this;
      this.collection.fetch({
        success: function(response) {

          // TODO: parse for status

          if(response.models.length > 0) {
            that.renderMessages(response);
          } else {
            console.log('rendering no messages');
            that.renderNoMessages();
          }
        },
        error: function (errorResponse, status, xhr) {
          that.renderErrorMessage(status);
	      }
      })
    },

    renderMessages: function(response) {

      //TODO: there's got to be a better way to do this...
      var json = response.toJSON();
      var msgs = json[0].messages;

      var template = $('#message-list-template').html();
      var html = Mustache.to_html(template, { messages: msgs });
      $(this.el).html(html);
    },

    renderNoMessages: function() {
      var template = $('#no-messages-template').html();
      var html = Mustache.to_html(template);
      $(this.el).html(html);
    },

    renderErrorMessage: function(status) {
      var errorMessage = "Status: " + status.status 
                          + " - " + status.statusText;
      var data = {
        status: errorMessage
      };

      var template = $('#error-template').html();
      var html = Mustache.to_html(template, data);
      $(this.el).html(html);
    }
  });

  var messagesView = new MessagesView();

}(jQuery));
