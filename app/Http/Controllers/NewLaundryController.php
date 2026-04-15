<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Addon;
use App\Models\ShopPrice;
use Illuminate\Support\Facades\Auth;

class NewLaundryController extends Controller
{
    public function create() {
        $addons    = Addon::where('is_active', true)->get();
        $shopPrice = ShopPrice::first();
        return view('staff.new-laundry', compact('addons', 'shopPrice'));
    }

    public function store(Request $request) {
        $request->validate([
            'full_name'      => 'required|string',
            'contact_number' => 'required|string',
            'kg'             => 'required|numeric|min:0',
            'service_type'   => 'required|in:ordinary,rush',
        ]);

        $lastQueue   = Queue::whereDate('created_at', today())->max('queue_number');
        $queueNumber = $lastQueue ? $lastQueue + 1 : 1;
        $qrCode      = strtoupper(substr(md5(uniqid()), 0, 6));

        $customer = Queue::create([
            'customer_name'  => $request->full_name,
            'contact_number' => $request->contact_number,
            'queue_number'   => $queueNumber,
            'service_type'   => $request->service_type,
            'kg'             => $request->kg,
            'addons'         => $request->addons ?? [],
            'receiving_time' => $request->receiving_time,
            'total_price'    => $request->total_price,
            'qr_code'        => $qrCode,
            'status'         => 'queued',
            'staff_id'       => Auth::id()
        ]);

        return response()->json([
            'success'      => true,
            'customer'     => $customer,
            'queue_number' => str_pad($queueNumber, 2, '0', STR_PAD_LEFT),
        ]);
    }
}