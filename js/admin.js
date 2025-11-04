// API Configuration
const API_CONFIG = {
    baseUrl: '/bina-adult-care-main/public/api',
    endpoints: {
        services: '/services',
        content: '/content',
        contact: '/contact'
    }
};

// API Service Class
class ApiService {
    async getHeaders() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        return {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        };
    }

    async request(endpoint, options = {}) {
        try {
            const url = API_CONFIG.baseUrl + endpoint;
            const response = await fetch(url, {
                ...options,
                headers: await this.getHeaders(),
                credentials: 'same-origin' // Include cookies for session handling
            });

            if (!response.ok) {
                if (response.status === 401) {
                    // Session expired or unauthorized
                    window.location.href = '/bina-adult-care-main/admin/login.php';
                    return;
                }

                const error = await response.json().catch(() => ({
                    message: 'An unknown error occurred'
                }));
                throw new Error(error.message || `HTTP error! status: ${response.status}`);
            }

            return response.json();
        } catch (error) {
            console.error('API request failed:', error);
            throw error;
        }
    }

    // Services CRUD operations
    async getServices() {
        return this.request(API_CONFIG.endpoints.services);
    }

    async createService(data) {
        return this.request(API_CONFIG.endpoints.services, {
            method: 'POST',
            body: JSON.stringify(data)
        });
    }

    async updateService(id, data) {
        return this.request(`${API_CONFIG.endpoints.services}/${id}`, {
            method: 'PUT',
            body: JSON.stringify(data)
        });
    }

    async deleteService(id) {
        return this.request(`${API_CONFIG.endpoints.services}/${id}`, {
            method: 'DELETE'
        });
    }
}

const apiService = new ApiService();

class AdminDashboard {
    constructor() {
        this.servicesList = document.getElementById('services-list');
        this.createForm = document.getElementById('create-service-form');
        this.editForm = document.getElementById('edit-service-form');
        this.setupEventListeners();
        this.loadServices();
    }

    // Event listeners setup
    setupEventListeners() {
        this.createForm?.addEventListener('submit', (e) => this.handleCreateService(e));
        this.editForm?.addEventListener('submit', (e) => this.handleUpdateService(e));
    }

    // Show loading state
    showLoading(element) {
        element.classList.add('loading');
        element.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
    }

    // Show notification
    showNotification(message, type = 'success') {
        const toast = document.getElementById('toast');
        if (toast) {
            toast.querySelector('.toast-body').textContent = message;
            toast.classList.remove('bg-success', 'bg-danger');
            toast.classList.add(type === 'success' ? 'bg-success' : 'bg-danger');
            toast.classList.add('text-white');
            bootstrap.Toast.getInstance(toast).show();
        }
    }

    // Load all services
    async loadServices() {
        try {
            this.showLoading(this.servicesList);
            const services = await apiService.getServices();
            this.renderServices(services);
        } catch (error) {
            this.showNotification(error.message, 'danger');
            this.servicesList.innerHTML = '<div class="alert alert-danger">Failed to load services</div>';
        }
    }

    // Render services list
    renderServices(services) {
        if (!this.servicesList) return;

        if (services.length === 0) {
            this.servicesList.innerHTML = '<div class="alert alert-info">No services available</div>';
            return;
        }

        this.servicesList.innerHTML = services.map(service => `
            <div class="card service-card" data-id="${service.id}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title">${this.escapeHtml(service.title)}</h5>
                            <p class="card-text">${this.escapeHtml(service.description)}</p>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-primary edit-service" data-id="${service.id}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger delete-service" data-id="${service.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    ${service.image_url ? `<img src="${this.escapeHtml(service.image_url)}" class="card-img-top mt-2" alt="${this.escapeHtml(service.title)}">` : ''}
                </div>
            </div>
        `).join('');

        // Add event listeners to edit and delete buttons
        this.servicesList.querySelectorAll('.edit-service').forEach(button => {
            button.addEventListener('click', () => this.handleEditClick(button.dataset.id));
        });

        this.servicesList.querySelectorAll('.delete-service').forEach(button => {
            button.addEventListener('click', () => this.handleDeleteClick(button.dataset.id));
        });
    }

// Function to create a new service
    // Handle create service form submission
    async handleCreateService(e) {
        e.preventDefault();
        const form = e.target;
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;

        try {
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Creating...';

            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            
            await apiService.createService(data);
            this.showNotification('Service created successfully');
            form.reset();
            bootstrap.Modal.getInstance(document.getElementById('createServiceModal')).hide();
            await this.loadServices();
        } catch (error) {
            this.showNotification(error.message, 'danger');
        } finally {
            submitButton.disabled = false;
            submitButton.innerHTML = originalText;
        }
    }

    // Handle edit button click
    async handleEditClick(serviceId) {
        try {
            const service = await apiService.getServices(serviceId);
            const form = this.editForm;
            if (!form) return;

            form.querySelector('#edit-id').value = service.id;
            form.querySelector('#edit-title').value = service.title;
            form.querySelector('#edit-description').value = service.description;
            form.querySelector('#edit-image_url').value = service.image_url || '';

            const modal = new bootstrap.Modal(document.getElementById('editServiceModal'));
            modal.show();
        } catch (error) {
            this.showNotification(error.message, 'danger');
        }
    }

    // Handle update service form submission
    async handleUpdateService(e) {
        e.preventDefault();
        const form = e.target;
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;

        try {
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Updating...';

            const formData = new FormData(form);
            const id = formData.get('id');
            const data = Object.fromEntries(formData.entries());
            delete data.id;

            await apiService.updateService(id, data);
            this.showNotification('Service updated successfully');
            bootstrap.Modal.getInstance(document.getElementById('editServiceModal')).hide();
            await this.loadServices();
        } catch (error) {
            this.showNotification(error.message, 'danger');
        } finally {
            submitButton.disabled = false;
            submitButton.innerHTML = originalText;
        }
    }

    // Handle delete button click
    async handleDeleteClick(serviceId) {
        if (!confirm('Are you sure you want to delete this service?')) return;

        try {
            await apiService.deleteService(serviceId);
            this.showNotification('Service deleted successfully');
            await this.loadServices();
        } catch (error) {
            this.showNotification(error.message, 'danger');
        }
    }

    // Utility method to escape HTML
    escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
}

// Initialize dashboard when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new AdminDashboard();
});

