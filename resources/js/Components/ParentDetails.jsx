import CompRowAndBox from "@/Shared/CompRowAndBox";
import Display from "@/Shared/Display";
import SmartFooterButton from "./SmartFooterButton";

export default ({parent,children}) => {
    return (
    <CompRowAndBox
        header={
            <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                Parent / {parent.name}
                {parent.blacklist == 'true' ? ' / BLACK LISTED' : ''}
            </h2>}
        
    >
        <Display
            content={parent}
            show="nik,name,email,phone,birth_date,blacklist,address,note,emergency_name,emergency_phone,bank_account_name,virtual_account_name,"
        >
        </Display>

        {children && 
            <div className="child-component">
                {children}
            </div>
        }
    </CompRowAndBox>)
}