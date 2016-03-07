var amqp = require('amqp');

var connection = amqp.createConnection({ 
  host: 'amqpphpnodejs_rabbit_1', 
  port: 5672, 
  login: 'rabbitadmin', 
  password: 'rabbitpass', 
  vhost: '/'
});

// Wait for connection to become established.
connection.on('ready', function () { 
  // Use the default 'amq.topic' exchange
  connection.queue('test',  {
    passive: false, 
    durable: true, 
    exclusive: false, 
    autoDelete: false
  }, function (q) {
      // Catch all messages
      q.bind('#');

      // Receive messages
      q.subscribe(function (message) {
        // Print messages to stdout
        console.log(message.data.toString());
      });
  });
}).on('error', function(err){
  console.log("ERR", err); 
}); 