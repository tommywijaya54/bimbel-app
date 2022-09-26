import CompRowAndBox from "@/Shared/CompRowAndBox";
import Display from "@/Shared/Display";

export default ({student,children}) => {
    return (
    <CompRowAndBox
        header={
            <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                {student.name}
                <span className="info">Student Information</span>
            </h2>}
    >
        <Display
            content={student}
            fields="name,birth_date,type,grade,email,phone,address,,join_date,exit_date,health_condition,exit_reason,note"
        >
        </Display>

        {children && 
            <div className="child-component">
                {children}
            </div>
        }
    </CompRowAndBox>)
}