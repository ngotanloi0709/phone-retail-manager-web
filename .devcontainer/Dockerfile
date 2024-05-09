FROM mcr.microsoft.com/vscode/devcontainers/base:0-ubuntu-20.04
LABEL maintainer LoiNgo <ngotanloi0709@gmail.com>

# Replace shell with bash so we can source files
RUN rm /bin/sh && ln -s /bin/bash /bin/sh

# Install basic dependencies and libraries
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    zip \
    unzip \
    vim \
    sudo \
    curl \
    tar \
    wget \
    git \
    bzip2 \
    telnet \
    rar \
    && apt-get clean

# Install Nginx web server
RUN apt -y install nginx

# Install PHP and its extensions
RUN apt -y install software-properties-common
RUN add-apt-repository ppa:ondrej/php
RUN apt-get update
RUN apt -y install php8.1 php8.1-{fpm,xdebug,bcmath,curl,mbstring,mysql,tokenizer,xml,zip,fileinfo,ctype}

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install NodeJS
# Note: un-comment the following lines to install NodeJS
# RUN #apt-get update && \
#    apt-get install -y ca-certificates curl gnupg && \
#    mkdir -p /etc/apt/keyrings && \
#    curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | sudo gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg && \
#    NODE_MAJOR=18 && \
#    echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_MAJOR.x nodistro main" | sudo tee /etc/apt/sources.list.d/nodesource.list && \
#    apt-get update && \
#    apt-get install nodejs -y

# This line below allow composer run in the container with root user
ENV COMPOSER_ALLOW_SUPERUSER=1