FROM soshal/wordpress
COPY /wp-content /app/wp-content
COPY .htaccess /app/.htaccess
RUN sudo chown -R www-data:www-data /app/wp-content
