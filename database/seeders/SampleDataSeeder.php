<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\User;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $cars = [
            ['brand' => 'مرسيدس-بنز', 'model' => 'S-Class 2024', 'year' => '2024', 'category' => 'luxury', 'transmission' => 'automatic', 'fuel_type' => 'gasoline', 'seats' => 5, 'ac' => true, 'price_per_day' => 250, 'status' => 'available', 'description' => 'سيارة فاخرة بتصميم أنيق ومقصورة داخلية مريحة.' ],
            ['brand' => 'بي إم دبليو', 'model' => 'X5', 'year' => '2024', 'category' => 'suv', 'transmission' => 'automatic', 'fuel_type' => 'diesel', 'seats' => 7, 'ac' => true, 'price_per_day' => 200, 'status' => 'available', 'description' => 'سيارة دفع رباعي فاخرة مناسبة للعائلة.' ],
            ['brand' => 'تويوتا', 'model' => 'كامري', 'year' => '2023', 'category' => 'sedan', 'transmission' => 'automatic', 'fuel_type' => 'gasoline', 'seats' => 5, 'ac' => true, 'price_per_day' => 80, 'status' => 'available', 'description' => 'سيارة سيدان اقتصادية وموثوقة.' ],
            ['brand' => 'فورد', 'model' => 'موستانغ', 'year' => '2024', 'category' => 'sports', 'transmission' => 'automatic', 'fuel_type' => 'gasoline', 'seats' => 4, 'ac' => true, 'price_per_day' => 180, 'status' => 'available', 'description' => 'سيارة رياضية بقوة عالية وأداء استثنائي.' ],
            ['brand' => 'هيونداي', 'model' => 'إلنترا', 'year' => '2023', 'category' => 'economy', 'transmission' => 'automatic', 'fuel_type' => 'gasoline', 'seats' => 5, 'ac' => true, 'price_per_day' => 55, 'status' => 'rented', 'description' => 'سيارة اقتصادية مثالية للتنقل اليومي.' ],
            ['brand' => 'نيسان', 'model' => 'باترول', 'year' => '2024', 'category' => 'suv', 'transmission' => 'automatic', 'fuel_type' => 'gasoline', 'seats' => 7, 'ac' => true, 'price_per_day' => 220, 'status' => 'maintenance', 'description' => 'سيارة دفع رباعي قوية للطرق الوعرة.' ],
            ['brand' => 'لكزس', 'model' => 'RX 350', 'year' => '2024', 'category' => 'luxury', 'transmission' => 'automatic', 'fuel_type' => 'gasoline', 'seats' => 5, 'ac' => true, 'price_per_day' => 190, 'status' => 'available', 'description' => 'سيارة فاخرة رياضية متعددة الاستخدامات.' ],
            ['brand' => 'شيفروليه', 'model' => 'تاهو', 'year' => '2023', 'category' => 'suv', 'transmission' => 'automatic', 'fuel_type' => 'gasoline', 'seats' => 8, 'ac' => true, 'price_per_day' => 160, 'status' => 'available', 'description' => 'سيارة عائلية كبيرة وواسعة.' ],
            ['brand' => 'أودي', 'model' => 'A6', 'year' => '2024', 'category' => 'luxury', 'transmission' => 'automatic', 'fuel_type' => 'gasoline', 'seats' => 5, 'ac' => true, 'price_per_day' => 210, 'status' => 'available', 'description' => 'سيارة سيدان فاخرة بتقنيات متطورة.' ],
            ['brand' => 'هوندا', 'model' => 'سيفيك', 'year' => '2023', 'category' => 'economy', 'transmission' => 'manual', 'fuel_type' => 'gasoline', 'seats' => 5, 'ac' => true, 'price_per_day' => 50, 'status' => 'available', 'description' => 'سيارة اقتصادية موفرة للوقود.' ],
            ['brand' => 'بورش', 'model' => 'كايين', 'year' => '2024', 'category' => 'sports', 'transmission' => 'automatic', 'fuel_type' => 'gasoline', 'seats' => 5, 'ac' => true, 'price_per_day' => 350, 'status' => 'rented', 'description' => 'سيارة رياضية فاخرة متعددة الاستخدامات.' ],
            ['brand' => 'كيا', 'model' => 'سبورتاج', 'year' => '2024', 'category' => 'suv', 'transmission' => 'automatic', 'fuel_type' => 'gasoline', 'seats' => 5, 'ac' => true, 'price_per_day' => 90, 'status' => 'available', 'description' => 'سيارة دفع رباعي متوسطة الحجم.' ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }

        $user = User::where('email', 'admin@arhab.rentals')->first();

        $bookings = [
            ['car_id' => 1, 'user_id' => $user->id, 'customer_name' => 'أحمد محمد', 'customer_email' => 'ahmed@example.com', 'customer_phone' => '+966501234567', 'pickup_date' => Carbon::now()->addDays(1), 'return_date' => Carbon::now()->addDays(4), 'total_price' => 750, 'status' => 'confirmed'],
            ['car_id' => 3, 'user_id' => $user->id, 'customer_name' => 'سارة خالد', 'customer_email' => 'sara@example.com', 'customer_phone' => '+966505678901', 'pickup_date' => Carbon::now()->addDays(2), 'return_date' => Carbon::now()->addDays(5), 'total_price' => 240, 'status' => 'pending'],
            ['car_id' => 7, 'user_id' => $user->id, 'customer_name' => 'فيصل العتيبي', 'customer_email' => 'faisal@example.com', 'customer_phone' => '+966501112233', 'pickup_date' => Carbon::now()->subDays(2), 'return_date' => Carbon::now()->addDays(2), 'total_price' => 760, 'status' => 'active'],
            ['car_id' => 2, 'user_id' => $user->id, 'customer_name' => 'نورة عبدالله', 'customer_email' => 'noura@example.com', 'customer_phone' => '+966504455667', 'pickup_date' => Carbon::now()->subDays(5), 'return_date' => Carbon::now()->subDays(1), 'total_price' => 800, 'status' => 'completed'],
            ['car_id' => 9, 'user_id' => $user->id, 'customer_name' => 'عمر الحارثي', 'customer_email' => 'omar@example.com', 'customer_phone' => '+966507788990', 'pickup_date' => Carbon::now()->addDays(3), 'return_date' => Carbon::now()->addDays(7), 'total_price' => 840, 'status' => 'pending'],
            ['car_id' => 5, 'user_id' => $user->id, 'customer_name' => 'ليلى الزهراني', 'customer_email' => 'layla@example.com', 'customer_phone' => '+966503322110', 'pickup_date' => Carbon::now()->subDays(3), 'return_date' => Carbon::now()->addDays(1), 'total_price' => 220, 'status' => 'active'],
        ];

        foreach ($bookings as $booking) {
            Booking::create($booking);
        }

        $messages = [
            ['name' => 'محمد القحطاني', 'email' => 'mohammed@example.com', 'subject' => 'استفسار عن الحجز', 'message' => 'السلام عليكم، أود الاستفسار عن إمكانية تمديد فترة الحجز للسيارة رقم 3 لمدة يومين إضافيين. هل هناك رسوم إضافية؟', 'is_read' => false],
            ['name' => 'نورة الدوسري', 'email' => 'noura.d@example.com', 'subject' => 'طلب سيارة خاصة', 'message' => 'أرغب في حجز سيارة فاخرة لمدة أسبوع في شهر يوليو القادم. هل تتوفر لديكم سيارة مرسيدس S-Class في تلك الفترة؟', 'is_read' => false],
            ['name' => 'خالد الشمري', 'email' => 'khalid@example.com', 'subject' => 'مشكلة في الدفع', 'message' => 'واجهت مشكلة أثناء عملية الدفع عبر الموقع. تم خصم المبلغ ولكن لم يتم تأكيد الحجز. أرجو التحقق من الأمر.', 'is_read' => true],
            ['name' => 'هند الغامدي', 'email' => 'hind@example.com', 'subject' => 'اقتراح تحسين', 'message' => 'أقترح إضافة خيار التأمين الشامل عند حجز السيارة ليكون متاحاً مباشرة من الموقع بدلاً من الاتصال بالدعم.', 'is_read' => false],
            ['name' => 'سعود الراشد', 'email' => 'saud@example.com', 'subject' => 'شكر وتقدير', 'message' => 'أشكركم على حسن التعامل والخدمة الممتازة. كانت تجربة تأجير السيارة رائعة وسأتعامل معكم مرة أخرى.', 'is_read' => true],
        ];

        foreach ($messages as $message) {
            ContactMessage::create($message);
        }

        echo "تم إضافة " . count($cars) . " سيارة، " . count($bookings) . " حجز، و " . count($messages) . " رسالة.\n";
    }
}
