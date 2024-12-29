<?php

namespace App\Http\Resources;

use App\Helpers\FileUploadHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uploaded_by' => $this->user->name,
            'file_name' => $this->file_name,
            'file_path' => $this->file_path,
            'file_url' => FileUploadHelper::generateSignedUrl($this->id),
            'file_type' => $this->file_type,
            'created_at' => Carbon::parse($this->created_at)->format('d M Y'),
        ];
    }
}
