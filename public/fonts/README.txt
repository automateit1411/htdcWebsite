Place Nikosh font files here so the site can use the Bangla Nikosh font.

Recommended file names (the CSS in `styles/globals.css` expects):
- nikosh.woff2   (preferred, modern browsers)
- nikosh.woff    (fallback)
- nikosh.ttf     (fallback)

How to add:
1. Download the Nikosh font files from a licensed source or your font provider.
2. Copy the font files into this folder (`public/fonts/`).
3. Restart the dev server if it was running.

Example usage in CSS (already included in `styles/globals.css`):
.bn-font { font-family: 'Nikosh', system-ui, sans-serif; }

Licensing note:
Ensure you have the right to distribute and use the font files in your project before committing them to source control. If the font is not open-source, keep the files locally and do not commit them to a public repository.
