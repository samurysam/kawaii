# Kawaii Blessings Branding Kit & Laravel Theme System Specification

## Purpose

This document defines the Kawaii Blessings brand system and how it should be implemented across the Laravel e-commerce storefront, category pages, product pages, internal dashboards, customer journeys, checkout, and transactional emails.

The goal is to ensure that the entire platform feels:

- cute
- soft
- premium pastel
- playful
- feminine
- giftable
- highly consistent across all customer-facing and admin interfaces

This spec should be used by Codex / MCP / theme-manager logic to standardize:

- colors
- typography
- buttons
- cards
- banners
- spacing
- borders
- forms
- navigation
- dashboard styling
- reusable components

## 1. Brand Identity

### Brand Name

**Kawaii Blessings**

### Brand Tone

Kawaii Blessings should feel like:

- soft
- sweet
- happy
- charming
- welcoming
- collectible
- authentic
- gift-friendly
- pastel-premium

### Brand Personality Keywords

- Cute
- Authentic
- Soft
- Playful
- Giftable
- Pastel Premium
- Cheerful
- Warm
- Collectible
- Feminine but clean

### Emotional Objective

The interface should make users feel:

- delighted
- safe buying
- surrounded by cuteness
- emotionally connected to products
- encouraged to browse and gift
- comfortable staying longer on the site

## 2. Core Visual Direction

### Overall Design Language

The UI should follow these visual principles:

- rounded, soft shapes
- blush pink dominant palette
- white and cream negative space
- subtle shadows, never harsh
- light pastel accent colors
- visually airy layouts
- playful motifs like hearts, bows, stars, clouds
- product-first presentation with cute supporting decoration
- premium softness rather than childish clutter

### Visual Mood

Think:

- pastel boutique
- kawaii stationery shop
- soft gift shop
- cute character retail
- elegant pink ecommerce

## 3. Brand Color Palette

### Primary Palette

| Token | Name | Hex | Usage |
| --- | --- | --- | --- |
| `bg.base` | Blush Cloud | `#FFF6FA` | Main page background |
| `bg.card` | Cotton Pink | `#FAD9E5` | Soft tinted cards / section fills |
| `brand.primary` | Bubblegum Pink | `#F58FB0` | Main brand color |
| `brand.accent` | Rose Candy | `#ED6E98` | CTA emphasis / hover / highlights |
| `text.primary` | Cocoa Berry | `#5B3A45` | Primary text |
| `accent.info` | Lavender Pop | `#D9C8F3` | Soft info state / badges |
| `accent.success` | Mint Mousse | `#DDF2E6` | Success state / positive notices |
| `accent.highlight` | Butter Cream | `#FFF1B8` | Notice / highlight backgrounds |
| `neutral.white` | White Sugar | `#FFFFFF` | Surface / cards / inputs |

### Support Colors

| Token | Name | Hex | Usage |
| --- | --- | --- | --- |
| `border.soft` | Petal Line | `#F4C7D6` | Borders / dividers |
| `shadow.pink` | Pink Shadow | `rgba(237, 110, 152, 0.12)` | Soft shadows |
| `shadow.deep` | Cocoa Shadow | `rgba(91, 58, 69, 0.08)` | Elevated cards |
| `text.secondary` | Warm Mauve | `#8A6772` | Secondary text |
| `text.muted` | Pale Cocoa | `#B08D98` | Low emphasis text |
| `state.error` | Soft Berry | `#E77C9B` | Error badges / alerts |
| `state.warning` | Cream Gold | `#F7E5A6` | Warning state |

### Usage Rules

- Pink tones should dominate customer-facing layouts.
- Dark text should always be warm-toned, never pure black.
- Avoid saturated neon pinks.
- Keep strong accent color usage limited to CTA areas, prices, badges, links, and highlights.
- White / blush backgrounds should balance colorful sections.
- Dashboard pages should use cleaner, lighter application of the same palette.

## 4. Gradients

### Primary Brand Gradients

#### Sweet Blush Gradient

```css
linear-gradient(135deg, #FFF6FA 0%, #FAD9E5 100%)
```

#### Candy CTA Gradient

```css
linear-gradient(135deg, #F9A8C2 0%, #ED6E98 100%)
```

#### Soft Premium Gradient

```css
linear-gradient(135deg, #FFFFFF 0%, #FFF6FA 45%, #FAD9E5 100%)
```

### Usage

Use gradients for:

- hero banners
- CTA buttons
- featured panels
- promotional strips
- premium highlighted cards

Avoid overusing gradients in tables or data-heavy dashboard screens.

## 5. Typography System

### Heading / Display Font

Use one of the following for hero and display text:

- **Fredoka**
- **Baloo 2**

Used for:

- hero headings
- major banners
- category headers
- cute promotional statements
- campaign blocks

Characteristics:

- rounded
- cheerful
- soft
- highly readable
- playful without losing professionalism

### Accent / Editorial Font

Use:

- **DM Serif Display**

