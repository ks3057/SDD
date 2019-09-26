var Validation = require("./business_layer.js");
const val = new Validation();

const root = "/CompanyServices";


const express = require("express"),
  app = express(),
  //npm install body-parser
  bodyParser = require("body-parser"), //form data in the body of the POST request
  //when extended= false, created object is array or object only
  jsonParser = bodyParser.json(),
  urlEncodedParser = bodyParser.urlencoded({
    extended: false
  });

server = app.listen(8080, () => {
  const host = server.address().address;
  port = server.address().port;
  console.log("App listening at http://%s:%s", host, port);
});

// app.route("/CompanyServices");
// app.set('base', '/CompanyServices');

//1. company DELETE
app.delete(root + "/company", (req, res) => {
  console.log("DELETE request for company");
  message = val.deleteCompany(req);
  res.type("json").send(JSON.stringify(message));
});

//2. department GET
app.get(root + "/department", (req, res) => {
  console.log("GET request for department");
  const obj1 = new Validation();
  message = obj1.getDepartment(req, res);
  console.log(message);
  res.type("json").send(JSON.stringify(message));

});


//3. departments GET
app.get(root + "/departments", (req, res) => {
  console.log("GET request for departments");
  const obj1 = new Validation();
  d = obj1.getAllDepartment(req);
  res.type("json").send(JSON.stringify(d));
});

//4. department POST
app.post(root + "/department", jsonParser, (req, res) => {
  console.log("POST request for department");
  let company = req.body.company;
  let dept_name = req.body.dept_name;
  let dept_no = req.body.dept_no;
  let location = req.body.location;
  message = val.postDepartment(company, dept_name, dept_no, location);
  res.type("json").send(JSON.stringify(message));
});

//5. department PUT
app.put(root + "/department", urlEncodedParser, (req, res) => {
  console.log("PUT request for department");

  let company = req.body.company;
  let dept_name = req.body.dept_name;
  let dept_no = req.body.dept_no;
  let location = req.body.location;
  let dept_id = req.body.dept_id;

  message = val.putDepartment(company, dept_name, dept_no, location, dept_id);
  res.type("json").send(JSON.stringify(message));
});


//6. department DELETE
app.delete(root + "/department", (req, res) => {
  console.log("DELETE request for department");
  message = val.deleteDepartment(req);
  res.type("json").send(JSON.stringify(message));
});


//7. employee GET
app.get(root + "/employee", (req, res) => {
  console.log("GET request for employee");
  message = val.getEmployee(req);
  res.type("json").send(JSON.stringify(message));
});

//8. employees GET
app.get(root + "/employees", (req, res) => {
  console.log("GET request for employees");
  const obj1 = new Validation();
  d = obj1.getAllEmployee(req);
  res.type("json").send(JSON.stringify(d));
});


//9. employee POST
app.post(root + "/employee", jsonParser, (req, res) => {
  console.log("POST request for employee");
  let emp_name = req.body.emp_name;
  let emp_no = req.body.emp_no;
  let hire_date = req.body.hire_date;
  let job = req.body.job;
  let salary = req.body.salary;
  let dept_id = req.body.dept_id;
  let mng_id = req.body.mng_id;

  message = val.postEmployee(emp_name, emp_no, hire_date, job, salary, dept_id, mng_id);
  res.type("json").send(JSON.stringify(message));
});

//10. employee PUT
app.put(root + "/employee", urlEncodedParser, (req, res) => {
  console.log("PUT request for employee");
  let emp_id = req.body.emp_id;
  let emp_name = req.body.emp_name;
  let emp_no = req.body.emp_no;
  let hire_date = req.body.hire_date;
  let job = req.body.job;
  let salary = req.body.salary;
  let dept_id = req.body.dept_id;
  let mng_id = req.body.mng_id;

  message = val.putEmployee(emp_id, emp_name, emp_no, hire_date, job, salary, dept_id, mng_id);
  res.type("json").send(JSON.stringify(message));
});

//11. employee DELETE
app.delete(root + "/employee", (req, res) => {
  console.log("DELETE request for employee");
  message = val.deleteEmployee(req);
  res.type("json").send(JSON.stringify(message));
});

//12. timecard GET
app.get(root + "/timecard", (req, res) => {
  console.log("GET request for timecard");
  message = val.getTimecard(req);
  res.type("json").send(JSON.stringify(message));
});

//13. timecards GET
app.get(root + "/timecards", (req, res) => {
  console.log("GET request for timecards");
  const obj1 = new Validation();
  d = obj1.getAllTimecard(req);
  res.type("json").send(JSON.stringify(d));
});


//14. timecard POST
app.post(root + "/timecard", jsonParser, (req, res) => {
  console.log("POST request for timecard");
  let emp_id = req.body.emp_id;
  let start_time = req.body.start_time;
  let end_time = req.body.end_time;

  message = val.postTimecard(emp_id, start_time, end_time);
  res.type("json").send(JSON.stringify(message));
});

//15. timecard PUT
app.put(root + "/timecard", urlEncodedParser, (req, res) => {
  console.log("PUT request for timecard");
  let timecard_id = req.body.timecard_id;
  let emp_id = req.body.emp_id;
  let start_time = req.body.start_time;
  let end_time = req.body.end_time;

  message = val.putTimecard(timecard_id, emp_id, start_time, end_time);
  res.type("json").send(JSON.stringify(message));
});

//16. timecard DELETE
app.delete(root + "/timecard", (req, res) => {
  console.log("DELETE request for timecard");
  message = val.deleteTimecard(req);
  res.type("json").send(JSON.stringify(message));
});