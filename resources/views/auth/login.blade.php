<x-guest-layout>
    <style>
        /* Custom styles untuk input fields */
        .custom-input {
            background-color: #ffffff;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            color: #374151;
            transition: all 0.3s ease;
        }
        
        .custom-input:focus {
            outline: none;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
            background-color: #ffffff;
        }
        
        .custom-input::placeholder {
            color: #9ca3af;
        }
        
        .input-container {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .input-container:focus-within {
            transform: translateY(-2px);
        }
        
        .floating-label {
            position: absolute;
            left: 40px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            transition: all 0.3s ease;
            pointer-events: none;
            background: white;
            padding: 0 4px;
        }
        
        .input-container input:focus + .floating-label,
        .input-container input:not(:placeholder-shown) + .floating-label {
            top: -8px;
            left: 36px;
            font-size: 12px;
            color: #8b5cf6;
            font-weight: 600;
        }
        
        .icon-container {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            transition: color 0.3s ease;
        }
        
        .input-container:focus-within .icon-container {
            color: #8b5cf6;
        }
        
        .gradient-button {
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
            border-radius: 8px;
        }
        
        .gradient-button:hover {
            background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);
        }
        
        .form-container {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .checkbox-custom {
            appearance: none;
            background-color: #fff;
            margin: 0;
            font: inherit;
            color: #8b5cf6;
            width: 1.15em;
            height: 1.15em;
            border: 2px solid #d1d5db;
            border-radius: 4px;
            transform: translateY(-0.075em);
            display: grid;
            place-content: center;
            transition: all 0.2s ease;
        }
        
        .checkbox-custom:checked {
            background-color: #8b5cf6;
            border-color: #8b5cf6;
        }
        
        .checkbox-custom::before {
            content: "";
            width: 0.65em;
            height: 0.65em;
            transform: scale(0);
            transition: 120ms transform ease-in-out;
            box-shadow: inset 1em 1em white;
            transform-origin: bottom left;
            clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
        }
        
        .checkbox-custom:checked::before {
            transform: scale(1);
        }
    </style>

    <!-- Judul Form -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Login ke Akun Anda</h2>
        <p class="text-gray-600">Gunakan email dan password Anda untuk melanjutkan.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Field -->
        <div class="input-container">
            <div class="icon-container">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                </svg>
            </div>
            <input 
                id="email" 
                type="email" 
                name="email" 
                value="{{ old('email') }}"
                placeholder=" "
                required 
                autofocus
                class="custom-input w-full h-14 pl-12 pr-4 text-gray-700 placeholder-transparent"
            />
            <label for="email" class="floating-label">Email Address</label>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password Field -->
        <div class="input-container">
            <div class="icon-container">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                   <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                </svg>
            </div>
            <input 
                id="password" 
                type="password" 
                name="password" 
                placeholder=" "
                required 
                autocomplete="current-password"
                class="custom-input w-full h-14 pl-12 pr-4 text-gray-700 placeholder-transparent"
            />
            <label for="password" class="floating-label">Password</label>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-6">
            <div class="flex items-center">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    name="remember"
                    class="checkbox-custom"
                >
                <label for="remember_me" class="ml-3 text-sm text-gray-700 font-medium select-none cursor-pointer">
                    Ingat saya
                </label>
            </div>

            @if (Route::has('password.request'))
                <div class="text-sm">
                    <a class="font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-200" 
                       href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                </div>
            @endif
        </div>

        <!-- Login Button -->
        <div class="mt-8">
            <button type="submit" class="gradient-button w-full h-14 text-white font-semibold rounded-12 flex items-center justify-center space-x-2 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                <span>Masuk</span>
            </button>
        </div>

        <!-- Register Link -->
        <div class="mt-8 text-center">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">atau</span>
                </div>
            </div>
            <p class="mt-6 text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" 
                   class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors duration-200 ml-1">
                    Daftar di sini
                </a>
            </p>
        </div>
    </form>

    <script>
        // Add some interactive effects
        document.querySelectorAll('.custom-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });

        // Form validation feedback
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const button = form.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;
            
            button.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memproses...
            `;
            button.disabled = true;
            
            // Reset after 3 seconds if form doesn't submit
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 3000);
        });
    </script>
</x-guest-layout>