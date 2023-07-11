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


class m4p_askproductfreeajaxModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        if (Configuration::get('m4p_askproductfree_switch') != 1)
            die('0');
        if (Tools::getValue('action') == 'askAboutProd') {

            $customerMail = Tools::getValue('email');
            $company = Tools::getValue('company');
            $phone = Tools::getValue('phone');
            $id_product = Tools::getValue('id_product');
            $ask = Tools::getValue('question');

            if (!$customerMail || !$id_product) {
                die('0');
            }

            $isValidEmail = Validate::isEmail($customerMail);
            if (false === $isValidEmail) {
                die('0');
            }



            $product = new Product((int) $id_product, false, Tools::getValue('id_lang'));
            $productLink = Context::getContext()->link->getProductLink($product);

            $templateVars = array(
                '{product}' => $product->name,
                '{phone}' => $phone,
                '{company}' => $company,
                '{customerMail}' => $customerMail,
                '{ask}' => $ask
            );

            /* Email sending */
            if (
                !Mail::Send(
                    (int) Tools::getValue('id_lang'),
                    'ask_product',
                    sprintf('Question about'.$product->name ),
                    $templateVars,
                    Configuration::get('PS_SHOP_EMAIL'),
                    null,
                    null,
                    null,
                    null,
                    null,
                    dirname(__FILE__) . '/mails/',
                    false,
                    Context::getContext()->shop->id,
                    $customerMail,
                    $customerMail,

                )
            ) {
                die('0');
            }
            die('1');
        }
        die('0');
    }


}