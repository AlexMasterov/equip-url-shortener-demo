<?php

namespace UrlShortener\Application\Handler;

use Equip\Payload;
use Equip\Resolver\ResolverTrait;
use Equip\Responder\FormattedResponder;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Relay\ResolverInterface;
use Throwable;

class ExceptionHandler
{
    use ResolverTrait;

    const MINIMUM_HTTP_CODE = 100;
    const MAXIMUM_HTTP_CODE = 599;
    const MISSING_HTTP_CODE = 200;

    /**
     * @var integer
     */
    private $missingHttpCode;

    /**
     * @param ResolverInterface $resolver
     * @param integer $missingHttpCode
     */
    public function __construct(
        ResolverInterface $resolver,
        $missingHttpCode = self::MISSING_HTTP_CODE
    ) {
        $this->resolver = $resolver;
        $this->missingHttpCode = $missingHttpCode;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ) {
        try {
            return $next($request, $response);
        } catch (Throwable $throwable) {
            return $this->withException($request, $response, $throwable);
        } catch (Exception $exception) {
            return $this->withException($request, $response, $exception);
        }
    }

    public function withException(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $exception
    ) {
        $response = $this->status($response, $exception);
        $response = $this->format($request, $response, $exception);

        return $response;
    }

    /**
     * Get the response with the status code from the exception.
     *
     * @param ResponseInterface $response
     * @param Throwable|Exception $exception
     *
     * @return ResponseInterface
     */
    private function status(
        ResponseInterface $response,
        $exception
    ) {
        $exceptionCode = $exception->getCode();

        $options = [
            'default'   => $this->missingHttpCode,
            'min_range' => self::MINIMUM_HTTP_CODE,
            'max_range' => self::MAXIMUM_HTTP_CODE,
        ];

        $code = filter_var($exceptionCode, FILTER_VALIDATE_INT, compact('options'));

        return $response->withStatus($code);
    }

    /**
     * Update the response.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param Throwable|Exception $exception
     *
     * @return ResponseInterface
     */
    private function format(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $exception
    ) {
        $formatter = $this->resolve(FormattedResponder::class);
        $payload = $this->payload($exception);

        return $formatter($request, $response, $payload);
    }

    /**
     * Get the payload with the exception.
     *
     * @param Throwable|Exception $exception
     *
     * @return Payload
     */
    private function payload($exception)
    {
        $message = $exception->getMessage();

        $payload = $this->resolve(Payload::class);
        $payload = $payload
            ->withSetting('template', 'exception')
            ->withOutput(compact('message'));

        return $payload;
    }
}
