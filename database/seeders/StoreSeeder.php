<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إنشاء التصنيفات الأساسية
        $printersCategory = Category::create([
            'name_ar' => 'طابعات ليزر',
            'name_en' => 'Laser Printers',
            'slug' => 'laser-printers',
        ]);

        $copiersCategory = Category::create([
            'name_ar' => 'ماكينات تصوير',
            'name_en' => 'Copiers',
            'slug' => 'copiers',
        ]);

        $inksCategory = Category::create([
            'name_ar' => 'أحبار أصلية',
            'name_en' => 'Original Inks',
            'slug' => 'original-inks',
        ]);

        // 2. إنشاء المنتجات وربطها بالتصنيفات
        $products = [
            [
                'category_id' => $printersCategory->id,
                'name_ar' => 'طابعة Xero ليزر برو 500',
                'name_en' => 'Xero Laser Pro 500',
                'slug' => Str::slug('Xero Laser Pro 500'),
                'description_ar' => 'طابعة ليزر سريعة وعالية الدقة تناسب المكاتب المتوسطة.',
                'description_en' => 'Fast and high-resolution laser printer for medium offices.',
                'price' => 4500.00,
                'stock' => 15,
                'is_active' => true,
            ],
            [
                'category_id' => $copiersCategory->id,
                'name_ar' => 'ماكينة تصوير Xero ألوان X-900',
                'name_en' => 'Xero Color Copier X-900',
                'slug' => Str::slug('Xero Color Copier X-900'),
                'description_ar' => 'ماكينة تصوير ألوان متكاملة للشركات الكبرى.',
                'description_en' => 'All-in-one color copier for large enterprises.',
                'price' => 25000.00,
                'stock' => 5,
                'is_active' => true,
            ],
            [
                'category_id' => $inksCategory->id,
                'name_ar' => 'حبر ليزر أسود متوافق',
                'name_en' => 'Compatible Black Toner',
                'slug' => Str::slug('Compatible Black Toner'),
                'description_ar' => 'حبر عالي الجودة يكفي لطباعة 5000 ورقة.',
                'description_en' => 'High quality toner yields up to 5000 pages.',
                'price' => 850.00,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'category_id' => $printersCategory->id,
                'name_ar' => 'طابعة إيكو تانك الموفرة',
                'name_en' => 'Eco-Tank Saver Printer',
                'slug' => Str::slug('Eco-Tank Saver Printer'),
                'description_ar' => 'طابعة اقتصادية بخزانات حبر قابلة لإعادة الملء.',
                'description_en' => 'Economic printer with refillable ink tanks.',
                'price' => 6200.00,
                'stock' => 10,
                'is_active' => true,
            ]
        ];

        // إدخال المنتجات في قاعدة البيانات
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}