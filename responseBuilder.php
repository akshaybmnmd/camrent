<?php
function responseBuilder($query)
{
    $response = array();

    while ($row = mysqli_fetch_assoc($query)) {
        $response[] = $row;
    }
    return json_encode($response);
}

// function buildDepartmentResponse($query)
// {
//     $response = array();
//     $department = array();

//     while ($row = mysqli_fetch_assoc($query)) {
//         $departmentId = $row['department_id'];
//         $subdepartmentId = $row['subdepartment_id'];
//         $name = $row['name'];

//         if ($departmentId != '' && $subdepartmentId == '' && $department == []) {
//             $department = array('department_id' => $departmentId, 'name' => $name, 'subdepartment' => []);
//         }

//         if ($subdepartmentId != '' && $departmentId != '') {
//             $subdepartment = array('id' => $subdepartmentId, 'name' => $name);
//             array_push($department['subdepartment'], $subdepartment);
//         }

//         if ($departmentId != $department['department_id']) {
//             array_push($response, $department);
//             $department = array('department_id' => $departmentId, 'name' => $name, 'subdepartment' => []);
//         }
//     }
//     array_push($response, $department);
//     return json_encode($response);
// }

// function buildFacilityDetailsByPhone($query)
// {
//     $response = array();
//     $users = array();
//     $facilityId = '';

//     while ($row = mysqli_fetch_assoc($query)) {

//         if (empty($facilityId)) {
//             $facilityId = $row['facility_id'];
//             $name = $row['name'];
//             $facilityPhone = $row['phone'];
//             $twilioPhone = $row['twilio_phone'];
//             $twilioPhoneResidentFamily = $row['twilio_phone_resident_family'];
//             $employeeChat = $row['employee_chat'];
//             $residentChat = $row['resident_chat'];

//             $facilityDetails = array(
//                 'facility_id' => $facilityId, 'name' => $name, 'phone' => $facilityPhone, 'twilio_phone' => $twilioPhone,
//                 'twilio_phone_resident_family' =>  $twilioPhoneResidentFamily,
//                 'employee_chat' => $employeeChat, 'resident_chat' => $residentChat, 'users' => $users
//             );
//         }

//         $userId = $row['user_id'];
//         $username = $row['username'];
//         $userLevel = $row['user_level'];
//         $userFullname = $row['user_fullname'];
//         $email = $row['email'];
//         $phone = $row['phone'];


//         $user = array(
//             'id' => $userId, 'username' => $username, 'user_level' => $userLevel,
//             'user_fullname' => $userFullname, 'email' => $email, 'phone' => $phone
//         );
//         array_push($users, $user);
//     }
//     $facilityDetails['users'] = $users;
//     return json_encode($facilityDetails);
// }

// function buildUpcomingSchedule($query, $dateStart)
// {
//     $response = array();
//     $currentWeek = array();
//     $nextWeek = array();

//     while ($row = mysqli_fetch_assoc($query)) {
//         if ($row['date'] < date('Y-m-d', strtotime($dateStart . ' + 6 days'))) {
//             $currentWeek[] = $row;
//         } else {
//             $nextWeek[] = $row;
//         }
//     }

//     array_push($response, $currentWeek, $nextWeek);
//     return json_encode($response);
// }
