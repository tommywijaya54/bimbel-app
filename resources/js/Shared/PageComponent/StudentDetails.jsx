import Component from "../DisplayPageComponent/Form/Component";
import Display from "../DisplayPageComponent/Element/Display";
import FormFooter from "../DisplayPageComponent/Form/Footer";
import { CurrentUser } from "@/util";

export default ({student,children}) => {
    return (
        <>
            <Component
                header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    <a href={'/student/'+student.id} className="link">{student.name}</a>
                    <span className="info">Student Information</span>
                </h2>}
                className=" student-information"
                footer={
                    <FormFooter link={{'permission':'edit-student','id':student.id}}></FormFooter>
                }
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
            </Component>  
        </>
    )
}

/*
 <CompRowAndBox
        header={
            <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                <a href={'/student/'+student.id} className="link">{student.name}</a>
                <span className="info">Student Information</span>
            </h2>}
        className=" student-information"
    >
        
    </CompRowAndBox>
*/