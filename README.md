# DWW Moodle SSO

![Version](https://img.shields.io/badge/version-1.1.1--alpha-green)
![Moodle](https://img.shields.io/badge/Moodle-4.x-orange)
![PHP](https://img.shields.io/badge/PHP-8.x-blue)

Secure Single Sign-On and Moodle integration companion plugin for DWW Moodle Bridge.

DWW Moodle SSO works together with the DWW Moodle Bridge WordPress plugin to provide secure authentication, automatic user provisioning and WooCommerce ↔ Moodle course access management.

---

# Documentation

## English

- [Installation Guide](INSTALL.md)

## Español

- [Guía de instalación](INSTALL.es.md)

---

# Features

- Secure Single Sign-On (SSO)
- Shared-secret authentication
- HMAC SHA-256 validation
- Automatic Moodle login
- Direct course access
- Moodle-side logging
- Setup Wizard
- WordPress connectivity validation
- Automatic Moodle Web Service registration
- Automatic REST service provisioning
- Secure token-based API integration
- WooCommerce integration support

---

# Requirements

- Moodle 4.x
- PHP 8.x
- HTTPS enabled
- Valid SSL certificate chain

---

# Quick Installation

## 1. Install plugin

Upload the plugin into:

```text
/local/dww_sso
```

or install using:

```text
Site administration
→ Plugins
→ Install plugins
```

---

## 2. Configure plugin

Go to:

```text
Site administration
→ Plugins
→ Local plugins
→ DWW SSO
```

Configure:

- Shared SSO secret
- WordPress URL

---

## 3. Run Setup Wizard

Open:

```text
Site administration
→ Plugins
→ Local plugins
→ DWW SSO
→ Setup Wizard
```

The wizard validates:

- Shared secret
- Endpoint availability
- WordPress connectivity
- WooCommerce availability
- Moodle API configuration
- SSO configuration

---

# Moodle Web Service

DWW Moodle SSO automatically creates:

```text
DWW Moodle Bridge Service
```

during plugin installation or upgrade.

This service includes all required Moodle API functions.

---

# IMPORTANT — Authorised Users

The service is intentionally created as:

```text
Restricted users only
```

for security reasons.

Before generating tokens:

```text
Site administration
→ Server
→ Web services
→ External services
→ DWW Moodle Bridge Service
→ Authorised users
```

Add the user that will be used by WordPress.

---

# Generate Moodle Token

Go to:

```text
Site administration
→ Server
→ Web services
→ Manage tokens
```

Generate a token using:

```text
Service:
DWW Moodle Bridge Service
```

Copy the generated token into the WordPress plugin settings.

---

# WordPress Companion Plugin

This plugin is designed to work together with:

```text
DWW Moodle Bridge for WordPress/WooCommerce
```

---

# Security Features

- HMAC SHA-256 signatures
- Shared secret validation
- Expiring SSO tokens
- Nonce replay protection
- Secure return URL validation
- Restricted web service users
- Moodle enrolment validation

---

# Troubleshooting

## webservice_access_exception

Usually caused by:

- token created from another Moodle service
- unauthorised user
- missing authorised user assignment

Solution:

- use ONLY:

```text
DWW Moodle Bridge Service
```

- verify authorised users
- generate a new token

---

## cURL error 60

Usually caused by:

- invalid SSL certificate chain
- missing intermediate certificates

Verify:

```bash
openssl s_client -connect yourdomain.com:443 -servername yourdomain.com
```

Verification should return:

```text
Verify return code: 0 (ok)
```

---

# Development Status

Current status:

```text
Alpha
```

The plugin is under active development and testing in real production environments.

---

# Changelog

See:

- [CHANGELOG.md](CHANGELOG.md)

---

# License

GPL v2 or later