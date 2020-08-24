<?php
/**
 * Fonction qui formate une date donnée
 *
 * @param string $origDate
 * @return string
 */
function formatDate(string $origDate): string
{
    // On définit la langue du site
    setlocale(LC_TIME, 'FR_fr');

    // On formate la date dans la langue choisie
    $newDate = strftime('%A %e %B %Y - %T', strtotime($origDate));

    // On encode en UTF-8 pour gérer les caractères spéciaux
    $newDate = utf8_encode($newDate);

    // On retourne la date formatée
    return $newDate;
}
/**
 * Cette fonction renvoie un extrait du texte raccourci à la longueur demandée
 *
 * @param string $texte
 * @param integer $longueur
 * @return string
 */
function extrait(string $texte, int $longueur): string
{
    // On décode les caractères HTML
    $texte = htmlspecialchars_decode($texte);

    // On supprime le HTML
    $texte = strip_tags($texte);

    // On raccourcit le texte
    $texteReduit = mb_strimwidth($texte, 0, $longueur, '...');

    return $texteReduit;
}

/**
 * Cette fonction génère une miniature d'une image dans la taille demandée (carré) (PNG ou JPG)
 * 
 * Le nom du fichier généré sera issu du nom du fichier source
 * brouette.jpg donnera brouette-300x300.jpg pour une taille de 300px
 *
 * @param string $fichier Chemin complet du fichier
 * @param integer $taille Taille en pixels
 * @return boolean
 */
function mini(string $fichier, int $taille): bool
{
    $dimensions = getimagesize($fichier);

    // On définit l'orientation et les décalages qui en découlent
    // On initialise les décalages
    $decalageX = $decalageY = 0;
    
    switch($dimensions[0] <=> $dimensions[1]){
        case -1: // Portrait
            $tailleCarre = $dimensions[0];
            $decalageY = ($dimensions[1] - $tailleCarre) / 2;
            break;
        case 0: // Carré
            $tailleCarre = $dimensions[0];
            break;
        case 1: // Paysage
            $tailleCarre = $dimensions[1];
            $decalageX = ($dimensions[0] - $tailleCarre) / 2;
    }
    
    // On vérifie le type Mime de l'image
    switch($dimensions['mime']){
        case 'image/png':
            $imageTemp = imagecreatefrompng($fichier);
            break;
        case 'image/jpeg':
            $imageTemp = imagecreatefromjpeg($fichier);
            break;
        default:
            return false;
    }
    
    // On crée une image temporaire en mémoire pour créer la copie
    $imageDest = imagecreatetruecolor($taille, $taille);
    //$imageDest = imagecreatefromjpeg('images/eglise.jpg');
    
    // On copie la partie de l'image source dans l'image de destination
    imagecopyresampled(
        $imageDest, // Image destination
        $imageTemp, // Image source
        0, // Point gauche de la zone de "collage"
        0, // Point supérieur de la zone de "collage"
        $decalageX, // Point gauche de la zone de "copie"
        $decalageY, // Point supérieur de la zone de "copie"
        $taille, // Largeur de la zone de "collage"
        $taille, // Hauteur de la zone de "collage"
        $tailleCarre, // Largeur de la zone de "copie"
        $tailleCarre // Hauteur de la zone de "copie"
    );

    // On "démonte" le nom de fichier
    // c:\brouette\eglise.jpg
    $chemin = pathinfo($fichier, PATHINFO_DIRNAME); // c:\brouette
    $nomFichier = pathinfo($fichier, PATHINFO_FILENAME); // eglise
    $extension = pathinfo($fichier, PATHINFO_EXTENSION); // jpg

    // c:\brouette\eglise-200x200.jpg
    $nouveauFichier = "$chemin/$nomFichier-{$taille}x$taille.$extension";

    // On enregistre l'image (sur le disque)
    switch($dimensions['mime']){
        case 'image/png':
            imagepng($imageDest, $nouveauFichier);
            break;
        case 'image/jpeg':
            imagejpeg($imageDest, $nouveauFichier);
    }
    
    // On "détruit" les images en mémoire
    imagedestroy($imageTemp);
    imagedestroy($imageDest);

    return true;
}