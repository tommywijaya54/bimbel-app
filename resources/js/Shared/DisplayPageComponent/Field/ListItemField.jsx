import { Field } from "./util_field";

export default ({field,data,rawdata}) => {
    let FieldOb = {
        ...field,
        value:data
    }

    if(field.model){
        FieldOb.model_value = rawdata[field.model];
    }

    return Field.displayElement(FieldOb);
}