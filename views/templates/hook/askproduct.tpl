<a id="send_askproduct" class="" href="#send_askproduct">
    <i class="material-icons">help_outline</i>{l s='Ask about product' mod='m4p_askproductfree'}
</a>

<div>
    <div id="send_askproduct_form" class="card">
        <div class="card-block">

            <div class="send_askproduct_form_content col-lg-6" id="send_askproduct_form_content">
                <div class="form_container">
                    {if !Context::getContext()->customer->islogged()}
                        <fieldset class="form-group">
                            <label class="form-control-label" for="askproduct_author">{l s='Your name' mod='m4p_askproductfree'}</label>
                            <input id="askproduct_author" name="askproduct_author" type="text" value="" class="form-control"/>
                        </fieldset>
                    {else}
                        <fieldset class="form-group">
                            <label class="form-control-label" for="askproduct_author">{l s='Your name' mod='m4p_askproductfree'}</label>
                            <input disabled id="askproduct_author" name="askproduct_author" type="text" value="{Context::getContext()->customer->firstname} {Context::getContext()->customer->lastname}" class="form-control disabled"/>
                            <p class="small">({l s='You are logged as a customer, we get your name automatically from your account details' mod='askproduct'})</p>
                        </fieldset>
                    {/if}
                    {if !Context::getContext()->customer->islogged()}
                        <fieldset class="form-group">
                            <label class="form-control-label" for="askproduct_email">{l s='Your e-mail' mod='m4p_askproductfree'}</label>
                            <input id="askproduct_email" name="askproduct_email" type="text" value="" class="form-control"/>
                        </fieldset>
                    {else}
                        <fieldset class="form-group">
                            <label class="form-control-label" for="askproduct_email">{l s='Your e-mail' mod='m4p_askproductfree'}</label>
                            <input id="askproduct_email" name="askproduct_email" type="text" value="{Context::getContext()->customer->email}" class="form-control"/>
                        </fieldset>
                    {/if}
                    {if m4p_askproductfree_phone}
                        <fieldset class="form-group">
                            <label class="form-control-label" for="askproduct_company">{l s='Company' mod='m4p_askproductfree'}</label>
                            <input id="askproduct_company" name="askproduct_company" type="text" value="" class="form-control"/>
                        </fieldset>
                    {/if}
                    {if m4p_askproductfree_phone}
                        <fieldset class="form-group">
                            <label class="form-control-label" for="askproduct_phone">{l s='Phone number' mod='m4p_askproductfree'}</label>
                            <input id="askproduct_phone" name="askproduct_phone" type="text" value="" class="form-control"/>
                        </fieldset>
                    {/if}
                </div>
            </div>
           <div class="col-lg-6">
                <fieldset class="form-group">
                    <label class="form-control-label" for="question">{l s='Your question' mod='m4p_askproductfree'}</label>
                    <textarea name="askproduct_question" id="askproduct_question" class="form-control"></textarea>
                </fieldset>
            </div>
        </div>
    </div>
</div>