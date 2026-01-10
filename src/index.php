<?php
// Redirect root requests to the login page
header('Location: /login.php', true, 302);
exit();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="refresh" content="0;url=/login.php">
  <title>Redirecting...</title>
</head>
<body>
  If your browser doesn't redirect automatically, <a href="/login.php">click here</a>.
</body>
</html>
