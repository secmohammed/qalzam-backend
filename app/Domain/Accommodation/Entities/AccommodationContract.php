<?php
namespace App\Domain\Accommodation\Entities;
    
use Illuminate\Database\Eloquent\Relations\Pivot;

class AccommodationContract extends Pivot {
    
    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }
    
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
    
   
   
}