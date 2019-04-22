package Timecard;

import com.google.gson.GsonBuilder;
import com.google.gson.JsonObject;
import companydata.*;

import javax.ws.rs.*;
import java.sql.Timestamp;
import java.text.SimpleDateFormat;
import java.time.temporal.ChronoUnit;
import java.util.Calendar;
import java.util.Date;
import java.util.List;

import com.google.gson.Gson;
import org.json.*;

@Path("/CompanyServices")
public class EmployeeService {

    private Gson gson = new GsonBuilder().setDateFormat("yyyy" +
            "-MM-dd").create();
    private String default_compname = "ks3057";


    private Boolean duplicateDepartment(String dept_no, Integer dept_id) {
        /**
         * Helper to check if department name supplied is unique
         */
        DataLayer dl;
        try {
            dl = new DataLayer("development");
            //check if another department exists with same department number

            List<Department> departments = dl.getAllDepartment(default_compname);
            Boolean exists = false;
            for (Department dep : departments) {
                if (dep.getId() != dept_id) {
                    if (dep.getDeptNo().equals(dept_no)) {
                        exists = true;
                        break;
                    }
                }
            }
            return exists;

        } catch (Exception e) {
            return null;
        }

    }

    private Boolean duplicateDepartment(String dept_no) {
        /**
         * Helper to check if department name supplied is unique
         */
        DataLayer dl;
        try {
            dl = new DataLayer("development");
            //check if another department exists with same department number

            List<Department> departments = dl.getAllDepartment(default_compname);
            Boolean exists = false;
            for (Department dep : departments) {
                if (dep.getDeptNo().equals(dept_no)) {
                    exists = true;
                    break;
                }
            }
            return exists;

        } catch (Exception e) {
            return null;
        }

    }

    private Boolean duplicateEmployee(String emp_no, Integer emp_id) {
        /**
         * Helper to check if employee number supplied is unique
         */
        try {
            DataLayer dl = new DataLayer("development");
            List<Employee> employees = dl.getAllEmployee(default_compname);
            for (Employee employee :
                    employees) {
                if (employee.getEmpNo().equals(emp_no) && employee.getId() != emp_id) {
                    return true;
                }
            }

            return false;

        } catch (Exception e) {
            return null;
        }
    }

    private Boolean duplicateEmployee(String emp_no) {
        /**
         * Helper to check if employee number supplied is unique
         */
        try {
            DataLayer dl = new DataLayer("development");
            List<Employee> employees = dl.getAllEmployee(default_compname);
            for (Employee employee :
                    employees) {
                if (employee.getEmpNo().equals(emp_no)) {
                    return true;
                }
            }

            return false;

        } catch (Exception e) {
            return null;
        }
    }

    @Path("/company")
    @DELETE
    @Produces("application/json")
    @Consumes("test/plain")
    public String deleteCompany(@QueryParam("company") String companyName) {
        DataLayer dl = null;
        try {
            dl = new DataLayer("development");
            Integer numRowsDeleted = dl.deleteCompany(companyName);
            JsonObject json = new JsonObject();
            json.addProperty("success", companyName + "\'s information " +
                    "deleted");
            return json.toString();
        } catch (Exception e) {
            return e.getMessage();
        } finally {
            dl.close();
        }
    }

    @Path("/department")
    @GET
    @Produces("application/json")
    @Consumes("text/plain")
    public String getDepartment(@QueryParam("company") String companyName,
                                @QueryParam("dept_id") Integer dept_id) {
        DataLayer dl = null;
        try {

            dl = new DataLayer("development");

            if (companyName == null || dept_id == null) {
                JsonObject json = new JsonObject();
                json.addProperty("error", "Company and department cannot be " +
                        "null");
                return json.toString();
            }


            Department department = dl.getDepartment(companyName, dept_id);
            if (department != null) {
                return gson.toJson(department);
            } else {
                JsonObject json = new JsonObject();
                json.addProperty("error", "Department does not exist");
                return json.toString();
            }


        } catch (Exception e) {
            JsonObject json = new JsonObject();
            json.addProperty("error", e.getMessage());
            return json.toString();
        } finally {
            dl.close();
        }
    }

