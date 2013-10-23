<html>
<head>
	<title></title>
</head>
<body>

	<p>Hello <strong>{{ $username }}</strong>,</p>
	<p>Thank you for your registration. Please activate your account to login to our website.<br />
 To activate, kindly click on <a href="{{ route('account_activation', $userid) }}"><strong>Activate My Account Now</strong></a>.</p> 
	<p>Flash eSports</p>
	<hr />
	<small>This is a computer-generated message, so please do not reply.</small>
</body>
</html>
