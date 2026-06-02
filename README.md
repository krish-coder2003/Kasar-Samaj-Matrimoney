# Kasar Samaj Matrimony Platform

A premium, full-stack matrimony platform specifically designed for the Kasar Samaj community. This application facilitates meaningful connections through secure profile management, real-time communication, and a community-centric user experience.

## 🚀 Project Overview

The Kasar Samaj Matrimony platform is a comprehensive digital solution for matrimonial search. Built with a focus on trust, security, and real-time interaction, it features a robust administrative backend and a modern, mobile-responsive frontend.

## 🛠️ Tech Stack

- **Backend**: Laravel 12.x (PHP 8.2+), PHPUnit
- **Frontend**: Blade Templates, Tailwind CSS 4.x, Hotwire Turbo (for SPA-like feel)
- **Real-time**: Laravel Reverb (WebSocket Server), Laravel Echo
- **Database**: MySQL (optimized for relational profile data)
- **Tooling**: Vite, Axios, Composer, NPM

## ✨ Key Features

### 1. Real-Time Communication
- **Instant Messaging**: Integrated WebSocket-based chat system using Laravel Reverb and Echo.
- **Dynamic Updates**: Real-time message delivery and notification system without page refreshes.

### 2. Trust-Centric Profile Management
- **Aadhaar Verification**: Admin-verified profiles to ensure community trust.
- **Advanced Privacy**: OTP-based account deletion with a 24-hour grace period for account recovery.
- **Rich Media**: Multi-photo upload and profile preview functionality.
- **Spotlight & Visibility**: Featured profiles (Spotlight) to increase match visibility.

### 3. Engagement & Networking
- **Interest System**: One-tap "Send Interest" to initiate connections.
- **Visitor Tracking**: Dashboard to monitor who visited the profile.
- **Success Stories**: Dedicated space to share and manage successful matches within the community.

### 4. Admin Command Center
- **User Moderation**: Dashboard for profile verification, spotlight management, and user oversight.
- **Content Management System (CMS)**: Manage FAQs, Legal Policies, and Success Stories directly.
- **Platform Analytics**: Overview of community growth and engagement.

### 5. Premium UI/UX
- **Mobile-First Design**: Fully responsive interface optimized for all screen sizes.
- **Smooth Navigation**: Implementation of Hotwire Turbo to eliminate page load lag and provide a seamless "App-like" experience.
- **Glassmorphic Aesthetics**: Modern, premium design system using curated Tailwind CSS 4 configurations.

## 📈 Technical Achievements & Contributions

- **Engineered a real-time chat architecture** from scratch using Laravel Reverb, replacing traditional polling for 100% live interaction.
- **Implemented a secure 2FA-like account deletion workflow** with a recovery banner system to prevent accidental data loss.
- **Optimized mobile performance** by refactoring global CSS and implementing dynamic viewport logic for chat and profile modals.
- **Standardized platform branding** by creating a centralized layout system and shared JS assets, reducing redundant code by ~30%.
- **Developed a background cleanup worker** (Laravel Console) to automate the pruning of deleted accounts after the grace period.

## 📂 Project Structure Highlights

- `app/Http/Controllers/ChatController.php`: Manages WebSocket event broadcasting for messages.
- `app/Http/Controllers/AccountDeletionController.php`: Handles secure deletion logic and grace period timing.
- `resources/views/layouts/`: Centralized Blade layouts for consistent branding.
- `database/migrations/`: Structured schema for profile verifications and community-specific attributes.

## ⚙️ Installation

```bash
# Clone the repository
git clone https://github.com/yourusername/kasar-samaj-matrimony.git

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Start the dev server
php artisan dev
```

---
*Developed with focus on community connection and modern web standards.*
