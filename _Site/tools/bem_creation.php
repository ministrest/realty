<?php
if (isset($argv[1])){

    $addresses[0] = "../project.blocks/common/".$argv[1];
    $addresses[1] = "../project.blocks/desktop/".$argv[1];
    $addresses[2] = "../project.blocks/mobile/".$argv[1];
    $addresses[3] = "../project.blocks/tablet/".$argv[1];
    foreach($addresses as $key=>$address) {
        if(!file_exists($address))
        {
            print_r(" I shall create folder ".$address."!\n");
            mkdir($address);
        } else {
            print_r(" Folder".$address." already exist. \n");
        }
        $fileName = $address."/".$argv[1].".css";
        $fileHandle = fopen($fileName, 'w') or die("can't open file");
        fclose($fileHandle);
        switch($key){
            case 0:
                $text = "@import url(\"../".$fileName."\");";
                $fileHandle = fopen("../inc/jscss/common.css", 'a') or die("can't open file");
                fwrite($fileHandle, PHP_EOL. $text);
                fclose($fileHandle);
                break;
            case 1:
                $text = "@import url(\"../".$fileName."\");";
                $fileHandle = fopen("../inc/jscss/desktop.css", 'a') or die("can't open file");
                fwrite($fileHandle, PHP_EOL. $text);
                fclose($fileHandle);
                break;
            case 2:
                $text = "@import url(\"../".$fileName."\");";
                $fileHandle = fopen("../inc/jscss/mobile.css", 'a') or die("can't open file");
                fwrite($fileHandle, PHP_EOL. $text);
                fclose($fileHandle);
                break;
            case 3:
                $text = "@import url(\"../".$fileName."\");";
                $fileHandle = fopen("../inc/jscss/tablet.css", 'a') or die("can't open file");
                fwrite($fileHandle, PHP_EOL. $text);
                fclose($fileHandle);
                break;
        }

    }


}
?>