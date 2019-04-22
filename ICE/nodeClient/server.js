var http = require("http");
server = http.createServer(function(request, response) {

});

server.listen(1234, function() {
  console.log((new Date()) + "server is listening on port 1234");
});

//attach the websocket server to the http server connection its riding on
var WebSocketServer = require("websocket").server;
wsServer = new WebSocketServer({
  httpServer: server
});
count = 0, //number of connection to the server
  clients = {}; //all clients that are connected to the server

wsServer.on("request", function(request) {
  //accept the incoming request connection
  var connection = request.accept(null, request.origin),
    //specific ID for this client (and increment count)
    id = count++;

  clients[id] = connection;
  console.log((new Date()) + "connection accepted[" + id + "]");

  //create an event listener on WS connection
  connection.on("message", function(msg) {
    //console.log(msg);
    var msgString = msg.utf8Data;
    console.log("Message received from " + id + " " + msgString);

    //iterate through clients
    for (var i in clients) {
      clients[i].sendUTF(msgString);
    }
  });

  connection.on("close", function(reasonCode, description) {
    delete clients[id];
    console.log((new Date()) + "User " + connection.remoteAddress + " disconnected");
  });
});