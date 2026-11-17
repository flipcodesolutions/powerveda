<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CmsPageController extends Controller
{
    /**
     * Display CMS listing with search and pagination.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $pages = CmsPage::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('title', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->orderBy('id', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.pages.cms.index', compact('pages', 'search'));
    }

    /**
     * Display create form for new CMS page.
     */
    public function create(): View
    {
        $page = new CmsPage([
            'status' => true,
        ]);

        return view('admin.pages.cms.form', compact('page'));
    }

    /**
     * Display edit form for existing CMS page.
     */
    public function edit(int $id): View
    {
        $page = CmsPage::findOrFail($id);

        return view('admin.pages.cms.form', compact('page'));
    }

    /**
     * Handle both create and update operations using a single method.
     */
    public function createOrUpdate(Request $request): RedirectResponse
    {
        $id = $request->input('id');

        $validated = $request->validate([
            'id' => ['nullable', 'integer', 'exists:cms_pages,id'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('cms_pages', 'slug')->ignore($id),
            ],
            'content' => ['required', 'string'],
            'status' => ['required', 'in:0,1'],
        ]);

        try {
            DB::beginTransaction();

            // Auto-generate slug if not provided or empty
            $slugInput = trim((string) ($validated['slug'] ?? ''));
            if ($slugInput === '') {
                $slug = CmsPage::generateUniqueSlug($validated['title'], $id ? (int) $id : null);
            } else {
                $slug = Str::slug($slugInput);
                // Ensure slug uniqueness
                $duplicateQuery = CmsPage::where('slug', $slug);
                if ($id) {
                    $duplicateQuery->where('id', '!=', $id);
                }
                if ($duplicateQuery->exists()) {
                    $slug = CmsPage::generateUniqueSlug($slug, $id ? (int) $id : null);
                }
            }

            $payload = [
                'title' => $validated['title'],
                'slug' => $slug,
                'content' => $validated['content'],
                'detail' => $validated['content'],
                'status' => (bool) $validated['status'],
            ];

            if ($id) {
                $page = CmsPage::findOrFail($id);
                $page->update($payload);
                $message = "CMS Page '{$page->title}' has been successfully updated!";
            } else {
                $page = CmsPage::create($payload);
                $message = "CMS Page '{$page->title}' has been successfully created!";
            }

            DB::commit();

            return redirect()
                ->route('admin.cms.index')
                ->with('success', $message);

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'An error occurred while saving the CMS page: ' . $e->getMessage());
        }
    }

    /**
     * Change active/inactive status.
     */
    public function toggleStatus(int $id): RedirectResponse
    {
        try {
            $page = CmsPage::findOrFail($id);
            $page->status = !$page->status;
            $page->save();

            $statusLabel = $page->status ? 'Active' : 'Inactive';

            return back()->with('success', "Page '{$page->title}' status changed to {$statusLabel}.");
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to update page status: ' . $e->getMessage());
        }
    }

    /**
     * Display frontend CMS page.
     */
    public function show(string $slug): View
    {
        $page = CmsPage::where('slug', $slug)
            ->active()
            ->firstOrFail();

        return view('visitor.pages.policy', compact('page'));
    }
}
