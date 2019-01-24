select subjects.`name`, student_class_tests.created_at, 
(`point` / 
(select sum(`point`) from questions where questions.class_test_id = class_tests.id)) as total
from student_class_tests
join class_tests on class_tests.id = student_class_tests.class_test_id
join class_teachings on class_teachings.id = class_tests.class_teaching_id
join subjects on subjects.id = class_teachings.subject_id
where student_class_tests.student_id = 10