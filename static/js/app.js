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
    url: 'http://localhost/lowphashion/message/all',
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

          if(response.models.length > 0) {

            //TODO: there's got to be a better way to do this...
            var json = response.toJSON()[0];
            var status = json.status;
            var msgs = json.messages;

            that.renderMessages(msgs);
          } else {
            console.log('rendering no messages');
            that.renderNoMessages();
          }
        },
        error: function (errorResponse, errorStatus, xhr) {
          that.renderErrorMessage(errorStatus);
        }
      })
    },

    renderMessages: function(msgs) {
      var template = $('#message-list-template').html();
      var html = Mustache.to_html(template, { messages: msgs });
      $(this.el).html(html);
    },

    renderNoMessages: function() {
      var template = $('#no-messages-template').html();
      var html = Mustache.to_html(template);
      $(this.el).html(html);
    },

    renderErrorMessage: function(errorStatus) {
      var status = {
        code: errorStatus.status,
        text: errorStatus.statusText
      };

      var template = $('#error-template').html();
      var html = Mustache.to_html(template, status);
      $(this.el).html(html);
    }
  });

  var messagesView = new MessagesView();

}(jQuery));
