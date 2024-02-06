FROM nginx:1.25.1-alpine

# ENV TZ=UTC

RUN apk --update --no-cache add \
    curl \
    bash \
    procps \
    && rm -rf /var/cache/apk/*

COPY ./.docker/web/nginx.conf /etc/nginx/nginx.conf