Used for:

- accent headings
- romantic premium feel
- mini banner accent text
- decorative section headings
- brand storytelling blocks

### UI / Body Font

Use one of:

- **Nunito Sans**
- **Poppins**

Used for:

- body text
- product descriptions
- labels
- inputs
- menus
- filters
- admin UI
- dashboard interface

Characteristics:

- clean
- rounded
- readable
- minimal
- modern

### Typography Rules

- Main hero: large rounded display font
- Section titles: rounded or serif display depending on context
- Dashboard section titles: use clean sans-serif with medium-bold weight
- Avoid overly condensed fonts
- Use soft dark brown instead of black
- Comfortable line spacing
- Readability first

### Font Scale Suggestion

| Element | Desktop | Tablet | Mobile |
| --- | --- | --- | --- |
| Hero H1 | 56px | 44px | 32px |
| Section H2 | 34px | 28px | 24px |
| Section H3 | 26px | 22px | 20px |
| Body Large | 18px | 17px | 16px |
| Body Base | 16px | 15px | 14px |
| Caption | 14px | 13px | 12px |

## 6. Motifs & Decorative Language

### Approved Decorative Motifs

- hearts
- bows
- stars
- clouds
- sparkles
- rounded ribbons
- cute mini icons
- plush-inspired shapes

### Usage Rules

- Use sparingly as supporting decoration
- Do not clutter product cards
- Hero banners and promotional areas can use more decoration
- Dashboard usage should be much lighter and more minimal
- Decorative illustrations should support, not overpower, content

## 7. Border Radius, Shadows & Surface Styling

### Border Radius

| Element | Radius |
| --- | --- |
| Buttons | `999px` |
| Cards | `20px` |
| Product cards | `18px` |
| Inputs | `16px` |
| Banner panels | `24px` |
| Modal windows | `24px` |
| Small badges | `999px` |

### Shadows

#### Soft Card Shadow

```css
0 8px 24px rgba(237, 110, 152, 0.08)
```

#### Hover Shadow

```css
0 12px 32px rgba(237, 110, 152, 0.14)
```

#### Dashboard Card Shadow

```css
0 6px 18px rgba(91, 58, 69, 0.06)
```

### Surface Rules

- Prefer white surfaces on blush backgrounds
- Use pale pink surface tint for promotional zones
- Keep borders soft and thin
- Avoid high contrast outlines

## 8. Core UI Style Rules

1. Use large rounded corners throughout the system.
2. Use pill-shaped buttons for primary CTAs.
3. Use soft shadows with pink tinting.
4. Use white cards over pastel backgrounds.
5. Keep layouts airy with comfortable spacing.
6. Prefer icons with rounded outlines and cute shapes.
7. Never let the UI become visually harsh or corporate gray.
8. Storefront may be more decorative; dashboard should be cleaner and more operational.
9. Maintain a premium-cute balance.
10. Preserve strong consistency across banners, collections, filters, and CTA blocks.

## 9. Component Design System

### 9.1 Primary Button

Main actions like Shop Now, Add to Cart, Buy Now, View Collection, and Continue Checkout should use:

- gradient pink fill
- pill shape
- white text
- soft shadow
- slightly raised look

### 9.2 Secondary Button

Used for View Collection, Learn More, Wishlist, and See Details:

- white or blush background
- pink border
- pink text
- pill shape

### 9.3 Product Card

Rules:

- white surface
- soft rounded corners
- subtle shadow
- large clean product image
- price emphasized in pink
- title in cocoa brown
- optional badge like New / Sale / Best Seller
- wishlist icon subtle and rounded
- hover lift effect
- image area should have clean pastel background if needed

### 9.4 Category Tile

Rules:

- pastel background
- centered icon / illustration
- rounded large tile
- minimal text
- cute and clean
- use distinct pastel per category while staying within overall palette

Suggested category backgrounds:

| Category | Background |
| --- | --- |
| Accessories | `#FCE6EE` |
| Stationery | `#E9DDF9` |
| Lifestyle | `#FFF2BF` |
| Plushies | `#FFE6F0` |
| Gifts | `#E6F6F3` |
| Sale | `#FEE1EB` |

### 9.5 Announcement Bar / Scroller

Style direction:

- slim but expressive
- scrolling or sliding messages
- blush / pastel background
- pink / cocoa typography
- light decorative icons allowed

### Example Content Types

- authenticity guarantee
- promo code / discount
- free shipping thresholds
- UAE-specific promotion

## 10. Implementation Appendix

### Shared Tokens

These token names should remain stable across shop, admin, customer, checkout, and email surfaces:

