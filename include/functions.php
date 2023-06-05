<?php
error_reporting(0);
require_once ('DataSource.php');
require_once ('vendor/autoload.php');
function breadcrumbs($separator = '', $home = 'Home') {
    $path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
    $base = ($_SERVER['HTTPS'] ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    $breadcrumbs = Array("<li class='breadcrumb-item'><a href=\"$base\">$home</a></li>");
    $last = end(array_keys($path));
    foreach ($path AS $x => $crumb) {
        $title = ucwords(str_replace(Array('.php', '_'), Array('', ' '), $crumb));
        if ($x != $last)
            $breadcrumbs[] = "<li class='breadcrumb-item'><a href=\"$base$crumb\">$title</a></li>";
        else
            $breadcrumbs[] = "<li class='breadcrumb-item'>$title</li>";
        $base .= $crumb . '/';
    }
    return implode($separator, $breadcrumbs);
 }


 ?>