//nodemon server.js
//npm install express
//below all are coma separated variables being termed a sconstants
const express = require("express"),
  app = express(),
  //npm install body-parser
  bodyParser = require("body-parser"), //form data in the body of the POST request
  //when extended= false, created object is array or object only
  urlEncodedParser = bodyParser.urlencoded({
    extended: false
  }),


  jsonParser = bodyParser.json(),
  fs = require("fs"), // for dealing with server file system
  multer = require("multer"), // for handling multipart form data
  upload = multer({
    dest: "./tmp/" // where to temporarily store uploaded files, create the uploads directory in project root
  }),

  server = app.listen(1234, () => {
    const host = server.address().address;
    port = server.address().port;
    console.log("App listening at htp://%s:%s", host, port);
  });

//handle get request using this method
app.get("/", (req, res) => {
  console.log("GET request for homepage");
  res.send("Hello World");
});

app.get("/employee", (req, res) => {
  console.log("GET request for employee");
  const response = {
    // usually this info would come from the data store
    first: req.query.first_name,
    last: req.query.last_name
  };
  res.type("json").send(JSON.stringify(response));
});

app.post("/", (req, res) => {
  console.log("POST request for homepage");
  res.status(201).send("Hello POST");
});

app.post("/employee", urlEncodedParser, (req, res) => {
  console.log("POST request for employee");
  const response = {
    // the parser is required for below
    first: req.body.first_name,
    last: req.body.last_name
  };

  res.status(201).type("json").send(JSON.stringify(response));
});


app.post("/department", jsonParser, (req, res) => {
  console.log("POST request for department");

  const response = {
    // the parser is required for below
    dept_name: req.body.dept_name,
    dept_num: req.body.dept_num
  };

  res.status(201).type("json").send(JSON.stringify(response));
});

app.delete("/employee", (req, res) => {
  console.log("DELETE request for department");

  res.send("Hello DELETE");
});

//using pattern matching
app.delete("/ab*cd", (req, res) => {
  console.log("GET request for ab*cd");

  res.send("Hello Pattern Match");
});

// to serve static files such as images, JS, CSS
// localhost:1234/images/kitten.jpeg
app.use(express.static("public"));

// for static pages like index.HTML
app.get("/index.html", (req, res) => {
  //below requires absolute path or specify root to res.sendFile
  res.sendFile(__dirname + "/index.html");
});

//for file uploads
app.post("/file_upload", upload.single("file"), (req, res) => {
  console.log(req.file);
  const file = __dirname + "/uploads" + req.file.originalname;

  // read from the temp location where multer stuck the file
  fs.readFile(req.file.path, (err, data) => {

    //write out to the uploads dir, with the original file name
    fs.writeFile(file, data, (err) => {
      if (err) {
        console.log(err);
      } else {
        response = "File uploaded successfully";
        filename = req.file.originalname;
      };
      console.log(response);
      res.type("json").send(JSON.stringify(response));
    });
  })
});