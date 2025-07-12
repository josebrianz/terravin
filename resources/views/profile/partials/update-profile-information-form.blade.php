<section>
    <header class="mb-4">
        <h2 class="text-lg font-medium text-burgundy fw-bold">
            <i class="fas fa-user-circle text-gold me-2"></i>
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-muted">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Profile Photo Update Form (Separate) -->
    <form method="post" action="{{ route('profile.update') }}" class="mt-4 mb-4" enctype="multipart/form-data" id="photo-form">
        @csrf
        @method('patch')

        <div class="card border-0 shadow-sm wine-card">
            <div class="card-header bg-white border-bottom-0">
                <h6 class="card-title mb-0 fw-bold text-burgundy">
                    <i class="fas fa-camera text-gold me-2"></i>
                    {{ __('Profile Photo') }}
                </h6>
        </div>
            <div class="card-body">
                <!-- Current Photo Display -->
                <div class="d-flex align-items-center gap-4 mb-3">
                    @if($user->profile_photo)
                        <div class="relative" id="photo-container">
                            <img src="{{ asset('storage/' . $user->profile_photo) }}?v={{ time() }}" 
                                 alt="{{ $user->name }}" 
                                 class="h-8 w-8 rounded-full object-cover border-2 border-gray-200"
                                 id="profile-preview">
                            <button type="button" 
                                    onclick="document.getElementById('profile_photo').click()" 
                                    class="absolute -bottom-2 -right-2 bg-blue-500 hover:bg-blue-600 text-white rounded-full p-2 shadow-lg transition-colors duration-200 border-2 border-white"
                                    title="Change Photo"
                                    style="z-index: 10;">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                </svg>
                            </button>
                        </div>
                    @else
                        <div class="h-8 w-8 rounded-full bg-gray-300 d-flex align-items-center justify-content-center" id="initials-container">
                            <span class="text-gray-600 text-xs font-medium">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                        </div>
                    @endif
                    
                    <!-- Action Buttons -->
                    <div class="d-flex flex-column gap-2">
                        <button type="button" 
                                onclick="document.getElementById('profile_photo').click()" 
                                class="btn btn-gold btn-sm shadow-sm">
                            <i class="fas fa-edit me-2"></i> {{ $user->profile_photo ? 'Change Photo' : 'Add Photo' }}
                        </button>
                        @if($user->profile_photo)
                        <button type="button" 
                                onclick="removePhoto()" 
                                class="btn btn-outline-burgundy btn-sm shadow-sm">
                            <i class="fas fa-trash me-2"></i> Remove Photo
                        </button>
                        @endif
                    </div>
                </div>
                
                <!-- File Input (Hidden) -->
                <input type="file" 
                       id="profile_photo" 
                       name="profile_photo" 
                       accept="image/*" 
                       class="d-none" 
                       onchange="previewImage(this)">
                
                <!-- File Info -->
                <div class="text-sm text-muted">
                    <p><i class="fas fa-info-circle text-gold me-1"></i> Supported formats: PNG, JPG, GIF (max 2MB)</p>
                </div>
                
                <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-burgundy btn-sm shadow-sm">
                        <i class="fas fa-save me-2"></i>{{ __('Update Photo') }}
                    </button>
                    
                    @if (session('status') === 'profile-updated' && (request()->hasFile('profile_photo') || request()->has('remove_photo')))
                        <div class="alert alert-success mt-3 mb-0 py-2 px-3" 
                             x-data="{ show: true }"
                             x-show="show"
                             x-transition
                             x-init="setTimeout(() => show = false, 3000)">
                            <i class="fas fa-check-circle me-2"></i>{{ __('Photo updated successfully!') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </form>

    <!-- Profile Information Form (Name & Email) -->
    <form method="post" action="{{ route('profile.update') }}" class="mt-4" id="info-form">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label text-burgundy fw-semibold">
                <i class="fas fa-user text-gold me-1"></i>
                {{ __('Name') }}
            </label>
            <input id="name" name="name" type="text" class="form-control wine-input" value="{{ old('name', $user->name) }}" autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="mb-3">
            <label for="email" class="form-label text-burgundy fw-semibold">
                <i class="fas fa-envelope text-gold me-1"></i>
                {{ __('Email') }}
            </label>
            <input id="email" name="email" type="email" class="form-control wine-input" value="{{ old('email', $user->email) }}" autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    <strong>{{ __('Your email address is unverified.') }}</strong>

                    <button form="send-verification" class="btn btn-link p-0 ms-2 text-decoration-none">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <div class="alert alert-success mt-3">
                        <i class="fas fa-check-circle text-success me-2"></i>
                        {{ __('A new verification link has been sent to your email address.') }}
                    </div>
                @endif
            @endif
        </div>

        <div class="d-flex align-items-center gap-3 mt-4">
            <button type="submit" class="btn btn-burgundy shadow-sm">
                <i class="fas fa-save me-2"></i>{{ __('Save Information') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div class="alert alert-success mb-0 py-2 px-3" 
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                     x-init="setTimeout(() => show = false, 2000)">
                    <i class="fas fa-check-circle me-2"></i>{{ __('Saved.') }}
                </div>
            @endif
        </div>
    </form>

    <script>
        // File input change handler
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('profile-preview');
                    if (img) {
                        img.src = e.target.result;
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Remove photo function
        function removePhoto() {
            if (confirm('Are you sure you want to remove your profile photo?')) {
                // Create a hidden input to indicate photo removal
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'remove_photo';
                hiddenInput.value = '1';
                document.getElementById('photo-form').appendChild(hiddenInput);
                
                // Clear the file input
                document.getElementById('profile_photo').value = '';
                
                // Show initials instead of photo
                const photoContainer = document.getElementById('photo-container');
                if (photoContainer) {
                    photoContainer.innerHTML = `
                        <div class="h-8 w-8 rounded-full bg-gray-300 d-flex align-items-center justify-content-center">
                            <span class="text-gray-600 text-xs font-medium">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                        </div>
                    `;
                }
            }
        }
    </script>

    <style>
        .wine-input {
            border: 2px solid rgba(200, 169, 126, 0.3);
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .wine-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 0.2rem rgba(200, 169, 126, 0.25);
        }
        
        .btn-gold {
            background-color: var(--gold);
            border-color: var(--gold);
            color: var(--burgundy);
            transition: all 0.3s ease;
        }
        
        .btn-gold:hover {
            background-color: var(--dark-gold);
            border-color: var(--dark-gold);
            color: var(--burgundy);
            transform: translateY(-1px);
        }
        
        .btn-outline-burgundy {
            border-color: var(--burgundy);
            color: var(--burgundy);
            transition: all 0.3s ease;
        }
        
        .btn-outline-burgundy:hover {
            background-color: var(--burgundy);
            border-color: var(--burgundy);
            color: white;
        }
        
        .btn-burgundy {
            background-color: var(--burgundy);
            border-color: var(--burgundy);
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-burgundy:hover {
            background-color: var(--light-burgundy);
            border-color: var(--light-burgundy);
            color: white;
            transform: translateY(-1px);
        }

        .accordion-collapse.show, .collapse.show {
            display: block !important;
            height: auto !important;
            opacity: 1 !important;
            visibility: visible !important;
            overflow: visible !important;
        }
    </style>
</section>
