<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Wajib import buat hapus file

class CampaignController extends Controller
{
    // Tampilkan List Campaign
    public function index()
    {
        $campaigns = Campaign::latest()->get();
        return view('admin.campaigns.index', compact('campaigns'));
    }

    // Form Tambah
    public function create()
    {
        return view('admin.campaigns.create');
    }

    // Proses Simpan
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'banner_path' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'redirect_url' => 'nullable|url'
        ]);

        // Upload Gambar
        $path = $request->file('banner_path')->store('campaigns', 'public');

        Campaign::create([
            'title' => $request->title,
            'banner_path' => $path,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'redirect_url' => $request->redirect_url
        ]);

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign berhasil dibuat!');
    }

    // Form Edit
    public function edit(Campaign $campaign)
    {
        return view('admin.campaigns.edit', compact('campaign'));
    }

    // Proses Update
    public function update(Request $request, Campaign $campaign)
    {
        $request->validate([
            'title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $data = $request->except(['banner_path', '_token', '_method']);

        // Cek kalo ada gambar baru
        if ($request->hasFile('banner_path')) {
            // Hapus gambar lama biar server gak penuh
            if ($campaign->banner_path && Storage::disk('public')->exists($campaign->banner_path)) {
                Storage::disk('public')->delete($campaign->banner_path);
            }
            
            // Upload baru
            $data['banner_path'] = $request->file('banner_path')->store('campaigns', 'public');
        }

        $campaign->update($data);

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign diperbarui!');
    }

    // Proses Hapus
    public function destroy(Campaign $campaign)
    {
        // Hapus file gambarnya juga
        if ($campaign->banner_path && Storage::disk('public')->exists($campaign->banner_path)) {
            Storage::disk('public')->delete($campaign->banner_path);
        }

        $campaign->delete();
        return back()->with('success', 'Campaign dihapus.');
    }
}