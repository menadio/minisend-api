<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EmailResource extends JsonResource
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
            'id' => $this->uuid,
            'sender' => $this->sender,
            'recipient' => $this->recipient,
            'subject' => $this->subject,
            'body' => new EmailBodyResource($this->whenLoaded('emailBody')),
            'attachments' => EmailAttachmentResource::collection($this->whenLoaded('emailAttachments')),
            'status' => $this->status->name,
            'created_at' => Carbon::parse($this->created_at)->format('d/m/Y H:i a')
        ];
    }
}
