<!DOCTYPE html>
<html>
<head>
	<title>New token</title>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>
	<h1>{{$uri}}</h1>
</body>
</html>