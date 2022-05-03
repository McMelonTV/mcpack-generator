<?php

$height = $_POST['height'];
$theight = $_POST['theight'];
$heights = $height.' - '.$theight;

mkdir('temp');
mkdir('temp/dimensions');

$data = file_get_contents('zip-stuff/manifest.json');

file_put_contents('temp/manifest.json', str_replace(["{UUID1}", "{UUID2}", "{HEIGHTS}"], [guidv4(), guidv4(), $heights], $data));
 
$data1 = file_get_contents('zip-stuff/dimensions/overworld.json');

file_put_contents('temp/dimensions/overworld.json', str_replace(["{MIN}", "{MAX}"], [$height, $theight], $data1));


# https://stackoverflow.com/questions/4914750/how-to-zip-a-whole-folder-using-php

// Get real path for our folder
$rootPath = realpath('temp');

// Initialize archive object
$zip = new ZipArchive();
$zip->open($heights.'.mcpack', ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}

// Zip archive will be created only after closing object
$zip->close();


function guidv4() {
    $data = random_bytes(16);
    assert(strlen($data) == 16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

header('Location: /minecraft/bedrock/worldgen/'.$heights.'.mcpack');
?>