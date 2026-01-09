@extends('layouts.app')

@section('title', __('messages.contact_us', [], 'en'))

@section('content')
<section class="page-section" id="contact" style="padding-top: 2rem; padding-bottom: 2rem;" lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8 col-xl-6 text-center mb-5 contact-header">
                <h2 class="mt-0">{{ __('messages.contact_us') }}</h2>
                <hr class="divider" />
                <p class="text-muted mb-5">{{ __('messages.contact_description') }}</p>
            </div>
        </div>
        
        <!-- Contact Info Cards -->
        @if($contactInfos->count() > 0)
        <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
            @foreach($contactInfos as $contactInfo)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="contact-info-card">
                        <div class="text-center">
                            <i class="bi {{ $contactInfo->icon }}" style="font-size: 3rem; color: white; margin-bottom: 1rem;"></i>
                            <h5 class="mb-2 text-white">{{ $contactInfo->getTranslation('title', app()->getLocale()) }}</h5>
                            <p class="mb-0 text-white">{{ $contactInfo->getTranslation('content', app()->getLocale()) }}</p>
                            @if($contactInfo->type === 'phone' && $contactInfo->working_hours)
                                <p class="working-hours text-white-50 small">{{ $contactInfo->working_hours }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif

        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8">
                <div class="contact-form-container" lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
                    <!-- Form Progress Indicator -->
                    <div class="form-progress mb-4">
                        <div class="progress-step active" data-step="1">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="progress-step" data-step="2">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="progress-step" data-step="3">
                            <i class="bi bi-chat"></i>
                        </div>
                        <div class="progress-step" data-step="4">
                            <i class="bi bi-check"></i>
                        </div>
                    </div>
                    <!-- Contact Form using Laravel -->
                    <form id="contactForm" method="POST" action="{{ route(app()->getLocale() . '.contact.store') }}" novalidate data-handler="blade">
                        @csrf
                        <!-- Name input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="name" id="name" type="text" placeholder="Enter your name..." required />
                            <label for="name"><i class="bi bi-person me-2"></i>{{ __('messages.full_name') }}</label>
                            <div class="invalid-feedback">{{ __('messages.name_required') }}</div>
                            <div class="valid-feedback">{{ __('messages.looks_good') }}</div>
                        </div>
                        <!-- Email address input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="email" id="email" type="email" placeholder="name@example.com" required />
                            <label for="email"><i class="bi bi-envelope me-2"></i>{{ __('messages.email_address') }}</label>
                            <div class="invalid-feedback">{{ __('messages.valid_email_required') }}</div>
                            <div class="valid-feedback">{{ __('messages.valid_email') }}</div>
                        </div>
                        <!-- Phone number input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="phone" id="phone" type="tel" placeholder="(123) 456-7890" />
                            <label for="phone"><i class="bi bi-telephone me-2"></i>{{ __('messages.phone_number') }}</label>
                            <div class="invalid-feedback">{{ __('messages.phone_invalid') }}</div>
                            <div class="valid-feedback">{{ __('messages.valid_phone') }}</div>
                        </div>
                        <!-- Subject input -->
                        <div class="form-floating mb-3">
                            <select class="form-control" name="subject" id="subject" required>
                                <option value="">{{ __('messages.select_subject') }}</option>
                                <option value="general">{{ __('messages.general_inquiry') }}</option>
                                <option value="project">{{ __('messages.project_quote') }}</option>
                                <option value="support">{{ __('messages.technical_support') }}</option>
                                <option value="partnership">{{ __('messages.partnership') }}</option>
                                <option value="other">{{ __('messages.other') }}</option>
                            </select>
                            <label for="subject"><i class="bi bi-tag me-2"></i>{{ __('messages.subject') }}</label>
                            <div class="invalid-feedback">{{ __('messages.select_subject_required') }}</div>
                            <div class="valid-feedback">{{ __('messages.subject_selected') }}</div>
                        </div>
                        <!-- Message input-->
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="message" id="message" placeholder="Enter your message here..." style="height: 10rem" maxlength="1000" required></textarea>
                            <label for="message"><i class="bi bi-chat-dots me-2"></i>{{ __('messages.message') }}</label>
                            <div class="invalid-feedback">{{ __('messages.message_required') }}</div>
                            <div class="valid-feedback">{{ __('messages.great_message') }}</div>
                            <div class="character-counter">
                                <span id="charCount">0</span>/1000 {{ __('messages.characters') }}
                            </div>
                        </div>
                        <!-- Submit success message-->
                        <div class="d-none" id="submitSuccessMessage">
                            <div class="form-success-message">
                                <i class="bi bi-check-circle-fill fs-1 mb-3"></i>
                                <h4>{{ __('messages.message_sent') }}</h4>
                                <p>{{ __('messages.thank_you_contact') }}</p>
                            </div>
                        </div>
                        <!-- Submit error message-->
                        <div class="d-none" id="submitErrorMessage">
                            <div class="form-error-message">
                                <i class="bi bi-exclamation-triangle-fill fs-1 mb-3"></i>
                                <h4>{{ __('messages.oops') }}</h4>
                                <p id="errorText">{{ __('messages.try_again') }}</p>
                            </div>
                        </div>
                        <!-- Submit Button-->
                        <div class="d-grid">
                            <button class="btn btn-submit btn-xl" id="submitButton" type="submit">
                                <span class="btn-text">
                                    <i class="bi bi-send me-2"></i>{{ __('messages.send_message') }}
                                </span>
                                <span class="btn-loading d-none">
                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                    {{ __('messages.sending') }}
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Back to Home Button -->
        <div class="text-center mt-5">
            <a href="/{{ app()->getLocale() }}" class="btn btn-primary btn-lg">
                <i class="bi bi-house-fill me-2"></i>{{ __('messages.back_to_home') }}
            </a>
        </div>
    </div>
</section>

<style>
/* Contact Info Cards */
.contact-info-card {
    background: linear-gradient(135deg, #6EB744 0%, #5A8C43 100%);
    border-radius: 1rem;
    padding: 2rem 1.5rem;
    text-align: center;
    box-shadow: 0 8px 25px rgba(110, 183, 68, 0.2);
    transition: all 0.3s ease;
    height: 100%;
}

.contact-info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(110, 183, 68, 0.3);
}

.contact-info-card i {
    display: block;
    margin-bottom: 1rem;
}

.contact-info-card h5 {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.contact-info-card p {
    font-size: 1rem;
    line-height: 1.5;
}

.working-hours {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
    font-style: italic;
    margin-top: 0.5rem;
    margin-bottom: 0;
}

/* Contact Form Styling */
.contact-form-container {
    background: #fff;
    border-radius: 1rem;
    padding: 2.5rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(110, 183, 68, 0.1);
}

.form-progress {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    width: 100%;
    position: relative;
}

.progress-step {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    position: relative;
    flex-shrink: 0;
    z-index: 2;
}

.progress-step.active {
    background: #6EB744;
    color: white;
    transform: scale(1.1);
}

.progress-step.completed {
    background: #6EB744;
    color: white;
}

.form-progress::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 2px;
    background: #e9ecef;
    transform: translateY(-50%);
    z-index: 1;
}

.progress-step::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100%;
    height: 2px;
    background: #6EB744;
    transform: translateY(-50%);
    z-index: 1;
    opacity: 0;
}

