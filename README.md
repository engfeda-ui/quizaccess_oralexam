# 🔒 Moodle Quiz Access Rule: Oral & Practical Exam Mode (`quizaccess_oralexam`)

[![Moodle Compatibility](https://img.shields.io/badge/Moodle-4.0%20to%205.2%2B-orange.svg?style=flat-square)](https://moodle.org)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%20%7C%208.2%20%7C%208.3-blue.svg?style=flat-square)](https://php.net)
[![Database](https://img.shields.io/badge/Database-PostgreSQL%20%7C%20MySQL%20%7C%20MariaDB-purple.svg?style=flat-square)](https://docs.moodle.org)
[![License](https://img.shields.io/badge/License-GPL%20v3-green.svg?style=flat-square)](http://www.gnu.org/copyleft/gpl.html)
[![Version](https://img.shields.io/badge/Version-v1.0.1-blue.svg?style=flat-square)](https://github.com/engfeda-ui/quizaccess_oralexam)

A professional Moodle quiz access rule plugin designed for **in-person Oral, OSCE, and Practical Examinations (Workshops & Labs)**. It restricts students from attempting the exam on their own while providing teachers and examiners full control to grade candidates face-to-face via the companion plugin [`quiz_oralexam`](https://github.com/engfeda-ui/quiz_oralexam).

---

## ✨ Features

- **🚫 Student Self-Attempt Restriction:** Completely hides and disables the "Attempt quiz now" button for students when the quiz is flagged as an oral or practical examination.
- **📢 Clear Examiner Notice:** Displays a styled, informative alert message informing students that this exam is assessed live and in-person by an authorized examiner.
- **🔒 Anti-Tampering Auto-Lock:** Automatically freezes and permanently locks the Oral Exam mode in the Quiz settings once student evaluations and attempts are recorded in the database, preventing accidental conversion back to standard quizzes.
- **🛡️ Enterprise-Ready Integrations:**
  - **Security Companion:** Enforces mutual dependency on [`quiz_oralexam`](https://github.com/engfeda-ui/quiz_oralexam) to ensure an active live examiner station is always available.
  - **GDPR Privacy Compliance:** Implements Moodle's Privacy Subsystem (`null_provider`) adhering to GDPR regulations.
  - **Localization Support:** Full bilingual English and Arabic (`ar`) language packs included.
  - **CI/CD Ready:** Automated GitHub Actions workflows using `moodle-plugin-ci`.

---

## 📋 Requirements

| Dependency | Required Version / Compatibility |
| :--- | :--- |
| **Moodle Framework** | Moodle 4.0 to 5.2+ (Tested against Moodle 4.5/5.0+ stable branches) |
| **PHP Runtime** | PHP 8.1, PHP 8.2, PHP 8.3 |
| **Database System** | PostgreSQL 13+, MySQL 8.0+, or MariaDB 10.5+ |
| **Required Sub-Plugin** | [`quiz_oralexam`](https://github.com/engfeda-ui/quiz_oralexam) |

---

## 🚀 Installation

1. **Download & Extract:** Download the repository source.
2. **Directory Placement:** Copy the `oralexam` folder into your Moodle quiz access rules directory:
   ```bash
   moodle/mod/quiz/accessrule/oralexam
   ```
3. **Install Companion Report Plugin:** Ensure [`quiz_oralexam`](https://github.com/engfeda-ui/quiz_oralexam) is installed into:
   ```bash
   moodle/mod/quiz/report/oralexam
   ```
4. **Run Moodle Upgrade:** Log in as Administrator and navigate to **Site administration > Notifications** to trigger the database installation.
5. **Alternative Install:** Upload the ZIP via **Site administration > Plugins > Install plugins**.

---

## 🛠️ Usage & Configuration

1. Navigate to your course and open a **Quiz** (or create a new one).
2. Go to **Quiz Settings > Extra restrictions on attempts**.
3. Under **Oral / Practical Examination Mode**:
   - Set **Enable Oral / Practical Exam Mode** to **Yes**.
4. Save the quiz settings. Students will now see an examiner instructions notice and cannot launch attempts on their own.
5. Once any evaluation is completed by examiners, this setting is automatically **frozen and locked** to protect assessment integrity.

---

## 📋 Changelog

### v1.0.1 (2026-09-08)
- **Auto-Lock Safeguard:** Added automatic freezing of the Oral Exam toggle in Quiz settings once evaluations exist.
- **Mutual Dependency:** Added formal requirement for `quiz_oralexam` in `version.php`.

### v1.0.0 (2026-09-07)
- **Initial Release:** Core access rule implementation blocking student self-attempts.

---

## 📜 License

Licensed under the [GNU General Public License, Version 3](http://www.gnu.org/copyleft/gpl.html).
