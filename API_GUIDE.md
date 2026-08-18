# دليل الاستخدام والواجهات (API)

## 1. المسارات الرئيسية

### مسارات المصادقة
```
POST   /register              - تسجيل مستخدم جديد
POST   /login                 - دخول المستخدم
POST   /logout                - تسجيل الخروج
```

### مسارات لوحة التحكم (جميعها تحت /acp)
```
GET    /acp                        - لوحة المعلومات الرئيسية
GET    /acp/report/{year}/{month}  - تقرير شهري

# Entries (المعاملات)
GET    /acp/entry                  - عرض المعاملات
GET    /acp/entry/create           - نموذج إنشاء معاملة
POST   /acp/entry                  - حفظ معاملة جديدة
GET    /acp/entry/{id}             - عرض معاملة
GET    /acp/entry/{id}/edit        - نموذج تعديل معاملة
PUT    /acp/entry/{id}             - تحديث معاملة
DELETE /acp/entry/{id}             - حذف معاملة

# Records (السجلات/الحركات)
GET    /acp/record                 - عرض السجلات
GET    /acp/record/create          - نموذج إنشاء سجل
POST   /acp/record                 - حفظ سجل جديد
GET    /acp/record/{id}            - عرض سجل
GET    /acp/record/{id}/edit       - نموذج تعديل سجل
PUT    /acp/record/{id}            - تحديث سجل
DELETE /acp/record/{id}            - حذف سجل

# Budgets (الميزانيات)
GET    /acp/budget                 - عرض الميزانيات
GET    /acp/budget/create          - نموذج إنشاء ميزانية
POST   /acp/budget                 - حفظ ميزانية جديدة
GET    /acp/budget/{id}            - عرض ميزانية
GET    /acp/budget/{id}/edit       - نموذج تعديل ميزانية
PUT    /acp/budget/{id}            - تحديث ميزانية
DELETE /acp/budget/{id}            - حذف ميزانية

# Accounts (الحسابات)
GET    /acp/account                - عرض الحسابات
GET    /acp/account/create         - نموذج إنشاء حساب
POST   /acp/account                - حفظ حساب جديد
GET    /acp/account/{id}           - عرض حساب
GET    /acp/account/{id}/edit      - نموذج تعديل حساب
PUT    /acp/account/{id}           - تحديث حساب
DELETE /acp/account/{id}           - حذف حساب

# Categories (التصنيفات)
GET    /acp/category               - عرض التصنيفات
GET    /acp/category/create        - نموذج إنشاء تصنيف
POST   /acp/category               - حفظ تصنيف جديد
GET    /acp/category/{id}          - عرض تصنيف
GET    /acp/category/{id}/edit     - نموذج تعديل تصنيف
PUT    /acp/category/{id}          - تحديث تصنيف
DELETE /acp/category/{id}          - حذف تصنيف
```

## 2. نماذج البيانات

### User (المستخدم)
```php
{
    "id": 1,
    "name": "محمد أحمد",
    "email": "user@example.com",
    "email_verified_at": "2024-01-01T00:00:00Z",
    "created_at": "2024-01-01T00:00:00Z",
    "updated_at": "2024-01-01T00:00:00Z"
}
```

### Entry (المعاملة)
```php
{
    "id": 1,
    "date": "2024-06-15",
    "note": "مصروفات اليوم",
    "user_id": 1,
    "status": true,           // متوازنة أم لا؟
    "deposit": 500,           // إجمالي الإيداعات
    "withdraw": 500,          // إجمالي السحوبات
    "records": [
        {
            "id": 1,
            "account_id": 1,
            "type": 1,        // 1 = إيداع، -1 = سحب
            "value": 500,
            "category_id": 1,
            "comment": "راتب"
        }
    ],
    "created_at": "2024-06-15T00:00:00Z"
}
```

### Record (السجل)
```php
{
    "id": 1,
    "entry_id": 1,
    "account_id": 1,
    "type": 1,              // 1 = إيداع، -1 = سحب
    "value": 500.00,
    "category_id": 1,
    "comment": "راتب شهري",
    "date": "2024-06-15",   // من خلال العلاقة مع Entry
    "created_at": "2024-06-15T00:00:00Z"
}
```

