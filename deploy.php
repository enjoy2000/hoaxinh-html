<?php
if (isset($_POST)) {
    var_dump($_POST);
    echo exec("whoami");
    echo exec("pwd");
    $listCommand = [
        "cd /usr/share/nginx/hoaxinh-html",
        "git fetch --all",
        "git reset --hard origin/master"
    ];
    
    // run command
    foreach ($listCommand as $command) {
        exec($command);
    }
    echo "Pulled latest source code successfully."
}