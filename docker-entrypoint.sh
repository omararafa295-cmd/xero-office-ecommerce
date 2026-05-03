#!/bin/bash

# تشغيل قواعد البيانات (Migrations) تلقائياً
php artisan migrate --force

# تهيئة الكاش لضمان سرعة التطبيق
php artisan config:cache
php artisan route:cache
php artisan view:cache

# إنشاء اختصار مجلد الصور (Storage Link)
php artisan storage:link

# تشغيل سيرفر Apache بشكل دائم
apache2-foreground