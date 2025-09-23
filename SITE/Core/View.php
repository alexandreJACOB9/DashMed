<?php

final class View
{
    public static function startBuffer()
    {
        ob_start();
    }

    public static function getBufferContent()
    {
        return ob_get_clean();
    }

    public static function render($path, $params = array())
    {
        $file = Constant::viewDirectory() . $path . '.php';
        $viewData = $params;

        ob_start();
        include $file;
        ob_end_flush();
    }
}
