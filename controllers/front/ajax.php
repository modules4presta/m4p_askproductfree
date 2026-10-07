<?php

/**
 * m4p_askproductfree
 *
 * @author    Modules4Presta <contact@modules4presta.io>
 * @copyright 2026 Nice Code sp. z o.o. (Modules4Presta)
 * @license   https://opensource.org/licenses/MIT MIT License
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class m4p_askproductfreeajaxModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        if (Configuration::get('m4p_askproductfree_switch') != 1) {
            $this->renderJson(false, $this->trans('Module is disabled', [], 'Modules.M4paskproductfree.Shop'));
        }

        if (Tools::getValue('action') !== 'askAboutProd') {
            $this->renderJson(false, $this->trans('Invalid request', [], 'Modules.M4paskproductfree.Shop'));
        }

        $customerMail = trim((string) Tools::getValue('email'));
        $company = trim((string) Tools::getValue('company'));
        $phone = trim((string) Tools::getValue('phone'));
        $idProduct = (int) Tools::getValue('id_product');
        $ask = trim((string) Tools::getValue('ask'));

        if (!$customerMail || !$idProduct) {
            $this->renderJson(false, $this->trans('E-mail and product are required', [], 'Modules.M4paskproductfree.Shop'));
        }

        if (!Validate::isEmail($customerMail)) {
            $this->renderJson(false, $this->trans('Invalid e-mail address', [], 'Modules.M4paskproductfree.Shop'));
        }

        if ($phone !== '' && !Validate::isPhoneNumber($phone)) {
            $this->renderJson(false, $this->trans('Invalid phone number', [], 'Modules.M4paskproductfree.Shop'));
        }

        if ($company !== '' && !Validate::isGenericName($company)) {
            $this->renderJson(false, $this->trans('Invalid company name', [], 'Modules.M4paskproductfree.Shop'));
        }

        if ($ask === '' || !Validate::isCleanHtml($ask)) {
            $this->renderJson(false, $this->trans('Invalid question content', [], 'Modules.M4paskproductfree.Shop'));
        }

        $idLang = (int) $this->context->language->id;
        $product = new Product($idProduct, false, $idLang);
        if (!Validate::isLoadedObject($product)) {
            $this->renderJson(false, $this->trans('Product not found', [], 'Modules.M4paskproductfree.Shop'));
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
            $this->trans('Question about product', [], 'Modules.M4paskproductfree.Shop') . ': ' . $productName,
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
            $this->renderJson(false, $this->trans('Your e-mail could not be sent. Please try again later.', [], 'Modules.M4paskproductfree.Shop'));
        }

        $this->renderJson(true, $this->trans('Your e-mail has been sent successfully', [], 'Modules.M4paskproductfree.Shop'));
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
