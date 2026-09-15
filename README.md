# Currency Exchange Platform (P2P & Reserve-Backed)

> **Full-featured Laravel 10 digital currency & crypto exchange script.** Supports automatic gateway payments, manual payment proofs, live rate calculations, proof of reserve, and user exchange desk. Reserve-backed swaps for USDT, Perfect Money, Payoneer, Mobile Money, and Fiat.

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=flat&logo=php)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

A Laravel currency-exchange and community platform for reserve-backed buy/sell of digital currencies (Payoneer, Perfect Money, USDT, bank/mobile money, and similar methods). Users place exchange orders, upload payment proof or pay through a gateway, and admins approve, cancel, or refund. A public forum, member profiles, support tickets, referrals, and a CMS sit around the exchange core.

**Stack:** Laravel 10 · Blade templates · MySQL · Bootstrap · Sanctum API


---

## Core exchange

- **Live calculator** on Home, Exchange, and the user dashboard. Send/receive pair selection, amount, min/max, reserve, and fee-aware receive amount.
- **Quick amounts** (100 / 500 / 1,000 / 5,000 / Max) and a **swap pair** button on the calculator.
- **Live quote panel** showing rate, fee, limit, and receive-side reserve before confirm.
- **Last pair memory** — the calculator restores the last send/receive/amount from the browser.
- **Dedicated Exchange page** (`/try/exchange`) with rate table plus pending and completed order feeds.
- **Live Rates & Fees** (`/rates`) — public buy/sell rates, min/max, fixed + percent fees, reserve, availability, **search**, **Buy/Sell filters**, and an Exchange shortcut per row.
- **Track Exchange** (`/track-exchange`) — look up an order by Exchange ID without logging in. Copy ID and print receipt.
- **How it works** (`/how-it-works`) — four-step public flow: quote → confirm → pay/proof → receive.
- **Platform status & proof of reserve** (`/status`) — completed/pending/today/member counters, live method reserves, and recently settled orders.
- **Public exchange history** (`/exchange/History`) and **public exchange detail** (`/exchange/{id}`) with copy/print receipt.
- **Guest start → login confirm** — calculator is public; confirmation requires an account.
- **Manual payment proof** — per-currency text/file fields configured by admin.
- **Automatic gateway payment** — when a send currency is linked to a payment gateway, a deposit is created and the user is redirected to pay.
- **Exchange statuses:** pending (0), approved (1), cancelled (2), refunded (3).
- **Reserve engine** — reserve checked on create and adjusted when admin approves.
- **Rate engine** — `buy_at` / `sell_at`, fixed charge, percent charge, and base-currency conversion.
- **Order review** — after a completed manual flow, users can leave a public review topic.
- **Exchange sitemap** (`/exchange.xml`) for approved orders.

## User account

- Register, login (username or email), logout.
- Referral registration (`/register/{reference}` or `?reference=`).
- Password reset via emailed verification code.
- Email verification, SMS verification, and Google Authenticator 2FA.
- Profile settings, avatar, about, country, and password change.
- User dashboard with pending/approved/refunded counts, referral bonus, recent exchanges, topics, tickets, and alerts.
- **In-app notifications** (`/user/notifications`) — exchange status list and recent support tickets.

## User exchange desk

- Create exchange, preview, confirm, attach transaction proof.
- Success page after submission.
- History filters: all, pending, approved, refunded.
- Exchange detail with pair, amounts, status, timestamps, copy ID, and print receipt.
- Transaction log of wallet movements.

## Wallet, deposit, withdraw

- User wallet balance.
- Deposit confirmation route for automatic gateways.
- Withdrawal request by currency, AJAX min/max and amount calculator, preview, and history.
- Admin approve/reject withdrawals.

## Referral & affiliate

- Unique referral link and email invite from the affiliate page.
- Multi-level commission configured by admin.
- Commission log and referred-users list.
- Commission credited when an exchange is approved.
- Referral bonus shown on the user dashboard.

