<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Initiate payment by creating a Razorpay order.
     */
    public function initiatePayment(Request $request)
    {
        $user = Auth::user();
        if ($user->is_premium) {
            return redirect()->route('home')->with('info', 'You are already a premium member.');
        }

        $price = Setting::get('gold_plan_price', 1000);

        // Check for an existing pending transaction to prevent duplicate entries
        $existingPayment = Payment::where('user_id', $user->id)
            ->where('plan_name', 'Gold Plan')
            ->where('amount', $price)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if ($existingPayment && !empty($existingPayment->razorpay_order_id)) {
            return redirect()->route('payment.checkout', $existingPayment->id);
        }

        $keyId = config('services.razorpay.key_id') ?: env('RAZORPAY_KEY_ID');
        $keySecret = config('services.razorpay.key_secret') ?: env('RAZORPAY_KEY_SECRET');

        if (empty($keyId) || empty($keySecret)) {
            Log::error('Razorpay credentials are not configured in environment variables.');
            return back()->with('error', 'Razorpay payment gateway is not configured correctly. Please contact support.');
        }

        try {
            // Amount in paise
            $amountInPaise = intval($price * 100);

            $response = Http::withBasicAuth($keyId, $keySecret)
                ->timeout(10)
                ->post('https://api.razorpay.com/v1/orders', [
                    'amount' => $amountInPaise,
                    'currency' => 'INR',
                    'receipt' => 'rcpt_' . $user->id . '_' . time(),
                    'payment_capture' => 1 // Auto-capture payments
                ]);

            if ($response->successful()) {
                $orderData = $response->json();
                $razorpayOrderId = $orderData['id'];

                $payment = Payment::create([
                    'user_id' => $user->id,
                    'plan_name' => 'Gold Plan',
                    'amount' => $price,
                    'currency' => 'INR',
                    'razorpay_order_id' => $razorpayOrderId,
                    'status' => 'pending',
                ]);

                return redirect()->route('payment.checkout', $payment->id);
            } else {
                Log::error('Razorpay Order API Failed: ' . $response->body());
                return back()->with('error', 'Failed to communicate with Razorpay. Message: ' . ($response->json('error.description') ?? 'Unknown Error'));
            }
        } catch (\Exception $e) {
            Log::error('Razorpay Checkout exception: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong while initiating the payment. Please try again.');
        }
    }

    /**
     * Show the Razorpay Checkout form.
     */
    public function checkout(Payment $payment)
    {
        // Ensure user is authorized
        if ($payment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized transaction access.');
        }

        if ($payment->status === 'completed') {
            return redirect()->route('home')->with('success', 'Payment was already successfully completed.');
        }

        $keyId = config('services.razorpay.key_id') ?: env('RAZORPAY_KEY_ID');

        return view('profile.checkout', compact('payment', 'keyId'));
    }

    /**
     * Verify the Razorpay payment signature.
     */
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $razorpayPaymentId = $request->razorpay_payment_id;
        $razorpayOrderId = $request->razorpay_order_id;
        $razorpaySignature = $request->razorpay_signature;

        $payment = Payment::where('razorpay_order_id', $razorpayOrderId)->first();

        if (!$payment) {
            return redirect()->route('plans')->with('error', 'Payment transaction order record not found.');
        }

        $keySecret = config('services.razorpay.key_secret') ?: env('RAZORPAY_KEY_SECRET');

        // Verify Razorpay signature using HMAC SHA256
        $expectedSignature = hash_hmac('sha256', $razorpayOrderId . '|' . $razorpayPaymentId, $keySecret);

        if (hash_equals($expectedSignature, $razorpaySignature)) {
            // Success
            $payment->update([
                'razorpay_payment_id' => $razorpayPaymentId,
                'razorpay_signature' => $razorpaySignature,
                'status' => 'completed',
            ]);

            $user = $payment->user;
            $user->update(['is_premium' => true]);

            // Flash success message
            return redirect()->route('home')->with('success', '👑 Congratulations! Your payment of ₹' . number_format($payment->amount) . ' was successful. You are now a Gold Plan Premium Member!');
        } else {
            // Signature verification failed
            $payment->update([
                'status' => 'failed'
            ]);

            return redirect()->route('plans')->with('error', 'Payment verification failed. Invalid transaction signature.');
        }
    }
}
