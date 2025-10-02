<?php

// La classe View gère l'affichage des vues de l'application.
// Elle utilise la mise en tampon de sortie pour contrôler ce qui est affiché.

final class View
{
    // Démarre un tampon de sortie (ce qui signifie que tout ce qui est "echo" sera stocké au lieu d'être affiché directement).
    public static function startBuffer()
    {
        ob_start();
    }

    // Récupère et renvoie le contenu du tampon (ce qui y a été stocké)
    public static function getBufferContent()
    {
        return ob_get_clean();
    }

    // Affiche une vue : construit le chemin du fichier de la vue,
    public static function render($path, $params = array())
    {
        $file = Constant::viewDirectory() . $path . '.php';
        $viewData = $params;

        ob_start(); // commence la mise en tampon
        include $file; // inclut la vue
        ob_end_flush(); // affiche et vide le tampon
    }
}
