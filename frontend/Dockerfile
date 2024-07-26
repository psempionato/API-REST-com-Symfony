FROM node:18

WORKDIR /app

RUN apt-get update && \
    apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev libpq-dev libzip-dev unzip git

RUN groupadd -g 1001 nodegroup && \
    useradd -u 1001 -g 1001 -ms /bin/bash nodeuser

RUN chown -R nodeuser:nodegroup /app && chmod -R 777 /app

# RUN npm install -g @angular/cli
RUN npm install -g @vue/cli

USER nodeuser

COPY . /app

EXPOSE 8080

CMD ["tail", "-f", "/dev/null"]