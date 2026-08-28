<?php

/**
 * LICENCE
 *
 * ALL RIGHTS RESERVED.
 * YOU ARE NOT ALLOWED TO COPY/EDIT/SHARE/WHATEVER.
 *
 * IN CASE OF ANY PROBLEM CONTACT AUTHOR.
 *
 *  @author    Jakub Przepióra (jakub@modules4presta.io)
 *  @copyright modules4presta.io
 *  @license   ALL RIGHTS RESERVED
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class m4p_askproductfreeajaxModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        if (Configuration::get('m4p_askproductfree_switch') != 1) {
            $this->renderJson(false, $this->module->l('Module is disabled', 'ajax'));
        }

        if (Tools::getValue('action') !== 'askAboutProd') {
            $this->renderJson(false, $this->module->l('Invalid request', 'ajax'));
        }

        $customerMail = trim((string) Tools::getValue('email'));
        $company = trim((string) Tools::getValue('company'));
        $phone = trim((string) Tools::getValue('phone'));
        $idProduct = (int) Tools::getValue('id_product');
        $ask = trim((string) Tools::getValue('ask'));

        if (!$customerMail || !$idProduct) {
            $this->renderJson(false, $this->module->l('E-mail and product are required', 'ajax'));
        }

        if (!Validate::isEmail($customerMail)) {
            $this->renderJson(false, $this->module->l('Invalid e-mail address', 'ajax'));
        }

        if ($phone !== '' && !Validate::isPhoneNumber($phone)) {
            $this->renderJson(false, $this->module->l('Invalid phone number', 'ajax'));
        }

        if ($company !== '' && !Validate::isGenericName($company)) {
            $this->renderJson(false, $this->module->l('Invalid company name', 'ajax'));
        }

        if ($ask === '' || !Validate::isCleanHtml($ask)) {
            $this->renderJson(false, $this->module->l('Invalid question content', 'ajax'));
        }

        $idLang = (int) $this->context->language->id;
        $product = new Product($idProduct, false, $idLang);
        if (!Validate::isLoadedObject($product)) {
            $this->renderJson(false, $this->module->l('Product not found', 'ajax'));
        }

        $productName = is_array($product->name) ? reset($product->name) : $product->name;
        $productLink = $this->context->link->getProductLink($product);

        $templateVars = [
            '{product}' => Tools::safeOutput($productName),
            '{product_link}' => $productLink,
            '{phone}' => Tools::safeOutput($phone),
            '{company}' => Tools::safeOutput($company),
            '{customerMail}' => Tools::safeOutput($customerMail),
            '{ask}' => nl2br(Tools::safeOutput($ask)),
        ];

        $sent = Mail::Send(
            $idLang,
            'ask_product',
            $this->module->l('Question about product', 'ajax') . ': ' . $productName,
            $templateVars,
            Configuration::get('PS_SHOP_EMAIL'),
            null,
            null,
            null,
            null,
            null,
            _PS_MODULE_DIR_ . $this->module->name . '/mails/',
            false,
            (int) $this->context->shop->id,
            null,
            $customerMail
        );

        if (!$sent) {
            $this->renderJson(false, $this->module->l('Your e-mail could not be sent. Please try again later.', 'ajax'));
        }

        $this->renderJson(true, $this->module->l('Your e-mail has been sent successfully', 'ajax'));
    }

    private function renderJson($success, $message)
    {
        header('Content-Type: application/json');
        exit(json_encode([
            'success' => (bool) $success,
            'message' => $message,
        ]));
    }
}
