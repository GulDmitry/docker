FROM nginx:1.11

COPY cert.pem /etc/ssl/nginx/
COPY key.pem /etc/ssl/nginx/
COPY default.conf /etc/nginx/conf.d/
#COPY nginx.conf /etc/nginx/

CMD ["nginx", "-g", "daemon off;"]
