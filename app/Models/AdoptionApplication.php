<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdoptionApplication extends Model
{
    protected $fillable = [
        'user_id', 'pet_id', 'applicant_name', 'address', 'contact_details',
        'occupation', 'previous_experience', 'reason', 'living_environment', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
