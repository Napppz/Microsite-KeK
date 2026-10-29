---
name: Sovereign Portal
colors:
  surface: '#031427'
  surface-dim: '#031427'
  surface-bright: '#2a3a4f'
  surface-container-lowest: '#000f21'
  surface-container-low: '#0b1c30'
  surface-container: '#102034'
  surface-container-high: '#1b2b3f'
  surface-container-highest: '#26364a'
  on-surface: '#d3e4fe'
  on-surface-variant: '#d9c3af'
  inverse-surface: '#d3e4fe'
  inverse-on-surface: '#213145'
  outline: '#a18d7c'
  outline-variant: '#534435'
  surface-tint: '#ffb86d'
  primary: '#ffbc76'
  on-primary: '#492900'
  primary-container: '#f29a2e'
  on-primary-container: '#613800'
  inverse-primary: '#8a5100'
  secondary: '#a9c9f0'
  on-secondary: '#0c3252'
  secondary-container: '#28496a'
  on-secondary-container: '#98b8de'
  tertiary: '#c8c8d0'
  on-tertiary: '#2e3036'
  tertiary-container: '#adadb4'
  on-tertiary-container: '#3f4147'
  error: '#ffb4ab'
  on-error: '#690005'
  error-container: '#93000a'
  on-error-container: '#ffdad6'
  primary-fixed: '#ffdcbd'
  primary-fixed-dim: '#ffb86d'
  on-primary-fixed: '#2c1600'
  on-primary-fixed-variant: '#683c00'
  secondary-fixed: '#d0e4ff'
  secondary-fixed-dim: '#a9c9f0'
  on-secondary-fixed: '#001d35'
  on-secondary-fixed-variant: '#28496a'
  tertiary-fixed: '#e2e2e9'
  tertiary-fixed-dim: '#c6c6cd'
  on-tertiary-fixed: '#1a1b21'
  on-tertiary-fixed-variant: '#45474c'
  background: '#031427'
  on-background: '#d3e4fe'
  surface-variant: '#26364a'
typography:
  display-hero:
    fontFamily: Inter
    fontSize: 48px
    fontWeight: '800'
    lineHeight: 56px
    letterSpacing: -0.02em
  display-hero-mobile:
    fontFamily: Inter
    fontSize: 32px
    fontWeight: '800'
    lineHeight: 40px
    letterSpacing: -0.015em
  headline-lg:
    fontFamily: Inter
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
    letterSpacing: -0.01em
  headline-lg-mobile:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
    letterSpacing: -0.01em
  headline-md:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
    letterSpacing: -0.005em
  headline-sm:
    fontFamily: Inter
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  title-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '600'
    lineHeight: 24px
  body-lg:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 26px
  body-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 22px
  body-sm:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '400'
    lineHeight: 18px
  label-lg:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '600'
    lineHeight: 20px
    letterSpacing: 0.01em
  label-md:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '600'
    lineHeight: 16px
    letterSpacing: 0.02em
  label-caps:
    fontFamily: Inter
    fontSize: 11px
    fontWeight: '700'
    lineHeight: 16px
    letterSpacing: 0.06em
rounded:
  sm: 0.125rem
  DEFAULT: 0.25rem
  md: 0.375rem
  lg: 0.5rem
  xl: 0.75rem
  full: 9999px
spacing:
  gutter: 1.5rem
  gutter-sm: 1rem
  margin: 2rem
  margin-sm: 1rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 1rem
  space-lg: 1.5rem
  space-xl: 2.5rem
---

## Brand & Style

This design system delivers an authoritative, high-trust digital environment engineered for state-level investment summits and Special Economic Zone (KEK - Kawasan Ekonomi Khusus) delegate operations. The aesthetic merges executive boardroom precision with rigorous civil-service institutionalism. It commands respect, ensures unwavering legitimacy for multinational investors, and communicates structural stability.

