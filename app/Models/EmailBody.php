<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailBody extends Model
{
    use HasFactory;

    /**
     * fillable attributes
     * 
     * @var array
     */
    protected $fillable = ['email_id', 'body'];

    /**
     * email body & email relationship
     */
    public function email(): BelongsTo
    {
        return $this->belongsTo(Email::class);
    }
}
