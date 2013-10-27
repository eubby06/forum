"use strict";
(function($, application, window)
{
	application.CommunicationLayer = function (spec) {
		var self = this;

		self.delete = function(id) {
			alert(id);
		};

		self.quote = function() {
			alert('quoted');
		};

		return self;
	};

	application.performBinding = function(app, selector) {
		var $wrapper = $(selector || window.document);

		$(".post").each(function() {

		    var text = $(this).html();

		    text = text.replace(/\[blockquote\]/g, '<blockquote>')
		    			.replace(/\[\/blockquote\]/g, '</blockquote>')
		    			.replace(/\[user\]/g, '<strong>')
		    			.replace(/\[\/user\]/g, '</strong>')
		    			.replace(/\r\n|\r|\n/g,"<br />");

		    $(this).html(text);
		});

		$wrapper
				.on('click', '.-delete', function(e) {
					e.preventDefault();

					var $comment_id = $(this).attr("id");
					var proceed = confirm("Are you sure you would like to delete this comment?");
            		
            		if (!proceed) { return; }

            		app.delete($comment_id);
				})
				.on('click', '.-quote', function(e) {
					e.preventDefault();

					var $c_id = $(this).attr("id");
					var $c_post = $('#message-' + $c_id).html();

		    		$c_post  = $c_post.replace(/\<blockquote\>/g, '[blockquote]')
		    			.replace(/\<\/blockquote\>/g, '[/blockquote]')
		    			.replace(/\<strong\>/g, '[user]')
		    			.replace(/\<\/strong\>/g, '[/user]')
		    			.replace(/\<br\>/g, '\r\n');

					$('#reply #message').removeClass('active').addClass('active');

					var $c_reply = $('#reply #message').html('[quote=' + $c_id + ']' + $c_post + '[/quote]');
				})
	};

})(jQuery, window.MyApp || (window.MyApp = {}), window);

$(function() {

	MyApp.performBinding(new MyApp.CommunicationLayer(), "#comment-wrapper");

    $('a.-quote').click(function(){

        $('html, body').animate({
            scrollTop: $("#reply").offset().top
        }, 500);
    });

    var offset = 100;
    var duration = 500;

    $(window).scroll(function() {
          if ($(this).scrollTop() > offset) {
              $('.back-to-top').fadeIn(duration);
          } else {
              $('.back-to-top').fadeOut(duration);
          }
    });
      
    $('.back-to-top').click(function(event) {
          event.preventDefault();

          $('html, body').animate({scrollTop: 0}, duration);
          return false;
    });
});