    @Path("/departments")
    @GET
    @Produces("application/json")
    @Consumes("text/plain")
    public String getAllDepartment(@QueryParam("company") String
                                           companyName) {
        DataLayer dl = null;
        JsonObject message = new JsonObject();
        try {
            dl = new DataLayer("development");
            List<Department> departments = dl.getAllDepartment(companyName);
            if(departments.size() == 0){
                JsonObject json = new JsonObject();
                json.addProperty("error", companyName + " does not have any " +
                        "departments");
                return json.toString();
            }
            return gson.toJson(departments);

        } catch (Exception e) {
            JsonObject json = new JsonObject();
            json.addProperty("error", e.getMessage());
            return json.toString();
        } finally {
            dl.close();
        }
    }

    @Path("/department")
    @POST
    @Produces("application/json")
    @Consumes("application/json")
    public String insertDepartment(String department) {
        DataLayer dl = null;
        try {
            JSONObject obj = new JSONObject(department);
            dl = new DataLayer("development");

            //check if all values are present
            if (!obj.has("company") || !obj.has("dept_name")
                    || !obj.has("dept_no") || !obj.has("location")
            ) {

                JsonObject json = new JsonObject();
                json.addProperty("error", "company name/department " +
                        "name/department number/location cant be null");
                return json.toString();

            }

            //if duplicate department number, then return error
            //else add department to database
            if (!obj.getString("dept_no").contains(default_compname)) {
                obj.put("dept_no", default_compname + obj.getString("dept_no"));
            }

            if (duplicateDepartment(obj.getString("dept_no"))) {
                JsonObject json = new JsonObject();
                json.addProperty("error", "Department number already exists");
                return json.toString();

            } else {

                Department dept = new Department(obj.getString("company"),
                        obj.getString("dept_name"), obj.getString("dept_no"),
                        obj.getString("location"));

                Department d = dl.insertDepartment(dept);

                if (d.getId() > 0) {
                    JsonObject jobj = new JsonObject();
                    jobj.add("success", new Gson().toJsonTree(dept));

                    return jobj.toString();

                } else {
                    JsonObject json = new JsonObject();
                    json.addProperty("error", "Not inserted");
                    return json.toString();
                }

            }


        } catch (Exception e) {
            JsonObject json = new JsonObject();
            json.addProperty("error", e.getMessage());
            return json.toString();
        } finally {
            dl.close();
        }

    }


    @Path("/department")
    @PUT
    @Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
    public String updateDepartment(@FormParam("company") String companyName,
                                   @FormParam("location") String location,
                                   @FormParam("dept_id") Integer dept_id,
                                   @FormParam("dept_no") String dept_no,
                                   @FormParam("dept_name") String dept_name) {
        DataLayer dl = null;
        try {

            dl = new DataLayer("development");

            //check for null values
            if (dept_id == null) {
                JsonObject json = new JsonObject();
                json.addProperty("error", "Department id can't be null");
                return json.toString();
            } else {

                //check if department id exists
                Department d = dl.getDepartment(default_compname, dept_id);
                if (d == null) {
                    JsonObject json = new JsonObject();
                    json.addProperty("error", "Department does not exist");
                    return json.toString();

                } else {
                    //check if another department exists with same department number
                    if (dept_no != null) {
                        if (!dept_no.contains(default_compname)) {
                            dept_no = default_compname + dept_no;
                        }
                        if (duplicateDepartment(dept_no,
                                dept_id)) {
                            JsonObject json = new JsonObject();
                            json.addProperty("error", "Department number already exists");
                            return json.toString();

                        }

                    }

                    if (companyName != null) {
                        d.setCompany(companyName);
                    }
                    if (dept_name != null) {
                        d.setDeptName(dept_name);
                    }

                    if (location != null) {
                        d.setLocation(location);
                    }

                    d = dl.updateDepartment(d);

                    JsonObject jobj = new JsonObject();
                    jobj.add("success", new Gson().toJsonTree(d));

                    return jobj.toString();
                }
            }

        } catch (Exception e) {
            JsonObject json = new JsonObject();
            json.addProperty("error", e.getMessage());
            return json.toString();
        } finally {
            dl.close();
        }


    }

