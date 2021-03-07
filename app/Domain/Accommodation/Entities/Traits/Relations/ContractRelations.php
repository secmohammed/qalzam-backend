<?php

namespace App\Domain\Accommodation\Entities\Traits\Relations;

use App\Domain\User\Entities\User;
use App\Domain\Product\Entities\Template;

trait ContractRelations
{
    /**
     * @return mixed
     */
    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
