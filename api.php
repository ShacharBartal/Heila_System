<?php

$host = 'localhost';
$db = 'employees';
define(USERNAME, "root");
define(PASSWORD, "root");
define(DSN, "mysql:host=$host;dbname=$db" );


    function connection($sql){
        try {
            $connection = new PDO(DSN, USERNAME, PASSWORD);
            $statement = $connection->prepare($sql);
            $statement->execute();
            return $statement;
        }
        catch (PDOException $err){
            $err->getMessage();
        }

    }

    function GetEmployeeList(){

        $statement = connection("SELECT * from employees");
        $employeesArray = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (!$employeesArray){
            die("There is no employees yet");
        }

        return json_decode(json_encode($employeesArray), true);

    }


    function GetEmployeeRoles($id){

        if (!$id){
            die("There is no id in input");
        }

        $statement = connection("SELECT ER.Roleid as 'RoleId', R.description as 'description'
                                          FROM Roles as R INNER JOIN EmployeeRoles as ER
                                          ON ER.EmployeeId = $id AND R.ID = ER.RoleId AND ER.enabled = 'yes'");

        $employeeRoles = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (!$employeeRoles){
            die("There is no employee with that values");
        }

        return json_decode(json_encode($employeeRoles), true);



    }

    function ClockIn($form){

        if (!$form['employeeId'] || !form['roleId']){
            die("No input");
        }

        $employeeId = $form['employeeId'];
        $roleId = $form['roleId'];

        $newVAlues =  connection("INSERT into Attendance(employeeId, roleId)
                                        VALUES ($employeeId, $roleId)");

        // Action time will be inserted automaticly by the table configuration like: 'actionTime timestamp'
    }

?>