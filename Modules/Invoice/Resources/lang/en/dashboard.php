<?php
return
[
    'invoices' =>
    [
        'index' => [
            'title' => 'Invoices',
            'transactions' => 'Transactions',
            'payment_links' => 'Payment Links',
        ],
        'datatable' =>
        [
            'number' => 'Invoice No.',
            'vendor' => 'Office',
            'amount' => 'Amount',
            'vat_amount' => 'VAT Amount',
            'discount_amount' => 'Discount Amount',
            'total' => 'Total',
            'status' => 'Status',
            'created_at' => 'Created at',
            'options' => 'Options',
            'client_name' => 'Client Name',
            'client_phone' => 'Client Phone',
            'reference_no' => 'Reference No.',
            'note' => 'Note',
            'payment_status' => 'Payment Status',
            'channel' => 'Channel',
            'short_link' => 'Short Link',
            'original_link' => 'Original Link',
            'expires_at' => 'Expiration Date',
            'transaction_key' => 'Transaction Key',
            'transaction_id' => 'Transaction ID',
            'invoice_amount' => 'Invoice Amount',
            'updated_at' => 'Last Update at',
            'or_select_users' => 'Or Select Agents',
        ],
        'show' =>
        [
            'subscription' => 'System Subscription',
            'invoice' => 'Invoice',
            'date' => 'Date',
            'email' => 'E-mail',
            'mobile' => 'Mobile Number',
            'description' => 'Description',
            'print' => 'Print',
            'loading' => 'Loading...',
        ],
        'form' =>
        [
            'create' => 'Create',
            'update' => 'Update',
            'general' => 'General',
            'vendor_required' => 'Office required',
            'amount_required' => 'Amount required',
            'total_required' => 'Total required',
            'status_required' => 'Status required',
            'channel_name_placeholder' => 'Enter the channel name...',
            'copy' => 'Copy',
            'open' => 'Open',
            'create' => 'Create',
            'create_invoice' => 'Create Invoice',
            'close' => 'Close',
        ],
        'statuses' =>
        [
            'paid' => 'Paid',
            'unpaid' => 'Unpaid',
            'canceled' => 'Cancelled',
            'refunded' => 'Refunded',
            'success' => 'Success',
            'pending' => 'Pending',
            'failed' => 'Failed',
            'expired' => 'Expired',
            'valid' => 'Valid',
            'disabled' => 'Disabled',
            'complete' => 'Complete (Success)',
            'incomplete' => 'Incomplete (Failed)',
        ],
        'channels' =>
        [
            'call_center' => 'Call Center',
            'online_store' => 'Online Store',
            'pharmacy' => 'Pharmacy',
            'other' => 'Other',
        ],
        'tabs' =>
        [
            'invoice_details' => 'Invoice Details',
            'transactions' => 'Transactions',
            'payment_links' => 'Payment Link',
            'activity_log' => 'Activity Log',
        ]
    ]
];
