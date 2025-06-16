<?php
include 'koneksi.php';

if (isset($_POST['register'])) {
  $username = $_POST['username'];
  $email    = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
  $result = mysqli_query($conn, $query);

  if ($result) {
    echo "<script>alert('Registrasi berhasil'); window.location.href='login.php';</script>";
  } else {
    echo "Gagal mendaftar: " . mysqli_error($conn);
  }
}
?>

<!-- HTML Register -->
 <link rel="stylesheet" href="css/loginRegister.css">
<form method="POST" action="">
  <h2>Daftar</h2>
  <input type="text" name="username" placeholder="Username" required><br>
  <input type="email" name="email" placeholder="Email" required><br>
  <input type="password" name="password" placeholder="Password" required><br>
  <button type="submit" name="register">Daftar</button>
  <p>Sudah punya akun? <a href="login.php">Login</a></p>
</form>
