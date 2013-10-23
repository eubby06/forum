<html>
<head>
	<title></title>
</head>
<body>

	<p>hi {{ $username }},</p>
	<p>Thank you for your registration. Please activate your account to login to our website.<br />
		To activate, kindly click on <a href="{{ route('account_activation', $userid) }}"><strong>Activate My Account Now</strong></a>.</p> 
</body>
</html>
