package Timecard;

import companydata.*;

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.List;
import java.util.Calendar;
import java.sql.Timestamp;

public class TestDataLayer {

   public static void main(String args[]) {
      DataLayer dl = null;
 //include company in employee no because unique     
      try {
         //use "development" for not running under Glassfish
         //use "production" for running under Glassfish
         dl = new DataLayer("development");  
//         System.out.println( "in try" );
      
         //Department
         
         // REMEMBER: USE YOUR ID FOR COMPANY IN PLACE OF bdfvks
//         Department dept = new Department("ks3057","CS","100","rochester");
//         dept = dl.insertDepartment(dept);
//         if (dept.getId() > 0) {
//            System.out.println("inserted id: "+ dept.getId());
//         } else {
//            System.out.println("Not inserted");
//         }
         
         // REMEMBER: USE YOUR ID FOR COMPANY IN PLACE OF bdfvks
//         List<Department> departments = dl.getAllDepartment("ks3057");
//         System.out.println( "length: " + departments.size() );
//
//         for(Department d : departments ){
//            System.out.println(d.getId());
//            System.out.println(d.getCompany());
//            System.out.println(d.getDeptName());
//            System.out.println(d.getDeptNo());
//            System.out.println(d.getLocation());
//            System.out.println("--------\n\n");
//         }

         // REMEMBER: USE YOUR ID FOR COMPANY IN PLACE OF bdfvks and department id must exist
//         Department department = dl.getDepartment("ks3057",15); ////////
//         System.out.println(department);
////
////         //Print the department details
//         System.out.println("\n\nCurrent Department:");
//         System.out.println(department.getId());
//         System.out.println(department.getCompany());
//         System.out.println(department.getDeptName());
//         System.out.println(department.getDeptNo());
//         System.out.println(department.getLocation());
//
//         department.setDeptName("Computing");
//         department = dl.updateDepartment(department);
//
//         //Print the updated department details
//         System.out.println("\n\nUpdated Department:");
//         System.out.println(department.getId());
//         System.out.println(department.getCompany());
//         System.out.println(department.getDeptName());
//         System.out.println(department.getDeptNo());
//         System.out.println(department.getLocation());
//
        // REMEMBER: USE YOUR ID FOR COMPANY IN PLACE OF bdfvks and department id must exist
        //    and all employees should be deleted first
//        int deleted = dl.deleteDepartment("bdfvks",5);
//         if (deleted >= 1) {
//            System.out.println("\nDepartment deleted");
//         } else {
//            System.out.println("\nDepartment not deleted");
//         }
 
         //Employee
         
        // REMEMBER: USE AN ID FOR your department in place of '4' and manager id must exist as an employee
         Employee emp = new Employee("French","23",
                 new java.sql.Date(new java.util.Date().getTime()),"Developer",80000.00, 727, 1);
         emp = dl.insertEmployee(emp);
//
//                  if (emp.getId() > 0) {
//            System.out.println("inserted id: "+ emp.getId());
//         } else {
//            System.out.println("Not inserted");
//         }


         // REMEMBER: USE YOUR ID FOR COMPANY IN PLACE OF bdfvks 
//         List<Employee> employees = dl.getAllEmployee("ks3057");
////
//         for(Employee empl : employees ){
//            System.out.println(empl.getId());
//            System.out.println(empl.getEmpName());
//            System.out.println(empl.getEmpNo());
//            System.out.println(empl.getHireDate());
//            System.out.println(empl.getJob());
//            System.out.println(empl.getSalary());
//            System.out.println(empl.getDeptId());
//            System.out.println(empl.getMngId());
//            System.out.println("--------\n\n");
//         }

         
         //employee number must exist
//         Employee employee = dl.getEmployee(494);
//
////         Print the employee details
//         System.out.println(employee.getId());
//         System.out.println(employee.getEmpName());
//         System.out.println(employee.getEmpNo());
//         System.out.println(employee.getHireDate());
//         System.out.println(employee.getJob());
//         System.out.println(employee.getSalary());
//         System.out.println(employee.getDeptId());
//         System.out.println(employee.getMngId());
//         System.out.println("--------\n\n");
//
//         Date hire_date =
//                 new SimpleDateFormat("yyyy-MM-dd").parse("2019-04-16");
//         java.sql.Date sqlDate = new java.sql.Date(hire_date.getTime());
//
//         employee.setSalary(60000.00);
//         employee.setHireDate(sqlDate);
//         employee = dl.updateEmployee(employee);
//
//         employee = dl.getEmployee(472);
//
////         Print the employee details
//         System.out.println(employee.getId());
//         System.out.println(employee.getEmpName());
//         System.out.println(employee.getEmpNo());
//         System.out.println(employee.getHireDate());
//         System.out.println(employee.getJob());
//         System.out.println(employee.getSalary());
//         System.out.println(employee.getDeptId());
//         System.out.println(employee.getMngId());
//         System.out.println("--------\n\n");
//
//         //Print the updated employee details
//         System.out.println("\n\nUpdated Employee:");
//         System.out.println(employee.getId());
//         System.out.println(employee.getEmpName());
//         System.out.println(employee.getEmpNo());
//         System.out.println(employee.getHireDate());
//         System.out.println(employee.getJob());
//         System.out.println(employee.getSalary());
//         System.out.println(employee.getDeptId());
//         System.out.println(employee.getMngId());
//         System.out.println("--------\n\n");

        // REMEMBER: if a manager, all employees that they manage must be deleted or assigned
        //    to another manager        
//         int deletedEmp = dl.deleteEmployee(17);
//         if (deletedEmp >= 1) {
//            System.out.println("\nEmployee deleted");
//         } else {
//            System.out.println("\nEmployee not deleted");
//         }
         
         //Timecard
         
         Timestamp startTime = new Timestamp(new Date().getTime());
         Calendar cal = Calendar.getInstance();
         cal.setTimeInMillis(startTime.getTime());
         cal.add(Calendar.HOUR, 5);
//
////         //REMBEMBER: employee must exist
//         Timecard tc = new Timecard(startTime,
//                  new Timestamp(cal.getTime().getTime()),468);
//         tc = dl.insertTimecard(tc);
//         if (tc.getId() > 0) {
//            System.out.println("inserted id: "+ tc.getId());
//         } else {
//            System.out.println("Not inserted");
//         }
//
//
//         List<Timecard> timecards = dl.getAllTimecard(468);
////
//         for(Timecard tcard : timecards ){
//            System.out.println(tcard.getId());
//            System.out.println(tcard.getStartTime());
//            System.out.println(tcard.getEndTime());
//            System.out.println(tcard.getEmpId());
//            System.out.println("--------\n\n");
//         }

//         Timecard timecard = dl.getTimecard(339);
//         System.out.println("\n\nCurrent Timecard:");
//         System.out.println(timecard.getId());
//         System.out.println(timecard.getStartTime());
//         System.out.println(timecard.getEndTime());
//         System.out.println(timecard.getEmpId());
//         System.out.println("--------\n\n");
//
//         cal.setTimeInMillis(timecard.getStartTime().getTime());
//         cal.add(Calendar.HOUR, 8);
//         timecard.setEndTime(new Timestamp(cal.getTime().getTime()));
//         timecard.setEmpId(552);
//         timecard = dl.updateTimecard(timecard);
////
//         System.out.println("\n\nUpdated Timecard:");
//         System.out.println(timecard.getId());
//         System.out.println(timecard.getStartTime());
//         System.out.println(timecard.getEndTime());
//         System.out.println(timecard.getEmpId());
//         System.out.println("--------\n\n");
//
//
//         Timecard timeCard = dl.getTimecard(339);
//         System.out.println("\n\nCurrent Timecard:");
//         System.out.println(timeCard.getId());
//         System.out.println(timeCard.getStartTime());
//         System.out.println(timeCard.getEndTime());
//         System.out.println(timeCard.getEmpId());
//         System.out.println("--------\n\n");
//
////         //REMEMBER: timecard id must exist
//         int deletedTC = dl.deleteTimecard(1);
//         if (deletedTC >= 1) {
//            System.out.println("\nTimecard deleted");
//         } else {
//            System.out.println("\nTimecard not deleted");
//         }
//

         //delete all for a company
         
 //        int numRowsDeleted = dl.deleteCompany("bdfvks");
 //        System.out.println("Number of rows deleted: "+numRowsDeleted);

      } catch (Exception e) {
         System.out.println("Problem with query: "+e.getMessage());
      } finally {
         dl.close();
      }
      
   }
   
}