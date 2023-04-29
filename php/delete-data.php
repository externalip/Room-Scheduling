<?php
require_once('./require/DBConfig.php');
if (isset($_GET['delete']) && ($_SERVER['REQUEST_METHOD'] == 'GET')) {
    //Delete Program
    if ($_GET['delete'] == 'program') {
        $program_id = filter_input(INPUT_GET, 'program_id', FILTER_SANITIZE_NUMBER_INT);
        if (empty($program_id)) {
            $status = "empty";
            header("Location: ../program-manage.php?status=$status&message=Please Fill Up All Fields");
            exit();
        }
        try {
            DB::delete('program', "program_id=%s", $program_id);
            $status = "success";

            header("Location: ../program-manage.php?status=$status&message=Successfully Deleted");
        } catch (Exception $e) {
            $status = "failed";
            header("Location: ../program-manage.php?status=$status&message=Failed to Delete");
        }
    }
    //Delete Course
    if ($_GET['delete'] == 'course') {
        $course_id = filter_input(INPUT_GET, 'course_id', FILTER_SANITIZE_NUMBER_INT);
        if (empty($course_id)) {
            $status = "empty";
            header("Location: ../course-manage.php?status=$status&message=Empty");
            exit();
        }
        try {
            DB::delete('course', "course_id=%s", $course_id);
            $status = "success";
            header("Location: ../course-manage.php?status=$status&message=Successfully Deleted");
        } catch (Exception $e) {
            $status = "error";
            header("Location: ../course-manage.php?status=$status&message=Failed to Delete Course");
        }
    }
    //Delete Subject
    if ($_GET['delete'] == 'subject') {
        $subject_id = filter_input(INPUT_GET, 'subject_id', FILTER_SANITIZE_NUMBER_INT);
        if (empty($subject_id)) {
            $status = "empty";
            header("Location: ../subject-manage.php?status=$status&message=Empty");
            exit();
        }
        try {
            DB::delete('subject', "subject_id=%s", $subject_id);
            $status = "success";
            header("Location: ../subject-manage.php?status=$status&message=Successfully Deleted");
        } catch (Exception $e) {
            $status = "failed";
            header("Location: ../subject-manage.php?status=$status&message=Failed to Delete Subject");
        }
    }
    //Delete Room
    if ($_GET['delete'] == 'room') {
        $room_id = filter_input(INPUT_GET, 'room_id', FILTER_SANITIZE_NUMBER_INT);
        if (empty($room_id)) {
            $status = "empty";
            header("Location: ../room-manage.php?status=$status&message=Empty");
            exit();
        }
        try {
            // Check if room has associated records in other tables
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM `scheduling table` WHERE room_id = :room_id');
            $stmt->bindValue(':room_id', $room_id, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            if ($count > 0) {
                $status = "error";
                $message = "Cannot delete room with associated reservations";
            } else {
                // Delete the room
                $stmt = $pdo->prepare('DELETE FROM room WHERE room_id = :room_id');
                $stmt->bindValue(':room_id', $room_id, PDO::PARAM_INT);
                $stmt->execute();
                $status = "success";
                $message = "Successfully deleted room";
            }
            header("Location: ../room-manage.php?status=$status&message=$message");
        } catch (PDOException $e) {
            $status = "error";
            $error = $e->getMessage();
            echo $error;
            header("Location: ../room-manage.php?status=$status&message=Failed to Delete Room");
        }
    }
    //Delete Professor
    if ($_GET['delete'] == 'professor') {
        $professor_id = filter_input(INPUT_GET, 'professor_id', FILTER_SANITIZE_NUMBER_INT);
        if (empty($professor_id)) {
            $status = "empty";
            header("Location: ../professor-manage.php?status=$status&message=Empty");
            exit();
        }
        try {
            DB::delete('professor', "professor_id=%s", $professor_id);
            $status = "success";
            header("Location: ../professor-manage.php?status=$status&message=Successfully Deleted");
        } catch (Exception $e) {
            $status = "error";
            header("Location: ../professor-manage.php?status=$status&message=Failed to Delete Professor");
        }
    }
    //Delete Schedule
    if ($_GET['delete'] == 'schedule') {
        $schedule = filter_input(INPUT_GET, 'schedule_id', FILTER_SANITIZE_NUMBER_INT);
        if (empty($schedule)) {
            $status = "empty";
            header("Location: ../schedule-manage.php?status=$status&message=Empty");
            exit();
        }
        try {
            DB::delete('scheduling table', "schedule_id=%s", $schedule);
            $status = "success";
            header("Location: ../scheduling.php?status=$status&message=Successfully Deleted");
        } catch (Exception $e) {
            $status = "error";
            header("Location: ../scheduling.php?status=$status&message=Failed to Delete Schedule");
        }
    }
}
