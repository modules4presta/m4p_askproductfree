{**
 * m4p_askproductfree
 *
 * @author    Modules4Presta <contact@modules4presta.io>
 * @copyright 2026 Nice Code sp. z o.o. (Modules4Presta)
 * @license   https://opensource.org/licenses/MIT MIT License
 *}
<div class="m4p-askproduct">
    <button type="button" class="btn btn-secondary m4p-askproduct__open" data-askproduct-open="1">
        {l s='Ask about product' d='Modules.M4paskproductfree.Shop'}
    </button>

    <div class="m4p-askproduct__modal" id="m4p-askproduct-modal" role="dialog" aria-modal="true"
         aria-labelledby="m4p-askproduct-title" hidden>
        <div class="m4p-askproduct__overlay" data-askproduct-close="1"></div>

        <div class="m4p-askproduct__dialog">
            <button type="button" class="m4p-askproduct__close" data-askproduct-close="1"
                    aria-label="{l s='Close' d='Modules.M4paskproductfree.Shop'}">&times;</button>

            <h2 class="m4p-askproduct__title" id="m4p-askproduct-title">
                {l s='Question about product' d='Modules.M4paskproductfree.Shop'}
            </h2>
            <p class="m4p-askproduct__product">
                <span class="m4p-askproduct__product-label">{l s='Product' d='Modules.M4paskproductfree.Shop'}:</span>
                <strong>{$m4p_askproductfree_product_name|escape:'html':'UTF-8'}</strong>
            </p>

            <div class="m4p-askproduct__form">
                <input type="hidden" id="askproduct_id_product" value="{$m4p_askproductfree_id_product|intval}">

                <div class="form-group">
                    <label class="form-control-label" for="askproduct_email">
                        {l s='Your e-mail' d='Modules.M4paskproductfree.Shop'}
                    </label>
                    <input id="askproduct_email" type="email" class="form-control" required
                           value="{$m4p_askproductfree_customer_email|escape:'html':'UTF-8'}">
                </div>

                {if $m4p_askproductfree_company}
                    <div class="form-group">
                        <label class="form-control-label" for="askproduct_company">
                            {l s='Company' d='Modules.M4paskproductfree.Shop'}
                        </label>
                        <input id="askproduct_company" type="text" class="form-control">
                    </div>
                {/if}

                {if $m4p_askproductfree_phone}
                    <div class="form-group">
                        <label class="form-control-label" for="askproduct_phone">
                            {l s='Phone number' d='Modules.M4paskproductfree.Shop'}
                        </label>
                        <input id="askproduct_phone" type="tel" class="form-control">
                    </div>
                {/if}

                <div class="form-group">
                    <label class="form-control-label" for="askproduct_question">
                        {l s='Your question' d='Modules.M4paskproductfree.Shop'}
                    </label>
                    <textarea id="askproduct_question" class="form-control" rows="4" required></textarea>
                </div>

                <p class="m4p-askproduct__message" id="m4p-askproduct-message" role="status" hidden></p>

                <button type="button" class="btn btn-primary m4p-askproduct__send" id="send_ask_about_product">
                    {l s='Send' d='Modules.M4paskproductfree.Shop'}
                </button>
            </div>
        </div>
    </div>
</div>
