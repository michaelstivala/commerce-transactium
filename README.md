Transactium payment gateway plugin for Craft Commerce 2
=======================

This plugin provides [Transactium](https://www.transactium.com/) integration for [Craft Commerce](https://craftcommerce.com/).

It provides the Transactium gateway.

## Requirements

This plugin requires Craft Commerce 2.0.0-alpha.5 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require michaelstivala/commerce-transactium

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Transactium.

## Setup

To add a Transactium payment gateway, go to Commerce → Settings → Gateways, create a new gateway, and set the gateway type to "Transactium".

In order to allow the payment gateway to be loaded in an iFrame, you need to create a template that responds to the route `/checkout/transactium` in your application that initates the payment flow - like below:

```
<html>
<body>
    LOADING PAYMENT GATEWAY...
    <form method="POST" id="transactium-payment-form">
        <input type="hidden" name="action" value="commerce/payments/pay"/>
        {{ redirectInput('account/orders-iframe?order={number}') }}
        <input type="hidden" name="cancelUrl" value="{{ url('/checkout/payment?cancel=true')|hash }}"/>
        {{ csrfInput() }}
    </form>
    <script type="text/javascript">
        document.getElementById("transactium-payment-form").submit();
    </script>
</body>
</html>
```