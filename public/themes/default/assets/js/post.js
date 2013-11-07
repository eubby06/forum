"use strict";
(function($, application, window)
{
	var offset = 100;
    var duration = 500;
    var addMemberUrl = '/forum/subscription/ajaxaddsubscriber';
    var removeMemberUrl = '/forum/subscription/ajaxremovesubscriber';
    var removePostUrl = '/forum/posts/ajaxdelete';

    $(window).scroll(function() {
          if ($(this).scrollTop() > offset) {
              $('.back-to-top').fadeIn(duration);
          } else {
              $('.back-to-top').fadeOut(duration);
          }
    });

	application.Model= function (spec) {
		var self = this;

		self.removePost = function(id) {
			$.ajax({
				type: 'POST',
				url: removePostUrl,
				data: {pid: id}
			}).done(function(msg) {

				if (msg.result == 'success')
				{
					$('.-single-post-'+id).detach();
				}

			});
		};

		self.quote = function() {
			alert('quoted');
		};

		self.addMember = function(username, cid) {

			$.ajax({
				type: 'POST',
				url: addMemberUrl,
				data: {subscriber: username, conversation_id: cid}
			}).done(function(msg) {

				if (msg.result == 'success')
				{
					$('.-added-members').append('<span class="'+username+'"><a id="'+ username +'" href="members/profile/'+ username +'">' 
						+ username + '</a><a id="' + username + ':' + cid + '" class="-remove-member" href="#"><i class="icon-remove"></i></a></span>').fadeIn('slow');
					$('#-subscriber-username').val('');
				}
				else
				{
					$('.-added-members-result').text(msg.message).fadeIn("slow").delay(2000).fadeOut("slow");
				}
			});
		};

		self.removeMember = function(username, cid) {

			$.ajax({
				type: 'POST',
				url: removeMemberUrl,
				data: {subscriber: username, conversation_id: cid}
			}).done(function(msg) {

				if (msg.result == 'success')
				{
					$('span.'+username).detach();
				}
				else
				{
					$('.-added-members-result').text(msg.message).fadeIn("slow").delay(2000).fadeOut("slow");
				}
			});
		};

		return self;
	};

	application.Controller = function(app, selector) {
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
				.on('click', '#-confirm-delete-btn', function() {
					var id = $('#-confirm-delete-modal').data('pid');

					app.removePost(id);

					$('#-confirm-delete-modal').modal('hide');
				})
				.on('click', '.-delete', function(e) {
					e.preventDefault();

					var $comment_id = $(this).attr("id");
					
					$('#-confirm-delete-modal').data('pid', $comment_id).modal('show')

            		app.delete($comment_id);
				})
				.on('click', '.-edit', function(e) {
					e.preventDefault();

					var $c_id = $(this).attr("id");
					var $message_div = $('#message-' + $c_id);

					$message_div.replaceWith(function()
					{
						var $c_post = $(this).html();

						$c_post = $c_post.replace(/\<blockquote\>/g, '[blockquote]')
		    			.replace(/\<\/blockquote\>/g, '[/blockquote]')
		    			.replace(/\<strong\>/g, '[user]')
		    			.replace(/\<\/strong\>/g, '[/user]')
		    			.replace(/\<br\>/g, '\r\n');

						return '<textarea class="span12 active -editedTextarea" id="' + $c_id + '">' + $c_post + '</textarea>';
					})

					$(this).text('save').removeClass().addClass('-save');
				})
				.on('click', '.-save', function(e)
				{
					e.preventDefault();
					var $c_id = $(this).attr("id");

					$('.-editedTextarea').replaceWith(function()
					{
						return '<div id="message-'+$c_id+'">' + $(this).val() + '</div>';
					});

					$(this).text('edit').removeClass().addClass('-edit');
				})
				.on('click', '.-quote', function(e) {
					e.preventDefault();

					var $c_id = $(this).attr("id");
					var $c_user = $(this).attr("data-user");
					var $c_post = $('#message-' + $c_id).html();

		    		$c_post  = $c_post.replace(/\<blockquote\>/g, '[blockquote]')
		    			.replace(/\<\/blockquote\>/g, '[/blockquote]')
		    			.replace(/\<strong\>/g, '[user]')
		    			.replace(/\<\/strong\>/g, '[/user]')
		    			.replace(/\<br\>/g, '\r\n');

					$('#reply #message').removeClass('active').addClass('active');

					var $c_reply = $('#reply #message').html('[quote=' + $c_user + ']' + $c_post + '[/quote]');
					
					//scroll window
					$('html, body').animate({
			            scrollTop: $("#reply").offset().top
			        }, 500);
				})
				.on('click', '.back-to-top', function() {
			        $('html, body').animate({scrollTop: 0}, duration);
			        
			        return false;
				})
				.on('click', '.-add-member', function(e) {
					e.preventDefault();

					var username = $('#-subscriber-username').val();
					var cid = $('#-conversation-id').val();

					if (username.length == 0) return false;

					app.addMember(username, cid);
				})
				.on('click', '.-remove-member', function(e) {
					e.preventDefault();

					var id = $(this).attr('id');
					var idSplit = id.split(':');
					var username = idSplit[0];
					var cid = idSplit[1];

					app.removeMember(username, cid);
				})
	};

})(jQuery, window.PostApp || (window.PostApp= {}), window);

$(function() {
	
	$('#search').autocomplete({ source: [ "c++", "java", "php", "coldfusion", "javascript", "asp", "ruby" ] });

	PostApp.Controller(new PostApp.Model(), "#comment-wrapper");

});