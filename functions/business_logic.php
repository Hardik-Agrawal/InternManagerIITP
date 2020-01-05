<?php
    function getUserDetails($email) {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = query($sql);
        confirm($result);
        $row = fetch_array($result);
        return $row;
    }
    function getStudentDetails($email){
        $query = "SELECT * FROM students WHERE email = '$email'";
        $result = query($query);
        confirm($result);
        $row  = fetch_array($result);
        return $row;
    }
    function getProfProjects($email) {
        $sql = "SELECT * FROM projects WHERE prof_email = '$email'";
        $result = query($sql);
        confirm($result);
        $data=array();
        while($row = mysqli_fetch_array($result)){
            $data[]=$row;
        }
        mysqli_free_result($result);
        return $data;
    }
    function addImagetoDatabase($name,$email){
        $query = "UPDATE students SET imageName = '$name' WHERE email = '$email'";
        $result = query($query);
        confirm($result);
    }
    function addPdfToDatabase($name,$email){
        $query = "UPDATE students SET resumeName = '$name' WHERE email = '$email'";
        $result = query($query);
        confirm($result);
    }
?>