# ⚡ Electricity Customer Management System

### نظام إدارة المشتركين وخدمات الكهرباء

A web-based system developed to manage electricity customers, meters, invoices, payments, consumption records, and related operations for a private electricity service company.

نظام ويب تم تطويره لإدارة المشتركين وخدمات الكهرباء، والفواتير والمدفوعات وبيانات العدادات والاستهلاك والعمليات المرتبطة بها.

> **Project started in 2018 and was uploaded to GitHub in 2019.**
> The version available in this repository is an older version of the system. The system was later developed and expanded significantly beyond this version.

> **بدأ تطوير المشروع في عام 2018 وتم رفعه إلى GitHub في عام 2019.**
> النسخة الموجودة في هذا المستودع هي نسخة قديمة من النظام، حيث تم تطوير النظام وتوسيعه بشكل كبير بعد ذلك.

---

## 📌 About the Project | عن المشروع

The system was developed for a private electricity service company to help manage a large number of customers and organize their electricity subscriptions, invoices, payments, meter points, and consumption information.

تم تطوير النظام لشركة خاصة تعمل في خدمات الكهرباء، بهدف تسهيل إدارة عدد كبير من المشتركين وتنظيم اشتراكاتهم وفواتيرهم ومدفوعاتهم وبيانات العدادات والاستهلاك.

The system also includes tools for monitoring electricity consumption between the main electricity meter and its connected customers. This helps identify differences in consumption that may indicate possible electricity losses or unauthorized usage.

كما يحتوي النظام على أدوات لمتابعة ومطابقة استهلاك الكهرباء بين العداد الرئيسي والمشتركين المرتبطين به، مما يساعد على اكتشاف الفروقات في الاستهلاك والتي قد تشير إلى وجود فقد أو استخدام غير مصرح به للكهرباء.

---

## ✨ Main Features | أهم المميزات

### 👥 Customer Management | إدارة المشتركين

* Add and manage customers.

* Store customer information.

* Search and filter customers.

* Manage customer subscriptions.

* View customer invoices and payment history.

* Track outstanding amounts and customer balances.

* إضافة وإدارة المشتركين.

* حفظ بيانات المشتركين.

* البحث والفلترة.

* إدارة اشتراكات المشتركين.

* عرض فواتير ومدفوعات العميل.

* متابعة المبالغ المتبقية والمديونيات.

---

### ⚡ Electricity Meter Management | إدارة عدادات الكهرباء

The system supports managing main electricity meters and the customers connected to them.

يدعم النظام إدارة العدادات الرئيسية والمشتركين المرتبطين بها.

A single main meter can provide electricity to many customers. The system records the related consumption information and uses it to compare the main meter readings with the consumption recorded for its customers.

يمكن أن يكون العداد الرئيسي مرتبطًا بعدد كبير من المشتركين، ويقوم النظام بتسجيل بيانات الاستهلاك ومقارنتها بين قراءة العداد الرئيسي واستهلاك المشتركين المرتبطين به.

This comparison can help identify unusual differences that may indicate electricity losses or possible unauthorized usage.

تساعد هذه المطابقة في اكتشاف الفروقات غير الطبيعية في الاستهلاك والتي قد تشير إلى وجود فقد أو استخدام غير مصرح به للكهرباء.

---

### 🧾 Invoices | الفواتير

* Create and manage customer invoices.

* Record invoice details.

* Track invoice balances.

* Connect invoices with customer payments.

* View and print invoices.

* Quickly add new invoices.

* إنشاء وإدارة الفواتير.

* تسجيل تفاصيل الفواتير.

* متابعة المبالغ المستحقة.

* ربط الفواتير بمدفوعات العملاء.

* عرض وطباعة الفواتير.

* إضافة الفواتير بسرعة.

---

### 💰 Payments | المدفوعات

The system provides tools for recording and managing customer payments.

يوفر النظام أدوات لتسجيل وإدارة مدفوعات المشتركين.

* Record payments.
* View payment history.
* Track remaining balances.
* Quickly add payments.
* Connect payments with customer invoices.

---

### 📊 Reports & Statements | التقارير والكشوفات

The system provides different reports and customer statements to help with daily management and follow-up.

يحتوي النظام على مجموعة من التقارير والكشوفات التي تساعد في إدارة ومتابعة المشتركين.

Examples include:

* Customer statements
* Invoice reports
* Payment reports
* Customer balances
* Consumption information
* Electricity meter information
* Other management reports

ومنها:

* كشوفات العملاء.
* تقارير الفواتير.
* تقارير المدفوعات.
* المديونيات والأرصدة.
* بيانات الاستهلاك.
* بيانات العدادات.
* تقارير إدارية أخرى.

---

### 🖨️ Printing | الطباعة

Printing was an important part of the system, with dedicated printable pages for different types of documents.

تم الاهتمام بشكل خاص بعملية الطباعة، حيث يحتوي النظام على صفحات مخصصة لطباعة أنواع مختلفة من المستندات.

* Invoices

* Customer statements

* Reports

* Payment information

* Quick statements

* الفواتير.

* كشوفات العملاء.

* التقارير.

* بيانات المدفوعات.

* الكشوفات السريعة.

---

### 🚀 Quick Actions | العمليات السريعة

Several features were added to make common daily tasks faster for users.

تمت إضافة مجموعة من الخصائص لتسهيل العمليات اليومية المتكررة وتسريع استخدامها.

Examples:

* Quick payment entry.
* Quick invoice entry.
* Quick customer statements.
* Fast access to frequently used operations.

---

## 👤 User Management | إدارة المستخدمين

