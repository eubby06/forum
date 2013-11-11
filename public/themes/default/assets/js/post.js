"use strict";
(function($, application, window)
{
	var offset = 100;
    var duration = 500;
    var addMemberUrl = '/forum/subscription/ajaxaddsubscriber';
    var removeMemberUrl = '/forum/subscription/ajaxremovesubscriber';
    var removePostUrl = '/forum/posts/ajaxdelete';
    var updatePostUrl = '/forum/posts/ajaxupdate';

    $(window).scroll(function() {
          if ($(this).scrollTop() > offset) {
              $('.back-to-top').fadeIn(duration);
          } else {
              $('.back-to-top').fadeOut(duration);
          }
    });

	application.Model= function (spec) {
		var self = this;

		self.convertBBTags = function(text) {
			var text = text.replace(/\[blockquote\]/g, '<blockquote>')
			    		.replace(/\[\/blockquote\]/g, '</blockquote>')
			    		.replace(/\[strong\]/g, '<strong>')
			    		.replace(/\[\/strong\]/g, '</strong>')
			    		.replace(/\r\n|\r|\n/g,"<br />");
		};

		self.wrapText = function(textArea, openTag, closeTag) {
					var openTag = openTag;
					var closeTag = closeTag;
					var textArea = $(textArea);
					var len = textArea.val().length;
					var start = textArea[0].selectionStart;
					var end = textArea[0].selectionEnd;
					var selectedText = textArea.val().substring(start, end);
					var replacement = openTag + selectedText + closeTag;
					textArea.val(textArea.val().substring(0, start) + replacement + textArea.val().substring(end, len));
		};

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

		self.updatePost = function(text, id) {
			$.ajax({
				type: 'POST',
				url: updatePostUrl,
				data: {text:text, id:id}
			});
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

		self.getSelected = function() {
			 var t = '';

			  if(window.getSelection){
			    t = window.getSelection();
			  }else if(document.getSelection){
			    t = document.getSelection();
			  }else if(document.selection){
			    t = document.selection.createRange().text;
			  }
			  return t;
		};

		return self;
	};

	application.Controller = function(app, element) {
		var $wrapper = $(element || window.document);

		$(".post").each(function() {

		    var text = $(this).html();

		    text = text.replace(/\[/g, '<')
		    			.replace(/\]/g, '>')
		    			.replace(/\[\//g, '</')
		    			.replace(/\r\n|\r|\n/g, "<br>")
		    			.replace(/<code>/, '<pre><code data-language="php">')
		    			.replace(/<\/code>/, '</code></pre>');

		    $(this).html(text);

		    var code = $('.post code').html();

		    if (code != undefined)
		    {
		    	code = code.replace(/<br>/g, '\r');
		    	$('.post code').html(code);
		    }

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
		    			.replace(/\<br\>/g, '\r\n')
						.replace(/<pre>/, '')
		    			.replace(/<\/pre>/, '');

						return '<textarea class="span12 active -editedTextarea" id="' + $c_id + '">' + $c_post + '</textarea>';
					})

					$(this).text('save').removeClass().addClass('-save');
				})
				.on('click', '.-save', function(e)
				{
					e.preventDefault();

					var $c_id = $(this).attr("id");

					var $edited_text = $('.-editedTextarea').val();

					app.updatePost($edited_text, $c_id);

					$('.-editedTextarea').replaceWith(function()
					{
						var text = $(this).val();

		    			text = text.replace(/\[blockquote\]/g, '<blockquote>')
			    			.replace(/\[\/blockquote\]/g, '</blockquote>')
			    			.replace(/\[user\]/g, '<strong>')
			    			.replace(/\[\/user\]/g, '</strong>')
			    			.replace(/\r\n|\r|\n/g,"<br />")
							.replace(/<code>/, '<pre><code>')
		    				.replace(/<\/code>/, '</code></pre>');

						return '<div id="message-'+$c_id+'">' + text + '</div>';
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
		    			.replace(/<code\s[\w-="\s]*>/g, '[code]')
		    			.replace(/<\/code>/g, '[/code]')
		    			.replace(/<span\s[\w-="\s]*>/g, ' ')
		    			.replace(/<\/span>/g, ' ')
		    			.replace(/\<br\>/g, '\r\n')
		    			.replace(/<pre>/, '')
		    			.replace(/<\/pre>/, '');

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
				.on('click', '.-btn-bold', function(e) {
					e.preventDefault();
					
					app.wrapText('textarea#message','[bold]','[/bold]');
				})
				.on('click', '.-btn-italic', function(e) {
					e.preventDefault();

					app.wrapText('textarea#message','[italic]','[/italic]');
				})
				.on('click', '.-btn-code', function(e) {
					e.preventDefault();

					app.wrapText('textarea#message','[code]','[/code]');
				})
	};

})(jQuery, window.PostApp || (window.PostApp= {}), window);

$(function() {
	
	$('#search').autocomplete({ source: [ "c++", "java", "php", "coldfusion", "javascript", "asp", "ruby" ] });

	PostApp.Controller(new PostApp.Model(), "#comment-wrapper");

});