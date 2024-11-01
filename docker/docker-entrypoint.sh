#!/bin/bash
set -e

echo "Entrypoint script is running"

# Execute the container's main process (what's set as CMD in the Dockerfile)
exec "$@"
