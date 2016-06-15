# MadLabBrazil Payment System (read carefully)

Description:
![alt slider](http://cdn.madlabbrazil.com/ex06.jpg)

[Full Presetation](https://docs.google.com/presentation/d/1DReA_GDzy6HvG0TJ1Ry-CQlmVhuNZsEbXi7VGO3-f3k/edit?usp=sharing)


#How to Install:
1. You need have installed and working docker-engine on your machine
2. Clone the project to your machine
3. On the project root just start follow down instruction copying and pasting the scripts on your shell command

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
