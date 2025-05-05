#!/bin/bash

# Start the containers
docker-compose up -d

# Wait for PostgreSQL to be ready
echo "Waiting for PostgreSQL to be ready..."
sleep 10

# Check if containers are running
if [ "$(docker-compose ps -q)" ]; then
    echo "Application is running!"
    echo "Web interface: http://localhost:8000"
    echo "PostgreSQL: localhost:5432"
    echo "Admin credentials:"
    echo "Username: admin"
    echo "Password: admin"
else
    echo "Failed to start the application. Please check the logs."
fi 