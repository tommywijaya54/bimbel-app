import CompRowAndBox from "@/Shared/CompRowAndBox";
import Display from "@/Shared/Display";
import SmartFooterButton from "./SmartFooterButton";

export default ({parent,children}) => {
    return (
    <CompRowAndBox
        header={
            <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                {parent.blacklist == 'true' ? 
                <span className="black-listed">Black Listed</span> : ''}
                {parent.name}
                <span className="info">Parent Information</span>
            </h2>}
        
    >
        <Display
            content={parent}
            show="nik,blacklist,name,email,phone,birth_date,address,note,emergency_name,emergency_phone,bank_account_name,virtual_account_name,"
        >
        </Display>

        {children && 
            <div className="child-component">
                {children}
            </div>
        }
    </CompRowAndBox>)
}