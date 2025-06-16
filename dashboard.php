<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';

// Proses upload menu
if (isset($_POST['upload'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    $upload_dir = "img/";
    move_uploaded_file($tmp, $upload_dir . $image);

    // Mencegah SQL Injection dengan prepared statements
    $stmt = mysqli_prepare($conn, "INSERT INTO menu (name, price, image) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sis", $name, $price, $image); // 's' for string, 'i' for integer
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: dashboard.php");
    exit();
}

// Proses hapus menu
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Ambil nama file gambar sebelum menghapus data dari database
    $query_get_image = "SELECT image FROM menu WHERE id=$id";
    $result_get_image = mysqli_query($conn, $query_get_image);
    $row_image = mysqli_fetch_assoc($result_get_image);
    $image_to_delete = $row_image['image'];

    $query = "DELETE FROM menu WHERE id=$id";
    mysqli_query($conn, $query);

    // Hapus file gambar dari server jika ada
    if (!empty($image_to_delete) && file_exists("img/" . $image_to_delete)) {
        unlink("img/" . $image_to_delete);
    }
    
    header("Location: dashboard.php");
    exit();
}

// Proses edit menu
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $old_image = $_POST['old_image']; // Gambar lama

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $upload_dir = "img/";

    // Jika ada gambar baru diunggah
    if (!empty($image)) {
        // Hapus gambar lama jika ada
        if (!empty($old_image) && file_exists($upload_dir . $old_image)) {
            unlink($upload_dir . $old_image);
        }
        move_uploaded_file($tmp, $upload_dir . $image);
    } else {
        $image = $old_image; // Gunakan gambar lama jika tidak ada gambar baru diunggah
    }

    // Mencegah SQL Injection dengan prepared statements
    $stmt = mysqli_prepare($conn, "UPDATE menu SET name=?, price=?, image=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sisi", $name, $price, $image, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: dashboard.php");
    exit();
}


$menu = mysqli_query($conn, "SELECT * FROM menu");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .edit-form-container {
            display: none; /* Sembunyikan form edit secara default */
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Dashboard Admin - Upload Menu</h2>

        <form action="" method="POST" enctype="multipart/form-data" class="mb-4">
            <div class="mb-3">
                <label class="form-label">Nama Menu</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar</label>
                <input type="file" name="image" class="form-control" required>
            </div>
            <button type="submit" name="upload" class="btn btn-primary">Upload</button>
        </form>

        <div id="editMenuFormContainer" class="edit-form-container">
            <h4>Edit Menu</h4>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="edit-id">
                <input type="hidden" name="old_image" id="edit-old-image">
                <div class="mb-3">
                    <label class="form-label">Nama Menu</label>
                    <input type="text" name="name" id="edit-name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="price" id="edit-price" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gambar Saat Ini</label><br>
                    <img id="current-image-preview" src="" width="60" class="mb-2">
                    <label class="form-label">Ganti Gambar (opsional)</label>
                    <input type="file" name="image" id="edit-image" class="form-control">
                </div>
                <button type="submit" name="edit" class="btn btn-success">Update</button>
                <button type="button" class="btn btn-secondary" onclick="hideEditForm()">Batal</button>
            </form>
        </div>


        <h4>Daftar Menu</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($menu)) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td>Rp<?= number_format($row['price']); ?></td>
                    <td><img src="img/<?= htmlspecialchars($row['image']); ?>" width="60"></td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" 
                                onclick="showEditForm(<?= $row['id']; ?>, '<?= htmlspecialchars($row['name']); ?>', <?= $row['price']; ?>, '<?= htmlspecialchars($row['image']); ?>')">Edit</button>
                        <a href="?delete=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="logout.php" class="btn btn-secondary mt-3">Logout</a>
    </div>

<script src="js/script.js"></script>
</body>
</html>