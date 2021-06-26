<?php

namespace App\Domain\Accommodation\Entities\Traits\Relations;

use App\Domain\Accommodation\Entities\AccommodationContract;
use App\Domain\Accommodation\Entities\Contract;
use App\Domain\Branch\Entities\Branch;
use App\Domain\Category\Entities\Category;
use App\Domain\Product\Entities\Template;
use App\Domain\User\Entities\User;

trait AccommodationRelations
{
    /**
     * @return mixed
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * @return mixed
     */
    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    /**
     * @return mixed
     */
    public function contracts()
    {
        return $this->belongsToMany(Contract::class);
    }

    /**
     * @return mixed
     */
    // public function template()
    // {
    //     return $this->hasOneThrough(Template::class, AccommodationContract::class, 'accommodation_id', 'contract_id', 'id', 'contract_id');
    // }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
