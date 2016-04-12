#Simple PHP-amqplib Demo

This is a really simple demo of using RabbitMQ to send messages between web and worker dynos on Heroku in PHP. It works on free Heroku dynos.

To set up:

* Clone this repo
* Update Composer (composer update)
* Init a git repo (git init .)
* Commit the code (git commit -m "something")
* Create a new Heroku app (heroku create)
* Add CloudAMQP to your new app (the free plan is fine)
* Scale up the dynos (heroku ps:scale web=1 worker=1)

To test:

* Open the web address of your new app (https://whatever.herokuapp.com)
* This page (index.php) sends a simple text message to the worker
* Check the logs (heroku logs) to see the worker (worker.php) receive it and output it to the log

That's it.