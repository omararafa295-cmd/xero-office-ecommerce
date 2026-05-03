FROM php:8.2-apache

# تثبيت الحزم الأساسية للنظام
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    libzip-dev

# تنظيف الكاش الخاص بنظام التشغيل
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# تثبيت إضافات PHP المطلوبة لتشغيل Laravel (شاملة دعم MySQL و PostgreSQL)
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip

# تفعيل mod_rewrite الخاص بـ Apache لضمان عمل راوتنج Laravel
RUN a2enmod rewrite

# تغيير المسار الافتراضي لـ Apache ليقرأ من مجلد public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# تحميل Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# تحديد مسار العمل داخل السيرفر
WORKDIR /var/www/html

# نسخ ملفات المشروع بالكامل
COPY . .

# تثبيت حزم Laravel بدون المكاتب الخاصة بالتطوير
RUN composer install --no-interaction --optimize-autoloader --no-dev

# إعطاء الصلاحيات اللازمة لمجلدات التخزين والكاش
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# جعل السكريبت قابل للتشغيل
RUN chmod +x docker-entrypoint.sh

# فتح البورت 80
EXPOSE 80

# أمر التشغيل الأساسي
ENTRYPOINT ["./docker-entrypoint.sh"]