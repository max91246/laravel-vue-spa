<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

/**
 * Trait ResponseJson
 * @package App\Traits
 */
trait ResponseJson
{
    protected $code = 200;
    protected $message = '';
    protected $data = [];

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @param string $msg
     * @param array $data
     * @return JsonResponse
     */
    public function jsonError($msg = '', $data = [])
    {
        $this->setCode(400);
        $this->setMessage($msg);
        $this->setData($data);

        return $this->json();
    }

    /**
     * @param string $msg
     * @param array $data
     * @return JsonResponse
     */
    public function jsonSuccess($msg = '', $data = [])
    {
        $this->setCode(200);
        $this->setMessage($msg);
        $this->setData($data);

        return $this->json();
    }

    /**
     * @param string $code
     * @param string $msg
     * @param array $data
     * @return JsonResponse
     */
    public function json($code = null, $msg = null, $data = null)
    {
        $res = [
            'code' => $code ?? $this->getCode(),
            'msg'  => $msg ?? $this->getMessage(),
            'data' => $data ?? $this->getData(),
        ];

        if (!$res['data']) unset($res['data']);

        return response()->json($res)->header('Content-Type', 'application/json; charset=UTF-8');
    }
}
