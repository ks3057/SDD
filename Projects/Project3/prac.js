var Validation = require("./practice.js");
const val = new Validation();

const root = "/CompanyServices";

const express = require("express"),
app = express(),
port = 8080,
bodyparser = require("body-parser"),
jsonparser = bodyparser.json(),
urlencodedparser = bodyparser.urlencoded({
    extended : false
});

app.listen(port, () => console.log("App is listening on port " + port));

app.get(root + "/departments", (req, res) => {
    console.log("GET request");
    answer = val.getAllDepartment(req);
    res.type("json").send(JSON.stringify(answer));
});

app.post(root + "/department", jsonparser, (req, res) => {
    console.log("post request for department");
    message = val.insertDepartment(req.body.name);
    res.type("json").send(JSON.stringify(message));
});
