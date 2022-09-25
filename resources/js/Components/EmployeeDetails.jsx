import CompRowAndBox from "@/Shared/CompRowAndBox";
import Display from "@/Shared/Display";

export default ({employee,children}) => {
    return (
    <CompRowAndBox
        header={
            <h2 className="font-semibold text-xl text-gray-800 leading-tight">
               {employee.name}
               <span className="info">Employment Information</span>
            </h2>}
    >
        <Display
            content={employee}
            show="nik,,name,email,phone,,address,note,join_date,exit_date,_,emergency_name,emergency_phone,branches_id"
        >
        </Display>

        {children && 
            <div className="child-component">
                {children}
            </div>
        }
    </CompRowAndBox>)
}










