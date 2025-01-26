# Query Loop Future Filter

A WordPress block editor plugin that adds a date range filter to the Query Loop block, allowing you to display either future or past dated posts.

## Description

This plugin extends the core Query Loop block by adding a date range filter in the block settings sidebar. You can choose to display:

- All posts (default)
- Only future dated posts
- Only past dated posts

Perfect for showing upcoming events, future scheduled posts, or filtering out old content.

## Installation

1. Download the latest release from the release section
2. Install the plugin through the 'Plugins' screen in WordPress
3. Activate the plugin through the 'Plugins' screen in WordPress

## Usage

1. Add a Query Loop block to your page/post
2. Open the block settings sidebar
3. Look for the "Date Range Settings" panel
4. Select your desired date range:
   - All Dates
   - Future Dates
   - Past Dates

## Development

### Requirements

- Node.js
- npm

### Setup

1. Clone this repository

   ```bash
   git clone https://github.com/sandymcfadden/query-loop-future-filter.git
   cd query-loop-future-filter
   ```

2. Install dependencies:

   ```bash
   npm install
   ```

### Build

The plugin uses @wordpress/scripts for build processes. Available commands:

Create a production build:

```bash
npm run build
```

### File Structure

```
query-loop-future-filter/
├── build/                  # Compiled files
├── src/                    # Source files
│   └── index.js            # Main JavaScript file
├── .gitignore
├── package.json
├── README.md
└── query-loop-future-filter.php
```

## Credit

Heavily inspired from https://rudrastyh.com/gutenberg/query-loop-block-variation.html
