import CompRowAndBox from "@/Shared/CompRowAndBox";
import Display from "@/Shared/Display";

export default ({student,children}) => {
    return (
    <CompRowAndBox
        header={
            <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                Student / {student.name}
            </h2>}
    >
        <Display
            content={student}
            show="name,email,phone,address,birth_date,note,join_date,grade,exit_date,exit_reason,health_condition,type"
        >
        </Display>

        {children && 
            <div className="child-component">
                {children}
            </div>
        }
    </CompRowAndBox>)
}