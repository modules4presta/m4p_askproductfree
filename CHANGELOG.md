# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and this project
adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.0] - 2026-09-28

### Removed

- A cURL call to modules4presta.io made on every visit to the module configuration, which fetched
  advertisements to display in the back office. A module has no business calling home from someone
  else's shop.
- The advertisement panel and the "check the PRO version" link that came with it.
- A server requirements panel that checked for the ionCube Loader — an encoder runtime this module
  never needed and an open one never will.
- The link to the paid version embedded in the module description.

### Changed

- The modal no longer needs fancybox or jQuery: it is plain markup with its own overlay, closes with
  the button, the overlay or Escape, and reports success and errors in the dialog instead of a
  browser `alert()`.
- Released under the MIT license, with English and Polish catalogues and the standard documentation.
- Compatibility declared against the installed PrestaShop instead of stopping at 8.1.99.

## [1.0.7] - earlier

### Added

- An "ask about this product" button on the product page, a modal with e-mail, optional phone and
  company fields, and an e-mail to the shop with the question and a link to the product.
