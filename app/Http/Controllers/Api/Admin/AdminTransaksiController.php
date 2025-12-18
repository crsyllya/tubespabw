<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class AdminTransaksiController extends Controller
{
    public function index()
    {
        return response()->json(
            Transaksi::with('event')->latest()->get()
        );
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,verifying,success,rejected,expired'
        ]);

        $transaction = Transaksi::findOrFail($id);
        $transaction->update(['status' => $request->status]);

        if ($request->status === 'success') {
            $transaction->tickets()->update(['status' => 'valid']);
        } elseif (in_array($request->status, ['rejected', 'expired'])) {
            $transaction->tickets()->update(['status' => 'invalid']);
        }

        return response()->json([
            'message' => 'Status transaksi diperbarui',
            'data' => $transaction
        ]);
    }

    public function destroy($id)
    {
        $transaction = Transaksi::findOrFail($id);
        $transaction->delete();

        return response()->json([
            'message' => 'Transaksi berhasil dihapus'
        ]);
    }
}
