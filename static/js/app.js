(function ($) {

  var Message = Backbone.Model.extend({
    defaults: {
      status: 'highphasion',
      messages: []
    }
  });

  var MessageList = Backbone.Collection.extend({
    model: Message,
    url: 'http://localhost/lowphashion/message',
    parse: function(response) {
      return response;
    }
  });

  var MessagesView = Backbone.View.extend({
    $el: $('#messages'),

    initialize: function() {
      this.collection = new MessageList();
      this.render();
    },

    render: function() {
      var that = this;
      this.collection.fetch({
        success: function(response) {
          console.log(response);
          if(response.models.length > 0) {
            that.renderMessages(response.models);
          } else {
            console.log('rendering no messages');
            that.renderNoMessages();
          }
        }
      })
    },

    renderMessages: function(messages) {
      var messageListView = new MessageListView({
        model: messages
      });
      this.$el.append(messageListView.render().el);
    },

    renderNoMessages: function() {
      var noMessagesView = new NoMessagesView();
      this.$el.append(noMessagesView.render().el);
    }

  });

  var NoMessagesView = Backbone.View.extend({
    template: $('#noMessagesTemplate').html(),
    render: function() {
      console.log(this.$el);
      $(this.el).html(this.template);
      return this;
    }
  });

  var MessageListView = Backbone.View.extend({
    template: $('#messageListTemplate').html(),
    render: function() {
      console.log(this.model);
      var html = Mustache.to_html(this.template, this.model.toJSON());
      console.log(html);
      $(this.el).html(html);
      return this;
    }
  });

  var messagesView = new MessagesView();
}(jQuery));
