<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Hand-rolled sitemap.xml — no package dependency, just the site's own
     * static routes plus every blog post. Add a new static page's route
     * name to STATIC_ROUTES when one is added.
     */
    private const STATIC_ROUTES = [
        'home',
        'about',
        'service',
        'portfolio',
        'contact',
        'blog',
        'services.web-development',
        'services.digital-marketing',
        'services.branding',
        'services.automation',
        'services.content',
        'services.solution',
        'privacy.policy',
        'terms.conditions',
    ];

    public function index(): Response
    {
        $urls = [];

        foreach (self::STATIC_ROUTES as $routeName) {
            $urls[] = [
                'loc' => route($routeName),
                'lastmod' => null,
            ];
        }

        foreach (Blog::all() as $blog) {
            $urls[] = [
                'loc' => route('blog.show', $blog->slug),
                'lastmod' => $blog->updated_at?->toAtomString(),
            ];
        }

        $xml = view('sitemap', ['urls' => $urls])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
