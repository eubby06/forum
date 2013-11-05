<html>
<head>
	<title></title>
</head>
<body>

	<p>Hello <strong>{{ $user->username }}</strong>,</p>
	<p><strong>{{ $sender->username }}</strong> {{ $statement }}.<br />
 To view this conversation, kindly click on <a href="{{ route('view_conversation', $notifiableObj->slug) }}">{{ $notifiableObj->title }}</a>.</p> 
	<p>Flash eSports</p>
	<hr />
	<small>This is a computer-generated message, so please do not reply.</small>
</body>
</html>
