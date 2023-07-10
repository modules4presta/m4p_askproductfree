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


class m4p_switch_invoiceajaxModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        if (Module::isEnabled('aapfree') && Tools::getValue('action') == 'sendQuestion' && Tools::getValue('secure_key') == $this->module->secure_key) {

            $customerMail = Tools::getValue('email');
            $author = Tools::getValue('author');
            $phone = Tools::getValue('phone');
            $id_product = Tools::getValue('id_product');
            $question = Tools::getValue('question');

            if (!$customerMail || !$id_product) {
                die('0');
            }

            $isValidEmail = Validate::isEmail($customerMail);
            if (false === $isValidEmail) {
                die('0');
            }


            /** check if combination **/
            $combinations_array = array();
            $combination_id = 0;
            if (Tools::getValue('group', 'false') != 'false') {
                $groups = Tools::getValue('group');
                if (empty($groups)) {
                    return null;
                }

                $combination_id = (int) Product::getIdProductAttributeByIdAttributes(
                    Tools::getValue('id_product'),
                    $groups,
                    true
                );
            }

            $combination_variable = '';
            $combination = '';
            if ($combination_id > 0) {
                $comb = new Combination($combination_id);
                if (is_object($comb)) {
                    foreach ($comb->getAttributesName(Tools::getValue('id_lang')) as $attr) {
                        if ($this->psversion(0) >= 8) {
                            $attribute = new ProductAttribute($attr['id_attribute'], Tools::getValue('id_lang'));

                        } else {
                            $attribute = new Attribute($attr['id_attribute'], Tools::getValue('id_lang'));
                        }
                        $attribute_group = new AttributeGroup($attribute->id_attribute_group, Tools::getValue('id_lang'));
                        $combinations_array[] = $attribute_group->public_name . ': ' . $attr['name'];
                    }
                    $combination_variable = implode(",", $combinations_array);
                    $combination = '(' . implode(",", $combinations_array) . ')';
                }
            }

            /* Email generation */
            $product = new Product((int) $id_product, false, Tools::getValue('id_lang'));
            $productLink = Context::getContext()->link->getProductLink($product);

            $templateVars = array(
                '{product}' => $product->name . $combination,
                '{combination}' => $combination_variable,
                '{product_link}' => $productLink,
                '{productLink}' => $productLink,
                '{customer}' => $author,
                '{phone}' => $phone,
                '{customerMail}' => $customerMail,
                '{question}' => $question
            );

            /* Email sending */
            if (
                !Mail::Send(
                    (int) Tools::getValue('id_lang'),
                    'send_question',
                    sprintf(Configuration::get('aapfree_TITLE', (int) Tools::getValue('id_lang')), $author, $product->name),
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
                    $author
                )
            ) {
                die('0');
            }
            die('1');
        }
        die('0');
    }


}