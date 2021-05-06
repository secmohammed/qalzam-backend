<?php

namespace App\Common\Traits;

use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

    /**
     * return last media collection
     * @param string $collectionName
     * @param array $filters
     * @return Media|null
     */
    public function getLastMedia(string $collectionName = 'default', $filters = []): ?Media
    {
        $media = $this->getMedia($collectionName, $filters);

        return $media->last();
    }


    /*
     * Get the url of the image for the given conversionName
     * for last media for the given collectionName.
     * If no profile is given, return the source's url.
     */
    public function getLastMediaUrl(string $collectionName = 'default', string $conversionName = ''): string
    {
        $media = $this->getLastMedia($collectionName);

        if (!$media) {
            return $this->getFallbackMediaUrl($collectionName) ?: '';
        }

        return $media->getUrl($conversionName);
    }
}
