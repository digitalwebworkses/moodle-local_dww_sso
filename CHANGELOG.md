# Changelog

All notable changes to DWW Moodle SSO will be documented in this file.

This project follows a pragmatic release process during alpha development.

---

## [1.0.0-rc3] - 2026-07-14

### Fixed

- Removed accidental backtick characters from `status.php`.
- Fixed the PHP syntax error detected by the Moodle Plugin CI check.
- Added the standard Moodle boilerplate header to the remaining flagged source files.
- Added explicit copyright and GPL license markers where required.
- Prepared the package for a new Moodle.org review submission.


---

# 1.0.0-rc2 - 2026-07-09

## Fixed

- Added Moodle Privacy API implementation.
- Documented external API communication.
- Replaced custom filesystem logging with Moodle-compliant mechanisms.
- Added standard Moodle GPL boilerplate headers.
- Internationalized remaining user-facing strings.
- Renamed repository to match Moodle component conventions.

---

# DWW Moodle SSO v1.0.0-rc1

First Release Candidate of DWW Moodle SSO.

DWW Moodle SSO is the official Moodle companion plugin for DWW Moodle Bridge. It enables Single Sign-On integration between WordPress/WooCommerce and Moodle, allowing students to access Moodle courses through a controlled WordPress-based purchase and enrolment flow.

## Added

- Single Sign-On endpoint for Moodle access from WordPress.
- Integration with DWW Moodle Bridge.
- Secure token-based login flow.
- Moodle-side configuration page.
- Setup assistant for initial configuration.
- Diagnostics page for checking plugin status.
- Security checks for integration requests.
- Logging support for SSO events.
- English and Spanish language strings.
- Moodle Web Service integration support.

## Improved

- Validation of Moodle plugin configuration.
- Diagnostics and status visibility.
- Installation and setup documentation.
- Compatibility with Moodle 4.4, 4.5 and 5.0.
- Release metadata for public distribution.

## Security

- Token-based access validation.
- Protection against direct unauthorized access.
- Server-side checks before authenticating users.
- Separation between public Moodle plugin and private license infrastructure.

## Tested with

- Moodle 4.4
- Moodle 4.5
- Moodle 5.0
- PHP 8.0+
- DWW Moodle Bridge v1.0.0-rc1
- DWW License Server v1.0.0-rc1

## Notes

This is a Release Candidate intended for controlled production validation.

If no critical issues are detected during the validation period, this version will evolve into the first stable 1.0.0 release.

---

## [1.1.1-alpha] - 2026-05-29

### Added

- Automatic Moodle Web Service registration through `db/services.php`.
- Automatic creation of `DWW Moodle Bridge Service`.
- Required Moodle API functions are now provisioned during plugin installation or upgrade.
- Setup Wizard contextual help for Moodle Web Service configuration.
- Warning about tokens created from incorrect Moodle services.
- Documentation updates for authorised users and token generation.
- Spanish and English installation documentation structure.
- Improved README documentation links.
- `INSTALL.md` and `INSTALL.es.md` support.

### Improved

- Setup Wizard onboarding flow.
- Moodle Web Service setup clarity.
- Token generation instructions.
- Troubleshooting documentation for `webservice_access_exception`.
- Troubleshooting documentation for SSL/cURL certificate issues.
- Security posture by keeping the generated service restricted to authorised users.

### Security

- Moodle Web Service is intentionally created as restricted to authorised users.
- The token must be generated specifically for `DWW Moodle Bridge Service`.
- Reduced risk of accidental token generation against incorrect or overly broad services.

---

## [1.1.0-alpha] - 2026-05-29

### Added

- WordPress URL setting in Moodle plugin configuration.
- Moodle Setup Wizard WordPress validation.
- Cross-platform validation between Moodle and WordPress.
- WordPress health endpoint validation support.
- Setup readiness score.
- Visual status badges.
- Copy buttons for Moodle connection values.
- Improved diagnostics and security visual feedback.

### Improved

- Setup Wizard UX.
- Moodle admin navigation.
- WordPress connection visibility.
- Installer-style onboarding flow.

---

## [1.0.8-alpha] - 2026-05-28

### Added

- Initial alpha release of the Moodle SSO companion plugin.
- Secure SSO login endpoint.
- HMAC SHA-256 token validation.
- Expiring SSO token support.
- Nonce replay protection.
- Moodle user validation.
- Moodle course validation.
- Active enrolment validation.
- Safe return URL validation.
- Moodle-side logging.
- Diagnostics page.
- Security page.
- Status page.
- Logs page.

### Security

- Shared secret validation.
- Token signature verification using `hash_equals`.
- Protection against token reuse.
- Protection against unsafe return URLs.

---

## [1.0.0] - Initial internal version

### Added

- Initial Moodle SSO proof of concept.
- Basic shared-secret SSO flow.
- WordPress companion compatibility.