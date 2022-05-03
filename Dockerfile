FROM composer AS build

WORKDIR /app
COPY composer.* .
RUN composer install --no-interaction --no-dev --optimize-autoloader --no-progress

FROM php:8.1

WORKDIR /app

COPY --from=build /app/ /app/
COPY checker .
COPY src/ src/

#RUN ls -lah && exit 1

CMD ["/app/checker", "check"]
