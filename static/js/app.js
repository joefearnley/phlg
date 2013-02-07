(function ($) {

  var Message = Backbone.Model.extend({
    messages: []
  });

  var MessageList = Backbone.Collection.extend({
    model: Message,
    url: 'http://localhost/lowphashion/message/all',
    parse: function(response) {

		  //console.log(this.toJSON());
			//return models
      //return this.models;

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

          if(response.models.length > 0) {
            that.renderMessages(response);

          } else {
            console.log('rendering no messages');
            that.renderNoMessages();
          }
        },
        error: function (errorResponse) {
          console.log(errorResponse);
	      }
      })
    },

    renderMessages: function(response) {
      //var messageListView = new MessageListView({
      //  model: messages
      //});

      console.log(JSON.stringify(this.models));

      var template = $('#message-list-template').html();


      var html = Mustache.to_html(template, response.toJSON());

      console.log(html);

      this.$el.append(html);
    },

    renderNoMessages: function() {
      var noMessagesView = new NoMessagesView();
      this.$el.append(noMessagesView.render().el);
    }

  });

  var NoMessagesView = Backbone.View.extend({
    template: $('#noMessagesTemplate').html(),
    render: function() {
      $(this.el).html(this.template);
      return this;
    }
  });

  var MessageListView = Backbone.View.extend({
    
    render: function() {

      console.log(this.model.models);

      var html = Mustache.to_html(this.template, this.model.models.toJSON());
      //console.log(html);
      return html;
    }
  });

  var messagesView = new MessagesView();
}(jQuery));
