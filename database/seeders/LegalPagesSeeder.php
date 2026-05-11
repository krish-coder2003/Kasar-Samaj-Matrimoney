<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class LegalPagesSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            'privacy-policy' => "Privacy Policy for Kasar Samaj Matrimony\n\nAt Kasar Samaj Matrimony, we take your privacy seriously. This policy describes how we collect, use, and protect your personal information.\n\n1. Information Collection\nWe collect information you provide during registration, including name, email, DOB, and profile details.\n\n2. Use of Information\nYour information is used to match you with potential partners within the community.\n\n3. Data Security\nWe implement industry-standard security measures to protect your data.",
            
            'terms-of-use' => "Terms of Use for Kasar Samaj Matrimony\n\nBy using our service, you agree to these terms:\n\n1. Eligibility\nYou must be at least 18 years old to register.\n\n2. Content Responsibility\nYou are responsible for the accuracy of your profile information.\n\n3. Prohibited Conduct\nHarassment or fraudulent activity is strictly prohibited and will lead to account termination.",
            
            'cookie-policy' => "Cookie Policy\n\nWe use cookies to improve your experience on our site.\n\n1. What are cookies?\nCookies are small text files stored on your device.\n\n2. How we use them\nWe use them for authentication and to remember your preferences.\n\n3. Managing cookies\nYou can disable cookies in your browser settings, but some features may not work correctly.",
            
            'safety-tips' => "Safety Tips for Online Matchmaking\n\nYour safety is our priority. Please follow these guidelines:\n\n1. Protect Your Identity\nDo not share financial information or home addresses early in the conversation.\n\n2. Meet in Public\nWhen meeting someone for the first time, choose a busy public place.\n\n3. Inform Someone\nAlways let a friend or family member know where you are going.",
            
            'help-center' => "Help Center\n\nWelcome to the Kasar Samaj Matrimony Help Center. Here you can find answers to common questions.\n\nIf you need further assistance, please contact our support team at support@kasarsamaj.com.\n\nYou can also use our automated assistant located at the bottom right of this page for instant answers."
        ];

        foreach ($pages as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
