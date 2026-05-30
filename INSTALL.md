# DWW Moodle Bridge — Installation Guide

Version: 1.1.1-alpha

---

# IMPORTANT

This guide is intentionally written as a strict step-by-step installation document.

Do NOT skip steps.  
Do NOT improvise.  
Do NOT replace values with “similar” values.

Most installation problems happen because:
- incorrect Moodle services,
- invalid SSL certificates,
- wrong URLs,
- wrong tokens,
- or broken Moodle configurations.

Follow this guide exactly.

---

# SYSTEM REQUIREMENTS

## WordPress

Required:

- WordPress 6.x
- WooCommerce
- PHP 8.x
- HTTPS enabled

---

## Moodle

Required:

- Moodle 4.x
- PHP 8.x
- HTTPS enabled
- Valid SSL certificate chain

---

# BEFORE STARTING

You need:

## WordPress side

- Administrator access
- WooCommerce installed
- DWW Moodle Bridge plugin ZIP

---

## Moodle side

- Site administrator access
- DWW Moodle SSO plugin ZIP

---

# STEP 1 — INSTALL MOODLE PLUGIN

In Moodle:

```text
Site administration
→ Plugins
→ Install plugins
```

Upload:

```text
dww_sso-x.x.x.zip
```

Complete installation.

---

# STEP 2 — CONFIGURE MOODLE PLUGIN

Go to:

```text
Site administration
→ Plugins
→ Local plugins
→ DWW SSO
```

Configure:

## Shared secret

Generate a LONG random value.

Example:

```text
8f2d7f9e7d3e4c6a9f7e2b1c4d5a6f7e
```

Save it.

IMPORTANT:  
The same value MUST be used later in WordPress.

---

## WordPress URL

Example:

```text
https://yourdomain.com
```

Save changes.

---

# STEP 3 — VERIFY MOODLE SETUP

Open:

```text
Site administration
→ Plugins
→ Local plugins
→ DWW SSO
→ Setup Wizard
```

Verify:

- readiness percentage
- endpoint availability
- WordPress validation
- Moodle information

The setup wizard should NOT show critical errors.

---

# STEP 4 — VERIFY MOODLE WEB SERVICE

The plugin automatically creates:

```text
DWW Moodle Bridge Service
```

Go to:

```text
Site administration
→ Server
→ Web services
→ External services
```

Verify the service exists.

---

# STEP 5 — AUTHORISE USER

IMPORTANT:  
The service is intentionally restricted for security reasons.

Go to:

```text
Site administration
→ Server
→ Web services
→ External services
→ DWW Moodle Bridge Service
→ Authorised users
```

Add the Moodle administrator or technical integration user.

Without this step:
tokens WILL fail.

---

# STEP 6 — GENERATE TOKEN

Go to:

```text
Site administration
→ Server
→ Web services
→ Manage tokens
```

Create token using:

## User

The authorised user added previously.

---

## Service

IMPORTANT:

You MUST select:

```text
DWW Moodle Bridge Service
```

Do NOT use:
- custom services
- old services
- manually created services

Copy the generated token.

---

# STEP 7 — VERIFY MANUAL ENROLMENTS

Go to:

```text
Site administration
→ Plugins
→ Enrolments
→ Manage enrol plugins
```

Verify:

```text
Manual enrolments = ENABLED
```

---

# STEP 8 — VERIFY COURSE ENROLMENT METHOD

Open the Moodle course.

Go to:

```text
Course
→ Participants
→ Enrolment methods
```

Verify:

```text
Manual enrolments
```

exists and is enabled.

Without this:
automatic enrolment WILL fail.

---

# STEP 9 — INSTALL WORDPRESS PLUGIN

In WordPress:

```text
Plugins
→ Add new
→ Upload plugin
```

Upload:

```text
dww-moodle-bridge-x.x.x.zip
```

Activate plugin.

---

# STEP 10 — CONFIGURE WORDPRESS PLUGIN

Go to:

```text
DWW Moodle Bridge
→ Settings
```

Configure:

---

## Moodle URL

Example:

```text
https://yourdomain.com/moodle
```

IMPORTANT:  
Use the PUBLIC HTTPS URL.

Do NOT use:
- localhost
- docker hostnames
- internal IPs

---

## Moodle Token

Paste the token generated previously.

---

## Shared Secret

Paste EXACTLY the same secret configured in Moodle.

---

# STEP 11 — VERIFY CONNECTION

Open:

```text
DWW Moodle Bridge
→ Health
```

Verify:

- Moodle API configured
- SSO configured
- REST API reachable

No critical errors should appear.

---

# STEP 12 — CREATE COURSE PRODUCT

Create WooCommerce product.

Assign:

- Moodle course
- access duration
- integration enabled

Save product.

---

# STEP 13 — TEST MANUAL ORDER

Recommended first test:

```text
WooCommerce
→ Orders
→ Add order
```

Create manual order using:
- test user
- Moodle product

Change order status to:

```text
Processing
```

or:

```text
Completed
```

---

# EXPECTED RESULT

The plugin should:

- create Moodle user
- enrol user
- create access expiration
- generate logs
- allow SSO access

---

# TEST REVOCATION

Cancel the order.

Expected result:

- Moodle unenrolment
- access revocation
- logs updated

---

# TROUBLESHOOTING

---

## ERROR

```text
webservice_access_exception
```

Usually caused by:

- wrong service selected
- unauthorised Moodle user
- invalid token

Fix:

- regenerate token
- verify authorised users
- use ONLY:

```text
DWW Moodle Bridge Service
```

---

## ERROR

```text
cURL error 60
```

Usually caused by:

- invalid SSL chain
- missing intermediate certificates

Verify SSL using:

```bash
openssl s_client -connect yourdomain.com:443 -servername yourdomain.com
```

Verification must return:

```text
Verify return code: 0 (ok)
```

---

## ERROR

```text
Manual enrolments plugin does not exist or is disabled
```

Fix:

Enable:

```text
Manual enrolments
```

globally and inside the course.

---

# SUPPORT

DWW Moodle Bridge assumes:
- valid SSL setup
- functional Moodle installation
- standard WooCommerce installation

Broken infrastructures, heavily modified Moodle installations or invalid SSL setups may require technical intervention.

---

# DEVELOPMENT STATUS

Current status:

```text
Alpha
```

Core functionality is operational and validated in real environments.

Further improvements and fixes are distributed to all active customers.

---

# LICENSE

GPL v2 or later