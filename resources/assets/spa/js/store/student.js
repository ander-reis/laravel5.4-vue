import classInformation from './student/class_information';
import classTeaching from './student/class_teaching';
import classTest from './student/class_test';

const module = {
    namespaced: true,
    modules: {
        classInformation,
        classTeaching,
        classTest
    }
};

export default module;