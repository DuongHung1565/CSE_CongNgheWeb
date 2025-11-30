<?php
$host = '127.0.0.1';
$dbname = 'cse485_web';
$username = 'root';
$password = '';
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}

if (isset($_POST['ten_sinh_vien']) && isset($_POST['email'])) {
    $ten = $_POST['ten_sinh_vien'];
    $email = $_POST['email'];

    $sql = "INSERT INTO sinhvien (ten_sinh_vien, email) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$ten, $email]);

    header("Location: chapter4.php");
    exit;
}

$sql_select = "SELECT * FROM sinhvien ORDER BY ngay_tao DESC";
$stmt_select = $pdo->query($sql_select);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>PHT Chương 4 - Website hướng dữ liệu</title>
</head>
<body>

<h2>Thêm Sinh Viên Mới</h2>

<form method="POST">
    Tên sinh viên: <input type="text" name="ten_sinh_vien" required>
    Email: <input type="email" name="email" required>
    <button type="submit">Thêm</button>
</form>

<h2>Danh Sách Sinh Viên</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Tên Sinh Viên</th>
        <th>Email</th>
        <th>Ngày Tạo</th>
    </tr>

<?php while ($row = $stmt_select->fetch(PDO::FETCH_ASSOC)) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['ten_sinh_vien']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= $row['ngay_tao'] ?></td>
    </tr>
<?php } ?>

</table>

</body>
</html>
