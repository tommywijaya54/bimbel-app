import { FieldUtil } from "../../Util/Field.util";

export default ({field,data,rawdata}) => {
    let FieldOb = {
        ...field,
        value:data
    }

    if(field.model){
        FieldOb.model_value = rawdata[field.model];
    }

    return FieldUtil.getProcessedContent(FieldOb);
}