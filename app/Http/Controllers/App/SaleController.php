<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\CashInHandDetail;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ReturnDetail;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
    public function index()
    {
        return view('app.admin.sales.index');
    }

    public function create()
    {
        return view('app.admin.sales.create');
    }

    public function store(Request $request)
    {

    }

    public function show(Sale $sale)
    {
        return view('app.sales.show');
    }

    public function destroy(Sale $sale)
    {
        
    }

    public function printInvoice(Sale $sale)
    {
        return view('app.sales.sale_invoice_print');
    }

    public function generateInvoicePDF(Sale $sale)
    {
        $data = [
            'sale' => $sale,
            'company' => [
                'name' => 'Your Business Name',
                'address' => '123 Business Street, City, State 10001',
                'phone' => '(123) 456-7890',
                'email' => 'info@yourbusiness.com'
            ]
        ];

        $pdf = PDF::loadView('app.sales.sale_invoice_pdf', $data);

        return $pdf->download('invoice-' . $sale->invoice_no . '.pdf');
    }



}
