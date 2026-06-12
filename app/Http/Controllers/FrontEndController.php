<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\KategoriArtikel;

class FrontEndController extends Controller
{
    public function index()
    {
        $terkini = Artikel::orderBy('tanggal', 'desc')->take(5)->get(); // Untuk sidebar
        $kategori = KategoriArtikel::all();

        $headline = Artikel::with(['penulis', 'kategori'])
            ->orderBy('tanggal', 'desc')
            ->first();

        $artikelQuery = Artikel::with(['penulis', 'kategori'])
            ->orderBy('tanggal', 'desc');

        if ($headline) {
            $artikelQuery->where('id', '!=', $headline->id);
        }

        $artikel = $artikelQuery->paginate(6);

        if (request()->ajax()) {
            $view = view('frontend.partials.artikel_grid', compact('artikel'))->render();
            return response()->json(['html' => $view, 'next_page' => $artikel->nextPageUrl()]);
        }

        return view('frontend.home', compact('headline', 'artikel', 'terkini', 'kategori'));
    }

    public function show($id)
    {
        $artikel = Artikel::with(['penulis', 'kategori', 'reaksis'])->findOrFail($id);
        
        // Cek ID artikel sebelumnya dan sesudahnya untuk navigasi
        $previous = Artikel::where('id', '<', $artikel->id)->orderBy('id','desc')->first();
        $next = Artikel::where('id', '>', $artikel->id)->orderBy('id')->first();

        // Artikel Terkait
        $related = Artikel::where('id_kategori', $artikel->id_kategori)
                        ->where('id', '!=', $artikel->id)
                        ->take(5)
                        ->get();

        // Hitung Reaksi
        $reaksiCounts = [
            'inspiratif' => $artikel->reaksis->where('tipe_reaksi', 'inspiratif')->count(),
            'terkejut' => $artikel->reaksis->where('tipe_reaksi', 'terkejut')->count(),
            'sedih' => $artikel->reaksis->where('tipe_reaksi', 'sedih')->count(),
            'menarik' => $artikel->reaksis->where('tipe_reaksi', 'menarik')->count(),
        ];

        return view('frontend.baca', compact('artikel', 'previous', 'next', 'related', 'reaksiCounts'));
    }

    public function storeReaksi(Request $request, $id)
    {
        $tipe = $request->input('tipe_reaksi');
        $ip = $request->ip();

        // Validasi Tipe
        $validTypes = ['inspiratif', 'terkejut', 'sedih', 'menarik'];
        if (!in_array($tipe, $validTypes)) {
            return response()->json(['success' => false, 'message' => 'Tipe reaksi tidak valid.']);
        }

        // Cek jika IP ini sudah pernah bereaksi di artikel ini
        // Jika IP address sama dan artikel_id sama, maka tidak bisa bereaksi lagi.
        $existing = \App\Models\Reaksi::where('artikel_id', $id)->where('ip_address', $ip)->first();
        
        if ($existing) {
            return response()->json(['success' => false, 'message' => 'Anda sudah memberikan reaksi pada artikel ini.']);
        }

        \App\Models\Reaksi::create([
            'artikel_id' => $id,
            'tipe_reaksi' => $tipe,
            'ip_address' => $ip,
        ]);

        return response()->json(['success' => true]);
    }

    public function trackView(Request $request, $id)
    {
        $sessionKey = 'viewed_artikel_' . $id;
        if (!$request->session()->has($sessionKey)) {
            $artikel = Artikel::findOrFail($id);
            $artikel->increment('views');
            $request->session()->put($sessionKey, true);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Already viewed']);
    }

    public function getStats($id)
    {
        $artikel = Artikel::findOrFail($id);
        $totalViews = $artikel->views;
        $totalReactions = \App\Models\Reaksi::where('artikel_id', $id)->count();

        return response()->json([
            'views' => $totalViews,
            'reactions' => $totalReactions
        ]);
    }

    public function byKategori($id)
    {
        $kategoriAktif = KategoriArtikel::findOrFail($id);
        $terkini = Artikel::orderBy('tanggal', 'desc')->take(5)->get();
        $kategori = KategoriArtikel::all();

        $artikel = Artikel::with(['penulis', 'kategori'])
            ->where('id_kategori', $id)
            ->orderBy('tanggal', 'desc')
            ->paginate(6);

        if (request()->ajax()) {
            $view = view('frontend.partials.artikel_grid', compact('artikel'))->render();
            return response()->json(['html' => $view, 'next_page' => $artikel->nextPageUrl()]);
        }

        return view('frontend.home', compact('artikel', 'terkini', 'kategori', 'kategoriAktif'));
    }

    public function liveSearch(Request $request)
    {
        $keyword = $request->input('q');
        
        if (empty(trim($keyword))) {
            return response()->json([]);
        }

        $artikel = Artikel::with(['penulis', 'kategori'])
            ->where('judul', 'like', '%' . $keyword . '%')
            ->orWhere('isi_artikel', 'like', '%' . $keyword . '%')
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();
            
        return response()->json($artikel);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('q');
        $artikel = Artikel::with(['penulis', 'kategori'])
            ->where('judul', 'like', '%' . $keyword . '%')
            ->orWhere('isi_artikel', 'like', '%' . $keyword . '%')
            ->orderBy('tanggal', 'desc')
            ->paginate(6);
            
        if ($request->ajax()) {
            $view = view('frontend.partials.artikel_grid', compact('artikel'))->render();
            return response()->json(['html' => $view, 'next_page' => $artikel->nextPageUrl()]);
        }

        return view('frontend.search', compact('artikel', 'keyword'));
    }

    public function penulis(Request $request, $username)
    {
        $penulis = \App\Models\Penulis::where('user_name', $username)->firstOrFail();
        
        $artikel = Artikel::with(['kategori'])
            ->where('id_penulis', $penulis->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(6);

        if ($request->ajax()) {
            $view = view('frontend.partials.artikel_grid', compact('artikel'))->render();
            return response()->json(['html' => $view, 'next_page' => $artikel->nextPageUrl()]);
        }

        return view('frontend.penulis', compact('penulis', 'artikel'));
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function redaksi()
    {
        $penulis = \App\Models\Penulis::all();
        return view('frontend.redaksi', compact('penulis'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function privacy()
    {
        return view('frontend.privacy');
    }
}
