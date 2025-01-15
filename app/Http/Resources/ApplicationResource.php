<?php


namespace App\Http\Resources;

use App\Models\ApplicationStatusLog;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    public function toArray($request)
    {
        // Since this is an array, you can directly return the array as response
        return [
            'id' => $this->id,
            'institution' => InstituteResource::make($this->institute),
            'course' => CourseResource::make($this->course),
            'term' => TermResource::make($this->term),
            'choice' => $this->choice,
            'amount' => $this->amount,
            'status' => $this->status,
            'statusLogs' => ApplicationStatusLogResource::collection($this->statusLogs),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
