# Ask about product FREE (m4p_askproductfree)

PrestaShop module that adds an **"Ask about product"** button with a contact form to the product page. Customers can quickly send a question about a specific product straight to the shop e-mail — useful especially for out-of-stock or quote-based products.

🇵🇱 [Wersja polska poniżej](#-wersja-polska)

---

## Features

- "Ask about product" button on the product page (hook `displayProductAdditionalInfo`)
- Question form in a modal (fancybox) with fields:
  - e-mail (pre-filled for logged-in customers)
  - question content
  - phone number *(optional — enabled in configuration)*
  - company name *(optional — enabled in configuration)*
- Question is sent to the shop e-mail (`PS_SHOP_EMAIL`) with the customer's address set as **Reply-To**, so you can reply directly from your mail client
- E-mail templates in Polish and English (HTML + text)
- Server-side validation of every field (e-mail, phone, company, question, product existence)
- User input is escaped before being inserted into the e-mail (HTML injection protection)
- Assets (JS/CSS) are loaded **only** on the product page and only when the module is enabled
- Module on/off switch in the configuration — no need to uninstall

## Compatibility

| Requirement | Version |
|---|---|
| PrestaShop | 1.7.x – 8.1.x |
| PHP | 7.3+ |

## Installation

### From a release ZIP (recommended)

1. Download `m4p_askproductfree.zip` from the [latest release](https://github.com/modules4presta/m4p_askproductfree/releases/latest).
2. In the PrestaShop back office go to **Modules → Module Manager → Upload a module** and upload the ZIP.
3. The module installs and enables itself automatically.

### From source

```bash
cd /path/to/prestashop/modules
git clone https://github.com/modules4presta/m4p_askproductfree
```

Then install the module from **Modules → Module Manager**.

## Configuration

**Modules → Module Manager → Ask about product FREE → Configure**

| Option | Description | Default |
|---|---|---|
| Active module | Turns the button and the form on/off on the product page | On |
| Show phone number field | Adds an optional phone field to the form | Off |
| Show company name field | Adds an optional company field to the form | Off |

## How it works

1. The customer clicks **Ask about product** on the product page — a modal with the form opens.
2. After submitting, the data goes via AJAX to the module front controller (`controllers/front/ajax.php`).
3. The controller validates the input (e-mail format, phone, company, question, product existence) and sends the e-mail using the `mails/<iso>/ask_product` template to the address configured in `PS_SHOP_EMAIL`.
4. The customer's address is set as **Reply-To**, so replying to the inquiry is a single click.

### E-mail template variables

| Placeholder | Content |
|---|---|
| `{product}` | Product name |
| `{product_link}` | Product URL |
| `{customerMail}` | Customer e-mail |
| `{phone}` | Phone number (if provided) |
| `{company}` | Company name (if provided) |
| `{ask}` | Question content |

Templates live in `mails/pl/` and `mails/en/` (`ask_product.html` + `ask_product.txt`). You can override them per shop the standard PrestaShop way (theme `mails/` folder).

## Project structure

```
m4p_askproductfree/
├── m4p_askproductfree.php     # main module class (hooks, configuration)
├── classes/                   # helper classes
├── controllers/front/ajax.php # AJAX endpoint sending the e-mail
├── mails/{pl,en}/             # e-mail templates
├── translations/              # module translations
└── views/
    ├── css/  js/              # front assets (loaded only on product page)
    └── templates/
        ├── hook/askproduct.tpl    # button + form modal
        └── admin/                 # back-office templates
```

## PRO version

The [PRO version](https://modules4presta.io) additionally offers, among others, saving inquiries in the database and managing them from the back office.

## License

All rights reserved — © [Modules4Presta.io](https://modules4presta.io). See the license header in the source files.

---

## 🇵🇱 Wersja polska

Moduł PrestaShop dodający na stronie produktu przycisk **„Zapytaj o produkt"** z formularzem kontaktowym. Klient może szybko wysłać pytanie o konkretny produkt bezpośrednio na adres e-mail sklepu — przydatne zwłaszcza przy produktach niedostępnych lub wycenianych indywidualnie.

### Funkcje

- Przycisk „Zapytaj o produkt" na stronie produktu (hook `displayProductAdditionalInfo`)
- Formularz w oknie modalnym (fancybox) z polami:
  - e-mail (automatycznie uzupełniany dla zalogowanych klientów)
  - treść pytania
  - numer telefonu *(opcjonalnie — włączane w konfiguracji)*
  - nazwa firmy *(opcjonalnie — włączane w konfiguracji)*
- Zapytanie trafia na adres sklepu (`PS_SHOP_EMAIL`), a adres klienta ustawiany jest jako **Reply-To** — odpowiadasz jednym kliknięciem
- Szablony e-mail po polsku i angielsku (HTML + tekst)
- Walidacja wszystkich pól po stronie serwera oraz escapowanie danych przed wstawieniem do maila
- Zasoby JS/CSS ładowane **tylko** na stronie produktu i tylko przy włączonym module

### Instalacja

1. Pobierz `m4p_askproductfree.zip` z [najnowszego wydania](https://github.com/modules4presta/m4p_askproductfree/releases/latest).
2. W panelu administracyjnym przejdź do **Moduły → Menedżer modułów → Załaduj moduł** i wgraj plik ZIP.
3. Moduł zainstaluje się i włączy automatycznie.

### Konfiguracja

**Moduły → Menedżer modułów → Ask about product FREE → Konfiguruj**

| Opcja | Opis | Domyślnie |
|---|---|---|
| Aktywacja modułu | Włącza/wyłącza przycisk i formularz na stronie produktu | Wł. |
| Pole numeru telefonu | Dodaje opcjonalne pole telefonu do formularza | Wył. |
| Pole nazwy firmy | Dodaje opcjonalne pole firmy do formularza | Wył. |

### Wymagania

- PrestaShop 1.7.x – 8.1.x
- PHP 7.3+

### Wersja PRO

[Wersja PRO](https://modules4presta.io) oferuje dodatkowo m.in. zapisywanie zapytań w bazie danych i zarządzanie nimi z poziomu panelu administracyjnego.
