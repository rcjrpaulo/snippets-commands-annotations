<?php

searcher::run('/application/app');

class searcher {

    public function run($folder = null) {

        $filename = 'app/Locale/en_us/LC_MESSAGES/kkk.txt';
        $fileContent = file_get_contents($filename);
        preg_match_all("/msgid  \".*\"/", $fileContent, $matches);
        $translation = $matches[0];
        $translation = preg_replace("/msgid  \"/", "", $translation);
        $translations = preg_replace("/\"/", "", $translation);
        if (!$folder) {
            $folder = getcwd();
        }
        $dir = new DirectoryIterator($folder);
        self::searchDirectory($dir, $translations);

    }

    public function searchDirectory($dir, $translations)
    {
        foreach ($dir as $file) {
            if (!$file->isDot()) {
                if ($file->isDir()) {
                    //Nome da Pasta
                    $dirName = $file->getFilename();

                    //caminho com o /Nome da Pasta
                    $caminho = $file->getPathname();
                    self::findSubDirectory($caminho, $dirName, $translations);
                }

                if ($file->isFile()) {
                    $fileName = $file->getFilename();
                    $caminho = $file->getPath();
                    $fileWay = $caminho . "/" . $fileName;
                    self::printStringNotTranslated($caminho, $translations, $fileWay, $fileName);
                }
            }
        }
    }

    //Função recursiva usada para varrer os sub-diretorios
    public function findSubDirectory($caminho, $dirName, $translations)
    {
        global $dirName;

        $DI = new DirectoryIterator($caminho);

        self::findSubDirectoryRecursive($caminho, $dirName, $translations, $DI);
    }

    public function findSubDirectoryRecursive($caminho, $dirName, $translations, $DI)
    {
        foreach ($DI as $file) {
            if (!$file->isDot()) {
                if ($file->isDir()) {
                    $dirName = $file->getFilename();

                    $caminho = $file->getPathname();
                    self::findSubDirectory($caminho, $dirName, $translations);
                }

                if ($file->isFile()) {
                    $fileName = $file->getFilename();
                    $caminho = $file->getPath();
                    $fileWay = $caminho . "/" . $fileName;

                    self::printStringNotTranslated($caminho, $translations, $fileWay, $fileName);
                }
            }
        }
    }

    private function printStringNotTranslated($caminho, $translations, $fileWay, $fileName): void
    {
        $isCtp = fnmatch('*.ctp', $fileWay);
        $isPhp = fnmatch('*.php', $fileWay);
        if ($isCtp || $isPhp) {
            $fileContent = file_get_contents($fileWay);
            preg_match_all("/\_\_\(('([a-zA-ZÀ-ú]|\s)*'|\"([a-zA-ZÀ-ú]|\s)*\")\)/", $fileContent, $found);
            $value = $found[0];
            $value = preg_replace("/\_\_\(/", "", $value);
            $value = preg_replace("/\)/", "", $value);
            $value = preg_replace("/'/", "", $value);
            $value = preg_replace("/\"/", "", $value);

            $result = array_diff($value, $translations);
            if ($result) {
                foreach ($result as $error) {
                    printf("Caminho: " . $caminho . "/" . $fileName . "\n" . "String: " . $error . "\n");
                }
            }
        }
    }
}
