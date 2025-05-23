<?php
return
[
    'invoices' =>
    [
        'index' => [
            'title' => 'الفواتير',
            'transactions' => 'المعاملات',
            'payment_links' => 'روابط الدفع',
        ],
        'datatable' =>
        [
            'number' => 'رقم الفاتورة',
            'vendor' => 'المكتب',
            'amount' => 'المبلغ',
            'vat_amount' => 'مبلغ الضريبة',
            'discount_amount' => 'مبلغ الخصم',
            'total' => 'الاجمالي',
            'status' => 'الحالة',
            'created_at' => 'أنشئت بتاريخ',
            'options' => 'الخيارات',
            'client_name' => 'اسم العميل',
            'client_phone' => 'جوال العميل',
            'reference_no' => 'الرقم المرجعي',
            'note' => 'ملاحظة',
            'payment_status' => 'حالة الدفع',
            'channel' => 'القسم',
            'short_link' => 'الرابط المختصر',
            'original_link' => 'الرابط الأصلي',
            'expires_at' => 'ينتهي بتاريخ',
            'transaction_key' => 'معرف المعاملة',
            'transaction_id' => 'رقم المعاملة',
            'invoice_amount' => 'مبلغ الفاتورة',
            'updated_at' => 'آخر تحديث',
            'or_select_users' => 'أو حدد عدد من الموظفين',
        ],
        'show' =>
        [
            'subscription' => 'اشتراك في النظام',
            'invoice' => 'فاتورة',
            'date' => 'التاريخ',
            'email' => 'البريد الالكتروني',
            'mobile' => 'رقم الجوال',
            'description' => 'الوصف',
            'print' => 'طباعة',
            'loading' => 'جارِ التحميل...',
        ],
        'form' =>
        [
            'create' => 'إنشاء',
            'update' => 'تحديث',
            'general' => 'عام',
            'vendor_required' => 'من فضلك حدد المكتب',
            'amount_required' => 'مبلغ الفاتورة مطلوب',
            'total_required' => 'الاجمالي مطلوب',
            'status_required' => 'من فضلك حدد حالة الفاتورة',
            'amount_numeric' => 'المبلغ يجب أن يكون أرقام',
            'channel_name_placeholder' => 'أدخل اسم المنفذ...',
            'copy' => 'نسخ',
            'open' => 'فتح',
            'create' => 'إنشاء',
            'create_invoice' => 'إنشاء فاتورة',
            'close' => 'غلق',
        ],
        'statuses' =>
        [
            'paid' => 'مدفوعة',
            'unpaid' => 'غير مدفوعة',
            'canceled' => 'ملغية',
            'refunded' => 'مرتجعة',
            'success' => 'ناجحة',
            'pending' => 'بالانتظار',
            'failed' => 'فشلت',
            'expired' => 'انتهت الصلاحية',
            'valid' => 'صالح',
            'disabled' => 'معطل',
            'complete' => 'مكتملة (ناجحة)',
            'incomplete' => 'غير مكتملة (فاشلة)',
        ],
        'channels' =>
        [
            'call_center' => 'خدمة العملاء',
            'online_store' => 'المتجر الالكتروني',
            'pharmacy' => 'صيدلية',
            'other' => 'أخرى',
        ],
        'tabs' =>
        [
            'invoice_details' => 'تفاصيل الفاتورة',
            'transactions' => 'حركات الدفع',
            'payment_links' => 'رابط الدفع',
            'activity_log' => 'سجل التتبع',
        ]
    ]
];
