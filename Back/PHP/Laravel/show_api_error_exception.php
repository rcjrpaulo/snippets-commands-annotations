<?php

// In file Handler.php

	public function render($request, Exception $e)
	{
        $isApi = Str::contains($request->getUri(), '/api/');
        if ($isApi) {
            return $this->error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, $e);
        }

		return parent::render($request, $e);
	}
	
	

private function error(string $message, int $code, Throwable $exception)
    {
        $response = [
            'message' => $exception->getMessage(),
            'file'    => $exception->getFile(),
            'line'    => $exception->getLine(),
            'trace'   => $exception->getTrace()
        ];

        return response()->json($response, $code);
    }