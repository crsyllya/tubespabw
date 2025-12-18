<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    // GET /api/admin/faqs
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => Faq::latest()->get()
        ]);
    }

    // POST /api/admin/faqs
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer'   => 'required|string',
        ]);

        $faq = Faq::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'FAQ berhasil ditambahkan',
            'data' => $faq
        ], 201);
    }

    // PUT /api/admin/faqs/{id}
    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer'   => 'required|string',
        ]);

        $faq->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'FAQ berhasil diperbarui',
            'data' => $faq
        ]);
    }

    // DELETE /api/admin/faqs/{id}
    public function destroy($id)
    {
        Faq::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'FAQ berhasil dihapus'
        ]);
    }
}
