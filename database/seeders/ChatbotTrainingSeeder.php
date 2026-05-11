<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class ChatbotTrainingSeeder extends Seeder
{
    public function run()
    {
        $faqs = [
            // Payment
            [
                'question' => 'How can I pay for the premium membership?',
                'answer' => 'You can pay securely using UPI (Google Pay, PhonePe, Paytm) or Direct Bank Transfer. Please visit the "Upgrade" page in your dashboard to see all available payment methods and bank details.'
            ],
            [
                'question' => 'What is the refund policy for payments?',
                'answer' => 'Payments made for premium memberships are generally non-refundable. However, if you face technical issues during payment, please contact our support team with your transaction ID for assistance.'
            ],
            // Membership
            [
                'question' => 'What are the benefits of Premium Membership?',
                'answer' => 'Premium members enjoy exclusive benefits: viewing contact numbers of profiles, initiating direct chats, unlimited interest requests, and advanced search filters to find highly compatible matches.'
            ],
            [
                'question' => 'How do I upgrade to a premium plan?',
                'answer' => 'To upgrade, click on the "Upgrade" or "Pricing" button in the menu. Choose your preferred plan and complete the payment process. Your account will be upgraded once the payment is verified.'
            ],
            // Login Issues
            [
                'question' => 'I am not receiving the OTP for login. What should I do?',
                'answer' => 'Please ensure you have entered the correct email address. Check your Spam or Junk folders. If the OTP does not arrive within 2 minutes, use the "Resend OTP" button. For further help, contact support@kasarsamaj.com.'
            ],
            [
                'question' => 'Why am I getting a "session expired" error during login?',
                'answer' => 'This usually happens if you wait too long to enter the OTP. Please refresh the page and request a new OTP to log in securely.'
            ],
            // Profile Issues
            [
                'question' => 'How can I edit my profile details?',
                'answer' => 'You can update your information at any time by navigating to "My Profile" in the top menu. Make your changes and click the "Save Profile" button at the bottom of the page.'
            ],
            [
                'question' => 'How do I upload or change my profile photo?',
                'answer' => 'Go to "My Profile" and look for the photo upload section. Select a clear, recent photo of yourself and click upload. Note: All photos are moderated for quality and guidelines before they become visible to others.'
            ],
            [
                'question' => 'Can I hide my profile from others temporarily?',
                'answer' => 'Yes, you can manage your profile visibility in the settings section of your profile page. You can choose to make your profile "Hidden" while you take a break.'
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(['question' => $faq['question']], $faq);
        }
    }
}
