<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductFaq;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Yuvar Dhan Ashwagandha Gold KSM-66',
                'price' => 1499.0,
                'original_price' => 1999.0,
                'discount' => '25% OFF',
                'stock' => 85,
                'photo' => 'image/products/product-1.jpg',
                'badge' => 'NATURAL',
                'detail' => 'Premium full-spectrum organic root extract designed to boost physical vitality, reduce stress, and enhance muscle endurance. Enhanced with BioPerine for maximum bioavailability.',
                'how_to_use' => 'Take 1 to 2 capsules twice daily with warm milk or warm water, preferably 30 minutes after your morning and evening meals.',
                'how_to_use_steps' => [
                    [
                        'step_number' => '01',
                        'title' => 'Dosage & Measure',
                        'description' => 'Take 1 to 2 vegetarian capsules daily based on your body constitution and physical activity goals.',
                        'timing' => 'Twice Daily',
                        'icon' => 'bi-capsule',
                    ],
                    [
                        'step_number' => '02',
                        'title' => 'Ideal Vehicle (Anupana)',
                        'description' => 'Consume with a cup of warm organic milk, almond milk, or lukewarm water for optimum adaptogenic uptake.',
                        'timing' => '30 Mins After Meals',
                        'icon' => 'bi-cup-hot',
                    ],
                    [
                        'step_number' => '03',
                        'title' => 'Consistent Cycle',
                        'description' => 'Incorporate consistently for 60 to 90 consecutive days to experience peak stamina, cortisol balance, and vitality.',
                        'timing' => '60-90 Days Cycle',
                        'icon' => 'bi-calendar-check',
                    ],
                    [
                        'step_number' => '04',
                        'title' => 'Synergistic Lifestyle',
                        'description' => 'Pair with 7-8 hours of sound sleep, adequate hydration, and moderate strength training or yoga.',
                        'timing' => 'Daily Wellness',
                        'icon' => 'bi-heart-pulse',
                    ],
                ],
                'meta_title' => 'Buy Organic Ashwagandha Gold KSM-66 | Yuvar Dhan Strength',
                'meta_detail' => 'Pure Ayurvedic KSM-66 Ashwagandha extract with standard 5% withanolides for peak stamina, stress relief, and hormonal vitality.',
                'og_image' => 'image/products/product-1.jpg',
                'rating' => 5.0,
                'reviews_count' => 240,
                'faqs' => [
                    [
                        'question' => 'What makes KSM-66 Ashwagandha superior to regular Ashwagandha?',
                        'answer' => 'KSM-66 is the highest concentration full-spectrum root extract available today. It is produced using a certified solvent-free "Green Chemistry" process that preserves both hydrophilic and lipophilic components of the raw root without using synthetic alcohol.',
                    ],
                    [
                        'question' => 'How soon can I expect to feel noticeable results?',
                        'answer' => 'Many individuals report a calming effect on daily stress and improved sleep quality within the first 1-2 weeks. Optimal improvements in strength, stamina, and endocrine balance generally culminate over 6 to 8 weeks of consistent daily usage.',
                    ],
                    [
                        'question' => 'Can both men and women take Yuvar Dhan Ashwagandha Gold?',
                        'answer' => 'Yes, absolutely. Ashwagandha is an adaptogen suitable for both men and women to balance cortisol, boost energy metabolism, improve sleep quality, and foster inner vitality.',
                    ],
                    [
                        'question' => 'Is it safe to consume long-term?',
                        'answer' => 'Yes, our formulation is 100% natural, third-party lab tested for heavy metals, and free of artificial additives or steroids. We recommend a 90-day cycle followed by a 1-2 week break before resuming.',
                    ],
                ],
            ],
            [
                'name' => 'Yuvar Dhan Himalayan Detox Elixir',
                'price' => 899.0,
                'original_price' => 1199.0,
                'discount' => '25% OFF',
                'stock' => 42,
                'photo' => 'image/products/product-2.jpg',
                'badge' => '100% PURE',
                'detail' => 'Handcrafted botanical blend of holy tulsi, lemongrass, and antioxidant herbs for cellular rejuvenation and daily detox.',
                'how_to_use' => 'Steep 1 teaspoon (or 1 infusion bag) in 200ml freshly boiled water for 4-5 minutes. Sip warm in the morning on an empty stomach.',
                'how_to_use_steps' => [
                    [
                        'step_number' => '01',
                        'title' => 'Boil Pure Water',
                        'description' => 'Bring 200ml of filtered water to a gentle rolling boil in a clean stainless steel kettle.',
                        'timing' => 'Freshly Boiled',
                        'icon' => 'bi-fire',
                    ],
                    [
                        'step_number' => '02',
                        'title' => 'Steep Botanicals',
                        'description' => 'Add 1 teaspoon of blend or 1 pyramid bag. Cover and let steep for 4 to 5 minutes to release active essential oils.',
                        'timing' => '4-5 Minutes Steep',
                        'icon' => 'bi-hourglass-split',
                    ],
                    [
                        'step_number' => '03',
                        'title' => 'Morning Cleanse Ritual',
                        'description' => 'Sip warm on an empty stomach immediately upon waking to ignite your digestive fire (Agni).',
                        'timing' => 'Morning Fasting',
                        'icon' => 'bi-sun',
                    ],
                    [
                        'step_number' => '04',
                        'title' => 'Hydration Continuity',
                        'description' => 'Drink at least 2.5 liters of clean water throughout the day to facilitate cellular toxin flush.',
                        'timing' => 'Throughout Day',
                        'icon' => 'bi-droplet-half',
                    ],
                ],
                'meta_title' => 'Himalayan Herbal Detox Elixir Tea | Yuvar Dhan Wellness',
                'meta_detail' => 'Purifying whole-body detox infusion formulated from pure Himalayan herbs for liver wellness and gut harmony.',
                'og_image' => 'image/products/product-2.jpg',
                'rating' => 4.8,
                'reviews_count' => 135,
                'faqs' => [
                    [
                        'question' => 'Does this detox blend contain caffeine or senna leaves?',
                        'answer' => 'No. Our Himalayan Detox Elixir is 100% caffeine-free and contains zero harsh laxatives like senna. It uses gentle Ayurvedic detoxifiers like Tulsi, Lemongrass, and Ginger.',
                    ],
                    [
                        'question' => 'Can I drink this multiple times a day?',
                        'answer' => 'Yes, you may enjoy 1-2 cups daily—one in the early morning and another in the late afternoon to refresh your mind and digestion.',
                    ],
                ],
            ],
            [
                'name' => 'Yuvar Dhan 24K Saffron Radiance Elixir',
                'price' => 2499.0,
                'original_price' => 3299.0,
                'discount' => '24% OFF',
                'stock' => 18,
                'photo' => 'image/products/product-3.jpg',
                'badge' => 'PREMIUM',
                'detail' => 'Sacred facial and skin radiance elixir formulated with pure Kashmiri saffron, sandalwood, and lotus blossoms.',
                'how_to_use' => 'Cleanse face thoroughly. Apply 3-4 drops onto damp facial skin and gently massage in upward circular motions before bedtime.',
                'how_to_use_steps' => [
                    [
                        'step_number' => '01',
                        'title' => 'Purify Skin',
                        'description' => 'Wash your face with a mild soap-free cleanser and pat dry, leaving skin slightly damp.',
                        'timing' => 'Evening Cleansing',
                        'icon' => 'bi-droplet',
                    ],
                    [
                        'step_number' => '02',
                        'title' => 'Dispense Drops',
                        'description' => 'Dispense 3 to 4 drops of golden nectar onto your clean fingertips or palms.',
                        'timing' => '3-4 Drops',
                        'icon' => 'bi-eyedropper',
                    ],
                    [
                        'step_number' => '03',
                        'title' => 'Vedic Facial Massage',
                        'description' => 'Gently press and massage in rhythmic upward circular strokes across cheekbones, forehead, and neck.',
                        'timing' => '2-3 Minutes',
                        'icon' => 'bi-stars',
                    ],
                    [
                        'step_number' => '04',
                        'title' => 'Overnight Nourishment',
                        'description' => 'Leave on overnight to let precious saffron carotenoids and 24K micro-nutrients deeply restore skin cells.',
                        'timing' => 'Nightly Sleep',
                        'icon' => 'bi-moon-stars',
                    ],
                ],
                'meta_title' => 'Kumkumadi 24K Saffron Face Elixir | Yuvar Dhan Ayurveda',
                'meta_detail' => 'Luxury Ayurvedic facial oil with authentic Kashmiri saffron and 24K gold essence for radiant, luminous skin.',
                'og_image' => 'image/products/product-3.jpg',
                'rating' => 5.0,
                'reviews_count' => 310,
                'faqs' => [
                    [
                        'question' => 'Is this elixir suitable for oily or acne-prone skin?',
                        'answer' => 'Yes. The lightweight sesame and sandalwood botanical base is non-comedogenic and absorbs quickly without leaving a greasy residue.',
                    ],
                    [
                        'question' => 'Is real 24K gold and Kashmiri saffron used in this formulation?',
                        'answer' => 'Yes, we source authentic Grade-A Kashmiri Mogra Saffron and genuine 24K micro-gold bhasma following classical Kumkumadi Tailam preparation methods.',
                    ],
                ],
            ],
            [
                'name' => 'Yuvar Dhan Triphala Gut Vitality',
                'price' => 799.0,
                'original_price' => 999.0,
                'discount' => '20% OFF',
                'stock' => 94,
                'photo' => 'image/products/product-4.jpg',
                'badge' => 'VITALITY',
                'detail' => 'Time-tested three-fruit botanical formula supporting digestion, nutrient absorption, and body purification.',
                'how_to_use' => 'Take 1 to 2 tablets with a glass of lukewarm water at night before going to bed.',
                'how_to_use_steps' => [
                    [
                        'step_number' => '01',
                        'title' => 'Bedtime Dosage',
                        'description' => 'Take 1 to 2 tablets with a full glass of lukewarm water right before sleeping.',
                        'timing' => 'Before Bedtime',
                        'icon' => 'bi-capsule-pill',
                    ],
                    [
                        'step_number' => '02',
                        'title' => 'Warm Water Vehicle',
                        'description' => 'Always drink with warm or room-temperature water to activate the digestive trifecta.',
                        'timing' => 'Lukewarm Water',
                        'icon' => 'bi-cup',
                    ],
                    [
                        'step_number' => '03',
                        'title' => 'Gentle Morning Relief',
                        'description' => 'Promotes regular, effortless bowel movements without cramping or electrolyte depletion.',
                        'timing' => 'Morning Awakening',
                        'icon' => 'bi-emoji-smile',
                    ],
                    [
                        'step_number' => '04',
                        'title' => 'Continuous Gut Nourishment',
                        'description' => 'Safe for daily use over 3-6 months to tone the intestinal walls and promote friendly microbiome balance.',
                        'timing' => 'Long-Term Health',
                        'icon' => 'bi-shield-check',
                    ],
                ],
                'meta_title' => 'Organic Triphala Gut Cleanse & Digestion | Yuvar Dhan',
                'meta_detail' => 'Traditional Haritaki, Bibhitaki, and Amalaki formulation for optimal digestive balance and gentle overnight detox.',
                'og_image' => 'image/products/product-4.jpg',
                'rating' => 4.7,
                'reviews_count' => 95,
                'faqs' => [
                    [
                        'question' => 'Is Triphala habit-forming like synthetic laxatives?',
                        'answer' => 'No. Triphala is a nourishing Ayurvedic Rasayana that tones and strengthens the colon muscles rather than forcing contractions, making it non-habit-forming.',
                    ],
                ],
            ],
            [
                'name' => 'Yuvar Dhan Brahmi Mind Focus Tonic',
                'price' => 1199.0,
                'original_price' => 1599.0,
                'discount' => '25% OFF',
                'stock' => 60,
                'photo' => 'image/products/product-5.jpg',
                'badge' => 'STRENGTH',
                'detail' => 'Cognitive enhancement formulation supporting peak memory clarity, sharp focus, and nervous system health.',
                'how_to_use' => 'Take 1 capsule twice daily after meals with water or a spoonful of organic ghee for cognitive enhancement.',
                'how_to_use_steps' => [
                    [
                        'step_number' => '01',
                        'title' => 'Single / Double Dose',
                        'description' => 'Take 1 capsule in the morning and 1 capsule in the early evening with water.',
                        'timing' => 'Morning & Afternoon',
                        'icon' => 'bi-brain',
                    ],
                    [
                        'step_number' => '02',
                        'title' => 'Ghee Synergy (Optional)',
                        'description' => 'Taking with half a teaspoon of pure cow ghee enhances lipid-soluble brain barrier transport.',
                        'timing' => 'Ayurvedic Carrier',
                        'icon' => 'bi-award',
                    ],
                    [
                        'step_number' => '03',
                        'title' => 'Focus & Meditation',
                        'description' => 'Ideal for professionals, students, and meditators seeking sharp retention and nervous tranquility.',
                        'timing' => 'Daily Routine',
                        'icon' => 'bi-lightning',
                    ],
                    [
                        'step_number' => '04',
                        'title' => 'Neuro-Protection',
                        'description' => 'Consistent usage over 90 days enhances bacosides concentrations for enduring memory clarity.',
                        'timing' => '90 Days Protocol',
                        'icon' => 'bi-patch-check',
                    ],
                ],
                'meta_title' => 'Brahmi Mind Memory & Focus Formulation | Yuvar Dhan',
                'meta_detail' => 'Ayurvedic nootropic tonic with pure Bacopa Monnieri for enhanced cognitive power and serene mental clarity.',
                'og_image' => 'image/products/product-5.jpg',
                'rating' => 4.9,
                'reviews_count' => 160,
                'faqs' => [
                    [
                        'question' => 'Does this contain stimulants like caffeine?',
                        'answer' => 'No. It is 100% caffeine-free and free of synthetic stimulants. It calms the nervous system while heightening mental alertness naturally.',
                    ],
                ],
            ],
            [
                'name' => 'Yuvar Dhan Turmeric Curcumin 95%',
                'price' => 1299.0,
                'original_price' => 1699.0,
                'discount' => '23% OFF',
                'stock' => 75,
                'photo' => 'image/products/product-6.jpg',
                'badge' => 'IMMUNITY',
                'detail' => 'Ultra-potent golden turmeric extract formulated with BioPerine for joint flexibility, vitality, and robust immunity.',
                'how_to_use' => 'Take 1 capsule daily with a meal containing healthy fats or with a cup of warm golden milk.',
                'how_to_use_steps' => [
                    [
                        'step_number' => '01',
                        'title' => 'Single Daily Capsule',
                        'description' => 'Take 1 capsule daily with your most substantial meal of the day.',
                        'timing' => 'Once Daily',
                        'icon' => 'bi-capsule',
                    ],
                    [
                        'step_number' => '02',
                        'title' => 'Dietary Fats Absorption',
                        'description' => 'Consume alongside healthy fats (avocado, coconut oil, ghee) for superior bioavailability.',
                        'timing' => 'With Food',
                        'icon' => 'bi-egg-fried',
                    ],
                    [
                        'step_number' => '03',
                        'title' => 'Joint & Cellular Harmony',
                        'description' => 'Experience improved joint ease, post-workout recovery, and robust seasonal immunity.',
                        'timing' => 'Daily Protection',
                        'icon' => 'bi-shield-plus',
                    ],
                    [
                        'step_number' => '04',
                        'title' => 'Inflammation Balance',
                        'description' => 'Continue for at least 60 days to stabilize whole-body inflammatory response.',
                        'timing' => '60 Days Cleanse',
                        'icon' => 'bi-activity',
                    ],
                ],
                'meta_title' => 'Pure Curcumin 95% Joint & Immune Support | Yuvar Dhan',
                'meta_detail' => 'Standardized 95% curcuminoids extract for healthy inflammatory response and joint comfort.',
                'og_image' => 'image/products/product-6.jpg',
                'rating' => 4.9,
                'reviews_count' => 215,
                'faqs' => [
                    [
                        'question' => 'Why is BioPerine black pepper extract included?',
                        'answer' => 'Curcumin alone is poorly absorbed by the human body. BioPerine (standardized black pepper extract) is clinically proven to boost curcumin absorption by up to 2000%.',
                    ],
                ],
            ],
            [
                'name' => 'Yuvar Dhan Neem & Tulsi Purifying Cleanse',
                'price' => 699.0,
                'original_price' => 899.0,
                'discount' => '22% OFF',
                'stock' => 50,
                'photo' => 'image/products/product-7.jpg',
                'badge' => 'WELLNESS',
                'detail' => 'Gentle soap-free foaming wash that balances natural skin oils and deeply purifies pores with sacred botanicals.',
                'how_to_use' => 'Dispense a coin-sized amount on wet palms, lather gently over wet face in circular motion for 60 seconds, then rinse with cool water.',
                'how_to_use_steps' => [
                    [
                        'step_number' => '01',
                        'title' => 'Wet Face with Lukewarm Water',
                        'description' => 'Splash your face with lukewarm water to open skin pores gently.',
                        'timing' => 'Morning & Night',
                        'icon' => 'bi-droplet',
                    ],
                    [
                        'step_number' => '02',
                        'title' => 'Lather Gently',
                        'description' => 'Work a small coin-sized drop into a rich herbal lather using your palms.',
                        'timing' => 'Coin Size',
                        'icon' => 'bi-hand-index-thumb',
                    ],
                    [
                        'step_number' => '03',
                        'title' => '60-Second Cleanse',
                        'description' => 'Massage gently over face and T-zone for 60 seconds, avoiding direct contact with eyes.',
                        'timing' => '60 Seconds',
                        'icon' => 'bi-stopwatch',
                    ],
                    [
                        'step_number' => '04',
                        'title' => 'Rinse & Pat Dry',
                        'description' => 'Rinse thoroughly with cool water to close pores and pat dry with a clean towel.',
                        'timing' => 'Cool Water Rinse',
                        'icon' => 'bi-check2-circle',
                    ],
                ],
                'meta_title' => 'Neem & Tulsi Herbal Clarifying Face Wash | Yuvar Dhan',
                'meta_detail' => 'Antibacterial botanical face wash enriched with organic Neem and holy Tulsi for blemish-free skin.',
                'og_image' => 'image/products/product-7.jpg',
                'rating' => 4.8,
                'reviews_count' => 112,
                'faqs' => [
                    [
                        'question' => 'Does this cleanser dry out the skin?',
                        'answer' => 'No. Our formula is sulfate-free, paraben-free, and contains pure aloe vera base to hydrate while neem purifies.',
                    ],
                ],
            ],
            [
                'name' => 'Yuvar Dhan Cold-Pressed Sweet Almond Oil',
                'price' => 999.0,
                'original_price' => 1299.0,
                'discount' => '23% OFF',
                'stock' => 35,
                'photo' => 'image/products/product-8.jpg',
                'badge' => 'COLD PRESSED',
                'detail' => '100% unrefined therapeutic oil rich in natural Vitamin E, perfect for restorative body massage and muscle recovery.',
                'how_to_use' => 'Warm a small quantity between your palms and massage onto scalp, body (Abhyanga), or facial skin until absorbed.',
                'how_to_use_steps' => [
                    [
                        'step_number' => '01',
                        'title' => 'Warm the Oil',
                        'description' => 'Pour 1-2 tablespoons into a small bowl and gently warm it in a hot water bath.',
                        'timing' => 'Gentle Warmth',
                        'icon' => 'bi-fire',
                    ],
                    [
                        'step_number' => '02',
                        'title' => 'Abhyanga Massage',
                        'description' => 'Apply onto body in long strokes on limbs and circular strokes on joints and abdomen.',
                        'timing' => 'Before Bathing',
                        'icon' => 'bi-heart-pulse',
                    ],
                    [
                        'step_number' => '03',
                        'title' => 'Deep Tissue Penetration',
                        'description' => 'Leave on for 15-20 minutes to allow natural Vitamin E and magnesium to penetrate tissues.',
                        'timing' => '15-20 Minutes',
                        'icon' => 'bi-clock',
                    ],
                    [
                        'step_number' => '04',
                        'title' => 'Warm Water Shower',
                        'description' => 'Rinse with a warm shower to feel energized, supple, and completely refreshed.',
                        'timing' => 'Post-Massage Wash',
                        'icon' => 'bi-water',
                    ],
                ],
                'meta_title' => '100% Pure Cold-Pressed Sweet Almond Oil | Yuvar Dhan',
                'meta_detail' => 'Virgin almond oil for deep skin nourishment, hair vitality, and therapeutic Abhyanga body massage.',
                'og_image' => 'image/products/product-8.jpg',
                'rating' => 4.9,
                'reviews_count' => 180,
                'faqs' => [
                    [
                        'question' => 'Is this sweet almond oil 100% edible and skin safe?',
                        'answer' => 'Yes, it is cold-pressed from sweet Mamra almonds without hexane, additives, or mineral oil, making it both cosmetic and food grade.',
                    ],
                ],
            ],
        ];

        // Also define some general brand FAQs (storewide FAQs with product_id = null)
        $storewideFaqs = [
            [
                'question' => 'Are all Yuvar Dhan products 100% natural and vegetarian?',
                'answer' => 'Yes! Every Yuvar Dhan formulation is 100% natural, vegetarian, free from synthetic preservatives, artificial colors, parabens, and GMO ingredients.',
                'sort_order' => 1,
            ],
            [
                'question' => 'Are Yuvar Dhan formulations tested by third-party laboratories?',
                'answer' => 'Yes. Each production batch undergoes rigorous third-party testing for active bio-marker potencies, heavy metals (Lead, Mercury, Arsenic), microbiological safety, and pesticide residues.',
                'sort_order' => 2,
            ],
            [
                'question' => 'What is the standard shipping and delivery timeline?',
                'answer' => 'We dispatch all orders within 24 hours of placement. Metro cities typically receive deliveries within 2 to 3 business days, while all other locations across India receive delivery within 3 to 5 business days.',
                'sort_order' => 3,
            ],
            [
                'question' => 'What is your 30-day money-back guarantee policy?',
                'answer' => 'We stand firmly behind our Vedic formulations. If you are not satisfied with your experience, contact our customer support team within 30 days of delivery for an effortless return and refund.',
                'sort_order' => 4,
            ],
        ];

        // Seed products and their specific FAQs
        foreach ($products as $data) {
            $faqs = $data['faqs'] ?? [];
            unset($data['faqs']);

            // Update existing or create new product by name
            $product = Product::updateOrCreate(
                ['name' => $data['name']],
                $data
            );

            // Clean up and seed FAQs for this product
            $product->faqs()->delete();
            $sort = 1;
            foreach ($faqs as $faq) {
                ProductFaq::create([
                    'product_id' => $product->id,
                    'question' => $faq['question'],
                    'answer' => $faq['answer'],
                    'sort_order' => $sort++,
                    'is_active' => true,
                ]);
            }
        }

        // Seed storewide FAQs (product_id = null)
        ProductFaq::whereNull('product_id')->delete();
        foreach ($storewideFaqs as $storeFaq) {
            ProductFaq::create([
                'product_id' => null,
                'question' => $storeFaq['question'],
                'answer' => $storeFaq['answer'],
                'sort_order' => $storeFaq['sort_order'],
                'is_active' => true,
            ]);
        }
    }
}