## Community forum

- Three-level structure: Forum → Category → Sub-category → Topic.
- Home feed, all posts, forum boards, category and sub-category listings.
- Topic detail with views, comments, and up/down votes.
- Create, edit, and delete own topics (admin can require approval).
- Post search.
- Load-more comments (AJAX).
- Member public profile with topics, answers, up-votes, and down-votes.
- **Trust score** on member profiles from completed vs total exchanges, plus Verified / Trusted / New badges.
- Advertisement click tracking (`/ad-redirect/{hash}`).

## Support & contact

- Contact form creates a support ticket.
- User ticket list, open, reply, and attachment download.
- Admin ticket queues: all, pending, answered, closed.
- WhatsApp floating button and header contact number.
- Official-site warning banner (no Facebook/IMO/unofficial deals).
- Safe-use terms on the contact page.

## Content & CMS

- Page builder for About, Affiliation, and other custom pages (`/page/{slug}`).
- Policy pages (terms, privacy, refund) linked in the footer.
- Tutorial / how-to page with video and desk contacts.
- **News & blog listing** (`/blog`) and **blog search** (`/blog/search`).
- Blog detail with view counter.
- **FAQ page** (`/faq`) from CMS FAQ items, with fallback questions.
- **Newsletter subscribe** in the footer (subscriber list in admin).
- Cookie consent.
- SEO manager, dynamic meta, sitemaps (`/sitemap.xml`, `/exchange.xml`).
- Language pack manager and language switcher.
- Frontend section builder: banner, features, reserve, counters, how-to, FAQ, transactions, testimonials, blog, newsletter, about, mission, affiliation, CTA, contact.
- Template switcher and custom CSS.
- Logo, favicon, and theme color settings.

## Admin panel (`/admin`)

- Dashboard with exchange, user, post, and traffic stats.
- Currency CRUD: rates, charges, reserve, min/max, buy/sell flags, user input/proof fields, gateway link.
- Exchange queues: all / pending / approved / cancelled / refunded. Approve (reserve + referral commission), cancel, refund, delete, search.
- User manager: all / active / banned / email & SMS verified states. Edit, impersonate, email, login history, posts, tickets, deposits, withdrawals.
- Forum, category, and sub-category management.
- Topic moderation: pending / approved / reject / delete / comments.
- Automatic payment gateway configuration (activate, currencies, credentials).
- Withdrawal approve/reject and logs.
- Advertisement CRUD.
- Subscriber list and broadcast email.
- Referral level configuration and per-user referral tree.
- Transaction and login/IP reports.
- Email templates, SMTP, test mail.
- SMS templates, gateway, test SMS.
- Extensions (reCAPTCHA, analytics, and similar plugins).
- Notifications inbox, system info, cache clear, bug report.

## API (`/api`)

- General settings and language data.
- Login, register, password reset.
- Authenticated profile, password, dashboard.
- Withdraw methods / store / confirm / history.
- Deposit methods / insert / confirm / manual / history.
- Transaction list.
- Sanctum token auth.

Supported gateway IPN hooks (when gateway processors are present): PayPal, Stripe, Perfect Money, Skrill, Paytm, Payeer, Paystack, Voguepay, Flutterwave, Razorpay, Instamojo, Blockchain, Block.io, CoinPayments, Coingate, Coinbase Commerce, Mollie, Cashmaal.

## Trust & safety features

- Working-hours and live clock in the header, with **Open / Closed** desk status (6 AM – 10 PM, Asia/Dhaka).
- Live desk ticker of recently settled orders.
- Official contact and WhatsApp only.
- Guarantee copy and DMCA badge in the footer.
- Public rate/reserve transparency and a dedicated reserves page.
- Public order tracking by Exchange ID, copy ID, and printable receipt.
- Member trust score from completed exchanges.
- 2FA, email/SMS verification, and login history.
- Admin impersonation disabled on the public site; admin-only approve/refund.

