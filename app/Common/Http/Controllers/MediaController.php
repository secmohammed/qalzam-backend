<?php

namespace App\Common\Http\Controllers;

use Joovlly\DDD\Traits\Responder;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Infrastructure\Http\AbstractControllers\BaseController;

class MediaController extends BaseController
{
    use Responder;

    /**
     * @var mixed
     */
    private $media;

    /**
     * @param Media $media
     */
    public function __construct(Media $media)
    {
        $this->media = $media;
    }

    /**
     * @return mixed
     */
    public function destroy($id)
    {
        $ids = request()->get('ids', $id);
        $ids = explode(',', $ids);

        $deleted = $this->media->whereIn('id', $ids)->delete();
        if ($deleted) {
            $this->setApiResponse(fn() => response()->json(['deleted' => true], 200));
        } else {
            $this->setApiResponse(fn() => response()->json(['deleted' => false], 404));
        }

        return $this->response();

    }
}
