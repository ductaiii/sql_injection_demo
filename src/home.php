<?php
session_set_cookie_params([
	'httponly' => true
]);

session_start();
require 'db.php';

// Ensure user is logged in in this demo
if (!isset($_SESSION['user'])) {
	header('Location: login.php');
	exit();
} else {
	$welcome = 'Xin chào, ' . htmlspecialchars($_SESSION['user']['fullname']);
}

$query = $_GET['query'] ?? '';

?>

<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Home - Danh sách người dùng</title>
	<style>
		body { font-family: Arial, Helvetica, sans-serif; background: #f5f7fb; color: #222; margin: 0; padding: 0; }
		header { background: linear-gradient(90deg,#4267b2,#8b9dc3); color: white; padding: 20px; }
		.container { max-width: 980px; margin: 24px auto; background: white; border-radius: 8px; padding: 20px; box-shadow: 0 6px 24px rgba(34,41,47,0.08); }
		h1 { margin: 0 0 10px 0; }
		.search { margin-bottom: 18px; display:flex; gap:8px; }
		.search input[type=text] { flex:1; padding:10px; border-radius:6px; border:1px solid #ddd; }
		.search button { padding:10px 14px; border-radius:6px; border:none; background:#28a745; color:white; cursor:pointer; }
		table { width:100%; border-collapse: collapse; margin-top: 12px; }
		th,td { text-align:left; padding:10px; border-bottom:1px solid #eee; }
		th { background:#fafafa; }
		.note { color:#666; font-size:14px; }
		.role { font-weight:600; color:#fff; padding:4px 8px; border-radius:4px; font-size:12px; }
		.role.admin { background:#e74c3c; }
		.role.user { background:#3498db; }
	</style>
</head>
<body>
	<header>
		<div style="max-width:980px;margin:0 auto;display:flex;justify-content:space-between;align-items:center;">
			<div>
				<h2 style="margin:0"><a href="home.php" style="text-decoration:none; color:white;">Home</a></h2>
				<div style="font-size:13px;opacity:0.9"><?php echo $welcome; ?></div>
			</div>
			<div>
				<a href="login.php" style="color:rgba(255,255,255,0.9);text-decoration:none">Back to Login</a>
			</div>
		</div>
	</header>

	<div class="container">
		<form method="GET" class="search" action="home.php">
			<input type="text" name="query" placeholder="Tìm theo họ tên hoặc username..." value="<?php echo htmlspecialchars($query); ?>">
			<button type="submit">Tìm</button>
		</form>
										<!-- 🔍 Kết quả cho: ' .htmlspecialchars($query) . ' -->
		<?php
		if ($query !== '') {
			// Demo XSS: Echo direct query without sanitization
				echo
				'<div style="padding: 12px 15px; background-color: #e3f2fd; color: #0d47a1; border-radius: 6px; margin-bottom: 20px; border-left: 5px solid #2196f3; font-weight: 500;">
								🔍 Kết quả cho: ' .$query . '

				</div>';
		}

		// Build query depending on search term
		if ($query !== '') {
			// Vulnerable pattern kept for demo clarity (original project was vulnerable)
			$sql = "SELECT id, username, password, fullname, role FROM users WHERE fullname LIKE '%$query%' OR username LIKE '%$query%'";
		} else {
			$sql = "SELECT id, username, password, fullname, role FROM users";
		}

		$result = $conn->query($sql);

		if ($result && $result->num_rows > 0) {
			echo '<table><thead><tr>';

			// determine columns shown based on role
			$isAdmin = isset($_SESSION['user']) && ($_SESSION['user']['role'] === 'admin');

			if ($isAdmin) {
				echo '<th>ID</th><th>Username</th><th>Password</th><th>Fullname</th><th>Role</th>';
			} else {
				echo '<th>Username</th><th>Họ tên</th>';
			}

			echo '</tr></thead><tbody>';

			while ($row = $result->fetch_assoc()) {
				echo '<tr>';
				if ($isAdmin) {
					echo '<td>'.htmlspecialchars($row['id']).'</td>';
					echo '<td>'.htmlspecialchars($row['username']).'</td>';
					echo '<td>'.htmlspecialchars($row['password']).'</td>';
					echo '<td>'.htmlspecialchars($row['fullname']).'</td>';
					echo '<td><span class="role '.htmlspecialchars($row['role']).'">'.htmlspecialchars($row['role']).'</span></td>';
				} else {
					echo '<td>'.htmlspecialchars($row['username']).'</td>';
					echo '<td>'.htmlspecialchars($row['fullname']).'</td>';
				}
				echo '</tr>';
			}

			echo '</tbody></table>';
		} else {
			echo '<p>Không tìm thấy kết quả.</p>';
		}
		?>

	</div>
</body>
</html>
