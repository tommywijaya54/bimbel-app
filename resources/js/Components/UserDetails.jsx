import CompRowAndBox from "@/Shared/CompRowAndBox";
import Display from "@/Shared/Display";
import SmartFooterButton from "./SmartFooterButton";

export default ({user,children}) => {
    return (
    <CompRowAndBox
        header={
            <h2 className="font-semibold text-xl text-gray-800 leading-tight">{user.id}. {user.name} 
                <span className="info">User Details</span>
            </h2>}
        footer={
            <SmartFooterButton componentFor='User' obj={user}></SmartFooterButton>
        }
    >
        <Display
            content={user}
            fields="name,email,type,status"
        >
        </Display>

        {children && 
            <div className="child-component">
                {children}
            </div>
        }
    </CompRowAndBox>)
}