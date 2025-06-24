<?php
// Configuration
$landingpage = "landing.txt";
$canno = "https://plc.unpar.ac.id/";
$list = "title.txt";
$desc = "desc.txt";
$namafolder = "folder.txt";

// Read template content
$isi_content = file_get_contents($landingpage);

// Read all lines from input files
$titles = file($list, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$descriptions = file($desc, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$foldernames = file($namafolder, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Process each entry
foreach ($titles as $index => $textfile) {
    // Get folder name (sanitize)
    $namadirbaru = str_replace(' ', '-', trim($foldernames[$index] ?? ''));
    $namadirbaru = preg_replace('/[^\w\-]/', '', $namadirbaru);
    
    // Get description
    $descr = trim($descriptions[$index] ?? '');
    
    // Prepare paths
    $path = __DIR__ . '/' . $namadirbaru;
    $file_path = $path . '/index.php';
    
    // Create directory if not exists
    if (!file_exists($path)) {
        mkdir($path, 0755, true);
    }
    
    // Replace placeholders
    $content = str_replace(
        ['judul', 'asap', 'localhost'],
        [$textfile, "$namadirbaru $descr", $canno . $namadirbaru . '/'],
        $isi_content
    );
    
    // Write file
    file_put_contents($file_path, $content);
    
    echo "Direktori dan file index.php untuk $namadirbaru telah berhasil dibuat.\n";
}
?>