The design philosophy combines **Corporate / Modern** sobriety with an architectural, high-contrast grid system. Visual chrome and structural anchor zones leverage deep institutional darkness (#111318) to project solemn authority and executive presence. Data ingestion workspaces, registration verification forms, and credential tables leverage high-clarity contrast surfaces (#FFFFFF and #F1F3F5) to ensure zero ambiguity during high-throughput delegate scanning and real-time credentialing. 

Subtle gold/amber highlights evoke sovereignty, economic value, and premium execution without slipping into luxury consumerism. Visual noise, trendy blurs, and whimsical interactions are strictly avoided in favor of crisp delineation, meticulous alignment, and unambiguous operational clarity.

## Colors

The palette establishes an unshakeable hierarchy between administrative authority, operational utility, and immediate actionability:

- **Institutional Black (`#111318`)**: Dominates the macro architecture—navigation bars, page footers, summit briefing hero zones, credential pass frames, and high-level delegate status headers.
- **Corporate Blue (`#183B5B`)**: Provides institutional ballast. Applied to sectional titles, table header rows, secondary actions, badge backgrounds, and structural borders dividing high-priority data points.
- **Investment Amber (`#F29A2E`)**: Reserved strictly as the primary focal cue. Applied to primary call-to-action buttons (e.g., *Konfirmasi Kehadiran*, *Cetak ID Pass*), key credential highlights, active navigation indicators, and high-value metric callouts.
- **Surface Neutrals (`#FFFFFF` & `#F1F3F5`)**: Used for data-entry pods, attendee search bars, badge scanning preview viewports, and modal dialog bodies to guarantee AAA accessibility compliance and legibility under direct sunlight or scanner glare.
- **Slate Gray (`#64748B`)**: Dictates structural strokes, secondary label typography, inactive toggle borders, timestamps, and delegate designation metadata (*Instansi / Jabatan*).
- **Operational Status Tokens**:
  - `status-success` (`#10B981`): Delegate QR verified, check-in validated (*Registrasi Sukses*).
  - `status-warning` (`#F59E0B`): Duplicate scans, unverified protocol clearances (*Perhatian / Duplikasi*).
  - `status-error` (`#EF4444`): Invalid delegate credentials, blacklisted access, session expired (*Akses Ditolak*).

## Typography

Typography relies uniformly on **Inter** to ensure maximum typographic neutrality, flawless numeral alignment (tabular figures for pass codes and passport identifiers), and reliable multilingual/Indonesian rendering.

### Hierarchy & Composition Rules
- **Formal Indonesian Nomenclature**: Headings and action patterns use official institutional terminology (*Kawasan Ekonomi Khusus, Forum Bisnis Terpadu, Verifikasi Akreditasi, Unduh Surat Keputusan*).
- **Tabular Figures**: Numeric outputs, delegate registration IDs, and quota counters must activate tabular figures (`font-variant-numeric: tabular-nums`) to prevent horizontal jitter during real-time attendance polling.
- **Label Capitalization**: The `label-caps` token is reserved for formal classifications, protocol bands (*DELEGASI VVIP, MEDIA, INVESTOR ASING*), and table column headers. It must always be presented in uppercase with positive letter spacing.
- **Weight Pairing**: Body text stays strictly at weight 400 for long-form bilateral agreements, shifting to weight 600 only for key terms, timestamps, and signer names. Headings utilize weights 700 and 800 to balance heavy borders.

## Layout & Spacing

The layout is built upon a structured, predictable 12-column responsive fluid-grid framework engineered for dashboard densities, rapid badge-printing queues, and institutional public disclosures.

### Breakpoints & Grid Adaptation
- **Desktop (≥ 1280px)**: 12-column grid, max canvas width 1360px centered, `margin: 2rem`, `gutter: 1.5rem`. Split layouts feature persistent protocol navigation on the left (280px fixed or 3 columns) and delegate operational viewports across the remaining 9 columns.
- **Tablet (768px – 1279px)**: 8-column grid, `margin: 1.5rem`, `gutter: 1rem`. Side panels fold into modal drawers or collapse into an authoritative top bar.
- **Mobile (< 768px)**: 4-column grid, `margin-sm: 1rem`, `gutter-sm: 1rem`. Check-in scanning forms become full-width vertical stacks with the primary CTA fixed to the bottom thumb zone.

### Spacing Rhythm
- Space is systematic and disciplined; all spacing tokens derive from an 8pt architectural rhythm.
- Spacing within form elements and table rows follows compact configurations (`space-xs` to `space-sm`) to support dense data sets without vertical sprawl.
- High-level sections (e.g., Summit Tracks, Bilateral Meeting Schedule) use `space-xl` margins to preserve dignified corporate separation.

## Elevation & Depth

This system avoids expressive drop shadows and skeuomorphic layering in favor of **structural planar stacking and low-contrast architectural borders**.

### Elevation Philosophy
1. **Base Layer (Level 0)**: `#111318` for shell chrome and high-level banners. Content regions sit on deep `#161922` or invert to `#F1F3F5` for white-paper workspaces.
2. **Surface Containers (Level 1)**: Modals, credential review cards, and check-in confirmation viewports use flat background fills accompanied by a 1px solid stroke (`#183B5B` on dark backgrounds, `#CBD5E1` on light backgrounds).
3. **Overlays & Dialogs (Level 2)**: Heavy 1px border stroke with a restrained, dark ambient tint (`box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.45)`). No color-tinted glows or floating blurs.
4. **Interactive Focus**: Focused inputs and activated buttons use a crisp, unblurred 2px focus ring using `#F29A2E` with a 2px offset, ensuring compliance with international public sector accessibility standards.

## Shapes

The design uses a **Soft (`1`)** roundedness scale to convey institutional solidity and technical efficiency. High border radii (such as pill shapes) undermine the seriousness of sovereign investment agreements and border-level credentialing.

- **Inputs, Buttons, Cards, Dialogs**: Default radius of `0.25rem` (4px). Corner radii communicate precision, discipline, and structural permanence.
- **Modals, Floating Panels**: Maximum radius of `0.5rem` (`rounded-lg`).
- **Pill Badges (Exceptions)**: Small metadata tags for accreditation categories (*e.g., KEK Sei Mangkei, VVIP*) may use full pill styling (`9999px`) only when text size is 12px or smaller and total badge height does not exceed 24px.

## Components

### Buttons
- **Primary Action (Investment Amber)**: Background `#F29A2E`, text `#111318`, font weight 600, border radius `0.25rem`. Hover state: `#D9831F`. Active state: `#BF7113`. Used exclusively for forward-driving summit actions (*Kirim Delegasi*, *Validasi Tiket Masuk*).
- **Secondary Action (Corporate Blue)**: Background `#183B5B`, text `#FFFFFF`, border 1px solid `#234E75`. Hover state: `#234E75`.
- **Tertiary / Neutral**: Background transparent, text `#F1F3F5` (on dark) or `#111318` (on light), border 1px solid `#64748B`.

### Text Inputs & Form Fields
- **Container**: Minimum height 44px for rapid touch-screen kiosk usage. Background `#FFFFFF` with 1px border `#64748B`.
- **Text & Placeholder**: Text `#111318`, font-size `14px`, placeholder `#94A3B8`.
- **Focus State**: 2px solid border `#F29A2E` without drop shadows.
- **Labels**: Rendered above inputs in `label-md` using `#111318` on light surfaces or `#F1F3F5` on dark surfaces. Required markers use `#EF4444`.

### Cards & Credential Blocks
- **Delegate Credential Card**: Crisp container utilizing `#FFFFFF` surface with an upper institutional color bar in `#183B5B`. Includes delegate photo slot, printed Barcode/QR zone, full legal name in `headline-sm`, and delegating entity in `body-sm`.
- **Metric / Zone Summary Cards**: Placed on `#111318` canvas with `#183B5B` interior strokes and `#F29A2E` accent indicators highlighting investment volume and check-in percentages.

### Status Indicators & Chips
- **Format**: Inline-flex, height 24px, padding 2px 8px, `label-caps`.
- **Success (`#10B981`)**: Light emerald background tint (`rgba(16, 185, 129, 0.12)`), text `#065F46` on light surfaces or `#34D399` on dark surfaces, border 1px solid `#10B981`. Icon: checkmark.
- **Warning (`#F59E0B`)**: Tinted warning background, 1px solid `#F59E0B`. Icon: alert triangle.
- **Error (`#EF4444`)**: Tinted danger background, 1px solid `#EF4444`. Icon: circle cross.

### Lists & Data Tables
- **Table Headers**: Background `#183B5B`, text `#FFFFFF`, text-transform uppercase, font `label-caps`, padding `12px 16px`.
- **Table Rows**: Alternating rows using `#FFFFFF` and `#F8FAFC`. Dividing border 1px solid `#E2E8F0`. Hover row highlights with subtle blue-gray tint (`#EDF2F7`).
- **Monospace Elements**: Pass codes, Passport/KTP hashes, and QR strings use tabular font features to facilitate quick verification by protocol staff.

### Checkboxes & Radio Controls
- **Size**: 18px × 18px square with `0.125rem` radius for checkboxes; 18px circle for radios.
- **Active State**: Background `#183B5B`, check indicator `#FFFFFF`, border `#183B5B`.
- **Inactive State**: Background `#FFFFFF`, border 1px solid `#64748B`. Focus ring `#F29A2E`.

### QR Scanner Viewport (Specialized Component)
- **Kiosk Target Frame**: Dark framed overlay (`#111318` at 80% opacity) with a centered scanning reticle bordered in `#F29A2E` with 2px stroke and soft 4px corner accents.
- **Real-Time Banner**: Instant status banner underneath the viewport switching dynamically to Emerald (`#10B981`) upon verification or Red (`#EF4444`) upon rejection, paired with an audible chime and large Indonesian status text.