    @Path("/department")
    @DELETE
    @Produces("application/json")
    @Consumes("text/plain")
    public String deleteDepartment(@QueryParam("company") String
                                           companyName, @QueryParam("dept_id") Integer dept_id) {
        DataLayer dl = null;
        try {
            dl = new DataLayer("development");
            if (companyName == null || dept_id == null) {
                JsonObject json = new JsonObject();
                json.addProperty("error", "please enter company name and " +
                        "department id");
                return json.toString();
            }

            if (dl.getDepartment(companyName, dept_id) != null) {

                //we need to delete all employees and their timecards from
                // department first
                List<Employee> employees = dl.getAllEmployee(companyName);
                for (Employee employee :
                        employees) {
                    if (employee.getDeptId() == dept_id) {
                        List<Timecard> timecards = dl.getAllTimecard(employee.getId());
                        for (Timecard timecard:
                                timecards) {
                            dl.deleteTimecard(timecard.getId());
                        }
                        dl.deleteEmployee(employee.getId());
                    }
                }

                int deleted = dl.deleteDepartment(companyName, dept_id);
                JsonObject json = new JsonObject();

                if (deleted >= 1) {
                    String value =
                            "Department " + dept_id + " from " + companyName + " deleted";
                    json.addProperty("success", value);
                    return json.toString();

                } else {
                    json.addProperty("error", "could not delete");
                    return json.toString();
                }

            } else {

                JsonObject json = new JsonObject();
                json.addProperty("error", "company or department doesn't " +
                        "exist");
                return json.toString();
            }


        } catch (Exception e) {
            JsonObject json = new JsonObject();
            json.addProperty("error", e.getMessage());
            return json.toString();
        }
        finally {
            dl.close();
        }
    }

    @Path("/employee")
    @GET
    @Produces("application/json")
    @Consumes("text/plain")
    public String getEmployee(@QueryParam("emp_id") Integer emp_id) {
        DataLayer dl = null;
        try {

            String ret;
            dl = new DataLayer("development");

            if (emp_id == null) {
                JsonObject json = new JsonObject();
                json.addProperty("error", "Employee id can't be null");
                return json.toString();
            }


            Employee employee = dl.getEmployee(emp_id);
            if (employee != null) {
                return gson.toJson(employee);
            } else {
                JsonObject json = new JsonObject();
                json.addProperty("error", "Employee does not exist");
                return json.toString();
            }

        } catch (Exception e) {
            JsonObject json = new JsonObject();
            json.addProperty("error", e.getMessage());
            return json.toString();

        } finally {
            dl.close();
        }
    }

    @Path("/employees")
    @GET
    @Produces("application/json")
    @Consumes("text/plain")
    public String getAllEmployee(@QueryParam("company") String companyName) {
        DataLayer dl = null;

        try {

            dl = new DataLayer("development");
            List<Employee> employees = dl.getAllEmployee(companyName);

            return gson.toJson(employees);
        } catch (Exception e) {
            JsonObject json = new JsonObject();
            json.addProperty("error", e.getMessage());
            return json.toString();
        } finally {
            dl.close();
        }
    }


