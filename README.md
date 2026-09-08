# ?? Moodle Quiz Access Rule Plugin: Oral & Practical Exam Mode (`quizaccess_oralexam`)

[![Moodle Compatibility](https://img.shields.io/badge/Moodle-4.0%20to%205.2%2B-orange.svg?style=flat-square)](https://moodle.org)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%20%7C%208.2%20%7C%208.3-blue.svg?style=flat-square)](https://php.net)
[![License](https://img.shields.io/badge/License-GPL%20v3-green.svg?style=flat-square)](http://www.gnu.org/copyleft/gpl.html)
[![Version](https://img.shields.io/badge/Version-v1.0.1-blue.svg?style=flat-square)](https://github.com/engfeda-ui/quizaccess_oralexam)

A specialized Moodle Quiz Access Rule sub-plugin designed for **in-person Oral, OSCE, and Practical Examinations (Workshops & Labs)**. It restricts students from attempting the exam on their own while providing teachers and examiners full control to grade candidates face-to-face via the companion plugin [`quiz_oralexam`](https://github.com/engfeda-ui/quiz_oralexam).

---

## ? Key Features

- **?? Student Self-Attempt Restriction:** Completely hides and disables the "Attempt quiz now" button for students when the quiz is flagged as an oral or practical examination.
- **?? Clear Examiner Notice:** Displays a styled, informative alert message informing students that this exam is assessed live and in-person by an authorized examiner.
- **?? Anti-Tampering Auto-Lock:** Automatically freezes and permanently locks the Oral Exam mode in the Quiz settings once student evaluations and attempts are recorded in the database, preventing accidental conversion back to standard quizzes.
- **?? Tight Integration with `quiz_oralexam`:** Acts as the required security companion for the Oral Examination Report station (`quiz_oralexam`).

---

## ?? Requirements

- **Moodle:** 4.0 to 5.2+
- **PHP:** 8.1, 8.2, or 8.3
- **Companion Plugin:** [`quiz_oralexam`](https://github.com/engfeda-ui/quiz_oralexam) (Quiz Report sub-plugin)

---

## ?? Installation

1. Download or clone this repository into:
   ```bash
   mod/quiz/accessrule/oralexam
   ```
2. Make sure [`quiz_oralexam`](https://github.com/engfeda-ui/quiz_oralexam) is also installed into:
   ```bash
   mod/quiz/report/oralexam
   ```
3. Visit **Site administration > Notifications** to complete database upgrade.

---

## ?? Changelog

### v1.0.1 (2026-09-08)
- **Auto-Lock Safeguard:** Added automatic freezing of the Oral Exam toggle in Quiz settings once evaluations exist.
- **Mutual Dependency:** Added formal requirement for `quiz_oralexam` in `version.php`.

### v1.0.0 (2026-09-07)
- **Initial Release:** Core access rule implementation blocking student self-attempts.

---

## ?? License

Licensed under the [GNU General Public License, Version 3](http://www.gnu.org/copyleft/gpl.html).
