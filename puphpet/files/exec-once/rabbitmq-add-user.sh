sudo rabbitmqctl add_user hackathon phx
sudo rabbitmqctl set_permissions -p / hackathon ".*" ".*" ".*"