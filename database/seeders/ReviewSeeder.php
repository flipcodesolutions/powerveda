<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $firstProduct = Product::first();

        $reviews = [
            [
                'author'     => 'Aarohi Sharma',
                'location'   => 'Mumbai, Maharashtra',
                'product_id' => $firstProduct ? $firstProduct->id : null,
                'rating'     => 5,
                'comment'    => 'The Ashwagandha Gold capsules have been a game-changer for my daily stamina and recovery. I feel more energetic during workouts and deeply calm at night.',
                'photo'      => 'image/review-1.jpg',
                'status'     => 'Approved',
            ],
            [
                'author'     => 'Vikram Malhotra',
                'location'   => 'Bengaluru, Karnataka',
                'product_id' => $firstProduct ? $firstProduct->id : null,
                'rating'     => 5,
                'comment'    => 'Kumkumadi 24K Saffron Oil is pure luxury. The texture is lightweight, deeply nourishing, and gave my skin a healthy, vibrant glow within just two weeks.',
                'photo'      => 'image/review-2.jpg',
                'status'     => 'Approved',
            ],
            [
                'author'     => 'Dr. Priya Nair',
                'location'   => 'New Delhi, Delhi',
                'product_id' => $firstProduct ? $firstProduct->id : null,
                'rating'     => 5,
                'comment'    => 'Super fast delivery, premium glass jar packaging, and authentic taste. The Himalayan Herbal Detox tea has replaced regular coffee in my morning routine.',
                'photo'      => 'image/review-3.jpg',
                'status'     => 'Approved',
            ],
            [
                'author'     => 'Siddharth Rao',
                'location'   => 'Hyderabad, Telangana',
                'product_id' => $firstProduct ? $firstProduct->id : null,
                'rating'     => 5,
                'comment'    => 'Very calming formulation, helps a lot with late work focus. Packaging arrived in pristine condition and the herbs feel 100% genuine.',
                'photo'      => null,
                'status'     => 'Approved',
            ],
        ];

        foreach ($reviews as $data) {
            Review::updateOrCreate(
                ['author' => $data['author']],
                $data
            );
        }
    }
}
