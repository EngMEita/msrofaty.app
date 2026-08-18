# دليل الترقية إلى Laravel 10

## نسخة التاريخ
- **تاريخ الترقية**: 2026-08-18
- **من**: Laravel 8.75 → **إلى**: Laravel 10.x (LTS)
- **PHP**: 7.3|8.0 → **8.1+**

---

## ✅ التغييرات الرئيسية

### 1. متطلبات النظام
```json
// composer.json
"php": "^8.1"  // كان "^7.3|^8.0"
```

- **إزالة دعم PHP 7.3 و PHP 8.0**
- **الحد الأدنى الجديد: PHP 8.1**

### 2. تحديثات Packages الأساسية
| Package              | القديم  | الجديد | ملاحظات               |
| -------------------- | ------- | ------ | --------------------- |
| laravel/framework    | ^8.75   | ^10.0  | ترقية رئيسية          |
| laravel/sanctum      | ^2.11   | ^3.0   | متوافقة مع Laravel 10 |
| laravel/tinker       | ^2.5    | ^2.8   | تحديث أداة تصحيح      |
| laravel/sail         | ^1.0.1  | ^1.26  | تحديث Docker          |
| phpunit/phpunit      | ^9.5.10 | ^10.1  | اختبارات محسّنة        |
| nunomaduro/collision | ^5.10   | ^7.0   | معالجة الأخطاء        |
| laravel/breeze       | ^1.9    | ^1.20  | توثيق محسّن            |

### 3. تحديثات الـ Middleware
```php
// في App\Http\Kernel
// قديم:
\Fruitcake\Cors\HandleCors::class,

// جديد:
\Illuminate\Http\Middleware\HandleCors::class,
```

- **استخدام CORS من Laravel مباشرة** بدلاً من الـ package الخارجي

### 4. تحديثات RouteServiceProvider
```php
// قديم:
Route::prefix('api')
    ->middleware('api')
    ->namespace($this->namespace)  // ❌ أزيل
    ->group(base_path('routes/api.php'));

// جديد:
Route::prefix('api')
    ->middleware('api')
    ->group(base_path('routes/api.php'));
```

- **إزالة `$this->namespace` الصريحة** - Laravel 10 يستخدمها بشكل افتراضي
- **`HOME` constant تحديث**: من `/dashboard` إلى `/acp`

### 5. Return Types في Controllers
```php
// قديم:
public function index(Request $request)
{
    return view('...');
}

// جديد:
public function index(Request $request): View
{
    return view('...');
}
```

**Controllers محدّثة:**
- ✅ HomeController
- ✅ RecordController
- ✅ BudgetController
- ✅ AuthServiceProvider

### 6. تحديثات PHPUnit
```xml
<!-- قديم -->
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="./vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true">

<!-- جديد -->
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="https://schema.phpunit.de/10.1/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true"
         beStrictAboutOutputDuringTests="true"
         failOnRisky="true"
         failOnWarning="true"
         cacheResult="false">
```

- **SQLite للاختبارات مفعّل** (قبلاً كان معطّل)
- **خيارات صرامة جديدة** للاختبارات الأفضل

---

## 📋 الملفات المحدّثة

### composer.json
- تحديث النسخ لـ packages
- إزالة `laravel-shift/blueprint` (اختياري)
- تحديث متطلبات PHP

### Config & Providers
- ✅ app/Providers/RouteServiceProvider.php
- ✅ app/Providers/AuthServiceProvider.php
- ✅ app/Http/Kernel.php

### Controllers
- ✅ app/Http/Controllers/Acp/HomeController.php
- ✅ app/Http/Controllers/Acp/RecordController.php
- ✅ app/Http/Controllers/Acp/BudgetController.php

### Tests
- ✅ phpunit.xml (تحديث شامل)

---

## 🚀 خطوات التثبيت

### 1. تحديث الـ Packages
```bash
composer update
npm update
```

### 2. نسخ ملفات البيئة إذا لزم الأمر
```bash
cp .env.example .env
php artisan key:generate
```

### 3. تشغيل الهجرات (إن وجدت)
```bash
php artisan migrate
```

### 4. تنظيف الـ Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### 5. اختبار التطبيق
```bash
php artisan test
php artisan serve
```

---

## ⚠️ Breaking Changes المهمة

### 1. PHP 8.1+
- **يجب ترقية PHP إلى 8.1 أو أعلى**
- بعض التوابع القديمة لم تعد مدعومة

### 2. Middleware
- `Fruitcake\Cors\HandleCors` → `Illuminate\Http\Middleware\HandleCors`
- تأكد من أن CORS مُعدّ بشكل صحيح

### 3. Routes
- إزالة `->namespace()` من route definitions
- Controllers يجب أن تكون بـ fully qualified names

### 4. Type Hints
- جميع Controller methods الآن لها return types
- قد تحتاج Views و Models إلى تحديثات صغيرة

---

## 🔍 اختبار الترقية

### تشغيل جميع الاختبارات
```bash
php artisan test
```

### اختبار مكونات محددة
```bash
# اختبارات الـ Features
php artisan test tests/Feature

# اختبارات الـ Units
php artisan test tests/Unit

# مع Coverage
php artisan test --coverage
```

### اختبار الـ Routes
```bash
php artisan route:list
```

---

## 📚 المراجع

- [Laravel 10 Release Notes](https://laravel.com/docs/10.x/releases)
- [Laravel Upgrade Guide](https://laravel.com/docs/10.x/upgrade)
- [PHP 8.1 Features](https://www.php.net/releases/8.1/en.php)
- [PHPUnit 10 Docs](https://phpunit.de/documentation.html)

---

## ✨ التحسينات الإضافية

### إضافة مستقبلية
- [ ] دعم Database Encryption
- [ ] Job Batching محسّن
- [ ] Test Profiling
- [ ] Lazy Collections
- [ ] Carbon Macros

---

## 📞 الدعم والمساعدة

إذا واجهت مشكلة:
1. تحقق من رسائل الخطأ في `php artisan tinker`
2. شغّل `php artisan config:cache` وأعد المحاولة
3. احذف `vendor/` و `node_modules/` ثم `composer install && npm install`

