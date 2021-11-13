FROM nginx:1.21.1-alpine

ENV PHP_FPM_URL=${PHP_FPM_URL:-localhost:9000}
ENV HSTS_HEADER=${HSTS_HEADER:-}
ENV PERMISSION_POLICY_HEADER=${PERMISSION_POLICY_HEADER:-geolocation=(self),microphone=(),camera=(),fullscreen=(),accelerometer=(),autoplay=()}

RUN rm -rf /etc/nginx/conf.d
COPY public/ /app/public
COPY docker/nginx/config /etc/nginx/
