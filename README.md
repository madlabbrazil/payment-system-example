# MadLabBrazil Payment System (read carefully)

```
docker build -f dockerfiles/Dockerfile-msg-server -t mlb-payment-system-message-server .
docker run -d --hostname payment-system-msg --name mlb-messaging  mlb-payment-system-message-server
```
To see if you container are build correctly run this command `docker ps`

![alt correct vision of running container msg](https://madlabbrazil.com/dockermsg.png)

```
docker build -f dockerfiles/Dockerfile-api-server -t mlb-payment-system-api-server .
docker run -d --hostname payment-system-api --name mlb-api --link mlb-messaging:mlb-messaging  mlb-payment-system-api-server
```

![alt correct vision of running container msg](https://madlabbrazil.com/dockerapi.png)
