<?php

namespace App\Http\Controllers;

use App\Models\LaundryOrder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaundryController extends Controller
{
    // ─── STAFF: Show new-laundry form ───────────────────────────────────────
    public function create()
    {
        return view('staff.new-laundry');
    }

    // ─── STAFF: Save new laundry order ──────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'weight_kg'      => 'required|numeric|min:0.1',
            'service_type'   => 'required|in:ordinary,rush',
            'addons'         => 'nullable|array',
            'total_price'    => 'required|numeric|min:0',
        ]);

        // Estimated finish: rush = +3 hrs, ordinary = +24 hrs
        $estimatedFinish = $request->service_type === 'rush'
            ? Carbon::now()->addHours(3)
            : Carbon::now()->addHours(24);

        $queueNumber = LaundryOrder::nextQueueNumber();

        // Simple QR code string (queue + timestamp)
        $qrCode = 'WD-' . str_pad($queueNumber, 3, '0', STR_PAD_LEFT) . '-' . now()->format('mdHi');

        $order = LaundryOrder::create([
            'queue_number'     => $queueNumber,
            'customer_name'    => $request->customer_name,
            'contact_number'   => $request->contact_number,
            'weight_kg'        => $request->weight_kg,
            'service_type'     => $request->service_type,
            'addons'           => $request->addons ?? [],
            'total_price'      => $request->total_price,
            'qr_code'          => $qrCode,
            'status'           => 'pending',
            'received_at'      => now(),
            'estimated_finish' => $estimatedFinish,
        ]);

        return response()->json([
            'success'      => true,
            'queue_number' => $queueNumber,
            'qr_code'      => $qrCode,
            'order'        => $order,
        ]);
    }

    // ─── STAFF: Queue management board ──────────────────────────────────────
    public function staffQueue()
    {
        return view('staff.queue');
    }

    // ─── STAFF: Get all orders as JSON (for JS polling) ─────────────────────
    public function ordersJson()
    {
        $orders = LaundryOrder::orderBy('queue_number')
            ->whereDate('created_at', today())
            ->get()
            ->map(fn($o) => [
                'id'               => $o->id,
                'queue'            => $o->queue_number,
                'name'             => $o->customer_name,
                'contact'          => $o->contact_number,
                'kg'               => $o->weight_kg,
                'type'             => $o->service_type,
                'addons'           => $o->addons ?? [],
                'total'            => number_format($o->total_price, 2),
                'status'           => $o->status,
                'received'         => $o->received_at->format('M j · g:i A'),
                'finish'           => optional($o->estimated_finish)->format('M j · g:i A') ?? '—',
                'qr_code'          => $o->qr_code,
            ]);

        return response()->json($orders);
    }

    // ─── STAFF: Update order status ──────────────────────────────────────────
    public function updateStatus(Request $request, LaundryOrder $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,complete',
        ]);

        $order->update(['status' => $request->status]);

        return response()->json(['success' => true, 'status' => $order->status]);
    }

    // ─── PUBLIC: Queue view ───────────────────────────────────────────────────
    public function publicQueue()
    {
        $orders = LaundryOrder::orderBy('queue_number')
            ->whereDate('created_at', today())
            ->get();

        $stats = [
            'pending'    => $orders->where('status', 'pending')->count(),
            'processing' => $orders->where('status', 'processing')->count(),
            'complete'   => $orders->where('status', 'complete')->count(),
            'rush'       => $orders->where('service_type', 'rush')->count(),
        ];

        $customers = $orders->map(fn($o) => [
            'queue'    => $o->queue_number,
            'name'     => $o->customer_name,
            'items'    => $o->weight_kg . ' kg · ' . ($o->addons ? implode(', ', $o->addons) : 'Standard wash'),
            'type'     => $o->service_type,
            'received' => $o->received_at->format('M j · g:i A'),
            'finish'   => optional($o->estimated_finish)->format('M j · g:i A') ?? '—',
            'status'   => $o->status,
        ]);

        return view('publicqueue', compact('customers', 'stats'));
    }

    // ─── PUBLIC: Orders JSON for auto-refresh ────────────────────────────────
    public function publicOrdersJson()
    {
        $orders = LaundryOrder::orderBy('queue_number')
            ->whereDate('created_at', today())
            ->get();

        $stats = [
            'pending'    => $orders->where('status', 'pending')->count(),
            'processing' => $orders->where('status', 'processing')->count(),
            'complete'   => $orders->where('status', 'complete')->count(),
            'rush'       => $orders->where('service_type', 'rush')->count(),
        ];

        $customers = $orders->map(fn($o) => [
            'queue'    => $o->queue_number,
            'name'     => $o->customer_name,
            'items'    => $o->weight_kg . ' kg · ' . ($o->addons ? implode(', ', $o->addons) : 'Standard wash'),
            'type'     => $o->service_type,
            'received' => $o->received_at->format('M j · g:i A'),
            'finish'   => optional($o->estimated_finish)->format('M j · g:i A') ?? '—',
            'status'   => $o->status,
        ]);

        return response()->json(['customers' => $customers, 'stats' => $stats]);
    }
}