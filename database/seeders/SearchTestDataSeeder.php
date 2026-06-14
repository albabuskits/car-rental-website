<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\User;
use Carbon\Carbon;

class SearchTestDataSeeder extends Seeder
{
    public function run(): void
    {
        $extraCars = [
            ['brand' => 'مرسيدس-بنز', 'model' => 'E-Class 2023', 'year' => '2023', 'category' => 'luxury', 'transmission' => 'automatic', 'fuel_type' => 'diesel', 'seats' => 5, 'ac' => true, 'price_per_day' => 190, 'status' => 'available', 'description' => 'سيارة سيدان فاخرة بمحرك ديزل اقتصادي.'],
            ['brand' => 'بي إم دبليو', 'model' => 'X3', 'year' => '2023', 'category' => 'suv', 'transmission' => 'automatic', 'fuel_type' => 'gasoline', 'seats' => 5, 'ac' => true, 'price_per_day' => 170, 'status' => 'available', 'description' => 'سيارة دفع رباعي متوسطة الحجم.'],
            ['brand' => 'تويوتا', 'model' => 'كورولا', 'year' => '2024', 'category' => 'sedan', 'transmission' => 'automatic', 'fuel_type' => 'gasoline', 'seats' => 5, 'ac' => true, 'price_per_day' => 65, 'status' => 'available', 'description' => 'أكثر سيارة مبيعاً في العالم.'],
            ['brand' => 'فورد', 'model' => 'F-150', 'year' => '2024', 'category' => 'suv', 'transmission' => 'automatic', 'fuel_type' => 'diesel', 'seats' => 5, 'ac' => true, 'price_per_day' => 150, 'status' => 'available', 'description' => 'شاحنة بيك أب قوية.'],
            ['brand' => 'هيونداي', 'model' => 'سوناتا', 'year' => '2024', 'category' => 'sedan', 'transmission' => 'automatic', 'fuel_type' => 'gasoline', 'seats' => 5, 'ac' => true, 'price_per_day' => 70, 'status' => 'maintenance', 'description' => 'سيارة سيدان عصرية وموفرة.'],
            ['brand' => 'نيسان', 'model' => 'سنترا', 'year' => '2023', 'category' => 'economy', 'transmission' => 'manual', 'fuel_type' => 'gasoline', 'seats' => 5, 'ac' => true, 'price_per_day' => 45, 'status' => 'available', 'description' => 'سيارة اقتصادية مثالية للطلاب.'],
            ['brand' => 'لكزس', 'model' => 'ES 350', 'year' => '2024', 'category' => 'luxury', 'transmission' => 'automatic', 'fuel_type' => 'gasoline', 'seats' => 5, 'ac' => true, 'price_per_day' => 200, 'status' => 'available', 'description' => 'سيارة فاخرة هادئة ومريحة.'],
            ['brand' => 'شيفروليه', 'model' => 'ماليبو', 'year' => '2023', 'category' => 'sedan', 'transmission' => 'automatic', 'fuel_type' => 'gasoline', 'seats' => 5, 'ac' => true, 'price_per_day' => 60, 'status' => 'rented', 'description' => 'سيارة سيدان عائلية.'],
            ['brand' => 'أودي', 'model' => 'Q5', 'year' => '2024', 'category' => 'suv', 'transmission' => 'automatic', 'fuel_type' => 'diesel', 'seats' => 5, 'ac' => true, 'price_per_day' => 230, 'status' => 'available', 'description' => 'SUV فاخرة بتقنيات متطورة.'],
            ['brand' => 'هوندا', 'model' => 'أكورد', 'year' => '2024', 'category' => 'sedan', 'transmission' => 'automatic', 'fuel_type' => 'gasoline', 'seats' => 5, 'ac' => true, 'price_per_day' => 85, 'status' => 'available', 'description' => 'سيارة سيدان موثوقة وعملية.'],
            ['brand' => 'بورش', 'model' => '911 كاريرا', 'year' => '2024', 'category' => 'sports', 'transmission' => 'automatic', 'fuel_type' => 'gasoline', 'seats' => 2, 'ac' => true, 'price_per_day' => 500, 'status' => 'available', 'description' => 'سيارة رياضية أسطورية.'],
            ['brand' => 'كيا', 'model' => 'سيراتو', 'year' => '2023', 'category' => 'economy', 'transmission' => 'manual', 'fuel_type' => 'gasoline', 'seats' => 5, 'ac' => false, 'price_per_day' => 40, 'status' => 'available', 'description' => 'سيارة اقتصادية للاستخدام اليومي.'],
            ['brand' => 'ميتسوبيشي', 'model' => 'لانسر', 'year' => '2022', 'category' => 'economy', 'transmission' => 'manual', 'fuel_type' => 'gasoline', 'seats' => 5, 'ac' => true, 'price_per_day' => 45, 'status' => 'available', 'description' => 'سيارة متينة واقتصادية.'],
            ['brand' => 'رينو', 'model' => 'ميغان', 'year' => '2023', 'category' => 'sedan', 'transmission' => 'automatic', 'fuel_type' => 'diesel', 'seats' => 5, 'ac' => true, 'price_per_day' => 55, 'status' => 'available', 'description' => 'سيارة فرنسية بتصميم أنيق.'],
            ['brand' => 'جيب', 'model' => 'رانغلر', 'year' => '2024', 'category' => 'suv', 'transmission' => 'manual', 'fuel_type' => 'gasoline', 'seats' => 4, 'ac' => true, 'price_per_day' => 130, 'status' => 'available', 'description' => 'SUV للطرق الوعرة والمغامرات.'],
            ['brand' => 'تسلا', 'model' => 'Model 3', 'year' => '2024', 'category' => 'luxury', 'transmission' => 'automatic', 'fuel_type' => 'electric', 'seats' => 5, 'ac' => true, 'price_per_day' => 280, 'status' => 'available', 'description' => 'سيارة كهربائية فاخرة وصديقة للبيئة.'],
            ['brand' => 'فولكس واجن', 'model' => 'باسات', 'year' => '2023', 'category' => 'sedan', 'transmission' => 'automatic', 'fuel_type' => 'diesel', 'seats' => 5, 'ac' => true, 'price_per_day' => 75, 'status' => 'available', 'description' => 'سيارة سيدان ألمانية موثوقة.'],
            ['brand' => 'لاند روفر', 'model' => 'ديسكفري', 'year' => '2024', 'category' => 'suv', 'transmission' => 'automatic', 'fuel_type' => 'diesel', 'seats' => 7, 'ac' => true, 'price_per_day' => 300, 'status' => 'available', 'description' => 'SUV فاخرة للعائلة.'],
            ['brand' => 'مازدا', 'model' => 'CX-5', 'year' => '2024', 'category' => 'suv', 'transmission' => 'automatic', 'fuel_type' => 'gasoline', 'seats' => 5, 'ac' => true, 'price_per_day' => 110, 'status' => 'available', 'description' => 'SUV رياضية بتصميم جذاب.'],
            ['brand' => 'فيات', 'model' => '500', 'year' => '2023', 'category' => 'economy', 'transmission' => 'manual', 'fuel_type' => 'gasoline', 'seats' => 4, 'ac' => true, 'price_per_day' => 35, 'status' => 'available', 'description' => 'سيارة صغيرة مثالية للمدينة.'],
        ];

        foreach ($extraCars as $car) {
            Car::create($car);
        }

        $admin = User::where('email', 'admin@arhab.rentals')->first();

        $extraUsers = [
            ['name' => 'أحمد علي', 'email' => 'ahmed.ali@test.com', 'password' => bcrypt('password'), 'email_verified_at' => now()],
            ['name' => 'محمد عمر', 'email' => 'mohammed.omar@test.com', 'password' => bcrypt('password'), 'email_verified_at' => now()],
            ['name' => 'فاطمة الزهراء', 'email' => 'fatima@test.com', 'password' => bcrypt('password'), 'email_verified_at' => now()],
            ['name' => 'خالد أحمد', 'email' => 'khaled@test.com', 'password' => bcrypt('password'), 'email_verified_at' => now()],
            ['name' => 'سامي عبدالله', 'email' => 'sami@test.com', 'password' => bcrypt('password'), 'email_verified_at' => now()],
            ['name' => 'مريم حسن', 'email' => 'maryam@test.com', 'password' => bcrypt('password'), 'email_verified_at' => now()],
            ['name' => 'يوسف إبراهيم', 'email' => 'youssef@test.com', 'password' => bcrypt('password'), 'email_verified_at' => now()],
            ['name' => 'هدى سعيد', 'email' => 'huda@test.com', 'password' => bcrypt('password'), 'email_verified_at' => now()],
            ['name' => 'عبدالرحمن ناصر', 'email' => 'abdalrahman@test.com', 'password' => bcrypt('password'), 'email_verified_at' => now()],
            ['name' => 'نوال عبدالعزيز', 'email' => 'nawal@test.com', 'password' => bcrypt('password'), 'email_verified_at' => now()],
        ];

        $createdUsers = [];
        foreach ($extraUsers as $userData) {
            $user = User::create($userData);
            $user->assignRole('user');
            $createdUsers[] = $user;
        }

        $extraBookings = [
            ['user_id' => $createdUsers[0]->id, 'car_id' => 13, 'customer_name' => 'أحمد علي', 'customer_email' => 'ahmed.ali@test.com', 'customer_phone' => '+967711111111', 'pickup_date' => Carbon::now()->addDays(2), 'return_date' => Carbon::now()->addDays(5), 'total_price' => 195, 'status' => 'pending'],
            ['user_id' => $createdUsers[1]->id, 'car_id' => 14, 'customer_name' => 'محمد عمر', 'customer_email' => 'mohammed.omar@test.com', 'customer_phone' => '+967722222222', 'pickup_date' => Carbon::now()->addDays(1), 'return_date' => Carbon::now()->addDays(3), 'total_price' => 180, 'status' => 'confirmed'],
            ['user_id' => $createdUsers[2]->id, 'car_id' => 15, 'customer_name' => 'فاطمة الزهراء', 'customer_email' => 'fatima@test.com', 'customer_phone' => '+967733333333', 'pickup_date' => Carbon::now()->subDays(1), 'return_date' => Carbon::now()->addDays(2), 'total_price' => 300, 'status' => 'active'],
            ['user_id' => $createdUsers[3]->id, 'car_id' => 16, 'customer_name' => 'خالد أحمد', 'customer_email' => 'khaled@test.com', 'customer_phone' => '+967744444444', 'pickup_date' => Carbon::now()->subDays(5), 'return_date' => Carbon::now()->subDays(2), 'total_price' => 240, 'status' => 'completed'],
            ['user_id' => $createdUsers[4]->id, 'car_id' => 17, 'customer_name' => 'سامي عبدالله', 'customer_email' => 'sami@test.com', 'customer_phone' => '+967755555555', 'pickup_date' => Carbon::now()->addDays(3), 'return_date' => Carbon::now()->addDays(8), 'total_price' => 350, 'status' => 'pending'],
            ['user_id' => $admin->id, 'car_id' => 18, 'customer_name' => 'نوال عبدالعزيز', 'customer_email' => 'nawal@test.com', 'customer_phone' => '+967766666666', 'pickup_date' => Carbon::now()->addDays(4), 'return_date' => Carbon::now()->addDays(7), 'total_price' => 900, 'status' => 'pending'],
            ['user_id' => $admin->id, 'car_id' => 19, 'customer_name' => 'يوسف إبراهيم', 'customer_email' => 'youssef@test.com', 'customer_phone' => '+967777777777', 'pickup_date' => Carbon::now()->addDays(1), 'return_date' => Carbon::now()->addDays(4), 'total_price' => 330, 'status' => 'confirmed'],
            ['user_id' => $createdUsers[5]->id, 'car_id' => 20, 'customer_name' => 'مريم حسن', 'customer_email' => 'maryam@test.com', 'customer_phone' => '+967788888888', 'pickup_date' => Carbon::now()->subDays(3), 'return_date' => Carbon::now()->addDays(1), 'total_price' => 420, 'status' => 'active'],
            ['user_id' => $createdUsers[6]->id, 'car_id' => 21, 'customer_name' => 'يوسف إبراهيم', 'customer_email' => 'youssef@test.com', 'customer_phone' => '+967799999999', 'pickup_date' => Carbon::now()->subDays(7), 'return_date' => Carbon::now()->subDays(3), 'total_price' => 2000, 'status' => 'completed'],
            ['user_id' => $createdUsers[7]->id, 'car_id' => 22, 'customer_name' => 'هدى سعيد', 'customer_email' => 'huda@test.com', 'customer_phone' => '+967700000001', 'pickup_date' => Carbon::now()->addDays(5), 'return_date' => Carbon::now()->addDays(6), 'total_price' => 75, 'status' => 'pending'],
            ['user_id' => $createdUsers[8]->id, 'car_id' => 23, 'customer_name' => 'عبدالرحمن ناصر', 'customer_email' => 'abdalrahman@test.com', 'customer_phone' => '+967700000002', 'pickup_date' => Carbon::now()->addDays(2), 'return_date' => Carbon::now()->addDays(9), 'total_price' => 2100, 'status' => 'confirmed'],
            ['user_id' => $createdUsers[9]->id, 'car_id' => 24, 'customer_name' => 'نوال عبدالعزيز', 'customer_email' => 'nawal@test.com', 'customer_phone' => '+967700000003', 'pickup_date' => Carbon::now()->subDays(2), 'return_date' => Carbon::now()->addDays(3), 'total_price' => 275, 'status' => 'active'],
        ];

        foreach ($extraBookings as $booking) {
            Booking::create($booking);
        }

        $extraMessages = [
            ['name' => 'أحمد علي', 'email' => 'ahmed.ali@test.com', 'subject' => 'استفسار عن سيارة متاحة', 'message' => 'هل تتوفر سيارة مرسيدس E-Class في الأسبوع القادم؟', 'is_read' => false],
            ['name' => 'فاطمة الزهراء', 'email' => 'fatima@test.com', 'subject' => 'طلب تمديد الحجز', 'message' => 'أود تمديد حجزي للسيارة لمدة يومين إضافيين.', 'is_read' => false],
            ['name' => 'خالد أحمد', 'email' => 'khaled@test.com', 'subject' => 'شكر على الخدمة', 'message' => 'أشكركم على حسن التعامل والخدمة الممتازة.', 'is_read' => true],
            ['name' => 'سامي عبدالله', 'email' => 'sami@test.com', 'subject' => 'استفسار عن السعر', 'message' => 'هل يوجد خصم للحجوزات الطويلة الأجل (أكثر من أسبوعين)؟', 'is_read' => false],
            ['name' => 'مريم حسن', 'email' => 'maryam@test.com', 'subject' => 'مشكلة في التطبيق', 'message' => 'لا يمكنني تسجيل الدخول إلى حسابي عبر الجوال.', 'is_read' => false],
            ['name' => 'نوال عبدالعزيز', 'email' => 'nawal@test.com', 'subject' => 'اقتراح إضافة سيارات', 'message' => 'أقترح إضافة سيارات كهربائية مثل تيسلا إلى أسطولكم.', 'is_read' => true],
            ['name' => 'عبدالرحمن ناصر', 'email' => 'abdalrahman@test.com', 'subject' => 'طلب استرجاع مبلغ', 'message' => 'تم إلغاء حجزي وأود استرجاع المبلغ المدفوع.', 'is_read' => false],
            ['name' => 'هدى سعيد', 'email' => 'huda@test.com', 'subject' => 'استفسار عن التأمين', 'message' => 'هل السعر يشمل التأمين الشامل أم هناك رسوم إضافية؟', 'is_read' => false],
        ];

        foreach ($extraMessages as $message) {
            ContactMessage::create($message);
        }

        echo "تم إضافة " . count($extraCars) . " سيارة إضافية، " . count($extraUsers) . " مستخدم، " . count($extraBookings) . " حجز إضافي، و " . count($extraMessages) . " رسالة إضافية.\n";
    }
}
