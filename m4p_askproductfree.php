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



require_once __DIR__ . '/classes/Modules4PrestaMarketingAskProductFree.php';


if (!defined('_PS_VERSION_')) {
    exit;
}

class m4p_askproductfree extends Module
{


    public function __construct()
    {
        $this->name = 'm4p_askproductfree';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Modules4Presta.io';
        $this->need_instance = 0;
        $this->_path = _PS_MODULE_DIR_.$this->name;
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

        if (!parent::install()) {
            return false;
        }
        if(!$this->registerHook('displayHeader')) return false;
        if(!$this->registerHook('displayProductAdditionalInfo')) return false;

        return true;
    }

    public function uninstall()
    {
        // Deletes module tables
        

        if (!parent::uninstall()) {
            return false;
        }
        return true;

    }

    public function displayForm(){
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
                    'desc' => $this->l('On/Off connect with Clarity'),
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
                    'label' => $this->l('Aktywuj wymaganie numeru telefonu'),
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
                    'label' => $this->l('Aktywuj podanie nazwy firmy'),
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
                'title' => $this->l('Zapisz'),
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

                'm4p_askproductfree_switch' => Configuration::get('m4p_askproductfree_switch'),
                'm4p_askproductfree_switch' => Configuration::get('m4p_askproductfree_phone'),
                'm4p_askproductfree_switch' => Configuration::get('m4p_askproductfree_company'),
            ),
            'languages' => $this->context->controller->getLanguages(),
        );


        return $helper->generateForm($fields_form);
    }

    public function getContent()
    {
        $output = '';

        if (Tools::isSubmit('submit' . $this->name)) {

            $m4p_askproductfree_phone = Tools::getValue('m4p_askproductfree_phone');
            $m4p_askproductfree_switch = Tools::getValue('m4p_askproductfree_switch');
            $m4p_askproductfree_company = Tools::getValue('m4p_askproductfree_company');



            Configuration::updateValue('m4p_askproductfree_phone', $m4p_askproductfree_phone);
            Configuration::updateValue('m4p_askproductfree_switch', $m4p_askproductfree_switch);
            Configuration::updateValue('m4p_askproductfree_company', $m4p_askproductfree_company);

            $output .= $this->displayConfirmation($this->l('Poprawnie zapisano'));
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name . '&conf=6');

        }
        require_once dirname(__FILE__) . '/classes/Modules4PrestaMarketingAskProductFree.php';
        $this->context->smarty->assign(array(
            'modules_ads' => Modules4PrestaMarketingAskProductFree::getAdsFromModules4Presta()
        ));
        $this->content .= $this->context->smarty->fetch(_PS_MODULE_DIR_.$this->name.'/views/templates/admin/m4p_ads.tpl');

        $this->context->smarty->assign(array(
            'content' => $this->content,
            'modules_ads' => Modules4PrestaMarketingAskProductFree::getAdsFromModules4Presta()
        ));
        $output .= $this->displayForm().$this->content;

        return $output ;
    }

    public function hookDisplayHeader()
    {


    }
    public function hookDisplayProductAdditionalInfo($params)
    {
        if (Tools::getValue('controller') == 'product' && Tools::getValue('action') == 'quickview') {
            return;
        }

        $product = new Product((int)Tools::getValue('id_product'), false, $this->context->language->id);
        $thumbnail = Product::getCover((int)$product->id);

        $this->context->smarty->assign(array(
            'm4p_askproductfree_link' => $this->context->link,
            'm4p_askproductfree_product_thumbnail' => (int)$product->id . '-' . (int)$thumbnail['id_image'],
            'm4p_askproductfreeproduct' => $product,

        ));

        return $this->display(__FILE__, 'views/templates/hook/askproduct.tpl');
    }

    
}