/**
 * m4p_askproductfree
 *
 * @author    Modules4Presta <contact@modules4presta.io>
 * @copyright 2026 Nice Code sp. z o.o. (Modules4Presta)
 * @license   https://opensource.org/licenses/MIT MIT License
 */
(function () {
    'use strict';

    var root = document.querySelector('.m4p-askproduct');
    if (!root) { return; }

    var modal = root.querySelector('.m4p-askproduct__modal');
    var button = root.querySelector('.m4p-askproduct__send');
    var messageBox = root.querySelector('.m4p-askproduct__message');

    function field(id) {
        var el = document.getElementById(id);
        return el ? el.value.trim() : '';
    }

    function showMessage(text, ok) {
        messageBox.textContent = text;
        messageBox.className = 'm4p-askproduct__message m4p-askproduct__message--' + (ok ? 'ok' : 'error');
        messageBox.hidden = false;
    }

    function clearMessage() {
        messageBox.hidden = true;
        messageBox.textContent = '';
    }

    function open() {
        clearMessage();
        modal.hidden = false;
        document.body.classList.add('m4p-askproduct-open');
        document.addEventListener('keydown', onKey);

        var first = document.getElementById('askproduct_email');
        if (first) { first.focus(); }
    }

    function close() {
        modal.hidden = true;
        document.body.classList.remove('m4p-askproduct-open');
        document.removeEventListener('keydown', onKey);
    }

    function onKey(event) {
        if (event.key === 'Escape') { close(); }
    }

    root.addEventListener('click', function (event) {
        if (event.target.closest('[data-askproduct-open]')) {
            event.preventDefault();
            open();
        }
        if (event.target.hasAttribute('data-askproduct-close')) {
            event.preventDefault();
            close();
        }
    });

    button.addEventListener('click', function (event) {
        event.preventDefault();
        send();
    });

    // The block cannot be a <form>: the hook renders inside the product page's
    // own form and the browser drops a nested one, taking its styling hooks with it.
    function clearFields() {
        ['askproduct_question', 'askproduct_company', 'askproduct_phone'].forEach(function (id) {
            var el = document.getElementById(id);
            if (el) { el.value = ''; }
        });
    }

    function send() {
        var email = field('askproduct_email');
        var question = field('askproduct_question');
        var idProduct = parseInt(field('askproduct_id_product'), 10);

        if (!email || !question || !idProduct) {
            showMessage(window.m4p_askproductfree_problem, false);

            return;
        }

        var body = new URLSearchParams({
            action: 'askAboutProd',
            email: email,
            ask: question,
            id_product: idProduct,
            company: field('askproduct_company'),
            phone: field('askproduct_phone')
        });

        button.disabled = true;
        clearMessage();

        fetch(window.m4p_askproductfree_frontcontroller, {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: body.toString()
        })
            .then(function (response) { return response.json(); })
            .then(function (result) {
                if (result && result.success) {
                    showMessage(result.message || window.m4p_askproductfree_confirmation, true);
                    clearFields();
                } else {
                    showMessage((result && result.message) || window.m4p_askproductfree_problem, false);
                }
            })
            .catch(function () {
                showMessage(window.m4p_askproductfree_problem, false);
            })
            .then(function () {
                button.disabled = false;
            });
    }
})();
