# Admin System Setup Guide

## 🔐 New Admin System Features

### Security Features Implemented:
✅ **Email/Password Authentication** - Simple and secure login  
✅ **Strong Password Requirements** - 8+ chars, uppercase, lowercase, numbers, special characters  
✅ **Session Timeout** - Automatic logout after 30 minutes of inactivity  
✅ **Activity Logging** - All admin actions are tracked with IP addresses  
✅ **Role-Based Access Control** - Super Admin and Content Editor roles  

---

## 👥 Admin Roles

### 🔴 Super Admin
**Full system access including:**
- Create/Edit/Delete admin accounts
- Change any admin's password
- View activity logs
- Manage all website content (services, benefits, contacts, etc.)
- Assign roles to other admins

### 🟢 Content Editor
**Limited to content management:**
- Update services
- Manage benefits
- View contact messages
- Edit website content
- **Cannot** manage admin accounts or change passwords

---

## 🚀 Default Login Credentials

### Super Admin Account
```
Email: admin@binaadultcare.com
Password: Admin@123
```

### Content Editor Account
```
Email: editor@binaadultcare.com
Password: Editor@123
```

⚠️ **IMPORTANT**: Change these passwords immediately after first login!

---

## 🔑 Login Process

### Simple Login
1. Go to `/admin/login`
2. Enter your email and password
3. Click "Login"
4. You're in! Session expires after 30 minutes of inactivity

---

---

## 🛠️ Admin Management (Super Admin Only)

### Create New Admin
1. Go to **Admin Management** in sidebar
2. Click **"Create New Admin"**
3. Fill in:
   - Email address
   - Role (Super Admin or Content Editor)
   - Password (must meet strength requirements)
   - Confirm password
4. Click **"Create Admin Account"**

### Edit Admin
1. Go to **Admin Management**
2. Click **Edit** button next to admin
3. Update email, role, or account status
4. Click **"Update Admin"**

### Change Admin Password
1. Go to **Admin Management**
2. Click **Key icon** next to admin
3. Enter new password (meeting requirements)
4. Confirm password
5. Click **"Change Password"**

### Delete Admin
1. Go to **Admin Management**
2. Click **Delete** button (trash icon)
3. Confirm deletion
4. **Note**: You cannot delete your own account

---

## 📊 Activity Logs

### View All Activity
1. Go to **Admin Management**
2. Click **"View Activity Logs"**

### What's Tracked:
- Login/Logout events
- Failed login attempts
- Admin account creation/updates/deletion
- Service creation/updates/deletion
- Benefit creation/updates/deletion
- Contact message views/deletion
- Content updates
- Password changes

### Log Details Include:
- Timestamp
- Admin email who performed action
- Action type (create, update, delete, etc.)
- Module (services, benefits, admins, etc.)
- Description of change
- IP address
- Before/After values (for updates)

---

## 🔒 Password Requirements

When creating or changing passwords:
- ✅ Minimum 8 characters
- ✅ At least one uppercase letter (A-Z)
- ✅ At least one lowercase letter (a-z)
- ✅ At least one number (0-9)
- ✅ At least one special character (!@#$%^&*, etc.)

**Example valid passwords:**
- `MySecure@Pass123`
- `Admin$2025Secure`
- `BinaAdult!Care2025`

---

## 🚨 Security Best Practices

1. **Change Default Passwords**
   - Immediately change the default super admin password
   - Use unique, strong passwords for each admin

2. **Limit Super Admin Access**
   - Only create super admin accounts when absolutely necessary
   - Most users should be content editors

3. **Regular Password Updates**
   - Change passwords every 90 days
   - Never reuse old passwords

4. **Monitor Activity Logs**
   - Review logs regularly for suspicious activity
   - Check for failed login attempts

5. **Deactivate Unused Accounts**
   - Set `is_active` to false for former employees
   - Don't delete immediately (preserves activity history)

6. **Session Security**
   - Always logout when finished
   - Don't leave admin panel open on shared computers
   - Sessions auto-expire after 30 minutes

---

## 🐛 Troubleshooting

### "Session expired due to inactivity"
- Normal after 30 minutes of no activity
- Simply log in again

### "Access denied" error
- Content editors trying to access admin management
- Feature requires super admin privileges

### Forgot password
- Contact super admin to reset your password
- Super admins can change any user's password

---

## 📱 Testing the System

### Test Login Flow:
1. Visit: `http://your-domain.test/admin/login`
2. Enter super admin credentials
3. Verify dashboard loads with role badge (crown icon for super admin)

### Test Admin Creation:
1. Login as super admin
2. Go to Admin Management
3. Create new content editor
4. Logout and login with new account
5. Verify content editor can't see Admin Management

### Test Activity Logging:
1. Perform various actions (create service, update benefit, etc.)
2. Go to Activity Logs
3. Verify all actions are recorded

### Test Session Timeout:
1. Login to admin panel
2. Wait 31 minutes without activity
3. Try to navigate - should redirect to login

---

## 🎯 Quick Reference

| Feature | Super Admin | Content Editor |
|---------|-------------|----------------|
| View Dashboard | ✅ | ✅ |
| Manage Services | ✅ | ✅ |
| Manage Benefits | ✅ | ✅ |
| View Contacts | ✅ | ✅ |
| Manage Content | ✅ | ✅ |
| Create Admins | ✅ | ❌ |
| Edit Admins | ✅ | ❌ |
| Change Passwords | ✅ | ❌ |
| View Activity Logs | ✅ | ❌ |
| Delete Admins | ✅ | ❌ |

---

## 📝 Notes

- All passwords are hashed using bcrypt
- Activity logs are never deleted (for audit purposes)
- Sessions are stored in database for better security
- IP addresses are logged for security tracking

---

## 🆘 Support

For issues or questions:
1. Check the activity logs for errors
2. Review `storage/logs/laravel.log` for detailed errors
3. Ensure database migrations ran successfully
4. Verify `.env` configuration

**Migration Commands:**
```bash
# Fresh install
php artisan migrate:fresh --seed

# Just run new migrations
php artisan migrate

# Clear all caches
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```
