<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailAttachment extends Model
{
    use HasFactory;

    /**
     * fillable attributes
     * 
     * @var array
     */
    protected $fillable = ['email_id', 'type', 'file'];

    /**
     * email attachment & email relationship
     */
    public function email(): BelongsTo
    {
        return $this->belongsTo(Email::class);
    }
}
