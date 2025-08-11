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
        
        .password-strength-indicator {
            height: 4px;
            background-color: #e5e7eb;
            border-radius: 2px;
            overflow: hidden;
            margin-top: 8px;
        }
        
        .password-strength-bar {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }
        
        .strength-weak { width: 25%; background: linear-gradient(90deg, #ef4444, #f87171); }
        .strength-fair { width: 50%; background: linear-gradient(90deg, #f59e0b, #fbbf24); }
        .strength-good { width: 75%; background: linear-gradient(90deg, #3b82f6, #60a5fa); }
        .strength-strong { width: 100%; background: linear-gradient(90deg, #10b981, #34d399); }
    </style>

    <!-- Judul Form -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Buat Akun Baru</h2>
        <p class="text-gray-600">Bergabunglah dengan ribuan pembaca lainnya</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name Field -->
        <div class="input-container">
            <div class="icon-container">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
            </div>
            <input 
                id="name" 
                type="text" 
                name="name" 
                value="{{ old('name') }}"
                placeholder=" "
                required 
                autofocus
                autocomplete="name"
                class="custom-input w-full h-14 pl-12 pr-4 text-gray-700 placeholder-transparent"
            />
            <label for="name" class="floating-label">Nama Lengkap</label>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

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
                autocomplete="username"
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
                autocomplete="new-password"
                class="custom-input w-full h-14 pl-12 pr-4 text-gray-700 placeholder-transparent"
                onkeyup="checkPasswordStrength(this.value)"
            />
            <label for="password" class="floating-label">Password</label>
            
            <!-- Password Strength Indicator -->
            <div class="password-strength-indicator">
                <div id="password-strength-bar" class="password-strength-bar"></div>
            </div>
            <div id="password-strength-text" class="text-xs text-gray-500 mt-1"></div>
            
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password Field -->
        <div class="input-container">
            <div class="icon-container">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <input 
                id="password_confirmation" 
                type="password" 
                name="password_confirmation" 
                placeholder=" "
                required 
                autocomplete="new-password"
                class="custom-input w-full h-14 pl-12 pr-4 text-gray-700 placeholder-transparent"
                onkeyup="checkPasswordMatch()"
            />
            <label for="password_confirmation" class="floating-label">Konfirmasi Password</label>
            <div id="password-match-indicator" class="text-xs mt-1"></div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms and Conditions -->
        <div class="flex items-start space-x-3 p-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl border border-indigo-100">
            <input 
                id="terms" 
                type="checkbox" 
                name="terms" 
                required
                class="mt-1 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
            >
            <div class="text-sm">
                <label for="terms" class="font-medium text-gray-900 cursor-pointer">
                    Saya setuju dengan 
                    <a href="#" class="text-indigo-600 hover:text-indigo-500 font-semibold">Syarat & Ketentuan</a> 
                    dan 
                    <a href="#" class="text-indigo-600 hover:text-indigo-500 font-semibold">Kebijakan Privasi</a>
                </label>
                <p class="text-gray-500 mt-1">
                    Dengan mendaftar, Anda menyetujui penggunaan layanan perpustakaan online kami.
                </p>
            </div>
        </div>

        <!-- Register Button & Login Link -->
        <div class="space-y-4">
            <button type="submit" class="gradient-button w-full h-14 text-white font-semibold flex items-center justify-center space-x-2 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                <span>Daftar Sekarang</span>
            </button>

            <!-- Divider -->
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">atau</span>
                </div>
            </div>

            <!-- Login Link -->
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" 
                       class="font-semibold text-indigo-600 hover:text-indigo-500 transition-colors duration-200 ml-1">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </div>
    </form>

    <script>
        // Password strength checker
        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthText = document.getElementById('password-strength-text');
            
            let strength = 0;
            let feedback = '';
            
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            // Remove all strength classes
            strengthBar.className = 'password-strength-bar';
            
            switch(strength) {
                case 0:
                case 1:
                    strengthBar.classList.add('strength-weak');
                    feedback = 'Password terlalu lemah';
                    strengthText.className = 'text-xs text-red-500 mt-1';
                    break;
                case 2:
                    strengthBar.classList.add('strength-fair');
                    feedback = 'Password cukup';
                    strengthText.className = 'text-xs text-yellow-500 mt-1';
                    break;
                case 3:
                    strengthBar.classList.add('strength-good');
                    feedback = 'Password baik';
                    strengthText.className = 'text-xs text-blue-500 mt-1';
                    break;
                case 4:
                    strengthBar.classList.add('strength-strong');
                    feedback = 'Password sangat kuat';
                    strengthText.className = 'text-xs text-green-500 mt-1';
                    break;
            }
            
            strengthText.textContent = feedback;
        }
        
        // Password match checker
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const indicator = document.getElementById('password-match-indicator');
            
            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    indicator.textContent = '✓ Password cocok';
                    indicator.className = 'text-xs text-green-500 mt-1';
                } else {
                    indicator.textContent = '✗ Password tidak cocok';
                    indicator.className = 'text-xs text-red-500 mt-1';
                }
            } else {
                indicator.textContent = '';
            }
        }
        
        // Add interactive effects
        document.querySelectorAll('.custom-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });

        // Form validation and submission
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const button = form.querySelector('button[type="submit"]');
            const termsCheckbox = document.getElementById('terms');
            
            // Check if terms are accepted
            if (!termsCheckbox.checked) {
                e.preventDefault();
                alert('Anda harus menyetujui Syarat & Ketentuan untuk melanjutkan.');
                return;
            }
            
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

        // Real-time form validation
        document.getElementById('email').addEventListener('input', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email.length > 0 && !emailRegex.test(email)) {
                this.style.borderColor = '#ef4444';
            } else {
                this.style.borderColor = '#e5e7eb';
            }
        });
    </script>
</x-guest-layout>