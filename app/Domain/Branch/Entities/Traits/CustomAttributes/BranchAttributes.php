<?php

namespace App\Domain\Branch\Entities\Traits\CustomAttributes;

trait BranchAttributes
{
    public function getPreviewNameAttribute()
    {
        return $this->name;
    }

    public function getPreviewStatusAttribute()
    {
        return $this->status;
    }
}
