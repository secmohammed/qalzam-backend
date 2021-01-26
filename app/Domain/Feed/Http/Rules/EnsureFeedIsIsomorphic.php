<?php

namespace App\Domain\Feed\Http\Rules;

use Illuminate\Contracts\Validation\Rule;

class EnsureFeedIsIsomorphic implements Rule
{
    /**
     * @var mixed
     */
    private $competition;

    /**
     * @param $competition_id
     */
    public function __construct($competition)
    {
        $this->competition = $competition;
    }

    public function message()
    {
        return 'The Feed file must be a valid ' . $this->competition->type;
    }

    /**
     * @param $attribute
     * @param $value
     */
    public function passes($attribute, $file)
    {
        $mime = explode('/', $file->getMimeType())[0];
        $extension = $file->extension();
        switch ($this->competition->type) {
            case 'image' && $mime === 'image':
                return in_array($extension, ['jpg', 'jpeg', 'png']);
                break;
            case 'video' && $mime === 'video':
                return in_array($extension, ['mp4', 'mkv']);
                break;
            default:
                return false;
                break;
        }
    }
}
