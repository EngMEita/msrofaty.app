# مصروفاتي - تطبيق إدارة المصروفات الشخصية

تطبيق ويب متقدم لإدارة المصروفات الشخصية والميزانيات، مبني بـ Laravel 8.

## المميزات الرئيسية

- ✅ **إدارة الحسابات البنكية** - تابع أرصدتك المختلفة
- ✅ **تسجيل المعاملات** - سجل الإيداعات والسحوبات بسهولة
- ✅ **تصنيفات مرنة** - نظام تصنيفات متسلسل (رئيسي وفرعي)
- ✅ **الميزانيات** - ضع حدود مالية واتبع إنفاقك
- ✅ **التقارير الشهرية** - اعرض ملخصات إنفاقك
- ✅ **الأمان** - التحقق من الملكية على جميع البيانات
- ✅ **Pagination** - عرض آمن وفعال للبيانات

## البنية الأساسية

```
app/
├── Models/           # نماذج البيانات (User, Entry, Record, Budget, etc.)
├── Http/
│   ├── Controllers/  # معالجات الطلبات
│   ├── Requests/     # التحقق من صحة المدخلات
│   └── Middleware/   # البرامج الوسيطة
├── Policies/         # سياسات التفويض والأمان
└── Providers/        # مزودي الخدمات

database/
├── migrations/       # هجرات قاعدة البيانات
├── factories/        # مصانع البيانات للاختبارات
└── seeders/          # بذور البيانات

routes/
├── web.php           # المسارات الرئيسية
├── acp.php           # مسارات لوحة التحكم
└── auth.php          # مسارات المصادقة

tests/
├── Unit/             # اختبارات الوحدات
└── Feature/          # اختبارات الميزات
```

## العلاقات بين البيانات

```
User (المستخدم)
├── hasMany -> Entry (المعاملات)
├── hasMany -> Budget (الميزانيات)
│   └── belongsToMany -> Category (التصنيفات)
└── Policies (سياسات التفويض)

Entry (المعاملة)
├── belongsTo -> User
├── hasMany -> Record (السجلات)
├── attribute: status (متوازن أم لا؟)
├── attribute: deposit (إجمالي الإيداعات)
└── attribute: withdraw (إجمالي السحوبات)

Record (السجل)
├── belongsTo -> Entry
├── belongsTo -> Account (الحساب)
├── belongsTo -> Category (التصنيف)
├── attribute: type (1 = إيداع، -1 = سحب)
└── attribute: value (المبلغ)

Account (الحساب)
├── hasMany -> Record
└── attribute: balance (الرصيد المحسوب)

Category (التصنيف)
├── hasMany -> Record
├── hasMany -> subcategories (تصنيفات فرعية)
├── belongsTo -> parentCategory (التصنيف الأب)
└── belongsToMany -> Budget

Budget (الميزانية)
├── belongsTo -> User
└── belongsToMany -> Category
```

## التطبيق

### متطلبات التشغيل

- PHP 8.0+ 
- Composer
- Node.js و npm
- MySQL/SQLite
- Laravel 8.75+

### التثبيت والإعداد

```bash
# 1. استنساخ المشروع
git clone <repo-url>
cd msrofaty.app

# 2. تثبيت مكتبات PHP
composer install

# 3. تثبيت مكتبات JavaScript
npm install

# 4. نسخ ملف البيئة
cp .env.example .env

# 5. توليد مفتاح التطبيق
php artisan key:generate

# 6. تشغيل الهجرات
php artisan migrate

# 7. (اختياري) ملء البيانات الأساسية
php artisan db:seed

# 8. بناء الأصول الأمامية
npm run dev
```

### تشغيل التطبيق

```bash
# تشغيل خادم التطوير
php artisan serve

# في نافذة أخرى - مراقبة تغييرات JavaScript/CSS
npm run watch
```

ثم افتح المتصفح على: `http://127.0.0.1:8000`

## الاختبارات

```bash
# تشغيل جميع الاختبارات
php artisan test

# تشغيل اختبارات معينة
php artisan test tests/Unit/AccountModelTest.php
php artisan test tests/Feature/EntryControllerTest.php

# مع نسبة الغطاء (Coverage)
php artisan test --coverage
```

## نقاط الأمان المُطبقة

✅ **التحقق من المصادقة** - تسجيل الدخول مطلوب
✅ **سياسات التفويض** - التحقق من ملكية البيانات
✅ **تحقق من صحة المدخلات** - Form Requests
✅ **CSRF Protection** - حماية من الهجمات
✅ **Pagination** - منع تحميل كميات ضخمة من البيانات
✅ **Foreign Keys** - قيود قاعدة البيانات
✅ **Encrypted Cookies** - حماية الجلسات

## الميزات القادمة

- [ ] المصادقة متعددة العوامل (2FA)
- [ ] تصدير البيانات (PDF/Excel)
- [ ] التنبيهات عند تجاوز الميزانية
- [ ] API RESTful
- [ ] تطبيق موبايل

## المساهمة

يرجى فتح issue أو pull request للمساهمة في تحسين المشروع.

## الترخيص

MIT License - انظر LICENSE للتفاصيل.

## الدعم

للمساعدة أو الإبلاغ عن مشاكل، يرجى فتح issue على المستودع.
