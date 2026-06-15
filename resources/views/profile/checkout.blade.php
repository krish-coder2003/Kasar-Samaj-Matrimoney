<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Checkout | Kasar Community Matrimony</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #fdfaf5;
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .checkout-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
            padding: 3rem 1.5rem;
        }
        .checkout-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 15px 40px rgba(128, 0, 0, 0.05);
            max-width: 480px;
            width: 100%;
            padding: 3rem 2.5rem;
            text-align: center;
            border: 1px solid rgba(128, 0, 0, 0.03);
            position: relative;
            overflow: hidden;
        }
        .checkout-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #800000, #d4af37);
        }
        .logo-container {
            margin-bottom: 2rem;
        }
        .logo-container img {
            height: 60px;
            width: 60px;
            border-radius: 12px;
            background: #fff;
            padding: 4px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .order-title {
            font-family: 'Playfair Display', serif;
            color: #800000;
            font-size: 1.8rem;
            margin: 0 0 0.5rem;
        }
        .order-desc {
            color: #777;
            font-size: 0.95rem;
            margin: 0 0 2rem;
        }
        .price-badge {
            background: rgba(128, 0, 0, 0.03);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px dashed rgba(128, 0, 0, 0.15);
        }
        .price-label {
            font-size: 0.85rem;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            margin-bottom: 0.2rem;
        }
        .price-val {
            font-size: 2.2rem;
            font-weight: 800;
            color: #800000;
        }
        .price-val span {
            font-size: 1rem;
            color: #888;
            font-weight: 400;
        }
        .pay-btn {
            background: #800000;
            color: white;
            border: none;
            width: 100%;
            padding: 1.2rem;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 8px 25px rgba(128, 0, 0, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .pay-btn:hover {
            background: #a00000;
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(128, 0, 0, 0.25);
        }
        .secure-notice {
            margin-top: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #2e7d32;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .spinner {
            display: inline-block;
            width: 40px;
            height: 40px;
            border: 4px solid rgba(128, 0, 0, 0.1);
            border-radius: 50%;
            border-top-color: #800000;
            animation: spin 1s ease-in-out infinite;
            margin-bottom: 1.5rem;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .loading-container {
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>

    @include('partials.header')

    <div class="checkout-wrapper">
        <div class="checkout-card">
            <div class="logo-container">
                <img src="/images/logo-icon.png" alt="Logo">
            </div>
            
            <div class="loading-container" id="loading-box">
                <div class="spinner"></div>
                <h3 style="font-size: 1.2rem; color: #333; margin: 0 0 0.5rem;">Launching Secure Checkout...</h3>
                <p style="color: #888; font-size: 0.9rem; margin: 0;">Please wait, redirecting to Razorpay payment gateway.</p>
            </div>

            <div id="payment-box" style="display: none;">
                <h2 class="order-title">Premium Upgrade</h2>
                <p class="order-desc">Unlock contact details and direct connection features instantly.</p>

                <div class="price-badge">
                    <div class="price-label">Upgrade to Gold Plan</div>
                    <div class="price-val">₹{{ number_format($payment->amount) }} <span>/ One-time</span></div>
                </div>

                <button class="pay-btn" id="rzp-button">
                    <i class="fas fa-shield-alt"></i> Pay Now with Razorpay
                </button>
            </div>

            <div class="secure-notice">
                <i class="fas fa-lock"></i> 100% Secure 256-bit SSL Transaction
            </div>
        </div>
    </div>

    <!-- Hidden form to post verification details back -->
    <form id="payment-verify-form" action="{{ route('payment.verify') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
        <input type="hidden" name="razorpay_signature" id="razorpay_signature">
    </form>

    @include('partials.footer')

    <!-- Razorpay Checkout JS -->
    <script>
        (function() {
            var initialized = false;
            var rzp = null;
            var rzpError = null;

            function loadRazorpay(callback) {
                if (typeof Razorpay !== 'undefined') {
                    callback();
                    return;
                }
                var script = document.createElement('script');
                script.src = "https://checkout.razorpay.com/v1/checkout.js";
                script.async = true;
                script.onload = function() {
                    callback();
                };
                script.onerror = function() {
                    rzpError = "Razorpay SDK failed to load. Please check your internet connection.";
                    showErrorState();
                };
                document.head.appendChild(script);
            }

            function initCheckout() {
                if (initialized) return;
                initialized = true;

                loadRazorpay(function() {
                    try {
                        if (typeof Razorpay === 'undefined') {
                            throw new Error("Razorpay payment SDK failed to load. Please check your internet connection.");
                        }

                    var options = {
                        "key": "{{ $keyId }}",
                        "amount": "{{ $payment->amount * 100 }}", 
                        "currency": "{{ $payment->currency }}",
                        "name": "Kasar Community Matrimony",
                        "description": "Gold Plan Membership Upgrade",
                        "image": "/images/logo-icon.png",
                        "order_id": "{{ $payment->razorpay_order_id }}",
                        "handler": function (response){
                            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                            document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                            document.getElementById('razorpay_signature').value = response.razorpay_signature;
                            document.getElementById('payment-verify-form').submit();
                        },
                        "prefill": {
                            "name": "{{ Auth::user()->name }}",
                            "email": "{{ Auth::user()->email }}",
                            "contact": "{{ Auth::user()->profile->phone_number ?? '' }}"
                        },
                        "theme": {
                            "color": "#800000"
                        },
                        "config": {
                            "display": {
                                "blocks": {
                                    "upi": {
                                        "name": "UPI / QR Code",
                                        "instruments": [
                                            {
                                                "method": "upi"
                                            }
                                        ]
                                    }
                                },
                                "sequence": ["block.upi", "block.other"],
                                "preferences": {
                                    "show_default_blocks": true
                                }
                            }
                        },
                        "modal": {
                            "ondismiss": function(){
                                document.getElementById('loading-box').style.display = 'none';
                                document.getElementById('payment-box').style.display = 'block';
                            }
                        }
                    };

                    if (!options.key || options.key === "") {
                        throw new Error("Razorpay Key ID is missing. Please check your environment configuration.");
                    }

                    rzp = new Razorpay(options);
                } catch (e) {
                    rzpError = e.message;
                    console.error("Razorpay Init Error: ", e);
                }

                // Open modal or show error fallback
                if (rzp && !rzpError) {
                    try {
                        rzp.open();
                    } catch(err) {
                        rzpError = err.message;
                        showErrorState();
                    }
                } else {
                    showErrorState();
                }

                // Fallback: hide loader, show options
                setTimeout(function() {
                    var loader = document.getElementById('loading-box');
                    var payBox = document.getElementById('payment-box');
                    if (loader) loader.style.display = 'none';
                    if (payBox) payBox.style.display = 'block';
                }, 1200);
            });
        }

            function showErrorState() {
                var loader = document.getElementById('loading-box');
                var payBox = document.getElementById('payment-box');
                if (loader) loader.style.display = 'none';
                if (payBox) payBox.style.display = 'block';
                
                var errDiv = document.createElement('div');
                errDiv.style.background = '#ffebee';
                errDiv.style.color = '#c62828';
                errDiv.style.padding = '1rem';
                errDiv.style.borderRadius = '10px';
                errDiv.style.marginBottom = '1.5rem';
                errDiv.style.fontWeight = '600';
                errDiv.style.fontSize = '0.9rem';
                errDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> ' + (rzpError || "Could not launch Razorpay Checkout.");
                
                var box = document.getElementById('payment-box');
                if (box) {
                    box.insertBefore(errDiv, box.firstChild);
                }
                
                var btn = document.getElementById('rzp-button');
                if (btn) {
                    btn.style.opacity = '0.5';
                    btn.style.cursor = 'not-allowed';
                }
            }

            // Bind events
            document.addEventListener('DOMContentLoaded', initCheckout);
            document.addEventListener('turbo:load', initCheckout);
            if (document.readyState === 'complete' || document.readyState === 'interactive') {
                initCheckout();
            }

            // Manual trigger button
            document.addEventListener('click', function(e) {
                var btn = document.getElementById('rzp-button');
                if (e.target === btn || (btn && btn.contains(e.target))) {
                    e.preventDefault();
                    if (rzp && !rzpError) {
                        try {
                            rzp.open();
                        } catch(err) {
                            alert("Error launching Razorpay: " + err.message);
                        }
                    } else {
                        alert("Payment gateway cannot be initialized: " + (rzpError || "Check configuration."));
                    }
                }
            });
        })();
    </script>
</body>
</html>