The system supports multiple users.

Each user's data is separated using a `user_id`, allowing users to manage their own customers, invoices, and related records within the same database.

يدعم النظام استخدام أكثر من مستخدم، ويتم فصل بيانات كل مستخدم باستخدام `user_id` بحيث تكون بيانات المشتركين والفواتير والمدفوعات مرتبطة بالمستخدم الخاص بها داخل قاعدة البيانات نفسها.

---

## 🔐 User Permissions | صلاحيات المستخدمين

The system includes different levels of access.

يوفر النظام أكثر من مستوى للصلاحيات، بحيث يمكن تحديد ما يمكن للمستخدم الوصول إليه داخل النظام.

The available roles in the original system include:

* Full access user
* Read-only user with limited access to system data and invoices

وتشمل العضويات في النسخة الأصلية:

* مستخدم بصلاحيات كاملة.
* مستخدم للقراءة فقط بصلاحيات محدودة على بيانات النظام والفواتير.

---

## ⚙️ Settings | الإعدادات

The system includes a settings section for configuring different parts of the application according to the company's requirements.

يحتوي النظام على قسم خاص بالإعدادات لتهيئة أجزاء مختلفة من النظام بما يتناسب مع احتياجات الشركة.

---

## 🔎 Search & Filtering | البحث والفلترة

The system provides search and filtering options to make it easier to find customers, invoices, payments, and other records.

يوفر النظام خصائص للبحث والفلترة للوصول إلى المشتركين والفواتير والمدفوعات والبيانات المختلفة بسهولة.

---

## 🛠️ Technologies | التقنيات المستخدمة

* HTML
* CSS
* JavaScript
* PHP
* MySQL
* AJAX
* Bootstrap 3

---

## 📅 Project History | تاريخ المشروع

* **2018** — Initial development of the system.
* **2019** — The project was uploaded to GitHub.
* **Later** — The system was significantly expanded and developed for the company's requirements.

### تاريخ المشروع

* **2018** — بداية تطوير النظام.
* **2019** — رفع المشروع إلى GitHub.
* **لاحقًا** — تم تطوير النظام وتوسيعه بشكل كبير ليتناسب مع احتياجات الشركة.

The code in this repository represents an earlier stage of the project and does not represent the latest version of the system.

الكود الموجود في هذا المستودع يمثل مرحلة سابقة من المشروع ولا يمثل النسخة الأخيرة من النظام.

---

## 🎯 Project Purpose | هدف المشروع

The main goal of the system was to organize electricity customer management and simplify the daily operations of the company, including customer management, billing, payments, consumption tracking, reporting, and printing.

الهدف الأساسي من النظام هو تنظيم إدارة المشتركين وتسهيل العمليات اليومية للشركة، بما في ذلك إدارة العملاء والفواتير والمدفوعات ومتابعة الاستهلاك والتقارير والطباعة.

---

## 📄 Note | ملاحظة

This repository contains an older version of a real-world project developed for a private company.

هذا المستودع يحتوي على نسخة قديمة من مشروع حقيقي تم تطويره لشركة خاصة.

The system continued to evolve after this version and received many additional changes and improvements based on the company's needs.

استمر تطوير النظام بعد هذه النسخة، وتمت إضافة العديد من التعديلات والتحسينات بناءً على احتياجات الشركة.


## 🚀 Installation | التثبيت والتشغيل

### 1. Create the Database | إنشاء قاعدة البيانات

Create a new MySQL database with the following name:

قم بإنشاء قاعدة بيانات جديدة في MySQL باسم:

```text
systempower
```

Then import the provided SQL database file into the newly created database.

بعد ذلك قم باستيراد ملف قاعدة البيانات `SQL` الموجود مع المشروع إلى قاعدة البيانات.

---

### 2. Database Connection | إعداد الاتصال بقاعدة البيانات

Open the following file:

افتح الملف:

```text
connect.php
```

Then update the database connection information according to your local environment:

ثم قم بتعديل بيانات الاتصال بقاعدة البيانات حسب إعدادات جهازك:

```php
$dsn = 'mysql:host=localhost;dbname=systempower';

$user = 'root';

$pass = '';
```

For example, if your MySQL username or password is different, change `$user` and `$pass` accordingly.

إذا كان اسم المستخدم أو كلمة مرور MySQL مختلفة لديك، قم بتعديل المتغيرين `$user` و`$pass` بما يتناسب مع إعداداتك.

---

### 3. Run the Project | تشغيل المشروع

Place the project inside your local server directory, such as:

ضع المشروع داخل مجلد السيرفر المحلي مثل:

```text
htdocs
```

For example, when using XAMPP:

في حالة استخدام XAMPP مثلًا:

```text
C:\xampp\htdocs\systemEle
```

Start **Apache** and **MySQL** from XAMPP, then open the project from your browser.

قم بتشغيل **Apache** و **MySQL** من XAMPP، ثم افتح المشروع من المتصفح.

---

### 4. Default Login | بيانات الدخول الافتراضية

The project contains sample data for testing. The login credentials are not real and are included only for demonstration purposes.

يحتوي المشروع على بيانات افتراضية للتجربة، وبيانات الدخول التالية غير حقيقية وموجودة فقط لأغراض تجربة النظام.

**Username | اسم المستخدم**

```text
main
```

**Password | كلمة المرور**

```text
123
```

> ⚠️ These are sample credentials for the old version of the project. Change them if you use the system for actual work.

> ⚠️ بيانات الدخول أعلاه افتراضية للنسخة القديمة من المشروع، ويُنصح بتغييرها عند استخدام النظام بشكل فعلي.
