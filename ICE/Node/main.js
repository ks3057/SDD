var hello = require("./hello");

hello.world();

var greetings = require("./hello2.js");

console.log(greetings.sayHelloInEnglish());
console.log(greetings.sayHelloInSpanish());

//include the http module that ships with Node
var http = require("http");

http.createServer(function(request, response) {
  response.writeHead(200, {
    "Content-Type": "text/plain"
  });
  response.write("Hello World (again)");
  response.end();
}).listen(8888);