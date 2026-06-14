<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Config;

class AdminSettings extends Component
{
    public $site_name = 'عرب لتأجير السيارات';
    public $contact_email = 'admin@arhab.rentals';
    public $contact_phone = '+1 (555) 012-3456';
    public $address = '';
    public $about_text = '';
    public $facebook_url = '';
    public $twitter_url = '';
    public $instagram_url = '';
    public $currency = 'USD';
    public $tax_rate = 0;
    public $booking_cancellation_hours = 24;

    protected $rules = [
        'site_name' => 'required|string|max:255',
        'contact_email' => 'required|email|max:255',
        'contact_phone' => 'nullable|string|max:50',
        'address' => 'nullable|string|max:500',
        'about_text' => 'nullable|string',
        'facebook_url' => 'nullable|url|max:500',
        'twitter_url' => 'nullable|url|max:500',
        'instagram_url' => 'nullable|url|max:500',
        'currency' => 'required|string|max:10',
        'tax_rate' => 'required|numeric|min:0|max:100',
        'booking_cancellation_hours' => 'required|integer|min:0',
    ];

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $this->site_name = config('app.name', 'عرب لتأجير السيارات');
        $this->contact_email = config('app.contact_email', 'admin@arhab.rentals');
        $this->contact_phone = config('app.contact_phone', '+1 (555) 012-3456');
        $this->address = config('app.address', '');
        $this->about_text = config('app.about_text', '');
        $this->facebook_url = config('app.facebook_url', '');
        $this->twitter_url = config('app.twitter_url', '');
        $this->instagram_url = config('app.instagram_url', '');
        $this->currency = config('app.currency', 'USD');
        $this->tax_rate = config('app.tax_rate', 0);
        $this->booking_cancellation_hours = config('app.booking_cancellation_hours', 24);
    }

    public function save()
    {
        $this->validate();

        $settings = [
            'APP_NAME' => '"' . $this->site_name . '"',
            'CONTACT_EMAIL' => $this->contact_email,
            'CONTACT_PHONE' => $this->contact_phone,
            'APP_ADDRESS' => $this->address,
            'APP_ABOUT' => $this->about_text,
            'FACEBOOK_URL' => $this->facebook_url,
            'TWITTER_URL' => $this->twitter_url,
            'INSTAGRAM_URL' => $this->instagram_url,
            'CURRENCY' => $this->currency,
            'TAX_RATE' => $this->tax_rate,
            'BOOKING_CANCEL_HOURS' => $this->booking_cancellation_hours,
        ];

        $envPath = base_path('.env');
        $content = file_get_contents($envPath);

        foreach ($settings as $key => $value) {
            if (str_contains($content, $key . '=')) {
                $content = preg_replace(
                    '/^' . $key . '=.*$/m',
                    $key . '=' . $value,
                    $content
                );
            } else {
                $content .= PHP_EOL . $key . '=' . $value;
            }
        }

        file_put_contents($envPath, $content);

        $this->loadSettings();
        session()->flash('message', 'تم حفظ الإعدادات بنجاح.');
    }

    public function render()
    {
        return view('livewire.admin-settings');
    }
}