## Premium frontend

- Navy + gold fintech theme (`assets/templates/basic/css/premium.css`).
- **Light / dark theme toggle** (saved in the browser).
- Sticky glass header, live clock, Track Order shortcut, Open/Closed badge.
- Glass exchange calculator with quote chips, quick amounts, and swap.
- Trust strip (completed orders, live methods, in-processing, desk hours).
- Four-step how-it-works strip on the home page.
- Refined cards, rate tables, sidebars, and dashboard widgets.
- Modern login, contact, FAQ, rates, track, blog, tutorial, profile, and receipt screens.
- Footer newsletter, policy links, and native WhatsApp button.
- Responsive layout for desktop and mobile, plus print-friendly receipts.

---

## Main public URLs

| Page | URL |
|------|-----|
| Home + calculator | `/` |
| Exchange | `/try/exchange` |
| Rates & fees | `/rates` |
| Track order | `/track-exchange` |
| How it works | `/how-it-works` |
| Platform status / reserves | `/status` |
| Forum | `/community/posts` |
| FAQ | `/faq` |
| News | `/blog` |
| Tutorial | `/tutorial` |
| Contact | `/contact` |
| Login / Register | `/login` · `/register` |
| User dashboard | `/user/dashboard` |
| Notifications | `/user/notifications` |
| Admin | `/admin` |

---

## Local setup

```bash
# from the core app directory
composer install
cp .env.example .env
php artisan key:generate
# configure DB_* in .env, then import the project SQL dump
php artisan storage:link
php artisan serve
```

The public web root is typically the parent project folder (so `assets/` and `core/` sit side by side). Point the vhost document root at that parent, not only `core/`.

Static assets live in `../assets` (`assets/templates/basic/` for the public theme, `assets/admin/` for the panel).

---

## License

Application code is project-specific. Laravel is MIT-licensed.

---

## 🤝 Let's Build Something Exceptional

I'm actively open to: **Remote Senior Full-Stack Roles · Freelance Contracts · Technical Partnerships · Long-Term Collaborations**

in Laravel · WordPress · React/Next.js · AI-powered Platforms · Security Audits · SaaS Architecture

- 📍 **Timezone:** UTC+6 (Dhaka/Rangpur) — flexible overlap for US, EU & Asia
- ⚡ **Available:** Immediately · Production-first · Fast delivery · Transparent communication

| Platform | Link |
|----------|------|
| 🌐 Portfolio | [imrandev.bd](https://imrandev.bd) |
| 💼 LinkedIn | [linkedin.com/in/imranbru99](https://linkedin.com/in/imranbru99) |
| 🐙 GitHub | [github.com/imranbru99](https://github.com/imranbru99) |
| 🐦 X / Twitter | [@imrandev_bd](https://x.com/imrandev_bd) |
| 📺 YouTube | [@ImranDevBD](https://youtube.com/@ImranDevBD) |
| 📸 Instagram | [@imranbru99](https://instagram.com/imranbru99) |
| 📘 Facebook | [ExpertImranDev](https://facebook.com/ExpertImranDev) |
| 🎵 TikTok | [@imrandev_bd](https://tiktok.com/@imrandev_bd) |
| 🧵 Threads | [@imranbru99](https://www.threads.net/@imranbru99) |
| 📌 Pinterest | [@imrandev_bd](https://pinterest.com/imrandev_bd) |
| 💬 WhatsApp | [+880 1576-918420](https://wa.me/8801576918420) |
| 📧 Email | [me@imrandev.bd](mailto:me@imrandev.bd) |
| 🔗 All Links | [linktr.ee/ExpertImranDev](https://linktr.ee/ExpertImranDev) |

> "Security isn't an add-on — it's the foundation. Scale, speed, and trust drive every line of code I write."
>
> — Imran Ahmed
>>>>>>> cbd730f (feat: initial commit for currency exchange platform)
