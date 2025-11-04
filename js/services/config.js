const config = {
    api: {
        baseUrl: process.env.NODE_ENV === 'production' 
            ? '/bina-adult-care-main/public/api'
            : 'http://localhost:8000/api',
        endpoints: {
            services: '/services',
            content: '/content',
            contact: '/contact',
            auth: '/auth'
        }
    },
    auth: {
        tokenKey: 'adminToken'
    },
    upload: {
        allowedTypes: ['image/jpeg', 'image/png', 'image/gif'],
        maxFileSize: 5 * 1024 * 1024 // 5MB
    }
};

export default config;