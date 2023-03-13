<?php

namespace App\Http\Resources;

use App\Wishlist;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    private static $user_id;

    protected $user;

    public function user_id($value)
    {
        $this->user = $value;
        return $this;
    }

    public function toArray($request)
    {
        $is_fav = false;
        if (self::$user_id) {
            $wishlist = Wishlist::where('user_id', self::$user_id)->where('product_id', $this->id)->first();
            if ($wishlist) {
                $is_fav = true;
            }
        }
        if ($this->user) {
            $wishlist = Wishlist::where('user_id', $this->user)->where('product_id', $this->id)->first();
            if ($wishlist) {
                $is_fav = true;
            }
        }
        return [
            'id' => (int)$this->id,
            'title' => (string)$this->title,
            'description' => (string)$this->description,
            //   'price' => $this->price,
            'discount' => (double)$this->offer,
            //  'total_price' => $this->price - $this->price * ($this->offer / 100),
            'main_image' => (string)$this->image,
            'is_fav' => (boolean)$is_fav,
            'units' => ProductUnitsResource::collection($this->productUnits),
            'images' => $this->whenLoaded('images', function () {
                return $this->images;
            }),
            'Review_section' => [
                'reviews' => ReviewResource::collection($this->reviews),
                'total_reviews' => $this->reviews->count(),
                'average' =>$this->reviews->count() > 0 ? $this->reviews->sum('rate') / $this->reviews->count() : 0,
                'five_stars' => $this->reviews->where('rate', 5)->count(),
                'four_stars' => $this->reviews->where('rate', 4)->count(),
                'three_stars' => $this->reviews->where('rate', 3)->count(),
                'two_stars' => $this->reviews->where('rate', 2)->count(),
                'one_stars' => $this->reviews->where('rate', 1)->count(),

            ],

        ];
    }

    public static function customCollection($resource, $user_id): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {

        //you can add as many params as you want.
        self::$user_id = $user_id;
        return parent::collection($resource);
    }
}
