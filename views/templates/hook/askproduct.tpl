<a id="send_askproduct" class="" href="#send_askproduct_form">
   {l s='Ask about product' mod='m4p_askproductfree'}
</a>

<div style="display:none;">
    <div id="send_askproduct_form" class="card">

        <div class="card-block">

            <div class="send_askproduct_form_content col-lg-12" id="send_askproduct_form_content">
                <div class="form_container">
                    <div class="card-title">
                        <b>{l s='Question about product' mod='m4p_askproductfree'}: {$m4p_askproductfree_product_name|escape:'html':'UTF-8'}</b>
                    </div>
                    <input type="hidden" name="askproduct_id_product" id="askproduct_id_product" value="{$m4p_askproductfree_id_product|intval}">
                    <fieldset class="form-group">
                        <label class="form-control-label" for="askproduct_email">{l s='Your e-mail' mod='m4p_askproductfree'}</label>
                        <input id="askproduct_email" name="askproduct_email" type="email" value="{$m4p_askproductfree_customer_email|escape:'html':'UTF-8'}" class="form-control" required/>
                    </fieldset>

                    {if $m4p_askproductfree_company}
                        <fieldset class="form-group">
                            <label class="form-control-label" for="askproduct_company">{l s='Company' mod='m4p_askproductfree'}</label>
                            <input id="askproduct_company" name="askproduct_company" type="text" value="" class="form-control"/>
                        </fieldset>
                    {/if}

                    {if $m4p_askproductfree_phone}
                        <fieldset class="form-group">
                            <label class="form-control-label" for="askproduct_phone">{l s='Phone number' mod='m4p_askproductfree'}</label>
                            <input id="askproduct_phone" name="askproduct_phone" type="tel" value="" class="form-control"/>
                        </fieldset>
                    {/if}
                </div>
            </div>
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-control-label" for="askproduct_question">{l s='Your question' mod='m4p_askproductfree'}</label>
                    <textarea name="askproduct_question" id="askproduct_question" class="form-control" required></textarea>
                </fieldset>
            </div>
            <div class="col-lg-12 ">
                <div class="d-flex justify-content-center align-items-center">
                    <a class="btn btn-primary btn-lg" id="send_ask_about_product">
                        {l s='Send' mod='m4p_askproductfree'}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
