<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — HR Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="font-family:'Figtree',sans-serif;margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#0f172a 0%,#1e1b4b 40%,#4f46e5 75%,#7c3aed 100%);">

    <div style="width:100%;max-width:440px;padding:24px;">
        <div style="background:white;border-radius:20px;padding:44px 40px;box-shadow:0 30px 60px rgba(0,0,0,0.4);">

            {{-- Logo & Title --}}
            <div style="text-align:center;margin-bottom:36px;">
                <img src="{{ asset('logo.png') }}"
                     alt="HR Management System"
                     style="height:68px;margin:0 auto 16px;display:block;object-fit:contain;">
                <h1 style="font-size:22px;font-weight:700;margin:0 0 6px;background:linear-gradient(135deg,#1e1b4b,#7c3aed);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">
                    HR Management System
                </h1>
                <p style="font-size:13px;color:#9ca3af;margin:0;">
                    Sign in to your account to continue
                </p>
            </div>

            {{-- Session Status --}}
            @if(session('status'))
                <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;padding:12px 16px;border-radius:10px;margin-bottom:20px;font-size:13px;">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Errors --}}
            @if($errors->any())
                <div style="background:#fef2f2;border:1px solid #fecaca;color:#dc2626;padding:12px 16px;border-radius:10px;margin-bottom:20px;font-size:13px;">
                    @foreach($errors->all() as $error)
                        <p style="margin:2px 0;">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div style="margin-bottom:20px;">
                    <label style="display:block;font-size:13px;font-weight:600;color:#1e1b4b;margin-bottom:7px;">
                        Email Address
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        required autofocus autocomplete="username"
                        placeholder="Enter your email"
                        style="width:100%;padding:11px 16px;border:1.5px solid #e5e7eb;border-radius:10px;font-size:14px;outline:none;box-sizing:border-box;color:#111827;transition:border-color 0.2s,box-shadow 0.2s;"
                        onfocus="this.style.borderColor='#4f46e5';this.style.boxShadow='0 0 0 3px rgba(79,70,229,0.1)'"
                        onblur="this.style.borderColor='#e5e7eb';this.style.boxShadow='none'">
                </div>

                {{-- Password --}}
                <div style="margin-bottom:20px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:7px;">
                        <label style="font-size:13px;font-weight:600;color:#1e1b4b;">
                            Password
                        </label>
                        @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               style="font-size:12px;color:#4f46e5;text-decoration:none;font-weight:500;">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <input type="password" name="password" required autocomplete="current-password"
                        placeholder="••••••••"
                        style="width:100%;padding:11px 16px;border:1.5px solid #e5e7eb;border-radius:10px;font-size:14px;outline:none;box-sizing:border-box;color:#111827;transition:border-color 0.2s,box-shadow 0.2s;"
                        onfocus="this.style.borderColor='#4f46e5';this.style.boxShadow='0 0 0 3px rgba(79,70,229,0.1)'"
                        onblur="this.style.borderColor='#e5e7eb';this.style.boxShadow='none'">
                </div>

                {{-- Remember Me --}}
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:28px;">
                    <input type="checkbox" name="remember" id="remember"
                        style="width:16px;height:16px;accent-color:#4f46e5;cursor:pointer;">
                    <label for="remember"
                        style="font-size:13px;color:#6b7280;cursor:pointer;">
                        Remember me
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    style="width:100%;padding:13px;background:linear-gradient(135deg,#1e1b4b,#4f46e5,#7c3aed);color:white;border:none;border-radius:10px;font-size:15px;font-weight:600;cursor:pointer;letter-spacing:0.3px;transition:opacity 0.2s,transform 0.1s;box-shadow:0 4px 15px rgba(79,70,229,0.4);"
                    onmouseover="this.style.opacity='0.92';this.style.transform='translateY(-1px)'"
                    onmouseout="this.style.opacity='1';this.style.transform='translateY(0)'">
                    Sign In
                </button>

            </form>

            <p style="text-align:center;font-size:11px;color:#d1d5db;margin-top:28px;margin-bottom:0;">
                © {{ date('Y') }} HR Management System. All rights reserved.
            </p>

        </div>
    </div>

</body>
</html>