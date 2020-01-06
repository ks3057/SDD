var datalayer = require("companydata");
var Department = require("companydata").Department;
var Employee = require("companydata").Employee;
var Timecard = require("companydata").Timecard;
var date_fns = require('date-fns');

module.exports = class Validation {
    getAllDepartment(){
        const response = {
            yo : "lo"
        }
        return response;
    }

    insertDepartment(){
        const response = {
            success : "inserted"
        }
        return response;
    }
}