    @Path("/employee")
    @POST
    @Produces("application/json")
    @Consumes("application/json")
    public String insertEmployee(String employeejson) {
        DataLayer dl = null;
        JsonObject json = new JsonObject();
        try {

            JSONObject obj = new JSONObject(employeejson);
            dl = new DataLayer("development");

            if (!obj.has("emp_name") ||
                    !obj.has("emp_no") ||
                    !obj.has("hire_date") ||
                    !obj.has("salary") ||
                    !obj.has("mng_id") ||
                    !obj.has("dept_id") ||
                    !obj.has("job")) {


                json.addProperty("error", "No employee field can be empty");
                return json.toString();
            }

            //validations
            Department department = dl.getDepartment(default_compname,
                    obj.getInt("dept_id"));
            if (department == null) {
                json.addProperty("error","department doesn't exist");
                return json.toString();
            }

            Employee employee = dl.getEmployee(obj.getInt("mng_id"));
            if (employee == null) {
                json.addProperty("error","manager doesn't exist");
                return json.toString();
            }

            Date hire_date =
                    new SimpleDateFormat("yyyy-MM-dd").parse(obj.getString("hire_date"));
            Date now = new Date();
            if (hire_date.before(now) || hire_date.equals(now)) {
                Calendar c = Calendar.getInstance();
                c.setTime(hire_date);
                int dayOfWeek = c.get(Calendar.DAY_OF_WEEK);
                if (dayOfWeek == Calendar.SATURDAY || dayOfWeek == Calendar.SUNDAY) {
                    json.addProperty("error","employee can't be hired on " +
                            "weekends");
                    return json.toString();
                }

            } else {
                json.addProperty("error","hire date can't be future date");
                return json.toString();
            }

            if (!obj.getString("emp_no").contains(default_compname)) {
                obj.put("emp_no", default_compname + "-" + obj.getString(
                        "emp_no"));
            }

            if (duplicateEmployee(obj.getString("emp_no"))) {
                json.addProperty("error","employee number is already " +
                        "associated with another employee");
                return json.toString();
            } else {

                Employee emp = new Employee(obj.getString("emp_name"),
                        obj.getString("emp_no"),
                        new java.sql.Date(hire_date.getTime()),
                        obj.getString("job"), obj.getDouble("salary"),
                        obj.getInt("dept_id"), obj.getInt("mng_id"));

                emp = dl.insertEmployee(emp);

                if (emp.getId() > 0) {
                    JsonObject jobj = new JsonObject();
                    jobj.add("success", gson.toJsonTree(emp));
                    return jobj.toString();

                } else {
                    json.addProperty("error","not inserted");
                    return json.toString();
                }

            }
        } catch (Exception e) {

            json.addProperty("error",e.getMessage());
            return json.toString();
        } finally {
            dl.close();
        }

    }


    @Path("/employee")
    @PUT
    @Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
    public String updateEmployee(@FormParam("emp_id") Integer emp_id,
                                 @FormParam("emp_name") String emp_name,
                                 @FormParam("emp_no") String emp_no,
                                 @FormParam("hire_date") String hire_date,
                                 @FormParam("job") String job,
                                 @FormParam("salary") Double salary,
                                 @FormParam("dept_id") Integer dept_id,
                                 @FormParam("mng_id") Integer mng_id) {
        DataLayer dl = null;
        JsonObject json = new JsonObject();
        try {

            dl = new DataLayer("development");

            if (emp_id == null) {

                json.addProperty("error","emp_id can't be null");
                return json.toString();
            }

            //validations
            Employee toupdate = dl.getEmployee(emp_id);
            if (toupdate == null) {
                json.addProperty("error","employee doesn't exist");
                return json.toString();
            } else {

                if (emp_name != null) {
                    toupdate.setEmpName(emp_name);
                }

                if (emp_no != null) {
                    if (!emp_no.contains(default_compname)) {
                        emp_no = default_compname + "-" + emp_no;
                    }
                    Boolean check = duplicateEmployee(emp_no,
                            emp_id);
                    if (check) {
                        json.addProperty("error","emp_no already associated " +
                                "with another employee");
                        return json.toString();
                    }

                    toupdate.setEmpNo(emp_no);
                }

                if (hire_date != null) {
                    Date hireDate =
                            new SimpleDateFormat("yyyy-MM-dd").parse(hire_date);

                    Date now = new Date();

                    if (hireDate.after(now)) {
                        json.addProperty("error","hire date can't be future " +
                                "date");
                        return json.toString();
                    } else {

                        Calendar c = Calendar.getInstance();
                        c.setTime(hireDate);
                        int dayOfWeek = c.get(Calendar.DAY_OF_WEEK);
                        if (dayOfWeek == Calendar.SATURDAY || dayOfWeek == Calendar.SUNDAY) {
                            json.addProperty("error","employee cant be hired " +
                                    "on weekends");
                            return json.toString();
                        }

                        toupdate.setHireDate(new java.sql.Date(hireDate.getTime()));
                    }
                }

                if (job != null) {
                    toupdate.setJob(job);
                }

                if (salary != null) {
                    toupdate.setSalary(salary);
                }

                if (dept_id != null) {
                    Department dept = dl.getDepartment(default_compname, dept_id);

                    if (dept == null) {
                        json.addProperty("error","department doesn't exist");
                        return json.toString();
                    } else {
                        toupdate.setDeptId(dept_id);
                    }

                }

                if (mng_id != null) {
                    Employee mngr = dl.getEmployee(mng_id);
                    if (mngr == null) {
                        json.addProperty("error","manager doesn't exist");
                        return json.toString();
                    }
                    toupdate.setMngId(mng_id);
                }

                toupdate = dl.updateEmployee(toupdate);

                JsonObject jobj = new JsonObject();
                jobj.add("success", gson.toJsonTree(toupdate));
                return jobj.toString();

            }

        } catch (Exception e) {
            json.addProperty("error",e.getMessage());
            return json.toString();
        } finally {
            dl.close();
        }

    }


