<?php
declare(strict_types=1);

namespace App\Test\TestCase\Error;

use App\Error\AppExceptionRenderer;
use Cake\Controller\Exception\MissingActionException;
use Cake\Core\Exception\CakeException as Exception;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Exception\MissingControllerException;
use Cake\TestSuite\TestCase;
use CakephpFixtureFactories\Error\PersistenceException;
use PDOException;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\CSS\MissingColonSniff;
use Recochoku\Exception\RedisException;
use Recochoku\Util\Constants;

/**
 * App\Error\AppExceptionRenderer Test Case
 */
class AppExceptionRendererTest extends TestCase
{
    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test render method
     * - 正常系
     *
     * @return void
     */
    public function testRenderSuccess(): void
    {
        $expectedBody = [
            'errorMessage' => 'test error',
        ];

        $exceptionRenderer = new AppExceptionRenderer(new Exception('test error'));
        $response = $exceptionRenderer->render();
        $responseBody = json_decode((string)$response->getBody(), true);
        $responseCode = $response->getStatusCode();

        $this->assertSame($expectedBody, $responseBody);
        $this->assertSame(500, $responseCode);
    }

    /**
     * Test getCode method
     * ・ HTTPステータスコードの指定あり
     *
     * @return void
     */
    public function testGetCodeExceptionWithStatusCode(): void
    {
        $exception = new Exception('test error', 422);
        $exceptionRenderer = new AppExceptionRenderer($exception);

        $reflection = new \ReflectionClass($exceptionRenderer);
        $method = $reflection->getMethod('getCode');
        $method->setAccessible(true);

        $response = $method->invoke($exceptionRenderer, $exception);
        $this->assertSame(422, $response);
    }

    /**
     * Test getCode method
     * ・ Exception発生時
     *
     * @return void
     */
    public function testGetCodeException(): void
    {
        $exception = new Exception('test error');
        $exceptionRenderer = new AppExceptionRenderer($exception);

        $reflection = new \ReflectionClass($exceptionRenderer);
        $method = $reflection->getMethod('getCode');
        $method->setAccessible(true);

        $response = $method->invoke($exceptionRenderer, $exception);
        $this->assertSame(500, $response);
    }

    /**
     * Test getCode method
     * ・ RecordNotFoundException発生時
     *
     * @return void
     */
    public function testGetCodeRecordNotFoundException(): void
    {
        $exception = new RecordNotFoundException('test error');
        $exceptionRenderer = new AppExceptionRenderer($exception);

        $reflection = new \ReflectionClass($exceptionRenderer);
        $method = $reflection->getMethod('getCode');
        $method->setAccessible(true);

        $response = $method->invoke($exceptionRenderer, $exception);
        $this->assertSame(404, $response);
    }

    /**
     * Test getCode method
     * ・ PDOException発生時
     *
     * @return void
     */
    public function testGetCodePDOException(): void
    {
        $exception = new PDOException('test error');
        $exceptionRenderer = new AppExceptionRenderer($exception);

        $reflection = new \ReflectionClass($exceptionRenderer);
        $method = $reflection->getMethod('getCode');
        $method->setAccessible(true);

        $response = $method->invoke($exceptionRenderer, $exception);
        $this->assertSame(500, $response);
    }

    /**
     * Test getCode method
     * ・ PersistenceFailedException発生時
     *
     * @return void
     */
    public function testGetCodePersistenceFailedException(): void
    {
        $exception = new PersistenceException('test error');
        $exceptionRenderer = new AppExceptionRenderer($exception);

        $reflection = new \ReflectionClass($exceptionRenderer);
        $method = $reflection->getMethod('getCode');
        $method->setAccessible(true);

        $response = $method->invoke($exceptionRenderer, $exception);
        $this->assertSame(500, $response);
    }
}