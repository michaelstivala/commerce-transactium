<?php

namespace Stivala\Commerce\Transactium\Adaptors;

use craft\commerce\base\RequestResponseInterface;
use Omnipay\Transactium\Api\Responses\GetHostedPaymentResponse;

class GetHostedPaymentResponseAdaptor implements RequestResponseInterface
{
    protected $getHostedPaymentResponse;

    public function __construct(GetHostedPaymentResponse $getHostedPaymentResponse)
    {
        $this->getHostedPaymentResponse = $getHostedPaymentResponse;
    }

    /**
     * Returns whether or not the payment was successful.
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->getHostedPaymentResponse->isSuccessful();
    }

    /**
     * Returns whether or not the payment is being processed by gateway.
     *
     * @return bool
     */
    public function isProcessing(): bool
    {
        return false;
    }

    /**
     * Returns whether or not the user needs to be redirected.
     *
     * @return bool
     */
    public function isRedirect(): bool
    {
        return $this->getHostedPaymentResponse->isRedirect();
    }

    /**
     * Returns the redirect method to use, if any.
     *
     * @return string
     */
    public function getRedirectMethod(): string
    {
        return $this->getHostedPaymentResponse->getRedirectMethod();
    }

    /**
     * Returns the redirect data provided.
     *
     * @return array
     */
    public function getRedirectData(): array
    {
        return $this->getHostedPaymentResponse->getRedirectData();
    }

    /**
     * Returns the redirect URL to use, if any.
     *
     * @return string
     */
    public function getRedirectUrl(): string
    {
        return $this->getHostedPaymentResponse->getRedirectUrl();
    }

    /**
     * Returns the transaction reference.
     *
     * @return string
     */
    public function getTransactionReference(): string
    {
        return $this->getHostedPaymentResponse->getTransactionReference() ?: '';
    }

    /**
     * Returns the response code.
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->getHostedPaymentResponse->getCode() ?: '';
    }

    /**
     * Returns the data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->getHostedPaymentResponse->getData();
    }

    /**
     * Returns the gateway message.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->getHostedPaymentResponse->getMessage();
    }

    /**
     * Perform the redirect.
     *
     * @return mixed
     */
    public function redirect()
    {
        return $this->getHostedPaymentResponse->redirect();
    }
}
