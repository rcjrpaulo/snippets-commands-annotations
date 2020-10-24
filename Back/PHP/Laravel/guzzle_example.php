<?php

public function webHookEcommerce($orcamento_id, $url)
{
    $urlEcommerce = "http://40.114.84.58/api/integrations/estimate/{$orcamento_id}/confirm";
    $token = "ciwfmTJawfKQ4Tvsm8eaVlKarVPYsIA963j2uIxQnZhxFHPFHNOXWbr9OTd5";
    $client = new \GuzzleHttp\Client();
    $headers = ['Authorization' => "Bearer $token"];
    $form_params = ['contrato' => $url];
    try {
        $request = $client->post($urlEcommerce, ['headers' => $headers, 'form_params' => $form_params]);

        $data = [
            'codigo' => $request->getStatusCode(),
            'mensagem' => $request->getBody()->getContents(),
            'user_id' => Auth::User()->sys_id,
        ];

        LogEcommerceWebhook::create($data);

        return '1';
    } catch (\GuzzleHttp\Exception\RequestException $e) {
        $data = [
            'codigo' => $e->getCode(),
            'mensagem' => $e->getMessage(),
            'user_id' => Auth::User()->sys_id,
        ];

        LogEcommerceWebhook::create($data);

        return '0';
    }
}