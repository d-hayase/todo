<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;

/**
 * Jsonレスポンス返却
 */
class JsonComponent extends Component
{
    /**
     * @var \Cake\Controller\Controller|null
     */
    private $controller = null;

    /**
     * 初期処理
     *
     * @param array $config 設定ファイル
     * @return void
     */
    public function initialize(array $config): void
    {
        $this->controller = $this->_registry->getController();
        $this->controller->viewBuilder()->setClassName('Json');
    }

    /**
     * Jsonレスポンス生成
     *
     * @param array $responseList レスポンスリスト
     * @param int $statusCode HTTPステータスコード
     * @return void
     */
    public function setJson(
        array $responseList,
        int $statusCode
    ): void {
        $this->controller->set($responseList);
        $this->controller->viewBuilder()->setOption('serialize', array_keys($responseList));
        $this->controller->setResponse($this->controller->getResponse()->withStatus($statusCode));
    }

    /**
     * 正常系共通Json生成
     *
     * @param array $responseList レスポンスリスト
     * @return void
     */
    public function setSucceedJson(array $responseList): void
    {
        $this->setJson($responseList, 200);
    }

    /**
     * エラー系共通Json生成
     *
     * @param string $message エラーメッセージ
     * @param int $code HTTPステータスコード
     * @return void
     */
    public function setErrorJson(string $message, int $code): void
    {
        $response = [
            'errorMessage' => $message,
        ];
        $this->setJson($response, $code);
    }
}
