<?php

namespace Webkul\Shop\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryTreeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $imageUrl = $this->logo_url
            ?: ($this->banner_url
            ?: ($this->products->first()?->images->first()?->url ?? ($this->products->first()?->base_image_url ?? '')));

        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'url' => $this->url,
            'status' => $this->status,
            'image_url' => $imageUrl,
            'logo' => [
                'large_image_url' => $this->logo_url ?: $imageUrl,
                'medium_image_url' => $this->logo_url ?: $imageUrl,
                'small_image_url' => $this->logo_url ?: $imageUrl,
                'original_image_url' => $this->logo_url ?: $imageUrl,
            ],
            'banner' => [
                'large_image_url' => $this->banner_url ?: $imageUrl,
                'medium_image_url' => $this->banner_url ?: $imageUrl,
                'small_image_url' => $this->banner_url ?: $imageUrl,
                'original_image_url' => $this->banner_url ?: $imageUrl,
            ],
            'children' => self::collection($this->children),
        ];
    }
}