    @Path("/employee")
    @DELETE
    @Produces("application/json")
    @Consumes("text/plain")
    public String deleteEmployee(@QueryParam("emp_id") Integer emp_id) {
        DataLayer dl = null;
        try {
            dl = new DataLayer("development");
            //check if employee is null
            if (emp_id == null) {
                JsonObject json = new JsonObject();
                json.addProperty("error", "Employee id cannot be null");
                return json.toString();
            }

            //check if employee exists
            Employee employee = dl.getEmployee(emp_id);
            if (employee == null) {
                JsonObject json = new JsonObject();
                json.addProperty("error", "Employee doesn't exist");
                return json.toString();

            } else {
                //remove him from other employee's manager id
                List<Employee> employees = dl.getAllEmployee(default_compname);
                for (Employee emp : employees) {
                    if (emp.getMngId() == emp_id) {
                        emp.setMngId(-1);
                        dl.updateEmployee(emp);
                    }
                }

                //remove all of his timecards
                List<Timecard> timecards = dl.getAllTimecard(emp_id);
                for (Timecard timecard:
                     timecards) {
                    dl.deleteTimecard(timecard.getId());
                }

                int deletedEmp = dl.deleteEmployee(emp_id);
                if (deletedEmp >= 1) {
                    JsonObject json = new JsonObject();
                    String value = "Employee " + emp_id + " deleted.";
                    json.addProperty("success", value);
                    return json.toString();

                } else {
                    JsonObject json = new JsonObject();
                    json.addProperty("error", "Employee couldn't be deleted");
                    return json.toString();
                }

            }
        } catch (Exception e) {
            JsonObject json = new JsonObject();
            json.addProperty("error",e.getMessage());
            return json.toString();
        } finally {
            dl.close();
        }

    }


    @Path("/timecard")
    @GET
    @Produces("application/json")
    @Consumes("text/plain")
    public String getTimecard(@QueryParam("timecard_id") Integer
                                      timecard_id) {
        DataLayer dl = null;
        JsonObject message = new JsonObject();
        gson = new GsonBuilder().setDateFormat("yyyy-MM-dd " +
                "HH:mm:ss").create();
        try {
            dl = new DataLayer("development");
            Timecard timecard = dl.getTimecard(timecard_id);
            if (timecard != null) {
                String t = gson.toJson(timecard);
                return t;
            } else {
                message.addProperty("error", "Timecard does not exist");
                return message.toString();
            }

        } catch (Exception e) {
            message.addProperty("error", e.getMessage());
            return message.toString();

        } finally {
            dl.close();
        }
    }

