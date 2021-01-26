<?php

namespace App\Common\Traits;

use Spatie\MediaLibrary\InteractsWithMedia;

trait FetchesMediaCollection
{
    use InteractsWithMedia;

    /**
     * @param string $collectionName
     * @param string $conversionName
     * @return array
     */
    public function getMediaCollectionUrl(string $collectionName = 'default', string $conversionName = ''): array
    {
        $medias = $this->getMedia($collectionName);

        if (!$medias) {
            return $this->getFallbackMediaUrl($collectionName) ?: '';
        }

        return $medias->map(function ($media) use ($collectionName, $conversionName) {
            return $media->getUrl($conversionName);
        })->reject(function ($url) {
            return empty($url);
        })->toArray();
    }
}
