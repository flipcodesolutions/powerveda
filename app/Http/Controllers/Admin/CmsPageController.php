<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CmsPageController extends Controller
{
    /**
     * Predefined policy list for quick switching and defaults.
     *
     * @var array<string, string>
     */
    protected array $predefinedPolicies = [
        'privacy-policy' => 'Privacy Policy',
        'refund-policy' => 'Refund Policy',
        'return-policy' => 'Return Policy',
        'shipping-policy' => 'Shipping Policy',
        'terms-and-conditions' => 'Terms and Conditions',
    ];

    /**
     * Display the single Policy CMS edit form.
     */
    public function index(Request $request): View
    {
        $selectedSlug = $request->query('slug', 'privacy-policy');

        // Fetch all existing pages for the tabs/selector
        $existingPages = CmsPage::all()->keyBy('slug');

        // Get the active page model or a new instance with default title if not existing
        $activePage = $existingPages->get($selectedSlug) ?? new CmsPage([
            'slug' => $selectedSlug,
            'title' => $this->predefinedPolicies[$selectedSlug] ?? ucwords(str_replace('-', ' ', $selectedSlug)),
            'detail' => '',
        ]);

        return view('admin.pages.cms.index', [
            'predefinedPolicies' => $this->predefinedPolicies,
            'existingPages' => $existingPages,
            'activePage' => $activePage,
            'selectedSlug' => $selectedSlug,
        ]);
    }

    /**
     * Create or update a policy page based on slug.
     */
    public function createOrUpdate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'detail' => 'required|string',
        ]);

        $page = CmsPage::updateOrCreate(
            ['slug' => $validated['slug']],
            [
                'title' => $validated['title'],
                'detail' => $validated['detail'],
            ]
        );

        return redirect()
            ->route('admin.cms.index', ['slug' => $page->slug])
            ->with('success', "'{$page->title}' has been successfully saved!");
    }
}
