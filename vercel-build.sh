#!/bin/bash
set -e

composer install --no-dev --optimize-autoloader --no-interaction
npm ci
npm run build
