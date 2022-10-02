import { getAlias } from "@/util";
import { FieldUtil } from "../util_form";
import { Field } from "./util_field";


export default ({fields, form}) => {
    if(fields){
        return fields.map((field,keyId) => {
            return FieldUtil.check_and_getCommonField(field,keyId) || 
                        (<div key={keyId} className="form-component pr-6 pb-8 w-full lg:w-1/2">
                            <label className="form-label">{field.label}:</label> 
                            <div className="form-input">
                                {Field.displayElement(field)}
                            </div>
                        </div>);
        })
    }
}