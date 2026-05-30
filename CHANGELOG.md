# Changelog

All notable changes to DWW Moodle SSO will be documented in this file.

This project follows a pragmatic release process during alpha development.

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