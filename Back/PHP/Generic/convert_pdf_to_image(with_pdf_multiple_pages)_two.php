<?php

//esse buga as paginas, porem se for só converter pdf pra jpg já funciona bem sem o resetIterator e appendImages
$im1 = new Imagick();
$im1->readImage($caminhoAnexo);
$im1->resetIterator();
$ima = $im1->appendImages(true);
$ima->setImageFormat("jpg");
$timestampImage = date('dmYHis');
$ima->writeImage(getcwd() . "/../storage/zzstackedImages{$timestampImage}.jpg");

// all pdf pages are alright
$isPdf = $anexo['tipo_extensao'] == 'pdf';
$numPaginas = 1;
if ($isPdf) {
    $caminhoPdf = getcwd() .'/../storage/temp_pdf'.date('YmdHis').'.pdf';
    try {
        file_put_contents($caminhoPdf, fopen($caminhoAnexo, 'r'));
    } catch (\Exception $e) {
        return response()->json($e->getMessage(), 400);
    }

    $pdf = new Pdf($caminhoPdf);
    $numPaginas = $pdf->getNumberOfPages();
    if ($numPaginas > 1) {
        $paginasSalvas = $pdf->saveAllPagesAsImages(getcwd() . '/../storage/', 'temp_image');

        $caminhoAnexo = $paginasSalvas[0];
        list($width, $height, $type, $attr) = getimagesize($paginasSalvas[0]);
        $final = imagecreatetruecolor($width, $height*$numPaginas);
        foreach ($paginasSalvas as $i => $paginaSalva) {
            $imagem = imagecreatefromjpeg($paginaSalva);

            imagecopymerge($final, $imagem, 0, ($height*($i)), 0, 0, $width, $height, 100);
            if ($i > 0) {
                unlink($paginaSalva);
            }
        }

        imagejpeg($final, $caminhoAnexo);
    } else {
        $caminhoAnexo = getcwd() . '/../storage/ztemp'.date('YmdHis').'.jpeg';
        $pdf->saveImage($caminhoAnexo);
    }

    unlink($caminhoPdf);
}