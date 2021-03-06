<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="Foobook is a social networking website." />
		<meta name="keywords" content="Foobook, Social Network">
		<title>Welcome to Foobook</title>
		<link rel="stylesheet" type="text/css" href="landing.css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js "></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script type="text/javascript" src="session.js"></script>
		<script type="text/javascript" src="ajax.js"></script>
		<script type="text/javascript" src="landing.js"></script>
	</head>
	<body>
		<div>
			<form id="signInForm">
				<h2>Sign In:</h2>
				<input type="text" name="email" size="30" maxlength="20" placeholder="Email"/><br>
				<input type="password" name="password" size="30" maxlength="20" placeholder="Password"/><br><br>
				<input type="submit" name="submit" value="Submit"/>
			</form>
		</div>
		<div>
            <form id="signUpForm">
	            <h2>Sign Up:</h2>
	            <input type="text" name="first_name" size="30" maxlength="20" placeholder="First Name"/><br>
	            <input type="text" name="last_name" size="30" maxlength="20" placeholder="Last Name"/><br>
	            <input type="text" id="signUpEmail" name="email" size="30" maxlength="20" placeholder="Email"/><br>
	            <input type="text" id="repeatEmail" size="30" maxlength="20" placeholder="Verify Email"/><br>
	            <input type="password" id="signUpPassword" name="password" size="30" maxlength="20" placeholder="Password"/><br>
	            <input type="password" id="repeatPassword" size="30" maxlength="20" placeholder="Verify Password"/><br>
	            <input type="date" name="date_of_birth"/><br>
	            Male<input type="radio" name="gender" value=0/>
	            Female<input type="radio" name="gender" value=1/><br><br>
	            <input type="submit" name="submit" value="Submit"/>
            </form>
        </div>
	</body>
</html>