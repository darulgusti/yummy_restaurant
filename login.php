<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
  // Ambil input dari form
  $email    = $_POST['email'];
  $password = $_POST['password'];

  // Query user berdasarkan email
  $query = "SELECT * FROM users WHERE email='$email'";
  $result = mysqli_query($conn, $query);
  $user = mysqli_fetch_assoc($result);

  // Jika user ditemukan dan password benar
  if ($user && password_verify($password, $user['password'])) {
    // Jika user adalah admin (misal username = 'admin')
    if ($user['username'] === 'admin') {
      $_SESSION['admin'] = $user['username'];
      header("Location: dashboard.php");
      exit();
    } else {
      $_SESSION['user'] = $user['username'];
      echo "<script>alert('Login berhasil'); window.location.href='index.php';</script>";
    }
  } else {
    echo "<script>alert('Login gagal: email atau password salah');</script>";
  }
}
?>

<!-- HTML Login -->
 <link rel="stylesheet" href="css/loginRegister.css">
<form method="POST" action="">
  <h2>Login</h2>
  <input type="email" name="email" placeholder="Email" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <button type="submit" name="login">Login</button>
  <p>Belum punya akun? <a href="register.php">register</a></p>
</form>
