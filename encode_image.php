<?php
$image_path = 'D:\ENSPM\L4\Semestre8\Developpement Web\Projet_Emploi_de_Temps\TIME_TABLE\public\assets\img\logo_uma.png';

if (!file_exists($image_path)) {
    die("Fichier introuvable : $image_path\n");
}

$ext  = strtolower(pathinfo($image_path, PATHINFO_EXTENSION));
$mime = match($ext) {
    'png'  => 'image/png',
    'jpg','jpeg' => 'image/jpeg',
    'gif'  => 'image/gif',
    default => 'image/png',
};

$base64 = base64_encode(file_get_contents($image_path));
$src    = "data:{$mime};base64,{$base64}";

echo "Copier ce src dans votre template :\n\n";
echo $src . "\n";