    @Path("/timecards")
    @GET
    @Produces("application/json")
    @Consumes("text/plain")
    public String getAllTimecard(@QueryParam("emp_id") Integer
                                         emp_id) {

        DataLayer dl;
        JsonObject message = new JsonObject();
        gson = new GsonBuilder().setDateFormat("yyyy-MM-dd " +
                "HH:mm:ss").create();
        try {
            dl = new DataLayer("development");
            if (emp_id != null) {
                List<Timecard> timecards = dl.getAllTimecard(emp_id);
                if (timecards.size() == 0) {
                    message.addProperty("error", "employee id doesn't exist");
                    return message.toString();
                } else {
                    return gson.toJson(timecards);
                }
            } else {
                message.addProperty("error", "employee id can't be null");
                return message.toString();
            }

        } catch (Exception e) {
            message.addProperty("error", e.getMessage());
            return message.toString();

        }

    }

    @Path("/timecard")
    @POST
    @Produces("application/json")
    @Consumes("application/json")
    public String insertTimecard(String timecardjson) {
        DataLayer dl = null;
        JsonObject message = new JsonObject();
        gson = new GsonBuilder().setDateFormat("yyyy-MM-dd " +
                "HH:mm:ss").create();
        try {
            JSONObject obj = new JSONObject(timecardjson);
            dl = new DataLayer("development");
            if (!obj.has("emp_id") || !obj.has("start_time") || !obj.has("end_time")) {
                message.addProperty("error", "all employee fields must be " +
                        "filled");
                return message.toString();
            } else {

                Employee em = dl.getEmployee(obj.getInt("emp_id"));
                if (em == null) {
                    message.addProperty("error", "employee id does not exist");
                    return message.toString();
                } else {

                    Timestamp start_time =
                            new Timestamp(new SimpleDateFormat("yyyy-MM-dd " +
                                    "HH:mm:ss").parse(obj.getString("start_time")).getTime());

                    Date now = new Date(System.currentTimeMillis());
                    Date week_before_now = new Date(System.currentTimeMillis());
                    Calendar start_week_before = Calendar.getInstance();
                    start_week_before.setTime(week_before_now);
                    start_week_before.add(Calendar.DATE, -7);

                    if (start_time.before(start_week_before.getTime()) || start_time.after(now)) {
                        message.addProperty("error", "start_time must be a valid date and time equal to the current date or up to 1 week ago from the current date.");
                        return message.toString();

                    } else {

                        Timestamp end_time =
                                new Timestamp(new SimpleDateFormat("yyyy-MM-dd " +
                                        "HH:mm:ss").parse(obj.getString(
                                        "end_time")).getTime());

                        Calendar end = Calendar.getInstance();
                        end.setTimeInMillis(end_time.getTime());

                        Calendar start = Calendar.getInstance();
                        start.setTimeInMillis(start_time.getTime());

                        if (end.get(Calendar.DAY_OF_YEAR) == start.get(Calendar.DAY_OF_YEAR) && end.after(start)
                        ) {
                            long hours = ChronoUnit.HOURS.between(start.toInstant(),
                                    end.toInstant());
                            if (hours >= 1) {
                                if (end.get(Calendar.DAY_OF_WEEK) != Calendar.SATURDAY &&
                                        end.get(Calendar.DAY_OF_WEEK) != Calendar.SUNDAY &&
                                        start.get(Calendar.DAY_OF_WEEK) != Calendar.SATURDAY &&
                                        start.get(Calendar.DAY_OF_WEEK) != Calendar.SUNDAY
                                ) {
                                    System.out.println(start.get(Calendar.HOUR_OF_DAY));
                                    if (end.get(Calendar.HOUR_OF_DAY) < 6 ||
                                            end.get(Calendar.HOUR_OF_DAY) > 18 ||
                                            start.get(Calendar.HOUR_OF_DAY) < 6 ||
                                            start.get(Calendar.HOUR_OF_DAY) > 18) {
                                        message.addProperty("error", "invalid" +
                                                " hours");
                                        return message.toString();

                                    } else {
                                        List<Timecard> timecards =
                                                dl.getAllTimecard(obj.getInt(
                                                        "emp_id"));

                                        for (Timecard timecard :
                                                timecards) {
                                            Calendar temp =
                                                    Calendar.getInstance();
                                            temp.setTimeInMillis(timecard.getStartTime().getTime());
                                            if (temp.get(Calendar.DAY_OF_YEAR) == start.get(Calendar.DAY_OF_YEAR)) {
                                                message.addProperty("error",
                                                        "timecard already " +
                                                                "exists for " +
                                                                "same day");
                                                return message.toString();
                                            }
                                        }

                                        Timecard toinsert =
                                                new Timecard(start_time,
                                                        end_time, obj.getInt(
                                                        "emp_id"));
                                        toinsert =
                                                dl.insertTimecard(toinsert);

                                        JsonObject jobj = new JsonObject();
                                        jobj.add("success",
                                                gson.toJsonTree(toinsert));
                                        return jobj.toString();
                                    }

                                } else {
                                    message.addProperty("error", "cannot be " +
                                            "weekend");
                                    return message.toString();
                                }

                            } else {
                                message.addProperty("error", "start time must be " +
                                        "at least one" +
                                        " " +
                                        "hour ahead of end time");
                                return message.toString();
                            }
                        } else {
                            message.addProperty("error", "start time must be " +
                                    "on same day as end time and before it");
                            return message.toString();
                        }

                    }
                }
            }


        } catch (Exception e) {
            message.addProperty("error", e.getMessage());
            return message.toString();
        }
    }

