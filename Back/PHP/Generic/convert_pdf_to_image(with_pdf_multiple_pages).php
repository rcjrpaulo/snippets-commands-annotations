<?php

//Pass a File as parameter, and return the jpeg saved path (also join pdf pages in the jpeg file)
function convertFilePdfToImage($file) {
    $arrayExtensao = explode('.', $file->getClientOriginalName());
    if ($arrayExtensao && count($arrayExtensao)) {
        $extensao = array_pop($arrayExtensao);
        $fileName = count($arrayExtensao) ? $arrayExtensao[0] : date('YmdHis');
        $isPdf = Str::contains(strtolower($extensao), 'pdf');
        if ($isPdf) {
            $caminhoPdf = getcwd().'/../storage/'.$fileName.'.pdf';
            file_put_contents($caminhoPdf, fopen($file, 'r'));

            $pdf = new Pdf($caminhoPdf);
            $pageNumbers = $pdf->getNumberOfPages();
            if ($pageNumbers > 1) {

                $paginasSalvas = $pdf->saveAllPagesAsImages(getcwd().'/../storage/',
                    date('YmdHis').$fileName);

                $filePath = $paginasSalvas[0];
                list($width, $height, $type, $attr) = getimagesize($paginasSalvas[0]);
                $final = imagecreatetruecolor($width, $height * $pageNumbers);
                foreach ($paginasSalvas as $i => $paginaSalva) {
                    $imagem = imagecreatefromjpeg($paginaSalva);

                    imagecopymerge($final, $imagem, 0, ($height * ($i)), 0, 0, $width, $height, 100);
                    if ($i > 0) {
                        unlink($paginaSalva);
                    }
                }

                imagejpeg($final, $filePath);

            } else {
                $filePath = getcwd().'/../storage/'.date('YmdHis').$fileName.'.jpeg';
                $pdf->saveImage($filePath);
            }

            unlink($caminhoPdf);

            $convertedPdf = true;
        }
    }
    
    return $filePath;
}