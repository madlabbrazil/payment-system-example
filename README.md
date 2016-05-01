# MadLabBrazil Payment System (read carefully)

docker build -f dockerfiles/Dockerfile-msg-server -t mlb-payment-system-message-server .
docker run -d --hostname payment-system-msg --name mlb-messaging  mlb-payment-system-message-server
