<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * بنجيب الطلبات من الداتا بيز (ممكن تحدد طلبات معينة زي الجديدة بس)
    */
    public function collection()
    {
        return Order::orderBy('created_at', 'desc')->get();
    }

    /**
    * عناوين الأعمدة في شيت الإكسيل
    */
    public function headings(): array
    {
        return [
            'رقم الطلب',
            'اسم العميل',
            'رقم التليفون',
            'الإجمالي (ج.م)',
            'حالة الطلب',
            'تاريخ الطلب',
        ];
    }

    /**
    * دمج البيانات تحت العناوين
    */
    public function map($order): array
    {
        return [
            '#' . $order->id,
            $order->customer_name ?? $order->user->name,
            $order->customer_phone ?? optional($order->user)->phone ?? 'غير مسجل',
            $order->total_amount,
            $this->formatStatus($order->status),
            $order->created_at->format('Y-m-d H:i A'),
        ];
    }

    /**
    * تحويل حالة الطلب لعربي عشان الشيت يكون مفهوم
    */
    private function formatStatus($status)
    {
        return match($status) {
            'pending' => 'قيد الانتظار',
            'processing' => 'جاري التجهيز',
            'shipped' => 'تم الشحن',
            'delivered' => 'تم التوصيل',
            'cancelled' => 'ملغي',
            default => $status,
        };
    }
}