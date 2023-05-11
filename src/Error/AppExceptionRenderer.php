<?php
declare(strict_types=1);

namespace App\Error;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Error\Renderer\WebExceptionRenderer;
use PDOException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class AppExceptionRenderer extends WebExceptionRenderer
{
    protected $exceptionHttpCodes = [
        Exception::class => 500,
        RecordNotFoundException::class => 404,
        PDOException::class => 500,
        PersistenceFailedException::class => 500,
    ];

    /**
     * エラーレスポンスのレンダリング
     *
     * @return \App\Error\Psr\Http\Message\ResponseInterface;
     */
    public function render(): ResponseInterface
    {
        $exception = $this->error;
        $code = $this->getCode($exception);
        // var_dump($code);
        $this->controller->Json->setErrorJson($exception->getMessage(), $code);

        return $this->_outputMessage($this->template);
    }

    /**
     * HTTPステータスコードの取得
     *
     * @param \Throwable $exception Exception
     * @return int HTTPステータスコード
     */
    private function getCode(Throwable $exception): int
    {
        if ($exception->getCode() !== 0) {
            return $exception->getCode();
        }

        return $this->exceptionHttpCodes[get_class($exception)] ?? 500;
    }
}
