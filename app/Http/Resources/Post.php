<?php

namespace App\Http\Resources;

use App\Http\Resources\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'type' => 'posts',
                'id' => $this->id,
                'attributes' => [
                    'body' => $this->body,
                    'image' => $this->image,
                    'posted_by' => new User($this->user),
                    'created_at' => $this->created_at,
                    'posted_at' => $this->created_at->diffForHumans(),
                ]
            ],
            'links' => [
                'self' => url('/posts/' . $this->id),
            ]
        ];
    }
}
