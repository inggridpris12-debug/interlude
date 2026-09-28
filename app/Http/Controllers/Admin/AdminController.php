<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_articles' => Article::where('is_published', true)->count(),
            'pending_reports' => Report::where('status', 'pending')->count(),
            'total_reports' => Report::count(),
        ];

        $recentReports = Report::with(['reporter', 'article', 'resolver'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentReports'));
    }

    public function reports(Request $request)
    {
        $status = $request->query('status', 'pending');

        $stats = [
            'total_users' => User::count(),
            'total_articles' => Article::where('is_published', true)->count(),
            'pending_reports' => Report::where('status', 'pending')->count(),
            'total_reports' => Report::count(),
        ];

        $reports = Report::with(['reporter', 'article.user', 'resolver'])
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20);

        return view('admin.reports', compact('reports', 'status', 'stats'));
    }

    public function resolveReport(Request $request, Report $report)
    {
        $validated = $request->validate([
            'action' => 'required|in:hide,delete,safe',
        ]);

        // ponytail: simple action mapping, add nuanced moderation when needed
        match ($validated['action']) {
            'hide' => $report->article->update(['is_published' => false]),
            'delete' => $report->article->delete(),
            'safe' => null,
        };

        $report->update([
            'status' => $validated['action'] === 'safe' ? 'rejected' : 'resolved',
            // ponytail: resolved_by FK-nya masih ke tabel users padahal diisi id admin; migrasikan FK ke admins begitu jejak moderasi akurat dibutuhkan
            'resolved_by' => Auth::guard('admin')->id(),
            'resolved_at' => now(),
        ]);

        return back()->with('success', 'Laporan berhasil diproses.');
    }

    public function users(Request $request)
    {
        $search = $request->query('q');

        $users = User::query()
            ->withCount('articles')
            ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%"))
            ->latest()
            ->paginate(20);

        return view('admin.users', compact('users', 'search'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