    @Path("/timecard")
    @PUT
    @Produces("application/json")
    @Consumes("application/x-www-form-urlencoded")
    public String updateTimecard(@FormParam("timecard_id") Integer timecard_id,
                                 @FormParam("emp_id") Integer emp_id,
                                 @FormParam("start_time") String start_time,
                                 @FormParam("end_time") String end_time) {

        DataLayer dl;
        JsonObject message = new JsonObject();
        gson = new GsonBuilder().setDateFormat("yyyy-MM-dd " +
                "HH:mm:ss").create();
        try {
            dl = new DataLayer("development");
            if (timecard_id == null) {
                message.addProperty("error", "timecard id can't be null");
                return message.toString();
            } else {
                Timecard timecard = dl.getTimecard(timecard_id);
                if (timecard == null) {
                    message.addProperty("error", "timecard doesn't exist");
                    return message.toString();
                } else {
                    if (emp_id != null) {
                        Employee employee = dl.getEmployee(emp_id);
                        if (employee == null) {
                            message.addProperty("error", "employee doesn't " +
                                    "exist");
                            return message.toString();
                        }

                    } else {
                        emp_id = timecard.getEmpId();
                    }

                    Calendar start = Calendar.getInstance();
                    Calendar end = Calendar.getInstance();
                    if (start_time != null) {
                        Timestamp startTime =
                                new Timestamp(new SimpleDateFormat("yyyy-MM-dd " +
                                        "HH:mm:ss").parse(start_time).getTime());
                        start.setTimeInMillis(startTime.getTime());

                    } else {
                        start.setTimeInMillis(timecard.getStartTime().getTime());
                    }


                    if (end_time != null){
                        Timestamp endTime =
                                new Timestamp(new SimpleDateFormat("yyyy-MM-dd " +
                                        "HH:mm:ss").parse(end_time).getTime());
                        end.setTimeInMillis(endTime.getTime());
                    } else {
                        end.setTimeInMillis(timecard.getEndTime().getTime());
                    }


                    Date now = new Date(System.currentTimeMillis());
                    Date week_before_now = new Date(System.currentTimeMillis());
                    Calendar start_week_before = Calendar.getInstance();
                    start_week_before.setTime(week_before_now);
                    start_week_before.add(Calendar.DATE, -7);

                    if (start.before(start_week_before) || start.after(now)) {
                        message.addProperty("error", "start_time must be a valid date and time equal to the current date or up to 1 week ago from the current date.");
                        return message.toString();

                    }

                    if (end.get(Calendar.DAY_OF_YEAR) == start.get(Calendar.DAY_OF_YEAR) && end.after(start)
                    ) {
                        long hours = ChronoUnit.HOURS.between(start.toInstant(),
                                end.toInstant());
                        if (hours >= 1) {
                            if (end.get(Calendar.DAY_OF_WEEK) != Calendar.SATURDAY &&
                                    end.get(Calendar.DAY_OF_WEEK) != Calendar.SUNDAY &&
                                    start.get(Calendar.DAY_OF_WEEK) != Calendar.SATURDAY &&
                                    start.get(Calendar.DAY_OF_WEEK) != Calendar.SUNDAY
                            ) {
                                if (end.get(Calendar.HOUR_OF_DAY) < 6 ||
                                        end.get(Calendar.HOUR_OF_DAY) > 18 ||
                                        start.get(Calendar.HOUR_OF_DAY) < 6 ||
                                        start.get(Calendar.HOUR_OF_DAY) > 18) {
                                    message.addProperty("error", "invalid" +
                                            " hours");
                                    return message.toString();

                                } else {
                                    List<Timecard> timecards =
                                            dl.getAllTimecard(emp_id);

                                    for (Timecard tc :
                                            timecards) {
                                        Calendar temp =
                                                Calendar.getInstance();
                                        temp.setTimeInMillis(tc.getStartTime().getTime());
                                        if (temp.get(Calendar.DAY_OF_YEAR) == start.get(Calendar.DAY_OF_YEAR) &&
                                        timecard.getEmpId() != emp_id) {
                                            message.addProperty("error",
                                                    "timecard already " +
                                                            "exists for " +
                                                            "same day");
                                            return message.toString();
                                        }
                                    }

                                    timecard.setEmpId(emp_id);
                                    timecard.setStartTime(new Timestamp(start.getTimeInMillis()));
                                    timecard.setEndTime(new Timestamp(end.getTimeInMillis()));

                                    timecard =
                                            dl.updateTimecard(timecard);
                                    JsonObject jobj = new JsonObject();
                                    jobj.add("success",
                                            gson.toJsonTree(timecard));
                                    return jobj.toString();
                                }

                            } else {
                                message.addProperty("error", "cannot be " +
                                        "weekend");
                                return message.toString();
                            }

                        } else {
                            message.addProperty("error", "start time must be " +
                                    "at least one" +
                                    " " +
                                    "hour ahead of end time");
                            return message.toString();
                        }
                    } else {
                        message.addProperty("error", "start time must be " +
                                "on same day as end time");
                        return message.toString();
                    }

                    }
                }

        } catch (Exception e) {
            message.addProperty("error", e.getMessage());
            return message.toString();
        }
    }


    @Path("/timecard")
    @DELETE
    @Produces("application/json")
    @Consumes("text/plain")
    public String deleteTimecard(@QueryParam("timecard_id") Integer timecard_id) {

        DataLayer dl;
        JsonObject message = new JsonObject();
        gson = new GsonBuilder().setDateFormat("yyyy-MM-dd " +
                "HH:mm:ss").create();
        try {
            dl = new DataLayer("development");
            Timecard timecard = dl.getTimecard(timecard_id);
            //check if timecard exists and delete
            if (timecard == null){
                JsonObject json = new JsonObject();
                json.addProperty("error", "Timecard doesnt exist");
                return json.toString();
            } else {
                int id = dl.deleteTimecard(timecard_id);
                if (id >= 1) {
                    JsonObject json = new JsonObject();
                    json.addProperty("success", "Timecard " + timecard_id + " " +
                            "deleted");
                    return json.toString();
                } else {
                    JsonObject json = new JsonObject();
                    json.addProperty("error", "Timecard not deleted");
                    return json.toString();
                }
            }
        } catch (Exception e) {
            message.addProperty("error", e.getMessage());
            return message.toString();
        }
    }
}