### Account (الحساب)
```php
{
    "id": 1,
    "name": "حسابي الأساسي",
    "balance": 1500.50,     // محسوب من جميع السجلات
    "created_at": "2024-01-01T00:00:00Z"
}
```

### Category (التصنيف)
```php
{
    "id": 1,
    "name": "طعام",
    "category_id": null,    // التصنيف الأب (للتصنيفات الفرعية)
    "records": [],          // السجلات المرتبطة
    "budgets": [],          // الميزانيات المرتبطة
    "subcategories": []     // التصنيفات الفرعية
}
```

### Budget (الميزانية)
```php
{
    "id": 1,
    "name": "ميزانية يونيو",
    "start_date": "2024-06-01",
    "end_date": "2024-06-30",
    "limit": 5000.00,       // الحد الأقصى للإنفاق
    "notice": 4000.00,      // مستوى التنبيه
    "user_id": 1,
    "categories": [
        {"id": 1, "name": "طعام"},
        {"id": 2, "name": "نقل"}
    ],
    "created_at": "2024-06-01T00:00:00Z"
}
```

## 3. معايير التحقق (Validation)

### Entry
```php
[
    'date' => 'required|date',
    'note' => 'string|nullable',
    'user_id' => 'required|integer|exists:users,id',
]
```

### Record
```php
[
    'entry_id' => 'required|integer|exists:entries,id',
    'account_id' => 'required|integer|exists:accounts,id',
    'type' => 'required|in:-1,1',
    'value' => 'required|numeric|between:-999999.99,999999.99',
    'category_id' => 'integer|exists:categories,id|nullable',
    'comment' => 'string|max:255|nullable',
]
```

### Budget
```php
[
    'name' => 'required|string|max:100',
    'start_date' => 'required|date',
    'end_date' => 'required|date',
    'limit' => 'required|numeric|between:-999999.99,999999.99',
    'notice' => 'required|numeric|between:-999.99,999.99',
    'user_id' => 'required|integer|exists:users,id',
    'categories' => 'array|exists:categories,id',
]
```

## 4. معالجة الأخطاء

### الاستجابات الشائعة

**نجاح (200)**
```json
{
    "message": "تم العملية بنجاح",
    "data": {}
}
```

**عدم التفويض (403)**
```json
{
    "message": "غير مصرح لك بإجراء هذه العملية"
}
```

**غير موجود (404)**
```json
{
    "message": "المورد المطلوب غير موجود"
}
```

**خطأ في التحقق (422)**
```json
{
    "message": "فشل التحقق من البيانات",
    "errors": {
        "email": ["البريد الإلكتروني مطلوب"],
        "name": ["الاسم مطلوب"]
    }
}
```

## 5. أمثلة للاستخدام

### إضافة معاملة جديدة مع حركة (Record)

```bash
# 1. أولاً، إنشاء معاملة
curl -X POST http://localhost:8000/acp/entry \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{
    "date": "2024-06-15",
    "note": "دخل اليوم"
  }'

# 2. ثم، إضافة حركة (سحب/إيداع)
curl -X POST http://localhost:8000/acp/record \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{
    "entry_id": 1,
    "account_id": 1,
    "type": 1,           // إيداع
    "value": 500,
    "category_id": 1,
    "comment": "راتب"
  }'
```

### الحصول على تقرير شهري

```bash
curl -X GET http://localhost:8000/acp/report/2024/6 \
  -H "Authorization: Bearer YOUR_TOKEN"
```

## 6. ملاحظات الأمان

- **جميع الطلبات تتطلب المصادقة** - يجب تسجيل الدخول
- **التفويض مفعل** - لا يمكنك رؤية أو تعديل بيانات المستخدمين الآخرين
- **Pagination مفعلة** - الحد الأقصى 50 سجل في الطلب الواحد
- **CSRF Protection** - تأكد من إرسال token CSRF في النماذج
