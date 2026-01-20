window.addEventListener('DOMContentLoaded', event => {

    // Navbar shrink function
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink')
        } else {
            navbarCollapsible.classList.add('navbar-shrink')
        }

    };

    // Shrink the navbar 
    navbarShrink();

    // Shrink the navbar when page is scrolled
    document.addEventListener('scroll', navbarShrink);

    // Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            rootMargin: '0px 0px -40%',
        });
    };

    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

    // Activate SimpleLightbox plugin for portfolio items
    new SimpleLightbox({
        elements: '#portfolio a.portfolio-box'
    });

    // Initialize EmailJS
    //emailjs.init("B2gi8tQi6jqZmwrcF");

    // Form validation functions
    function validateName(name) {
        return name.trim().length >= 2;
    }

    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function validatePhone(phone) {
        const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
        return phoneRegex.test(phone.replace(/[\s\-\(\)]/g, ''));
    }

    function validateSubject(subject) {
        return subject && subject !== '';
    }

    function validateMessage(message) {
        return message.trim().length >= 10;
    }

    function showFieldError(fieldId, message) {
        const field = document.getElementById(fieldId);
        const feedback = field.parentNode.querySelector('.invalid-feedback');
        field.classList.add('is-invalid');
        if (feedback) {
            feedback.textContent = message;
        }
    }

    function clearFieldError(fieldId) {
        const field = document.getElementById(fieldId);
        field.classList.remove('is-invalid');
    }

    function resetForm() {
        const contactForm = document.getElementById('contactForm');
        if (contactForm) {
            contactForm.reset();
            // Clear all validation errors
            const fields = ['name', 'email', 'phone', 'subject', 'message'];
            fields.forEach(fieldId => clearFieldError(fieldId));
            // Reset progress steps
            updateProgressSteps(1);
            // Reset character counter
            updateCharacterCounter(0);
        }
    }

    function updateProgressSteps(currentStep) {
        const steps = document.querySelectorAll('.progress-step');
        steps.forEach((step, index) => {
            const stepNumber = index + 1;
            step.classList.remove('active', 'completed');
            if (stepNumber < currentStep) {
                step.classList.add('completed');
            } else if (stepNumber === currentStep) {
                step.classList.add('active');
            }
        });
    }

    function updateCharacterCounter(count) {
        const charCount = document.getElementById('charCount');
        const counter = document.querySelector('.character-counter');
        if (charCount) {
            charCount.textContent = count;
        }
        if (counter) {
            counter.classList.remove('near-limit', 'at-limit');
            if (count >= 900) {
                counter.classList.add('at-limit');
            } else if (count >= 800) {
                counter.classList.add('near-limit');
            }
        }
    }

    // Handle contact form submission
    const contactForm = document.getElementById('contactForm');
    // If the contact form is present but marked to be handled by Blade inline JS, skip legacy handler
    const handledByBlade = contactForm && contactForm.getAttribute('data-handler') === 'blade';
    if (contactForm && !handledByBlade) {
        // Reset form on page load/refresh
        resetForm();

        // Add real-time validation and progress tracking
        const fields = ['name', 'email', 'phone', 'subject', 'message'];
        let currentStep = 1;
        
        fields.forEach((fieldId, index) => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.addEventListener('blur', function() {
                    const value = this.value.trim();
                    let isValid = true;
                    let errorMessage = '';

                    switch(fieldId) {
                        case 'name':
                            isValid = validateName(value);
                            errorMessage = 'Name must be at least 2 characters long';
                            break;
                        case 'email':
                            isValid = validateEmail(value);
                            errorMessage = 'Please enter a valid email address';
                            break;
                        case 'phone':
                            isValid = validatePhone(value);
                            errorMessage = 'Please enter a valid phone number';
                            break;
                        case 'subject':
                            isValid = validateSubject(value);
                            errorMessage = 'Please select a subject';
                            break;
                        case 'message':
                            isValid = validateMessage(value);
                            errorMessage = 'Message must be at least 10 characters long';
                            break;
                    }

                    if (!isValid && value !== '') {
                        showFieldError(fieldId, errorMessage);
                    } else {
                        clearFieldError(fieldId);
                        if (isValid && value !== '') {
                            // Show success feedback
                            field.classList.add('is-valid');
                        }
                    }
                    
                    // Update progress steps based on completed fields
                    updateFormProgress();
                });

                field.addEventListener('input', function() {
                    // Clear error when user starts typing
                    clearFieldError(fieldId);
                    field.classList.remove('is-valid');
                    
                    // Handle character counter for message field
                    if (fieldId === 'message') {
                        const count = this.value.length;
                        updateCharacterCounter(count);
                    }
                });

                field.addEventListener('focus', function() {
                    // Update current step when field is focused
                    currentStep = index + 1;
                    updateProgressSteps(currentStep);
                });
            }
        });

        function updateFormProgress() {
            let completedFields = 0;
            fields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field && field.value.trim() !== '' && !field.classList.contains('is-invalid')) {
                    completedFields++;
                }
            });
            
            const progressStep = Math.min(completedFields + 1, 4);
            updateProgressSteps(progressStep);
        }

        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value.trim();
            
            // Validate all fields
            let isValid = true;
            
            if (!validateName(name)) {
                showFieldError('name', 'Name must be at least 2 characters long');
                isValid = false;
            }
            
            if (!validateEmail(email)) {
                showFieldError('email', 'Please enter a valid email address');
                isValid = false;
            }
            
            if (!validatePhone(phone)) {
                showFieldError('phone', 'Please enter a valid phone number');
                isValid = false;
            }
            
            if (!validateSubject(subject)) {
                showFieldError('subject', 'Please select a subject');
                isValid = false;
            }
            
            if (!validateMessage(message)) {
                showFieldError('message', 'Message must be at least 10 characters long');
                isValid = false;
            }
            
            if (!isValid) {
                return; // Stop submission if validation fails
            }
            
            // Show loading state
            const submitButton = document.getElementById('submitButton');
            const btnText = submitButton.querySelector('.btn-text');
            const btnLoading = submitButton.querySelector('.btn-loading');
            
            btnText.classList.add('d-none');
            btnLoading.classList.remove('d-none');
            submitButton.disabled = true;
            
            // Prepare email parameters
            const templateParams = {
                to_email: 'ma4482604@gmail.com',
                from_name: name,
                from_email: email,
                phone: phone,
                subject: subject,
                message: message
            };
            
            // Send email using EmailJS
            emailjs.send('service_nq95css', 'template_et777gq', templateParams)
                .then(function(response) {
                    // Show success message
                    document.getElementById('submitSuccessMessage').classList.remove('d-none');
                    
                    // Reset form and clear validation errors
                    resetForm();
                    // Clear validation classes and messages
                    clearAllValidationStates();
                    
                    // Reset button
                    btnText.classList.remove('d-none');
                    btnLoading.classList.add('d-none');
                    submitButton.disabled = false;
                    
                    // Hide success message after 5 seconds
                    setTimeout(() => {
                        document.getElementById('submitSuccessMessage').classList.add('d-none');
                    }, 5000);
                }, function(error) {
                    // Show error message
                    document.getElementById('submitErrorMessage').classList.remove('d-none');
                    
                    // Reset button
                    btnText.classList.remove('d-none');
                    btnLoading.classList.add('d-none');
                    submitButton.disabled = false;
                    // Clear validation classes and messages
                    clearAllValidationStates();
                    
                    // Hide error message after 5 seconds
                    setTimeout(() => {
                        document.getElementById('submitErrorMessage').classList.add('d-none');
                    }, 5000);
                });
        });
    }

    // Helper to clear all validation states/messages
    function clearAllValidationStates() {
        const fields = ['name', 'email', 'phone', 'subject', 'message'];
        fields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.classList.remove('is-valid', 'is-invalid');
                const validFeedback = field.parentNode.querySelector('.valid-feedback');
                const invalidFeedback = field.parentNode.querySelector('.invalid-feedback');
                if (validFeedback) validFeedback.style.display = 'none';
                if (invalidFeedback) invalidFeedback.style.display = 'none';
            }
        });
    }

});
