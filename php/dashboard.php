<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$roles = ['Frontend Developer', 'Backend Developer', 'Full Stack Developer', 'DevOps Engineer', 'AI Engineer', 'UI/UX Designer'];
$skills = ['HTML', 'CSS', 'JavaScript', 'React', 'Node.js', 'Python', 'MongoDB', 'MySQL', 'DevOps', 'UI Design'];
$activities = [
    'Completed JavaScript assessment',
    'Updated profile skills',
    'Applied for Frontend Developer',
    'Viewed DevOps role',
    'Completed React project'
];
$messages = [
    'Keep building. Every project improves your skills.',
    'Consistency in coding beats talent.',
    'Ship code. Learn fast.'
];

$recommendedRole = $roles[array_rand($roles)];
shuffle($skills);
$topSkills = array_slice($skills, 0, 3);
$skillScore = rand(60, 95);
shuffle($activities);
$recentActivity = array_slice($activities, 0, 3);
$message = $messages[array_rand($messages)];

$dashboardData = [
    'recommendedRole' => $recommendedRole,
    'skills' => $topSkills,
    'skillScore' => $skillScore,
    'recentActivity' => $recentActivity,
    'message' => $message
];

echo json_encode($dashboardData);
?>