var datalayer = require("companydata");
var Department = require("companydata").Department;
var Employee = require("companydata").Employee;
var Timecard = require("companydata").Timecard;
var Validation = require(Validation);

const default_company = "ks3057";

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

  server = app.listen(8080, () => {
    const host = server.address().address;
    port = server.address().port;
    console.log("App listening at http://%s:%s", host, port);
  });

function duplicateDeptNo(dept_no) {
  let d = datalayer.getAllDepartment(default_company);
  let flag = false;
  for (let i = 0; i < d.length; i++) {
    if (d[i].getDeptNo() === dept_no) {
      flag = true;
      break;
    }
  }
  return flag;
}

function duplicateDeptNo(dept_no, dept_id) {
  let d = datalayer.getAllDepartment(default_company);
  let flag = false;
  for (let i = 0; i < d.length; i++) {
    if (d[i].getDeptNo() === dept_no && d[i].getId() != dept_id) {
      flag = true;
      break;
    }
  }
  return flag;
}

//1. company DELETE
app.delete("/company", (req, res) => {
  console.log("DELETE request for company");
  var companyName = req.query.company;
  var numRowsDeleted = datalayer.deleteCompany(companyName);
  var message;
  const response = "";
  if (numRowsDeleted) {
    message = companyName + "\'s information deleted";
    response = {
      success: message
    }
  } else {
    message = companyName + "could not be deleted";
    response = {
      error: message
    }
  }
  res.type("json").send(JSON.stringify(response));
});

//2. department GET
app.get("/department", (req, res) => {
  console.log("GET request for department");


});


//3. departments GET
app.get("/departments", (req, res) => {
  console.log("GET request for departments");
  var d = datalayer.getAllDepartment(req.query.company);
  res.type("json").send(JSON.stringify(d));
});

//4. department POST
app.post("/department", jsonParser, (req, res) => {
  console.log("POST request for department");

  let company = req.body.company;
  let dept_name = req.body.dept_name;
  let dept_no = req.body.dept_no;
  let location = req.body.location;

  if (company == null ||
    dept_name == null ||
    dept_no == null ||
    location == null) {
    const response = {
      error: "No department field can be empty"
    }
    res.type("json").send(JSON.stringify(response));
    return;
  } else {
    //check if company name is part of department name
    if (!dept_no.includes(default_company)) {
      dept_no = default_company + dept_no;
    }

    if (duplicateDeptNo(dept_no)) {
      const response = {
        error: "Department Number already associated with another department"
      }
      res.type("json").send(JSON.stringify(response));
      return;
    } else {
      var dept = new Department;
      dept.setDeptNo(dept_no);
      dept.setCompany(company);
      dept.setDeptName(dept_name);
      dept.setLocation(location);
      dept = datalayer.insertDepartment(dept);
      res.type("json").send(JSON.stringify(dept));
    }
  }
});

//5. department PUT
app.put("/department", urlEncodedParser, (req, res) => {
  console.log("PUT request for department");

  let company = req.body.company;
  let dept_name = req.body.dept_name;
  let dept_no = req.body.dept_no;
  let location = req.body.location;
  let dept_id = req.body.dept_id;

  if (dept_id == null) {
    const response = {
      error: "Department ID can't be null"
    };
    res.type("json").send(JSON.stringify(response));
    return;
  } else {
    // check if department exists
    let x = datalayer.getDepartment(default_company, dept_id);
    if (x == null) {
      const response = {
        error: "Department doesn't exist"
      };
      res.type("json").send(JSON.stringify(response));
      return;
    } else {
      if (dept_no != null) {
        if (!dept_no.includes(default_company)) {
          dept_no = default_company + dept_no;
        }
        if (duplicateDeptNo(dept_no, dept_id)) {
          const response = {
            error: "Department Number already associated with another department"
          };
          res.type("json").send(JSON.stringify(response));
          return;
        } else {
          x.setDeptNo(dept_no);
        }
      }

      if (company != null) {
        x.setCompany(company);
      }

      if (location != null) {
        x.setLocation(location);
      }

      if (dept_name != null) {
        x.setDeptName(dept_name);
      }

      x = datalayer.updateDepartment(x);
      const response = {
        success: x
      };
      res.type("json").send(JSON.stringify(response));
    }
  }
});




app.get("/employee", (req, res) => {
  console.log("GET request for employee");
  var d = datalayer.getAllDepartment("ks3057");
  const response = {
    // usually this info would come from the data store
    // let dl = new

    first: req.query.first_name,
    last: req.query.last_name,
    temp: d
  };
  res.type("json").send(JSON.stringify(response));
});

app.post("/", (req, res) => {
  console.log("POST request for homepage");
  res.status(201).send("Hello POST");
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