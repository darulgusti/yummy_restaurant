<form action="upload.php" method="POST" enctype="multipart/form-data">
    <label for="gambar_menu">Pilih Gambar Menu:</label>
    <input type="file" name="gambar_menu" id="gambar_menu" required><br><br>
    
    <label for="nama_menu">Nama Menu:</label>
    <input type="text" name="nama_menu" id="nama_menu" required><br><br>
    
    <label for="harga_menu">Harga Menu:</label>
    <input type="number" name="harga_menu" id="harga_menu" required><br><br>
    
    <button type="submit" name="submit">Tambah Menu</button>
</form>
