# MadLabBrazil Payment System (read carefully)

docker build -f dockerfiles/Dockerfile-msg-server -t mlb-payment-system-message-server .
docker run -d --hostname payment-system-msg --name mlb-messaging  mlb-payment-system-message-server

docker build -f dockerfiles/Dockerfile-api-server -t mlb-payment-system-api-server .
docker run -it --hostname payment-system-api --name mlb-api --link mlb-messaging:mlb-messaging  mlb-payment-system-api-server /bin/bash