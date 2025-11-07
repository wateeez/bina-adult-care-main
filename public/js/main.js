const API_BASE_URL = 'http://localhost:8000/api';

// Function to fetch services from the API
async function fetchServices() {
    // Temporary placeholder data until API is working
    const sampleServices = [
        {
            title: 'Personal Care Assistance',
            description: 'Professional assistance with daily activities including bathing, dressing, grooming, and mobility support.',
            image_url: 'https://placehold.co/600x400/007bff/white?text=Personal+Care'
        },
        {
            title: 'Medication Management',
            description: 'Expert oversight and assistance with medication schedules, ensuring proper dosage and timing.',
            image_url: 'https://placehold.co/600x400/28a745/white?text=Medication'
        },
        {
            title: 'Companionship Services',
            description: 'Friendly companionship, conversation, and social engagement to enhance quality of life.',
            image_url: 'https://placehold.co/600x400/ffc107/white?text=Companionship'
        }
    ];
    displayServices(sampleServices);
}

// Function to display services in the services container
function displayServices(services) {
    const container = document.getElementById('services-container');
    if (!container) return;

    const serviceHTML = services.map(service => `
        <div class="col-md-4 mb-4">
            <div class="card service-card h-100">
                <img src="${service.image_url}" class="card-img-top" alt="${service.title}">
                <div class="card-body">
                    <h5 class="card-title">${service.title}</h5>
                    <p class="card-text">${service.description}</p>
                </div>
            </div>
        </div>
    `).join('');

    container.innerHTML = serviceHTML;
}

// Function to handle contact form submission
async function handleContactSubmission(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    
    // Temporary mock submission until API is working
    alert('Thank you for your message! We will contact you soon.\n\nNote: This is a demo message - the backend API is not yet connected.');
    form.reset();
}

// Mobile menu toggle
document.addEventListener('DOMContentLoaded', () => {
    // Initialize services if on home page
    if (document.getElementById('services-container')) {
        fetchServices();
    }
    
    // Set up contact form handler if on contact page
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', handleContactSubmission);
    }

    // Mobile menu toggle for all pages
    const menuToggle = document.querySelector('.menu-toggle');
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    const navMenu = document.getElementById('navMenu');

    // Function to toggle menu
    function toggleMenu() {
        if (navLinks) {
            navLinks.classList.toggle('active');
        }
        if (navMenu) {
            navMenu.classList.toggle('active');
        }
    }

    // Add click handlers
    if (menuToggle) {
        menuToggle.addEventListener('click', toggleMenu);
    }
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', toggleMenu);
    }

    // Make toggleMenu global for onclick handlers
    window.toggleMenu = toggleMenu;

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
        const navLinks = document.querySelector('.nav-links');
        const navMenu = document.getElementById('navMenu');
        const menuToggle = document.querySelector('.menu-toggle');
        const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
        
        if (navLinks && menuToggle && !navLinks.contains(e.target) && !menuToggle.contains(e.target)) {
            navLinks.classList.remove('active');
        }
        if (navMenu && mobileMenuToggle && !navMenu.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
            navMenu.classList.remove('active');
        }
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const target = document.querySelector(targetId);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                // Close mobile menu after clicking
                const navLinks = document.querySelector('.nav-links');
                const navMenu = document.getElementById('navMenu');
                if (navLinks) {
                    navLinks.classList.remove('active');
                }
                if (navMenu) {
                    navMenu.classList.remove('active');
                }
            }
        });
    });

    // Navbar scroll effect - disabled auto-hide
    const navbar = document.querySelector('.navbar') || document.querySelector('nav');
    
    if (navbar) {
        // Add transition
        navbar.style.transition = 'box-shadow 0.3s ease';
        
        window.addEventListener('scroll', () => {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Only change shadow, don't hide navbar
            if (scrollTop === 0) {
                navbar.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
            } else {
                navbar.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
            }
        });
    }
});