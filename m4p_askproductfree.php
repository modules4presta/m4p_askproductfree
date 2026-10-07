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


class m4p_askproductfree extends Module
{
    public function __construct()
    {
        $this->name = 'm4p_askproductfree';
        $this->tab = 'front_office_features';
        $this->version = '2.0.0';
        $this->author = 'Modules4Presta';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = ['min' => '1.7.6.0', 'max' => _PS_VERSION_];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('Ask about product', [], 'Modules.M4paskproductfree.Admin');
        $this->description = $this->trans('Adds an "ask about this product" button to the product page and mails the enquiry to the shop.', [], 'Modules.M4paskproductfree.Admin');
    }

    public function install()
    {
        return parent::install()
            && $this->registerHook('displayHeader')
            && $this->registerHook('displayProductAdditionalInfo')
            && Configuration::updateValue('m4p_askproductfree_switch', 1)
            && Configuration::updateValue('m4p_askproductfree_phone', 0)
            && Configuration::updateValue('m4p_askproductfree_company', 0);
    }

    public function uninstall()
    {
        Configuration::deleteByName('m4p_askproductfree_switch');
        Configuration::deleteByName('m4p_askproductfree_phone');
        Configuration::deleteByName('m4p_askproductfree_company');

        return parent::uninstall();
    }

    public function displayForm()
    {
        $fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->trans('Settings', [], 'Modules.M4paskproductfree.Admin'),
            ),
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->trans('Active module', [], 'Modules.M4paskproductfree.Admin'),
                    'name' => 'm4p_askproductfree_switch',
                    'is_bool' => true,
                    'desc' => $this->trans('On/Off module', [], 'Modules.M4paskproductfree.Admin'),
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->trans('On', [], 'Modules.M4paskproductfree.Admin')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->trans('Off', [], 'Modules.M4paskproductfree.Admin')
                        )
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->trans('Show phone number field', [], 'Modules.M4paskproductfree.Admin'),
                    'name' => 'm4p_askproductfree_phone',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->trans('On', [], 'Modules.M4paskproductfree.Admin')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->trans('Off', [], 'Modules.M4paskproductfree.Admin')
                        )
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->trans('Show company name field', [], 'Modules.M4paskproductfree.Admin'),
                    'name' => 'm4p_askproductfree_company',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->trans('On', [], 'Modules.M4paskproductfree.Admin')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->trans('Off', [], 'Modules.M4paskproductfree.Admin')
                        )
                    ),
                ),
            ),
            'submit' => array(
                'title' => $this->trans('Save', [], 'Modules.M4paskproductfree.Admin'),
                'class' => 'btn btn-default pull-right'
            )
        );
        $helper = new HelperForm();

        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;

        $helper->title = $this->displayName;
        $helper->show_toolbar = true;
        $helper->toolbar_scroll = true;
        $helper->submit_action = 'submit' . $this->name;
        $helper->toolbar_btn = array(
            'save' => array(
                'desc' => $this->trans('Save', [], 'Modules.M4paskproductfree.Admin'),
                'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&save' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'),
            ),
            'back' => array(
                'href' => AdminController::$currentIndex . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->trans('Back to list', [], 'Modules.M4paskproductfree.Admin')
            )
        );
        $helper->tpl_vars = array(
            'fields_value' => array(
                'm4p_askproductfree_switch' => (int) Configuration::get('m4p_askproductfree_switch'),
                'm4p_askproductfree_phone' => (int) Configuration::get('m4p_askproductfree_phone'),
                'm4p_askproductfree_company' => (int) Configuration::get('m4p_askproductfree_company'),
            ),
            'languages' => $this->context->controller->getLanguages(),
        );

        return $helper->generateForm($fields_form);
    }

    public function getContent()
    {
        if (Tools::isSubmit('submit' . $this->name)) {
            Configuration::updateValue('m4p_askproductfree_switch', (int) Tools::getValue('m4p_askproductfree_switch'));
            Configuration::updateValue('m4p_askproductfree_phone', (int) Tools::getValue('m4p_askproductfree_phone'));
            Configuration::updateValue('m4p_askproductfree_company', (int) Tools::getValue('m4p_askproductfree_company'));

            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name . '&conf=6');
        }

        return $this->displayForm();
    }

    public function hookDisplayHeader($params)
    {
        if (Configuration::get('m4p_askproductfree_switch') != 1) {
            return;
        }
        if ($this->context->controller->php_self !== 'product') {
            return;
        }

        Media::addJsDef(
            [
                'm4p_askproductfree_frontcontroller' => $this->context->link->getModuleLink('m4p_askproductfree', 'ajax'),
                'm4p_askproductfree_confirmation' => $this->trans('Your e-mail has been sent successfully', [], 'Modules.M4paskproductfree.Shop'),
                'm4p_askproductfree_problem' => $this->trans('Your e-mail could not be sent. Please check the name and e-mail address and try again.', [], 'Modules.M4paskproductfree.Shop'),
                'm4p_askproductfree_title' => $this->trans('Question about product', [], 'Modules.M4paskproductfree.Shop'),
            ]
        );
        $this->context->controller->registerStylesheet(
            'modules-m4p-askproductfree',
            'modules/' . $this->name . '/views/css/main.css',
            ['media' => 'all', 'priority' => 150]
        );
        $this->context->controller->registerJavascript(
            'modules-m4p-askproductfree',
            'modules/' . $this->name . '/views/js/main.js',
            ['position' => 'bottom', 'priority' => 150]
        );
    }

    public function hookDisplayProductAdditionalInfo($params)
    {
        if (Configuration::get('m4p_askproductfree_switch') != 1) {
            return;
        }
        if (Tools::getValue('controller') == 'product' && Tools::getValue('action') == 'quickview') {
            return;
        }

        $idProduct = (int) Tools::getValue('id_product');
        if (!$idProduct) {
            return;
        }

        $product = new Product($idProduct, false, $this->context->language->id);
        if (!Validate::isLoadedObject($product)) {
            return;
        }

        $this->context->smarty->assign(array(
            'm4p_askproductfree_id_product' => (int) $product->id,
            'm4p_askproductfree_product_name' => $product->name,
            'm4p_askproductfree_customer_email' => $this->context->customer->isLogged() ? $this->context->customer->email : '',
            'm4p_askproductfree_phone' => (int) Configuration::get('m4p_askproductfree_phone'),
            'm4p_askproductfree_company' => (int) Configuration::get('m4p_askproductfree_company'),
        ));

        return $this->display(__FILE__, 'views/templates/hook/askproduct.tpl');
    }
}
