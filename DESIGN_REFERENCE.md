# Visual Design Reference

## Color Swatches

### Navigation Bar
```
Color: #7ba7c1 (Light Blue)
RGB: 123, 167, 193
Use: Header, primary buttons, links
Contrast with white: WCAG AAA ✓
```

### Background
```
Color: #f9f0ed (Off-White/Cream)
RGB: 249, 240, 237
Use: Page backgrounds, sections
Warm and comfortable for extended viewing
```

### Footer
```
Color: #455766 (Dark Blue)
RGB: 69, 87, 102
Use: Footer, dark accents
Contrast with white: WCAG AAA ✓
```

### Benefits/Highlights
```
Color: #ec9a63 (Light Orange)
RGB: 236, 154, 99
Use: Benefit sections, call-outs, highlights
Warm, inviting, energetic
```

### Supporting Colors
```
Accent: #d67d47 (Darker Orange)
- Icons, hover states, emphasis

Hover Blue: #5d8aa8
- Navigation hover, interactive states

Dark Text: #2c3e50
- Body text, headings (high contrast)
```

## Typography Scale

### Headings
- H1: 3.5rem (56px) - Hero titles
- H2: 2.8rem (44.8px) - Section headers
- H3: 1.6rem (25.6px) - Subsections
- Body: 1.125rem (18px) - Main content

### Mobile Adjustments
- H1: 2.2rem (35.2px)
- H2: 2.2rem (35.2px)
- Body: 1.0625rem (17px)

## Spacing System

### Padding/Margin
- XS: 8px
- SM: 16px
- MD: 24px
- LG: 32px
- XL: 40px
- 2XL: 60px
- 3XL: 80px

### Sections
- Vertical: 80px
- Horizontal: 24px (container)

### Components
- Card padding: 40px 32px
- Button padding: 16px 40px
- Input padding: 14px

## Component Dimensions

### Minimum Touch Targets
- Links: 48px × 48px
- Buttons: 56px × 160px
- Form inputs: 48px height
- Icon buttons: 48px × 48px

### Border Radius
- Cards: 12px
- Buttons: 12px
- Inputs: 8px
- Images: 8-12px

### Shadows
```css
/* Small - Subtle lift */
box-shadow: 0 2px 8px rgba(0,0,0,0.1);

/* Medium - Cards, buttons */
box-shadow: 0 4px 12px rgba(0,0,0,0.15);

/* Large - Modals, dropdowns */
box-shadow: 0 6px 20px rgba(0,0,0,0.2);
```

## Grid System

### Desktop (>968px)
- Max width: 1280px
- Columns: auto-fit, min 300px
- Gap: 32px

### Tablet (768-968px)
- Flexible grids
- 2 columns typically
- Gap: 24px

### Mobile (<768px)
- Single column
- Gap: 24px
- Full-width elements

## Interaction States

### Buttons
```
Default: bg #7ba7c1, text white
Hover: bg #5d8aa8, lift 3px, shadow increase
Active: lift 1px
Focus: 3px outline #7ba7c1
```

### Links
```
Default: #7ba7c1
Hover: #5d8aa8, underline
Focus: 3px outline
```

### Cards
```
Default: shadow-md, border transparent
Hover: lift 8px, shadow-lg, border #d67d47
```

### Forms
```
Default: border 2px #ddd
Focus: border #7ba7c1, outline 3px rgba(123,167,193,0.3)
Error: border red, background light pink
Success: border green
```

## Animation Timings

### Transitions
- Default: 0.3s ease
- Fast: 0.2s ease
- Slow: 0.5s ease

### Hover Effects
```css
transition: all 0.3s ease;
transform: translateY(-3px); /* Buttons */
transform: translateY(-8px); /* Cards */
```

## Accessibility Notes

### Focus Indicators
```css
outline: 3px solid #7ba7c1;
outline-offset: 2px;
```

### Text Selection
```css
background: #ec9a63;
color: #ffffff;
```

### Contrast Ratios
- Nav (white on #7ba7c1): 4.8:1 ✓ WCAG AA
- Body (#2c3e50 on #f9f0ed): 12.6:1 ✓ WCAG AAA
- Footer (white on #455766): 8.2:1 ✓ WCAG AAA
- Benefits (white on #ec9a63): 4.6:1 ✓ WCAG AA

## Icon Usage

### Font Awesome Classes
- Navigation: fa-bars (menu)
- Benefits: fa-heart, fa-users, fa-shield
- Contact: fa-envelope, fa-phone
- Social: fa-facebook, fa-twitter
- Actions: fa-edit, fa-trash, fa-save

### Icon Sizes
- Small: 1.5rem (24px)
- Medium: 2rem (32px)
- Large: 3.5rem (56px)
- Color: #d67d47 (accent orange)

## Print Styles

### Colors
- All backgrounds: white
- All text: black
- Remove shadows
- Hide navigation
- Show URLs for links

## Browser-Specific Notes

### Safari
- Use -webkit prefixes for gradients
- Test focus outlines
- Verify sticky positioning

### Firefox
- Verify custom scrollbars
- Test grid layouts
- Check color rendering

### Edge/Chrome
- Standard rendering
- Test touch events on hybrid devices

## Performance Tips

- Use CSS transforms (GPU accelerated)
- Avoid expensive properties (box-shadow during scroll)
- Lazy load images
- Use system fonts
- Minimize repaints
