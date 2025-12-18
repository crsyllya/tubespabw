<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use App\Models\Transaksi;
use Illuminate\Http\Request;

class AdminTransaksiController extends Controller
{
    public function index()
    {
        $transactions = Transaksi::with(['event'])->latest()->get();
        return view('admin.transactions.index', compact('transactions'));
    }

    public function search()
    {
        return view();
    }

    public function updateStatus(Request $request, $id)
    {
        $transaction = Transaksi::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,verifying,success,rejected,expired'
        ]);

        $transaction->update([
            'status' => $request->status
        ]);

        if ($request->status === 'success') {
            $transaction->tickets()->update(['status' => 'valid']);
        } elseif (in_array($request->status, ['rejected', 'expired'])) {
            $transaction->tickets()->update(['status' => 'invalid']);
        }

        return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $transaction = Transaksi::findOrFail($id);

        if (
            $transaction->bukti_pembayaran &&
            file_exists(public_path('uploads/bukti/' . $transaction->bukti_pembayaran))
        ) {
            unlink(public_path('uploads/bukti/' . $transaction->bukti_pembayaran));
        }

        $transaction->delete();

        return redirect()->back()->with('success', 'Data transaksi berhasil dihapus.');
    }
}
