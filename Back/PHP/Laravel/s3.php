<?php

// Run: composer require league/flysystem-aws-s3-v3


// file .env

// put secret key and access key (both are from user of IAM AWS), region of bucket, name of bucket
// AWS_ACCESS_KEY_ID=AKIAWI7TO74CIPJP3aUCZ??
// AWS_SECRET_ACCESS_KEY=fZqB3CqyusgbmDVa5W3jS612KjHonv9y2XFX5ONtI
// AWS_DEFAULT_REGION=us-west-2
// AWS_BUCKET=grao

// view calling controller sending file to save in bucket

public function caixaDocumentos(Request $request)
    {
        if ($request->method() == 'POST' && $request->hasfile('image')) {
            $path = $request->file('image')->store('images', 's3');
            Storage::disk('s3')->setVisibility($path, 'public');

            $data = [
                'image_name' => basename($path),
                'image_path' => Storage::disk('s3')->url($path),
            ];

            $caixaDocumento = CaixaDocumento::create($data);

            return back()->with('success','Image Uploaded successfully');
        }

        $caixaDocumentos = CaixaDocumento::all();

        return view('personalizacoes.caixa', compact('caixaDocumentos'));
    }
