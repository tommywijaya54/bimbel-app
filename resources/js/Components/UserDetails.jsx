import CompRowAndBox from "@/Shared/CompRowAndBox";
import Display from "@/Shared/Display";
import SmartFooterButton from "./SmartFooterButton";

export default ({user,children}) => {
    return (
    <CompRowAndBox
        header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">User / {user.name}</h2>}
    >
        <Display
            content={user}
            show="name,email,type"
        >
        </Display>

        {children && 
            <div className="child-component">
                {children}
            </div>
        }
    </CompRowAndBox>)
}