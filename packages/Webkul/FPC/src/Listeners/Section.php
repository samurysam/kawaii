<?php

namespace Webkul\FPC\Listeners;

use Illuminate\Support\Arr;
use Spatie\ResponseCache\Facades\ResponseCache;
use Webkul\Theme\Repositories\SectionRepository;

class Section
{
    /**
     * Types the layout draws on every page rather than the home page alone.
     *
     * @var array
     */
    public const LAYOUT_TYPES = ['footer_links', 'services_content'];

    /**
     * Create a new listener instance.
     *
     * @return void
     */
    public function __construct(protected SectionRepository $sectionRepository) {}

    /**
     * After section create.
     *
     * @param  \Webkul\Shop\Contracts\Section  $section
     * @return void
     */
    public function afterCreate($section)
    {
        $this->forget([$section->type]);
    }

    /**
     * After section update.
     *
     * @param  \Webkul\Shop\Contracts\Section  $section
     * @return void
     */
    public function afterUpdate($section)
    {
        $this->forget([$section->type]);
    }

    /**
     * Before section delete.
     *
     * @param  int  $sectionId
     * @return void
     */
    public function beforeDelete($sectionId)
    {
        $section = $this->sectionRepository->find($sectionId);

        $this->forget([$section?->type]);
    }

    /**
     * Drop the pages the given section types are rendered on.
     *
     * The home page carries the sections it is built from, while the footer and the service
     * promises are drawn by the layout and so reach every page.
     */
    protected function forget(array $types): void
    {
        if (array_intersect($types, self::LAYOUT_TYPES)) {
            ResponseCache::clear();

            return;
        }

        ResponseCache::selectCachedItems()
            ->forUrls($this->homepageUrls())
            ->forget();
    }

    /**
     * Home page URLs that should be invalidated together in local development.
     */
    protected function homepageUrls(): array
    {
        $appUrl = rtrim((string) config('app.url'), '/');

        $urls = [$appUrl.'/'];

        $host = parse_url($appUrl, PHP_URL_HOST);

        if (in_array($host, ['127.0.0.1', 'localhost'], true)) {
            $alternateHost = $host === '127.0.0.1' ? 'localhost' : '127.0.0.1';
            $alternateUrl = preg_replace('#//'.preg_quote($host, '#').'(?=[:/]|$)#', '//'.$alternateHost, $appUrl, 1);

            if (is_string($alternateUrl) && $alternateUrl !== $appUrl) {
                $urls[] = $alternateUrl.'/';
            }
        }

        return array_values(array_unique(Arr::where($urls, fn ($url) => is_string($url) && $url !== '/')));
    }
}
