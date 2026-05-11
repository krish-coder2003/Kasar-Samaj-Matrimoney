<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        $titleMap = [
            'privacy-policy' => 'Privacy Policy',
            'terms-of-use' => 'Terms of Use',
            'cookie-policy' => 'Cookie Policy',
            'safety-tips' => 'Safety Tips',
            'help-center' => 'Help Center',
            'refund-policy' => 'Refund Policy'
        ];

        if (!isset($titleMap[$slug])) {
            abort(404);
        }

        $title = $titleMap[$slug];
        $content = Setting::get($slug, "Content for $title is coming soon...");
        $faqs = [];

        if ($slug === 'help-center') {
            $faqs = \App\Models\Faq::all();
        }

        return view('pages.show', compact('title', 'content', 'faqs'));
    }

    public function chatbotAnswer(Request $request)
    {
        $query = strtolower($request->query('q', ''));
        if (empty($query))
            return response()->json(['answer' => 'How can I help you today?']);

        $faqs = \App\Models\Faq::all();
        $bestMatch = null;
        $highestScore = 0;

        foreach ($faqs as $faq) {
            $score = 0;
            $question = strtolower($faq->question);

            // Simple keyword matching
            $words = explode(' ', $query);
            foreach ($words as $word) {
                if (strlen($word) > 3 && str_contains($question, $word)) {
                    $score++;
                }
            }

            if ($score > $highestScore) {
                $highestScore = $score;
                $bestMatch = $faq;
            }
        }

        if ($bestMatch && $highestScore > 0) {
            return response()->json(['answer' => $bestMatch->answer]);
        }

        return response()->json(['answer' => "I'm sorry, I couldn't find a specific answer for that. You can try asking about 'registration', 'payment', or 'premium membership'. Alternatively, please contact our support team at support@kasarsamaj.com"]);
    }
}
