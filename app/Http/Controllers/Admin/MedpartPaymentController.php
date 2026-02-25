<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedpartPayment;
use Illuminate\Http\Request;

class MedpartPaymentController extends Controller
{
    public function index()
    {
        $payments = MedpartPayment::get();
        return view('admin.medpart_payment.index', compact('payments'));
    }

    public function create()
    {
        return view('admin.medpart_payment.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        MedpartPayment::create([
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('medpart-payments.index')->with('success', 'Metode Pembayaran berhasil ditambahkan!');
    }

    public function show(MedpartPayment $medpartPayment)
    {
        return redirect()->route('medpart-payments.index');
    }

    public function edit(MedpartPayment $medpartPayment)
    {
        return view('admin.medpart_payment.edit', compact('medpartPayment'));
    }

    public function update(Request $request, MedpartPayment $medpartPayment)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        $medpartPayment->update([
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('medpart-payments.index')->with('success', 'Metode Pembayaran berhasil diperbarui!');
    }

    public function destroy(MedpartPayment $medpartPayment)
    {
        $medpartPayment->delete();
        return redirect()->route('medpart-payments.index')->with('success', 'Metode Pembayaran dihapus!');
    }
}
