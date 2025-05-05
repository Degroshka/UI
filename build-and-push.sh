#!/bin/bash

# Сборка образа
docker build -t your-dockerhub-username/schedule:latest .
 
# Публикация образа
docker push your-dockerhub-username/schedule:latest 