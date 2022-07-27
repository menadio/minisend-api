<?php

namespace App\Http\Resources;

use App\Models\Email;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'posted_count' => $this->emails->count(),
            'sent_count' => $this->sent->count(),
            'failed_count' => $this->failed->count(),
            'account_created_on' => Carbon::parse($this->created_at)->toDateString()
        ];
    }
}