.progress-step.completed::after {
    opacity: 1;
}

.progress-step:last-child::after {
    display: none;
}

.form-floating {
    position: relative;
}

.form-floating .form-control {
    border: 2px solid #e9ecef;
    border-radius: 0.75rem;
    padding: 1rem 0.75rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-floating .form-control:focus {
    border-color: #6EB744;
    box-shadow: 0 0 0 0.2rem rgba(110, 183, 68, 0.25);
}

.form-floating label {
    color: #6c757d;
    font-weight: 500;
}

.form-floating .form-control:focus ~ label,
.form-floating .form-control:not(:placeholder-shown) ~ label {
    color: #6EB744;
    transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
}

.character-counter {
    text-align: right;
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

.btn-submit {
    background: linear-gradient(135deg, #6EB744 0%, #5A8C43 100%);
    border: none;
    border-radius: 2rem;
    padding: 1rem 2rem;
    font-weight: 600;
    font-size: 1.1rem;
    color: white;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(110, 183, 68, 0.3);
}

.btn-submit:hover {
    background: linear-gradient(135deg, #5A8C43 0%, #497f2d 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(110, 183, 68, 0.4);
    color: white;
}

.btn-submit:active {
    transform: translateY(0);
}

.form-success-message,
.form-error-message {
    text-align: center;
    padding: 2rem;
    border-radius: 1rem;
}

.form-success-message {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
    border: 1px solid #c3e6cb;
}

.form-error-message {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.form-success-message i {
    color: #28a745;
}

.form-error-message i {
    color: #dc3545;
}

/* RTL Support for Contact Form */
[dir="rtl"] .form-floating .form-control:focus ~ label,
[dir="rtl"] .form-floating .form-control:not(:placeholder-shown) ~ label {
    transform: scale(0.85) translateY(-0.5rem) translateX(-0.15rem);
    right: 1rem;
    left: auto;
    text-align: right;
}

[dir="rtl"] .invalid-feedback,
[dir="rtl"] .valid-feedback {
    text-align: right;
}

[dir="rtl"] .form-progress {
    flex-direction: row-reverse;
}

[dir="rtl"] .progress-step::after {
    left: auto;
    right: 50%;
    transform: translateY(-50%) translateX(50%);
}

[dir="rtl"] .character-counter {
    text-align: left;
}

[dir="rtl"] .form-floating .form-control {
    text-align: right;
    padding-right: 0.75rem;
    padding-left: 0.75rem;
}

[dir="rtl"] .form-floating label {
    text-align: right;
    right: 1rem;
    left: auto;
}

[dir="rtl"] .form-floating .form-control:focus ~ label,
[dir="rtl"] .form-floating .form-control:not(:placeholder-shown) ~ label {
    right: 0.75rem;
    left: auto;
    transform: scale(0.85) translateY(-0.6rem) translateX(-0.15rem);
}

[dir="rtl"] .form-floating .form-control::placeholder {
    text-align: right;
}

[dir="rtl"] .form-floating label i {
    margin-left: 0.5rem;
    margin-right: 0;
}

/* Contact page header spacing */
.contact-header { margin-top: 60px; margin-bottom: 2rem; }
@media (min-width: 768px) and (max-width: 1023px) { .contact-header { margin-top: 70px; margin-bottom: 2.5rem; } }
@media (min-width: 1024px) { .contact-header { margin-top: 80px; margin-bottom: 3rem; } }

/* Responsive Design */
@media (max-width: 768px) {
    .contact-form-container {
        padding: 1.5rem;
    }
    
    .contact-info-card {
        padding: 1.5rem 1rem;
        margin-bottom: 1rem;
    }
    
    .form-progress {
        justify-content: space-between;
    }
    
    .progress-step {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .progress-step::after {
        width: 0.5rem;
    }
}

@media (max-width: 576px) {
    .contact-form-container {
        padding: 1rem;
    }
    
    .contact-info-card {
        padding: 1.25rem 0.75rem;
    }
    
    .form-progress {
        flex-wrap: wrap;
        justify-content: space-between;
    }
    
    .progress-step {
        width: 35px;
        height: 35px;
        font-size: 0.9rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const submitButton = document.getElementById('submitButton');
    const successMsg = document.getElementById('submitSuccessMessage');
    const errorMsg = document.getElementById('submitErrorMessage');
    const errorText = document.getElementById('errorText');

    // Progress bar logic
    const steps = document.querySelectorAll('.progress-step');
    const fields = ['name', 'email', 'phone', 'subject', 'message'];
    
    function updateProgressSteps(currentStep) {
        steps.forEach((step, index) => {
            step.classList.remove('active', 'completed');
            if (index < currentStep) {
                step.classList.add('completed');
            } else if (index === currentStep) {
                step.classList.add('active');
            }
        });
    }
    
    // Form validation
    function validateField(field) {
        const value = field.value.trim();
        const fieldName = field.name;
        let isValid = true;
        
        // Remove existing validation classes
        field.classList.remove('is-valid', 'is-invalid');
        
        // Define validation messages
        const messages = {
            name_min: {!! json_encode(__('messages.name_min')) !!},
            valid_email_required: {!! json_encode(__('messages.valid_email_required')) !!},
            phone_invalid: {!! json_encode(__('messages.phone_invalid')) !!},
            select_subject_required: {!! json_encode(__('messages.select_subject_required')) !!},
            message_min: {!! json_encode(__('messages.message_min')) !!}
        };

        switch(fieldName) {
            case 'name':
                if (value.length < 2) {
                    field.classList.add('is-invalid');
                    const fb = field.parentElement.querySelector('.invalid-feedback');
                    if (fb) fb.textContent = messages.name_min;
                    isValid = false;
                } else {
                    field.classList.add('is-valid');
                }
                break;
                
            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    field.classList.add('is-invalid');
                    const fb = field.parentElement.querySelector('.invalid-feedback');
                    if (fb) fb.textContent = messages.valid_email_required;
                    isValid = false;
                } else {
                    field.classList.add('is-valid');
                }
                break;
                
            case 'phone':
                if (value && value.length > 0) {
                    const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
                    if (!phoneRegex.test(value.replace(/[\s\-\(\)]/g, ''))) {
                        field.classList.add('is-invalid');
                        const fb = field.parentElement.querySelector('.invalid-feedback');
                        if (fb) fb.textContent = messages.phone_invalid;
                        isValid = false;
                    } else {
                        field.classList.add('is-valid');
                    }
                }
                break;
                
            case 'subject':
                if (!value) {
                    field.classList.add('is-invalid');
                    const fb = field.parentElement.querySelector('.invalid-feedback');
                    if (fb) fb.textContent = messages.select_subject_required;
                    isValid = false;
                } else {
                    field.classList.add('is-valid');
                }
                break;
                
            case 'message':
                if (value.length < 10) {
                    field.classList.add('is-invalid');
                    const fb = field.parentElement.querySelector('.invalid-feedback');
                    if (fb) fb.textContent = messages.message_min;
                    isValid = false;
                } else {
                    field.classList.add('is-valid');
                }
                break;
        }
        
        return isValid;
    }
    
    // Add validation on blur
    fields.forEach(fieldName => {
        const field = document.getElementById(fieldName);
        if (field) {
            field.addEventListener('blur', function() {
                validateField(this);
            });
            
            field.addEventListener('focus', function() {
                const idx = fields.indexOf(fieldName);
                updateProgressSteps(idx);
            });
        }
    });
    
    updateProgressSteps(0);

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate all fields
        let allValid = true;
        fields.forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (field && !validateField(field)) {
                allValid = false;
            }
        });
        
        if (!allValid) {
            return;
        }
        
        submitButton.disabled = true;
        submitButton.querySelector('.btn-text').classList.add('d-none');
        submitButton.querySelector('.btn-loading').classList.remove('d-none');
        successMsg.classList.add('d-none');
        errorMsg.classList.add('d-none');
        
        const formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            submitButton.disabled = false;
            submitButton.querySelector('.btn-text').classList.remove('d-none');
            submitButton.querySelector('.btn-loading').classList.add('d-none');
            
            if (data.success) {
                // Reset form and validation states
                form.reset();
                resetFormValidation();
                successMsg.classList.remove('d-none');
                updateProgressSteps(0);
                
                // Hide success message after 5 seconds
                setTimeout(() => {
                    successMsg.classList.add('d-none');
                }, 5000);
            } else {
                errorText.textContent = data.message || '{{ __('messages.try_again') }}';
                errorMsg.classList.remove('d-none');
            }
        })
        .catch(error => {
            submitButton.disabled = false;
            submitButton.querySelector('.btn-text').classList.remove('d-none');
            submitButton.querySelector('.btn-loading').classList.add('d-none');
            errorText.textContent = '{{ __('messages.error_occurred') }}';
            errorMsg.classList.remove('d-none');
        });
    });
    
    // Reset form validation
    function resetFormValidation() {
        fields.forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (field) {
                field.classList.remove('is-valid', 'is-invalid');
            }
        });
        
        // Reset character counter
        const charCount = document.getElementById('charCount');
        if (charCount) {
            charCount.textContent = '0';
        }
        
        // Reset progress steps
        updateProgressSteps(0);
    }
    
    // Character counter
    const messageInput = document.getElementById('message');
    const charCount = document.getElementById('charCount');
    if (messageInput && charCount) {
        messageInput.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
    }
});
</script>
@endsection
