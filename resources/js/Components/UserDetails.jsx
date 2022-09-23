import CompRowAndBox from "@/Shared/CompRowAndBox";
import Display from "@/Shared/Display";
export default ({user}) => {
    return (
    <CompRowAndBox
        header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">User details: {user.name}</h2>}
    >
        <Display
            content={user}
            show="name,email,type"
        >
        </Display>
    </CompRowAndBox>)
}