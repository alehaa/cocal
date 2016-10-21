<?php
require_once('includes.php');
if (file_exists('config.php') && file_exists('install.php')) {
    error(500, "Vor dem Benutzen von Cocal muss die install.php file gelöscht werden.");
}
if(isset($_POST['install'])) {
    $newKey = openssl_random_pseudo_bytes(32);
    $newPassword = randomString(20);
    $configFileExisted = false;
    if (file_exists('config.php')) {
        $configFileExisted = true;
        rename('config.php', 'config.php~')
            or error(500, "Fehler bei der Konfiguration. Bitte beachten, dass die config.php file schreibbar sein muss.");
    }
    $fd = fopen('config.php', "w")
    or error(500, "Fehler bei der Konfiguration. Bitte beachten, dass die config.php file schreibbar sein muss.");
    $fileContent = "<?php
        /**
        * This is an automatically generated file. Manual modifications may be overwritten. Handle with care.
        * Last modification: " . date('d.m.Y H:i:s') . "
        */\n";
    $fileContent .= "\t".'define(\'CRYPTPASSWORD\', base64_decode(\'' . base64_encode($newKey) . '\'));' . "\n";
    $fileContent .= "\t".'define(\'URLPASSWORD\', \'' . $newPassword . '\');' . "\n";
    fwrite($fd, $fileContent);
    fclose($fd);
    $progress = 100;
    $content = '<div class="panel panel-success"><div class="panel-heading">
                <h3 class="panel-title">Installation erfolgreich</h3>
                </div>
                <div class="panel-body">
                Die Cocal-Installation wurde erfolgreich abgeschlossen. <b>Bitte löschen Sie jetzt install.php.</b>
                </div>
                </div>';
}
else {
    //if (file_exists('config.php') && file_exists('install.php')) { error(500, "Vor dem Benutzen von Cocal muss die install.php file gelöscht werden."); }
    $progress = 10;
    $content = '<form action="" method="post"><input type="hidden" name="install">
                <p>Um Cocal benutzen zu können, müssen ein privater Schlüssel und ein URL Passwort generiert werden. 
                Um Cocal zu installieren, einfach auf folgenden Button klicken:</p>
                <p><button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-cog"></span>
                    Cocal installieren</button></p></form>';
}

require_once('installTemplate.php');
