#!/usr/bin/env node
/**
 * Wrapper for php artisan wayfinder:generate.
 * Exits 0 even when the command fails (e.g. DB not running) so Vite dev server can start.
 */
import { execSync } from 'node:child_process';

try {
  execSync('php artisan wayfinder:generate --with-form', {
    stdio: 'inherit',
    cwd: process.cwd(),
  });
} catch {
  console.warn('Wayfinder generate skipped (e.g. database not running). Route/action types may be stale.');
}
process.exit(0);
