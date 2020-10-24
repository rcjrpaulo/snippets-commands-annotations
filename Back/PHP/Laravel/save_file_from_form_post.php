<?php

// save file in public
$fileName = time().'.'.$request->anexo->extension();
$fileSaved = $request->anexo->move(public_path(''), $fileName);

// save $fileSaved in some model or else

//delete file in server folder
unlink($fileSaved->getPathname());