| Token | Value |
| --- | --- |
| `--kb-bg-base` | `#fff6fa` |
| `--kb-bg-soft` | `#fad9e5` |
| `--kb-surface` | `#ffffff` |
| `--kb-surface-muted` | `#fff9fc` |
| `--kb-primary` | `#f58fb0` |
| `--kb-primary-strong` | `#ed6e98` |
| `--kb-primary-soft` | `#f9a8c2` |
| `--kb-text` | `#5b3a45` |
| `--kb-text-soft` | `#8a6772` |
| `--kb-text-muted` | `#b08d98` |
| `--kb-border` | `#f4c7d6` |
| `--kb-border-strong` | `#efadc4` |
| `--kb-info` | `#d9c8f3` |
| `--kb-success` | `#ddf2e6` |
| `--kb-warning` | `#fff1b8` |
| `--kb-error` | `#e77c9b` |
| `--kb-shadow-soft` | `0 8px 24px rgba(237, 110, 152, 0.08)` |
| `--kb-shadow-hover` | `0 12px 32px rgba(237, 110, 152, 0.14)` |
| `--kb-shadow-admin` | `0 6px 18px rgba(91, 58, 69, 0.06)` |
| `--kb-gradient-soft` | `linear-gradient(135deg, #fff6fa 0%, #fad9e5 100%)` |
| `--kb-gradient-cta` | `linear-gradient(135deg, #f9a8c2 0%, #ed6e98 100%)` |
| `--kb-gradient-premium` | `linear-gradient(135deg, #ffffff 0%, #fff6fa 45%, #fad9e5 100%)` |

### Surface-Specific Tokens

These may vary by surface while keeping shared tokens intact:

| Surface | Tokens |
| --- | --- |
| Storefront | `--kb-surface-page`, `--kb-surface-panel`, `--kb-surface-hero`, `--kb-shell-accent` |
| Customer auth/account | `--kb-auth-panel`, `--kb-account-card`, `--kb-account-sidebar` |
| Checkout | `--kb-checkout-panel`, `--kb-checkout-summary`, `--kb-checkout-step` |
| Admin | `--kb-admin-bg`, `--kb-admin-panel`, `--kb-admin-nav`, `--kb-admin-active` |
| Email | `--kb-email-bg`, `--kb-email-panel`, `--kb-email-accent` |

### Font Stack Contract

- Display / Hero: `"Fredoka", "Baloo 2", cursive`
- Editorial Accent: `"DM Serif Display", Georgia, serif`
- UI / Body: `"Nunito Sans", "Poppins", sans-serif`

### Spacing System

- `--kb-space-1`: `0.25rem`
- `--kb-space-2`: `0.5rem`
- `--kb-space-3`: `0.75rem`
- `--kb-space-4`: `1rem`
- `--kb-space-5`: `1.25rem`
- `--kb-space-6`: `1.5rem`
- `--kb-space-8`: `2rem`
- `--kb-space-10`: `2.5rem`
- `--kb-space-12`: `3rem`

### Radius System

- `--kb-radius-xs`: `12px`
- `--kb-radius-sm`: `16px`
- `--kb-radius-md`: `20px`
- `--kb-radius-lg`: `24px`
- `--kb-radius-pill`: `999px`

### Button Rules

- Primary buttons use `--kb-gradient-cta`, white text, pill radius, and hover lift.
- Secondary buttons use white or blush background, soft pink border, and cocoa or rose text.
- Focus states use a soft pink ring: `0 0 0 4px rgba(245, 143, 176, 0.18)`.
- Disabled buttons keep readable text and reduced opacity, with no harsh gray.

### Card Rules

- Default cards are white with soft pink borders and either `--kb-shadow-soft` or `--kb-shadow-admin`.
- Product cards should lift slightly on hover and keep the image area airy.
- Admin cards use the same palette with lower decoration density.

### Form Rules

- Inputs, selects, and textareas use white or blush-tinted backgrounds.
- Borders are soft pink, never dark gray by default.
- Labels use cocoa text with medium weight.
- Errors use soft berry text and blush-tinted backgrounds rather than strong red blocks.

### Status Rules

- Success: mint surface with cocoa text
- Warning: butter cream surface with cocoa text
- Info: lavender surface with cocoa text
- Error: blush berry surface with white or cocoa text based on density

### Surface Guidance

#### Storefront

- Use blush or premium gradients for shell backgrounds.
- Keep white content cards and rounded promotional panels.
- Product discovery should feel airy, giftable, and polished.

#### Admin

- Keep full kawaii branding, but reduce decorative density.
- Prioritize readability of forms, tables, and navigation states.
- Sidebars and shell chrome should use blush/white panels with warm active states.

#### Customer Auth / Account

- Use centered premium cards with strong display headings.
- Maintain a gentle, reassuring tone.
- Account navigation and cards should feel lighter than admin, but more structured than the home page.

#### Checkout

- Emphasize trust, simplicity, and warmth.
- Use rounded summary cards, blush section headers, and clear CTA hierarchy.
- Payment and shipping choices should stay easy to scan.

#### Email

- Use email-safe HTML with brand colors and generous spacing.
- Keep a soft branded header, rounded content panels, and a calm cocoa footer.
- Reuse the same button and typography hierarchy wherever mail client support allows.
