<?php

namespace Stivala\Commerce\Transactium\Gateways;

use Craft;
use craft\web\View;
use Omnipay\Omnipay;
use craft\web\Response;
use Omnipay\Common\AbstractGateway;
use craft\commerce\Plugin as Commerce;
use craft\commerce\models\Transaction;
use craft\commerce\omnipay\base\OffsiteGateway;
use craft\commerce\base\RequestResponseInterface;
use Omnipay\Transactium\Gateway as OmnipayGateway;
use craft\commerce\models\payments\BasePaymentForm;
use Stivala\Commerce\Transactium\Models\TransactiumPaymentForm;
use Stivala\Commerce\Transactium\Adaptors\GetHostedPaymentResponseAdaptor;

class Gateway extends OffsiteGateway
{
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    /**
     * @var boolean
     */
    public $testMode = false;

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('commerce', 'Transactium');
    }

    /**
     * @inheritdoc
     */
    public function getPaymentFormHtml(array $params = [])
    {
        $defaults = [
            'gateway' => $this,
            'paymentForm' => $this->getPaymentFormModel(),
        ];

        $params = array_merge($defaults, $params);

        $view = Craft::$app->getView();

        $previousMode = $view->getTemplateMode();
        $view->setTemplateMode(View::TEMPLATE_MODE_CP);

        $html = Craft::$app->getView()->renderTemplate('commerce-transactium/paymentForm', $params);
        $view->setTemplateMode($previousMode);

        return $html;
    }

    /**
     * @inheritdoc
     */
    public function getPaymentFormModel(): BasePaymentForm
    {
        return new TransactiumPaymentForm();
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('commerce-transactium/gatewaySettings', ['gateway' => $this]);
    }

    public function supportsCompletePurchase(): bool
    {
        return true;
    }

    public function completePurchase(Transaction $transaction): RequestResponseInterface
    {
        $transactiumId = Craft::$app->getRequest()->getRequiredParam('hpsid');

        return new GetHostedPaymentResponseAdaptor(
            $this->createGateway()->getHostedPayment($transactiumId)->send()
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createGateway(): AbstractGateway
    {
        /** @var OmnipayGateway $gateway */
        $gateway = Omnipay::create($this->getGatewayClassName());

        $gateway->setUsername($this->username);
        $gateway->setPassword($this->password);
        $gateway->setTestMode($this->testMode);

        return $gateway;
    }

    /**
     * @inheritdoc
     */
    protected function getGatewayClassName()
    {
        return '\\'.OmnipayGateway::class;
    }
}
