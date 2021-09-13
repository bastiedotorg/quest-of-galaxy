<?php
spl_autoload_register(function ($class_name) {
    if(substr($class_name,0,7) == "Mission") {
        $filename = "includes/classes/missions/$class_name.class.php";

    } else {
        $filename = "includes/classes/$class_name.class.php";
    }
    if(file_exists($filename))
        require_once ($filename);
});
