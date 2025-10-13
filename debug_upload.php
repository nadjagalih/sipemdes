<?php
// File test untuk debug upload file desa
include '../Module/Config/Env.php';
session_start();

echo "<h2>Debug Upload File Desa</h2>";

// Test 1: Cek koneksi database
echo "<h3>1. Test Database Connection</h3>";
if ($db) {
    echo "✅ Database connected successfully<br>";
} else {
    echo "❌ Database connection failed: " . mysqli_connect_error() . "<br>";
}

// Test 2: Cek tabel file
echo "<h3>2. Test Table Structure</h3>";
$result = mysqli_query($db, "DESCRIBE file");
if ($result) {
    echo "✅ Table 'file' exists<br>";
    echo "<table border='1'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['Field']}</td>";
        echo "<td>{$row['Type']}</td>";
        echo "<td>{$row['Null']}</td>";
        echo "<td>{$row['Key']}</td>";
        echo "<td>{$row['Default']}</td>";
        echo "<td>{$row['Extra']}</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "❌ Table 'file' not found or error: " . mysqli_error($db) . "<br>";
}

// Test 3: Cek data di tabel file
echo "<h3>3. Test Data in File Table</h3>";
if (isset($_SESSION['IdDesa'])) {
    $idDesa = $_SESSION['IdDesa'];
    echo "Session IdDesa: $idDesa<br>";
    
    $result = mysqli_query($db, "SELECT COUNT(*) as total FROM file WHERE IdDesaFK = '$idDesa'");
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo "Total files for this desa: {$row['total']}<br>";
        
        // Show recent files
        $recent = mysqli_query($db, "SELECT * FROM file WHERE IdDesaFK = '$idDesa' ORDER BY IdFile DESC LIMIT 5");
        if (mysqli_num_rows($recent) > 0) {
            echo "<table border='1'>";
            echo "<tr><th>IdFile</th><th>Nama</th><th>Ekstensi</th><th>IdFileKategoriFK</th><th>IdDesaFK</th></tr>";
            while ($file = mysqli_fetch_assoc($recent)) {
                echo "<tr>";
                echo "<td>{$file['IdFile']}</td>";
                echo "<td>{$file['Nama']}</td>";
                echo "<td>{$file['Ekstensi']}</td>";
                echo "<td>{$file['IdFileKategoriFK']}</td>";
                echo "<td>{$file['IdDesaFK']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No files found for this desa.<br>";
        }
    }
} else {
    echo "❌ No IdDesa in session<br>";
}

// Test 4: Cek tabel master_file_kategori
echo "<h3>4. Test File Categories</h3>";
$categories = mysqli_query($db, "SELECT * FROM master_file_kategori");
if ($categories && mysqli_num_rows($categories) > 0) {
    echo "✅ File categories available:<br>";
    echo "<table border='1'>";
    echo "<tr><th>IdFileKategori</th><th>KategoriFile</th></tr>";
    while ($cat = mysqli_fetch_assoc($categories)) {
        echo "<tr><td>{$cat['IdFileKategori']}</td><td>{$cat['KategoriFile']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "❌ No file categories found<br>";
}

// Test 5: Check session info
echo "<h3>5. Session Information</h3>";
echo "Session ID: " . session_id() . "<br>";
echo "IdDesa: " . (isset($_SESSION['IdDesa']) ? $_SESSION['IdDesa'] : 'Not set') . "<br>";
echo "NameUser: " . (isset($_SESSION['NameUser']) ? $_SESSION['NameUser'] : 'Not set') . "<br>";

echo "<br><a href='/sipemdes/View/v?pg=FileUploadDesa'>Back to Upload Form</a>";
?>