<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-pink-50 to-purple-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Welcome to Fitsme!</h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Let's personalize your experience by setting up your profile preferences.
                    This will help us recommend outfits that match your skin tone and style preferences.
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8">
                    <!-- Progress indicator -->
                    <div class="mb-10">
                        <div class="flex items-center justify-center">
                            <div class="flex items-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">1</div>
                                    <span class="mt-2 text-sm font-medium text-gray-700">Skin Tone</span>
                                </div>
                                <div class="w-16 h-1 bg-gray-300 mx-2"></div>
                                <div class="flex flex-col items-center">
                                    <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">2</div>
                                    <span class="mt-2 text-sm font-medium text-gray-700">Style Preferences</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 1: Skin Tone Selection -->
                    <div id="step1" class="step active">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Select Your Skin Tone</h2>
                        <p class="text-gray-600 mb-8 text-center">
                            Choose the skin tone that best matches yours. This helps us recommend colors that will look great on you.
                        </p>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                            @foreach($skinTones as $tone)
                                <div class="skin-tone-option border-2 border-gray-200 rounded-xl p-4 cursor-pointer hover:border-indigo-300 transition-colors"
                                     data-value="{{ $tone->id }}"
                                     onclick="selectSkinTone(this)">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-full mr-4 border border-gray-300"
                                             style="background-color: {{ $tone->hex_preview }};">
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $tone->label }}</div>
                                            <div class="text-sm text-gray-500 capitalize">{{ $tone->undertone }} undertone</div>
                                            <div class="text-xs text-gray-400">{{ $tone->code }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-center">
                            <button id="nextToStep2" 
                                    class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-indigo-700 transition-colors disabled:opacity-50"
                                    disabled>
                                Continue to Style Preferences
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Style Preferences -->
                    <div id="step2" class="step hidden">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Select Your Style Preferences</h2>
                        <p class="text-gray-600 mb-8 text-center">
                            Choose the styles that match your taste. You can select multiple options.
                        </p>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                            @foreach($recommendedStyles as $value => $label)
                                <div class="style-option border border-gray-200 rounded-lg p-4 cursor-pointer hover:border-indigo-300 transition-colors text-center"
                                     onclick="selectStyle(this)"
                                     data-value="{{ $value }}">
                                    <div class="font-medium text-gray-900">{{ $label }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-between">
                            <button id="backToStep1" 
                                    class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-medium hover:bg-gray-300 transition-colors">
                                Back
                            </button>
                            <button id="completeSetup" 
                                    class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                                Complete Setup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedSkinTone = null;
        let selectedStyles = [];

        function selectSkinTone(element) {
            // Remove selected class from all options
            document.querySelectorAll('.skin-tone-option').forEach(el => {
                el.classList.remove('border-indigo-500', 'bg-indigo-50');
            });
            
            // Add selected class to clicked option
            element.classList.add('border-indigo-500', 'bg-indigo-50');
            
            // Update selected skin tone
            selectedSkinTone = element.getAttribute('data-value');
            
            // Enable continue button
            document.getElementById('nextToStep2').disabled = false;
        }

        function selectStyle(element) {
            const value = element.getAttribute('data-value');
            const index = selectedStyles.indexOf(value);
            
            if (index > -1) {
                // Remove if already selected
                selectedStyles.splice(index, 1);
                element.classList.remove('border-indigo-500', 'bg-indigo-50');
            } else {
                // Add if not selected
                selectedStyles.push(value);
                element.classList.add('border-indigo-500', 'bg-indigo-50');
            }
        }

        // Navigation between steps
        document.getElementById('nextToStep2').addEventListener('click', function() {
            if (selectedSkinTone) {
                // Save skin tone
                fetch('{{ route('profile.save.skin-tone') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ skin_tone_id: selectedSkinTone })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Hide step 1 and show step 2
                        document.getElementById('step1').classList.add('hidden');
                        document.getElementById('step2').classList.remove('hidden');
                        
                        // Mark as active step
                        document.querySelectorAll('.step').forEach(step => {
                            step.classList.remove('active');
                        });
                        document.getElementById('step2').classList.add('active');
                    } else {
                        alert('Error saving skin tone: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while saving your skin tone.');
                });
            }
        });

        document.getElementById('backToStep1').addEventListener('click', function() {
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step1').classList.remove('hidden');
            
            // Mark as active step
            document.querySelectorAll('.step').forEach(step => {
                step.classList.remove('active');
            });
            document.getElementById('step1').classList.add('active');
        });

        document.getElementById('completeSetup').addEventListener('click', function() {
            if (selectedStyles.length > 0) {
                // Save style preferences
                fetch('{{ route('profile.save.styles') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ styles: selectedStyles })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Redirect to dashboard
                        window.location.href = '{{ route('profile.complete') }}';
                    } else {
                        alert('Error saving style preferences: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while saving your style preferences.');
                });
            } else {
                alert('Please select at least one style preference.');
            }
        });

        // Pre-populate selections if user has existing preferences
        document.addEventListener('DOMContentLoaded', function() {
            @if($user->skin_tone_id)
                // Pre-select skin tone
                document.querySelectorAll('.skin-tone-option').forEach(el => {
                    if (el.getAttribute('data-value') === '{{ $user->skin_tone_id }}') {
                        el.click();
                    }
                });
            @endif

            @if(!empty($existingStyles))
                // Pre-select existing styles
                @foreach($existingStyles as $style)
                    document.querySelectorAll('.style-option').forEach(el => {
                        if (el.getAttribute('data-value') === '{{ $style }}') {
                            el.click();
                        }
                    });
                @endforeach
            @endif
        });
    </script>

    <style>
        .step {
            transition: opacity 0.3s ease-in-out;
        }
        .skin-tone-option.selected {
            border-color: #4f46e5;
            background-color: #eef2ff;
        }
        .style-option.selected {
            border-color: #4f46e5;
            background-color: #eef2ff;
        }
    </style>
</x-app-layout>