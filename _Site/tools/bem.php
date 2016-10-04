<?php

$rootDir = dirname(__DIR__);

if (count($argv) !== 3) {
    ?>
    HELP
    =========================================
    bem.php module moduleName   Create module "moduleName"
    bem.php block blockName     Create block "blockName"
    <?php
    exit;
}

$name = $argv[2];

if ($argv[1] == 'module') {
    $path = $rootDir.'/modules/'.$name;

    if (is_dir($path)) {
        print_r("Module $name exists\n");
        exit;
    }
    mkdir($path);
    $fileHandle = fopen($path.'/index.php', 'w') or die("can't open file");
    fclose($fileHandle);
    $fileHandle = fopen($path.'/index.tpl.php', 'w') or die("can't open file");
    fclose($fileHandle);
    print_r("SUCCESS\n");
} elseif($argv[1] == 'block') {
    $paths = array('common', 'desktop', 'tablet', 'mobile');
    foreach($paths as $block) {
        $path = $rootDir.'/project.blocks/'.$block.'/'.$name;

        if (is_dir($path)) {
            print_r("Folder $path already exist. \n");
            exit;
        }
        print_r("I shall create folder $path!\n");
        mkdir($path);
        // Создаем файл блока
        $fileName = $path.'/'.$name.'.css';
        $fileHandle = fopen($fileName, 'w') or die("can't open file");
        fclose($fileHandle);
        // включаем в соответственный css
        $text = '@import url("../../project.blocks/'.$block.'/'.$name.'/'.$name.'.css");';
        $fileHandle = fopen($rootDir.'/inc/jscss/'.$block.'.css', 'a') or die("can't open file");
        fwrite($fileHandle, PHP_EOL. $text);
        fclose($fileHandle);

    }
}
