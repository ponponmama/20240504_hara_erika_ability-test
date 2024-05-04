<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\Contact;
use App\Models\Category;


class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = \Faker\Factory::create('ja_JP');
        $faker->addProvider(new \Faker\Provider\ja_JP\Person($faker));

        $category_id = Category::all()->random()->id;
        $detail = '';

        switch ($category_id) {
        case 1:
            $detail = '商品が届かないです。確認よろしくお願いします。';
            break;
        case 2:
            $detail = '商品が壊れていました。新しいものに交換してください';
            break;
        case 3:
            $detail = '商品の電源が入りません。対応お願いします。';
            break;
        case 4:
            $detail = '営業時間と定休日はどうなっていますか？';
            break;
        case 5:
            $detail = 'こんな商品のお取り扱いは無いでしょうか？';
            break;
    }

        return [
            'category_id' => $category_id,
            'first_name' => $faker->lastName,
            'last_name' => $faker->firstName,
            'gender' => $faker->randomElement([1, 2, 3]),
            'email' => $faker->safeEmail,
            'tell' => $faker->phoneNumber,
            'address' => $faker->address,
            'building' => $faker->secondaryAddress(),
            'detail' => $detail,
            'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}