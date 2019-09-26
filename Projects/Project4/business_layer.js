var datalayer = require("companydata");
var Department = require("companydata").Department;
var Employee = require("companydata").Employee;
var Timecard = require("companydata").Timecard;

const default_company = "ks3057";
var date_fns = require('date-fns');
var parse = require('date-fns/parse');
var isToday = require('date-fns/is_today');
var format = require('date-fns/format')

module.exports = class Validation {

  dupeDeptNo(dept_no) {
    try {
      let d = datalayer.getAllDepartment(default_company);
      let flag = false;
      for (let i = 0; i < d.length; i++) {
        if (d[i].getDeptNo() === dept_no) {
          flag = true;
          break;
        }
      }
      return flag;
    } catch (e) {
      console.log(e);
      return e;
    }
  }


  duplicateDeptNo(dept_no, dept_id) {
    try {
      let d = datalayer.getAllDepartment(default_company);
      let flag = false;
      for (let i = 0; i < d.length; i++) {
        if (d[i].getDeptNo() === dept_no && d[i].getId() != dept_id) {
          flag = true;
          break;
        }
      }
      return flag;
    } catch (e) {
      console.log(e);
      return e;
    }
  }


  dupeEmployee(emp_no, emp_id) {
    /**
     * Helper to check if employee number supplied is unique
     */
    try {
      let e = datalayer.getAllEmployee(default_company);
      for (let i = 0; i < e.length; i++) {
        if (e[i].getEmpNo() === emp_no && e[i].getId() != emp_id) {
          return true;
        }
      }
      return false;
    } catch (e) {
      console.log(e);
      return e;
    }

  }

  duplicateEmployee(emp_no) {
    /**
     * Helper to check if employee number supplied is unique
     */
    try {
      let e = datalayer.getAllEmployee(default_company);
      for (let i = 0; i < e.length; i++) {
        if (e[i].getEmpNo() === emp_no) {
          return true;
        }
      }
      return false;
    } catch (e) {
      console.log(e);
      return e;
    }
  }

  getDepartment(req) {
    try {
      if (req.query.company == null || req.query.dept_id == null) {
        const response = {
          error: "company name and department id can't be null"
        }
        return response;
      } else {
        var department = datalayer.getDepartment(req.query.company, req.query.dept_id);
        if (department == null) {
          const response = {
            error: "department doesn't exist"
          }
          return response;
        } else {
          const response = department;
          return response;
        }
      }
    } catch (e) {
      console.log(e);
      return e;
    }
  }

  getAllDepartment(req) {
    try {
      var d = datalayer.getAllDepartment(req.query.company);
      return d;
    } catch (e) {
      console.log(e);
      return e;
    }
  }

  deleteCompany(req) {
    try {
      var companyName = req.query.company;
      var numRowsDeleted = datalayer.deleteCompany(companyName);
      var message;
      if (numRowsDeleted) {
        let message = companyName + "\'s information deleted";
        const response = {
          success: message
        }
        return response;
      } else {
        message = companyName + " could not be deleted";
        const response = {
          error: message
        }
        return response;
      }
    } catch (e) {
      console.log(e);
      return e;
    }
  }

  postDepartment(company, dept_name, dept_no, location) {
    try {
      if (company == null ||
        dept_name == null ||
        dept_no == null ||
        location == null) {
        const response = {
          error: "No department field can be empty"
        }
        return response;
      } else {
        //check if company name is part of department name
        if (!dept_no.includes(default_company)) {
          dept_no = default_company + dept_no;
        }

        if (this.dupeDeptNo(dept_no)) {
          const response = {
            error: "Department Number already associated with another department"
          }
          return response;
        } else {
          var dept = new Department;
          dept.setDeptNo(dept_no);
          dept.setCompany(company);
          dept.setDeptName(dept_name);
          dept.setLocation(location);
          dept = datalayer.insertDepartment(dept);
          const response = {
            success: dept
          }
          return response;
        }
      }
    } catch (e) {
      console.log(e);
      return e;
    }
  }

  putDepartment(company, dept_name, dept_no, location, dept_id) {
    try {
      if (dept_id == null) {
        const response = {
          error: "Department ID can't be null"
        };
        return response;
      } else {
        // check if department exists
        let x = datalayer.getDepartment(default_company, dept_id);
        if (x == null) {
          const response = {
            error: "Department doesn't exist"
          };
          return response;
        } else {
          if (dept_no != null) {
            if (!dept_no.includes(default_company)) {
              dept_no = default_company + dept_no;
            }
            if (this.duplicateDeptNo(dept_no, dept_id)) {
              const response = {
                error: "Department Number already associated with another department"
              };
              return response;
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
          return response;
        }
      }
    } catch (e) {
      console.log(e);
      return e;
    }
  }

  deleteDepartment(req) {
    try {
      if (req.query.company == null || req.query.dept_id == null) {
        const response = {
          error: "company name and department id can't be null"
        }
        return response;
      } else {
        var department = datalayer.getDepartment(req.query.company, req.query.dept_id);
        if (department == null) {
          const response = {
            error: "department doesn't exist"
          }
          return response;
        } else {
          let employees = datalayer.getAllEmployee(req.query.company);
          for (let i = 0; i < employees.length; i++) {
            if (employees[i].getDeptId() == req.query.dept_id) {
              let timecards = datalayer.getAllTimecard(employees[i].getId());
              for (let j = 0; j < timecards.length; j++) {
                datalayer.deleteTimecard(timecards[j].getId());
              }
              datalayer.deleteEmployee(employees[i].getId());
            }
          }

          let deleted = datalayer.deleteDepartment(req.query.company, req.query.dept_id);

          if (deleted >= 1) {
            let value = "Department " + req.query.dept_id + " from " + req.query.company + " deleted";
            const response = {
              success: value
            }
            return response;

          } else {
            const response = {
              error: "Could not delete"
            }
            return response;
          }
        }
      }
    } catch (e) {
      console.log(e);
      return e;
    }
  }

  getEmployee(req) {
    try {
      if (req.query.emp_id == null) {
        const response = {
          error: "Employee id can't be null"
        }
        return response;
      }
      var employee = datalayer.getEmployee(req.query.emp_id);
      if (employee != null) {
        return employee;
      } else {
        const response = {
          error: "Employee does not exist"
        }
        return response;
      }
    } catch (e) {
      console.log(e);
      return e;
    }
  }

  getAllEmployee(req) {
    try {
      var e = datalayer.getAllEmployee(req.query.company);
      return e;
    } catch (e) {
      console.log(e);
      return e;
    }
  }


  postEmployee(emp_name, emp_no, hire_date, job, salary, dept_id, mng_id) {
    try {
      if (emp_name == null ||
        emp_no == null ||
        hire_date == null ||
        job == null ||
        salary == null ||
        dept_id == null ||
        mng_id == null) {

        const response = {
          error: "No employee field can be empty"
        }
        return response;
      }

      //validations
      let department = datalayer.getDepartment(default_company, dept_id);
      if (department == null) {
        const response = {
          error: "department doesn't exist"
        }
        return response;
      }

      if (mng_id != 0) {
        let employee = datalayer.getEmployee(mng_id);
        if (employee == null) {
          const response = {
            error: "manager doesn't exist"
          }
          return response;
        }
      }

      var hire_date = format(
        parse(
          hire_date,
          'YYYY-MM-DD',
          new Date()
        ),
        'YYYY-MM-DD'
      );

      var now = format(
        new Date(),
        'YYYY-MM-DD'
      );

      if (date_fns.isBefore(hire_date, now) || date_fns.isEqual(hire_date, now)) {
        if (date_fns.isWeekend(hire_date)) {
          const response = {
            error: "employee can't be hired on " +
              "weekends"
          }
          return response;
        }
      } else {
        const response = {
          error: "hire date can't be future date"
        }
        return response;
      }

      if (!emp_no.includes(default_company)) {
        emp_no = default_company + "-" + emp_no;
      }

      if (this.duplicateEmployee(emp_no)) {
        const response = {
          error: "employee number is already " +
            "associated with another employee"
        }

        return response;
      } else {
        var emp = new Employee(emp_name, emp_no, hire_date, job, salary, dept_id, mng_id);
        emp = datalayer.insertEmployee(emp);
        if (emp.getId() > 0) {
          const response = {
            success: emp
          }
          return response;
        } else {
          const response = {
            error: "not inserted"
          }
          return response;
        }
      }
    } catch (e) {
      console.log(e);
      return e;
    }
  }

  putEmployee(emp_id, emp_name, emp_no, hire_date, job, salary, dept_id, mng_id) {
    try {
      if (emp_id == null) {
        const response = {
          error: "emp_id can't be null"
        }
        return response;
      }

      //validations
      let toupdate = datalayer.getEmployee(emp_id);
      if (toupdate == null) {
        const response = {
          error: "employee doesn't exist"
        }
        return response;
      } else {

        if (emp_name != null) {
          toupdate.setEmpName(emp_name);
        }

        if (emp_no != null) {
          if (!emp_no.includes(default_company)) {
            emp_no = default_company + "-" + emp_no;
          }
          let check = this.dupeEmployee(emp_no, emp_id);
          if (check) {
            const response = {
              error: "emp_no already associated " +
                "with another employee"
            }
            return response;
          } else {
            toupdate.setEmpNo(emp_no);
          }
        }

        if (hire_date != null) {
          var hire_date = format(
            parse(
              hire_date,
              'YYYY-MM-DD',
              new Date()
            ),
            'YYYY-MM-DD'
          );

          var now = format(
            new Date(),
            'YYYY-MM-DD'
          );

          if (date_fns.isAfter(hire_date, now)) {
            const response = {
              error: "hire date can't be future date"
            }
            return response;
          } else {

            if (date_fns.isWeekend(hire_date)) {
              const response = {
                error: "employee can't be hired on " +
                  "weekends"
              }
              return response;
            } else {
              toupdate.setHireDate(hire_date);
            }
          }
        }

        if (job != null) {
          toupdate.setJob(job);
        }

        if (salary != null) {
          toupdate.setSalary(salary);
        }

        if (dept_id != null) {
          let dept = datalayer.getDepartment(default_company, dept_id);

          if (dept == null) {
            const response = {
              error: "department doesn't exist"
            }
            return response;
          } else {
            toupdate.setDeptId(dept_id);
          }
        }

        if (mng_id != null && mng_id !=0 ) {
          let mngr = datalayer.getEmployee(mng_id);
          if (mngr == null) {
            const response = {
              error: "manager doesn't exist"
            }
            return response;
          } else {
            toupdate.setMngId(mng_id);
          }
        }

        toupdate = datalayer.updateEmployee(toupdate);

        const response = {
          success: toupdate
        }
        return response;
      }
    } catch (e) {
      console.log(e);
      return e;
    }
  }

  deleteEmployee(req) {
    try {
      let emp_id = req.query.emp_id;
      if (emp_id == null) {
        const response = {
          error: "Employee id cannot be null"
        }
        return response;
      }

      //check if employee exists
      let employee = datalayer.getEmployee(emp_id);
      if (employee == null) {
        const response = {
          error: "Employee doesn't exist"
        }
        return response;
      } else {
        //remove him from other employee's manager id
        let e = datalayer.getAllEmployee(default_company);
        for (let i = 0; i < e.length; i++) {
          if (e[i].getMngId() == emp_id) {
            e[i].setMngId(-1);
            datalayer.updateEmployee(e[i]);
          }
        }

        //remove all of his timecards
        let t = datalayer.getAllTimecard(emp_id);
        for (let i = 0; i < t.length; i++) {
          datalayer.deleteTimecard(t[i].getId());
        }

        let deletedEmp = datalayer.deleteEmployee(emp_id);
        if (deletedEmp >= 1) {
          const response = {
            success: "Employee " + emp_id + " deleted."
          }
          return response;
        } else {
          const response = {
            error: "Employee couldn't be deleted"
          }
          return response;
        }
      }
    } catch (e) {
      console.log(e);
      return e;
    }

  }

  getTimecard(req) {
    try {
      let timecard = datalayer.getTimecard(req.query.timecard_id);
      if (timecard != null) {
        return timecard;
      } else {
        const response = {
          error: "Timecard does not exist"
        }
        return response;
      }
    } catch (e) {
      console.log(e);
      return e;
    }
  }

  getAllTimecard(req) {
    try {
      let emp_id = req.query.emp_id;
      if (emp_id != null) {
        let timecards = datalayer.getAllTimecard(emp_id);
        return timecards;
      } else {
        const response = {
          error: "employee id cant be null"
        }
        return response;
      }
    } catch (e) {
      console.log(e);
      return e;
    }
  }

  postTimecard(emp_id, start_time, end_time) {
    try {
      if (emp_id == null || start_time == null || end_time == null) {
        const response = {
          error: "Please provide all employee fields"
        }
        return response;
      } else {
        let em = datalayer.getEmployee(emp_id);
        if (em == null) {
          const response = {
            error: "employee id does not exist"
          }
          return response;
        } else {
          var start_time = format(
            parse(
              start_time,
              'YYYY-MM-DD HH:mm:ss',
              new Date()
            ),
            'YYYY-MM-DD HH:mm:ss'
          );

          var end_time = format(
            parse(
              end_time,
              'YYYY-MM-DD HH:mm:ss',
              new Date()
            ),
            'YYYY-MM-DD HH:mm:ss'
          );

          var now = format(
            new Date(),
            'YYYY-MM-DD HH:mm:ss'
          );

          let week_before_now = date_fns.subWeeks(now, 1);
          week_before_now = format(
            week_before_now,
            'YYYY-MM-DD HH:mm:ss'
          );

          // console.log(start_time);
          // console.log(end_time);
          // console.log(now);
          // console.log(week_before_now);

          if (date_fns.isWithinRange(start_time, week_before_now, now)) {
            if (date_fns.differenceInHours(end_time, start_time) >= 1 &&
              date_fns.isSameDay(start_time, end_time)) {
              if (!date_fns.isWeekend(start_time) && !date_fns.isWeekend(end_time)) {
                if (date_fns.getHours(start_time) >= 6 &&
                  date_fns.getHours(start_time) <= 18 &&
                  date_fns.getHours(end_time) >= 6 &&
                  date_fns.getHours(end_time) <= 18) {
                  let timecards = datalayer.getAllTimecard(emp_id);
                  for (let i = 0; i < timecards.length; i++) {
                    let time = format(
                      parse(
                        timecards[i].getStartTime(),
                        'YYYY-MM-DD HH:mm:ss',
                        new Date()
                      ),
                      'YYYY-MM-DD HH:mm:ss'
                    );
                    if (date_fns.isSameDay(time, start_time)) {
                      const response = {
                        error: "Timecard already exists for same day"
                      }
                      return response;
                    }
                  }
                  let toinsert = new Timecard(start_time, end_time, emp_id);
                  toinsert = datalayer.insertTimecard(toinsert);
                  const response = {
                    success: toinsert
                  }
                  return response

                } else {
                  const response = {
                    error: "start_time and end_time must be between the hours (in 24 hour format) of 06:00:00 and 18:00:00 inclusive"
                  }
                  return response;
                }

              } else {
                const response = {
                  error: "start_time and end_time cannot be Saturday or Sunday"
                }
                return response;
              }
            } else {
              const response = {
                error: "end_time must be a valid date and time at least 1 hour greater than the start_time and be on the same day as the start_time"
              }
              return response;
            }

          } else {
            const response = {
              error: "start_time must be a valid date and time equal to the current date or up to 1 week ago from the current date"
            }
            return response;
          }
        }
      }
    } catch (e) {
      console.log(e);
      return e;
    }
  }

  putTimecard(timecard_id, emp_id, start_time, end_time) {
    try {
      if (timecard_id == null) {
        const response = {
          error: "timecard id can't be null"
        }
        return response;
      } else {
        let timecard = datalayer.getTimecard(timecard_id);
        if (timecard == null) {
          const response = {
            error: "timecard doesn't exist"
          }
          return response;
        } else {
          if (emp_id != null) {
            let employee = datalayer.getEmployee(emp_id);
            if (employee == null) {
              const response = {
                error: "employee doesn't exist"
              }
              return response;
            } else {
              timecard.setEmpId(emp_id);
            }
          } else {
            emp_id = timecard.getEmpId();
          }

          if (start_time != null) {
            var start_time = format(
              parse(
                start_time,
                'YYYY-MM-DD HH:mm:ss',
                new Date()
              ),
              'YYYY-MM-DD HH:mm:ss'
            );
            timecard.setStartTime(start_time);
          } else {
            start_time = timecard.getStartTime();
          }

          if (end_time != null) {
            var end_time = format(
              parse(
                end_time,
                'YYYY-MM-DD HH:mm:ss',
                new Date()
              ),
              'YYYY-MM-DD HH:mm:ss'
            );
            timecard.setEndTime(end_time);
          } else {
            end_time = timecard.getEndTime();
          }

          var now = format(
            new Date(),
            'YYYY-MM-DD HH:mm:ss'
          );

          let week_before_now = date_fns.subWeeks(now, 1);
          week_before_now = format(
            week_before_now,
            'YYYY-MM-DD HH:mm:ss'
          );

          if (date_fns.isWithinRange(start_time, week_before_now, now)) {
            if (date_fns.differenceInHours(end_time, start_time) >= 1 &&
              date_fns.isSameDay(start_time, end_time)) {
              if (!date_fns.isWeekend(start_time) && !date_fns.isWeekend(end_time)) {
                if (date_fns.getHours(start_time) >= 6 &&
                  date_fns.getHours(start_time) <= 18 &&
                  date_fns.getHours(end_time) >= 6 &&
                  date_fns.getHours(end_time) <= 18) {
                  let timecards = datalayer.getAllTimecard(emp_id);
                  for (let i = 0; i < timecards.length; i++) {
                    let time = format(
                      parse(
                        timecards[i].getStartTime(),
                        'YYYY-MM-DD HH:mm:ss',
                        new Date()
                      ),
                      'YYYY-MM-DD HH:mm:ss'
                    );
                    if (date_fns.isSameDay(time, start_time) && timecards[i].getId() != timecard_id) {
                      const response = {
                        error: "Timecard already exists for same day"
                      }
                      return response;
                    }
                  }
                  let toupdate = datalayer.updateTimecard(timecard);
                  const response = {
                    success: toupdate
                  }
                  return response

                } else {
                  const response = {
                    error: "start_time and end_time must be between the hours (in 24 hour format) of 06:00:00 and 18:00:00 inclusive"
                  }
                  return response;
                }

              } else {
                const response = {
                  error: "start_time and end_time cannot be Saturday or Sunday"
                }
                return response;
              }
            } else {
              const response = {
                error: "end_time must be a valid date and time at least 1 hour greater than the start_time and be on the same day as the start_time"
              }
              return response;
            }

          } else {
            const response = {
              error: "start_time must be a valid date and time equal to the current date or up to 1 week ago from the current date"
            }
            return response;
          }

        }
      }
    } catch (e) {
      console.log(e);
      return e;
    }
  }

  deleteTimecard(req) {
    try {
      let timecard_id = req.query.timecard_id;
      let timecard = datalayer.getTimecard(timecard_id);
      //check if timecard exists and delete
      if (timecard == null) {
        const response = {
          error: "Timecard doesnt exist"
        }
        return response;
      } else {
        let id = datalayer.deleteTimecard(timecard_id);
        if (id >= 1) {
          const response = {
            success: "Timecard " + timecard_id + " " + "deleted"
          }
          return response;
        } else {
          const response = {
            error: "Timecard not deleted"
          }
          return response;
        }
      }
    } catch (e) {
      console.log(e);
      return e;
    }
  }
}