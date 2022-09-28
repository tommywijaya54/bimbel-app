import { DisplayFields } from "@/util";
import DisplayElement from "./DisplayElement";

export default ({header, content, fields, children}) => {
    return (
        <div className="display-component flex flex-wrap ">
            <DisplayElement fields={fields} content={content}></DisplayElement>
            {children}
        </div>
    );
}