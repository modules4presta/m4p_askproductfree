# M4P Ask About Product for PrestaShop 8 & 9

**Let a buyer ask about a product without hunting for your contact page — one button, one modal, one e-mail with the product attached.**

> **Meta description (150 chars):** Add an "ask about this product" button to PrestaShop product pages. The question reaches your inbox with a link to the product. Free MIT module.

---

## Why a question is worth more than a bounce

Somebody looking at a product with a question in their head does one of two things: writes to you,
or leaves. Most leave, because writing means finding the contact page, then explaining which product
they meant:

- **The product comes with the question** — name and link are in the e-mail, nothing to explain
- **No account needed** — an e-mail address is enough to ask
- **Works when stock is out** — the question replaces the order you cannot take today
- **A lead you can answer** — for a wholesale shop, an enquiry is worth more than a cart

## What the module does

The module adds a button to the product page. Clicking it opens a modal with an e-mail field, a
question box and — when you switch them on — phone and company fields. Sending mails the question to
your shop address, with the product name and a link to it.

### Key features

- **Optional phone and company fields** — switch them on for a B2B shop, off for a consumer one
- **Validated before sending** — address, phone, company and the question itself are checked
- **In the shop's language** — the modal and the mail follow the customer's language
- **One switch** — turn the button off without uninstalling
- **No external services** — no analytics, no calls to anybody's server
- **No jQuery plugins** — the modal is plain markup and a few lines of JavaScript

### What it does not do

The module does not keep enquiries in the back office, does not assign them to anyone and does not
reply automatically. The question arrives as an e-mail; the conversation happens in your mailbox.

## Compatibility

| | |
|---|---|
| PrestaShop | 1.7.6 – 9.x |
| PHP | 7.2.5+ |
| Requirements | a working shop e-mail configuration |
| Multistore | Settings are shared across shops |
| Themes | Needs a theme that renders `displayProductAdditionalInfo` (all standard themes do) |

The module performs no core overrides and adds no database tables — it stores three settings.

## Installation

1. Upload and install the module from **Modules → Module Manager**.
2. Open the module configuration and decide whether to ask for a phone number and a company name.
3. Open any product page — the button is under the product details.
4. Send a test question and check that it arrives at your shop address.

## Configuration options

| Setting | Description |
|---|---|
| **Active module** | Shows or hides the button without uninstalling. |
| **Show phone number field** | Adds a phone field to the modal; validated when filled. |
| **Show company name field** | Adds a company field, useful when your buyers order for a business. |

## Frequently asked questions

**Where do the questions go?**
To the shop e-mail address set in **Shop Parameters → Contact**. The module sends, it does not store.

**Can the customer attach a file?**
No. Attachments mean storage, size limits and a virus policy — deliberately out of scope.

**Is the form protected against bots?**
The fields are validated, but there is no captcha. Put your shop behind whatever protection you
already use if automated submissions become a problem.

**Does it work when the product is out of stock?**
Yes, and that is the point — the button is there whether or not the product can be bought today.

**What happens to the settings when I uninstall the module?**
All three are deleted.

---

**Keywords:** PrestaShop ask about product, product enquiry, lead generation, B2B question form,
out of stock enquiry, contact about product.

## License

MIT — see [LICENSE](LICENSE). Free to use commercially, fork and modify; keep the copyright notice.

## Contributing

Bug reports and pull requests are welcome — see [CONTRIBUTING.md](CONTRIBUTING.md). For security
issues, follow [SECURITY.md](SECURITY.md) instead of opening a public issue.

---

Built by [Nice Code](https://nice-code.com/pl/oferta/moduly-prestashop) — we build and maintain PrestaShop stores.

© Nice Code sp. z o.o. (Modules4Presta) — released under the MIT license.
