<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $usedSlugs = [];

        $title    = $this->faker->words(3, true);
        $baseSlug = Str::slug($title);
        $slug     = $baseSlug;
        $suffix = '';

        // Check in both: database and used slugs in memory
        while (Product::where('slug', $slug)->exists() || in_array($slug, $usedSlugs)) {
            $suffix .= '-';
            $slug = $baseSlug . $suffix;
        }

        $usedSlugs[] = $slug;

        return [
            'banner'              => 'backend/assets/images/products/sample-' . $this->faker->numberBetween(1, 5) . '.png',
            'product_category_id' => ProductCategory::inRandomOrder()->value('id'),
            'title'               => $title,
            'slug'                => $slug,
            'price'               => $this->faker->numberBetween(300, 15000),
            'stock_quantity'      => $this->faker->numberBetween(1, 500),
            'is_popular'          => 0,
            'description'         => $this->faker->paragraph(1),
            'short_description'   => $this->faker->sentence(30)
        ];
    }
}
