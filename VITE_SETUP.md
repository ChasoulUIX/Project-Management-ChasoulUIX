# Vite + TailwindCSS Setup Guide

## 🚀 Setup Selesai!

Project ini sudah dikonfigurasi dengan:
- ✅ Vite v6.0.11
- ✅ TailwindCSS v4.0.0
- ✅ Laravel Vite Plugin v1.2.0
- ✅ Auto-reload untuk CSS dan JS

## 📁 Struktur File

```
public/
├── index.php          # Entry point Laravel
├── .htaccess          # Apache rewrite rules
├── robots.txt         # SEO configuration
├── favicon.ico        # Site icon
└── web.config         # IIS configuration

resources/
├── css/
│   ├── app.css        # TailwindCSS + Custom styles (Main)
│   └── admin.css      # Admin layout specific styles
├── js/
│   ├── app.js         # Main JavaScript
│   └── bootstrap.js   # Axios configuration
└── views/
    ├── layouts/
    │   └── app.blade.php      # Main layout dengan @vite directive
    └── admin/
        └── layouts/
            └── app.blade.php  # Admin layout dengan @vite directive
```

## 🎯 Cara Menggunakan

### 1. Install Dependencies (Sudah dilakukan)
```bash
npm install
```

### 2. Jalankan Vite Dev Server
```bash
npm run dev
```
Server akan berjalan di: `http://localhost:5173/`

### 3. Build untuk Production
```bash
npm run build
```

## 🎨 TailwindCSS Auto-Reload

TailwindCSS akan otomatis reload saat Anda:
- ✅ Mengubah file `.blade.php`
- ✅ Mengubah file `.js`
- ✅ Mengubah `resources/css/app.css`
- ✅ Menambah/mengubah class TailwindCSS

## 📝 Menggunakan di Blade Template

### Main Layout (`resources/views/layouts/app.blade.php`)

```blade
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

### Admin Layout (`resources/views/admin/layouts/app.blade.php`)

```blade
@vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'])
```

### Contoh Halaman

Untuk halaman biasa, extend main layout:

```blade
@extends('layouts.app')

@section('title', 'Halaman Saya')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-blue-500">Hello World!</h1>
    </div>
@endsection
```

Untuk halaman admin, extend admin layout:

```blade
@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold">Admin Content</h1>
    </div>
@endsection
```

## 🎨 Custom Styles

### Main Layout (`resources/css/app.css`)
- Custom scrollbar
- Gradient animation
- Glass effect
- Smooth transitions
- Custom colors (dark-primary, dark-secondary)

### Admin Layout (`resources/css/admin.css`)
- Navigation link animations
- Sidebar menu effects
- Menu item hover states
- Section title styling
- Dark mode input styles

## 🔧 Custom Classes yang Tersedia

### Main Layout Classes
```css
.animate-gradient     /* Animated gradient background */
.glass-effect         /* Backdrop blur effect */
bg-dark-primary       /* #0F172A (Admin) / #1a1b1e (Main) */
bg-dark-secondary     /* #1E293B (Admin) / #25262b (Main) */
bg-dark-accent        /* #334155 (Admin only) */
```

### Admin Layout Classes
```css
.nav-link            /* Navigation link with animation */
.nav-link.active     /* Active navigation state */
.menu-item           /* Sidebar menu item */
.menu-item.active    /* Active menu state */
.menu-icon           /* Menu icon with hover effect */
.menu-text           /* Menu text with animation */
.section-title       /* Section title with accent bar */
.sidebar-scroll      /* Custom scrollbar for sidebar */
```

## 🚨 Troubleshooting

### Vite tidak bisa start?
```bash
# Hapus node_modules dan install ulang
rm -rf node_modules package-lock.json
npm install
npm run dev
```

### CSS tidak auto-reload?
- Pastikan Vite dev server berjalan (`npm run dev`)
- Refresh browser dengan Ctrl+F5 (hard refresh)
- Check console browser untuk error

### Production build error?
```bash
# Clear cache Laravel
php artisan cache:clear
php artisan view:clear

# Build ulang
npm run build
```

## 📦 Package.json Scripts

```json
{
  "dev": "vite",           // Development server
  "build": "vite build"    // Production build
}
```

## 🌐 Akses Aplikasi

- **Development**: `http://127.0.0.1:8000` (Laravel) + `http://localhost:5173` (Vite)
- **Production**: `http://127.0.0.1:8000` (Laravel dengan built assets)

## ⚡ Tips

1. **Selalu jalankan `npm run dev`** saat development
2. **Gunakan `npm run build`** sebelum deploy ke production
3. **TailwindCSS v4** menggunakan `@theme` directive untuk custom config
4. **Hot Module Replacement (HMR)** sudah aktif untuk instant updates

---

**Happy Coding! 🎉**
