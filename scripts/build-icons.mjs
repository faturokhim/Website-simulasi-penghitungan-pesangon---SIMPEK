/**
 * Generates `resources/icons/lucide.php` from the installed `lucide` package so
 * Blade can render outline SVGs without shipping the whole JS runtime.
 *
 * Usage: node scripts/build-icons.mjs
 */
import { writeFileSync, mkdirSync } from 'node:fs';
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';
import * as lucide from 'lucide';

const ICONS = [
    // brand / structure
    'scale', 'landmark', 'gavel', 'building-2', 'shield-check', 'badge-check',
    // navigation
    'layout-dashboard', 'calculator', 'history', 'book-open', 'file-text', 'folder',
    'user', 'users', 'user-plus', 'user-check', 'log-in', 'log-out', 'settings', 'menu', 'x', 'chevron-down', 'chevron-up',
    'chevron-left', 'chevron-right', 'arrow-right', 'arrow-left', 'arrow-up-right',
    'arrow-up', 'arrow-down', 'more-horizontal', 'external-link', 'shield', 'paperclip',
    'message-square', 'circle-check', 'timer', 'list', 'square-check',
    // actions
    'plus', 'search', 'filter', 'download', 'upload', 'printer', 'pencil', 'trash-2',
    'check', 'check-circle', 'x-circle', 'refresh-cw', 'rotate-ccw', 'save', 'send',
    'eye', 'copy', 'link', 'mail', 'phone', 'map-pin', 'lock', 'key', 'bell',
    // status / feedback
    'alert-triangle', 'alert-circle', 'info', 'clock', 'calendar', 'help-circle',
    'check-square', 'circle-dot', 'loader', 'sparkles', 'zap', 'target', 'flag',
    // domain
    'calculator', 'coins', 'banknote', 'wallet', 'briefcase', 'trending-up',
    'bar-chart-3', 'pie-chart', 'clipboard-list', 'clipboard-check', 'clipboard',
    'list-checks', 'database', 'file-check', 'file-search', 'file-down', 'table-2',
    'quote', 'bookmark', 'graduation-cap', 'hourglass', 'award', 'layers',
];

const pascal = (kebab) => kebab.split('-').map((s) => s.charAt(0).toUpperCase() + s.slice(1)).join('');

const serialize = (node) => {
    const [tag, attrs] = node;
    const rendered = Object.entries(attrs)
        .map(([key, value]) => `${key}="${String(value).replace(/"/g, '&quot;')}"`)
        .join(' ');
    return `<${tag} ${rendered}></${tag}>`;
};

const missing = [];
const map = {};

for (const name of new Set(ICONS)) {
    const icon = lucide[pascal(name)];
    if (!icon) {
        missing.push(name);
        continue;
    }
    map[name] = icon.map(serialize).join('');
}

const fallback = (lucide.Circle ?? []).map(serialize).join('');
const entries = Object.entries(map)
    .sort(([a], [b]) => a.localeCompare(b))
    .map(([name, svg]) => `    '${name}' => '${svg.replace(/'/g, "\\'")}',`)
    .join('\n');

const out = `<?php

/**
 * GENERATED FILE - do not edit by hand.
 * Run \`node scripts/build-icons.mjs\` after changing the icon allow-list.
 */
return [
${entries}
];

`;

const target = resolve(dirname(fileURLToPath(import.meta.url)), '../resources/icons/lucide.php');
mkdirSync(dirname(target), { recursive: true });
writeFileSync(target, out, 'utf8');

console.log(`Wrote ${Object.keys(map).length} icons -> ${target}`);
if (missing.length) {
    console.error(`Missing lucide icons: ${missing.join(', ')}`);
    process.exitCode = 1;
}
void fallback;
