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

require_once __DIR__ . '/classes/Modules4PrestaMarketingAskProductFree.php';

class m4p_askproductfree extends Module
{
    public function __construct()
    {
        $this->name = 'm4p_askproductfree';
        $this->tab = 'front_office_features';
        $this->version = '1.0.7';
        $this->author = 'Modules4Presta.io';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7',
            'max' => '8.1.99',
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Ask about product FREE');
        $this->description = $this->l('Module to add ask button to product page if out off stock').' &nbsp;<a href="https://modules4presta.io/index.php?action=redirectToModule&fc=module&module=mfp_license_manager&controller=ajax&modulename=m4p_askproductpro" target="_blank">'.$this->l('Get PRO').'</a>';
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
                'title' => $this->l('Settings'),
            ),
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Active module'),
                    'name' => 'm4p_askproductfree_switch',
                    'is_bool' => true,
                    'desc' => $this->l('On/Off module'),
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('On')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Off')
                        )
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show phone number field'),
                    'name' => 'm4p_askproductfree_phone',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('On')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Off')
                        )
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Show company name field'),
                    'name' => 'm4p_askproductfree_company',
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('On')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Off')
                        )
                    ),
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
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
                'desc' => $this->l('Save'),
                'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&save' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'),
            ),
            'back' => array(
                'href' => AdminController::$currentIndex . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
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

        $ads = '';
        $modulesAds = Modules4PrestaMarketingAskProductFree::getAdsFromModules4Presta();
        if (!empty($modulesAds)) {
            $this->context->smarty->assign([
                'modules_ads' => $modulesAds,
            ]);
            $ads = $this->context->smarty->fetch(_PS_MODULE_DIR_ . $this->name . '/views/templates/admin/m4p_ads.tpl');
        }

        return $this->displayForm() . $ads;
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
                'm4p_askproductfree_confirmation' => $this->l('Your e-mail has been sent successfully'),
                'm4p_askproductfree_problem' => $this->l('Your e-mail could not be sent. Please check the name and e-mail address and try again.'),
                'm4p_askproductfree_title' => $this->l('Question about product'),
            ]
        );
        $this->context->controller->addJqueryPlugin('fancybox');
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
